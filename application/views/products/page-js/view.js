$(function () {
    var tabsReferences = [];
    if (0 < $('a.nav-scroll-js').length) {
        $('a.nav-scroll-js').each(function () {
            tabsReferences.push($(this).attr('href'));
        });
    }

    /* Product Main image to be static on scroll par a particular window scroll range[ */
    $(window).on("scroll", function () {
        var scrollTop = $(window).scrollTop();

        $.each(tabsReferences, function (index, value) {
            var tabDist = ($('.nav-detail-js a[href="' + value + '"]').offset().top) - scrollTop;
            var contentDist = (($(value).offset().top) - scrollTop) - tabDist;
            var headerHeight = $("#header").height();
            if ((headerHeight + 20) > tabDist && 130 > contentDist) {
                $(".nav-scroll-js").removeClass('is-active');
                $('a[href="' + value + '"]').addClass('is-active');
            } else if ((headerHeight + 20) < tabDist) {
                $(".nav-scroll-js").removeClass('is-active');
            }
        });
    });

    $(".cancel").on('click', function () {
        $(this).closest('.addon--js').toggleClass('cancelled--js ');
        $(this).toggleClass('remove-add-on');
    });

    $(".be-first").on('click', function () {
        $('html, body').animate({ scrollTop: $("#itemRatings").offset().top - 130 }, 'slow');
        fcom.scrollToTop($("#itemRatings"));
    });

    $(".itemthumb").on('click', function () {
        var mainSrc = $(this).find('img').attr('main-src');
        $(".item__main").find('img').attr('src', mainSrc);
    });

    // $('.js-collection-corner').slick(getSlickSliderSettings(5, 1, langLbl.layoutDirection));

    /* for on scoll jump navigation fix */
    /* var elementPosition = $('.nav--jumps').offset();
    $(window).scroll(function(){
        if( $(window).scrollTop() > elementPosition.top ){
            $('.nav--jumps').addClass('nav--jumps-fixed');
        } else {
            $('.nav--jumps').removeClass('nav--jumps-fixed');
        }
    });
     */
    $(".link_li").on('click', function (event) {
        event.preventDefault();

        var target_offset = $(".product--specifications").offset();
        var target_top = target_offset.top - 100;
        $('html, body').animate({ scrollTop: target_top }, 1000);
    });
    /* for click scroll function */
    $(".scroll").on('click', function (event) {
        /* event.preventDefault();
        var full_url = this.href;
        var parts = full_url.split("#");
        var trgt = parts[1];
        fcom.scrollToTop('#' + trgt);
        var target_offset = $("#" + trgt).offset();
        var target_top = target_offset.top - 60;
        $('html, body').animate({ scrollTop: target_top }, 1000); */
    });

    $(".link--write").on('click', function () {
        $('html, body').animate({ scrollTop: $("#itemRatings").offset().top - 130 }, 'slow');
        fcom.scrollToTop($("#itemRatings"));
    });

    /* bannerAdds(); */
    reviews(document.frmReviewSearch);


    /* Product Gallery */
    $("#detail .main-img-slider").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        arrows: true,
        fade: true,
        autoplay: true,
        autoplaySpeed: 4000,
        speed: 300,
        lazyLoad: "ondemand",
        asNavFor: ".thumb-nav",
        prevArrow: '<button class="btn btn-prev"><span></span> </button>',
        nextArrow: '<button class="btn btn-next"><span></span> </button>',
    });

    /* Thumbnail/alternates slider for product page */
    $(".thumb-nav").slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        infinite: true,
        centerPadding: "0px",
        asNavFor: ".main-img-slider",
        dots: false,
        centerMode: false,
        draggable: true,
        speed: 200,
        focusOnSelect: true,
        prevArrow: '<button class="btn btn-prev"><span></span> </button>',
        nextArrow: '<button class="btn btn-next"><span></span> </button>',
    });

    /* keeps thumbnails active when changing main image, via mouse/touch drag/swipe */
    $(".main-img-slider").on("afterChange", function (event, slick, currentSlide, nextSlide) {
        /* remove all active class */
        $(".thumb-nav .slick-slide").removeClass("slick-current");
        /* set active class for current slide */
        $(".thumb-nav .slick-slide:not(.slick-cloned)").eq(currentSlide).addClass("slick-current");
    });
    /* Product Gallery */
});

function moreSellerRows(selprodCode, sellerId) {
    fcom.ajax(fcom.makeUrl('Products', 'moreSellersRows', [selprodCode, sellerId]), '', function (res) {
        $('.moreSellerRows--js').append(res);
    });
}

function getSortedReviews(elm) {
    if ($(elm).length) {
        var sortBy = $(elm).data('sort');
        if (sortBy) {
            document.frmReviewSearch.orderBy.value = $(elm).data('sort');
            $(elm).parent().siblings().removeClass('is-active');
            $(elm).parent().addClass('is-active');
        }
    }
    $('.sortByTxtJs').text($(elm).text());
    $('.sortByEleJs').removeClass('active');
    $(elm).addClass('active');
    reviews(document.frmReviewSearch);
}

function reviewAbuse(reviewId) {
    if (reviewId) {
        $.facebox(function () {
            fcom.ajax(fcom.makeUrl('Reviews', 'reviewAbuse', [reviewId]), '', function (t) {
                $.facebox(t);
            });
        });
    }
}

function setupReviewAbuse(frm) {
    if (!$(frm).validate()) return;
    var data = fcom.frmData(frm);
    fcom.updateWithAjax(fcom.makeUrl('Reviews', 'setupReviewAbuse'), data, function (t) {
        $(document).trigger('close.facebox');
    });
    return false;
}

(function () {
    var setProdWeightage = false;
    var timeSpendOnProd = false;
    bannerAdds = function () {
        fcom.ajax(fcom.makeUrl('Banner', 'products'), '', function (res) {
            $("#productBanners").html(res);
        });
    };

    setProductWeightage = function (code) {
        var data = 'selprod_code=' + code;
        if (setProdWeightage == true && timeSpendOnProd == true) { return; }
        if (setProdWeightage == true) {
            timeSpendOnProd = true;
            data += '&timeSpend=true';
        }
        setProdWeightage = true;
        fcom.ajax(fcom.makeUrl('Products', 'logWeightage'), data, function (res) { });
    };

    /* reviews section[ */
    var dv = '#itemRatings .reviewListJs';
    var currPage = 1;

    reviews = function (frm, append) {
        if (typeof append == undefined || append == null) {
            append = 0;
        }

        var data = fcom.frmData(frm);
        if (append == 1) {
            $(dv).prepend(fcom.getLoader());
        } else {
            $(dv).html(fcom.getLoader());
        }
        data += '&productView=1';
        fcom.updateWithAjax(fcom.makeUrl('Reviews', 'searchForProduct'), data, function (ans) {
            $.ykmsg.close();
            fcom.removeLoader();
            if (ans.totalRecords) {
                $('#reviews-pagination-strip--js').show();
            }
            if (append == 1) {
                $(dv).find('.loader-yk').remove();
                $(dv).find('form[name="frmSearchReviewsPaging"]').remove();
                $(dv).append(ans.html);
                $('#reviewEndIndex').html((Number($('#reviewEndIndex').html()) + ans.recordsToDisplay));
            } else {
                $(dv).html(ans.html);
                $('#reviewStartIndex').html(ans.startRecord);
                $('#reviewEndIndex').html(ans.recordsToDisplay);
            }
            $('#reviewsTotal').html(ans.totalRecords);
            $("#loadMoreReviewsBtnDiv").html(ans.loadMoreBtnHtml);
        }, '', false);
    };

    goToLoadMoreReviews = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        currPage = page;
        var frm = document.frmSearchReviewsPaging;
        $(frm.page).val(page);
        reviews(frm, 1);
    };

    /*] */

    markReviewHelpful = function (reviewId, isHelpful) {
        if (isUserLogged() == 0) {
            loginPopUpBox();
            return false;
        }
        isHelpful = (isHelpful) ? isHelpful : 0;
        var data = 'reviewId=' + reviewId + '&isHelpful=' + isHelpful;
        fcom.updateWithAjax(fcom.makeUrl('Reviews', 'markHelpful'), data, function (ans) {
            $.ykmsg.close();
            reviews(document.frmReviewSearch);
            /* if(isHelpful == 1){

            } else {

            } */
        });
    }

    shareSocialReferEarn = function (selprod_id, socialMediaName) {
        if (isUserLogged() == 0) {
            loginPopUpBox();
            return false;
        }
        var data = 'selprod_id=' + selprod_id + '&socialMediaName=' + socialMediaName;

        $.facebox(function () {
            fcom.ajax(fcom.makeUrl('Account', 'shareSocialReferEarn'), data, function (t) {
                $.facebox(t);
            });
        });
        return false;
    }

    rateAndReviewProduct = function (product_id) {
        if (isUserLogged() == 0) {
            loginPopUpBox();
            return false;
        }
        /* var data = 'product_id=' + product_id; */
        window.location = fcom.makeUrl('Reviews', 'write', [product_id]);
    }

    checkUserLoggedIn = function () {
        if (isUserLogged() == 0) {
            loginPopUpBox();
            return false;
        } else return true;
    }

    loadMoreImages = function (obj, e) {
        e.preventDefault();
        $(obj).removeAttr("onclick");
        $(obj).find('.moreMediaCountJs').remove();
        $(obj).siblings('.moreMediaJs').removeClass("d-none");
        return false;
    }


})();

/* jQuery(document).ready(function ($) {
    $('a[rel*=facebox]').facebox()
}); */

/* for sticky things*/
if ($(window).width() > 1050) {
    function sticky_relocate() {
        var window_top = $(window).scrollTop();
        var div_top = $('.fixed__panel').offset().top - 110;
        var sticky_left = $('#fixed__panel');
        if ((window_top + sticky_left.height()) >= ($('.unique-heading').offset().top - 40)) {
            var to_reduce = ((window_top + sticky_left.height()) - ($('.unique-heading').offset().top - 40));
            var set_stick_top = -40 - to_reduce;
            sticky_left.css('top', set_stick_top + 'px');
        } else {
            sticky_left.css('top', '110px');
            if (window_top > div_top) {
                $('#fixed__panel').addClass('stick');
            } else {
                $('#fixed__panel').removeClass('stick');
            }
        }
    }


}

$('.gallery').modaal({
    type: 'image'
});

function playVideo(videoPath, type, filename) {
    fcom.updateFaceboxContent(function () {
        $.facebox.reveal('<div class="modal-body"><div class="jwplayer--content"><div id="jwplayer-blk"></div></div></div>');
        $("." + $.facebox.element + ' .modal-header').prepend("<h4>" + filename + "</h4>");
        /* 
        ------following code can be used if need to set height/width of jw player and need to set the . Other wise we have the option to set the aspect ratio.

        var width = $('.jwplayer--content').width() || 0;
        var height = $('.jwplayer--content').height() || 0;

        if (1 > width) {
            width = $('#facebox').width();
        }
        if (1 > height) {
            height = $('#facebox').height();
        } */

        var type = type || "mp4";
        var jwplayerInst = jwplayer("jwplayer-blk").setup({
            file: videoPath,
            type: type,
            /* width: width,
            height: height, */
            aspectratio: "16:9",
            events: {
                onTime: function (object) {
                    if (object.position > object.duration - 1) {
                        this.pause();
                    }
                }
            }
        }).play();
    });
}