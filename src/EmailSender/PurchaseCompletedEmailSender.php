<?php

namespace App\EmailSender;

use App\ValueObject\ProductInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class PurchaseCompletedEmailSender implements PurchaseCompletedEmailSenderInterface
{
    public function __construct(
        private MailerInterface $mailer,
        private string $infoEmailAddress,
        private TranslatorInterface $translator
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(string $receiver, ProductInterface $product, string $locale): void
    {
        $email = (new TemplatedEmail())
            ->sender($this->infoEmailAddress)
            ->to($receiver)
            ->bcc($this->infoEmailAddress)
            ->subject($this->translator->trans('app.purchase_email.subject', [], null, $locale))
            ->htmlTemplate('Emails/purchaseCompleted.html.twig')
            ->context([
                'product' => $product,
                '_locale' => $locale,
            ]);

        $this->mailer->send($email);
    }
}
