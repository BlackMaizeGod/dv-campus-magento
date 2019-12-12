define(
    ['jquery'], function ($) {
        'use strict';

        return function () {
            $.validator.addMethod(
                'validate-ua-phone',
                function (value) {
                    return value[0] === '+' && /^38([- ]?)[0-9]{10}$/.test(value.substr(1));
                },
                $.mage.__('Enter correct ukrainian phone number, 13 symbols, start with +38, dont use \'-\' or space')
            );
        };
    }
);