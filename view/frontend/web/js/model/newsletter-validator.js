define(
    [
        'jquery',
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/url-builder',
        'Magento_Checkout/js/model/error-processor',
        'mage/url'

    ],
    function ($, customer, quote, urlBuilder, errorProcessor, urlFormatter) {
        'use strict';

        function getNewsletterSubscribtionStatus() {
            var contexts = document.querySelectorAll('#checkout-payment-method-load [type=radio]');
            var i;
            for (i = 0; i < contexts.length; i++) {
                var checkbox = document.querySelector('#newsletter_' + contexts[i].id);
                if (checkbox && checkbox.checked) {
                    return true;
                }
            }
            return false;
        }

        return {
            validate: function () {
                var isCustomer = customer.isLoggedIn();
                var status = getNewsletterSubscribtionStatus();
                var quoteId = quote.getQuoteId();
                var url;

                if (isCustomer) {
                    url = urlBuilder.createUrl('/carts/mine/newsletter-subscribe', {})
                } else {
                    url = urlBuilder.createUrl('/guest-carts/:cartId/newsletter-subscribe', {cartId: quoteId});
                }

                var payload = {
                    cartId: quoteId,
                    newsletterSubscription: {
                        subscribe: status
                    }
                };

                if (!payload.newsletterSubscription.subscribe) {
                    return true;
                }

                var result = true;

                $.ajax({
                    url: urlFormatter.build(url),
                    data: JSON.stringify(payload),
                    global: false,
                    contentType: 'application/json',
                    type: 'PUT',
                    async: false
                }).done(
                    function () {
                        result = true;
                    }
                ).fail(
                    function (response) {
                        result = false;
                        errorProcessor.process(response);
                    }
                );
                return result;
            }
        };
    }
);