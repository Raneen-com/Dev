define([

    'underscore',

    'uiRegistry',

    'Magento_Ui/js/form/element/single-checkbox',

    'Magento_Ui/js/modal/modal',

    'ko'

], function (_, uiRegistry, select, modal, ko) {

    'use strict';

    return select.extend({


        initialize: function () {
            this._super();

            this.fieldDepend(this.value());

            return this;

        },

        onUpdate: function (value)
        {
            console.log(value);

            var field_url_val = uiRegistry.get('index = authentication_url'); // get field

            var field_request_type_val = uiRegistry.get('index = authentication_request_type'); // get fieldset

            var field_body_val = uiRegistry.get('index = authentication_request_body'); // get fieldset


            if (value == 0) {
                field_url_val.hide();
                field_request_type_val.hide();
                field_body_val.hide();
            }

            else {

                field_url_val.show();

                field_request_type_val.show();

                field_body_val.show();


            }
            return this._super();

        },
        fieldDepend: function (value)

        {
            setTimeout( function(){
                var field_url_val = uiRegistry.get('index = authentication_url'); // get field

                var field_request_type_val = uiRegistry.get('index = authentication_request_type'); // get fieldset

                var field_body_val = uiRegistry.get('index = authentication_request_body'); // get fieldset


                if (value == 0) {

                    field_url_val.hide();

                    field_request_type_val.hide();

                    field_body_val.hide();
                }

                else {

                    field_url_val.show();

                    field_request_type_val.show();

                    field_body_val.show();

                }

            });

        }
    });

});
