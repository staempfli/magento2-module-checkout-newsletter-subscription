<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\CheckoutNewsletterSubscription\Test\Unit\Model\Data;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\CheckoutNewsletterSubscription\Model\Data\NewsletterSubscription;

final class NewsletterSubscriptionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var NewsletterSubscription
     */
    private $newsletterSubscription;

    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->newsletterSubscription = $objectManager->getObject(NewsletterSubscription::class);
    }

    public function testSetSubscribe()
    {
        $result = $this->newsletterSubscription->setSubscribe(1);
        $this->assertInstanceOf(\Staempfli\CheckoutNewsletterSubscription\Model\Data\NewsletterSubscription::class, $result);
    }

    public function testGetSubscribe()
    {
        $result = $this->newsletterSubscription->getSubscribe();
        $this->assertSame($result, null);
    }
}
