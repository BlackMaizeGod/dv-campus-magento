define(
    [
        'jquery',
        'jquery/ui'
    ], function ($) {
        'use strict';

        $.widget(
            'geekhub.submitQuestion', {
                _create: function () {
                    var that = this;

                    $(this.element).submit(
                        function () {
                            if($(that.element).validation().valid()) {
                                alert('valid');
                            }else {
                                alert('not valid');
                            }

                        }
                    );
                }
            }
        );

        return $.geekhub.submitQuestion;
    }
);