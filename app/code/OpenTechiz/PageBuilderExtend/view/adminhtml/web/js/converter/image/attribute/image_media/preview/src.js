/*eslint-disable */
/* jscs:disable */
define(
    [
        "Magento_PageBuilder/js/utils/object",
        "Magento_PageBuilder/js/config",
    ],

    function (_object, _config) {
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
         * @returns {string | object}
         */
        _proto.fromDom = function fromDom(value) {
            return value;
        }
        /**
         * Convert value to knockout format
         *
         * @param name string
         * @param data Object
         * @returns {string}
         */
        ;

        _proto.toDom = function toDom(name, data) {
            var value = (0, _object.get)(data, name);
            var mediaUrl = _config.getConfig("media_url");
            var pathImage = '';
            if(value) {
                var valueSplit = [];
                if(value.indexOf('"') != -1) {
                    valueSplit = value.split('"');
                }
                if(value.indexOf("'") != -1) {
                    valueSplit = value.split("'");
                }

                if (valueSplit.length > 1) {
                    pathImage = valueSplit[1];
                } else {
                    if(value.indexOf("{{media url=") != -1 && value.indexOf("}}") != -1) {
                        value = value.replace("{{media url=", "");
                        value = value.replace("}}", "");
                        pathImage = value;
                    }
                }
            }
            if(pathImage) {
                return mediaUrl+pathImage;
            }
            return "";
        };
        return Src;
    }();

    return Src;
});
//# sourceMappingURL=src.js.map
