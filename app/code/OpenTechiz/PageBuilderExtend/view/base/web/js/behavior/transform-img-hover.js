define([
    'ko',
    'jquery',
], function(ko, $)
{
    'use strict';
    $.widget('mage.transformImgHover', {
        options:{
            eleParent:'.container-transfer-img',
            eleSelector:'',
            classAdd:'show-bg',
        },
        _create: function () {
            var self = this;
            self.addClassFollowplatFormAndBrowser();

            if ($(window).width() >= 768) {
                $(self.options.eleParent).height($(self.options.eleParent + ' .element-content-image').height());
            }
            $(window).resize(function(){
                if($(window).width() >= 768) {
                    $(self.options.eleParent).height($(self.options.eleParent + ' .element-content-image').height());
                } else {
                    $(self.options.eleParent).height('auto');
                }
            });

            $(self.options.eleSelector).mouseenter(function () {
                if($(window).width() >= 768) {
                    $(this).addClass('hovering');
                    $(this).siblings('.box-img').addClass('unhover');
                }
            });
            $(self.options.eleSelector).mouseleave(function () {
                if($(window).width() >= 768) {
                    $(this).removeClass('hovering');
                    $(this).siblings('.box-img').removeClass('unhover');
                }
            })
        },
        addClassFollowplatFormAndBrowser: function()
        {
            var self = this;
            let platform = '';
            if (/(Mac|iPhone|iPod|iPad)/i.test(navigator.platform)) {
                platform = 'mac-';
            } else if(/(Win)/i.test(navigator.platform)) {
                platform = 'win-';
            } else if(/(Linux)/i.test(navigator.platform)) {
                platform = 'linux-';
            }
            let userAgent = navigator.userAgent;
            let browserName = '';
            if(userAgent.match(/chrome|chromium|crios/i)){
                browserName = "chrome";
            }else if(userAgent.match(/firefox|fxios/i)){
                browserName = "firefox";
            }  else if(userAgent.match(/safari/i)){
                browserName = "safari";
            }else if(userAgent.match(/opr\//i)){
                browserName = "opera";
            } else if(userAgent.match(/edg/i)){
                browserName = "edge";
            }
            var addClass = platform + browserName;
            $(self.options.eleParent).addClass(addClass);
        }
    });
    return $.mage.transformImgHover
});
