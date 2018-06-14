<?php

namespace Staempfli\CheckoutNewsletterSubscription\Api;

use Staempfli\CheckoutNewsletterSubscription\Api\Data\NewsletterSubscriptionInterface;

/**
 * Interface to set the newsletter subscription for logged in users
 * @api
 */
interface NewsletterSubscriptionManagementInterface
{
    /**
     * @param string $cartId
     * @param NewsletterSubscriptionInterface $newsletterSubscription
     * @return void
     */
    public function subscribe($cartId, NewsletterSubscriptionInterface $newsletterSubscription);
}
