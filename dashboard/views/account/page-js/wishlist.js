$("document").ready(function () {
    $(document).on("click", ".selectItem--js", function () {
        if ($(this).prop("checked") == false) {
            $(".selectAll-js").prop("checked", false);
        }
        if ($(".selectItem--js").length == $(".selectItem--js:checked").length) {
            $(".selectAll-js").prop("checked", true);
        }
        showFormActionsBtns();
    });
});

(function () {
    var dv = "#listingDiv";
    searchWishList = function () {
        $("#tab-wishlist").parents().children().removeClass("is-active");
        $("#tab-wishlist").addClass("is-active");
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl("Account", "wishListSearch"), "", function (res) {
            fcom.removeLoader();
            $(dv).html(res);
        });
    };

    setupWishList2 = function (frm, event) {
        if (!$(frm).validate()) return false;
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(
            fcom.makeUrl("Account", "setupWishList"),
            data,
            function (ans) {
                if (ans.status) {
                    searchWishList();
                }
            }
        );
    };

    deleteWishList = function (uwlist_id) {
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        fcom.updateWithAjax(
            fcom.makeUrl("Account", "deleteWishList"),
            "uwlist_id=" + uwlist_id,
            function (ans) {
                if (ans.status) {
                    searchWishList();
                }
            }
        );
    };

    searchFavouriteListItems = function (frm, append) {
        if (typeof append == undefined || append == null) {
            append = 0;
        }
        if (typeof frm == undefined || frm == null) {
            frm = document.frmProductSearchPaging;
        }

        data = fcom.frmData(frm);
        $(dv).prepend(fcom.getLoader());

        fcom.ajax(fcom.makeUrl("Account", "searchFavouriteListItems"), data,
            function (ans) {
                fcom.removeLoader();
                ans = $.parseJSON(ans);
                $.ykmsg.close();
                let toolbar = $(ans.html).find('.card-toolbar').html();
                $(dv).replaceWith(ans.html);
                $(dv).find('.card-toolbar').remove();
                $('#headerToolbar').html(toolbar);
            }
        );
    };

    searchWishListItems = function (uwlist_id, append, page) {
        var dv2 = "#favListItems";
        append = (typeof append == "undefined") ? 0 : append;
        page = (typeof page == "undefined") ? 0 : page;

        $(dv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl("Account", "searchWishListItems"), "uwlist_id=" + uwlist_id + "&page=" + page,
            function (ans) {
                fcom.removeLoader();
                ans = $.parseJSON(ans);
                let toolbar = $(ans.html).find('.card-toolbar').html();
                $(dv).replaceWith(ans.html);
                $(dv).find('.card-toolbar').remove();
                $('#headerToolbar').html(toolbar);
            }
        );
    };

    goToProductListingSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var uwlist_id = $("input[name='uwlist_id']").val();
        searchWishListItems(uwlist_id, 0, page);
        $(".selectAll-js").prop("checked", false);
        $(".formActionBtn-js").addClass("disabled");
    };

    goToFavouriteListingSearchPage = function (page) {
        if (typeof page == "undefined" || page == null) {
            page = 1;
        }
        var frm = document.frmProductSearchPaging;
        $(frm.page).val(page);

        searchFavouriteListItems(frm, 0, page);
    };

    searchFavoriteShop = function (frm) {
        if (typeof frm == undefined || frm == null) {
            frm = document.frmFavShopSearchPaging;
        }
        $('.actionBtnsSectionJs').hide();
        data = fcom.frmData(frm);
        $(dv).prepend(fcom.getLoader());
        fcom.ajax(
            fcom.makeUrl("Account", "favoriteShopSearch"),
            data,
            function (res) {
                fcom.removeLoader();
                $('.navLinkJs.active').removeClass('active');
                $('.navLinkJs.favtShopsJs').addClass('active');
                $(dv).html(res);
                $('#headerToolbar').html('');
            }
        );
    };

    goToFavoriteShopSearchPage = function (page) {
        if (typeof page == undefined || page == null) {
            page = 1;
        }
        var frm = document.frmFavShopSearchPaging;
        $(frm.page).val(page);
        searchFavoriteShop(frm);
    };

    toggleShopFavorite2 = function (shop_id) {
        toggleShopFavorite(shop_id);
        searchFavoriteShop();
    };

    selectAll = function (obj) {
        $(".selectItem--js").each(function () {
            if (obj.prop("checked") == false) {
                $(this).prop("checked", false);
            } else {
                $(this).prop("checked", true);
            }
        });
        showFormActionsBtns();
    };

    removeFromWishlist = function (selprod_id, wish_list_id, event) {
        if (!confirm(langLbl.confirmDelete)) {
            return false;
        }
        addRemoveWishListProduct(selprod_id, wish_list_id, event);
        searchWishList();
    };

    removeSelectedFromWishlist = function (wish_list_id, event) {
        event.stopPropagation();
        if (!confirm(langLbl.confirmDelete)) {
            return false;
        }
        updateWishlist();
        searchWishList();
    };

    removeSelectedFromFavtlist = function (event, moveToCart = false) {
        event.stopPropagation();
        if (false === moveToCart) {
            if (!confirm(langLbl.confirmDelete)) {
                return false;
            }
        }
        if (0 < $("#wishlistForm").length) {
            var data = $("#wishlistForm").serialize();
        } else {
            var data = $("#favtlistForm").serialize();
        }
        fcom.updateWithAjax(
            fcom.makeUrl("Account", "removeFromFavoriteArr"),
            data,
            function (ans) {
                if (false === moveToCart) {
                    searchFavouriteListItems();
                    if (ans.status) {
                        fcom.displaySuccessMessage(ans.msg);
                    }
                }
            }
        );
    };

    updateWishlist = function () {
        if (0 < $("#wishlistForm").length) {
            var data = $("#wishlistForm").serialize();
        } else {
            var data = $("#favtlistForm").serialize();
        }
        fcom.updateWithAjax(
            fcom.makeUrl("Account", "addRemoveWishListProductArr"),
            data,
            function (ans) {
                if (ans.status) {
                    fcom.displaySuccessMessage(ans.msg);
                }
            }
        );
    };

    addToCart = function (obj, event, isWishlist = 0) {
        event.stopPropagation();

        $("#favListItems .selectItem--js").each(function () {
            $(this).prop("checked", false);
        });

        obj.parent().siblings("li").find(".selectItem--js").prop("checked", true);

        addSelectedToCart(event, isWishlist);
    };

    addSelectedToCart = function (event, isWishlist) {
        event.stopPropagation();
        fcom.displayProcessing();
        if (0 < $("#wishlistForm").length) {
            var data = $("#wishlistForm").serialize();
        } else {
            var data = $("#favtlistForm").serialize();
        }
        fcom.updateWithAjax(
            fcom.makeUrl("cart", "addSelectedToCart", [], siteConstants.webrootfront),
            data,
            function (ans) {
                if (0 < isWishlist) {
                    updateWishlist();
                } else {
                    removeSelectedFromFavtlist(event, true);
                }
                setTimeout(function () {
                    location.href = fcom.makeUrl(
                        "cart",
                        "",
                        [],
                        siteConstants.webrootfront
                    );
                }, 1000);
            }
        );
    };
})();
