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

        //TODO Remove cookie when customer logout

        $.widget(
            'geekhub.submitQuestion', {

                options: {
                    cookieName: 'ban_on_sending',
                    cookieLifeTime: 120
                },

                /**
                 * Constructor
                 * @private
                 */
                _create: function () {
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
                    if ($.mage.cookies.get(this.options.cookieName)) {
                        alert({
                            title: 'Error',
                            // eslint-disable-next-line max-len
                            content: 'You cannot send question now, please wait: ' + (this.options.cookieLifeTime - this.getTimeDifference()).toFixed() + ' seconds'
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
                 * set cookies
                 */
                setTimeCookie: function () {
                    // eslint-disable-next-line max-len
                    $.mage.cookies.set(this.options.cookieName, this.getUnixTime(), {lifetime: this.options.cookieLifeTime});
                }
            }
        );

        return $.geekhub.submitQuestion;
    }
);