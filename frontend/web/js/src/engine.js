$(document).ready(function () {

    (function render_header() {
        var screen0 = $('#screen-0');
        var text = $('#header_text');
        var mouse = $('.__mouse', text);
        var scroll = $('.__scroll', text);
        var windowHeight = $(window).height();
        screen0.css({minHeight: windowHeight});
        text.css({
            top: screen0.height() / 2 - text.height() / 2,
            left: screen0.width() / 2 - text.width() / 2,
        });
        $('.__animated', text).addClass('active');

        if (windowHeight > 700 && mouse.length) {
            setTimeout(function () {
                var h = (windowHeight - text.height()) / 2 - 100;
                if (h > 0) {
                    var scrollTop = scroll.position().top;
                    mouse.css({opacity: 1, top: '+=' + h});
                    setTimeout(function () {
                        setInterval(function () {
                            scroll.animate({top: '+=10'}, 800, '', function () {
                                scroll.css({top:scrollTop});
                            });
                        }, 1100);
                    },1500);
                }
            }, 3600);
        }
    })();

    $('input[type-number],input[type-price]').not('[check-excluded]').on('blur', function () {
        if ($(this).val() <= 0) {
            $(this).addClass('warning').one('click', function () {
                $(this).removeClass('warning');
            });
        }
    });

    $('input[type-email]').on('blur', function () {
        if (!$(this).val().trim().match(/^[a-z0-9._+-]+@(?:[^.-]?[a-z0-9-]+[^-]?\.)+(?:[A-Z]{2,6})$/i)) {
            $(this).addClass('warning').one('click', function () {
                $(this).removeClass('warning');
            });
        }
    });


    (function self_culculate() {
        var eresult = $('#self_server_result');
        var eresult_usd = $('#self_server_result_usd');
        var form = $('#input_self_result');
        var inputs = $('input', form);

        var check = function () {
            var data = form.serializeArray();
            if (inputs.hasClass('warning')) {
                return false;
            }
            $.post(form.prop('action'), data, function (result) {
                if (result.error === false) {
                    eresult.text(result.profit + '%');
                    if (result.profit < 100) {
                        eresult.addClass('digit2')
                    } else {
                        eresult.removeClass('digit2')
                    }
                    eresult_usd.text(result.rate);
                }
            }, 'json');
        };

        inputs.on('blur', function () {
            check();
        });
        check();
    })();


    $('input[type-number]').priceFormat({
        prefix: '',
        thousandsSeparator: ' ',
        centsLimit: 0
    });
    $('input[type-price]').priceFormat({
        prefix: '',
        thousandsSeparator: ' ',
        centsLimit: 2
    });

    $('#scroll_down').on('click', function () {
        $('html,body').animate({
            scrollTop: $('#screen-1').position().top
        }, 900);
    })

    $('.inform-question').each(function () {
        $(this).css({
            position: 'relative',
            display: 'inline-block'
        });
        var q = $('<div class="ico-question"></div>').appendTo($(this));
        q.prop('title', $(this).data('hint'));
        if(typeof $(this).attr('data-mobile') !== 'undefined'){
            q.tooltipster({contentAsHTML: true, trigger: 'click'});
        } else {
            q.tooltipster({contentAsHTML: true});
        }
    });
});


var Btc = {
    check_form: function (form) {
        var success = true;
        var el = false;
        $('input[type-number],input[type-price],input[type-email]', form).each(function () {
            var val = $(this).val();
            if (($(this).attr('type-number') !== undefined || $(this).attr('type-price') !== undefined) && val <= 0) {
                el = $(this);
                success = false;
            } else if ($(this).attr('type-email') !== undefined && !val.match(/^[a-z0-9._+-]+@(?:[^.-]?[a-z0-9-]+[^-]?\.)+(?:[A-Z]{2,6})$/i)) {
                el = $(this);
                success = false;
            }
            return success;
        });
        if (el !== false) {
            el.addClass('warning').one('click', function () {
                $(this).removeClass('warning');
            });
        }

        return success;
    },
    order: function () {
        var form = $('#form_order');
        if (this.check_form(form) !== true) {
            return false;
        }
        $.post(form.prop('action'), form.serializeArray(), function(result){

        }, 'json');

        Btc.lightbox.open({
            src: '<div class="lb_ok"><div class="lb_ok_content"><div class="lb_ok_content_ok"></div>' +
            '<span class="lb_ok_content_send span48">Sent!</span>' +
            '<span class="lb_ok_content_text span16">You can address all your questions<br/> or concerns to' +
            ' <a href="mailto:info@btcstat.com">info@btcstat.com</a></span>' +
            '</div></div>'
        });
    },
    lightbox: {
        defOptions: {
            type: 'content',
            src: '<span>test</span>',
            title: 'Информация',
            callbacks: {
                afterOpen: null,
                beforeClose: null,
                afterClose: null
            }
        },
        options: {
            callbacks: {
                afterOpen: null,
                beforeClose: null,
                afterClose: null
            }
        },
        open: function (config) {
            var $overlay, $container, $popup, $close, $content, $wrap, $header, self = this;

            if (config)
                this.options = $.extend(this.defOptions, config);
            else
                this.options = this.defOptions;

            $('.popup__overlay.alert').remove();
            $('.popup_wrap.alert').remove();

            if ($('.popup__overlay:not(.static)').length) {
                $('.popup_wrap').remove();
                $overlay = $('.popup__overlay');
            } else {
                $('.popup__overlay.static').remove();
                $('.popup_wrap').remove();
                $overlay = $('<div class="popup__overlay open"></div>').appendTo($(document.body));
            }
            $wrap = $('<div class="popup_wrap"></div>').appendTo($(document.body));
            $container = $('<div class="popup_container"></div>').appendTo($wrap);
            $content = $('<div class="popup_content"></div>').appendTo($container);
            var $popup_container = $('<div class="popup_contant_container"></div>').appendTo($content);
            $popup = $('<div class="popup"></div>').appendTo($popup_container);


            if (this.options.type == 'content')
                $popup.append(this.options.src);
            else if (this.options.type == 'inline') {
                $popup.append($(this.options.src));
                $(this.options.src).removeClass('popup_state_hide');
            }

            $('html').css({
                'margin-right': '15px',
                'overflow': 'hidden'
            });
            /*

             $close.on('click', function (e) {
             self.close();
             });
             */
            $wrap.on('click', function (e) {
                //if ($(e.target).hasClass('popup_content') || $(e.target).hasClass('popup_container'))
                self.close();
            });


            $container.animate({
                opacity: 1
            }, 200);
            $overlay.animate({
                opacity: 1
            }, 200);

            if (typeof this.options.callbacks.afterOpen === 'function')
                this.options.callbacks.afterOpen($wrap);
        },
        close: function (timeout) {
            var self = this;

            if (typeof self.options.callbacks.beforeClose === 'function')
                self.options.callbacks.beforeClose();


            $.when(
                $('.popup_container').animate({
                    opacity: 0
                }, timeout >= 0 ? timeout : 300),
                $('.popup__overlay').animate({
                    opacity: 0
                }, timeout >= 0 ? timeout : 300)
            ).done(function () {
                if (self.options.type == 'inline') {
                    $(self.options.src).addClass('popup_state_hide');
                    $(document.body).append($(self.options.src));
                }

                $('.popup__overlay').remove();
                $('.popup_wrap').remove();

                if (typeof self.options.callbacks.afterClose === 'function')
                    self.options.callbacks.afterClose();

                self.options = {};
                $('html').css({
                    'margin-right': 0,
                    'overflow': 'auto'
                });

            });
        },
    }
};
