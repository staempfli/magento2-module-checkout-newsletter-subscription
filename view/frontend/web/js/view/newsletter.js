define([
    'ko',
    'jquery',
    'uiComponent'
], function (ko, $, Component) {
    'use strict';

    function getContextId(element) {
        var context = element;
        while (!context.querySelector('[type=radio]')) {
            context = context.parentNode;
        }
        return context.querySelector('[type=radio]').id;
    }

    return Component.extend({
        defaults: {
            template: 'Staempfli_CheckoutNewsletterSubscription/newsletter'
        },

        /**
         * @param {Object} context - the ko context
         */
        getCheckboxId: function (context) {
            return 'newsletter_' + getContextId(context);
        },

        /**
         * @param {Object} context - the ko context
         */
        getCheckboxName: function (context) {
            return 'newsletter[' + getContextId(context) + ']';
        }
    });
});
