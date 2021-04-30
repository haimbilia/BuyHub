<?php

class BadgesController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();

        $this->objPrivilege->canViewBadges($this->admin_id);
    }

    public function index()
    {
        $frmSearch = $this->getSearchForm();
        $this->set("canEdit", $this->objPrivilege->canEditBadges($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);

        $this->_template->addJs('js/jscolor.js');
        $this->_template->render();
    }

    public function search()
    {
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            FatUtility::dieJsonError(current($searchForm->getValidationErrors()));
        }

        $srch = new BadgeSearch($this->adminLangId);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $keyword = $post['keyword'];
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('badge_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('badge_identifier', 'like', '%' . $keyword . '%');
        }

        $badgeType = $post['badge_type'];
        if (!empty($badgeType)) {
            $srch->addTypesCondition([$badgeType]);
        }

        $badgeShapeType = $post['badge_shape_type'];
        if (!empty($badgeShapeType)) {
            $srch->addShapeTypesCondition([$badgeShapeType]);
        }
        $srch->descOrder();
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set("canEdit", $this->objPrivilege->canEditBadges($this->admin_id, true));
        $this->set("arr_listing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    public function form(int $badgeId, int $type)
    {
        $this->objPrivilege->canEditBadges();
        $frm = $this->getForm($type);

        $dataToFill = [];
        if ($badgeId > 0) {
            $srch = new Badge($badgeId);
            $langData = $srch->getAllLangData($this->adminLangId);
            if (empty($langData)) {
                FatUtility::dieWithError($this->str_invalid_request);
            }
            foreach ($langData as $langId => $data) {
                foreach ($data as $key => $value) {
                    if (in_array($key, Badge::ATTR) && !array_key_exists($key, $dataToFill)) {
                        $dataToFill[$key] = $value;
                    } else if (in_array($key, Badge::LANG_ATTR)) {
                        if (Badge::DB_TBL_PREFIX . 'name' == $key) { continue; }

                        $dataToFill[Badge::DB_TBL_PREFIX . 'name'][$value] = $data[Badge::DB_TBL_PREFIX . 'name'];
                    }
                }
            }
        }
        $frm->fill($dataToFill);

        $this->set('frm', $frm);
        $this->set('badge_id', $badgeId);
        $this->set('type', $type);

        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $langData = Language::getAllNames();
        unset($langData[$siteDefaultLangId]);
        $this->set('otherLangData', $langData);
        $this->set('siteDefaultLangId', $siteDefaultLangId);

        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditBadges();

        $color = FatApp::getPostedData('badge_color', FatUtility::VAR_STRING, '');
        $badgeType = empty($color) ? Badge::TYPE_BADGE : Badge::TYPE_RIBBON;
        $frm = $this->getForm(FatApp::getPostedData('badge_type', FatUtility::VAR_INT, $badgeType));
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $badgeId = FatApp::getPostedData('badge_id', FatUtility::VAR_INT, 0);

        $record = new Badge($badgeId);
        if (!$record->add($post, applicationConstants::NO, applicationConstants::ACTIVE)) {
            FatUtility::dieJsonError($record->getError());
        }
        $badgeId = $record->getMainTableRecordId();

        $this->set('badge_id', $badgeId);
        $this->set('badge_type', $badgeType);
        $this->set('msg', Labels::getLabel('MGS_ADDED_SUCCESSFULLY', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getSearchForm()
    {
        $frm = new Form('frmSearch');
        $frm->addTextBox(Labels::getLabel('LBL_KEYWORD', $this->adminLangId), 'keyword', '');

        $badgeTypes = Badge::getTypeArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_TYPE', $this->adminLangId), 'badge_type', $badgeTypes);

        $badgeShapeTypes = Badge::getShapeTypesArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_SHAPE_TYPE', $this->adminLangId), 'badge_shape_type', $badgeShapeTypes);

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function getForm(int $type)
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', 'badge_id');
        $frm->addHiddenField('', 'badge_type', $type);

        $badgeShapeTypes = Badge::getShapeTypesArr($this->adminLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_SHAPE', $this->adminLangId), 'badge_shape_type', $badgeShapeTypes);
        $fld->requirement->setRequired(true);

        if (Badge::TYPE_RIBBON == $type) {
            $frm->addRequiredField(Labels::getLabel('LBL_COLOR', $this->adminLangId), 'badge_color', '', ['class' => 'jscolor']);
        }

        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $langData = Language::getAllNames();
        foreach ($langData as $langId => $data) {
            $fld = $frm->addTextBox(Labels::getLabel('LBL_NAME', $this->adminLangId), 'badge_name[' . $langId . ']');
            if ($siteDefaultLangId == $langId) {
                $fld->requirement->setRequired(true);
            }
        }

        unset($langData[$siteDefaultLangId]);
        if (!empty($translatorSubscriptionKey) && count($langData) > 0) {
            $frm->addCheckBox(Labels::getLabel('LBL_TRANSLATE_TO_OTHER_LANGUAGES', $this->adminLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        $requireApprovalArr = [Labels::getLabel('LBL_APPROVED', $this->adminLangId), Labels::getLabel('LBL_PENDING', $this->adminLangId)];
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_APPROVAL_STATUS', $this->adminLangId), 'badge_required_approval', $requireApprovalArr);
        $fld->requirement->setRequired(true);

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->adminLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_STATUS', $this->adminLangId), 'badge_active', $activeInactiveArr, '', array(), '');
        $fld->requirement->setRequired(true);

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SAVE', $this->adminLangId));
        return $frm;
    }

    public function changeStatus()
    {
        $this->objPrivilege->canEditBadges();
        $badge_id = FatApp::getPostedData('badge_id', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('badge_active', FatUtility::VAR_INT, -1);
        if (1 > $badge_id || 0 > $status) {
            FatUtility::dieJsonError($this->str_invalid_request);
        }

        if (!Badge::getAttributesById($badge_id, ['badge_active'])) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        $this->updateStatus($badge_id, $status);
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditBadges();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $badgeIdsArr = FatUtility::int(FatApp::getPostedData('badgeIds'));
        if (empty($badgeIdsArr) || -1 == $status) {
            FatUtility::dieJsonError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId)
            );
        }

        foreach ($badgeIdsArr as $badge_id) {
            if (1 > $badge_id) {
                continue;
            }

            $this->updateStatus($badge_id, $status);
        }
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updateStatus(int $badge_id, int $status)
    {
        if (1 > $badge_id || -1 == $status) {
            FatUtility::dieJsonError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId)
            );
        }

        $brandObj = new Badge($badge_id);
        if (!$brandObj->changeStatus($status)) {
            FatUtility::dieJsonError($brandObj->getError());
        }
    }

    public function translatedCategoryData()
    {
        $badge_name = FatApp::getPostedData('badge_name', FatUtility::VAR_STRING, '');
        $toLangId = FatApp::getPostedData('toLangId', FatUtility::VAR_INT, 0);
        $data['badge_name'] = $badge_name;
        $productCategory = new ProductCategory();
        $translatedData = $productCategory->getTranslatedCategoryData($data, $toLangId);
        if (!$translatedData) {
            FatUtility::dieJsonError($productCategory->getError());
        }
        $this->set('badge_name', $translatedData[$toLangId]['badge_name']);
        $this->_template->render(false, false, 'json-success.php');
    }
}
