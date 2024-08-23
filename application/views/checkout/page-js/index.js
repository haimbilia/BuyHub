var pageContent = ".checkout-content-js";

var loginDiv = "#login-register";
var addressDiv = "#address";
var addressFormDiv = "#addressFormDiv";
var addressDivFooter = "#addressDivFooter";
var addressWrapper = "#addressWrapper";
var addressWrapperContainer = ".address-wrapper";
var alreadyLoginDiv = "#alreadyLoginDiv";
var shippingSummaryDiv = "#shipping-summary";
var cartReviewDiv = "#cart-review";
var paymentDiv = "#payment";
var financialSummary = ".summary-listing-js";
var reviewSection = ".review-section-js";

var paymentSummaryAjax = 0;
var financialSummaryAjax = 0;

async function checkLogin() {
    let ans = await $.ajax({
        url: fcom.makeUrl("GuestUser", "checkAjaxUserLoggedIn"),
        dataType: "json",
    });

    if (parseInt(ans.isUserLogged) == 0) {
        loginPopUpBox();
        return false;
    }
    return true;
}

function showLoginDiv() {
    $(".step").removeClass("is-current");
    $(loginDiv).find(".step__body").show();
    $(loginDiv).find(".step__body").html(fcom.getLoader());
    fcom.ajax(fcom.makeUrl("Checkout", "login"), "", function (ans) {
        $(loginDiv).find(".step__body").html(ans);
        $(loginDiv).addClass("is-current");
    });
}

function editCart() {
    if (!checkLogin()) {
        return false;
    }
    $(".js-editCart").toggle();
}

function showAddressFormDiv(address_type) {
    if (typeof address_type == "undefined") {
        address_type = 0;
    }
    editAddress(0, address_type);
    if ($(".payment-js").hasClass("is-active") == false) {
        setCheckoutFlow("BILLING");
    }
}

function showAddressList() {
    loadAddressDiv();
    setCheckoutFlow("BILLING");
}

function showShippingSummaryDiv() {
    return loadShippingSummaryDiv();
}

$("document").ready(function () {
    $(document).on("keydown", "#cc_number", function () {
        var obj = $(this);
        var cc = obj.val();
        obj.attr("class", "p-cards");
        if (cc != "") {
            var card_type = getCardType(cc).toLowerCase();
            obj.addClass("p-cards " + card_type);
        }
    });
});

(function () {
    setUpLogin = function (frm, v) {
        v.validate();
        if (!v.isValid()) return;
        fcom.ajax(
            fcom.makeUrl("GuestUser", "login"),
            fcom.frmData(frm),
            function (t) {
                var ans = JSON.parse(t);
                if (ans.status == 1) {
                    fcom.displaySuccessMessage(ans.msg);
                    location.href = ans.redirectUrl;
                    return;
                }
                fcom.displayErrorMessage(ans.msg);
            }
        );
        return false;
    };

    loadloginDiv = function () {
        fcom.ajax(fcom.makeUrl("Checkout", "loadLoginDiv"), "", function (ans) {
            $(loginDiv).html(ans);
        });
    };

    loadFinancialSummary = function (isShippingSelected) {
        isShippingSelected = ('undefined' == typeof isShippingSelected ? 0 : isShippingSelected);
        if (1 > $(financialSummary + ' .skeleton').length) {
            $(financialSummary).prepend(fcom.getLoader(true));
        }
        financialSummaryAjax = 1;
        fcom.updateWithAjax(fcom.makeUrl("Checkout", "getFinancialSummary", [isShippingSelected]), "",
            function (ans) {
                $(financialSummary).hide().html(ans.html).fadeIn();
                $("#netAmountSummary").hide().html(ans.netAmount).fadeIn();
                if (0 == paymentSummaryAjax) {
                    fcom.removeLoader();
                }
            }
        );
    };

    setUpRegisteration = function (frm, v) {
        v.validate();
        if (!v.isValid()) return;
        fcom.updateWithAjax(
            fcom.makeUrl("GuestUser", "register"),
            fcom.frmData(frm),
            function (t) {
                if (t.status == 1) {
                    if (t.needLogin) {
                        window.location.href = t.redirectUrl;
                        return;
                    } else {
                        loadAddressDiv();
                    }
                }
            }
        );
    };

    removeAddress = function (id, address_type) {
        if (!checkLogin()) {
            return false;
        }
        var agree = confirm(langLbl.confirmDelete);
        if (!agree) {
            return false;
        }
        if (typeof address_type == "undefined") {
            address_type = 0;
        }
        data = "id=" + id;
        fcom.updateWithAjax(
            fcom.makeUrl(
                "Addresses",
                "deleteRecord",
                [],
                siteConstants.webroot_dashboard
            ),
            data,
            function (res) {
                loadAddressDiv(address_type);
            }
        );
    };

    editAddress = function (address_id, address_type) {
        if (typeof address_id == "undefined") {
            address_id = 0;
        }
        if (typeof address_type == "undefined") {
            address_type = 0;
        }

        $.ykmodal(fcom.getLoader());
        var data = "address_id=" + address_id + "&address_type=" + address_type;
        fcom.ajax(fcom.makeUrl("Checkout", "editAddress"), data, function (ans) {
            fcom.removeLoader();
            $.ykmodal(ans);
            if ($(".payment-js").hasClass("is-active") == false) {
                setCheckoutFlow("BILLING");
            }
        });
    };

    setUpAddress = function (frm, address_type) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);

        $.ykmodal(fcom.getLoader());
        fcom.updateWithAjax(
            fcom.makeUrl(
                "Addresses",
                "setUpAddress",
                [],
                siteConstants.webroot_dashboard
            ),
            data,
            function (t) {
                fcom.closeProcessing();
                fcom.removeLoader();
                if (t.status == 1) {
                    if ($("#hasAddress").length > 0) {
                        $("#hasAddress").val(1);
                    }

                    if (address_type == 1) {
                        if ($(frm.addr_id).val() != 0 && $(frm.shipping_addr_id).val() == $(frm.addr_id).val()) {
                            setUpAddressSelection(t.addr_id);
                            $.ykmodal.close();
                        } else {
                            loadAddressDiv(address_type);
                            setTimeout(function () {
                                setDefaultAddress(t.addr_id);
                                setUpBillingAddressSelection();
                                $.ykmodal.close();
                            }, 1000);
                        }
                    } else {
                        showShippingSummaryDiv(t.addr_id);
                        setUpAddressSelection(t.addr_id);
                        $.ykmodal.close();
                    }

                }
            }
        );
    };

    setDefaultAddress = function (id) {
        $("input[name='shipping_address_id']").each(function () {
            $(this).removeAttr("checked");
        });
        $(".s-" + id + " input[name=shipping_address_id]").attr(
            "checked",
            "checked"
        );
    };

    setUpAddressSelection = function (addr_id) {
        if (typeof addr_id == "undefined") {
            var shipping_address_id = $('input[name="shipping_address_id"]:checked').val();
        } else {
            var shipping_address_id = addr_id;
        }
        var data = "shipping_address_id=" + shipping_address_id + "&billing_address_id=" + shipping_address_id + "&isShippingSameAsBilling=1";
        $.ykmodal(fcom.getLoader());
        fcom.updateWithAjax(
            fcom.makeUrl("Checkout", "setUpAddressSelection"),
            data,
            function (t) {
                if (t.status == 1) {
                    if (t.loadAddressDiv) {
                        loadAddressDiv();
                    } else {
                        if (t.hasPhysicalProduct) {
                            $(shippingSummaryDiv).show();
                        } else {
                            $(shippingSummaryDiv).hide();
                            loadShippingAddress();
                        }
                        loadShippingSummaryDiv();
                        loadFinancialSummary();
                        $.ykmodal.close();
                    }
                }
            }
        );
    };

    setUpShippingApi = function (frm) {
        if (!checkLogin()) {
            return false;
        }
        var data = fcom.frmData(frm);
        $(shippingSummaryDiv).html(fcom.getLoader());
        fcom.ajax(
            fcom.makeUrl("Checkout", "setUpShippingApi"),
            data,
            function (ans) {
                $(shippingSummaryDiv).html(ans);
                /* fcom.scrollToTop("#shipping-summary"); */
                $(".sduration_id-Js").trigger("change");
            }
        );
    };

    getProductShippingComment = function (el, selprod_id) {
        var sduration_id = $(el).find(":selected").val();
        $(".shipping_comment_" + selprod_id).hide();
        $("#shipping_comment_" + selprod_id + "_" + sduration_id).show();
    };

    getProductShippingGroupComment = function (el, prodgroup_id) {
        var sduration_id = $(el).find(":selected").val();
        $(".shipping_group_comment_" + prodgroup_id).hide();
        $("#shipping_group_comment_" + prodgroup_id + "_" + sduration_id).show();
    };

    setUpShippingMethod = function () {
        $(shippingSummaryDiv).prepend(fcom.getLoader());
        $(financialSummary).prepend(fcom.getLoader(true));
        var data = $("#shipping-summary select").serialize();
        fcom.updateWithAjax(
            fcom.makeUrl("Checkout", "setUpShippingMethod"),
            data,
            function (t) {
                financialSummaryAjax = paymentSummaryAjax = 1;
                loadPaymentSummary();
                loadFinancialSummary(1);
                setCheckoutFlow("PAYMENT");
            }
        );
    };

    loadAddressDiv = function (address_type) {
        if (typeof address_type == "undefined") {
            address_type = 0;
        }
        $.ykmodal(fcom.getLoader());
        fcom.displayProcessing();
        var data = "address_type=" + address_type;
        fcom.ajax(fcom.makeUrl("Checkout", "addresses"), data, function (ans) {
            fcom.removeLoader();
            fcom.closeProcessing();
            $.ykmodal(ans);
            setCheckoutFlow("BILLING");
        });
    };

    loadShippingAddress = function () {
        fcom.ajax(
            fcom.makeUrl("Checkout", "loadBillingShippingAddress"),
            "",
            function (t) {
                $(addressDiv).html(t);
                /* fcom.scrollToTop("#alreadyLoginDiv"); */
            }
        );
    };

    resetShippingSummary = function () {
        resetCartReview();
        fcom.ajax(
            fcom.makeUrl("Checkout", "resetShippingSummary"),
            "",
            function (ans) {
                $(shippingSummaryDiv).html(ans);
            }
        );
    };

    removeShippingSummary = function () {
        resetCartReview();
        fcom.ajax(
            fcom.makeUrl("Checkout", "removeShippingSummary"),
            "",
            function (ans) { }
        );
    };

    resetCartReview = function () {
        fcom.ajax(fcom.makeUrl("Checkout", "resetCartReview"), "", function (ans) {
            $(cartReviewDiv).html(ans);
        });
    };

    loadShippingSummary = function () {
        $(shippingSummaryDiv).show();
        $(shippingSummaryDiv).html(fcom.getLoader());

        fcom.ajax(
            fcom.makeUrl("Checkout", "loadShippingSummary"),
            "",
            function (ans) {
                $(shippingSummaryDiv).html(ans);
                /* fcom.scrollToTop("#shipping-summary"); */
            }
        );
    };

    changeShipping = function () {
        if (!checkLogin()) {
            return false;
        }
        loadShippingSummaryDiv();
        resetCartReview();
        resetPaymentSummary();
    };

    loadShippingSummaryDiv = function (reloadFinancialSummary) {
        if (1 > $(pageContent + ' .skeleton').length) {
            $(pageContent).prepend(fcom.getLoader());
        }
        reloadFinancialSummary = ('undefined' == typeof reloadFinancialSummary ? false : reloadFinancialSummary)
        fcom.ajax(fcom.makeUrl("Checkout", "shippingSummary"), "", function (ans) {
            fcom.removeLoader();
            $(pageContent).hide().html(ans).fadeIn();
            $(".sduration_id-Js").trigger("change");
            setCheckoutFlow("SHIPPING");
            if (reloadFinancialSummary) {
                loadFinancialSummary();
            }
        });
    };

    resetPaymentSummary = function () {
        $(paymentDiv).removeClass("is-current");
        fcom.ajax(
            fcom.makeUrl("Checkout", "resetPaymentSummary"),
            "",
            function (ans) {
                $(paymentDiv).html(ans);
            }
        );
    };

    /* Not In Use. */
    viewOrder = function () {
        if (!checkLogin()) {
            return false;
        }
        resetPaymentSummary();
        loadShippingSummary();
        loadCartReviewDiv();
    };

    /* Not In Use. */
    loadCartReviewDiv = function () {
        $(pageContent).html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl("Checkout", "reviewCart"), "", function (ans) {
            $(pageContent).html(ans);
        });
    };

    /* Not In Use. */
    loadCartReview = function () {
        $(reviewSection).show().prepend(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl("Checkout", "loadCartReview"), "", function (ans) {
            fcom.removeLoader();
            $(reviewSection).html(ans.html);
        });
    };

    loadPaymentSummary = function () {
        paymentSummaryAjax = 1;
        $(pageContent).prepend(fcom.getLoader(true));
        fcom.ajax(
            fcom.makeUrl("Checkout", "PaymentSummary"),
            '',
            function (res) {
                if (1 > res.status) {
                    loadShippingSummaryDiv();
                    loadFinancialSummary();
                    fcom.displayErrorMessage(res.msg);
                    return;
                }

                paymentSummaryAjax = 0;
                if ('' == res.html) {
                    $('.checkoutPageJs').hide();
                    setTimeout(() => {
                        $('.checkoutPageJs').addClass('checkout-page-single').fadeIn();
                    }, 200);
                } else {
                    $(pageContent).hide().html(res.html).fadeIn();
                    $(paymentDiv).addClass("is-current");
                }

                if (0 == financialSummaryAjax) {
                    fcom.removeLoader();
                }
            }, { 'fOutMode': 'json' }
        );
    };

    walletSelection = function (el) {
        var wallet = $(el).is(":checked") ? 1 : 0;
        var data = "payFromWallet=" + wallet;

        $(shippingSummaryDiv).prepend(fcom.getLoader());
        $(financialSummary).prepend(fcom.getLoader(true));
        fcom.updateWithAjax(
            fcom.makeUrl("Checkout", "walletSelection"),
            data,
            function (ans) {
                financialSummaryAjax = paymentSummaryAjax = 1;
                loadFinancialSummary(1);
                loadPaymentSummary();
            }
        );
    };

    useRewardPoints = function (frm) {
        if (!$(frm).validate()) return;
        $(financialSummary).prepend(fcom.getLoader());
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(
            fcom.makeUrl("Checkout", "useRewardPoints"),
            data,
            function (res) {
                loadFinancialSummary(1);
                loadPaymentSummary();
            }
        );
    };

    removeRewardPoints = function () {
        checkLogin();
        fcom.updateWithAjax(
            fcom.makeUrl("Checkout", "removeRewardPoints"),
            "",
            function (res) {
                fcom.closeProcessing();
                loadFinancialSummary(1);
                loadPaymentSummary();
            }
        );
    };

    resetCheckoutDiv = function () {
        removeShippingSummary();
        resetPaymentSummary();
        loadShippingSummaryDiv();
    };

    setCheckoutFlow = function (type) {
        var obj = $(".checkout-progress");
        obj.find(".checkoutNav-js").removeClass("is-complete");
        obj.find(".checkoutNav-js").removeClass("is-active");
        obj.find(".checkoutNav-js").removeClass("pending");
        if (obj.find(".shipping-js")) {
            obj.find(".shipping-js").attr("onclick", "loadShippingSummaryDiv(1)");
        }
        switch (type) {
            case "BILLING":
                obj.find(".billing-js").addClass("is-active");
                obj.find(".shipping-js").addClass("pending");
                obj.find(".payment-js").addClass("pending");
                if (obj.find(".shipping-js")) {
                    obj.find(".shipping-js").removeAttr("onclick");
                }
                obj.find(".order-complete-js").addClass("pending");
                break;
            case "SHIPPING":
                obj.find(".billing-js").addClass("is-complete");
                obj.find(".shipping-js").addClass("is-active");
                obj.find(".payment-js").addClass("pending");
                obj.find(".order-complete-js").addClass("pending");
                break;
            case "PAYMENT":
                obj.find(".billing-js").addClass("is-complete");
                obj.find(".shipping-js").addClass("is-complete");
                obj.find(".payment-js").addClass("is-active");
                obj.find(".order-complete-js").addClass("pending");
                break;
            case "COMPLETED":
                obj.find(".billing-js").addClass("is-complete");
                obj.find(".shipping-js").addClass("is-complete");
                obj.find(".payment-js").addClass("is-complete");
                obj.find(".order-complete-js").addClass("pending");
                break;
            default:
                obj.find("li").addClass("pending");
        }
    };

    sendPayment = function (frm, dv = "") {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        var action = $(frm).attr("action");
        var submitBtn = $("input[type=submit]", frm);
        var btnText = submitBtn.val();
        submitBtn.attr("disabled", "disabled");
        submitBtn.val(submitBtn.data("processing-text"));
        fcom.displayProcessing();
        $(pageContent).prepend(fcom.getLoader(true));
        fcom.ajax(action, data, function (t) {
            submitBtn.val(btnText);
            try {
                var json = $.parseJSON(t);
                if (typeof json.status != "undefined" && 1 > json.status) {
                    submitBtn.removeAttr("disabled");
                    fcom.displayErrorMessage(json.msg);
                    return false;
                }

                if (typeof json.html != "undefined") {
                    $(dv).append(json.html);
                }

                if (json["redirect"]) {
                    $(location).attr("href", json["redirect"]);
                }
            } catch (e) {
                $(dv).append(t);
            }
        });
    };

    displayPickupAddress = function (pickUpBy, recordId) {
        fcom.displayProcessing();
        var addrId = $(".js-slot-addr-" + pickUpBy).attr("data-addr-id");
        var slotId = $("input[name='slot_id[" + pickUpBy + "]']").val();
        var slotDate = $("input[name='slot_date[" + pickUpBy + "]']").val();
        var data =
            "pickUpBy=" +
            pickUpBy +
            "&recordId=" +
            recordId +
            "&addrId=" +
            addrId +
            "&slotId=" +
            slotId +
            "&slotDate=" +
            slotDate;
        fcom.ajax(
            fcom.makeUrl(
                "Addresses",
                "getPickupAddresses",
                [],
                siteConstants.webroot_dashboard
            ),
            data,
            function (rsp) {
                $.ykmsg.close();
                $.ykmodal(rsp, true, 'modal-dialog-vertical-md');
                $("input[name='coupon_code']").focus();
            }
        );
    };

    setUpPickup = function () {
        if (!checkLogin()) {
            return false;
        }

        var slotIds = $(".js-slot-id").serialize();
        var slotDates = $(".js-slot-date").serialize();
        var data = slotIds + "&" + slotDates;
        fcom.updateWithAjax(
            fcom.makeUrl("Checkout", "setUpPickUp"),
            data,
            function (t) {
                loadFinancialSummary(1);
                loadPaymentSummary();
                setCheckoutFlow("PAYMENT");
            }
        );
    };

    setUpBillingAddressSelection = function () {
        var billing_address_id = $('input[name="shipping_address_id"]:checked').val();
        var data = "billing_address_id=" + billing_address_id + "&isShippingSameAsBilling=0";
        fcom.updateWithAjax(
            fcom.makeUrl("Checkout", "setUpBillingAddressSelection"), data,
            function (t) {
                loadFinancialSummary(1);
                loadPaymentSummary();
                setCheckoutFlow("PAYMENT");
                $.ykmodal.close();
            }
        );
    };

    /* Phone/Email Verification for COD */
    validateOtp = function (frm) {
        if (!$(frm).validate()) return;
        var data = fcom.frmData(frm);
        var method = $(frm).data("method");
        var orderId = $(frm).find('input[name="order_id"]').val();
        fcom.displayProcessing();
        $(paymentDiv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl("Checkout", "validateOtp"), data, function (t) {
            fcom.closeProcessing();
            fcom.removeLoader();
            t = $.parseJSON(t);
            if (1 == t.status) {
                if ("undefined" != typeof method) {
                    $(frm).attr(
                        "action",
                        fcom.makeUrl(method + "Pay", "charge", [orderId])
                    );
                }
                fcom.displaySuccessMessage(t.msg);
                $(".successOtp-js").removeClass("d-none");
                $(".otpBlock-js").addClass("d-none");
                confirmOrder(frm);
            } else {
                fcom.displayErrorMessage(t.msg);
                invalidOtpField();
            }
        });
        return false;
    };

    resendOtp = function (frm = "") {
        fcom.displayProcessing();
        $('input[name="btn_submit"]', frm).val(langLbl.processing);
        fcom.ajax(fcom.makeUrl("Checkout", "resendOtp"), "", function (t) {
            t = $.parseJSON(t);
            if (typeof t.status != "undefined" && 1 > t.status) {
                fcom.displayErrorMessage(t.msg);
                return false;
            }
            $(".otpVal-js").val("");
            $('#codCodeSentOnInfo').removeClass('d-none');
            if ("" != frm) {
                $(frm).attr("onsubmit", "validateOtp(this); return(false);");
                $('input[name="btn_submit"]', frm).val(langLbl.proceed);
                $(".otpVal-js").removeAttr("disabled");
            }
            fcom.displaySuccessMessage(t.msg);
            startOtpInterval("", "showElements");
            $(".resendOtpDiv-js").addClass("d-none");
        });
        return false;
    };
    /* Phone/Email Verification for COD */

    orderPickUpData = function (order_id) {
        var data = "order_id=" + order_id;
        fcom.ajax(
            fcom.makeUrl("Checkout", "orderPickUpData"),
            data,
            function (rsp) {
                $.facebox(rsp);
            }
        );
    };

    goToBack = function () {
        if ($(".payment-js").hasClass("is-active")) {
            loadPaymentSummary();
        } else {
            window.location.href = fcom.makeUrl("Cart");
        }
    };

    orderShippingData = function (order_id) {
        fcom.displayProcessing();
        var data = "order_id=" + order_id;
        fcom.ajax(fcom.makeUrl("Checkout", "orderShippingData"), data,
            function (rsp) {
                $.ykmsg.close();
                $.facebox(rsp);
            }
        );
    };

    scrollToFinancialSummary = function () {
        $('html, body').animate({
            scrollTop: $(financialSummary).offset().top
        }, 'slow');
    }

    $(document).on('click', '.addrListJs', function () {
        $('.addrListJs').removeClass('is-active');
        $(this).addClass('is-active');
    });

    $(document).on('keydown', '#cc_number', function () {
        $(this).addClass(getCardType($(this).val()).toLowerCase());
    });
})();
