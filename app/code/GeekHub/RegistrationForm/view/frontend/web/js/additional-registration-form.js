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

        return function (config, element) {
            const options = {
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

            let popup = modal(options, $("#header-registration-modal"));
            $(".registration-for-dealer-wrapper").on('click', function () {
                $("#header-registration-modal").modal("openModal");
            });
        }
    }
);