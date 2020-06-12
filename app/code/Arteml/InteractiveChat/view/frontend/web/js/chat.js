define([
    'jquery',
    'mage/url',
    'Magento_Ui/js/modal/alert',
    'jquery/ui'
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
            messageContentHtmlClass: 'message-content',
            messageTimeHtmlClass: 'message-time',
            customControllerUrl: url.build('ajax-interactive-chat/interactiveChat/sendMessage')
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
            $(document).trigger('arteml_interactiveChat_clearMessageArea.arteml_interactiveChat');
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
            var that = this,
                formData = new FormData($(this.options.formId).get(0)),
                textarea = $(this.options.messageAreaId),
                today = new Date(),
                time = today.getHours() + ':' + this.roundDatetime(today.getMinutes()),
                date = today.getFullYear() + "-" + this.roundDatetime(today.getMonth() + 1) + "-" + this.roundDatetime(today.getDate());

            if (!this.validateForm()) {
                return;
            }

            formData.append('form_key', $.mage.cookies.get('form_key'));
            formData.append('isAjax', 1);
            formData.append('datetime', date + ' ' + time);

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
                        that.appendMessageToChat(textarea.val(), time);
                        textarea.attr('value', '');

                    },
                    error: function (errorMessage) {
                        alert(
                            {
                                title: $.mage.__('Error'),
                                content: $.mage.__(JSON.parse(errorMessage.responseText))
                            }
                        );
                    }
                }
            );
        },

        /**
         * Append Message To chat
         */
        appendMessageToChat: function (message, time) {
            var messageText = '<span class="' + this.options.messageContentHtmlClass + '">' + message + '</span>',
                messageTime = '<span class="' + this.options.messageTimeHtmlClass + '">' + time + '</span>',
                messageContent = messageText + messageTime;

            $(this.options.chatHistoryDivId).append('<p class="customer-message">' + messageContent +'</p>');
        },

        /**
         * Show form
         */
        showForm: function () {
            $(document).trigger('arteml_interactiveChat_processMessages.arteml_interactiveChat');
            this.element
                .css('transform', 'translate(0, 0)');
        },

        /**
         * @param value
         * @returns {string}
         */
        roundDatetime: function (value) {
            return value > 9 ? value : '0' + value;
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
