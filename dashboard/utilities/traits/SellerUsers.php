<?php

trait SellerUsers
{
    protected function getUserSearchForm()
    {
        $frm = new Form('frmSearch');
        $frm->addHiddenField('', 'total_record_count');
        $frm->addHiddenField('', 'page', 1);
        $frm->addTextBox('', 'keyword', '', array('id' => 'keyword'));

        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    public function users()
    {
        if ($this->userParentId != UserAuthentication::getLoggedUserId()) {
            $msg = Labels::getLabel('LBL_UNAUTHORIZED_ACCESS!', $this->siteLangId);
            if (FatUtility::isAjaxCall()) {
                FatUtility::dieWithError($msg);
            }
            Message::addErrorMessage($msg);
            FatApp::redirectUser(UrlHelper::generateUrl('seller'));
        }
        $this->set('frmSearch', $this->getUserSearchForm());
        $this->set('canEdit', true);
        $this->set('keywordPlaceholder', Labels::getLabel('LBL_SEARCH_BY_USERNAME', $this->siteLangId));
        $this->set('statusButtons', true);
        $this->set('newRecordBtn', true);
        $this->set('newRecordBtnAttrs', [
            'attr' => [
                'onclick' => 'addUserForm(0);',
                'title' => Labels::getLabel('LBL_Add_User', $this->siteLangId)
            ]
        ]);
        $this->_template->render(true, true);
    }

    public function searchUsers()
    {
        $pageSize = FatApp::getConfig('CONF_PAGE_SIZE');
        $post = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $srch = User::getSearchObject(true, UserAuthentication::getLoggedUserId());
        if ($keyword = FatApp::getPostedData('keyword')) {
            $cnd = $srch->addCondition('user_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('credential_username', 'LIKE', '%' . $keyword . '%');
            $cnd->attachCondition('credential_email', 'LIKE', '%' . $keyword . '%');
        }
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(array('user_id', 'user_name', 'credential_username', 'credential_email', 'credential_active'));
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $this->set("arrListing", FatApp::getDb()->fetchAll($srch->getResultSet()));
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    private function getSubUserForm($userId = 0)
    {
        $frm = new Form('frmSocialPlatform');
        $frm->addHiddenField('', 'user_id', $userId);
        $frm->addRequiredField(Labels::getLabel('FRM_FULL_NAME', $this->siteLangId), 'user_name');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_USERNAME', $this->siteLangId), 'user_username');
        $fld->setUnique('tbl_user_credentials', 'credential_username', 'credential_user_id', 'user_id', 'user_id');
        $fld->requirements()->setRequired();
        $fld->requirements()->setUsername();
        $fld = $frm->addEmailField(Labels::getLabel('FRM_USER_EMAIL', $this->siteLangId), 'user_email', '');
        $fld->setUnique('tbl_user_credentials', 'credential_email', 'credential_user_id', 'user_id', 'user_id');
        $frm->addHiddenField('', 'user_phone_dcode');
        $phoneFld = $frm->addRequiredField(Labels::getLabel('FRM_PHONE', $this->siteLangId), 'user_phone');
        $phoneFld->requirements()->setRegularExpressionToValidate(ValidateElement::PHONE_REGEX);
        $phoneFld->requirements()->setCustomErrorMessage(Labels::getLabel('ERR_PLEASE_ENTER_VALID_PHONE_NUMBER_FORMAT.', $this->siteLangId));
        if ($userId == 0) {
            $fld = $frm->addPasswordField(Labels::getLabel('FRM_PASSWORD', $this->siteLangId), 'user_password');
            $fld->requirements()->setRequired();
            $fld->requirements()->setRegularExpressionToValidate(ValidateElement::PASSWORD_REGEX);
            $fld->requirements()->setCustomErrorMessage(Labels::getLabel('ERR_PASSWORD_MUST_BE_EIGHT_CHARACTERS_LONG_AND_ALPHANUMERIC', $this->siteLangId));
            $fld1 = $frm->addPasswordField(Labels::getLabel('FRM_CONFIRM_PASSWORD', $this->siteLangId), 'confirm_password');
            $fld1->requirements()->setRequired();
            $fld1->requirements()->setCompareWith('user_password', 'eq', Labels::getLabel('FRM_PASSWORD', $this->siteLangId));
        }

        $countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesAssocArr($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_COUNTRY', $this->siteLangId), 'user_country_id', $countriesArr, FatApp::getConfig('CONF_COUNTRY', FatUtility::VAR_INT, 0), array(), Labels::getLabel('FRM_SELECT', $this->siteLangId));
        $fld->requirement->setRequired(true);

        $frm->addSelectBox(Labels::getLabel('FRM_STATE', $this->siteLangId), 'user_state_id', array(), '', array(), Labels::getLabel('FRM_SELECT', $this->siteLangId))->requirement->setRequired(true);
        $frm->addTextBox(Labels::getLabel('FRM_CITY', $this->siteLangId), 'user_city');

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'user_active', $activeInactiveArr, '', array(), '');

        return $frm;
    }

    public function addSubUserForm($userId = 0)
    {
        $userId = FatUtility::int($userId);
        $frm = $this->getSubUserForm($userId);
        $stateId = 0;
        if (0 < $userId) {
            $srch = User::getSearchObject(true, UserAuthentication::getLoggedUserId());
            $srch->addMultipleFields(array('user_id', 'user_parent', 'user_name', 'user_phone_dcode', 'user_phone', 'user_country_id', 'user_state_id', 'user_city', 'credential_username', 'credential_email', 'credential_active'));
            $srch->addCondition('user_id', '=', 'mysql_func_' . $userId, 'AND', true);
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $rs = $srch->getResultSet();
            $data = FatApp::getDb()->fetch($rs);
            if ($data === false) {
                FatUtility::dieWithError(Labels::getLabel("LBL_INVALID_REQUEST", $this->siteLangId));
            }
            $data['user_username'] = $data['credential_username'];
            $data['user_email'] = $data['credential_email'];
            $data['user_active'] = $data['credential_active'];
            $frm->fill($data);
            $stateId = $data['user_state_id'];
        }
        $this->set('userId', $userId);
        $this->set('frm', $frm);
        $this->set('stateId', $stateId);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('language', Language::getAllNames());
        $this->_template->render(false, false);
    }

    public function setupSubUser()
    {
        if ($this->userParentId != UserAuthentication::getLoggedUserId()) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_UNAUTHORIZED_ACCESS!', $this->siteLangId));
        }
        $post = FatApp::getPostedData();

        $userId = $post['user_id'];
        $user_state_id = FatUtility::int($post['user_state_id']);
        $frm = $this->getSubUserForm($userId);

        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        if (0 < $userId) {
            $srch = User::getSearchObject(true, UserAuthentication::getLoggedUserId());
            $srch->addMultipleFields(array('user_id', 'user_parent', 'credential_username'));
            $srch->addCondition('user_id', '=', 'mysql_func_' . $userId, 'AND', true);
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $rs = $srch->getResultSet();
            $userData = FatApp::getDb()->fetch($rs);
            if (empty($userData) || $userData['user_parent'] != UserAuthentication::getLoggedUserId()) {
                FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            }
            $post['user_username'] = $userData['credential_username'];
        }

        if ($post == false) {
            $message = Labels::getLabel(current($frm->getValidationErrors()), $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $post['user_phone_dcode'] = FatApp::getPostedData('user_phone_dcode', FatUtility::VAR_STRING, '');
        $post['user_parent'] = UserAuthentication::getLoggedUserId();
        $post['user_state_id'] = $user_state_id;
        if (0 < $userId) {
            $post['user_password'] = null;
            $post['user_verify'] = null;
        } else {
            $post['user_registered_initially_for'] = User::USER_TYPE_SELLER;
            $post['user_preferred_dashboard'] = User::USER_SELLER_DASHBOARD;
            $post['user_is_supplier'] = applicationConstants::YES;
            $post['user_is_advertiser'] = applicationConstants::YES;
            $post['user_verify'] = applicationConstants::YES;
            $post['user_active'] = applicationConstants::ACTIVE;
        }
        $db = FatApp::getDb();
        $db->startTransaction();
        $userObj = new User($userId);
        $userObj->assignValues($post);
        if (!$userObj->save()) {
            $db->rollbackTransaction();
            $message = Labels::getLabel($userObj->getError(), $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        if (!$userObj->setLoginCredentials($post['user_username'], $post['user_email'], $post['user_password'], $post['user_active'], $post['user_verify'])) {
            $db->rollbackTransaction();
            $message = Labels::getLabel($userObj->getError(), $this->siteLangId);
            FatUtility::dieJsonError($message);
        }

        $db->commitTransaction();

        $this->set('msg', Labels::getLabel('MSG_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function changeUserStatus()
    {
        if ($this->userParentId != UserAuthentication::getLoggedUserId()) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_UNAUTHORIZED_ACCESS!', $this->siteLangId));
        }
        $userId = FatApp::getPostedData('userId', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        $userData = User::getAttributesById($userId);
        if (empty($userData) || $userData['user_parent'] != UserAuthentication::getLoggedUserId()) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }

        $this->updateUserStatus($userId, $status);

        $this->set('msg', Labels::getLabel('MSG_Status_changed_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleSellerUserStatus()
    {
        if ($this->userParentId != UserAuthentication::getLoggedUserId()) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_UNAUTHORIZED_ACCESS!', $this->siteLangId));
        }
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $userIdsArr = FatUtility::int(FatApp::getPostedData('user_ids'));
        if (empty($userIdsArr) || -1 == $status) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }

        foreach ($userIdsArr as $userId) {
            if (1 > $userId) {
                continue;
            }

            $this->updateUserStatus($userId, $status);
        }
        $this->set('msg', Labels::getLabel('MSG_Status_changed_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updateUserStatus($userId, $status)
    {
        if ($this->userParentId != UserAuthentication::getLoggedUserId()) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_UNAUTHORIZED_ACCESS!', $this->siteLangId));
        }
        $status = FatUtility::int($status);
        $userId = FatUtility::int($userId);
        if (1 > $userId || -1 == $status) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }

        $userObj = new User($userId);

        if (!$userObj->activateAccount($status)) {
            FatUtility::dieJsonError($userObj->getError());
        }
    }

    public function subUserPasswordForm($userId = 0)
    {
        $userId = FatUtility::int($userId);
        $frm = $this->getChangePasswordForm($userId);

        $this->set('frm', $frm);
        $this->set('userId', $userId);
        $this->_template->render(false, false);
    }

    private function getChangePasswordForm($userId)
    {
        $frm = new Form('changePwdFrm');
        $frm->addHiddenField('', 'user_id', $userId);
        $newPwd = $frm->addPasswordField(Labels::getLabel('FRM_NEW_PASSWORD', $this->siteLangId), 'new_password');
        $newPwd->requirements()->setRequired();
        $newPwd->requirements()->setRegularExpressionToValidate(ValidateElement::PASSWORD_REGEX);
        $newPwd->requirements()->setCustomErrorMessage(Labels::getLabel('MSG_PASSWORD_MUST_BE_ATLEAST_EIGHT_CHARACTERS_LONG_AND_ALPHANUMERIC', $this->siteLangId));
        $conNewPwd = $frm->addPasswordField(
            Labels::getLabel('FRM_CONFIRM_NEW_PASSWORD', $this->siteLangId),
            'conf_new_password'
        );
        $conNewPwdReq = $conNewPwd->requirements();
        $conNewPwdReq->setRequired();
        $conNewPwdReq->setCompareWith('new_password', 'eq');
        return $frm;
    }

    public function updateUserPassword()
    {
        if ($this->userParentId != UserAuthentication::getLoggedUserId()) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_UNAUTHORIZED_ACCESS!', $this->siteLangId));
        }
        $post = FatApp::getPostedData();
        $userId = $post['user_id'];
        $frm = $this->getChangePasswordForm($userId);

        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieWithError(Message::getHtml());
        }

        $userData = User::getAttributesById($userId);
        if (empty($userData) || $userData['user_parent'] != UserAuthentication::getLoggedUserId()) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $password = $post['new_password'];
        $encryptedPassword = UserAuthentication::encryptPassword($password);

        $arrFlds['credential_password'] = $encryptedPassword;

        $user = new User();
        if (!$user->setLoginPassword($post['new_password'], $userId)) {
            $message = Labels::getLabel('MSG_Password_could_not_be_set', $this->siteLangId) . $user->getError();
            FatUtility::dieWithError(Message::getHtml());
        }

        $this->set('msg', Labels::getLabel('MSG_PASSWORD_UPDATED_SUCCESSFUL', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function searchPermissionForm()
    {
        $frm = new Form('frmPrmSrchFrm');
        $frm->addHiddenField('', 'user_id');
        return $frm;
    }

    private function getAllAccessForm()
    {
        $permissionArr = UserPrivilege::getPermissionArr($this->siteLangId);
        $frm = new Form('frmAllAccess');
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_SELECT_PERMISSION_FOR_ALL_MODULES', $this->siteLangId), 'permissionForAll', $permissionArr, '', array(), Labels::getLabel('FRM_SELECT', $this->siteLangId));
        $fld->requirements()->setRequired();
        $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('BTN_APPLY_TO_ALL', $this->siteLangId), array('onclick' => 'updatePermission(0);return false;'));
        return $frm;
    }

    public function userPermissions($userId = 0)
    {
        $userId = FatUtility::int($userId);
        $userData = User::getAttributesById($userId);
        if (empty($userData) || $userId == UserAuthentication::getLoggedUserId() || $userData['user_parent'] != UserAuthentication::getLoggedUserId()) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('seller', 'users'));
        }
        $frm = $this->searchPermissionForm();
        $allAccessfrm = $this->getAllAccessForm();

        $frm->fill(array('user_id' => $userId));

        $this->set('user_id', $userId);
        $this->set('frm', $frm);
        $this->set('allAccessfrm', $allAccessfrm);
        $this->set('userData', $userData);
        $this->_template->render();
    }

    public function userRoles()
    {
        $frmSearch = $this->searchPermissionForm();
        $post = $frmSearch->getFormDataFromArray(FatApp::getPostedData());
        $userId = FatUtility::int($post['user_id']);

        $userData = array();
        if ($userId > 0) {
            $userData = UserPermission::getSellerPermissions($userId);
        }

        $permissionModules = UserPrivilege::getModuleSpecificPermissionArr($this->siteLangId);
        $this->set('arrListing', $permissionModules);
        $this->set('modulesArr', UserPrivilege::getSellerModulesArr($this->siteLangId));
        $this->set('userData', $userData);
        $this->_template->render(false, false);
    }

    public function updatePermission($moduleId, $permission)
    {
        if ($this->userParentId != UserAuthentication::getLoggedUserId()) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_UNAUTHORIZED_ACCESS!', $this->siteLangId));
        }
        $moduleId = FatUtility::int($moduleId);
        $permission = FatUtility::int($permission);

        $frmSearch = $this->searchPermissionForm();
        $post = $frmSearch->getFormDataFromArray(FatApp::getPostedData());

        $userId = FatUtility::int($post['user_id']);
        $userData = User::getAttributesById($userId);
        if (empty($userData) || $userId == UserAuthentication::getLoggedUserId() || $userData['user_parent'] != UserAuthentication::getLoggedUserId()) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }
        $data = array(
            'userperm_user_id' => $userId,
            'userperm_section_id' => $moduleId,
            'userperm_value' => $permission,
        );
        $userPermission = new UserPermission();
        if ($moduleId == 0) {
            if (!$userPermission->updatePermissions($this->siteLangId, $data, true)) {
                FatUtility::dieJsonError($userPermission->getError());
            }
        } else {
            $permissionModules = UserPrivilege::getSellerPermissionModulesArr($this->siteLangId);
            $permissionArr = UserPrivilege::getPermissionArr($this->siteLangId);
            if (!array_key_exists($moduleId, $permissionModules) || !array_key_exists($permission, $permissionArr)) {
                FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            }
            if (!$userPermission->updatePermissions($this->siteLangId, $data)) {
                FatUtility::dieJsonError($userPermission->getError());
            }
        }

        $this->set('msg', Labels::getLabel('MSG_Updated_Successfully', $this->siteLangId));
        $this->set('moduleId', $moduleId);
        $this->_template->render(false, false, 'json-success.php');
    }
}
