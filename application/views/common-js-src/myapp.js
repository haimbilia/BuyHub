var isAjaxRunning = false;
var cart = {
    add: function (selprod_id, quantity, isRedirectToCart) {
        isRedirectToCart = (typeof (isRedirectToCart) != 'undefined') ? true : false;
        var data = 'selprod_id=' + selprod_id + '&quantity=' + (typeof (quantity) != 'undefined' ? quantity : 1);
        if (0 < $(".list-addons--js").length && typeof mainSelprodId != 'undefined' && mainSelprodId == selprod_id) {
            $(".list-addons--js").find("input").each(function (e) {
                if (($(this).val() > 0) && (!$(this).closest(".addon--js").hasClass("cancelled--js"))) {
                    data = data + '&' + $(this).attr('data-lang') + "=" + $(this).val();
                }
            });
        }

        fcom.updateWithAjax(fcom.makeUrl('Cart', 'add'), data, function (ans) {
            fcom.closeProcessing();
            fcom.removeLoader();
            if (ans['redirect']) {
                location = ans['redirect'];
            }
            fcom.displaySuccessMessage(ans.msg);

            productData = [];
            var totalCartItemsPrice = 0;
            $.each(ans.cartItems, function (key, val) {
                totalCartItemsPrice += val.theprice;
                productData.push({
                    item_id: val.selprod_id,
                    item_name: val.selprod_title,
                    discount: (val.selprod_price - val.theprice),
                    index: key,
                    item_brand: val.brand_name,
                    item_category: val.prodcat_name,
                    price: val.theprice,
                    quantity: val.addedQty
                })
            });

            ykevents.addToCart({
                currency: currencyCode,
                value: totalCartItemsPrice,
                items: productData
            });

            /* isRedirectToCart needed from product detail page */
            if (isRedirectToCart) {
                setTimeout(function () {
                    window.location = fcom.makeUrl('Checkout');
                }, 300);
            } else {
                $('span.cartQuantity').html(ans.total);
                cart.loadCartSummary();
            }

        });
    },

    remove: function (key, page, saveForLater) {
        if (confirm(langLbl.confirmRemove)) {
            var data = 'key=' + key + '&saveForLater=' + saveForLater;
            fcom.updateWithAjax(fcom.makeUrl('Cart', 'remove'), data, function (ans) {
                fcom.removeLoader();
                removedItems = [];
                var totalCartItemsPrice = 0;
                $.each(ans.cartItems, function (key, val) {
                    totalCartItemsPrice += val.theprice;
                    removedItems.push({
                        item_id: val.selprod_id,
                        item_name: val.selprod_title,
                        discount: (val.selprod_price - val.theprice),
                        index: key,
                        item_brand: val.brand_name,
                        item_category: val.prodcat_name,
                        price: val.theprice,
                        quantity: val.addedQty
                    })
                });

                ykevents.removeFromCart({
                    currency: currencyCode,
                    value: totalCartItemsPrice,
                    items: removedItems
                });

                if (page == 'checkout') {
                    if (ans.status) {
                        loadFinancialSummary();
                        resetCheckoutDiv();
                    }
                    if (ans.total == 0) {
                        window.location = fcom.makeUrl('Cart');
                    }
                }
                else if (page == 'cart') {
                    if (ans.status) {
                        listCartProducts();
                        cart.loadCartSummary();
                    }
                    if (ans.total == 0) {
                        $('.emtyCartBtn-js').hide();
                    }
                }
                else {
                    cart.loadCartSummary();
                }
                $.ykmsg.close();
            });
        }
    },

    update: function (key, loadDiv, fulfilmentType = 0) {
        if (true === isAjaxRunning) {
            return false;
        }
        isAjaxRunning = true;
        var data = 'key=' + key + '&quantity=' + $("input[name='qty_" + key + "']").val();
        fcom.ajax(fcom.makeUrl('Cart', 'update'), data, function (ans) {
            fcom.removeLoader();
            if (!ans.status) {
                fcom.displayErrorMessage(ans.msg);
                if (typeof (cart.addCallBackFn) == 'function') {
                    cart.addCallBackFn(ans);
                }
                return;
            }


            isAjaxRunning = false;
            if (ans.status) {
                if (loadDiv != undefined) {
                    $(financialSummary).prepend(fcom.getLoader(true));
                    loadFinancialSummary();
                    if (1 > $("#hasAddress").length || ($("#hasAddress").length > 0 && 0 < $("#hasAddress").val())) {
                        resetCheckoutDiv();
                    }
                } else if (0 < fulfilmentType) {
                    listCartProducts(fulfilmentType);
                } else {
                    listCartProducts();
                }
            }

        }, { fOutMode: 'json' });
    },

    updateGroup: function (prodgroup_id) {
        $.ykmsg.close();
        var data = 'prodgroup_id=' + prodgroup_id + '&quantity=' + $("input[name='qty_" + prodgroup_id + "']").val();;
        fcom.updateWithAjax(fcom.makeUrl('Cart', 'updateGroup'), data, function (ans) {
            fcom.removeLoader();
            if (ans.status) {
                listCartProducts();
            }
        });
    },

    addGroup: function (prodgroup_id, isRedirectToCart) {
        isRedirectToCart = (typeof (isRedirectToCart) != 'undefined') ? true : false;
        var data = 'prodgroup_id=' + prodgroup_id;
        fcom.updateWithAjax(fcom.makeUrl('Cart', 'addGroup'), data, function (ans) {
            fcom.removeLoader();
            setTimeout(function () {
                fcom.closeProcessing();
            }, 3000);

            $(".cart-item-counts-js").html(ans.total);
            if (isRedirectToCart) {
                setTimeout(function () {
                    window.location = fcom.makeUrl('Cart');
                }, 300);
            }
        });
    },

    removeGroup: function (prodgroup_id) {
        if (confirm(langLbl.confirmRemove)) {
            var data = 'prodgroup_id=' + prodgroup_id;
            fcom.updateWithAjax(fcom.makeUrl('Cart', 'removeGroup'), data, function (ans) {
                fcom.removeLoader();
                if (ans.status) {
                    listCartProducts();
                }
                $.ykmsg.close();
            });
        }
    },

    clear: function () {
        if (confirm(langLbl.confirmRemove)) {
            fcom.updateWithAjax(fcom.makeUrl('Cart', 'clear'), '', function (ans) {
                fcom.removeLoader();
                if (ans.status) {
                    removedItems = [];
                    var totalCartItemsPrice = 0;
                    $.each(ans.cartItems, function (key, val) {
                        totalCartItemsPrice += val.theprice;
                        removedItems.push({
                            item_id: val.selprod_id,
                            item_name: val.selprod_title,
                            discount: (val.selprod_price - val.theprice),
                            index: key,
                            item_brand: val.brand_name,
                            item_category: val.prodcat_name,
                            price: val.theprice,
                            quantity: val.addedQty
                        })
                    });

                    ykevents.removeFromCart({
                        currency: currencyCode,
                        value: totalCartItemsPrice,
                        items: removedItems
                    });

                    if (typeof listCartProducts === "function") {
                        listCartProducts();
                    }
                    $('span.cartQuantity').html(ans.total);
                    cart.loadCartSummary();
                    $('body').removeClass('side-cart--on');
                }
                $.ykmsg.close();
            });
        }
    },

    loadCartSummary: function (show = true) {
        var isOffcanvas = (0 < $("#sideCartJs.offcanvas").length);
        if (true === show && isOffcanvas) {
            $("#sideCartJs").prepend(fcom.getLoader()).offcanvas('hide');
        }

        fcom.updateWithAjax(fcom.makeUrl('Cart', 'getCartSummary'), '', function (ans) {
            if (true === show && isOffcanvas) {
                fcom.removeLoader();
                $('#cartSummaryJs').html(ans.buttonHtml);
                $('#sideCartJs').replaceWith(ans.offCanvasHtml);
                $("#sideCartJs").offcanvas('show');
            }
        });
    },
    addCallBackFn: null,
};

var ykevents = {
    /* 1: For FB, 2: For GA4. */
    _validateAndTrigger: function (requestTo, event, data = '') {
        if (1 == requestTo && 'undefined' !== typeof fbPixel && true == fbPixel) {
            fbq('track', event, data);
        }
        if (2 == requestTo && 'undefined' !== typeof gtag && '' != data) {
            gtag("event", event, data);
        }
    },

    viewItem: function (data) {
        ykevents._validateAndTrigger(2, 'view_item', data);
    },
    
    addToCart: function (data) {
        ykevents._validateAndTrigger(1, 'AddToCart');
        ykevents._validateAndTrigger(2, 'add_to_cart', data);
    },

    viewCart: function (data) {
        ykevents._validateAndTrigger(2, 'view_cart', data);
    },

    removeFromCart: function (data) {
        ykevents._validateAndTrigger(2, 'remove_from_cart', data);
    },

    addToWishList: function () {
        ykevents._validateAndTrigger(1, 'AddToWishlist');
    },

    contactUs: function () {
        ykevents._validateAndTrigger(1, 'Contact');
    },

    customizeProduct: function () {
        ykevents._validateAndTrigger(1, 'CustomizeProduct');
    },

    initiateCheckout: function (data) {
        ykevents._validateAndTrigger(1, 'InitiateCheckout');
        ykevents._validateAndTrigger(2, 'begin_checkout', data);
    },

    search: function () {
        ykevents._validateAndTrigger(1, 'search');
    },

    purchase: function (data) {
        ykevents._validateAndTrigger(1, 'Purchase', data);
        ykevents._validateAndTrigger(2, 'purchase', data);
    },

    /* 
        A visit to a web page you care about. For example, a product or landing page. View content tells you if someone visits a web page's URL, but not what they do or see on that web page.
    */
    viewContent: function () {
        ykevents._validateAndTrigger(1, 'viewContent');
    },

    newsLetterSubscription: function () {
        ykevents._validateAndTrigger(1, 'CompleteRegistration');
    },
};

/*sidebar.js */
$(document).on("click", ".resetModalFormJs", function (e) {
    if ($.ykmodal.isSideBarView()) {
        $.ykmodal(fcom.getLoader());
    }

    var onClear = $(".modalFormJs").data("onclear");
    if ('undefined' != typeof onClear) {
        eval(onClear);
    } else if (0 < $("." + $.ykmodal.element + " .navTabsJs .nav-link").length) {
        $("." + $.ykmodal.element + " .navTabsJs .nav-link.active").click();
    }
});

function hasUserAcceptedCookies() {
    return document.cookie.includes('ykPersonaliseCookies=') || document.cookie.includes('ykStatisticalCookies=');
}

function isHomePage() {
    const path = window.location.pathname.replace(/\/+$/, ''); // remove trailing slash
    return path === '' || path === '/' || path === '/index.php';
}
function isMobileDevice() {
  return /Mobi|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('firstVisitCloseBtn')) {
        const popup = document.querySelector('.firstVisitPopupContainer');
        if (popup) popup.remove();
    }
});


function showFirstVisitPopup() {
    fcom.ajax(fcom.makeUrl("Home", "firstVisitPopup"), "", function (res) {
        console.log("Popup loaded once");
        document.body.insertAdjacentHTML('beforeend', res);
    });
}


$(function () {
    if (isMobileDevice() && !hasUserAcceptedCookies() && isHomePage()) {
        showFirstVisitPopup();
    }
});

function gotoPage(controller) {
    const url = fcom.makeUrl(controller, '', null); // Skip the action, null args
    window.location.href = url;
}
