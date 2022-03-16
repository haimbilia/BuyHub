$(function () {

    /* for navigation drop down */
    $('.navchild').hover(function () {
        var el = $("body");
        if ($(window).width() > 1025) {
            $(this).toggleClass("is-focus");
            el.toggleClass("nav_show");
        }
        return false;
    });


    /* for mobile navigation */
    $('.link__mobilenav').click(function () {

        if ($(this).hasClass('is-focus')) {
            $(this).removeClass('is-focus');
            $(this).siblings('.navigation > li .subnav').slideUp();
            return false;
        }
        $('.link__mobilenav').removeClass('is-focus');
        $(this).addClass("is-focus");
        if ($(window).width() < 1025) {
            $('.navigation > li .subnav').slideUp();
            $(this).siblings('.navigation > li .subnav').slideDown();
        }
        return;
    });


    /* for mobile toggle navigation */
    $('.navs_toggle').click(function () {



        $(this).toggleClass("is-focus");
        var el = $("body");
        if (el.hasClass('toggled_left')) el.removeClass("toggled_left");
        else el.addClass('toggled_left');
        return false;
    });

    $('body').click(function () {
        if ($('body').hasClass('toggled_left')) {
            $('.navs_toggle').removeClass("is-focus");
            $('body').removeClass('toggled_left');
        }
    });

    $('.mobile__overlay').click(function () {
        if ($('body').hasClass('toggled_left')) {
            $('.navs_toggle').removeClass("is-focus");
            $('body').removeClass('toggled_left');
        }
    });


    $('.navigation-wrapper').click(function (e) {
        e.stopPropagation();

    });




});