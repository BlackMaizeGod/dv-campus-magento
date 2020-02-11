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
            $(this.element).on('click.arteml_interactiveChat', () => this.openModal());
        },

        /**
         * Open Modal
         */
        openModal: function () {
            $(document).trigger('arteml_interactiveChat_showForm');
        }
    });

    return $.artemlInteractiveChat.openButton;
});