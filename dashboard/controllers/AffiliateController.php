<?php

require_once CONF_INSTALLATION_PATH . 'library/APIs/twitteroauth/Twitter.php';
class AffiliateController extends AffiliateBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function index()
    {
        $twitter = new Twitter($this->siteLangId);
        $this->set('twitterUrl', $twitter->getAuthUrl());
        
        $usrObj = new User();
        $loggedUserId = UserAuthentication::getLoggedUserId();
        $userInfo = User::getAttributesById($loggedUserId, array('user_fb_access_token', 'user_referral_code'));

        /*
        * Referred User Listing
        */
        $srch = $usrObj->referredByAffilates($loggedUserId);
        $srch->setPageSize(applicationConstants::DASHBOARD_PAGE_SIZE);
        $rs = $srch->getResultSet();
        $user_listing = FatApp::getDb()->fetchAll($rs);

        /*
        * Transactions Listing
        */
        $srch = Transactions::getUserTransactionsObj($loggedUserId);
        $srch->setPageSize(applicationConstants::DASHBOARD_PAGE_SIZE);
        $rs = $srch->getResultSet();
        $transactions = FatApp::getDb()->fetchAll($rs, 'utxn_id');

        $txnObj = new Transactions();
        $txnsSummary = $txnObj->getTransactionSummary($loggedUserId, date('Y-m-d'));
        $this->set('txnsSummary', $txnsSummary);

        $sharingFrm = $this->getSharingForm($this->siteLangId);
        $affiliateTrackingUrl = CommonHelper::affiliateReferralTrackingUrl($userInfo['user_referral_code']);
        $this->set('affiliateTrackingUrl', $affiliateTrackingUrl);
        $this->set('sharingFrm', $sharingFrm);
        $this->set('user_listing', $user_listing);
        $this->set('transactions', $transactions);
        $this->set('txnStatusArr', Transactions::getStatusArr($this->siteLangId));
        $this->set('txnStatusClassArr', Transactions::getStatusClassArr());
        $this->set('affiliateTrackingUrl', $affiliateTrackingUrl);
        $this->set('userBalance', User::getUserBalance($loggedUserId));
        $this->set('userRevenue', User::getAffiliateUserRevenue($loggedUserId));
        $this->set('todayRevenue', User::getAffiliateUserRevenue($loggedUserId, date('Y-m-d')));
        $this->_template->addJs('js/slick.min.js');
        $this->_template->render(true, true);
    }

    public function twitterCallback()
    {
        $get = FatApp::getQueryStringData();

        if (!empty($get['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {            
            $referralLink = CommonHelper::affiliateReferralTrackingUrl(UserAuthentication::getLoggedUserAttribute('user_referral_code'));

            $urlapi = "http://tinyurl.com/api-create.php?url=" . $referralLink;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $urlapi);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $shorturl = curl_exec($ch);
            curl_close($ch);
            $anchor_length = strlen($shorturl);
            $message = substr($shorturl . " " . sprintf(FatApp::getConfig("CONF_SOCIAL_FEED_TWITTER_POST_TITLE" . $this->siteLangId), FatApp::getConfig("CONF_WEBSITE_NAME_" . $this->siteLangId)), 0, 134 - $anchor_length);

            $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_SOCIAL_FEED_IMAGE, 0, 0, $this->siteLangId);
            $imagePath = isset($file_row['afile_physical_path']) ? $file_row['afile_physical_path'] : '';
            $imagePath = CONF_UPLOADS_PATH . $imagePath;

            $twitter = new Twitter($this->siteLangId);
            $response = $twitter->postTweet($get['oauth_verifier'], $imagePath, array(
                'Name' => FatApp::getConfig("CONF_WEBSITE_NAME_" . $this->siteLangId), 
                'status' => $message)
            );

            $this->set('errors', (false === $response) ? $twitter->getError() : false);
            $this->_template->render(true, false, 'affiliate/twitter-response.php');
        }
    }

    public function paymentInfoForm()
    {
        $loggedUserId = UserAuthentication::getLoggedUserId();
        $frm = $this->getPaymentInfoForm($this->siteLangId);
        $userExtraData = User::getUserExtraData(
            $loggedUserId,
            array(
                'uextra_tax_id',
                'uextra_payment_method',
                'uextra_cheque_payee_name',
                'uextra_paypal_email_id'
            )
        );
        if ($userExtraData['uextra_payment_method'] == 0) {
            $userExtraData['uextra_payment_method'] = User::AFFILIATE_PAYMENT_METHOD_CHEQUE;
        }
        $userObj = new User($loggedUserId);
        $userBankInfo = $userObj->getUserBankInfo();
        $frmData = $userExtraData;
        if (is_array($userBankInfo) && !empty($userBankInfo)) {
            $frmData = array_merge($frmData, $userBankInfo);
        }
        $frm->fill($frmData);
        $this->set('userExtraData', $frmData);
        $this->set('frm', $frm);
        $this->_template->render();
    }

    public function setUpPaymentInfo()
    {
        $frm = $this->getPaymentInfoForm($this->siteLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if ($post == false) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            if (FatUtility::isAjaxCall()) {
                FatUtility::dieWithError(Message::getHtml());
            }
            FatApp::redirectUser(UrlHelper::generateUrl('Affiliate'));
        }

        $loggedUserId = UserAuthentication::getLoggedUserId();
        $userObj = new User($loggedUserId);

        /* saving user extras[ */
        $dataToSave = array(
            'uextra_user_id' => $loggedUserId,
            'uextra_tax_id' => $post['uextra_tax_id'],
            'uextra_payment_method' => $post['uextra_payment_method'],
            'uextra_cheque_payee_name' => $post['uextra_cheque_payee_name'],
            'uextra_paypal_email_id' => $post['uextra_paypal_email_id'],
        );
        $dataToUpdateOnDuplicate = $dataToSave;
        unset($dataToUpdateOnDuplicate['uextra_user_id']);
        if (!FatApp::getDb()->insertFromArray(User::DB_TBL_USR_EXTRAS, $dataToSave, false, array(), $dataToUpdateOnDuplicate)) {
            Message::addErrorMessage(Labels::getLabel("LBL_Details_could_not_be_saved!", $this->siteLangId));
            if (FatUtility::isAjaxCall()) {
                FatUtility::dieWithError(Message::getHtml());
            }
            FatApp::redirectUser(UrlHelper::generateUrl('Account', 'ProfileInfo'));
        }
        /* ] */

        /* saving user bank details[ */
        $bankInfoData = array(
            'ub_bank_name' => $post['ub_bank_name'],
            'ub_account_holder_name' => $post['ub_account_holder_name'],
            'ub_account_number' => $post['ub_account_number'],
            'ub_ifsc_swift_code' => $post['ub_ifsc_swift_code'],
            'ub_bank_address' => $post['ub_bank_address'],
        );
        if (!$userObj->updateBankInfo($bankInfoData)) {
            Message::addErrorMessage($userObj->getError());
            if (FatUtility::isAjaxCall()) {
                FatUtility::dieWithError(Message::getHtml());
            }
            FatApp::redirectUser(UrlHelper::generateUrl('Account', 'ProfileInfo'));
        }
        /* ] */

        $this->set('msg', Labels::getLabel('MSG_Payment_details_saved_successfully!', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function setUpMailAffiliateSharing()
    {
        $sharingFrm = $this->getSharingForm($this->siteLangId);
        $post = $sharingFrm->getFormDataFromArray(FatApp::getPostedData());

        if ($post == false) {
            Message::addErrorMessage(current($sharingFrm->getValidationErrors()));
            FatUtility::dieWithError(Message::getHtml());
        }

        $error = '';
        FatUtility::validateMultipleEmails($post["email"], $error);
        if ($error != '') {
            Message::addErrorMessage($error);
            FatUtility::dieWithError(Message::getHtml());
        }
        $emailsArr = CommonHelper::multipleExplode(array(",", ";", "\t", "\n"), trim($post["email"], ","));
        $emailsArr = array_unique($emailsArr);
        if (count($emailsArr) && !empty($emailsArr)) {
            $personalMessage = empty($post['message']) ? "" : "<b>" . Labels::getLabel('Lbl_Personal_Message_From_Affiliate', $this->siteLangId) . ":</b> " . nl2br($post['message']);
            $emailNotificationObj = new EmailHandler();
            foreach ($emailsArr as $email_id) {
                $email_id = trim($email_id);
                if (!CommonHelper::isValidEmail($email_id)) {
                    continue;
                }

                /* email notification handling[ */
                $emailNotificationObj = new EmailHandler();
                if (!$emailNotificationObj->sendAffiliateMailShare(UserAuthentication::getLoggedUserId(), $email_id, $personalMessage, $this->siteLangId)) {
                    Message::addErrorMessage(Labels::getLabel($emailNotificationObj->getError(), $this->siteLangId));
                    CommonHelper::redirectUserReferer();
                }
                /* ] */
            }
        }

        $this->set('msg', Labels::getLabel('MSG_invitation_emails_sent_successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function addressInfo()
    {
        $loggedUserId = UserAuthentication::getLoggedUserId();
        $siteLangId = $this->siteLangId;
        $userExtraData = User::getUserExtraData($loggedUserId, array('uextra_company_name', 'uextra_website'));
        $srch = User::getSearchObject();
        $srch->joinTable(Countries::DB_TBL, 'LEFT OUTER JOIN', 'u.user_country_id = c.country_id', 'c');
        $srch->joinTable(Countries::DB_TBL_LANG, 'LEFT OUTER JOIN', 'c.country_id = c_l.countrylang_country_id AND countrylang_lang_id = ' . $siteLangId, 'c_l');
        $srch->joinTable(States::DB_TBL, 'LEFT OUTER JOIN', 'u.user_state_id = s.state_id', 's');
        $srch->joinTable(States::DB_TBL_LANG, 'LEFT OUTER JOIN', 's.state_id = s_l.statelang_state_id AND statelang_lang_id = ' . $siteLangId, 's_l');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields(array('user_address1', 'user_address2', 'user_zip', 'user_city', 'IFNULL(country_name, country_code) as country_name', 'IFNULL(state_name, state_identifier) as state_name'));
        $srch->addCondition('user_id', '=', $loggedUserId);
        $rs = $srch->getResultSet();
        $userData = FatApp::getDb()->fetch($rs);

        $userExtraData = (!empty($userExtraData)) ? $userExtraData : array('uextra_company_name' => '', 'uextra_website' => '');
        $userData = array_merge($userData, $userExtraData);

        $this->set('userData', $userData);
        $this->_template->render(false, false);
    }

    private function getPaymentInfoForm($siteLangId)
    {
        $siteLangId = FatUtility::int($siteLangId);
        $frm = new Form('frmPaymentInfoForm');

        $frm->addRadioButtons(Labels::getLabel('FRM_PAYMENT_METHOD', $siteLangId), 'uextra_payment_method', User::getAffiliatePaymentMethodArr($siteLangId), User::AFFILIATE_PAYMENT_METHOD_CHEQUE, array('class' => 'list-radio'));
        $frm->addTextBox(Labels::getLabel('FRM_TAX_ID', $siteLangId), 'uextra_tax_id');
        $frm->addTextBox(Labels::getLabel('FRM_CHEQUE_PAYEE_NAME', $siteLangId), 'uextra_cheque_payee_name');

        $frm->addTextBox(Labels::getLabel('FRM_BANK_NAME', $siteLangId), 'ub_bank_name');
        $frm->addTextBox(Labels::getLabel('FRM_ACCOUNT_HOLDER_NAME', $siteLangId), 'ub_account_holder_name');
        $frm->addTextBox(Labels::getLabel('FRM_BANK_ACCOUNT_NUMBER', $siteLangId), 'ub_account_number');
        $frm->addTextBox(Labels::getLabel('FRM_SWIFT_CODE', $siteLangId), 'ub_ifsc_swift_code');
        $frm->addTextArea(Labels::getLabel('FRM_BANK_ADDRESS', $siteLangId), 'ub_bank_address');

        $fld = $frm->addTextBox(Labels::getLabel('FRM_PAYPAL_EMAIL_ACCOUNT', $siteLangId), 'uextra_paypal_email_id');
        $fld->requirements()->setEmail();

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_REGISTER', $siteLangId));
        $frm->setFormTagAttribute('onsubmit', 'setupAffiliateRegister(this); return(false);');
        return $frm;
    }

    private function getSharingForm($siteLangId)
    {
        $siteLangId = FatUtility::int($siteLangId);
        $frm = new Form('frmAffiliateSharingForm');
        $fld = $frm->addTextArea(Labels::getLabel('FRM_FRIENDS_EMAIL', $siteLangId), 'email');
        $str = Labels::getLabel('FRM_USE_COMMAS_SEPARATE_EMAILS', $siteLangId);
        $str .= ", " . Labels::getLabel("FRM_DO_NOT_USE_SPACE_AND_COMMA_AT_END_OF_STRING", $siteLangId);
        $fld->htmlAfterField = ' <small>(' . $str . ')</small>';
        $fld->requirements()->setRequired();
        $frm->addTextArea(Labels::getLabel('FRM_PERSONAL_MESSAGE', $siteLangId), 'message');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_INVITE_YOUR_FRIENDS', $siteLangId));
        return $frm;
    }

    public function referredByMe()
    {
        $loggedUserId = UserAuthentication::getLoggedUserId();

        $usrObj = new User();
        $srch = $usrObj->referredByAffilates($loggedUserId);
        $srch->setPageSize(applicationConstants::DASHBOARD_PAGE_SIZE);
        $rs = $srch->getResultSet();
        $user_listing = FatApp::getDb()->fetchAll($rs);
        $frmSearch = $this->getUserSearchForm();

        $this->set('user_listing', $user_listing);
        $this->set('frmSearch', $frmSearch);
        $this->set('user_listing', $user_listing);
        $this->set('keywordPlaceholder', Labels::getLabel('LBL_NAME_OR_EMAIL', $this->siteLangId));
        $this->_template->render(true, true);
    }

    private function getUserSearchForm()
    {
        $frm = new Form('frmUserSearch');
        $keyword = $frm->addTextBox(Labels::getLabel('FRM_NAME_OR_EMAIL', $this->siteLangId), 'keyword', '', array('id' => 'keyword', 'autocomplete' => 'off'));

        $arr_options = array('-1' => Labels::getLabel('FRM_DOES_NOT_MATTER', $this->siteLangId)) + applicationConstants::getActiveInactiveArr($this->siteLangId);
        $arr_options1 = array('-1' => Labels::getLabel('FRM_DOES_NOT_MATTER', $this->siteLangId)) + applicationConstants::getYesNoArr($this->siteLangId);

        $frm->addSelectBox(Labels::getLabel('FRM_ACTIVE_USERS', $this->siteLangId), 'user_active', $arr_options, -1, array(), '');
        $frm->addSelectBox(Labels::getLabel('FRM_EMAIL_VERIFIED', $this->siteLangId), 'user_verified', $arr_options1, -1, array(), '');

        $frm->addHiddenField('', 'page', 1);
        $frm->addHiddenField('', 'user_id', '');
        $frm->addHiddenField('', 'total_record_count', '');

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm, 'btn btn-clear');

        return $frm;
    }

    public function userSearch()
    {
        $loggedUserId = UserAuthentication::getLoggedUserId();
        $pagesize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);
        $frmSearch = $this->getUserSearchForm();

        $data = FatApp::getPostedData();
        $post = $frmSearch->getFormDataFromArray($data);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }

        $userObj = new User();
        $srch = $userObj->referredByAffilates($loggedUserId);
        $user_id = FatApp::getPostedData('user_id', FatUtility::VAR_INT, -1);
        if ($user_id > 0) {
            $srch->addCondition('user_id', '=', $user_id);
        } else {
            $keyword = FatApp::getPostedData('keyword', null, '');
            if (!empty($keyword)) {
                $cond = $srch->addCondition('uc.credential_username', 'like', '%' . $keyword . '%');
                $cond->attachCondition('uc.credential_email', 'like', '%' . $keyword . '%', 'OR');
                $cond->attachCondition('u.user_name', 'like', '%' . $keyword . '%');
            }
        }

        $user_active = FatApp::getPostedData('user_active', FatUtility::VAR_INT, -1);
        if ($user_active > -1) {
            $srch->addCondition('uc.credential_active', '=', $user_active);
        }

        $user_verified = FatApp::getPostedData('user_verified', FatUtility::VAR_INT, -1);
        if ($user_verified > -1) {
            $srch->addCondition('uc.credential_verified', '=', $user_verified);
        }

        $this->setRecordCount(clone $srch, $pagesize, $page, $post);
        $srch->doNotCalculateRecords();
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $this->set("arrListing", FatApp::getDb()->fetchAll($srch->getResultSet(), 'user_id'));
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    public function autoCompleteJson()
    {
        $post = FatApp::getPostedData();
        $pagesize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);
        $loggedUserId = UserAuthentication::getLoggedUserId();
        $userObj = new User();
        $srch = $userObj->referredByAffilates($loggedUserId);
        $srch->addOrder('user_name', 'ASC');
        $keyword = FatApp::getPostedData('keyword', null, '');
        if (!empty($keyword)) {
            $cond = $srch->addCondition('uc.credential_username', 'like', '%' . $keyword . '%');
            $cond->attachCondition('uc.credential_email', 'like', '%' . $keyword . '%', 'OR');
            $cond->attachCondition('u.user_name', 'like', '%' . $keyword . '%');
        }

        $srch->setPageSize($pagesize);

        $rs = $srch->getResultSet();
        $db = FatApp::getDb();
        $users = $db->fetchAll($rs, 'user_id');

        $json = array();
        foreach ($users as $key => $user) {
            $json[] = array(
                'id' => $key,
                'name' => strip_tags(html_entity_decode($user['user_name'], ENT_QUOTES, 'UTF-8')),
                'username' => strip_tags(html_entity_decode($user['credential_username'], ENT_QUOTES, 'UTF-8')),
                'credential_email' => strip_tags(html_entity_decode($user['credential_email'], ENT_QUOTES, 'UTF-8')),
            );
        }

        die(json_encode($json));
    }
}
