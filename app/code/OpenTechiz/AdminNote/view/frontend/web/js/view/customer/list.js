define([
    'uiComponent'
], function (Component) {
    'use strict';

    return Component.extend({
        defaults: {
            childTemplate: 'OpenTechiz_AdminNote/shipping-address/form',
        },
        /** @inheritdoc */
        initialize: function () {
            this._super();
            console.log('OpenTechiz_AdminNote/js/view/customer/list');
            console.log(this.config);
        }
    });
});
