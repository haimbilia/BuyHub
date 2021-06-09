<?php

class BadgesController extends SellerPluginBaseController
{
    private $sellerId = 0;
    public function __construct($action)
    {
        parent::__construct($action);
        $this->sellerId = UserAuthentication::getLoggedUserId();
        $this->userPrivilege->canViewBadges($this->sellerId);
    }

    public function index()
    {
        $frmSearch = $this->getSearchForm();
        $this->set("canEdit", $this->userPrivilege->canEditBadges($this->sellerId, true));
        $this->set("frmSearch", $frmSearch);

        $this->_template->addJs(array('js/select2.js'));
        $this->_template->addCss(array('custom/page-css/select2.min.css'));
        $this->_template->render();
    }

    public function search()
    {
        $pagesize = FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            FatUtility::dieJsonError(current($searchForm->getValidationErrors()));
        }

        $srch = new BadgeSearch($this->siteLangId);
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

        $approval = $post['badge_required_approval'];
        if ('' != $approval) {
            $srch->addCondition('badge_type', '=', Badge::TYPE_BADGE);
            $srch->addCondition('badge_required_approval', '=', $approval);
        }

        $srch->descOrder();
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set("canEdit", $this->userPrivilege->canEditBadges($this->sellerId, true));
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    public function form(int $badgeId, int $type)
    {
        $this->userPrivilege->canEditBadges();
        $frm = $this->getForm($type);

        $dataToFill = [];
        $frm->fill($dataToFill);

        $this->set('frm', $frm);
        $this->set('badge_id', $badgeId);
        $this->set('type', $type);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->userPrivilege->canEditBadges();

        $color = FatApp::getPostedData('badge_color', FatUtility::VAR_STRING, '');
        $badgeType = empty($color) ? Badge::TYPE_BADGE : Badge::TYPE_RIBBON;
        $frm = $this->getForm(FatApp::getPostedData('badge_type', FatUtility::VAR_INT, $badgeType));
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
        $badgeId = FatApp::getPostedData('badge_id', FatUtility::VAR_INT, 0);
        $attachments = FatApp::getPostedData('attachment_ids', FatUtility::VAR_STRING, '');

        $record = new Badge($badgeId);
        if (!$record->add($post)) {
            FatUtility::dieJsonError($record->getError());
        }
        $badgeId = $record->getMainTableRecordId();

        if (!empty($attachments)) {
            $attachmentIdsArr = json_decode($attachments, true);
            if (!empty($attachmentIdsArr)) {
                foreach ($attachmentIdsArr as $langId => $aFileId) {
                    $badgeRecord = ['afile_record_id' => $badgeId];
                    $where = array('smt' => 'afile_id = ? AND afile_lang_id = ?', 'vals' => [$aFileId, $langId]);
                    FatApp::getDb()->updateFromArray(AttachedFile::DB_TBL, $badgeRecord, $where);
                }
            }
        }

        $this->set('badge_id', $badgeId);
        $this->set('badge_type', $badgeType);
        $this->set('msg', Labels::getLabel('MGS_ADDED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getSearchForm()
    {
        $frm = new Form('frmSearch');
        $frm->addTextBox(Labels::getLabel('LBL_KEYWORD', $this->siteLangId), 'keyword', '');

        $badgeTypes = Badge::getTypeArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_TYPE', $this->siteLangId), 'badge_type', $badgeTypes);

        $approvalArr = Badge::getApprovalStatusArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_APPROVAL', $this->siteLangId), 'badge_required_approval', $approvalArr);

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->siteLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->siteLangId));
        return $frm;
    }

    private function getForm(int $type)
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', 'badge_id');
        $frm->addHiddenField('', 'badge_type', $type);

        if (Badge::TYPE_RIBBON == $type) {
            $badgeShapeTypes = Badge::getShapeTypesArr($this->siteLangId);
            $fld = $frm->addSelectBox(Labels::getLabel('LBL_SHAPE', $this->siteLangId), 'badge_shape_type', $badgeShapeTypes);
            $fld->requirement->setRequired(true);
            $frm->addCheckBox(Labels::getLabel('LBL_DISPLAY_INSIDE', $this->siteLangId), 'badge_display_inside', 1, [], false, 0 );
            $frm->addRequiredField(Labels::getLabel('LBL_COLOR', $this->siteLangId), 'badge_color', '', ['class' => 'jscolor']);
        }

        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $langData = Language::getAllNames();
        foreach ($langData as $langId => $data) {
            $fld = $frm->addTextBox(Labels::getLabel('LBL_NAME', $this->siteLangId), 'badge_name[' . $langId . ']');
            if ($siteDefaultLangId == $langId) {
                $fld->requirement->setRequired(true);
            }
            if (Badge::TYPE_RIBBON == $type) {
                $fld->htmlAfterField = '<small>' . CommonHelper::replaceStringData(Labels::getLabel('LBL_MIN_LENGTH_{MINLEN}_CHARACTERS_AND_MAX_LENGTH_{MAXLEN}_CHARACTERS.', $this->siteLangId), ['{MINLEN}' => Badge::RIBB_TEXT_MIN_LEN, '{MAXLEN}' => Badge::RIBB_TEXT_MAX_LEN]) . '</small>';
            }
        }
        
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        unset($langData[$siteDefaultLangId]);
        if (!empty($translatorSubscriptionKey) && count($langData) > 0) {
            $frm->addCheckBox(Labels::getLabel('LBL_TRANSLATE_TO_OTHER_LANGUAGES', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        if (Badge::TYPE_BADGE == $type) {
            $requireApprovalArr = [Labels::getLabel('LBL_OPEN', $this->siteLangId), Labels::getLabel('LBL_REQUESTED', $this->siteLangId)];
            $fld = $frm->addSelectBox(Labels::getLabel('LBL_APPROVAL_STATUS', $this->siteLangId), 'badge_required_approval', $requireApprovalArr);
            $fld->requirement->setRequired(true);
        }

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_STATUS', $this->siteLangId), 'badge_active', $activeInactiveArr, '', array(), '');
        $fld->requirement->setRequired(true);

        if (Badge::TYPE_BADGE == $type) {
            $mediaLanguages = applicationConstants::bannerTypeArr();
            $frm->addSelectBox(Labels::getLabel('LBL_Language', $this->siteLangId), 'icon_lang_id', $mediaLanguages, '', array(), '');
            $frm->addHiddenField('', 'icon_file_type', AttachedFile::FILETYPE_BADGE);
            $frm->addHiddenField('', 'logo_min_width');
            $frm->addHiddenField('', 'logo_min_height');
            $frm->addFileUpload(Labels::getLabel('LBL_UPLOAD', $this->siteLangId), 'badge_icon', array('accept' => 'image/*', 'data-frm' => 'frmCategoryIcon'));
            $frm->addHiddenField('', 'attachment_ids');
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SAVE', $this->siteLangId));
        return $frm;
    }

    public function changeStatus()
    {
        $this->userPrivilege->canEditBadges();
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
        $this->userPrivilege->canEditBadges();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $badgeIdsArr = FatUtility::int(FatApp::getPostedData('badgeIds'));
        if (empty($badgeIdsArr) || -1 == $status) {
            FatUtility::dieJsonError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
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
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
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

    public function autoComplete(int $badgeType = 0)
    {
        $pagesize = 20;
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');

        $srch = new BadgeSearch($this->siteLangId, -1, applicationConstants::ACTIVE);
        $srch->setPageSize($pagesize);
        if (!empty($keyword)) {
            $srch->addCondition(Badge::DB_TBL_PREFIX . 'name', 'LIKE', '%' . $keyword . '%');
        }

        if (0 < $badgeType) {
            $srch->addTypesCondition([$badgeType]);
        }

        $srch->addMultipleFields([Badge::DB_TBL_PREFIX . 'id as id', Badge::DB_TBL_PREFIX . 'name as name']);
        $badges = FatApp::getDb()->fetchAll($srch->getResultSet());
        die(json_encode(['badges' => $badges]));
    }

    public function deleteSelected()
    {
        $this->userPrivilege->canEditBadges();
        $badgeIdsArr = FatUtility::int(FatApp::getPostedData('badgeIds'));
        if (empty($badgeIdsArr)) {
            FatUtility::dieJsonError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }

        foreach ($badgeIdsArr as $badge_id) {
            if (1 > $badge_id) {
                continue;
            }

            $obj = new Badge($badge_id);
            if (!$obj->deleteRecord(true)) {
                continue;
            }

            if (!FatApp::getDb()->deleteRecords(BadgeLinkCondition::DB_TBL_PREFIX, array('smt' => 'blinkcond_badge_id = ?', 'vals' => array($badge_id)))) {
                continue;
            }
        }
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function setUpImages()
    {
        $this->userPrivilege->canEditBadges();
        $file_type = FatApp::getPostedData('file_type', FatUtility::VAR_INT, 0);
        $badge_id = FatApp::getPostedData('badge_id', FatUtility::VAR_INT, 0);
        $badge_type = FatApp::getPostedData('badge_type', FatUtility::VAR_INT, 0);

        if (Badge::TYPE_RIBBON == $badge_type) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_BADGE_TYPE', $this->siteLangId));
        }

        $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        $slide_screen = FatApp::getPostedData('slide_screen', FatUtility::VAR_INT, 0);
        $afileId = FatApp::getPostedData('afile_id', FatUtility::VAR_INT, 0);
        if (!$file_type) {
            FatUtility::dieJsonError($this->str_invalid_request);
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_Please_Select_A_File', $this->siteLangId));
        }

        Badge::deleteImagesWithOutBadgeId($file_type);

        $fileHandlerObj = new AttachedFile($afileId);
        if (!$res = $fileHandlerObj->saveImage(
            $_FILES['cropped_image']['tmp_name'],
            $file_type,
            $badge_id,
            0,
            $_FILES['cropped_image']['name'],
            -1,
            $unique_record = false,
            $lang_id,
            $_FILES['cropped_image']['type'],
            $slide_screen
        )) {
            FatUtility::dieJsonError($fileHandlerObj->getError());
        }

        $this->set('attachFileId', $fileHandlerObj->getMainTableRecordId());
        $this->set('file', $_FILES['cropped_image']['name']);
        $this->set('badge_id', $badge_id);
        $this->set('msg', $_FILES['cropped_image']['name'] . ' ' . Labels::getLabel('LBL_UPLOADED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeImage($afileId, $badgeId, $imageType = '', $langId = 0, $slide_screen = 0)
    {
        $this->userPrivilege->canEditBadges();
        $afileId = FatUtility::int($afileId);
        $badgeId = FatUtility::int($badgeId);
        $langId = FatUtility::int($langId);
        if (!$afileId) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
        }
        $fileType = AttachedFile::FILETYPE_BADGE;
        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile($fileType, $badgeId, $afileId, 0, $langId, $slide_screen)) {
            FatUtility::dieJsonError($fileHandlerObj->getError());
        }

        $this->set('imageType', $imageType);
        $this->set('msg', Labels::getLabel('MSG_IMAGE_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function images($badge_id, $imageType = '', $lang_id = 0, $slide_screen = 0)
    {
        $canEdit = $this->userPrivilege->canEditBadges(0, true);
        $badge_id = FatUtility::int($badge_id);
        $lang_id = FatUtility::int($lang_id);
        $icon = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $badge_id, 0, $lang_id, false);
        $this->set('icon', $icon);
        $this->set('imageType', $imageType);
        $this->set('languages', Language::getAllNames());
        $this->set('canEdit', $canEdit);
        $this->_template->render(false, false);
    }
}
