$(document).on('click', '.blogPageBurgerIconJs', function () {
    // $(".blogOverlayJs, .menuNavJs").addClass('open');
});

$(document).on('click', '.blogOverlayJs', function () {
    $(".blogOverlayJs, .menuNavJs").removeClass('open');
});

$(function () {
    /* blog slider */
    if (langLbl.layoutDirection == 'rtl') {
        $('.post__pic').slick({
            dots: true,
            arrows: false,
            autoplay: true,
            rtl: true,
            pauseOnHover: false,

        });
    }
    else {
        $('.post__pic').slick({
            dots: true,
            arrows: false,
            autoplay: true,
            pauseOnHover: false,
        });

    }
    /* bannerAdds(); */
    if (boolLoadComments) {
        searchComments(document.frmSearchComments);
    }
});

$(document).on('click', ".link--post-comment-form", function () {
    /* $(document).delegate(".link--post-comment-form",'click',function(){ */
    $('html, body').animate({ scrollTop: $("#container--comment-form").offset().top - 150 }, 'slow');
    fcom.scrollToTop($("#container--comment-form"));
});

(function () {
    bannerAdds = function () {
        fcom.ajax(fcom.makeUrl('Banner', 'blogPage'), '', function (res) {
            $("#div--banners").html(res);
            if ($(window).width() < 990) {
                $('.grids').masonry({
                    itemSelector: '.grids__item',
                });
            }
        });
    };

    setupPostComment = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('Blog', 'setupPostComment'), data, function (res) {
            fcom.removeLoader();
            frm.reset();
        });
    };

    var dv = '#comments--listing';
    var currPage = 1;

    searchComments = function (frm, append) {

        if (typeof append == undefined || append == null) {
            append = 0;
        }

        var data = fcom.frmData(frm);
        if (append == 1) {
            $(dv).prepend(fcom.getLoader());
        } else {
            $(dv).html(fcom.getLoader());
        }

        fcom.updateWithAjax(fcom.makeUrl('Blog', 'searchComments'), data, function (ans) {
            fcom.removeLoader();
            $.ykmsg.close();
            if (append == 1) {
                $(dv).find('.loader-yk').remove();
                $(dv).find('form[name="frmSearchCommentsPaging"]').remove();
                $(dv).append(ans.html);
            } else {
                $(dv).html(ans.html);
            }

            $("#loadMoreCommentsBtnDiv").html(ans.loadMoreBtnHtml);
            if (1 < $(".commentBox-js").length) {
                $(".commentBox-js:not(:last)").remove();
            }
        });
    };

    goToLoadMoreComments = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        currPage = page;
        var frm = document.frmSearchCommentsPaging;
        $(frm.page).val(page);
        searchComments(frm, 1);
    };
})();
