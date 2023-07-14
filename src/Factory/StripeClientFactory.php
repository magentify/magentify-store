<?php

namespace App\Factory;

use App\Factory\Exception\StripeApiKeyNotProvided;
use Stripe\StripeClient;
use Stripe\StripeClientInterface;

final readonly class StripeClientFactory implements StripeClientFactoryInterface
{
    public function __construct(
        private ?string $stripeApiKey
    ) {
    }

    /**
     * @throws StripeApiKeyNotProvided
     */
    public function create(): StripeClientInterface
    {
        if ($this->stripeApiKey === null) {
            throw new StripeApiKeyNotProvided();
        }

        return new StripeClient($this->stripeApiKey);
    }
}
