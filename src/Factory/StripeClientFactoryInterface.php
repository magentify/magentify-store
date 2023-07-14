<?php

namespace App\Factory;

use Stripe\StripeClientInterface;

interface StripeClientFactoryInterface
{
    public function create(): StripeClientInterface;
}
