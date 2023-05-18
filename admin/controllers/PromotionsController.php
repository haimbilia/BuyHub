<?php

class PromotionsController extends ListingBaseController
{
    protected $pageKey = 'PROMOTIONS';

    private int $minWidth = 1200;
    private int $minHeight = 360;
    protected string $modelClass = 'Promotion';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewPromotions();
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
            $this->set("canEdit", $this->objPrivilege->canEditPromotions($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditPromotions();
        }
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->checkEditPrivilege();
        $this->setModel($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('name')];
        $this->set('formTitle', Labels::getLabel('LBL_PPC_PROMOTION_SETUP', $this->siteLangId));

        $promotionType = Promotion::getAttributesById($this->mainTableRecordId, 'promotion_type');
        if ($promotionType == Promotion::TYPE_BANNER || $promotionType == Promotion::TYPE_SLIDES) {
            $otherButtons = [
                [
                    'attr' => [
                        'href' => 'javascript:void(0)',
                        'onclick' => 'promotionMediaForm(' . $this->mainTableRecordId . ', 0, ' . applicationConstants::SCREEN_DESKTOP . ')',
                        'title' => Labels::getLabel('LBL_Media', $this->siteLangId)
                    ],
                    'label' => Labels::getLabel('LBL_Media', $this->siteLangId),
                    'isActive' => false
                ]
            ];
            $this->set('otherButtons', $otherButtons);
        }
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? Labels::getLabel('LBL_PPC_PROMOTION_MANAGEMENT', $this->siteLangId);

        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['newRecordBtn'] = false;
        $actionItemsData['deleteButton'] = true;
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['formAction'] = 'deleteSelected';

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_PROMOTION_NAME', $this->siteLangId));
        $this->getListingData();

        $this->_template->addCss(['css/select2.min.css', 'css/cropper.css']);
        $this->_template->addJs(['js/select2.js', 'js/cropper.js', 'js/cropper-main.js']);
        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'promotions/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $db = FatApp::getDb();
        $post = FatApp::getPostedData();

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);

        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'promotion_id');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = 'promotion_id';
        }

        if ('user_name' == $sortBy) {
            $sortBy = 'shop_name';
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING), applicationConstants::SORT_DESC);

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = new PromotionSearch($this->siteLangId);
        $srch->joinBannersAndLocation($this->siteLangId, Promotion::TYPE_BANNER, 'b');
        $srch->joinPromotionsLogForCount();
        $srch->joinActiveUser(false);
        $srch->joinShops($this->siteLangId);
        $srch->addCondition('pr.promotion_deleted', '=', applicationConstants::NO);

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $condition = $srch->addCondition('pr.promotion_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('pr_l.promotion_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $date_from = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
        if (!empty($date_from)) {
            $srch->addCondition('pr.promotion_start_date', '>=', $date_from . ' 00:00:00');
        }

        $date_to = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');
        if (!empty($date_to)) {
            $srch->addCondition('pr.promotion_end_date', '<=', $date_to . ' 23:59:59');
        }

        $active = FatApp::getPostedData('active');
        if ('' != $active && '-1' != $active) {
            $srch->addCondition('pr.promotion_active', '=', $active);
        }

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, -1);
        $promotionId = FatApp::getPostedData('promotion_id', FatUtility::VAR_INT, $recordId);
        if (0 < $promotionId) {
            $srch->addCondition('pr.promotion_id', '=', $promotionId);
        }

        $approved = FatApp::getPostedData('approve');
        if ('' != $approved && '-1' != $approved) {
            $srch->addCondition('pr.promotion_approved', '=', $approved);
        }

        $impressionFrom = FatApp::getPostedData('impression_from', FatUtility::VAR_INT, 0);
        $impressionTo = FatApp::getPostedData('impression_to', FatUtility::VAR_INT, 0);
        if ($impressionFrom > 0) {
            $srch->addCondition('pri.impressions', '>=', $impressionFrom);
        }
        if ($impressionTo > 0) {
            $srch->addCondition('pri.impressions', '<=', $impressionTo);
        }

        $clickFrom = FatApp::getPostedData('click_from', FatUtility::VAR_INT, 0);
        $clickTo = FatApp::getPostedData('click_to', FatUtility::VAR_INT, 0);
        if ($clickFrom > 0) {
            $srch->addCondition('pri.clicks', '>=', $clickFrom);
        }
        if ($clickTo > 0) {
            $srch->addCondition('pri.clicks', '<=', $clickTo);
        }

        $type = FatApp::getPostedData('type', FatUtility::VAR_INT, '-1');
        if ($type != '-1') {
            $srch->addCondition('promotion_type', '=', $type);
        }
        $srch->addGroupBy('pr.promotion_id');
        $this->setRecordCount(clone $srch, $pageSize, $page, $post, true);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(['pr.promotion_id', 'IFNULL(pr_l.promotion_name,pr.promotion_identifier)as promotion_name', 'user_name', 'credential_username', 'credential_email', 'credential_email', 'pr.promotion_type', 'pr.promotion_budget', 'pr.promotion_duration', 'promotion_approved', 'bbl.blocation_promotion_cost', 'pri.impressions', 'pri.clicks', 'pri.orders', 'bbl.blocation_id', 'shop_id', 'shop_user_id', 'IFNULL(shop_name, shop_identifier) as shop_name', 'user_id', 'user_updated_on', 'shop_updated_on']);
        $srch->addOrder($sortBy, $sortOrder);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set("arrListing", $records);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditPromotions($this->admin_id, true));
        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->siteLangId));
        $this->set('yesNoArr', applicationConstants::getYesNoArr($this->siteLangId));
        $this->set('typeArr', Promotion::getTypeArr($this->siteLangId));
        $this->set('canViewShops', $this->objPrivilege->canViewShops($this->admin_id, true));
    }

    public function setup()
    {
        $this->objPrivilege->canEditPromotions();
        $recordId = FatApp::getPostedData('promotion_id');
        $frm = $this->getForm($recordId);
        $userId = FatApp::getPostedData('promotion_user_id');
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $minimumWithdrawLimit = FatApp::getConfig("CONF_PPC_MIN_WALLET_BALANCE", FatUtility::VAR_INT, 0);
        if (User::getUserBalance($userId) < $minimumWithdrawLimit) {
            FatUtility::dieJsonError(str_replace("{amount}", CommonHelper::displayMoneyFormat($minimumWithdrawLimit), Labels::getLabel('MSG_YOUR_ACCOUNT_BALANCE_HAS_TO_BE_GREATER_THAN_{amount}_TO_CREATE_PROMOTIONS.', $this->siteLangId)));
        }

        if (strtotime($post['promotion_start_date']) > strtotime($post['promotion_end_date'])) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_END_DATE_SHOULD_BE_GREATOR_THAN_START_DATE', $this->siteLangId));
        }

        $promotionDetails = Promotion::getAttributesById($recordId);
        $oldApprovalStatus = applicationConstants::INACTIVE;
        if ($promotionDetails) {
            $oldApprovalStatus = $promotionDetails['promotion_approved'];
        }
        $promotion_record_id = 0;
        $bannerData = array();
        $slidesData = array();

        $minBudget = 0;

        switch ($post['promotion_type']) {
            case Promotion::TYPE_SHOP:
                $srch = Shop::getSearchObject(true, $this->siteLangId);
                $srch->addCondition('shop_user_id', '=', $userId);
                $srch->setPageSize(1);
                $srch->doNotCalculateRecords();
                $srch->addMultipleFields(array('ifnull(shop_name,shop_identifier) as shop_name', 'shop_id'));
                $rs = $srch->getResultSet();
                $row = FatApp::getDb()->fetch($rs);
                if (empty($row)) {
                    LibHelper::exitWithError($this->str_invalid_request, true);
                }
                $promotion_record_id = $row['shop_id'];
                $minBudget = FatApp::getConfig('CONF_CPC_SHOP', FatUtility::VAR_FLOAT, 0);
                break;

            case Promotion::TYPE_PRODUCT:
                $selProdId = $post['promotion_record_id'];

                $srch = new ProductSearch($this->siteLangId);
                $srch->joinSellerProducts();
                $srch->setPageSize(1);
                $srch->doNotCalculateRecords();
                $srch->addCondition('selprod_id', '=', $selProdId);
                $srch->addCondition('selprod_user_id', '=', $userId);
                $srch->addMultipleFields(array('selprod_id'));

                $rs = $srch->getResultSet();
                $row = FatApp::getDb()->fetch($rs);

                if (empty($row)) {
                    LibHelper::exitWithError($this->str_invalid_request, true);
                }
                $promotion_record_id = $row['selprod_id'];
                $minBudget = FatApp::getConfig('CONF_CPC_PRODUCT', FatUtility::VAR_FLOAT, 0);
                break;

            case Promotion::TYPE_BANNER:
                $promotion_record_id = 0;
                $bannerData = array(
                    'banner_blocation_id' => $post['banner_blocation_id'],
                    'banner_url' => $post['banner_url'],
                    'banner_target' => applicationConstants::LINK_TARGET_BLANK_WINDOW,
                    'banner_type' => Banner::TYPE_PPC,
                    'banner_active' => applicationConstants::ACTIVE,
                );

                $bannerLocationId = Fatutility::int($post['banner_blocation_id']);
                $srch = BannerLocation::getSearchObject($this->siteLangId);
                $srch->addMultipleFields(array('blocation_promotion_cost'));
                $srch->addCondition('blocation_id', '=', $bannerLocationId);
                $srch->doNotCalculateRecords();
                $srch->setPageSize(1);
                $rs = $srch->getResultSet();
                $row = FatApp::getDb()->fetch($rs, 'blocation_id');
                if (!empty($row)) {
                    $minBudget = $row['blocation_promotion_cost'];
                }
                break;

            case Promotion::TYPE_SLIDES:
                $promotion_record_id = 0;
                $slidesData = array(
                    'slide_url' => $post['slide_url'],
                    'slide_target' => applicationConstants::LINK_TARGET_BLANK_WINDOW,
                    'slide_type' => Slides::TYPE_PPC,
                    'slide_active' => applicationConstants::ACTIVE,
                );
                $minBudget = FatApp::getConfig('CONF_CPC_SLIDES', FatUtility::VAR_FLOAT, 0);
                break;

            default:
                LibHelper::exitWithError($this->str_invalid_request, true);
                break;
        }

        $promotionBudget = Fatutility::float($post['promotion_budget']);
        if ($minBudget > $promotionBudget) {
            LibHelper::exitWithError(Labels::getLabel("ERR_Budget_should_be_greater_than_CPC", $this->siteLangId), true);
        }

        $recordId = $post['promotion_id'];

        unset(
            $post['promotion_record_id'],
            $post['banner_id'],
            $post['promotion_id'],
            $post['banner_blocation_id'],
            $post['banner_url']
        );

        $record = new Promotion($recordId);
        $data = array(
            'promotion_user_id' => $userId,
            'promotion_added_on' => date('Y-m-d H:i:s'),
            'promotion_active' => applicationConstants::ACTIVE,
            'promotion_record_id' => $promotion_record_id,
        );

        $post['promotion_identifier'] = $post['promotion_name'];

        $data = array_merge($data, $post);
        $record->assignValues($data);

        if (!$record->save()) {
            $msg = $record->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_NAME', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }
        $this->setLangData($record, [$record::tblFld('name') => $post[$record::tblFld('name')]]);

        $newTabLangId = 0;
        if ($recordId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = Promotion::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $recordId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        switch ($post['promotion_type']) {
            case Promotion::TYPE_BANNER:
                $bannerId = 0;
                $srch = Banner::getSearchObject();
                $srch->addCondition('banner_type', '=', Banner::TYPE_PPC);
                $srch->addCondition('banner_record_id', '=', $recordId);
                $srch->addMultipleFields(array('banner_id'));
                $srch->doNotCalculateRecords();
                $srch->setPageSize(1);
                $rs = $srch->getResultSet();
                $row = FatApp::getDb()->fetch($rs);

                if ($row) {
                    $bannerId = $row['banner_id'];
                }

                $bannerRecord = new Banner($bannerId);
                $bannerData['banner_record_id'] = $recordId;
                $bannerRecord->assignValues($bannerData);

                if (!$bannerRecord->save()) {
                    LibHelper::exitWithError($bannerRecord->getError(), true);
                }
                break;

            case Promotion::TYPE_SLIDES:
                $slideId = 0;
                $srch = Slides::getSearchObject();
                $srch->addCondition('slide_type', '=', Slides::TYPE_PPC);
                $srch->addCondition('slide_record_id', '=', $recordId);
                $srch->addMultipleFields(array('slide_id'));
                $srch->doNotCalculateRecords();
                $srch->setPageSize(1);
                $rs = $srch->getResultSet();
                $row = FatApp::getDb()->fetch($rs);
                if ($row) {
                    $slideId = $row['slide_id'];
                }

                $slideRecord = new Slides($slideId);
                $slidesData['slide_record_id'] = $recordId;
                $slideRecord->assignValues($slidesData);

                if (!$slideRecord->save()) {
                    LibHelper::exitWithError($slideRecord->getError(), true);
                }
                break;
        }

        $promotionDetails = Promotion::getAttributesById($recordId);
        $currentApprovalStatus = $promotionDetails['promotion_approved'];
        if ($oldApprovalStatus == applicationConstants::INACTIVE && $currentApprovalStatus == applicationConstants::ACTIVE) {
            EmailHandler::sendPromotionStatusChangeNotification($this->siteLangId, $userId, $promotionDetails);
        }

        $this->set('promotionId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeMedia()
    {
        $this->objPrivilege->canEditPromotions();
        $recordId = FatApp::getPostedData('promotionId', FatUtility::VAR_INT, 0);
        $bannerId = FatApp::getPostedData('bannerId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        $screen = FatApp::getPostedData('screen', FatUtility::VAR_INT, 0);

        $data = Promotion::getAttributesById($recordId, array('promotion_id', 'promotion_type', 'promotion_user_id'));
        if (!$data) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST_ID', $this->siteLangId), true);
        }

        $fileHandlerObj = new AttachedFile();
        $attachedFileType = 0;
        switch ($data['promotion_type']) {
            case Promotion::TYPE_BANNER:
                $attachedFileType = AttachedFile::FILETYPE_BANNER;
                break;

            case Promotion::TYPE_SLIDES:
                $attachedFileType = AttachedFile::FILETYPE_HOME_PAGE_BANNER;
                break;
        }

        if (1 > $attachedFileType) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile($attachedFileType, $bannerId, 0, 0, $langId, $screen)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Deleted_successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function uploadMedia()
    {
        $this->objPrivilege->canEditPromotions();
        $post = FatApp::getPostedData();
        $recordId = FatUtility::int($post['record_id']);

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $langId = FatUtility::int($post['lang_id']);
        } else {
            $langId  = array_key_first($languages);
        }

        $promotionType = FatUtility::int($post['promotion_type']);
        $bannerScreen = FatUtility::int($post['banner_screen']);

        $promotionDetails = Promotion::getAttributesById($recordId);
        $userId = $promotionDetails['promotion_user_id'];

        $allowedTypeArr = array(Promotion::TYPE_BANNER, Promotion::TYPE_SLIDES);

        if (1 > $recordId || !in_array($promotionType, $allowedTypeArr)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Invalid_access', $this->siteLangId), true);
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Please_Select_A_File', $this->siteLangId), true);
        }

        $promotionRecordId = 0;
        $attachedFileType = 0;

        $srch = new PromotionSearch($this->siteLangId);
        $srch->addCondition('promotion_id', '=', $recordId);
        $srch->addCondition('promotion_user_id', '=', $userId);

        switch ($promotionType) {
            case Promotion::TYPE_BANNER:
                $srch->joinBannersAndLocation($this->siteLangId, Promotion::TYPE_BANNER, 'b');
                $srch->doNotCalculateRecords();
                $srch->setPageSize(1);
                $rs = $srch->getResultSet();
                $promotionDetails = FatApp::getDb()->fetch($rs);
                $promotionRecordId = $promotionDetails['banner_id'];
                $attachedFileType = AttachedFile::FILETYPE_BANNER;
                break;
            case Promotion::TYPE_SLIDES:
                $srch->joinSlides();
                $srch->doNotCalculateRecords();
                $srch->setPageSize(1);
                $rs = $srch->getResultSet();
                $promotionDetails = FatApp::getDb()->fetch($rs);
                $promotionRecordId = $promotionDetails['slide_id'];
                $attachedFileType = AttachedFile::FILETYPE_HOME_PAGE_BANNER;
                break;
        }

        if (1 > $promotionRecordId || 1 > $attachedFileType) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Invalid_access', $this->siteLangId), true);
        }

        $fileHandlerObj = new AttachedFile();

        if (!$res = $fileHandlerObj->saveAttachment(
            $_FILES['cropped_image']['tmp_name'],
            $attachedFileType,
            $promotionRecordId,
            0,
            $_FILES['cropped_image']['name'],
            -1,
            true,
            $langId,
            $bannerScreen
        )) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('promotionId', $recordId);
        $this->set('file', $_FILES['cropped_image']['name']);
        $this->set('msg', $_FILES['cropped_image']['name'] . Labels::getLabel('MSG_File_uploaded_successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function form()
    {
        $this->objPrivilege->canEditPromotions();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);
        $promotionType = 0;
        if (0 < $recordId) {
            $srch = new PromotionSearch($this->siteLangId);
            $srch->joinBannersAndLocation($this->siteLangId, Promotion::TYPE_BANNER, 'b');
            $srch->joinSlides();
            $srch->joinShops(0, false, false);
            $srch->addCondition('promotion_id', '=', $recordId);

            $srch->addMultipleFields(array('promotion_id', 'promotion_identifier', 'IFNULL(promotion_name,promotion_identifier) as promotion_name', 'promotion_user_id', 'promotion_type', 'promotion_budget', 'promotion_duration', 'promotion_start_date', 'promotion_end_date', 'promotion_start_time', 'promotion_end_time', 'promotion_active', 'promotion_approved', 'ifnull(shop_identifier,shop_name) as promotion_shop', 'banner_url', 'banner_target', 'banner_blocation_id', 'slide_url', 'slide_target', 'promotion_record_id'));
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $rs = $srch->getResultSet();
            $promotionDetails = FatApp::getDb()->fetch($rs);

            if ($promotionDetails === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $promotionType = $promotionDetails['promotion_type'];
            $frm = $this->getForm($recordId);

            $frm->fill($promotionDetails);
        }
        $languages = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        $enableTabs = (in_array($promotionType, [Promotion::TYPE_BANNER, Promotion::TYPE_SLIDES]) || 0 < count($languages));
        $this->set('promotionType', $promotionType);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);

        $this->set('includeTabs', $enableTabs);
        $this->set('activeTab', 'GENERAL');
        $this->set('formTitle', Labels::getLabel('LBL_PPC_PROMOTION_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function media($recordId = 0)
    {
        $this->objPrivilege->canEditPromotions();

        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $srch = new PromotionSearch($this->siteLangId);
        $srch->joinBannersAndLocation($this->siteLangId, Promotion::TYPE_BANNER, 'b');
        $srch->joinTable(
            Collections::DB_TBL,
            'LEFT OUTER JOIN',
            'c.collection_id = blocation_collection_id',
            'c'
        );
        $srch->joinSlides();
        $srch->addCondition('promotion_id', '=', $recordId);
        $srch->addMultipleFields(array('promotion_id', 'promotion_type', 'banner_id', 'blocation_banner_width', 'blocation_banner_height', 'slide_id', 'collection_layout_type'));
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $promotionDetails = FatApp::getDb()->fetch($rs);
        if (empty($promotionDetails)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $promotionType = $promotionDetails['promotion_type'];

        switch ($promotionType) {
            case Promotion::TYPE_BANNER:
                $imgDetail = Banner::getAttributesById($promotionDetails['banner_id']);
                if (!false == $imgDetail && ($imgDetail['banner_active'] != applicationConstants::ACTIVE)) {
                    LibHelper::exitWithError(Labels::getLabel('ERR_Invalid_request_Or_Inactive_Record', $this->siteLangId), true);
                }
                break;
            case Promotion::TYPE_SLIDES:
                $imgDetail = Slides::getAttributesById($promotionDetails['slide_id']);
                if (!false == $imgDetail && ($imgDetail['slide_active'] != applicationConstants::ACTIVE)) {
                    LibHelper::exitWithError(Labels::getLabel('ERR_Invalid_request_Or_Inactive_Record', $this->siteLangId), true);
                }
                break;
        }

        $mediaFrm = $this->getMediaForm($recordId, $promotionType, $promotionDetails['collection_layout_type']);
        $bannerWidth = '';
        $bannerHeight = '';
        $fileType = AttachedFile::FILETYPE_HOME_PAGE_BANNER;
        if ($promotionType == Promotion::TYPE_BANNER) {
            $fileType = AttachedFile::FILETYPE_BANNER;
            $bannerWidth = FatUtility::convertToType($promotionDetails['blocation_banner_width'], FatUtility::VAR_FLOAT);
            $bannerHeight = FatUtility::convertToType($promotionDetails['blocation_banner_height'], FatUtility::VAR_FLOAT);
        }
        $mediaFrm->fill(['file_type' => $fileType]);

        $silesScreenDimensions = ImageDimension::getScreenSizes(ImageDimension::TYPE_SLIDE);

        $this->set('bannerWidth', $bannerWidth);
        $this->set('bannerHeight', $bannerHeight);
        $this->set('silesScreenDimensions', $silesScreenDimensions);
        $this->set('promotionType', $promotionType);
        $this->set('recordId', $recordId);

        $this->set('mediaFrm', $mediaFrm);
        $this->set('screen', applicationConstants::SCREEN_DESKTOP);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function images($recordId = 0, $lang_id = 0, $screen = 0)
    {
        $this->objPrivilege->canEditPromotions();
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $languages = Language::getAllNames();
        if (count($languages) <= 1) {
            $lang_id =  array_key_first($languages);
        }

        $srch = new PromotionSearch($this->siteLangId);
        $srch->joinBannersAndLocation($this->siteLangId, Promotion::TYPE_BANNER, 'b');
        $srch->joinSlides();
        $srch->addCondition('promotion_id', '=', $recordId);
        $srch->addMultipleFields(array('promotion_id', 'promotion_type', 'banner_id', 'blocation_banner_width', 'blocation_banner_height', 'slide_id'));
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $promotionDetails = FatApp::getDb()->fetch($rs);
        if (empty($promotionDetails)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $promotionType = $promotionDetails['promotion_type'];

        $promotionRecordId = 0;
        $attachedFileType = 0;
        $imgDetail = false;
        switch ($promotionType) {
            case Promotion::TYPE_BANNER:
                $imgDetail = Banner::getAttributesById($promotionDetails['banner_id']);
                if (!false == $imgDetail && ($imgDetail['banner_active'] != applicationConstants::ACTIVE)) {
                    LibHelper::exitWithError(Labels::getLabel('ERR_Invalid_request_Or_Inactive_Record', $this->siteLangId), true);
                }
                $attachedFileType = AttachedFile::FILETYPE_BANNER;
                $promotionRecordId = $promotionDetails['banner_id'];
                break;
            case Promotion::TYPE_SLIDES:
                $imgDetail = Slides::getAttributesById($promotionDetails['slide_id']);
                if (!false == $imgDetail && ($imgDetail['slide_active'] != applicationConstants::ACTIVE)) {
                    LibHelper::exitWithError(Labels::getLabel('ERR_Invalid_request_Or_Inactive_Record', $this->siteLangId), true);
                }
                $attachedFileType = AttachedFile::FILETYPE_HOME_PAGE_BANNER;
                $promotionRecordId = $promotionDetails['slide_id'];
                break;
        }

        if (!false == $imgDetail) {
            $image = AttachedFile::getAttachment($attachedFileType, $promotionRecordId, 0, $lang_id, (count($languages) > 1) ? false : true, $screen);
            $this->set('image', $image);
        }

        $this->set('promotionType', $promotionType);
        $this->set("canEdit", $this->objPrivilege->canEditPromotions($this->admin_id, true));
        $this->set('promotionId', $recordId);
        $this->set('bannerTypeArr', applicationConstants::getAllLanguages());
        $this->set('screenTypeArr', array(0 => '') + applicationConstants::getDisplaysArr($this->siteLangId));
        $this->set('language', Language::getAllNames());
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function autoCompleteSelprods(int $userId = 0, int $selProdId = 0, bool $return = false)
    {
        $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = (2 > $page) ? 1 : $page;

        $db = FatApp::getDb();
        $srch = new ProductSearch($this->siteLangId);
        $srch->joinSellerProducts();

        if (0 < $selProdId) {
            $srch->addCondition('selprod_id', '=', $selProdId);
        } else {
            $srch->addCondition('selprod_id', '>', 0);
        }

        $srch->addCondition('selprod_user_id', '=', $userId);

        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        if (!empty($keyword)) {
            $srch->addDirectCondition("(selprod_title like " . $db->quoteVariable('%' . $keyword . '%') . " or product_name LIKE " . $db->quoteVariable('%' . $keyword . '%') . " or product_identifier LIKE " . $db->quoteVariable('%' . $keyword . '%') . " )", 'and');
        }

        $srch->setPageSize($pageSize);
        $srch->setPageNumber($page);
        $srch->addMultipleFields([
            'selprod_id as id',
            'IFNULL(IFNULL(selprod_title, product_identifier), IFNULL(product_name, product_identifier)) as text'
        ]);

        if (true === $return) {
            return FatApp::getDb()->fetch($srch->getResultSet());
        }

        $products = FatApp::getDb()->fetchAll($srch->getResultSet());
        die(json_encode(['pageCount' => $srch->pages(), 'results' => $products]));
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditPromotions();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        if (1 > $recordId) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST_ID', $this->siteLangId), true);
        }

        $data = Promotion::getAttributesById($recordId, array('promotion_id', 'promotion_user_id'));
        if (!$data) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST_ID', $this->siteLangId), true);
        }

        $this->markAsDeleted($recordId);

        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_RECORD_DELETED_SUCCESSFULLY', $this->siteLangId));
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditPromotions();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('promotion_ids'));

        if (empty($recordIdsArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }
            $this->markAsDeleted($recordId);
        }
        $this->set('msg', Labels::getLabel('MSG_RECORDS_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $obj = new Promotion($recordId);
        $obj->assignValues(array(Promotion::tblFld('deleted') => 1));
        if (!$obj->save()) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    protected function getLangForm($recordId, $langId)
    {
        $frm = new Form('frmPromotionLang');
        $frm->addHiddenField('', 'promotion_id', $recordId);

        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_promotion_name', $langId), 'promotion_name');

        return $frm;
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'promotion_id', applicationConstants::SORT_DESC);
        }

        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $frm->addDateField(Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'date_from', '', array('placeholder' => Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addDateField(Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'date_to', '', array('placeholder' => Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_ACTIVATION_STATUS', $this->siteLangId), 'active', array(-1 => 'Does not Matter') + $activeInactiveArr, '', array(), '');

        $yesNoArr = applicationConstants::getYesNoArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_APPROVED', $this->siteLangId), 'approve', array(-1 => 'Does not Matter') + $yesNoArr, '', array(), '');

        $frm->addTextBox(Labels::getLabel('FRM_IMPRESSION_FROM_(NUMBER)', $this->siteLangId), 'impression_from');
        $frm->addTextBox(Labels::getLabel('FRM_IMPRESSION_TO_(NUMBER)', $this->siteLangId), 'impression_to');

        $frm->addTextBox(Labels::getLabel('FRM_CLICKS_FROM_(NUMBER)', $this->siteLangId), 'click_from');
        $frm->addTextBox(Labels::getLabel('FRM_CLICKS_TO_(NUMBER)', $this->siteLangId), 'click_to');
        $frm->addHiddenField('', 'promotion_id');
        $frm->addSelectBox(Labels::getLabel('FRM_TYPE', $this->siteLangId), 'type', array('-1' => Labels::getLabel('FRM_ALL_TYPE', $this->siteLangId)) + Promotion::getTypeArr($this->siteLangId), '', array(), '');
        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);/*clearBtn*/
        return $frm;
    }

    private function getForm($recordId = 0)
    {
        $frm = new Form('frmPromotion');
        $frm->addHiddenField('', 'promotion_id', $recordId);
        $frm->addHiddenField('', 'promotion_record_id');
        $frm->addRequiredField(Labels::getLabel('FRM_PROMOTION_NAME', $this->siteLangId), 'promotion_name');

        $selectedProductRow = [];
        $selectedValue = 0;
        if ($recordId > 0) {
            $srch = new PromotionSearch($this->siteLangId);
            $srch->addCondition('promotion_id', '=', $recordId);
            $srch->addMultipleFields(array('promotion_type', 'promotion_record_id', 'promotion_user_id'));
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $rs = $srch->getResultSet();
            $promotion = FatApp::getDb()->fetch($rs);

            $promotionTypeArr = Promotion::getTypeArr($this->siteLangId);
            $promotioTypeValue = $promotionTypeArr[$promotion['promotion_type']];
            $promotioTypeArr = array($promotion['promotion_type'] => $promotioTypeValue);

            $selectedValue = $promotion['promotion_record_id'];
            if (Promotion::TYPE_PRODUCT == $promotion['promotion_type']) {
                $product = $this->autoCompleteSelprods($promotion['promotion_user_id'], $promotion['promotion_record_id'], true);
                $selectedProductRow[$product['id']] = $product['text'];
            }
        } else {
            $promotioTypeArr = Promotion::getTypeArr($this->siteLangId);
        }
        $pTypeFld = $frm->addSelectBox(Labels::getLabel('FRM_TYPE', $this->siteLangId), 'promotion_type', $promotioTypeArr, '', array(), '');
        $frm->addSelectBox(Labels::getLabel('FRM_BUDGET_DURATION_FOR', $this->siteLangId), 'promotion_duration', Promotion::getPromotionBudgetDurationArr($this->siteLangId), '', array('id' => 'promotion_duration'), Labels::getLabel('FRM_SELECT', $this->siteLangId))->requirements()->setRequired();

        /* Shop [ */
        $frm->addTextBox(Labels::getLabel('FRM_SHOP', $this->siteLangId), 'promotion_shop', '', array('readonly' => true))->requirements()->setRequired(true);;
        $shopUnReqObj = new FormFieldRequirement('promotion_shop', Labels::getLabel('FRM_SHOP', $this->siteLangId));
        $shopUnReqObj->setRequired(false);

        $shopReqObj = new FormFieldRequirement('promotion_shop', Labels::getLabel('FRM_SHOP', $this->siteLangId));
        $shopReqObj->setRequired(true);

        $frm->addTextBox(Labels::getLabel('FRM_CPC', $this->siteLangId) . "[" . $this->siteDefaultCurrencyCode . "]", 'promotion_shop_cpc', FatApp::getConfig('CONF_CPC_SHOP', FatUtility::VAR_FLOAT, 0), array('readonly' => true));
        /*]*/

        /* Product [ */
        $frm->addSelectBox(Labels::getLabel('FRM_PRODUCT', $this->siteLangId), 'promotion_product', $selectedProductRow, $selectedValue)->requirements()->setRequired(true);;
        $prodUnReqObj = new FormFieldRequirement('promotion_product', Labels::getLabel('FRM_PRODUCT', $this->siteLangId));
        $prodUnReqObj->setRequired(false);

        $prodReqObj = new FormFieldRequirement('promotion_product', Labels::getLabel('FRM_PRODUCT', $this->siteLangId));
        $prodReqObj->setRequired(true);

        $frm->addTextBox(Labels::getLabel('FRM_CPC', $this->siteLangId) . '[' . $this->siteDefaultCurrencyCode . ']', 'promotion_product_cpc', FatApp::getConfig('CONF_CPC_PRODUCT', FatUtility::VAR_FLOAT, 0), array('readonly' => true));
        /* ]*/

        /* Banner Url [*/
        $frm->addTextBox(Labels::getLabel('FRM_URL', $this->siteLangId), 'banner_url')->requirements()->setRequired(true);;
        $urlUnReqObj = new FormFieldRequirement('banner_url', Labels::getLabel('FRM_URL', $this->siteLangId));
        $urlUnReqObj->setRequired(false);

        $urlReqObj = new FormFieldRequirement('banner_url', Labels::getLabel('FRM_URL', $this->siteLangId));
        $urlReqObj->setRequired(true);
        /*]*/

        /* Slide Url [*/
        $frm->addTextBox(Labels::getLabel('FRM_URL', $this->siteLangId), 'slide_url')->requirements()->setRequired(true);;
        $urlSlideUnReqObj = new FormFieldRequirement('slide_url', Labels::getLabel('FRM_URL', $this->siteLangId));
        $urlSlideUnReqObj->setRequired(false);

        $urlSlideReqObj = new FormFieldRequirement('slide_url', Labels::getLabel('FRM_URL', $this->siteLangId));
        $urlSlideReqObj->setRequired(true);

        $frm->addTextBox(Labels::getLabel('FRM_CPC', $this->siteLangId) . "[" . $this->siteDefaultCurrencyCode . "]", 'promotion_slides_cpc', FatApp::getConfig('CONF_CPC_SLIDES', FatUtility::VAR_FLOAT, 0), array('readonly' => true));

        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_BANNER, 'eq', 'banner_url', $urlReqObj);
        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SHOP, 'eq', 'banner_url', $urlUnReqObj);
        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_PRODUCT, 'eq', 'banner_url', $urlUnReqObj);
        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SLIDES, 'eq', 'banner_url', $urlUnReqObj);

        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_BANNER, 'eq', 'promotion_product', $prodUnReqObj);
        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SHOP, 'eq', 'promotion_product', $prodUnReqObj);
        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_PRODUCT, 'eq', 'promotion_product', $prodReqObj);
        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SLIDES, 'eq', 'promotion_product', $prodUnReqObj);

        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_BANNER, 'eq', 'promotion_shop', $shopUnReqObj);
        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SHOP, 'eq', 'promotion_shop', $shopReqObj);
        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_PRODUCT, 'eq', 'promotion_shop', $shopUnReqObj);
        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SLIDES, 'eq', 'promotion_shop', $shopUnReqObj);

        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_BANNER, 'eq', 'slide_url', $urlSlideUnReqObj);
        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SHOP, 'eq', 'slide_url', $urlSlideUnReqObj);
        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_PRODUCT, 'eq', 'slide_url', $urlSlideUnReqObj);
        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SLIDES, 'eq', 'slide_url', $urlSlideReqObj);

        $srch = BannerLocation::getSearchObject($this->siteLangId);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(array(
            'blocation_id',
            'blocation_promotion_cost',
            'ifnull(blocation_name,blocation_identifier) as blocation_name'
        ));
        $srch->joinTable(
            Collections::DB_TBL,
            'LEFT JOIN',
            'collections.collection_id = blocation_collection_id',
            'collections'
        );
        $srch->addFld('if(blocation_collection_id > 0,collection_deleted,0 ) as deleted');
        $srch->addFld('if(blocation_collection_id > 0,collection_active,1 ) as active');
        $srch->addHaving('deleted', '=', applicationConstants::NO);
        $srch->addHaving('active', '=', applicationConstants::ACTIVE);

        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetchAll($rs, 'blocation_id');
        $locationArr = array();
        if (!empty($row)) {
            foreach ($row as $key => $val) {
                $locationArr[$key] = $val['blocation_name'] . ' ( ' . CommonHelper::displayMoneyFormat($val['blocation_promotion_cost']) . ' )';
            }
        }
        $frm->addSelectBox(Labels::getLabel('FRM_LAYOUT_TYPE', $this->siteLangId), 'banner_blocation_id', $locationArr, '', array(), '');

        $fld = $frm->addTextBox(Labels::getLabel('FRM_BUDGET', $this->siteLangId) . '[' . $this->siteDefaultCurrencyCode . ']', 'promotion_budget');
        $fld->requirements()->setRequired();
        $fld->requirements()->setFloatPositive(true);

        $frm->addDateField(Labels::getLabel('FRM_START_DATE', $this->siteLangId), 'promotion_start_date', '', array('placeholder' => Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'))->requirements()->setRequired();
        $frm->addDateField(Labels::getLabel('FRM_END_DATE', $this->siteLangId), 'promotion_end_date', '', array('placeholder' => Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'))->requirements()->setRequired();

        $frm->addRequiredField(Labels::getLabel('FRM_PROMOTION_START_TIME', $this->siteLangId), 'promotion_start_time', '', array('class' => 'time', 'readonly' => 'readonly'));
        $frm->addRequiredField(Labels::getLabel('FRM_PROMOTION_END_TIME', $this->siteLangId), 'promotion_end_time', '', array('class' => 'time', 'readonly' => 'readonly'));

        $yesNoArr = applicationConstants::getYesNoArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_APPROVED', $this->siteLangId), 'promotion_approved', $yesNoArr, '', array(), '');
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'promotion_active', $activeInactiveArr, '', array(), '');
        $frm->addHiddenField('', 'promotion_user_id');

        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }

    private function getMediaForm($recordId = 0, $promotionType = 0, $layoutType = 0)
    {
        $recordId = FatUtility::int($recordId);
        $frm = new Form('frmRecordImage');
        $frm->addHiddenField('', 'min_width');
        $frm->addHiddenField('', 'min_height');
        $frm->addHiddenField('', 'file_type');

        $frm->addHiddenField('', 'record_id', $recordId);
        $frm->addHiddenField('', 'promotion_type', $promotionType);

        $bannerTypeArr = applicationConstants::getAllLanguages();

        if (count($bannerTypeArr) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', $bannerTypeArr, '', array(), '');
        } else {
            $lang_id = array_key_first($bannerTypeArr);
            $frm->addHiddenField('', 'lang_id', $lang_id);
        }

        $screenArr = applicationConstants::getDisplaysArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel("FRM_Display_For", $this->siteLangId), 'banner_screen', $screenArr, '', array(), '');

        $frm->addHtml('', 'banner_image', '');

        return $frm;
    }

    public function checkValidPromotionBudget()
    {
        $post = FatApp::getPostedData();
        $promotionType = Fatutility::int($post['promotion_type']);
        $promotionBudget = Fatutility::float($post['promotion_budget']);

        $minBudget = 0;

        switch ($promotionType) {
            case Promotion::TYPE_SHOP:
                $minBudget = FatApp::getConfig('CONF_CPC_SHOP', FatUtility::VAR_FLOAT, 0);
                break;
            case Promotion::TYPE_PRODUCT:
                $minBudget = FatApp::getConfig('CONF_CPC_PRODUCT', FatUtility::VAR_FLOAT, 0);
                break;
            case Promotion::TYPE_BANNER:
                $bannerLocationId = Fatutility::int($post['banner_blocation_id']);
                $srch = BannerLocation::getSearchObject($this->siteLangId);
                $srch->addMultipleFields(array('blocation_promotion_cost'));
                $srch->addCondition('blocation_id', '=', $bannerLocationId);
                $srch->doNotCalculateRecords();
                $srch->setPageSize(1);
                $rs = $srch->getResultSet();
                $row = FatApp::getDb()->fetch($rs, 'blocation_id');
                if (!empty($row)) {
                    $minBudget = $row['blocation_promotion_cost'];
                }
                break;
            case Promotion::TYPE_SLIDES:
                $minBudget = FatApp::getConfig('CONF_CPC_SLIDES', FatUtility::VAR_FLOAT, 0);
                break;
        }

        if ($minBudget > $promotionBudget) {
            LibHelper::exitWithError(Labels::getLabel("ERR_Budget_should_be_greater_than_CPC", $this->siteLangId), true);
        }
        FatUtility::dieJsonSuccess(Labels::getLabel("MSG_SUCCESS", $this->siteLangId));
    }

    public function getBannerLocationDimensions($recordId, $deviceType)
    {
        $srch = new PromotionSearch($this->siteLangId);
        $srch->joinBannersAndLocation($this->siteLangId, Promotion::TYPE_BANNER, 'b', $deviceType);
        $srch->addCondition('promotion_id', '=', $recordId);
        $srch->addMultipleFields(array('blocation_banner_width', 'blocation_banner_height'));
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $bannerDimensions = FatApp::getDb()->fetch($rs);
        $this->set('bannerWidth', $bannerDimensions['blocation_banner_width']);
        $this->set('bannerHeight', $bannerDimensions['blocation_banner_height']);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getFormColumns(): array
    {
        $promotionsTblHeadingCols = CacheHelper::get('promotionsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($promotionsTblHeadingCols) {
            return json_decode($promotionsTblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'promotion_name' => Labels::getLabel('LBL_PROMOTION_NAME', $this->siteLangId),
            'user_name' => Labels::getLabel('LBL_PROMOTION_ADVERTISER', $this->siteLangId),
            'promotion_type' => Labels::getLabel('LBL_TYPE', $this->siteLangId),
            'blocation_promotion_cost' => Labels::getLabel('LBL_CPC', $this->siteLangId),
            'promotion_budget' => Labels::getLabel('LBL_BUDGET', $this->siteLangId),
            'impressions' => Labels::getLabel('LBL_IMPRESSIONS', $this->siteLangId),
            'clicks' => Labels::getLabel('LBL_CLICKS', $this->siteLangId),
            'promotion_approved' => Labels::getLabel('LBL_APPROVED', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];

        if (count(Language::getAllNames()) < 2) {
            unset($arr['language_name']);
        }

        CacheHelper::create('promotionsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            /*  'listSerial', */
            'promotion_name',
            'user_name',
            'promotion_type',
            'blocation_promotion_cost',
            'promotion_budget',
            'impressions',
            'clicks',
            'promotion_approved',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'index':
                $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? Labels::getLabel('LBL_PPC_PROMOTION_MANAGEMENT', $this->siteLangId);
                $this->nodes = [
                    ['title' => $pageTitle]
                ];
        }
        return $this->nodes;
    }
}
