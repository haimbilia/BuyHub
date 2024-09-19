<?php

class UserAuthentication extends FatModel
{
    public const SESSION_ELEMENT_NAME = 'yokartUserSession';
    public const AFFILIATE_SESSION_ELEMENT_NAME = 'yokartAffiliateSession';
    public const SYSTEMUSER_COOKIE_NAME = '_uyokart';
    public const TEMP_SESSION_ELEMENT_NAME = 'yokartTempUserSession';

    public const DB_TBL_USER_PRR = 'tbl_user_password_reset_requests';
    public const DB_TBL_UPR_PREFIX = 'uprr_';

    public const DB_TBL_USER_AUTH = 'tbl_user_auth_token';
    public const DB_TBL_UAUTH_PREFIX = 'uauth_';

    public const TOKEN_LENGTH = 32;

    private $commonLangId;
    public $loginWithOtp = false;
    private $loginDcode = '';
    private $loginPhone = '';
    public $loginWithSocialAccount = false;

    public const AFFILIATE_REG_STEP1 = 1;
    public const AFFILIATE_REG_STEP2 = 2;
    public const AFFILIATE_REG_STEP3 = 3;
    public const AFFILIATE_REG_STEP4 = 4;

    public const TOKEN_AGE_IN_DAYS = 7;

    public function __construct()
    {
        $this->commonLangId = CommonHelper::getLangId();
    }

    public static function getAffiliateRegisterationStepArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId == 0) {
            trigger_error("Language Id not specified.", E_USER_ERROR);
        }
        return array(
            static::AFFILIATE_REG_STEP1 => Labels::getLabel('LBL_Personal_Details', $langId),
            static::AFFILIATE_REG_STEP2 => Labels::getLabel('LBL_Company_Details', $langId),
            static::AFFILIATE_REG_STEP3 => Labels::getLabel('LBL_Payment_Information', $langId),
            static::AFFILIATE_REG_STEP4 => Labels::getLabel('LBL_Confirmation', $langId),
        );
    }

    public static function encryptPassword(string $pass, bool $oldStyle = false)
    {
        if ($oldStyle) {
            return md5(PASSWORD_SALT . $pass . PASSWORD_SALT);
        }
        return  password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]);
    }


    public function logFailedAttempt($ip, $username)
    {
        $db = FatApp::getDb();

        $db->deleteRecords(
            'tbl_failed_login_attempts',
            array(
                'smt' => 'attempt_time < ?',
                'vals' => array(date('Y-m-d H:i:s', strtotime("-7 Day")))
            )
        );

        $db->insertFromArray(
            'tbl_failed_login_attempts',
            [
                'attempt_username' => $username,
                'attempt_ip' => $ip,
                'attempt_time' => date('Y-m-d H:i:s')
            ]
        );

        // For improvement, we can send an email about the failed attempt here.
    }

    public function clearFailedAttempt($ip, $username)
    {
        $db = FatApp::getDb();

        return $db->deleteRecords(
            'tbl_failed_login_attempts',
            array(
                'smt' => 'attempt_username = ? and attempt_ip = ?',
                'vals' => array($username, $ip)
            )
        );
    }

    public function isBruteForceAttempt($ip, $username)
    {
        $db = FatApp::getDb();
        $ips = explode(',', FatApp::getConfig("CONF_WHITELISTED_IP", FatUtility::VAR_STRING, ''));
        if (in_array($ip, $ips)) {
            return false;
        }

        if (true === $this->loginWithOtp) {
            $username = CommonHelper::replaceStringData($username, [$this->loginDcode => ValidateElement::formatDialCode($this->loginDcode)]);
        }

        $srch = new SearchBase('tbl_failed_login_attempts');
        $srch->addCondition('attempt_ip', '=', $ip)->attachCondition('attempt_username', '=', $username);
        $srch->addCondition('attempt_time', '>=', date('Y-m-d H:i:s', strtotime("-5 minutes")));
        $srch->addFld('COUNT(*) AS total');
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $row = $db->fetch($rs);

        return ($row['total'] > 5);
    }

    public static function doAppLogin($token, $userType = 0)
    {
        $authRow = self::checkLoginTokenInDB($token);

        if (strlen($token) != self::TOKEN_LENGTH || empty($authRow)) {
            self::clearLoggedUserLoginCookie();
            return false;
        }

        if (strtotime($authRow['uauth_expiry']) < strtotime('now')) {
            self::clearLoggedUserLoginCookie();
            return false;
        }

        $ths = new UserAuthentication();
        if ($ths->loginByAppToken($authRow)) {
            return true;
        }
        return false;
    }

    private function loginByAppToken($authRow)
    {
        $userObj = new User($authRow['uauth_user_id']);

        if ($row = $userObj->getProfileData()) {
            if ($row['credential_verified'] != applicationConstants::YES) {
                return false;
            }

            if ($row['credential_active'] != applicationConstants::YES) {
                return false;
            }
            $row['user_ip'] = CommonHelper::getClientIp();
            $this->setSession($row);

            return $row;
        }
        return false;
    }

    public static function doCookieLogin($returnAuthRow = true)
    {
        $cookieName = self::SYSTEMUSER_COOKIE_NAME;

        if (!array_key_exists($cookieName, $_COOKIE)) {
            return false;
        }

        $token = $_COOKIE[$cookieName];
        $authRow = false;

        $authRow = self::checkLoginTokenInDB($token);

        if (strlen($token) != self::TOKEN_LENGTH || empty($authRow)) {
            self::clearLoggedUserLoginCookie();
            return false;
        }

        $browser = CommonHelper::userAgent();
        if (strtotime($authRow['uauth_expiry']) < strtotime('now') || $authRow['uauth_browser'] != $browser || CommonHelper::getClientIp() != $authRow['uauth_last_ip']) {
            self::clearLoggedUserLoginCookie();
            return false;
        }

        $ths = new UserAuthentication();
        if ($ths->loginByCookie($authRow)) {
            if (true === $returnAuthRow) {
                return $authRow;
            }
            return true;
        }
        return false;
    }

    public function guestLogin($useremail, $name, $ip)
    {
        $db = FatApp::getDb();
        $srch = User::getSearchObject(true, 0, false);
        $srch->addCondition('credential_email', '=', $useremail);
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $row = $db->fetch($rs);
        if (!empty($row)) {
            if ($row['user_is_buyer'] != applicationConstants::YES) {
                $this->error = Labels::getLabel('ERR_Please_login_with_buyer_account', $this->commonLangId);
                return false;
            }

            if ($row['credential_verified'] == applicationConstants::YES && $row['credential_active'] == applicationConstants::ACTIVE) {
                $this->error = Labels::getLabel('ERR_YOUR_ACCOUNT_ALREADY_EXIST._PLEASE_LOGIN', $this->commonLangId);
                return false;
            }

            if ($row && $row['user_deleted'] == applicationConstants::YES) {
                $this->error = Labels::getLabel('ERR_USER_INACTIVE_OR_DELETED', $this->commonLangId);
                return false;
            }

            $rowUser = User::getAttributesById($row['user_id']);

            $rowUser['user_ip'] = $ip;
            $rowUser['user_is_guest'] = true;
            $rowUser['user_email'] = $row['credential_email'];
            Cart::setCartAttributes($row['user_id']);
            $this->setSession($rowUser);
            return true;
        }


        $userObj = new User();
        $db->startTransaction();

        $data = array(
            'user_name' => $name,
            'user_username' => $useremail,
            'user_email' => $useremail,
            'user_is_buyer' => 1,
            'user_type' => User::USER_TYPE_BUYER,
            'user_preferred_dashboard' => User::USER_BUYER_DASHBOARD,
            'user_registered_initially_for' => User::USER_TYPE_BUYER,
        );
        $userObj->assignValues($data);

        if (!$userObj->save()) {
            $db->rollbackTransaction();
            $this->error = Labels::getLabel("ERR_USER_COULD_NOT_BE_SET", $this->commonLangId) . $userObj->getError();
            return false;
        }
        $userId = $userObj->getMainTableRecordId();

        $active = FatApp::getConfig('CONF_ADMIN_APPROVAL_REGISTRATION', FatUtility::VAR_INT, 1) ? 0 : 1;
        $verify = FatApp::getConfig('CONF_EMAIL_VERIFICATION_REGISTRATION', FatUtility::VAR_INT, 1) ? 0 : 1;

        $pass = CommonHelper::getRandomPassword(8);
        if (!$userObj->setLoginCredentials($useremail, $useremail, $pass, $active, $verify)) {
            $this->error = Labels::getLabel("ERR_LOGIN_CREDENTIALS_COULD_NOT_BE_SET", $this->commonLangId) . $userObj->getError();
            $db->rollbackTransaction();
            return false;
        }

        if (FatApp::getConfig('CONF_NOTIFY_ADMIN_REGISTRATION', FatUtility::VAR_INT, 1)) {
            if (!$userObj->notifyAdminRegistration($data, $this->commonLangId)) {
                $this->error = Labels::getLabel("ERR_NOTIFICATION_EMAIL_COULD_NOT_BE_SENT", $this->commonLangId);
                $db->rollbackTransaction();
                return false;
            }
        }

        if (FatApp::getConfig('CONF_WELCOME_EMAIL_REGISTRATION', FatUtility::VAR_INT, 1)) {
            if (!$userObj->guestUserWelcomeEmail($data, $this->commonLangId)) {
                $this->error = Labels::getLabel("ERR_WELCOME_EMAIL_COULD_NOT_BE_SENT", $this->commonLangId);
                $db->rollbackTransaction();
                return false;
            }
        }

        $db->commitTransaction();

        $srch = User::getSearchObject(true, 0, false);
        $srch->addCondition('credential_email', '=', $useremail);
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        if (!$row = $db->fetch($rs)) {
            $this->logFailedAttempt($ip, $useremail);
            $this->error = Labels::getLabel('ERR_INVALID_USERNAME_OR_PASSWORD', $this->commonLangId);
            return false;
        }

        $rowUser = User::getAttributesById($row['credential_user_id']);

        $rowUser['user_ip'] = $ip;
        $rowUser['user_is_guest'] = true;
        $rowUser['user_email'] = $row['credential_email'];
        Cart::setCartAttributes($row['credential_user_id']);
        $this->setSession($rowUser);

        $this->clearFailedAttempt($ip, $useremail);

        return true;
    }

    public function setLoginWithOtp($dcode, $phone)
    {
        $this->loginDcode = $dcode;
        $this->loginPhone = $phone;
        $this->loginWithOtp = (!empty($this->loginDcode) && !empty($this->loginPhone));
    }

    public function login($username, $password, $ip, $encryptPassword = true, $isAdmin = false, $tempUserId = 0, $userType = 0, $withPhone = false)
    {
        $db = FatApp::getDb();
        if ($this->isBruteForceAttempt($ip, $username)) {
            $userSrch = User::getSearchObject(true, 0, false);
            $condition = $userSrch->addCondition('credential_username', '=', $username);
            $condition->attachCondition('mysql_func_CONCAT(user_phone_dcode, user_phone)', '=', $username, 'OR', true);
            $userSrch->doNotCalculateRecords();
            if ($row = $db->fetch($userSrch->getResultSet())) {
                $email = new EmailHandler();
                $email->failedLoginAttempt(FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1), $row);
            }

            $this->error = Labels::getLabel('ERR_LOGIN_ATTEMPT_LIMIT_EXCEEDED_PLEASE_TRY_LATER', $this->commonLangId);
            return false;
        }

        $srch = User::getSearchObject(true, 0, false);
        $condition = $srch->addCondition('credential_username', '=', $username);
        $condition->attachCondition('credential_email', '=', $username, 'OR');
        $condition->attachCondition('mysql_func_CONCAT(user_phone_dcode, user_phone)', '=', $username, 'OR', true);
        $srch->doNotCalculateRecords();
        if (true === $this->loginWithOtp) {
            $loginPhone = CommonHelper::replaceStringData($username, [$this->loginDcode => ValidateElement::formatDialCode($this->loginDcode)]);
            $srch->joinTable(User::DB_TBL_USER_PHONE_VER, 'INNER JOIN', 'upv_user_id = user_id', 'upv');
            $srch->addCondition('mysql_func_CONCAT(upv_phone_dcode, upv_phone)', '=', $loginPhone, 'AND', true);
            $srch->addCondition('upv_otp', '=', $password);
        }

        if (0 < $userType) {
            switch ($userType) {
                case User::USER_TYPE_BUYER:
                    $srch->addCondition('user_is_buyer', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
                    break;
                case User::USER_TYPE_SELLER:
                    $srch->addCondition('user_is_supplier', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
                    break;
                case User::USER_TYPE_ADVERTISER:
                    $srch->addCondition('user_is_advertiser', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
                    break;
                case User::USER_TYPE_AFFILIATE:
                    $srch->addCondition('user_is_affiliate', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
                    break;
                default:
                    $srch->addCondition('user_registered_initially_for', '=', $userType);
                    break;
            }
        }

        if (!$row = $db->fetch($srch->getResultSet())) {
            $this->error = Labels::getLabel('ERR_INVALID_USER_NAME_OR_PASSWORD', $this->commonLangId);
            if ($withPhone) {
                $this->error = Labels::getLabel('ERR_INVALID_OTP', $this->commonLangId);
            }
            return false;
        }

        /* [To Do - need to remove credential_password_old in next release */
        if (false === $this->loginWithOtp && false === $this->loginWithSocialAccount) {
            if ($row['credential_verified'] == applicationConstants::YES  && !$isAdmin) {
                if (empty($row['credential_email']) && !empty($row['user_phone_dcode']) && !empty($row['user_phone'])) {
                    $this->error = Labels::getLabel('MSG_THIS_ACCOUNT_IS_LINKED_WITH_PHONE._PLEASE_LINK_YOUR_EMAIL_FROM_YOUR_ACCOUNT_TO_LOGIN_USING_PASSWORD.', $this->commonLangId);
                    return false;
                }

                if (empty($row['credential_password'])) {
                    if (MOBILE_APP_API_CALL) {
                        $this->error = Labels::getLabel('MSG_FOR_SECURITY_REASON_RESET_YOUR_PASSWORD.', $this->commonLangId);
                    } else {
                        $this->error = CommonHelper::replaceStringData(Labels::getLabel('MSG_FOR_SECURITY_REASON_{CLICKHERE}_TO_RESET_YOUR_PASSWORD.', $this->commonLangId), ["{clickhere}" => '<a href="javascript:void(0)" onclick="sendResetPasswordLink(' . "'" . $username . "'" . ')">' . Labels::getLabel('LBL_Click_Here', $this->commonLangId) . '</a>']);
                    }
                    return false;
                }

                if (true == $encryptPassword) {
                    if (false == password_verify($password, $row['credential_password'])) {
                        $this->logFailedAttempt($ip, $username);
                        $this->error = Labels::getLabel('ERR_INVALID_USER_NAME_OR_PASSWORD', $this->commonLangId);
                        return false;
                    }
                } else {
                    if ($password !== $row['credential_password']) {
                        $this->logFailedAttempt($ip, $username);
                        $this->error = Labels::getLabel('ERR_INVALID_USER_NAME_OR_PASSWORD', $this->commonLangId);
                        return false;
                    }
                }
            }
        }
        /* [To Do - need to remove credential_password_old in next release */

        if ($row && $row['user_deleted'] == applicationConstants::YES) {
            $this->logFailedAttempt($ip, $username);
            $this->error = Labels::getLabel('ERR_USER_INACTIVE_OR_DELETED', $this->commonLangId);
            return false;
        }

        if ($row['user_is_shipping_company'] == applicationConstants::YES) {
            $this->logFailedAttempt($ip, $username);
            $this->error = Labels::getLabel('ERR_Shipping_user_are_not_allowed_to_login', $this->commonLangId);
            return false;
        }

        if (!$isAdmin) {
            if ($row['credential_verified'] != applicationConstants::YES) {
                $emailErrorMsg = str_replace("{clickhere}", '<a href="javascript:void(0)" onclick="resendVerificationLink(' . "'" . $username . "'" . ')">' . Labels::getLabel('LBL_Click_Here', $this->commonLangId) . '</a>', Labels::getLabel('MSG_Your_Account_verification_is_pending_{clickhere}', $this->commonLangId));

                $message = Labels::getLabel('MSG_THIS_PHONE_NUMBER_IS_NOT_VERIFIED_YET._DO_YOU_WANT_TO_CONTINUE?_{CONTINUE-BTN}', $this->commonLangId);
                $replacements = [
                    '{CONTINUE-BTN}' => '<a class="btn btn-outline-white" href="javascript:void(0);" onclick="loginPopupOtp(' . $row['user_id'] . ', ' . applicationConstants::NO . ')">' . Labels::getLabel('MSG_PROCEED', $this->commonLangId) . '</a>'
                ];
                $phoneErrorMsg = CommonHelper::replaceStringData($message, $replacements);

                if (strtolower($row['credential_email']) === strtolower($username)) {
                    $this->error = $emailErrorMsg;
                } else if ($row['user_phone'] === $username) {
                    $json['userId'] = FatUtility::convertToType($row['user_id'], FatUtility::VAR_STRING);
                    $this->error = $phoneErrorMsg;
                } else {
                    $this->error = !empty($row['credential_email']) ? $emailErrorMsg : $phoneErrorMsg;
                }

                if (true === MOBILE_APP_API_CALL) {
                    $this->error = Labels::getLabel('ERR_Your_Account_verification_is_pending', $this->commonLangId);
                }

                if (FatUtility::isAjaxCall() || true === MOBILE_APP_API_CALL) {
                    LibHelper::exitWithError($this->error, false, false, ['notVerified' => 1]);
                }
                return false;
            }

            if ($row['credential_active'] != applicationConstants::ACTIVE) {
                $this->error = Labels::getLabel('ERR_YOUR_ACCOUNT_HAS_BEEN_DEACTIVATED_OR_NOT_ACTIVE', $this->commonLangId);
                return false;
            }

            $rowUser = User::getAttributesById($row['credential_user_id']);
            if (0 < $rowUser['user_parent']) {
                $parentUser = new User($rowUser['user_parent']);
                $parentSrch = $parentUser->getUserSearchObj();
                $parentSrch->addCondition('credential_active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
                $parentSrch->doNotCalculateRecords();
                $rs = $parentSrch->getResultSet();
                $parentData = FatApp::getDb()->fetch($rs);
                if (false == $parentData || null == $parentData) {
                    $this->error = Labels::getLabel('ERR_YOUR_ACCOUNT_HAS_BEEN_DEACTIVATED_OR_NOT_ACTIVE', $this->commonLangId);
                    return false;
                }
            }
        } else {
            $rowUser = User::getAttributesById($row['credential_user_id']);
        }

        if (true === $this->loginWithOtp) {
            $user = new User();
            $user->deletePhoneOtp($row['credential_user_id']);
        }

        $rowUser['user_ip'] = $ip;
        $rowUser['user_email'] = $row['credential_email'];
        Cart::setCartAttributes($row['credential_user_id'], $tempUserId);
        $this->setSession($rowUser);
        /* $_SESSION[static::SESSION_ELEMENT_NAME] = array(
        'user_id'=>$rowUser['user_id'],
        'user_name'=>$rowUser['user_name'],
        'user_ip'=>$ip
        ); */

        /* clear failed login attempt for the user [ */
        $this->clearFailedAttempt($ip, $username);
        /* ] */

        return true;
    }

    private function setSession($data)
    {
        unset($_SESSION['shopping_cart']["order_id"]);
        unset($_SESSION['wallet_recharge_cart']["order_id"]);
        unset($_SESSION['subscription_shopping_cart']["order_id"]);
        unset($_SESSION['shopping_cart']["order_id"]);
        unset($_SESSION["order_id"]);

        if (!MOBILE_APP_API_CALL) {
            session_regenerate_id();
        }

        $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME] = array(
            'user_id' => $data['user_id'],
            'user_name' => $data['user_name'],
            'user_ip' => $data['user_ip'],
            'user_email' => $data['user_email'],
            'user_is_buyer' => $data['user_is_buyer'],
            'user_is_supplier' => $data['user_is_supplier'],
            'user_preferred_dashboard' => $data['user_preferred_dashboard'],
            'user_is_guest' => isset($data['user_is_guest']) ? $data['user_is_guest'] : false,
            'user_phone' => (isset($data['user_phone']) ? ValidateElement::formatDialCode($data['user_phone_dcode']) . $data['user_phone'] : ''),
        );

        return true;
    }

    private function loginByCookie($authRow)
    {
        $userObj = new User($authRow['uauth_user_id']);
        if ($row = $userObj->getProfileData()) {
            if ($row['credential_verified'] != applicationConstants::YES) {
                return false;
            }

            if ($row['credential_active'] != applicationConstants::YES) {
                return false;
            }

            $row['user_ip'] = CommonHelper::getClientIp();
            $this->setSession($row);
            return true;
        }
        return false;
    }

    public static function checkFcmDeviceTokenInDB($fcmDeviceToken)
    {
        $db = FatApp::getDb();
        $srch = new SearchBase(static::DB_TBL_USER_AUTH);
        $srch->addCondition(static::DB_TBL_UAUTH_PREFIX . 'fcm_id', '=', $fcmDeviceToken);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();
        return $db->fetch($rs);
    }

    public static function updateFcmDeviceToken(&$values, $where)
    {
        $db = FatApp::getDb();
        if ($db->updateFromArray(static::DB_TBL_USER_AUTH, $values, $where)) {
            return true;
        }
        return false;
    }

    public static function saveLoginToken(&$values)
    {
        $db = FatApp::getDb();
        if ($db->insertFromArray(static::DB_TBL_USER_AUTH, $values)) {
            return true;
        }
        return false;
    }

    public static function checkLoginTokenInDB($token)
    {
        $db = FatApp::getDb();
        $srch = new SearchBase(static::DB_TBL_USER_AUTH);
        $srch->addCondition(static::DB_TBL_UAUTH_PREFIX . 'token', '=', $token);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();
        return (array)$db->fetch($rs);
    }

    public static function clearLoggedUserLoginCookie()
    {
        if (!isset($_COOKIE[static::SYSTEMUSER_COOKIE_NAME])) {
            return false;
        }

        $db = FatApp::getDb();
        if (strlen($_COOKIE[static::SYSTEMUSER_COOKIE_NAME])) {
            $db->deleteRecords(
                static::DB_TBL_USER_AUTH,
                array(
                    'smt' => static::DB_TBL_UAUTH_PREFIX . 'token = ?',
                    'vals' => array($_COOKIE[static::SYSTEMUSER_COOKIE_NAME])
                )
            );
        }
        setcookie($_COOKIE[static::SYSTEMUSER_COOKIE_NAME], '', time() - 3600, CONF_WEBROOT_URL);       
        return true;
    }

    public static function isGuestUserLogged($ip = '')
    {
        if ($ip == '') {
            $ip = CommonHelper::getClientIp();
        }

        if (
            isset($_SESSION[static::SESSION_ELEMENT_NAME])
            /*&& $_SESSION [static::SESSION_ELEMENT_NAME] ['user_ip'] == $ip*/
            && $_SESSION[static::SESSION_ELEMENT_NAME]['user_is_guest'] == true
            && is_numeric($_SESSION[static::SESSION_ELEMENT_NAME]['user_id'])
            && 0 < $_SESSION[static::SESSION_ELEMENT_NAME]['user_id']
        ) {
            return true;
        }
        return false;
    }

    public static function logout($fcmToken = '')
    {
        if (isset($_SESSION['access_token'])) {
            unset($_SESSION['access_token']);
        }

        include_once CONF_INSTALLATION_PATH . 'library/facebook/facebook.php';
        $facebook = new Facebook(
            array(
                'appId' => FatApp::getConfig("CONF_FACEBOOK_APP_ID"),
                'secret' => FatApp::getConfig("CONF_FACEBOOK_APP_SECRET"),
            )
        );

        $user = $facebook->getUser();

        if ($user) {
            unset($_SESSION['fb_' . FatApp::getConfig("CONF_FACEBOOK_APP_ID") . '_code']);
            unset($_SESSION['fb_' . FatApp::getConfig("CONF_FACEBOOK_APP_ID") . '_access_token']);
            unset($_SESSION['fb_' . FatApp::getConfig("CONF_FACEBOOK_APP_ID") . '_user_id']);
        }

        unset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]);

        unset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]);
        unset($_SESSION[UserAuthentication::AFFILIATE_SESSION_ELEMENT_NAME]);
        unset($_SESSION['activeTab']);
        unset($_SESSION['referer_page_url']);
        unset($_SESSION['registered_supplier']['id']);

        self::clearLoggedUserLoginCookie();
    }

    public static function isUserLogged($ip = '', $token = '')
    {
        if ($ip == '') {
            $ip = CommonHelper::getClientIp();
        }

        if (
            isset($_SESSION[static::SESSION_ELEMENT_NAME])
            /*&& $_SESSION [static::SESSION_ELEMENT_NAME] ['user_ip'] == $ip*/
            && $_SESSION[static::SESSION_ELEMENT_NAME]['user_is_guest'] == false
            && is_numeric($_SESSION[static::SESSION_ELEMENT_NAME]['user_id'])
            && 0 < $_SESSION[static::SESSION_ELEMENT_NAME]['user_id']
        ) {
            return true;
        }

        $token = empty($token) ? CommonHelper::getAppToken() : $token;

        if ($token != '' && static::doAppLogin($token)) {
            return true;
        }

        if (static::doCookieLogin(false)) {
            return true;
        }

        return false;
    }

    public static function getLoggedUserAttribute($attr, $returnNullIfNotLogged = false)
    {
        if (!static::isUserLogged() && !static::isGuestUserLogged()) {
            if ($returnNullIfNotLogged) {
                return null;
            }
            $message = Labels::getLabel('MSG_USER_NOT_LOGGED', CommonHelper::getLangId());
            LibHelper::exitWithError($message, false);
        }


        if (array_key_exists($attr, $_SESSION[static::SESSION_ELEMENT_NAME])) {
            return $_SESSION[static::SESSION_ELEMENT_NAME][$attr];
        }

        return User::getAttributesById($_SESSION[static::SESSION_ELEMENT_NAME]['user_id'], $attr);
    }

    public static function getLoggedUserId($returnZeroIfNotLogged = false)
    {
        return FatUtility::int(static::getLoggedUserAttribute('user_id', $returnZeroIfNotLogged));
    }

    public function getUserByEmail($email, $isActive = true, $isVerfied = true, $attr = null)
    {
        $db = FatApp::getDb();
        $srch = new SearchBase(User::DB_TBL);
        $srch->joinTable(User::DB_TBL_CRED, 'INNER JOIN', User::tblFld('id') . '=' . User::DB_TBL_CRED_PREFIX . 'user_id');
        $srch->addCondition(User::DB_TBL_CRED_PREFIX . 'email', '=', $email);

        if (true === $isActive) {
            $srch->addCondition(User::DB_TBL_CRED_PREFIX . 'active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
        } else {
            $srch->addFld(User::DB_TBL_CRED_PREFIX . 'active');
        }
        if (true === $isVerfied) {
            $srch->addCondition(User::DB_TBL_CRED_PREFIX . 'verified', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
        } else {
            $srch->addFld(User::DB_TBL_CRED_PREFIX . 'verified');
        }

        if ($attr == null) {
            $srch->addMultipleFields(
                array(
                    User::tblFld('id'),
                    User::tblFld('name'),
                    User::DB_TBL_CRED_PREFIX . 'email',
                    User::DB_TBL_CRED_PREFIX . 'password'
                )
            );
        } else {
            $srch->addMultipleFields($attr);
        }

        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();

        if (!$row = $db->fetch($rs, User::tblFld('id'))) {
            $this->error = Labels::getLabel('ERR_INVALID_EMAIL_ADDRESS', $this->commonLangId);
            return false;
        }
        return $row;
    }

    public function validateUserObj($isActive = true, $isVerfied = true, $addDeletedCheck = true)
    {
        $srch = new SearchBase(User::DB_TBL);
        $srch->joinTable(User::DB_TBL_CRED, 'INNER JOIN', User::tblFld('id') . '=' . User::DB_TBL_CRED_PREFIX . 'user_id');

        if (true === $isActive) {
            $srch->addCondition(User::DB_TBL_CRED_PREFIX . 'active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
        } else {
            $srch->addFld(User::DB_TBL_CRED_PREFIX . 'active');
        }

        if (true === $isVerfied) {
            $srch->addCondition(User::DB_TBL_CRED_PREFIX . 'verified', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
        } else {
            $srch->addFld(User::DB_TBL_CRED_PREFIX . 'verified');
        }

        if (true === $addDeletedCheck) {
            $srch->addCondition(User::DB_TBL_PREFIX . 'deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        }

        $srch->addMultipleFields(
            array(
                User::tblFld('id'),
                User::tblFld('name'),
                User::tblFld('is_shipping_company'),
                User::tblFld('deleted'),
                User::DB_TBL_CRED_PREFIX . 'email',
                User::DB_TBL_CRED_PREFIX . 'password'
            )
        );

        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        return $srch;
    }

    public function getUserByPhone($phoneNumber, $isActive = true, $isVerfied = true, $addDeletedCheck = true)
    {
        $db = FatApp::getDb();
        $srch = $this->validateUserObj($isActive, $isVerfied, $addDeletedCheck);
        $srch->addCondition('mysql_func_CONCAT(user_phone_dcode, user_phone)', '=', $phoneNumber, 'AND', true);
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        if (!$row = $db->fetch($rs, User::tblFld('id'))) {
            $this->error = Labels::getLabel('ERR_INVALID_PHONE_NUMBER', $this->commonLangId);
            return false;
        }

        return $row;
    }

    public function getUserByEmailOrUserName($user, $isActive = true, $isVerfied = true, $addDeletedCheck = true)
    {
        $db = FatApp::getDb();
        $srch = $this->validateUserObj($isActive, $isVerfied, $addDeletedCheck);
        $cnd = $srch->addCondition(User::DB_TBL_CRED_PREFIX . 'username', '=', $user);
        $cnd->attachCondition(User::DB_TBL_CRED_PREFIX . 'email', '=', $user, 'OR');
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        if (!$row = $db->fetch($rs, User::tblFld('id'))) {
            $this->error = Labels::getLabel('ERR_INVALID_USERNAME/EMAIL', $this->commonLangId);
            return false;
        }

        return $row;
    }

    public function getUserResetPwdToken($userId)
    {
        $userId = FatUtility::int($userId);
        $db = FatApp::getDb();
        $srch = new SearchBase(static::DB_TBL_USER_PRR);
        $srch->addCondition(static::DB_TBL_UPR_PREFIX . 'user_id', '=', 'mysql_func_' . $userId, 'AND', true);
        $srch->addCondition(static::DB_TBL_UPR_PREFIX . 'expiry', '>', date('Y-m-d H:i:s'));
        $srch->addMultipleFields([static::DB_TBL_UPR_PREFIX . 'user_id', static::DB_TBL_UPR_PREFIX . 'token']);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();
        if (!$row = $db->fetch($rs)) {
            return false;
        }
        return $row;
    }

    public function checkUserPwdResetRequest($userId)
    {
        if (!$this->getUserResetPwdToken($userId)) {
            return false;
        }

        $this->error = Labels::getLabel('ERR_RESET_PASSWORD_REQUEST_ALREADY_PLACED', $this->commonLangId);
        return true;
    }

    public function deleteOldPasswordResetRequest($userId = 0)
    {
        $userId = FatUtility::int($userId);
        $db = FatApp::getDb();
        if (0 < $userId) {
            $condition = array('smt' => static::DB_TBL_UPR_PREFIX . 'user_id = ?', 'vals' => array($userId));
        } else {
            $condition = array('smt' => static::DB_TBL_UPR_PREFIX . 'expiry < ?', 'vals' => array(date('Y-m-d H:i:s')));
        }
        if (!$db->deleteRecords(static::DB_TBL_USER_PRR, $condition)) {
            $this->error = $db->getError();
            return false;
        }
        return true;
    }

    public function addPasswordResetRequest($data = array())
    {
        if (!isset($data['user_id']) || $data['user_id'] < 1 || strlen($data['token']) < 20) {
            return false;
        }
        $db = FatApp::getDb();
        if (!$db->insertFromArray(
            static::DB_TBL_USER_PRR,
            array(
                static::DB_TBL_UPR_PREFIX . 'user_id' => intval($data['user_id']),
                static::DB_TBL_UPR_PREFIX . 'token' => $data['token'],
                static::DB_TBL_UPR_PREFIX . 'expiry' => date('Y-m-d H:i:s', strtotime("+" . ($data['days'] ?? 1) . " DAY"))
            )
        )) {
            $this->error = $db->getError();
            return false;
        }
        return true;
    }

    public function checkResetLink($uId, $token)
    {
        $uId = FatUtility::convertToType($uId, FatUtility::VAR_INT);
        $token = FatUtility::convertToType($token, FatUtility::VAR_STRING);
        if (intval($uId) < 1 || strlen($token) < 20) {
            $this->error = Labels::getLabel('ERR_INVALID_RESET_PASSWORD_REQUEST', $this->commonLangId);
            return false;
        }
        $db = FatApp::getDb();
        $srch = new SearchBase(static::DB_TBL_USER_PRR);
        $srch->addCondition(static::DB_TBL_UPR_PREFIX . 'user_id', '=', 'mysql_func_' . $uId, 'AND', true);
        $srch->addCondition(static::DB_TBL_UPR_PREFIX . 'token', '=', $token);
        $srch->addCondition(static::DB_TBL_UPR_PREFIX . 'expiry', '>', date('Y-m-d H:i:s'));
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();

        $rs = $srch->getResultSet();

        if (!$row = $db->fetch($rs)) {
            $this->error = Labels::getLabel('ERR_LINK_IS_INVALID_OR_EXPIRED', $this->commonLangId);
            return false;
        }

        if ($row[static::DB_TBL_UPR_PREFIX . 'user_id'] == $uId && $row[static::DB_TBL_UPR_PREFIX . 'token'] === $token) {
            return true;
        }
        $this->error = Labels::getLabel('ERR_LINK_IS_INVALID_OR_EXPIRED', $this->commonLangId);
        return false;
    }

    public function resetUserPassword($userId, $pwd)
    {
        $userId = FatUtility::convertToType($userId, FatUtility::VAR_INT);
        if ($userId < 1) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', $this->commonLangId);
            return false;
        }

        if (!ValidateElement::password($pwd)) {
            $this->error = Labels::getLabel('ERR_PASSWORD_MUST_BE_EIGHT_CHARACTERS_LONG_AND_ALPHANUMERIC', $this->commonLangId);
            return false;
        }

        $pwd = UserAuthentication::encryptPassword($pwd);

        if (!empty($pwd)) {
            $user = new User($userId);
            if (!$user->resetPassword($pwd)) {
                $this->error = $user->getError();
                return false;
            }
            FatApp::getDb()->deleteRecords(static::DB_TBL_USER_PRR, array('smt' => static::DB_TBL_UPR_PREFIX . 'user_id =?', 'vals' => array($userId)));
            return true;
        }
        $this->error = Labels::getLabel('ERR_INVALID_PASSWORD', $this->commonLangId);
        return false;
    }

    public static function checkLogin($redirect = true, $redirectUrl = '')
    {
        if (static::isUserLogged() || static::isGuestUserLogged()) {
            return true;
        }

        $message = Labels::getLabel('MSG_SESSION_SEEMS_TO_BE_EXPIRED', CommonHelper::getLangId());
        LibHelper::exitWithError($message, false, $redirect, ['displayLoginForm' => 1]);

        $_SESSION['referer_page_url'] = UrlHelper::getCurrUrl();
        if ($redirect == true) {
            $redirectUrl = (empty($redirectUrl) ? UrlHelper::generateUrl('GuestUser', 'loginForm', [], CONF_WEBROOT_FRONTEND) : $redirectUrl);
            FatApp::redirectUser($redirectUrl);
        }

        return false;
    }

    public static function subscriptionCheckLogin($redirect = true, $redirectUrl = '')
    {
        if (static::isUserLogged() && User::canViewSupplierTab()) {
            return true;
        }

        $message = Labels::getLabel('MSG_SESSION_SEEMS_TO_BE_EXPIRED._PLEASE_LOGIN_WITH_SELLER_ACCOUNT', CommonHelper::getLangId());
        LibHelper::exitWithError($message, false, $redirect, ['displayLoginForm' => 1]);

        $_SESSION['referer_page_url'] = UrlHelper::getCurrUrl();
        if ($redirect == true) {
            $redirectUrl = (empty($redirectUrl) ? UrlHelper::generateUrl('GuestUser', 'loginForm', [], CONF_WEBROOT_FRONTEND) : $redirectUrl);
            FatApp::redirectUser($redirectUrl);
        }

        return false;
    }


    public static function setSessionAffiliateRegistering($data = array())
    {
        $affiliateSessionElementName = UserAuthentication::AFFILIATE_SESSION_ELEMENT_NAME;

        if (empty($data)) {
            trigger_error("Paramaeters are required.", E_USER_ERROR);
        }

        $_SESSION[$affiliateSessionElementName]['affiliate_is_registering_now'] = 1;

        if (isset($data['user_id'])) {
            $_SESSION[$affiliateSessionElementName]['user_id'] = $data['user_id'];
        }

        /* if( isset($data['addr_id']) ){
        $_SESSION[$affiliateSessionElementName]['addr_id'] = $data['addr_id'];
        } */

        if (isset($data['affiliate_register_step_number'])) {
            $_SESSION[$affiliateSessionElementName]['affiliate_register_step_number'] = $data['affiliate_register_step_number'];
        }
        return true;
    }

    public static function getSessionAffiliateByKey($key)
    {
        $affiliateSessionElementName = UserAuthentication::AFFILIATE_SESSION_ELEMENT_NAME;
        return isset($_SESSION[$affiliateSessionElementName][$key]) ? $_SESSION[$affiliateSessionElementName][$key] : false;
    }

    /**
     * validateUserPhone
     *
     * @param  int $userId
     * @param  string $phoneNumber
     * @return bool
     */
    public static function validateUserPhone(int $userId, string $phoneNumber): bool
    {
        return ($phoneNumber == User::getAttributesById($userId, 'user_phone'));
    }

    /**
     * validateMarketplaceAuthToken
     *
     * @param  string $authToken
     * @return bool
     */
    public function validateMarketplaceAuthToken(string $authToken): bool
    {
        $srchPluginSettings = new PluginSettingSearch();
        $srchPluginSettings->joinPlugin();
        $srchPluginSettings->addCondition('pluginsetting_value', '=', $authToken);
        $srchPluginSettings->addMultipleFields(['plugin_code']);
        $srchPluginSettings->setPageSize(1);
        $srchPluginSettings->doNotCalculateRecords();
        $rs = $srchPluginSettings->getResultSet();
        $plugin =  FatApp::getDb()->fetch($rs);
        return empty($plugin) ? false : true;
    }

    public static function getAttributesByToken($token, $attr = null)
    {
        $token = FatUtility::convertToType($token, FatUtility::VAR_STRING);
        $db = FatApp::getDb();

        $srch = new SearchBase(static::DB_TBL_USER_AUTH);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition('uauth_token', '=', $token);

        if (null != $attr) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } elseif (is_string($attr)) {
                $srch->addFld($attr);
            }
        }

        $rs = $srch->getResultSet();
        $row = $db->fetch($rs);

        if (!is_array($row)) {
            return false;
        }

        if (is_string($attr)) {
            return $row[$attr];
        }

        return $row;
    }
}
