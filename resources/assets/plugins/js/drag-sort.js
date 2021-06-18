/**
 * @fileView 基于jQuery的简单拖动排序插件
 *
 * @param {Object} options
 *        {String} targetEle 可选，排序元素的DOM选择器字符串，默认li
 *        {object} replaceStyle 可选， 拖动时，占位元素的样式
 *        {object} dragStyle 可选， 拖动时，被拖动元素的样式
 * 
 * @example $('#wrap').dragSort();
 *
 * @author 阿伦<https://github.com/ylb1992/drag-sort>
 **/
(function($) {
    'use strict';
    $.fn.dragSort = function(options) {
        var settings = $.extend(true, {
            targetEle: 'li',
            replaceStyle: {
                'background-color': '#f9f9f9',
                'border': '1px dashed #ddd'
            },
            dragStyle: {
                'position': 'fixed',
                'box-shadow': '10px 10px 20px 0 #eee'
            }
        }, options);

        return this.each(function() {
            
            // 由于有些浏览器的图片和链接是默认可以拖动的，所以屏蔽掉document的dragstart事件 
            document.ondragstart = function() {
                return false;
            }

            var thisEle = $(this);
            thisEle.on('mousedown.dragSort', settings.targetEle, function(event) {

                var selfEle = $(this);

                // 只允许鼠标左键拖动
                if(event.which !== 1) {
                    return;
                }

                // 禁止在表单元素里面拖动
                var tagName = event.target.tagName.toUpperCase();
                if(tagName === 'INPUT' || tagName === 'TEXTAREA' || tagName === 'SELECT') {
                    return;
                }

                var moveEle = $(this);

                var offset = selfEle.offset();
                var rangeX = event.pageX - offset.left;
                var rangeY = event.pageY - offset.top;

                var replaceEle = selfEle.clone()
                    .css('height', selfEle.outerHeight())
                    .css(settings.replaceStyle)
                    .empty();
                settings.dragStyle.width = selfEle.width();
                var move = true;

                $(document).on('mousemove.dragSort', function(event) {
                    if (move) {
                        moveEle.before(replaceEle).css(settings.dragStyle).appendTo(moveEle.parent());
                        move = false;
                    }

                    var thisOuterHeight = moveEle.outerHeight();

                    // 滚动条的位置
                    var scrollTop = $(document).scrollTop();
                    var scrollLeft = $(document).scrollLeft();


                    var moveLeft = event.pageX - rangeX - scrollLeft;
                    var moveTop = event.pageY - rangeY - scrollTop;



                    var prevEle = replaceEle.prev();
                    var nextEle = replaceEle.next().not(moveEle);

                    moveEle.css({
                        left: moveLeft,
                        top: moveTop
                    });


                    // 向上排序
                    if (prevEle.length > 0 && moveTop + scrollTop < prevEle.offset().top + prevEle.outerHeight() / 2) { 
                        replaceEle.after(prevEle);
                    //向下排序
                    } else if (nextEle.length > 0 && moveTop + scrollTop > nextEle.offset().top - nextEle.outerHeight() / 2) { 
                        replaceEle.before(nextEle);
                    }
                });

                $(document).on('mouseup.dragSort', function(event) {
                    $(document).off('mousemove.dragSort mouseup.dragSort')
                    if (!move) {
                        replaceEle.before(moveEle.removeAttr('style')).remove();
                    }
                });
            });
        });
    };
})(jQuery)