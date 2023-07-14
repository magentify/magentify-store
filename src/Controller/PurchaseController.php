<?php

namespace App\Controller;

use App\Database\ConnectionInterface;
use App\EmailSender\PurchaseCompletedEmailSenderInterface;
use App\Factory\StripeClientFactoryInterface;
use App\ValueObject\ProductInterface;
use Stripe\Exception\SignatureVerificationException;
use Stripe\StripeClient;
use Stripe\Webhook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UnexpectedValueException;
use Webmozart\Assert\Assert;

class PurchaseController extends AbstractController
{
    public function __construct(
        private readonly ConnectionInterface $connection,
        private readonly StripeClientFactoryInterface $stripeClientFactory,
        private readonly PurchaseCompletedEmailSenderInterface $purchaseCompletedEmailSender,
        private readonly string $stripeEndpointSecret
    ) {
    }

    #[Route(path: '/confirm-purchase', name: 'app_confirm_purchase')]
    public function confirm(Request $request): Response
    {
        $country = null;
        $payload = $request->getContent();
        $sigHeader = $request->headers->get('Stripe-Signature', '');

        try {
            $paymentIntentEvent = Webhook::constructEvent($payload, $sigHeader, $this->stripeEndpointSecret);
        } catch (UnexpectedValueException|SignatureVerificationException) {
            throw new BadRequestException();
        }

        if ($paymentIntentEvent->type !== 'payment_intent.succeeded') {
            throw new BadRequestException(sprintf('Received unknown event type %s', $paymentIntentEvent->type));
        }

        $stripe = $this->stripeClientFactory->create();
        Assert::isInstanceOf($stripe, StripeClient::class);
        $paymentIntentEventId = $paymentIntentEvent->id;
        $sku = null;
        $email = null;
        foreach ($stripe->events->all([
            'type' => 'checkout.session.completed',
        ])->autoPagingIterator() as $event) {
            if ($event->data->object->payment_intent === $paymentIntentEventId) {
                $sku = $event->data->object->metadata->sku;
                $email = $event->data->object->customer_details->email;
                $country = $event->data->object->customer_details->address->country;

                break;
            }
        }
        if (! is_string($sku) || ! is_string($email) || ! is_string($country)) {
            throw $this->createNotFoundException(sprintf('No payment info found for paymentIntent with id %s', $paymentIntentEventId));
        }
        $locale = $country === 'IT' ? 'it' : 'en';
        $product = $this->connection->getProductBySku($sku, $locale);
        if (! $product instanceof ProductInterface) {
            throw $this->createNotFoundException();
        }
        $this->purchaseCompletedEmailSender->send($email, $product, $locale);

        return $this->json('purchase confirmed');
    }

    #[Route(path: '/checkout-complete', name: 'app_checkout_complete')]
    public function checkoutComplete(Request $request): Response
    {
        $stripe = $this->stripeClientFactory->create();
        Assert::isInstanceOf($stripe, StripeClient::class);
        $checkoutSessionId = $request->query->get('checkout-session-id');
        if (! is_string($checkoutSessionId)) {
            throw new BadRequestException();
        }
        $email = $stripe->checkout->sessions->retrieve($checkoutSessionId)->customer_details->offsetGet('email');
        if (! is_string($email)) {
            throw new BadRequestException();
        }
        $request->getSession()->set('email', $email);

        return $this->redirectToRoute('app_thank_you_page');
    }

    #[Route(path: '/{_locale}/thank-you', name: 'app_thank_you_page')]
    public function thankYou(Request $request): Response
    {
        $email = $request->getSession()->get('email');
        if (! is_string($email)) {
            throw new BadRequestException();
        }

        return $this->render('/ThankYou/index.html.twig', [
            'email' => $email,
        ]);
    }
}
