define([
    'jquery',
    'Magento_Ui/js/modal/alert',

], function ($) {
    'use strict';

    $.widget('artemlInteractiveChat.form', {
        options: {
            formWrapperId: '#wrapper-for-chat-window',
            closeButtonId: '#close-btn'
        },

        /**
         * @private
         */
        _create: function () {
            $(document).on('arteml_interactiveChat_showForm.arteml_interactiveChat', this.showForm.bind(this));
            $(this.options.closeButtonId).on('click', this.hideForm.bind(this));
        },

        /**
         * @private
         */
        _destroy: function () {
            $(document).off('arteml_interactiveChat_showForm.arteml_interactiveChat');
            $(this.options.closeButtonId).off('click');
        },

        /**
         * Validate request form
         */
        validateForm: function () {
            return $(this.element).validation().valid();
        },

        /**
         * Show form
         */
        showForm: function () {
            this.element
                .css('transform','translate(0, 0)');
        },

        /**
         * Hide Form
         */
        hideForm: function () {
            this.element
                .css('transform','translate(200%, 0)');
        }
    });

    return $.artemlInteractiveChat.form;
});
