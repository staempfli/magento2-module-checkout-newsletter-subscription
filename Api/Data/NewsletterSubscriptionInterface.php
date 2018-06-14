<?php

namespace Staempfli\CheckoutNewsletterSubscription\Api\Data;

interface NewsletterSubscriptionInterface
{
    /**
     * @param string $subscribe
     * @return null
     */
    public function setSubscribe($subscribe);

    /**
     * @return string
     */
    public function getSubscribe();
}
