/*eslint-disable */
/* jscs:disable */
define([
    "Magento_PageBuilder/js/config",
    "Magento_PageBuilder/js/utils/image",
    "Magento_PageBuilder/js/utils/object",
    "Magento_PageBuilder/js/utils/url"],
    function (_config, _image, _object, _url) {
    /**
     * Copyright © Magento, Inc. All rights reserved.
     * See COPYING.txt for license details.
     */

    /**
     * @api
     */
    var Src = /*#__PURE__*/function () {
        "use strict";

        function Src() {}

        var _proto = Src.prototype;

        /**
         * Convert value to internal format
         *
         * @param value string
         * @param name string
         * @param {DataObject} data
         * @returns {string | object}
         */
        _proto.fromDom = function fromDom(value, name, data) {
            var enableLazyload = (0, _object.get)(data, 'enable_lazyload');
            var dataSrc = (0, _object.get)(data, 'data-src');
            if (enableLazyload == 'true' && dataSrc) {
                return dataSrc;
            }
            if (!value) {
                return "";
            }
            return value;
        }
        /**
         * Convert value to knockout format
         *
         * @param {string} name
         * @param {DataObject} data
         * @returns {string}
         */
        ;

        _proto.toDom = function toDom(name, data) {
            var value = (0, _object.get)(data, name);
            var enableLazyload = (0, _object.get)(data, 'enable_lazyload');
            if (enableLazyload == 'true' && value) {
                return "{{view url='images/px.gif'}}"
            }
            return value;
        };

        return Src;
    }();

    return Src;
});
//# sourceMappingURL=src.js.map
