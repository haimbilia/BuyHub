var ykevents = {
    _validateAndTrigger: function (event, data = '') {
        if (typeof fbPixel !== 'undefined' && true == fbPixel) {
            fbq('track', event, data);
        }
    },
    addToCart: function () {
        ykevents._validateAndTrigger('AddToCart');
    },

    addToWishList: function () {
        ykevents._validateAndTrigger('AddToWishlist');
    },

    contactUs: function () {
        ykevents._validateAndTrigger('Contact');
    },

    customizeProduct: function () {
        ykevents._validateAndTrigger('CustomizeProduct');
    },

    initiateCheckout: function () {
        ykevents._validateAndTrigger('InitiateCheckout');
    },

    search: function () {
        ykevents._validateAndTrigger('search');
    },

    purchase: function (data) {
        ykevents._validateAndTrigger('Purchase', data);
    },

    /* 
        A visit to a web page you care about. For example, a product or landing page. View content tells you if someone visits a web page's URL, but not what they do or see on that web page.
    */
    viewContent: function () {
        ykevents._validateAndTrigger('viewContent');
    },

    newsLetterSubscription: function () {
        ykevents._validateAndTrigger('CompleteRegistration');
    },

    rfqSubmitted: function () {
        ykevents._validateAndTrigger('Lead');
    },
};