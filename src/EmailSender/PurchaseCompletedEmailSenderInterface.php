<?php

namespace App\EmailSender;

use App\ValueObject\ProductInterface;

interface PurchaseCompletedEmailSenderInterface
{
    public function send(string $receiver, ProductInterface $product, string $locale): void;
}
