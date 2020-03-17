define([
    'jquery',
    'jquery/ui',
    'mage/translate'
], function ($) {
    'use strict';

    $.widget('artemlInteractiveChat.openButton', {

        /**
         * @private
         */
        _create: function () {
            $(this.element).on('click.arteml_interactiveChat', this.openModal.bind(this));
        },

        /**
         * Destroy widget
         */
        _destroy: function () {
            $(this.element).off('click.arteml_interactiveChat');
        },


        /**
         * Open Modal
         */
        openModal: function () {
            $(document).trigger('arteml_interactiveChat_showForm.arteml_interactiveChat');
        }
    });

    return $.artemlInteractiveChat.openButton;
});