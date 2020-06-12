define([
    'jquery',
    'mage/url',
    'jquery/ui'
], function ($, urlBuilder) {
    'use strict';

    $.widget('artemlInteractiveChat.chatMessages', {
        options: {
            messageCount: 10,
            route: 'ajax-interactive-chat/interactiveChat/getMessageList',
            messageContentHtmlClass: 'message-content',
            messageTimeHtmlClass: 'message-time',
            messageDateHtmlClass: 'message-date'
        },

        /**
         * @private
         */
        _create: function () {
            $(document).on(
                'arteml_interactiveChat_processMessages.arteml_interactiveChat',
                this.ajaxGetLastMessages.bind(this)
            );
            $(document).on(
                'arteml_interactiveChat_clearMessageArea.arteml_interactiveChat',
                this.clearMessageArea.bind(this)
            );
        },

        /**
         * Get messages list
         */
        ajaxGetLastMessages: function () {
            $.ajax(
                {
                    url: urlBuilder.build(this.options.route),
                    data: {
                        'message_count': this.options.messageCount,
                        'isAjax': true
                    },
                    context: this,
                    success: this.processMessages
                }
            );
        },

        /**
         * Clear message area
         */
        clearMessageArea: function () {
            $(this.element).html('');
        },

        /**
         * Appending messages to chat history div
         * @param {obj} response
         */
        processMessages: function (response) {
            var messages = response.messages,
                jsonDateOptions = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
            };

            messages.forEach(function ($message) {
                var datetime = new Date($message.created_at),
                    date = datetime.toLocaleDateString('en-US', jsonDateOptions),
                    time = datetime.getHours() + ':' + (datetime.getMinutes() > 9 ? datetime.getMinutes() : '0' + datetime.getMinutes()),
                    messageHtmlClass = $message.author_type + '-message',
                    messageHtmlMessage = '<span class="' + this.options.messageContentHtmlClass +'">' + $message.message + '</span>',
                    messageHtmlTime = '<span class="' + this.options.messageTimeHtmlClass + '">' + time + '</span>',
                    messageHtml = messageHtmlMessage + messageHtmlTime,
                    messageContent = '<p class="' + messageHtmlClass + '">'+ messageHtml + '</p>';

                $(this.element).children('.' + this.options.messageDateHtmlClass).last().text() !== date
                    ? $(this.element).append('<p class="' + this.options.messageDateHtmlClass + '"><span>' + date +'</span></p>')
                    : false;

                $(this.element).append(messageContent);
            }.bind(this));
        },

        /**
         * Destroy widget
         */
        _destroy: function () {
            $(document).off('arteml_interactiveChat_processMessages.arteml_interactiveChat');
            $(document).off('arteml_interactiveChat_clearMessageArea.arteml_interactiveChat');
        }
    });

    return $.artemlInteractiveChat.chatMessages;
});
