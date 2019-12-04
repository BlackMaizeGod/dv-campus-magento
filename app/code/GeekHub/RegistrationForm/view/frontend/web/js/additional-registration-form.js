define(
    [
        'jquery',
        'Magento_Ui/js/modal/modal',
        'mage/url'
    ],
    function (
        $,
        modal,
        url
    ) {
        "use strict";

        return function (config, node) {
            const options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                title: '',
                buttons: [{
                    text: $.mage.__('Close'),
                    class: '',
                    click: function () {
                        $("#registration-form-content-wrapper").empty();
                        this.closeModal();
                    }
                }]
            };

            console.log(url);
            console.log(modal);
            let popup = modal(options, $("#header-registration-modal"));
            $(".registration-for-dealer-wrapper").on('click', function () {
                let modalContent = '<iframe width="100%" height="500" scrolling="auto" frameborder="0"' +
                    'src="' + url.build('dealer-additional-form/render/render') + '">' +
                    '</iframe>';
                $("#registration-form-content-wrapper").html(modalContent);
                $("#header-registration-modal").modal("openModal");
            });

            $('button.action-close').on('click', () => {
                $('#registration-form-content-wrapper').empty();
            });

            $(document).on('click', (e) => {
                if ($(e.target.parentElement).attr('class') !== 'modal-inner-wrap' &&
                    $(e.target).attr('class') !== 'non-target') {
                    $('#registration-form-content-wrapper').empty();
                }
            });
        }
    }
);