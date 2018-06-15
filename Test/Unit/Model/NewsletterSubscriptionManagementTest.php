<?php
declare(strict_types=1);
/**
 * Copyright © 2018 Stämpfli AG. All rights reserved.
 * @author marcel.hauri@staempfli.com
 */

namespace Staempfli\CheckoutNewsletterSubscription\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Staempfli\CheckoutNewsletterSubscription\Model\NewsletterSubscriptionManagement;
use Staempfli\CheckoutNewsletterSubscription\Model\Data\NewsletterSubscription;

final class NewsletterSubscriptionManagementTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var NewsletterSubscriptionManagement
     */
    private $newsletterSubscriptionManagement;
    /**
     * @var NewsletterSubscription
     */
    private $newsletterSubscription;
    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    private $cartRepository;
    /**
     * @var \Magento\Quote\Model\QuoteIdMaskFactory
     */
    private $quoteIdMaskFactory;
    /**
     * @var
     */
    private $quote;

    public function setUp()
    {
        $this->quote = $this->getMockBuilder(\Magento\Quote\Model\Quote::class)
            ->setMethods(['setData'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->quote->expects($this->any())->method('setData')->willReturn(null);
        $this->cartRepository = $this->getMockBuilder(\Magento\Quote\Api\CartRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $quoteIdMaskFactory = $this->getMockBuilder(\Magento\Quote\Model\QuoteIdMaskFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->newsletterSubscription = $this->getMockBuilder(NewsletterSubscription::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->newsletterSubscription->expects($this->once())->method('getSubscribe')->willReturn('1');
        $objectManager = new ObjectManager($this);
        $this->newsletterSubscriptionManagement = $objectManager->getObject(
            NewsletterSubscriptionManagement::class,
            [
                'cartRepository' => $this->cartRepository,
                'quoteIdMaskFactory' => $quoteIdMaskFactory
            ]
        );
    }

    public function testSubscribe()
    {
        $this->cartRepository->expects($this->once())->method('getActive')->willReturn($this->quote);
        $this->newsletterSubscriptionManagement->subscribe('1', $this->newsletterSubscription);
    }

    public function testSubscribeWithNoSuchEntityException()
    {
        $this->cartRepository->expects($this->once())->method('getActive')->willThrowException(new \Magento\Framework\Exception\NoSuchEntityException);
        $this->expectException(\Error::class);
        $this->newsletterSubscriptionManagement->subscribe('1', $this->newsletterSubscription);
        $this->expectException(\Magento\Framework\Exception\NoSuchEntityException::class);
    }

    public function testSubscribeWithCouldNotSaveException()
    {
        $this->cartRepository->expects($this->once())->method('getActive')->willReturn('2');
        $this->cartRepository->expects($this->any())->method('save')->willThrowException(new \Exception());
        $this->expectException(\Error::class);
        $this->newsletterSubscriptionManagement->subscribe('1', $this->newsletterSubscription);
        $this->expectException(\Magento\Framework\Exception\CouldNotSaveException::class);
    }
}
