<?php

namespace Staempfli\CheckoutNewsletterSubscription\Setup;

use Staempfli\CheckoutNewsletterSubscription\Model\Data\NewsletterSubscription;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

use Magento\Framework\DB\Ddl\Table;
use Magento\Quote\Setup\QuoteSetupFactory;

class InstallData implements InstallDataInterface
{
    /**
     * @var QuoteSetupFactory
     */
    private $quoteSetupFactory;

    /**
     * InstallData constructor.
     * @param QuoteSetupFactory $quoteSetupFactory
     */
    public function __construct(
        QuoteSetupFactory $quoteSetupFactory
    ) {
        $this->quoteSetupFactory = $quoteSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) //@codingStandardsIgnoreLine
    {
        $setup->startSetup();
        /** @var \Magento\Quote\Setup\QuoteSetup $quoteInstaller */
        $quoteInstaller = $this->quoteSetupFactory->create(['resourceName' => 'quote_setup', 'setup' => $setup]);

        $quoteInstaller->addAttribute(
            'quote',
            NewsletterSubscription::NEWSLETTER_SUBSCRIPTION,
            ['type' => Table::TYPE_INTEGER, 'nullable' => true]
        );
        $setup->endSetup();
    }
}
