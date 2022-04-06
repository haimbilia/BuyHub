var loginDiv = '#login';
var sCartReviewDiv = '.checkout-content-js';
var paymentDiv = '.checkout-content-js';
var financialSummary = '.summary-listing-js';

$(function () {
    loadPaymentSummary();
});

(function () {
    loadPaymentSummary = function () {
        $(paymentDiv).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('SubscriptionCheckout', 'PaymentSummary'), '', function (ans) {
            fcom.removeLoader();
            $(paymentDiv).html(ans);
            $(paymentDiv).addClass("is-current");
            setCheckoutFlow('PAYMENT');
            loadFinancialSummary();
        });
    };

    loadFinancialSummary = function () {
        $(financialSummary).prepend(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('SubscriptionCheckout', 'getFinancialSummary'), '', function (ans) {
            fcom.removeLoader();
            $(financialSummary).html(ans);
        });
    }

    walletSelection = function (el) {
        var wallet = ($(el).is(":checked")) ? 1 : 0;
        var data = 'payFromWallet=' + wallet;
        fcom.updateWithAjax(fcom.makeUrl('SubscriptionCheckout', 'walletSelection'), data, function (ans) {
            loadPaymentSummary();
        });
    };
    
    getPromoCode = function () {
        fcom.displayProcessing();
        if (isUserLogged() == 0) {
            loginPopUpBox();
            return false;
        }
        fcom.ajax(fcom.makeUrl('SubscriptionCheckout', 'getCouponForm'), '', function (t) {
            $.ykmsg.close();
            $.ykmodal(t);
            $("input[name='coupon_code']").focus();
        });
    };

    triggerApplyCoupon = function (coupon_code) {
        $(".couponCodeJs").val(coupon_code);
        applyPromoCode($("#checkoutCouponForm").get(0));
        return false;
    };

    applyPromoCode = function (frm) {
        if (!$(frm).validate()) { return; }
        if ('undefined' == typeof frm.coupon_code.value || '' == frm.coupon_code.value) { return; }
        var data = fcom.frmData(frm);
        fcom.updateWithAjax(fcom.makeUrl('SubscriptionCheckout', 'applyPromoCode'), data, function (res) {
            $.ykmodal.close();
            loadPaymentSummary();
        });
    };

    removePromoCode = function () {
        fcom.updateWithAjax(fcom.makeUrl('SubscriptionCheckout', 'removePromoCode'), '', function (res) {
            $.ykmodal.close();
            loadPaymentSummary();
        });
    };

    setCheckoutFlow = function (type) {
        var obj = $('.checkout-progress');
        obj.find('div').removeClass('is-complete');
        obj.find('div').removeClass('is-active');
        obj.find('div').removeClass('pending');
        switch (type) {
            case 'BILLING':
                obj.find('.billing-js').addClass('is-active');
                obj.find('.shipping-js').addClass('pending');
                obj.find('.payment-js').addClass('pending');
                obj.find('.order-complete-js').addClass('pending');
                break;
            case 'PAYMENT':
                obj.find('.billing-js').addClass('is-complete');
                obj.find('.shipping-js').addClass('is-complete');
                obj.find('.payment-js').addClass('is-active');
                obj.find('.order-complete-js').addClass('pending');
                break;
            case 'COMPLETED':
                obj.find('.billing-js').addClass('is-complete');
                obj.find('.shipping-js').addClass('is-complete');
                obj.find('.payment-js').addClass('is-complete');
                obj.find('.order-complete-js').addClass('pending');
                break;
            default:
                obj.find('li').addClass('pending');
        }
    };

    sendPayment = function (frm, dv = '') {
        var data = fcom.frmData(frm);
        var action = $(frm).attr('action');
        $("#payment").prepend(fcom.getLoader());
        fcom.ajax(action, data, function (t) {
            // debugger;
            try {
                var json = $.parseJSON(t);
                if (typeof json.status != 'undefined' && 1 > json.status) {
                    fcom.removeLoader();
                    $('input[type="submit"]').removeAttr('disabled');
                    fcom.displayErrorMessage(json.msg);
                    return false;
                }
                if (typeof json.html != 'undefined') {
                    $('input[type="submit"]').removeAttr('disabled');
                    fcom.removeLoader();
                    $(dv).append(json.html);
                }
                if (json['redirect']) {
                    $(location).attr("href", json['redirect']);
                }
            } catch (e) {
                $('input[type="submit"]').removeAttr('disabled');
                fcom.removeLoader();
                $(dv).append(t);
            }
        });
    };
})();