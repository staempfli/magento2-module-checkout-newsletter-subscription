<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\CheckoutNewsletterSubscription\Test\Unit\Observer;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\CheckoutNewsletterSubscription\Observer\NewsletterSubscription;

final class NewsletterSubscriptionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var NewsletterSubscription
     */
    private $newsletterSubscription;
    /**
     * @var \Magento\Framework\Event\Observer
     */
    private $observer;

    public function setUp()
    {
        $quote = $this->getMockBuilder(\Magento\Quote\Model\Quote::class)
            ->setMethods(['setData','getData','getCustomerEmail'])
            ->disableOriginalConstructor()
            ->getMock();
        $quote->expects($this->any())->method('setData')->willReturn(null);
        $quote->expects($this->any())->method('getCustomerEmail')->willReturn('test@test.com');
        $quote->expects($this->any())->method('getData')->willReturn('1');

        $eventMock = $this->createPartialMock(\Magento\Framework\Event::class, ['getQuote']);
        $eventMock->expects($this->once())->method('getQuote')->willReturn($quote);

        $this->observer = $this->getMockBuilder(\Magento\Framework\Event\Observer::class)
            ->setMethods(['getEvent'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->observer->expects($this->once())->method('getEvent')->willReturn($eventMock);

        $subscriber = $this->getMockBuilder(\Magento\Newsletter\Model\Subscriber::class)
            ->disableOriginalConstructor()
            ->getMock();
        $subscriber->expects($this->once())->method('subscribe')->willThrowException(new \Exception());

        $subscriberFactory = $this->getMockBuilder(\Magento\Newsletter\Model\SubscriberFactory::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();
        $subscriberFactory->expects($this->once())->method('create')->willReturn($subscriber);

        $objectManager = new ObjectManager($this);
        $this->newsletterSubscription = $objectManager->getObject(
            NewsletterSubscription::class,
            [
                'subscriberFactory' => $subscriberFactory
            ]
        );
    }

    public function testExecute()
    {
        $result = $this->newsletterSubscription->execute($this->observer);
    }
}
