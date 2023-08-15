define([
    'ko',
    'jquery',
], function(ko, $)
{
    'use strict';
    $.widget('mage.pageBuilderReadMore', {
        options:{
            eleSelector:'.b-readmore',
            minHeightDesktop : 150,
            minHeightMobile : 320
        },
        _create: function () {
            var self = this;
            var body = $('body');
            body.find(self.options.eleSelector).each(function() {
                var heightContent = $(this).children('.b-readmore-content').height();
                var widthScreen = $(window).width();
                if ((widthScreen < 768 && heightContent > self.options.minHeightMobile) || (widthScreen > 768 && heightContent > self.options.minHeightDesktop)) {
                    $(this).addClass('active');
                    $(this).find('.b-button-read-more').addClass('show');
                }
            })
            body.on('click', '.b-button-read-more', function() {
                $(this).removeClass('show');
                $(this).parents('.b-readmore').removeClass('active');
                $('.b-readmore-content').first().addClass('active');
            })
        },
    });
    return $.mage.pageBuilderReadMore
});
