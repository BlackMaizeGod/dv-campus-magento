define([
    'jquery',
    'mage/url',
    'Magento_Ui/js/modal/alert',
    "mage/cookies"
], function ($, url, alert) {
    'use strict';

    $.widget('artemlInteractiveChat.chatForm', {
        options: {
            formWrapperId: '#wrapper-for-chat-window',
            closeButtonId: '#close-btn',
            formId: '#chat-form',
            messageAreaId: '#chat-message-field',
            chatHistoryDivId: '#chat-history',
            openButtonWrapperElementClass: '.open-interactive-chat',
            customControllerUrl: url.build('ajax-interactive-chat/interactiveChat'),
        },

        /**
         * @private
         */
        _create: function () {
            $(document).on('arteml_interactiveChat_showForm.arteml_interactiveChat', this.showForm.bind(this));
            $(this.options.closeButtonId).on('click.arteml_interactiveChat', this.destroyForm.bind(this));

            $(this.options.formId).on('submit', this.submitForm.bind(this));
        },

        /**
         * @private
         */
        _destroy: function () {
            $(document).off('arteml_interactiveChat_showForm.arteml_interactiveChat');
            $(this.options.closeButtonId).off('click.arteml_interactiveChat');
            $(this.options.formId).off('submit');
            $(this.options.chatHistoryDivId).html('');
            $(this.options.messageAreaId).attr('value', '');
        },

        /**
         * Validate request form
         */
        validateForm: function () {
            return $(this.options.formId).validation().valid();
        },

        /**
         *  Submit Form
         */
        submitForm: function () {
            var that = this;
            var formData = new FormData($(this.options.formId).get(0));
            var textarea = $(this.options.messageAreaId);

            if (!this.validateForm()) {
                return;
            }

            formData.append('form_key', $.mage.cookies.get('form_key'));
            formData.append('isAjax', 1);


            $.ajax(
                {
                    url: that.options.customControllerUrl,
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    dataType: 'json',
                    context: this,
                    success: function (response) {
                        alert(
                            {
                                title: $.mage.__('Success'),
                                content: $.mage.__(response)
                            }
                        );
                        that.appendMessageToChat(textarea.val());
                        textarea.attr('value', '');

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
         * Append Message To chat
         */
        appendMessageToChat: function (message) {
            var today = new Date();
            var time = today.getHours() + ":" + today.getMinutes();

            $(this.options.chatHistoryDivId).append('<p class="user-message"><span class="message-text">' + message + '</span><span class="chat-time">' + time + '</span></p>');
        },

        /**
         * Show form
         */
        showForm: function () {
            this.element
                .css('transform', 'translate(0, 0)');
        },

        /**
         * Destroy Form
         */
        destroyForm: function () {
            this.element
                .css('transform', 'translate(200%, 0)');
            $($(this.options.openButtonWrapperElementClass).get(0)).data('artemlInteractiveChatOpenButton').destroy();
            this._destroy();
            this._create();
            $(this.options.openButtonWrapperElementClass).openButton();

        }
    });

    return $.artemlInteractiveChat.chatForm;
});
