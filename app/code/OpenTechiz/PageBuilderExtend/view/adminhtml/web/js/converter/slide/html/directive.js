/*eslint-disable */
/* jscs:disable */
define([
    "Magento_PageBuilder/js/utils/directives",
    "Magento_PageBuilder/js/utils/editor",
    "Magento_PageBuilder/js/utils/object",
    "Magento_PageBuilder/js/config"
], function (_directives, _editor, _object, _config) {
    /**
     * Copyright © Magento, Inc. All rights reserved.
     * See COPYING.txt for license details.
     */

    /**
     * @api
     */
    var Directives = /*#__PURE__*/function () {
        "use strict";

        function Directives() {}

        var _proto = Directives.prototype;

        /**
         * Convert value to internal format
         *
         * @param {string} value
         * @returns {string | object}
         */
        _proto.fromDom = function fromDom(value,name, data) {
            if (!value) {
                return "";
            }
            if((0, _object.get)(data, 'enable_lazyload') == 'true') {
                value = value.replace('class="lazyload"', '');
                value = value.replace('src="{{view url=\'images/px.gif\'}}"', '');
                value = value.replace('data-src="', 'src="');
                console.log(1111);
            }
            return value;
        }
        /**
         * Convert value to knockout format
         *
         * @param {string} name
         * @param {Object} data
         * @returns {string}
         */
        ;

        _proto.toDom = function toDom(name, data) {
            var content = (0, _object.get)(data, name);
            if((0, _object.get)(data, 'enable_lazyload') == 'true') {
                content = content.replace('class="lazyload"', '');
                content = content.replace('src="{{view url=\'images/px.gif\'}}"', '');
                content = content.replace('data-src="', 'src="');
                content = content.replace("src=", " class=\"lazyload\" src=\"{{view url='images/px.gif'}}\" data-src=");
                console.log(true);
            } else {
                content = content.replace('class="lazyload"', '');
                content = content.replace('src="{{view url=\'images/px.gif\'}}"', '');
                content = content.replace('data-src="', 'src="');
                console.log(false);
            }
            var result = (0, _editor.encodeContent)((0, _directives.convertMediaDirectivesToUrls)((0, _directives.removeQuotesInMediaDirectives)(content)))
            return result;
        };

        return Directives;
    }();

    return Directives;
});
//# sourceMappingURL=directive.js.map
