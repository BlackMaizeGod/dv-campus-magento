define(
    [
        'jquery',
        'Magento_Ui/js/modal/modal'
    ],
    function (
        $,
        modal
    ) {
        "use strict";

        return function () {
            var options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                title: '',
                buttons: [{
                    text: $.mage.__('Close'),
                    class: '',
                    click: function () {
                        this.closeModal();
                    }
                }]
            };

            var popup = modal(options, $('#header-registration-modal'));

            $('.registration-for-dealer-wrapper').on(
                'click', function () {
                    $('#header-registration-modal').modal('openModal');
                }
            );
        };
    }
);
