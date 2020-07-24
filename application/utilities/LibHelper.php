<?php

class LibHelper extends FatUtility
{
    private const ENCRYPTION_KEY = '__^%&Q@$&*!@#$%^&*^__';

    public static function dieJsonError($message)
    {
        if (true === MOBILE_APP_API_CALL) {
            $message = strip_tags($message);
        }
        FatUtility::dieJsonError($message);
    }

    public static function dieWithError($message)
    {
        FatUtility::dieWithError($message);
    }

    public static function exitWithError($message, $json = false, $redirect = false)
    {
        if (true === MOBILE_APP_API_CALL) {
            $message = strip_tags($message);
            FatUtility::dieJsonError($message);
        }

        if (true === $json) {
            FatUtility::dieJsonError($message);
        }
        
        if (FatUtility::isAjaxCall() || $redirect === false) {
            FatUtility::dieWithError($message);
        }

        if (true === $redirect) {
            Message::addErrorMessage($message);
        }
    }

    public static function getCommonReplacementVarsArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = CommonHelper::getLangId();
        }
        return array(
            '{SITE_NAME}' => FatApp::getConfig("CONF_WEBSITE_NAME_$langId"),
            '{SITE_URL}' => UrlHelper::generateFullUrl(),
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
}
