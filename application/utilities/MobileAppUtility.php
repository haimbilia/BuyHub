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

}
