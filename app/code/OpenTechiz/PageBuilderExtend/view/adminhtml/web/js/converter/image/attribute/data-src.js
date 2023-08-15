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
             * @returns {string | object}
             */
            _proto.fromDom = function fromDom(value) {
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
                var enableLazyload = (0, _object.get)(data, 'enable_lazyload');
                var value = (0, _object.get)(data, name);
                var imageUrl = '';
                var mediaUrl = '';
                var mediaPath = ''
                if (enableLazyload == "true") {
                    var desktopImage = (0, _object.get)(data, 'image');
                    var mobileImage = (0, _object.get)(data, 'mobile_image');
                    var imageMedia = (0, _object.get)(data, 'image_media');
                    if (imageMedia) {
                        return imageMedia;
                    }
                    if(desktopImage && desktopImage[0] != undefined && desktopImage[0].url != undefined) {
                        imageUrl = desktopImage[0].url;
                        mediaUrl = (0, _url.convertUrlToPathIfOtherUrlIsOnlyAPath)(_config.getConfig("media_url"), imageUrl);
                        mediaPath = imageUrl.split(mediaUrl);
                        return "{{media url=" + mediaPath[1] + "}}";
                    }
                    if(mobileImage && mobileImage[0] != undefined && mobileImage[0].url != undefined) {
                        imageUrl = mobileImage[0].url;
                        mediaUrl = (0, _url.convertUrlToPathIfOtherUrlIsOnlyAPath)(_config.getConfig("media_url"), imageUrl);
                        mediaPath = imageUrl.split(mediaUrl);
                        return "{{media url=" + mediaPath[1] + "}}";
                    }
                } else {
                    value = null;
                }
                return value;
            };
            return Src;
        }();

        return Src;
    });
//# sourceMappingURL=src.js.map
