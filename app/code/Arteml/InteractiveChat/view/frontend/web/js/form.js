define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'Magento_Ui/js/modal/alert',

], function ($, modal) {
    'use strict';

    $.widget('artemlInteractiveChat.form', {
        options: {
            formWrapperId: '#wrapper-for-chat-window'
        },
        /**
         * @private
         */
        _create: function () {
            this.form = $(this.element).modal({
                buttons: []
            });

            $(document).on('arteml_interactiveChat_showForm.arteml_interactiveChat', () => this.showForm());
        },

        /**
         * @private
         */
        _destroy: function () {
            $(document).off('arteml_interactiveChat_showForm.arteml_interactiveChat');
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
            console.log('show modal');
            this.form.modal('openModal');
        },

        /**
         * Hide Form
         */
        hideForm: function () {
            this.modal.closeModal();
            this.modal.destroy();
        }
    });

    return $.artemlInteractiveChat.form;
});
