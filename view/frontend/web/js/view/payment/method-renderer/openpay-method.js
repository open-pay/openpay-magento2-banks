/**
 * Openpay_Banks Magento JS component
 *
 * @category    Openpay
 * @package     Openpay_Banks
 * @author      Federico Balderas
 * @copyright   Openpay (http://openpay.mx)
 * @license     http://www.apache.org/licenses/LICENSE-2.0  Apache License Version 2.0
 */
/*browser:true*/
/*global define*/
define(
    [
        'knockout',
        'Magento_Checkout/js/view/payment/default',
        'jquery',
        'Magento_Checkout/js/model/quote'
    ],
    function (ko, Component, $, quote) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Openpay_Banks/payment/openpay-offline'
            },

            initialize: function () {
                this._super(); // Llama al initialize del padre
                
                // Definimos isMX como un "computed observable"
                this.isMx = ko.computed(function () {
                    const billingAddress = quote.billingAddress();
                    if (billingAddress && billingAddress.countryId) {
                        const countryId = billingAddress.countryId;
                        return countryId === 'MX';
                    }
                    return false; // Default to false if no address is set
                }, this);
            },

            getSpeiIcon: function() {
                return require.toUrl('https://img.openpay.mx/plugins/spei_logo.svg');
            },

            getPseIcon: function() {
                return require.toUrl('https://img.openpay.mx/plugins/pse_logo.svg');
            },

            country: function() {
                console.log('getCountry()', window.checkoutConfig.openpay_banks.country);
                return window.checkoutConfig.openpay_banks.country;
            },
            getImagePse: function() {
                return window.checkoutConfig.openpay_banks.image_pse;
            }
        });
    }
);