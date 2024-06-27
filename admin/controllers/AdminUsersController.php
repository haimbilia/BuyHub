<?php

class AdminUsersController extends ListingBaseController
{
    protected string $modelClass = 'AdminUsers';
    protected $pageKey = 'MANAGE_ADMIN_USERS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewAdminUsers();
    }

    /**
     * checkEditPrivilege - This function is used to check, set previlege and can be also used in parent class to validate request.
     *
     * @param  bool $setVariable
     * @return void
     */
    protected function checkEditPrivilege(bool $setVariable = false): void
    {
        if (true === $setVariable) {
            $this->set("canEdit", $this->objPrivilege->canEditAdminUsers($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditAdminUsers();
        }
    }

    public function setProcedurePermission()
    {
        $db = FatApp::getDb();
        $con = $db->getConnectionObject();
        if (!$con->query("SET GLOBAL log_bin_trust_function_creators = 1")) {
            die($con->error);
        }
        echo "Done";
    }

    public function createProcedures()
    {
        $db = FatApp::getDb();
        $con = $db->getConnectionObject();
        $queries = array(
            "DROP FUNCTION IF EXISTS `GETBLOGCATCODE`",
            "CREATE FUNCTION `GETBLOGCATCODE`(`id` INT) RETURNS varchar(255) CHARSET utf8
			BEGIN
				DECLARE code VARCHAR(255);
				DECLARE catid INT(11);

				SET catid = id;
				SET code = '';
				WHILE catid > 0  AND LENGTH(code) < 240 DO
					SET code = CONCAT(RIGHT(CONCAT('000000', catid), 6), '_', code);
					SELECT bpcategory_parent INTO catid FROM tbl_blog_post_categories WHERE bpcategory_id = catid;
				END WHILE;
				RETURN code;
			END",
            "DROP FUNCTION IF EXISTS `GETCATCODE`",
            "CREATE FUNCTION `GETCATCODE`(`id` INT) RETURNS varchar(255) CHARSET utf8
			BEGIN
				DECLARE code VARCHAR(255);
				DECLARE catid INT(11);

				SET catid = id;
				SET code = '';
				WHILE catid > 0 AND LENGTH(code) < 240 DO
					SET code = CONCAT(RIGHT(CONCAT('000000', catid), 6), '_', code);
					SELECT prodcat_parent INTO catid FROM tbl_product_categories WHERE prodcat_id = catid;
				END WHILE;
				RETURN code;
			END",
            "DROP FUNCTION IF EXISTS `GETCATORDERCODE`",
            "CREATE FUNCTION `GETCATORDERCODE`(`id` INTEGER) RETURNS varchar(255) CHARSET utf8
			BEGIN
				DECLARE code VARCHAR(255);
				DECLARE catid INT(11);
				DECLARE myorder INT(11);
				SET catid = id;
				SET code = '';
				set myorder = 0;
				WHILE catid > 0 DO
					SELECT prodcat_parent, prodcat_display_order  INTO catid, myorder FROM tbl_product_categories WHERE prodcat_id = catid;
					SET code = CONCAT(RIGHT(CONCAT('000000', myorder), 6), code);
				END WHILE;
				RETURN code;
			END",
            "DROP FUNCTION IF EXISTS `GETBLOGCATORDERCODE`",
            "CREATE FUNCTION `GETBLOGCATORDERCODE`(`id` INT) RETURNS varchar(500) CHARSET utf8
			BEGIN
				DECLARE code VARCHAR(255);
				DECLARE catid INT(11);
				DECLARE myorder INT(11);
				SET catid = id;
				SET code = '';
				set myorder = 0;
				WHILE catid > 0 DO
					SELECT bpcategory_parent, bpcategory_display_order  INTO catid, myorder FROM tbl_blog_post_categories WHERE bpcategory_id = catid;
					SET code = CONCAT(RIGHT(CONCAT('000000', myorder), 6), code);
				END WHILE;
				RETURN code;
			END",
            "DROP PROCEDURE IF EXISTS UPDATECATEGORYRELATIONS",
            "CREATE PROCEDURE UPDATECATEGORYRELATIONS(IN catId INT)
            BEGIN
               DECLARE levelCounter INT DEFAULT 0;
               DECLARE maxLevel INT DEFAULT 20;
               WHILE levelCounter <= maxLevel DO
                    /**Sql statement**/
                    IF 0 < catId THEN 
                        DELETE FROM `tbl_product_category_relations` WHERE `pcr_prodcat_id` = catId;
                    END IF;
            
                    IF 1 > levelCounter THEN 
                        INSERT IGNORE INTO `tbl_product_category_relations`(`pcr_prodcat_id`, `pcr_parent_id`, `pcr_level`) 
                        SELECT prodcat_id, prodcat_id, 0 FROM `tbl_product_categories` WHERE (CASE WHEN 0 < catId THEN prodcat_id = catId ELSE TRUE END) ORDER BY prodcat_id ASC;
                        INSERT IGNORE INTO `tbl_product_category_relations`(`pcr_prodcat_id`, `pcr_parent_id`, `pcr_level`)
                        SELECT prodcat_id, prodcat_parent, 1 FROM `tbl_product_categories` WHERE prodcat_parent > 0 AND (CASE WHEN 0 < catId THEN prodcat_id = catId ELSE TRUE END) ORDER BY prodcat_id ASC;
                    END IF;
            
                    INSERT IGNORE INTO `tbl_product_category_relations`(`pcr_prodcat_id`, `pcr_parent_id`, `pcr_level`)
                    SELECT prodcat_id, pcr_parent_id, (pcr_level+1) FROM `tbl_product_categories`
                    INNER JOIN tbl_product_category_relations ON pcr_prodcat_id = prodcat_parent
                    WHERE pcr_prodcat_id != pcr_parent_id 
                    AND (CASE WHEN 0 < catId THEN prodcat_id = catId ELSE TRUE END) 
                    ORDER BY prodcat_id ASC;
            
                    IF 0 < catId THEN 
                        SET levelCounter = maxLevel;
                    END IF;
                    
                    SET levelCounter = levelCounter + 1;
               END WHILE;
            END",
            "DROP TRIGGER IF EXISTS `ADDNEWCATEGORY`",
            "CREATE TRIGGER `ADDNEWCATEGORY`
            AFTER INSERT ON `tbl_product_categories` 
            FOR EACH ROW 
            CALL UPDATECATEGORYRELATIONS(new.prodcat_id)",
            "DROP TRIGGER IF EXISTS `UPDATECATEGORY`",
            "CREATE TRIGGER `UPDATECATEGORY` AFTER UPDATE ON `tbl_product_categories`
            FOR EACH ROW IF new.prodcat_parent != old.prodcat_parent THEN 
               CALL UPDATECATEGORYRELATIONS(new.prodcat_id);
               CALL UPDATECATEGORYRELATIONS(old.prodcat_parent);
            END IF",
            "CALL updateCategoryRelations(0)",
            "DROP PROCEDURE IF EXISTS updateShopUserValid",
            "CREATE PROCEDURE updateShopUserValid(IN userId INT)
            BEGIN    
                -- Set shop_user_valid to 0 where shop_user_id matches the input userId
                UPDATE tbl_shops SET shop_user_valid = 0 WHERE shop_user_id = userId;
              
                -- Set shop_user_valid to 1 based on the conditions in the subquery
                UPDATE tbl_shops SET shop_user_valid = 1 WHERE shop_user_id = ( SELECT u.user_id FROM tbl_users u INNER JOIN tbl_user_credentials c ON u.user_id = c.credential_user_id WHERE u.user_id = userId AND u.user_is_supplier = 1 AND u.user_deleted = 0 AND c.credential_active = 1 AND c.credential_verified = 1 LIMIT 1 );
            END",
            "DROP TRIGGER IF EXISTS `ON_USER_CREDENTIALS_INSERT`",
            "CREATE TRIGGER ON_USER_CREDENTIALS_INSERT
            AFTER INSERT
            ON tbl_user_credentials
            FOR EACH ROW
            BEGIN
                CALL updateShopUserValid(NEW.credential_user_id);
            END",
            "DROP TRIGGER IF EXISTS `ON_USERS_UPDATE`",
            "CREATE TRIGGER ON_USERS_UPDATE
            AFTER UPDATE
            ON tbl_users
            FOR EACH ROW
            BEGIN
                IF NEW.user_deleted != OLD.user_deleted THEN
                    CALL updateShopUserValid(NEW.user_id);
                END IF;      
            END",
            "DROP TRIGGER IF EXISTS `ON_USER_CREDENTIALS_UPDATE`",
            "CREATE TRIGGER ON_USER_CREDENTIALS_UPDATE
            AFTER UPDATE
            ON tbl_user_credentials
            FOR EACH ROW
            BEGIN
                IF NEW.credential_active != OLD.credential_active OR NEW.credential_verified != OLD.credential_verified THEN
                    CALL updateShopUserValid(NEW.credential_user_id);
                END IF;     
            END"
        );

        foreach ($queries as $qry) {
            if (!$con->query($qry)) {
                die($con->error);
            }
        }
        echo 'Created All the Procedures.';
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['statusButtons'] = true;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_NAME,_USERNAME_OR_EMAIL', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(array('js/select2.js', 'admin-users/page-js/index.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'admin-users/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);

        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $searchForm = $this->getSearchForm($fields);
        $postedData = FatApp::getPostedData();
        $post = $searchForm->getFormDataFromArray($postedData);

        $srch = AdminUsers::getSearchObject(false);
        $srch->addCondition('admin_id', '!=', 'mysql_func_' . $this->admin_id, 'AND', true);
        $srch->addCondition('admin_id', '!=', 'mysql_func_1', 'AND', true);

        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        if (!empty($keyword)) {
            $cond = $srch->addCondition('adu.admin_username', 'like', '%' . $keyword . '%');
            $cond->attachCondition('adu.admin_name', 'like', '%' . $keyword . '%', 'OR');
            $cond->attachCondition('adu.admin_email', 'like', '%' . $keyword . '%');
        }
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();

        $srch->addOrder($sortBy, $sortOrder);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set("arrListing", $records);
        $paginationArr = empty($postedData) ? $post : $postedData;
        $this->set('postedData', $paginationArr);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('adminLoggedInId', $this->admin_id);
        $this->set('canEdit', $this->objPrivilege->canEditAdminUsers($this->admin_id, true));
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);

        if (0 < $recordId) {
            $data = AdminUsers::getAttributesById($recordId);

            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('includeTabs', false);
        $this->set('formTitle', Labels::getLabel('LBL_ADMIN_USER_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditAdminUsers();

        $post = FatApp::getPostedData();

        $recordId = FatUtility::int($post['admin_id']);
        if (1 == $recordId || $recordId == $this->admin_id) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getForm($recordId);
        $post = $frm->getFormDataFromArray($post);
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }
        unset($post['admin_id']);
        $record = new AdminUsers($recordId);

        if (0 < $recordId) {
            $data = AdminUsers::getAttributesById($recordId);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request_id, true);
            }
            $post['admin_username'] = $data['admin_username'];
        } else {
            $password = $post['password'];
            $encryptedPassword = UserAuthentication::encryptPassword($password);
            $post['admin_password'] = $encryptedPassword;
        }

        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $this->set('recordId', $record->getMainTableRecordId());
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function changePassword($recordId)
    {
        $recordId = FatUtility::int($recordId);
        $frm = $this->getChangePasswordForm($recordId);

        if (2 > $recordId || $recordId == $this->admin_id) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $data = AdminUsers::getAttributesById($recordId);

        $this->set('frm', $frm);
        $this->set('recordId', $recordId);
        $this->set('adminProfile', $data);
        $this->set('includeTabs', false);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function updatePassword()
    {
        $this->objPrivilege->canEditAdminUsers();

        $post = FatApp::getPostedData();
        $recordId = FatUtility::int($post['admin_id']);
        unset($post['admin_id']);

        if (2 > $recordId || $recordId == $this->admin_id) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getChangePasswordForm($recordId);
        $post = $frm->getFormDataFromArray($post);

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $record = new AdminUsers($recordId);

        $password = $post['password'];
        $encryptedPassword = UserAuthentication::encryptPassword($password);
        $post['admin_password'] = $encryptedPassword;

        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }


        $this->set('recordId', $recordId);
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm(int $recordId = 0)
    {
        $frm = new Form('frmAdminUser');
        $frm->addHiddenField('', 'admin_id', $recordId);
        $frm->addRequiredField(Labels::getLabel('FRM_FULL_NAME', $this->siteLangId), 'admin_name');

        $attr = [];
        if (0 < $recordId) {
            $attr = ['disabled' => 'disabled'];
        }
        $fld = $frm->addTextBox(Labels::getLabel('FRM_USERNAME', $this->siteLangId), 'admin_username', '', $attr);
        $fld->setUnique(AdminUsers::DB_TBL, AdminUsers::DB_TBL_PREFIX . 'username', 'admin_id', 'admin_id', 'admin_id');
        $fld->requirements()->setRequired();
        $fld->requirements()->setUsername();
        $emailFld = $frm->addRequiredField(Labels::getLabel('FRM_EMAIL', $this->siteLangId), 'admin_email', '', array('id' => 'admin_username'));
        $emailFld->setUnique(AdminUsers::DB_TBL, AdminUsers::DB_TBL_PREFIX . 'email', 'admin_id', 'admin_id', 'admin_id');

        if ($recordId == 0) {
            $fld = $frm->addPasswordField(Labels::getLabel('FRM_PASSWORD', $this->siteLangId), 'password');
            $fld->requirements()->setRequired();
            $fld->requirements()->setPassword();
            $fld = $frm->addPasswordField(Labels::getLabel('FRM_CONFIRM_PASSWORD', $this->siteLangId), 'confirm_password');
            $fld->requirements()->setRequired();
            $fld->requirements()->setCompareWith('password', 'eq', '');
        }

        if ($recordId != 1) {
            $fld = $frm->addCheckBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'admin_active', applicationConstants::ACTIVE, [], true, applicationConstants::INACTIVE);
            HtmlHelper::configureSwitchForCheckbox($fld);
            $fld->developerTags['noCaptionTag'] = true;
        }

        $fld = $frm->addCheckBox(Labels::getLabel('FRM_SEND_EMAIL_NOTIFICATION', $this->siteLangId), 'admin_email_notification', applicationConstants::YES, array(), false, applicationConstants::NO);
        HtmlHelper::configureSwitchForCheckbox($fld);
        $fld->developerTags['noCaptionTag'] = true;

        return $frm;
    }

    private function getChangePasswordForm($recordId)
    {
        $frm = new Form('frmAdminUserChangePassword');
        $frm->addHiddenField('', 'admin_id', $recordId);
        $fld = $frm->addPasswordField(Labels::getLabel('FRM_NEW_PASSWORD', $this->siteLangId), 'password');
        $fld->requirements()->setRequired(true);
        $fld->requirements()->setLength(4, 20);
        $fld = $frm->addPasswordField(Labels::getLabel('FRM_CONFIRM_PASSWORD', $this->siteLangId), 'confirm_password');
        $fld->requirements()->setRequired();
        $fld->requirements()->setCompareWith('password', 'eq', '');
        return $frm;
    }

    public function updateStatus()
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        $this->changeStatus($recordId, $status);
        $this->set('msg', Labels::getLabel('MSG_STATUS_UPDATED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function changeStatus(int $recordId, int $status)
    {
        $status = FatUtility::int($status);
        $recordId = FatUtility::int($recordId);
        if (1 >= $recordId || -1 == $status || !in_array($status, [applicationConstants::ACTIVE, applicationConstants::INACTIVE])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $this->setModel([$recordId]);
        if (!$this->modelObj->changeStatus($status)) {
            LibHelper::exitWithError($this->modelObj->getError(), true);
        }
    }

    public function toggleBulkStatuses()
    {
        $this->checkEditPrivilege();
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $recordsArr = FatUtility::int(FatApp::getPostedData('record_ids'));
        if (empty($recordsArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $this->setModel([0]);

        foreach ($recordsArr as $recordId) {
            if (2 > $recordId || $recordId == $this->admin_id) {
                continue;
            }
            $this->changeStatus($recordId, $status);
        }
        $this->set('msg', Labels::getLabel('MSG_STATUS_UPDATED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getFormColumns(): array
    {
        $adminUsersTblHeadingCols = CacheHelper::get('adminUsersTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($adminUsersTblHeadingCols) {
            return json_decode($adminUsersTblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            /*  'listSerial' => Labels::getLabel('LBL_#', $this->siteLangId), */
            'admin_name' => Labels::getLabel('LBL_FULL_NAME', $this->siteLangId),
            'admin_username' => Labels::getLabel('LBL_USERNAME', $this->siteLangId),
            'admin_email' => Labels::getLabel('LBL_EMAIL', $this->siteLangId),
            'admin_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];

        CacheHelper::create('adminUsersTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            /*   'listSerial', */
            'admin_name',
            'admin_username',
            'admin_email',
            'admin_active',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
