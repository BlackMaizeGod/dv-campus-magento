define(
    [
        'jquery',
        'validationAlert',
        'Magento_Ui/js/modal/alert',
        'mage/translate',
        'mage/cookies',
        'jquery/ui',
    ], function ($, validationAlert, alert) {
        'use strict';

        $.widget(
            'geekhub.submitQuestion', {

                options: {
                    cookieName: 'last_submit_time',
                    cookieLiveTime: 120
                },

                /**
                 * Constructor
                 * @private
                 */
                _create: function () {
                    this.clearCookie();
                    $(this.element).submit(this.submit.bind(this));
                },

                /**
                 * Validate request form
                 */
                validateForm: function () {
                    return $(this.element).validation().valid();
                },

                /**
                 * Validate request and submit the form if able
                 */
                submit: function () {
                    if (!this.validateForm()) {
                        validationAlert();
                        return;
                    }
                    if (!this.isValidCookieLiveTime()) {
                        alert({
                            title: 'Error',
                            // eslint-disable-next-line max-len
                            content: 'You cannot send question now, please wait: ' + (this.options.cookieLiveTime-this.getTimeDifference()).toFixed() + ' seconds'
                        });
                        return;
                    }
                    this.submitAjax();
                },

                /**
                 * Submit request via AJAX. Add form key to the post data.
                 */
                submitAjax: function () {
                    var that = this;
                    var formData = new FormData($(this.element).get(0));

                    formData.append('form_key', $.mage.cookies.get('form_key'));
                    formData.append('isAjax', 1);

                    $.ajax(
                        {
                            url: $(this.element).attr('action'),
                            data: formData,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            dataType: 'json',
                            context: this,
                            success: function (response) {
                                alert(
                                    {
                                        title: $.mage.__(response.status),
                                        content: $.mage.__(response.message)
                                    }
                                );
                                that.setTimeCookie();
                            },
                            error: function (errorMessage) {
                                alert(
                                    {
                                        title: $.mage.__('Error'),
                                        // eslint-disable-next-line max-len
                                        content: $.mage.__(errorMessage.responseText)
                                    }
                                );
                            }
                        }
                    );

                },

                /**
                 * Get unix time
                 */
                getUnixTime: function () {
                    return new Date().valueOf() * 0.001;
                },

                /**
                 * Get difference between current unix time and cookie value
                 */
                getTimeDifference: function () {
                    return this.getUnixTime() - parseFloat($.mage.cookies.get(this.options.cookieName));
                },

                /**
                 * Check value last_submit_time cookie and current unix time
                 */
                isValidCookieLiveTime: function () {
                    if($.mage.cookies.get(this.options.cookieName)){
                        return this.getTimeDifference() >= this.options.cookieLiveTime;
                    }
                    return true;
                },

                /**
                 * set cookies
                 */
                setTimeCookie: function () {
                    $.mage.cookies.set(this.options.cookieName, this.getUnixTime());
                },

                /**
                 * Clear cookie
                 */
                clearCookie: function () {
                    $.mage.cookies.clear(this.options.cookieName);
                }
            }
        );

        return $.geekhub.submitQuestion;
    }
);