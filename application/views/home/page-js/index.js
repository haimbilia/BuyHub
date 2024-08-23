$(function () {
    $('.js-hero-slider').slick({
        rtl: ('rtl' == langLbl.layoutDirection),
        autoplay: true,
        autoplaySpeed: 8000,
        draggable: true,
        arrows: false,
        dots: true,
        fade: true,
        speed: 900,
        infinite: true,
        cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
        touchThreshold: 100
    });
});
resendOtp = function (userId, getOtpOnly = 0) {
    fcom.displayProcessing();
    fcom.ajax(fcom.makeUrl('GuestUser', 'resendOtp', [userId, getOtpOnly]), '', function (t) {
        t = $.parseJSON(t);
        if (1 > t.status) {
            fcom.displayErrorMessage(t.msg);
            return false;
        }
        fcom.displaySuccessMessage(t.msg);
        startOtpInterval();
    });
    return false;
};

validateOtp = function (frm) {
    if (!$(frm).validate()) return;
    var data = fcom.frmData(frm);
    fcom.ajax(fcom.makeUrl('GuestUser', 'validateOtp'), data, function (t) {
        t = $.parseJSON(t);
        if (1 == t.status) {
            window.location.href = t.redirectUrl;
        } else {
            fcom.displayErrorMessage(t.msg);
            invalidOtpField();
        }
    });
    return false;
};