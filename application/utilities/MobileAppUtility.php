<?php

class MobileAppUtility
{

    const STATUS_SUCCESS = 1;
    const STATUS_ERROR = 0;
    const STATUS_SESSION_OUT = -1;
    const APP_REQUEST_TYPE_DELIVERY_APP = 0;
    const APP_REQUEST_TYPE_BUYER = 1;

    public static function response($status, $msg, $data = array(), $errorCode = null, $errorDetail = array())
    {
        if (true === MOBILE_APP_API_CALL) {
            if (0 < count($data)) {
                $responseArr = $data;
            }

            $responseArr['status'] = $status;
            $responseArr['msg'] = $msg;

            if (null !== $errorCode) {
                $responseArr['error']['error_detail'] = $errorDetail;
                $responseArr['errorcode'] = $errorCode;
            }
            $responseArr = Common::convertDataTypeToString($responseArr);
            header('Content-type: text/json');
            self::convertToJson($responseArr);
        }
    }

    public static function convertToJson($data, $options = 0)
    {
        array_walk_recursive($data, function(&$value, $key) {
            if (is_string($value)) {
                $value = html_entity_decode($value);
            }
        });
        die(FatUtility::convertToJson($data, $options));
    }

    /*
     * 	Function For APIs | function to remove null values and convert data into json form
     */
    public static function dieWithJsonData($status, $data, $convertToString = false)
    {
        $msg = $data['msg'];
        unset($data['msg']);
        return static::response($status, $msg, $data);
    }

    public static function getPublicApiRequestsList()
    {
        return array(
            'guest-user/login',
            'google-login/index',
            'facebook-login/index',
            'apple-login/index',
            'guest-user/register',
            'guest-user/forgot-password',
            'guest-user/guest-login',
            'guest-user/app-version',
            'guest-user/resend-verification',
            'shops/search',
            'home/index',
            'products/filters',
            'shops/view',
            'shops/products',
            'products/view',
            'geo-location/set-up-user-location',
            'products/show-shop-delivery-dates-and-slots',
            'shops/get-autosuggest-products',
            'brands/index',
            'guest-user/login-with-otp',
            'whatsapp-notification/send-otp',
            'reviews/search-for-shop',
            'products/search',
            'brands/view',
            'custom/contact-submit',
            'category/view',
            'products/get-option-detail',
            'products/sellers',
            'cart/add',
            'cart/listing',
            'cart/remove',
            'cart/update',
            'category/index',
            'mobile-app-api/report_shop_spam_reasons',
            'mobile-app-api/countries',
            'mobile-app-api/get_states',
            'mobile-app-api/get-cities',
            'mobile-app-api/send_to_web',
            'mobile-app-api/buyer_order_cancellation_reasons',
            'mobile-app-api/get-return-request-status',
            'mobile-app-api/product_reviews',
            'mobile-app-api/get-configurations',
            'mobile-app-api/languages',
            'mobile-app-api/currencies',
            'mobile-app-api/home',
            'mobile-app-api/category',
            'mobile-app-api/language_labels',
            'mobile-app-api/getConfigurations',
            'mobile-app-api/getReturnRequestStatus',
            'mobile-app-api/getCities',
            'labels/download-file',
            'checkout/get-shop-delivery-dates-and-slots',
            'guest-user/get-initial-settings',
            'guest-user/get-countries-list',
            'guest-user/delivery-staff-register',
            'mobile-app-api/set-user-push-notification-token',
            'guest-user/validate-otp',
            'guest-user/reset-password-setup',
            'guest-user/resend-otp',
            'home/set-language',
            'mobile-app-api/get-cms-pages-content',
            'mobile-app-api/getCmsPagesContent',
            'banner/update-impression',
            'banner/url',
            'testimonials/search',
        );
    }

}
