<?php

class LibHelper extends FatUtility
{
    /* Response Codes */
    public const RC_OK = 200; /* The request was successfully completed. */
    public const RC_CREATED = 201; /* A new resource was successfully created. */
    public const RC_BAD_REQUEST = 400; /* The request was invalid. */
    public const RC_UNAUTHORIZED = 401; /* The request did not include an authentication token or the authentication token was expired. */
    public const RC_FORBIDDEN = 403; /* The client did not have permission to access the requested resource.  */
    public const RC_NOT_FOUND = 404; /* The requested resource was not found.  */
    public const RC_METHOD_NOT_ALLOWED = 405; /* The HTTP method in the request was not supported by the resource. For example, the DELETE method cannot be used with the Agent API.  */
    public const RC_CONFLICT = 409; /* The request could not be completed due to a conflict. For example,  POST ContentStore Folder API cannot complete if the given file or folder name already exists in the parent location.  */
    public const RC_INTERNAL_SERVER_ERROR = 500; /* The request was not completed due to an internal error on the server side.  */
    public const RC_SERVICE_UNAVAILABLE = 503; /* The server was unavailable.  */
    /* Response Codes */

    private const ENCRYPTION_KEY = '__^%&Q@$&*!@#$%^&*^__';

    public static function dieJsonError($message)
    {
        if (true === MOBILE_APP_API_CALL) {
            $message = strip_tags($message);
        }
        header('Content-Type: application/json; charset=utf-8');
        FatUtility::dieJsonError($message);
    }

    public static function dieWithError($message, bool $withHtml = false)
    {
        if (true === $withHtml) {
            if (method_exists('HtmlHelper', 'getErrorMessageHtml')) {
                FatUtility::dieWithError(HtmlHelper::getErrorMessageHtml($message));
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }
        FatUtility::dieWithError($message);
    }

    /**
     * exitWithError
     *
     * @param  mixed $message : Can be Array as well when called from self::dieJsonResponse()
     * @param  bool $json
     * @param  bool $redirect
     * @param  array $jsonData
     * @return void
     */
    public static function exitWithError($message, $json = false, $redirect = false, $jsonData = [])
    {
        if (true === MOBILE_APP_API_CALL) {
            if (is_array($message)) {
                array_walk_recursive($message, function (&$item) {
                    $item = is_string($item) ? trim(strip_tags($item)) : $item;
                });
            } else {
                $message = strip_tags($message);
            }
            header('Content-Type: application/json; charset=utf-8');

            if (is_array($message)) {
                $jsonData += $message;
            } else {
                $jsonData += ['msg' => $message, 'status' => 0];
            }

            FatUtility::dieJsonError($jsonData);
        }

        $fOutMode = FatApp::getPostedData('fOutMode', FatUtility::VAR_STRING);
        if (true === $json || 'json' == $fOutMode) {
            header('Content-Type: application/json; charset=utf-8');
            if (is_array($message)) {
                $jsonData += $message;
            } else {
                $jsonData += ['msg' => $message, 'status' => 0];
            }
            FatUtility::dieJsonError($jsonData);
        }

        $fIsAjax = FatApp::getPostedData('fIsAjax', FatUtility::VAR_STRING);
        if (1 == $fIsAjax && 'html' == $fOutMode) {
            self::dieWithError($message, true);
        }

        if (true === $redirect) {
            Message::addErrorMessage($message);
            return;
        }

        self::dieWithError($message, true);
    }

    public static function exitWithSuccess($message, $json = false, $redirect = false)
    {
        if (true === MOBILE_APP_API_CALL) {
            if (is_array($message)) {
                array_walk_recursive($message, function (&$item) {
                    if (is_string($item)) {
                        $item = trim(strip_tags($item));
                    }
                });
            } else {
                $message = strip_tags($message);
            }
            header('Content-Type: application/json; charset=utf-8');
            FatUtility::dieJsonSuccess($message);
        }

        if (true === $json) {
            header('Content-Type: application/json; charset=utf-8');
            FatUtility::dieJsonSuccess($message);
        }

        if (true === $redirect) {
            Message::addMessage($message);
        }
    }

    public static function dieJsonSuccess($arr = [])
    {
        $arr['status'] = true;
        header('Content-Type: application/json; charset=utf-8');
        FatUtility::dieJsonSuccess($arr);
    }

    public static function getCommonReplacementVarsArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = CommonHelper::getLangId();
        }
        return array(
            '{SITE_NAME}' => FatApp::getConfig("CONF_WEBSITE_NAME_$langId"),
            '{SITE_URL}' => UrlHelper::generateFullUrl('', '', array(), CONF_WEBROOT_FRONT_URL),
        );
    }

    /**
     * This function returns the maximum files size that can be uploaded
     * in PHP
     * @returns int File size in bytes
     **/
    public static function getMaximumFileUploadSize()
    {
        return min(static::convertPHPSizeToBytes(ini_get('post_max_size')), static::convertPHPSizeToBytes(ini_get('upload_max_filesize')));
    }

    /**
     * This function transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)
     *
     * @param string $sSize
     * @return integer The value in bytes
     */
    public static function convertPHPSizeToBytes($sSize)
    {
        $sSuffix = strtoupper(substr($sSize, -1));
        if (!in_array($sSuffix, array('P', 'T', 'G', 'M', 'K'))) {
            return (int) $sSize;
        }
        $iValue = substr($sSize, 0, -1);
        switch ($sSuffix) {
            case 'P':
                $iValue *= 1024;
                // Fallthrough intended
                // no break
            case 'T':
                $iValue *= 1024;
                // Fallthrough intended
                // no break
            case 'G':
                $iValue *= 1024;
                // Fallthrough intended
                // no break
            case 'M':
                $iValue *= 1024;
                // Fallthrough intended
                // no break
            case 'K':
                $iValue *= 1024;
                break;
        }
        return (int) $iValue;
    }

    /**
     * bytesToSize
     *
     * @param  mixed $bytes
     * @return void
     */
    public static function bytesToSize($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    /**
     * verify
     *
     * @param  string $bundle
     * @param  string $key
     * @return bool
     */
    public static function verify(string $bundle, string $key): bool
    {
        return hash_equals(
            hash_hmac('sha256', mb_substr($bundle, 64, null, '8bit'), $key),
            mb_substr($bundle, 0, 64, '8bit')
        );
    }

    /**
     * getKey
     *
     * @param  int $keysize
     * @return string
     */
    public static function getKey(int $keysize = 16): string
    {
        return hash_pbkdf2('sha256', self::ENCRYPTION_KEY, 'some_token', 100000, $keysize, true);
    }

    /**
     * encrypt
     *
     * @param  string $string
     * @return string
     */
    public static function encrypt(string $string): string
    {
        $iv = random_bytes(16);
        $key = self::getKey();
        $string = openssl_encrypt($string, 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $iv);
        $result = hash_hmac('sha256', $string, $key) . $string;
        return bin2hex($iv) . bin2hex($result);
    }

    /**
     * decrypt
     *
     * @param  string $hash
     * @return string
     */
    public static function decrypt(string $hash): string
    {
        $iv = hex2bin(substr($hash, 0, 32));
        $data = hex2bin(substr($hash, 32));
        $key = self::getKey();
        if (!self::verify($data, $key)) {
            return null;
        }
        return openssl_decrypt(mb_substr($data, 64, null, '8bit'), 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $iv);
    }

    /**
     * isJson
     *
     * @param  string $string
     * @return bool
     */
    public static function isJson($string, &$error = ''): bool
    {
        json_decode($string);
        $errValue = json_last_error();

        switch ($errValue) {
            case JSON_ERROR_NONE:
                $error = Labels::getLabel('MSG_NO_ERRORS', CommonHelper::getLangId());
                break;
            case JSON_ERROR_DEPTH:
                $error = Labels::getLabel('MSG_MAXIMUM_STACK_DEPTH_EXCEEDED', CommonHelper::getLangId());
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = Labels::getLabel('MSG_UNDERFLOW_OR_THE_MODES_MISMATCH', CommonHelper::getLangId());
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = Labels::getLabel('MSG_UNEXPECTED_CONTROL_CHARACTER_FOUND', CommonHelper::getLangId());
                break;
            case JSON_ERROR_SYNTAX:
                $error = Labels::getLabel('MSG_SYNTAX_ERROR,_MALFORMED_JSON', CommonHelper::getLangId());
                break;
            case JSON_ERROR_UTF8:
                $error = Labels::getLabel('MSG_MALFORMED_UTF-8_CHARACTERS,_POSSIBLY_INCORRECTLY_ENCODED', CommonHelper::getLangId());
                break;
            default:
                $error = Labels::getLabel('MSG_UNKNOWN_ERROR', CommonHelper::getLangId());
                break;
        }
        return ($errValue == JSON_ERROR_NONE);
    }

    public static function remove_utf8_bom($text)
    {
        $bom = pack('H*', 'EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }

    public static function emailAddressMasking(string $email): string
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            list($first, $last) = explode('@', $email);
            $first = str_replace(substr($first, 1), str_repeat('*', strlen($first) - 2), $first) . substr($first, -1);
            $last = explode('.', $last);
            $last_domain = str_replace(substr($last['0'], '1'), str_repeat('*', strlen($last['0']) - 2), $last['0']) . substr($last[0], -1);
            return $first . '@' . $last_domain . '.' . $last['1'];
        }
    }

    public static function phoneNumberMasking(string $phone): string
    {
        return substr($phone, 0, 4) . str_repeat('*', (strlen($phone) - 5)) . substr($phone, -1);
    }

    /**
     * formatResponse
     *
     * @param  int $status
     * @param  string $msg
     * @param  array $data
     * @return array
     */
    public static function formatResponse(int $status, string $msg, array $data = [], $responseCode = LibHelper::RC_BAD_REQUEST): array
    {
        return [
            'status' => $status,
            'responseCode' => (applicationConstants::SUCCESS == $status) ? LibHelper::RC_OK : $responseCode,
            'msg' => $msg,
            'data' => $data
        ];
    }

    /**
     * dieJsonResponse
     *
     * @param  array $data
     * @return void
     */
    public static function dieJsonResponse(array $data = [], int $langId = 0)
    {
        $status = (int) $data['status'] ?? Plugin::RETURN_FALSE;
        $langId = 0 < $langId ? $langId : CommonHelper::getLangId();

        $msg = (0 < $status ? Labels::getLabel("MSG_SUCCESS", $langId) : Labels::getLabel("MSG_AN_UNKNOWN_ERROR_OCCURRED", $langId));
        $data['msg'] = $data['msg'] ?? $msg;

        $respData = [];
        if (array_key_exists('data', $data)) {
            $respData = empty($data['data']) && MOBILE_APP_API_CALL ? (object) [] : $data['data'];
        }
        $data['data'] = $respData;

        $isAjaxCall = (FatUtility::isAjaxCall() || MOBILE_APP_API_CALL);

        if (Plugin::RETURN_FALSE == $status) {
            LibHelper::exitWithError($data, $isAjaxCall, !$isAjaxCall);
        } else {
            LibHelper::exitWithSuccess($data, $isAjaxCall, !$isAjaxCall);
        }

        CommonHelper::redirectUserReferer();
    }

    public static function getControllerName($titleCase = false)
    {
        if (false === $titleCase) {
            return str_replace('Controller', '', FatApp::getController());
        }

        $arr = explode('-', FatUtility::camel2dashed(FatApp::getController()));
        array_pop($arr);
        return ucfirst(implode(' ', $arr));
    }

    public static function getSessionId()
    {
        return (true === MOBILE_APP_API_CALL) ? CommonHelper::getAppToken() : session_id();
    }

    /**
     * Send a HTTP (Async) request, but do not wait for the response
     *
     * @param string $method The HTTP method
     * @param string $url The url (including query string)
     * @param array $params Added to the URL or request body depending on method
     */
    public static function sendAsyncRequest(string $method, string $url, array $params = []): void
    {
        // url check
        $parts = parse_url($url);
        if ($parts === false) {
            SystemLog::system('Unable to parse URL', 'Send Add To Cart Async Request', SystemLog::TYPE_ERROR);
            return;
        }

        $host = $parts['host'] ?? null;
        $port = $parts['port'] ?? 80;
        $path = $parts['path'] ?? '/';
        $query = $parts['query'] ?? '';
        parse_str($query, $queryParts);

        if ($host === null) {
            SystemLog::system('Unknown Host', 'Send Add To Cart Async Request', SystemLog::TYPE_ERROR);
            return;
        }

        $connection = fsockopen($host, $port, $errno, $errstr, 30);
        if ($connection === false) {
            SystemLog::system('Unable To Connect ' . $host, 'Send Add To Cart Async Request', SystemLog::TYPE_ERROR);
            return;
        }

        $method = strtoupper($method);

        if (!in_array($method, ['POST', 'PUT', 'PATCH'], true)) {
            $queryParts = $params + $queryParts;
            $params = [];
        }

        // Build request
        $request  = $method . ' ' . $path;
        if ($queryParts) {
            $request .= '?' . http_build_query($queryParts);
        }
        $request .= ' HTTP/1.1' . "\r\n";
        $request .= 'Host: ' . $host . "\r\n";

        $body = http_build_query($params);
        if ($body) {
            $request .= 'Content-Type: application/x-www-form-urlencoded' . "\r\n";
            $request .= 'Content-Length: ' . strlen($body) . "\r\n";
        }
        $request .= 'Connection: Close' . "\r\n\r\n";
        $request .= $body;

        // Send request to server
        fwrite($connection, $request);
        fclose($connection);
    }

    /**
     * callPlugin - Used to call plugin file without including plugin. This function is used for files exists in library\plugins.
     *
     * @param string $keyname - ClassName
     * @param string $args - Constructor Arguments
     * @param string $error
     * @param int $langId
     * @param bool $checkActive
     * @return mixed
     */
    public static function callPlugin(string $keyName, array $args = [], &$error = '', int $langId = 0, bool $checkActive = true)
    {
        if (1 > $langId) {
            $langId = CommonHelper::getLangId();
        }

        if (empty($keyName)) {
            $error =  Labels::getLabel('MSG_INVALID_KEY_NAME', $langId);
            return false;
        }

        $pluginType = Plugin::getAttributesByCode($keyName, 'plugin_type');

        $directory = Plugin::getDirectory($pluginType);

        if (false == $directory) {
            $error =  Labels::getLabel('MSG_INVALID_PLUGIN_TYPE', $langId);
            return false;
        }

        $error = '';
        if (false === self::includePlugin($keyName, $directory, $error, $langId, $checkActive)) {
            return false;
        }

        $reflect  = new ReflectionClass($keyName);
        return $reflect->newInstanceArgs($args);
    }

    /**
     * includePlugin
     *
     * @param  string $keyName
     * @param  string $directory
     * @param  string $error
     * @param  int $langId
     * @param bool $checkActive
     * @return mixed
     */
    public static function includePlugin(string $keyName, string $directory, &$error = '', int $langId = 0, bool $checkActive = true)
    {
        if (1 > $langId) {
            $langId = CommonHelper::getLangId();
        }

        if (empty($directory)) {
            $error = Labels::getLabel('MSG_INVALID_REQUEST', $langId);
            return false;
        }

        if (true === $checkActive && 1 > Plugin::isActive($keyName)) {
            $str =  Labels::getLabel('MSG_{NAME}_IS_NOT_ACTIVE', $langId);
            $error = CommonHelper::replaceStringData($str, ['{NAME}' => $keyName]);
            return false;
        }

        $file = CONF_PLUGIN_DIR . $directory . '/' . strtolower($keyName) . '/' . $keyName . '.php';

        if (!file_exists($file)) {
            $error =  Labels::getLabel('MSG_UNABLE_TO_LOCATE_REQUIRED_FILE', $langId) . '-' . $keyName;
            return false;
        }

        try {
            require_once $file;
        } catch (\Error $e) {
            $error = $e->getMessage();
            return false;
        }
    }

    public static function getCacheKey()
    {
        $calledRoute = debug_backtrace()[1] ?? [];
        if (empty($calledRoute)) {
            die('Invalid Calling Route');
        }
        $class = $calledRoute['class'];
        $function = $calledRoute['function'];
        $args = (array)$calledRoute['args'];
        foreach ($args as &$val) {
            if (empty($val)) {
                $val = 0;
            }

            if (is_object($val)) {
                die('Object is being passed inside arguments please avoid using cache key in ' . $class . ' > ' . $function . '.');
            }

            if (is_array($val)) {
                $val = json_encode($val);
            }
        }
        return strtoupper($class . '-' . $function . '-' . implode('-', $args));
    }
}
