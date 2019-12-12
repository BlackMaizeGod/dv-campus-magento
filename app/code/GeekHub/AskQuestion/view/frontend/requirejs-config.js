var config = {
    config: {
        mixins: {
            'mage/validation': {
                'GeekHub_AskQuestion/js/validation/validator-mixin': true
            }
        }
    },
    map: {
        '*': {
            submitQuestion: 'GeekHub_AskQuestion/js/submit-question',
            validationAlert: 'GeekHub_AskQuestion/js/validation-alert',
            'jquery/jquery.cookie': 'GeekHub_AskQuestion/js/jquery/jquery.cookie'
        }
    }
};
