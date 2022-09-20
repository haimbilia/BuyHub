<?php

use Braintree\Collection;

class AdvertiserController extends AdvertiserBaseController
{
    use RecordOperations;
    private $recordData = [];

    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function index()
    {
        $this->userPrivilege->canViewPromotions();
        $userId = $this->userParentId;
        $user = new User($userId);

        $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'Ad';

        $walletBalance = User::getUserBalance($userId);

        $lowBalWarning = '';
        $errorSet = false;
        /* foreach($promotionList as $promotion){
          if ($promotion["promotion_start_date"]<=date("Y-m-d") && $promotion["promotion_end_date"]>=date("Y-m-d") && ($walletBalance<FatApp::getConfig('CONF_PPC_MIN_WALLET_BALANCE', FatUtility::VAR_INT, 0) && $errorSet==false)) {
          $errorSet = true;
          Message::addInfo(sprintf(Labels::getLabel('L_Please_maintain_minimum_balance_to_%s', $this->siteLangId), CommonHelper::displaymoneyformat(FatApp::getConfig('CONF_PPC_MIN_WALLET_BALANCE'))));
          }
          } */

        /* Transactions Listing [ */
        $srch = Transactions::getUserTransactionsObj($userId);
        $srch->setPageSize(applicationConstants::DASHBOARD_PAGE_SIZE);
        $rs = $srch->getResultSet();
        $transactions = FatApp::getDb()->fetchAll($rs, 'utxn_id');
        /* ] */

        /* Active Promotions [ */
        $activePSrch = $this->getPromotionsSearch(true);
        $rs = $activePSrch->getResultSet();
        $activePromotions = FatApp::getDb()->fetchAll($rs, 'promotion_id');
        /* ] */

        /* Total Promotions [ */
        $totalPSrch = $this->getPromotionsSearch();
        $totalPSrch->getResultSet();
        /* ] */

        $txnObj = new Transactions();
        $txnsSummary = $txnObj->getTransactionSummary($userId, date('Y-m-d'));
        $this->set('txnsSummary', $txnsSummary);
        $this->set('userParentId', $this->userParentId);
        $this->set('userPrivilege', UserPrivilege::getInstance());
        $this->set('totChargedAmount', Promotion::getTotalChargedAmount($userId));
        $this->set('activePromotionChargedAmount', Promotion::getTotalChargedAmount($userId, true));
        $this->set('transactions', $transactions);
        $this->set('txnStatusArr', Transactions::getStatusArr($this->siteLangId));
        $this->set('txnStatusClassArr', Transactions::getStatusClassArr());
        $this->set('activePromotions', $activePromotions);
        $this->set('totPromotions', $totalPSrch->recordCount());
        $this->set('totActivePromotions', $activePSrch->recordCount());
        $this->set('lowBalWarning', $lowBalWarning);
        // $this->set('frmRechargeWallet', $this->getRechargeWalletForm($this->siteLangId));
        $this->set('walletBalance', $walletBalance);
        $typeArr = Promotion::getTypeArr($this->siteLangId);
        $this->set('typeArr', $typeArr);
        // $this->set('promotionList', $promotionList);
        // $this->set('promotionCount', $srch->recordCount());
        $this->_template->addJs('js/slick.min.js');
        $this->_template->render(true, true);
    }

    public function getPromotionsSearch($active = false)
    {
        $pSrch = $this->searchPromotionsObj();
        $pSrch->addOrder('promotion_id', 'DESC');
        $pSrch->joinBannersAndLocation($this->siteLangId, Promotion::TYPE_BANNER, 'b');
        $pSrch->joinPromotionsLogForCount();
        $pSrch->addMultipleFields(array(
            'pr.promotion_id',
            'ifnull(pr_l.promotion_name,pr.promotion_identifier)as promotion_name',
            'pr.promotion_type',
            'pr.promotion_cpc',
            'pr.promotion_budget',
            'pr.promotion_duration',
            'pr.promotion_start_date',
            'pr.promotion_end_date',
            'pr.promotion_approved',
            'bbl.blocation_promotion_cost',
            'pri.impressions',
            'pri.clicks',
            'pri.orders',
            'promotion_start_time',
            'promotion_end_time',
            'promotion_active'
        ));

        if ($active) {
            $pSrch->addCondition('promotion_end_date', '>', date("Y-m-d"));
            $pSrch->addCondition('promotion_approved', '=', applicationConstants::YES);
            $pSrch->addCondition('promotion_active', '=', applicationConstants::YES);
        }

        $pSrch->setPageSize(applicationConstants::DASHBOARD_PAGE_SIZE);
        return $pSrch;
    }

    public function setupPromotion()
    {
        $this->userPrivilege->canEditPromotions();
        $userId = $this->userParentId;
        $frm = $this->getPromotionForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $minimumWithdrawLimit = FatApp::getConfig("CONF_PPC_MIN_WALLET_BALANCE", FatUtility::VAR_INT, 0);
        if (User::getUserBalance($this->userParentId) < $minimumWithdrawLimit) {
            FatUtility::dieJsonError(str_replace("{amount}", CommonHelper::displayMoneyFormat($minimumWithdrawLimit), Labels::getLabel('MSG_YOUR_ACCOUNT_BALANCE_HAS_TO_BE_GREATER_THAN_{amount}_TO_CREATE_PROMOTIONS.', $this->siteLangId)));
        }

        $promotion_record_id = 0;
        $promotionApproved = applicationConstants::NO;
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
                    FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
                }
                $promotion_record_id = $row['shop_id'];
                $promotionApproved = applicationConstants::YES;
                $minBudget = FatApp::getConfig('CONF_CPC_SHOP', FatUtility::VAR_FLOAT, 0);
                break;
            case Promotion::TYPE_PRODUCT:
                $selProdId = FatApp::getPostedData('promotion_record_id', FatUtility::VAR_INT, 0);

                $srch = new ProductSearch($this->siteLangId);
                $srch->joinSellerProducts();
                $srch->joinProductToCategory();
                $srch->joinSellerSubscription($this->siteLangId, true);
                $srch->addSubscriptionValidCondition();
                $srch->joinBrands();
                $srch->setPageSize(1);
                $srch->doNotCalculateRecords();
                $srch->addCondition('selprod_id', '=', $selProdId);
                $srch->addCondition('selprod_user_id', '=', $userId);
                $srch->addMultipleFields(array('selprod_id'));

                $rs = $srch->getResultSet();
                $row = FatApp::getDb()->fetch($rs);

                if (empty($row)) {
                    FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
                }
                $promotion_record_id = $row['selprod_id'];
                $promotionApproved = applicationConstants::YES;
                $minBudget = FatApp::getConfig('CONF_CPC_PRODUCT', FatUtility::VAR_FLOAT, 0);
                break;

            case Promotion::TYPE_BANNER:
                $promotion_record_id = 0;
                $bannerData = array(
                    'banner_blocation_id' => $post['banner_blocation_id'],
                    'banner_url' => $post['banner_url'],
                    'banner_target' => applicationConstants::LINK_TARGET_BLANK_WINDOW,
                    'banner_type' => Banner::TYPE_PPC,
                    'banner_active' => applicationConstants::ACTIVE
                );

                $bannerLocationId = Fatutility::int($post['banner_blocation_id']);
                $srch = BannerLocation::getSearchObject($this->siteLangId);
                $srch->addMultipleFields(array(
                    'blocation_promotion_cost'
                ));
                $srch->addCondition('blocation_id', '=', $bannerLocationId);
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
                    'slide_active' => applicationConstants::ACTIVE
                );
                $minBudget = FatApp::getConfig('CONF_CPC_SLIDES', FatUtility::VAR_FLOAT, 0);
                break;

            default:
                FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
                break;
        }

        $promotionBudget = Fatutility::float($post['promotion_budget']);
        if ($minBudget > $promotionBudget) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_BUDGET_SHOULD_BE_GREATER_THAN_CPC", $this->siteLangId));
        }
        $recordId = $post['promotion_id'];
        if (Promotion::TYPE_PRODUCT == $post['promotion_type'] || $post['promotion_type'] == Promotion::TYPE_SHOP) {
            $srch = Promotion::getSearchObject(0, false);
            $srch->addCondition('promotion_user_id', '=', $userId);
            $srch->addCondition('promotion_record_id', '=', $promotion_record_id);
            $srch->addCondition('promotion_type', '=', $post['promotion_type']);
            $srch->addCondition('promotion_duration', '=', $post['promotion_duration']);
            $srch->addCondition('promotion_start_date', '<=', $post['promotion_start_date']);
            $srch->addCondition('promotion_end_date', '>=', $post['promotion_end_date']);
            $srch->addCondition('promotion_deleted', '=', applicationConstants::NO);
            /* $srch->addCondition('promotion_end_time','=',$post['promotion_end_time']); */
            $srch->addCondition('promotion_id', '!=', $recordId);
            $rs = $srch->getResultSet();
            /* echo $srch->getQuery();die;  */
            $row = FatApp::getDb()->fetch($rs);
            if (!empty($row)) {
                FatUtility::dieJsonError(Labels::getLabel('ERR_PROMOTION_RECORD_WITH_SAME_PERIOD_ALREADY_EXISTS', $this->siteLangId));
            }
        }

        unset($post['banner_id']);
        unset($post['promotion_id']);
        /* unset($post['banner_blocation_id']); */
        unset($post['banner_url']);
        /* unset($post['banner_target']); */
        unset($post['promotion_record_id']);

        $record = new Promotion($recordId);
        $data = array(
            'promotion_user_id' => $this->userParentId,
            'promotion_added_on' => date('Y-m-d H:i:s'),
            'promotion_active' => applicationConstants::ACTIVE,
            'promotion_record_id' => $promotion_record_id,
            'promotion_identifier' => $post['promotion_name']
        );

        if (!$recordId) {
            $data['promotion_approved'] = $promotionApproved;
        }

        if ($post['promotion_type'] == Promotion::TYPE_SHOP) {
            $data['promotion_cpc'] = $post['promotion_shop_cpc'];
        } elseif ($post['promotion_type'] == Promotion::TYPE_PRODUCT) {
            $data['promotion_cpc'] = $post['promotion_product_cpc'];
        } elseif ($post['promotion_type'] == Promotion::TYPE_SLIDES) {
            $data['promotion_cpc'] = $post['promotion_slides_cpc'];
        } else {
            $srch = BannerLocation::getSearchObject($this->siteLangId);
            $srch->addMultipleFields(array(
                'blocation_id',
                'blocation_promotion_cost',
                'ifnull(blocation_name,blocation_identifier) as blocation_name'
            ));
            $rs = $srch->getResultSet();
            $row = FatApp::getDb()->fetchAll($rs, 'blocation_id');
            $data['promotion_cpc'] = $row[$post['banner_blocation_id']]['blocation_promotion_cost'];
        }

        $data = array_merge($data, $post);
        $record->assignValues($data);

        if (!$record->save()) {
            FatUtility::dieJsonError($record->getError());
        }
        $recordId = $record->getMainTableRecordId();

        $this->setLangData($record, [$record::tblFld('name') => $post[$record::tblFld('name')]]);

        switch ($post['promotion_type']) {
            case Promotion::TYPE_BANNER:
                $bannerId = 0;
                $srch = Banner::getSearchObject();
                $srch->addCondition('banner_type', '=', Banner::TYPE_PPC);
                $srch->addCondition('banner_record_id', '=', $recordId);
                $srch->addMultipleFields(array('banner_id'));
                $rs = $srch->getResultSet();
                $row = FatApp::getDb()->fetch($rs);

                if ($row) {
                    $bannerId = $row['banner_id'];
                }

                $bannerRecord = new Banner($bannerId);
                $bannerData['banner_record_id'] = $recordId;
                $bannerRecord->assignValues($bannerData);

                if (!$bannerRecord->save()) {
                    FatUtility::dieJsonError($bannerRecord->getError());
                }

                $recordId = $bannerRecord->getMainTableRecordId();
                if (!$bannerRecord->updateLangData(CommonHelper::getDefaultFormLangId(), ['banner_title' => $post['promotion_name']])) {
                    LibHelper::exitWithError($bannerRecord->getError(), true);
                }
                break;

            case Promotion::TYPE_SLIDES:
                $slideId = 0;
                $srch = Slides::getSearchObject();
                $srch->addCondition('slide_type', '=', Slides::TYPE_PPC);
                $srch->addCondition('slide_record_id', '=', $recordId);
                $srch->addMultipleFields(array('slide_id'));
                $rs = $srch->getResultSet();
                $row = FatApp::getDb()->fetch($rs);
                if ($row) {
                    $slideId = $row['slide_id'];
                }

                $slideRecord = new Slides($slideId);
                $slidesData['slide_record_id'] = $recordId;
                $slideRecord->assignValues($slidesData);

                if (!$slideRecord->save()) {
                    FatUtility::dieJsonError($slideRecord->getError());
                }
                break;
        }

        $notificationData = array(
            'notification_record_type' => Notification::TYPE_PROMOTION,
            'notification_record_id' => $recordId,
            'notification_user_id' => $this->userParentId,
            'notification_label_key' => Notification::PROMOTION_APPROVAL_NOTIFICATION,
            'notification_added_on' => date('Y-m-d H:i:s')
        );

        if (!Notification::saveNotifications($notificationData)) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_NOTIFICATION_COULD_NOT_BE_SENT", $this->siteLangId));
        }

        if ($post['promotion_type'] == Promotion::TYPE_SHOP || $post['promotion_type'] == Promotion::TYPE_PRODUCT) {
            $this->set('noMediaTab', 'noMediaTab');
        }



        $this->_template->render(false, false, 'json-success.php');
    }

    public function setupPromotionLang()
    {
        $this->userPrivilege->canEditPromotions();
        $post = FatApp::getPostedData();
        $userId = $this->userParentId;

        $promotionId = $post['promotion_id'];
        $langId = $post['lang_id'];

        if ($promotionId == 0 || $langId == 0) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $promotionData = Promotion::getAttributesById($promotionId, array('promotion_user_id'));
        if (!$promotionData || ($promotionData && $promotionData['promotion_user_id'] != $userId)) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $frm = $this->getPromotionLangForm($promotionId, $langId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }
        $record = new Promotion($promotionId);

        $this->setLangData($record, [$record::tblFld('name') => $post[$record::tblFld('name')]], $langId);

        $promotionType = Promotion::getAttributesById($promotionId, array('promotion_type'));
        if ($promotionType['promotion_type'] == Promotion::TYPE_SHOP || $promotionType['promotion_type'] == Promotion::TYPE_PRODUCT) {
            $this->set('noMediaTab', 'noMediaTab');
        }
        $this->_template->render(false, false, 'json-success.php');
    }

    public function promotionUpload()
    {
        $this->userPrivilege->canEditPromotions();
        $userId = $this->userParentId;
        $post = FatApp::getPostedData();

        $promotionId = FatUtility::int($post['promotion_id']);
        $promotionType = FatUtility::int($post['promotion_type']);
        $langId = FatUtility::int($post['lang_id']);
        $bannerScreen = FatUtility::int($post['banner_screen']);

        $allowedTypeArr = array(
            Promotion::TYPE_BANNER,
            Promotion::TYPE_SLIDES
        );

        if (1 > $promotionId || !in_array($promotionType, $allowedTypeArr)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_PLEASE_SELECT_A_FILE', $this->siteLangId));
        }

        $recordId = 0;
        $attachedFileType = 0;

        $srch = new PromotionSearch($this->siteLangId);
        $srch->addCondition('promotion_id', '=', $promotionId);
        $srch->addCondition('promotion_user_id', '=', $userId);

        switch ($promotionType) {
            case Promotion::TYPE_BANNER:
                $srch->joinBannersAndLocation($this->siteLangId, Promotion::TYPE_BANNER, 'b');
                $rs = $srch->getResultSet();
                $promotionDetails = FatApp::getDb()->fetch($rs);
                $recordId = $promotionDetails['banner_id'];
                $attachedFileType = AttachedFile::FILETYPE_BANNER;
                break;
            case Promotion::TYPE_SLIDES:
                $srch->joinSlides();
                $rs = $srch->getResultSet();
                $promotionDetails = FatApp::getDb()->fetch($rs);
                $recordId = $promotionDetails['slide_id'];
                $attachedFileType = AttachedFile::FILETYPE_HOME_PAGE_BANNER;
                break;
        }

        if (1 > $recordId || 1 > $attachedFileType) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }
        $db = FatApp::getDb();
        $db->startTransaction();
        $fileHandlerObj = new AttachedFile();

        if (!$res = $fileHandlerObj->saveImage($_FILES['cropped_image']['tmp_name'], $attachedFileType, $recordId, 0, $_FILES['cropped_image']['name'], -1, true, $langId, '', $bannerScreen)) {
            FatUtility::dieJsonError($fileHandlerObj->getError());
        }


        /* if($promotionDetails['promotion_approved']==applicationConstants::YES){ */
        $dataToUpdate = array(
            'promotion_approved' => applicationConstants::NO
        );
        $record = new Promotion($promotionId);
        $record->assignValues($dataToUpdate);

        if (!$record->save()) {
            $db->rollbackTransaction();
            FatUtility::dieJsonError($record->getError());
        }
        $objEmailHandler = new EmailHandler();
        $objEmailHandler->sendPromotionApprovalRequestAdmin($this->siteLangId, $userId, $promotionDetails);

        $notificationData = array(
            'notification_record_type' => Notification::TYPE_PROMOTION,
            'notification_record_id' => $promotionId,
            'notification_user_id' => $this->userParentId,
            'notification_label_key' => Notification::PROMOTION_APPROVAL_NOTIFICATION,
            'notification_added_on' => date('Y-m-d H:i:s')
        );

        if (!Notification::saveNotifications($notificationData)) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_NOTIFICATION_COULD_NOT_BE_SENT", $this->siteLangId));
        }
        /* } */
        $db->commitTransaction();

        $fileName = $_FILES['cropped_image']['name'];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileName = strlen($fileName) > 10 ? substr($fileName, 0, 10) . '.' . $ext : $fileName;
        Message::addMessage($fileName . " " . Labels::getLabel('MSG_FILE_UPLOADED_SUCCESSFULLY_AND_SEND_IT_FOR_ADMIN_APPROVAL', $this->siteLangId));

        $this->set('promotionId', $promotionId);
        $this->set('file', $_FILES['cropped_image']['name']);
        FatUtility::dieJsonSuccess(Message::getHtml());
    }

    public function searchPromotions()
    {
        $this->userPrivilege->canViewPromotions();
        $userId = $this->userParentId;
        $pagesize = FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10);
        $frmSearch = $this->getPromotionSearchForm($this->siteLangId);

        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $frmSearch->getFormDataFromArray($data);
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);

        $srch = $this->searchPromotionsObj();

        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('pr.promotion_identifier', 'like', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('pr_l.promotion_name', 'like', '%' . $post['keyword'] . '%');
        }

        $type = FatApp::getPostedData('type', FatUtility::VAR_INT, '-1');
        if ($type != '-1') {
            $srch->addCondition('promotion_type', '=', $type);
        }

        $active_promotion = FatApp::getPostedData('active_promotion', FatUtility::VAR_INT, '-1');
        if ($active_promotion != '-1') {
            $srch->addCondition('promotion_active', '=', applicationConstants::YES);
            $srch->addCondition('promotion_deleted', '=', applicationConstants::NO);
            $srch->addCondition('promotion_end_date', '>', date("Y-m-d"));
            $srch->addCondition('promotion_approved', '=', applicationConstants::YES);
        }

        $dateFrom = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
        $dateTo = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');

        if (!empty($dateFrom) || (!empty($dateTo))) {
            $srch->addDateCondition($dateFrom, $dateTo);
        }

        $this->setRecordCount(clone $srch, $pagesize, $page, $post);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(array(
            'promotion_id',
            'promotion_budget',
            'promotion_duration',
            'promotion_type',
            'IFNULL(promotion_name,promotion_identifier) as promotion_name',
            'promotion_start_date',
            'promotion_end_date',
            'promotion_start_time',
            'promotion_end_time',
            'promotion_active',
            'promotion_approved',
            'promotion_active'
        ));
        $srch->addOrder('promotion_id', 'DESC');
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs, 'promotion_id');
        $promotionBudgetDurationArr = Promotion::getPromotionBudgetDurationArr($this->siteLangId);

        $this->set('arrYesNo', applicationConstants::getYesNoArr($this->siteLangId));
        $this->set('arrYesNoClassArr', applicationConstants::getYesNoClassArr());
        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->siteLangId));
        $this->set('canEdit', $this->userPrivilege->canEditPromotions(0, true));
        $this->set('promotionBudgetDurationArr', $promotionBudgetDurationArr);
        $this->set('arrListing', $records);
        $this->set('postedData', $post);
        $this->set('userId', $userId);
        $this->set('typeArr', Promotion::getTypeArr($this->siteLangId));
        $this->set('isPpcBalanceSufficent', 0 <= (User::getUserBalance($this->userParentId, true, true) - FatApp::getConfig('CONF_PPC_MIN_WALLET_BALANCE')));
        $this->_template->render(false, false);
    }

    public function searchPromotionsObj()
    {
        $srch = new PromotionSearch($this->siteLangId);
        $srch->addCondition('promotion_deleted', '=', applicationConstants::NO);
        $srch->addCondition('promotion_user_id', '=', $this->userParentId);
        return $srch;
    }

    private function getTypeData($promotionId, $promotionType = 0)
    {
        $promotionType = FatUtility::int($promotionType);
        $promotionId = FatUtility::int($promotionId);

        $userId = $this->userParentId;

        if (1 > $promotionType) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }

        $label = '';
        $value = 0;
        switch ($promotionType) {
            case Promotion::TYPE_SHOP:
                $srch = Shop::getSearchObject(true, $this->siteLangId);
                $srch->addCondition('shop_user_id', '=', $userId);
                $srch->setPageSize(1);
                $srch->doNotCalculateRecords();
                $srch->addMultipleFields(array('ifnull(shop_name,shop_identifier) as shop_name', 'shop_id'));
                $rs = $srch->getResultSet();
                $row = FatApp::getDb()->fetch($rs);
                if (empty($row)) {
                    FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
                }
                $label = $row['shop_name'];
                $value = $row['shop_id'];
                break;

            case Promotion::TYPE_PRODUCT:
                if ($promotionId > 0) {
                    $row = Promotion::getAttributesById($promotionId, array(
                        'promotion_record_id'
                    ));

                    $srch = new PromotionSearch($this->siteLangId);
                    $srch->joinProducts();
                    $srch->addCondition('selprod_user_id', '=', $userId);
                    $srch->addCondition('selprod_id', '=', $row['promotion_record_id']);
                    $srch->setPageSize(1);
                    $srch->doNotCalculateRecords();
                    $srch->addMultipleFields(array(
                        'selprod_id',
                        'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title',
                        'ifnull(product_name,product_identifier)as product_name'
                    ));
                    $rs = $srch->getResultSet();
                    $row = FatApp::getDb()->fetch($rs);
                    if (!empty($row)) {
                        $variantStr = '';
                        $options = SellerProduct::getSellerProductOptions($row['selprod_id'], true, $this->siteLangId);
                        if (is_array($options) && count($options)) {
                            foreach ($options as $op) {
                                $variantStr .= '(' . $op['option_name'] . ': ' . $op['optionvalue_name'] . ')';
                            }
                        }
                        $label = ($row['selprod_title'] != '') ? $row['selprod_title'] . $variantStr : $row['product_name'] . $variantStr;
                        $value = $row['selprod_id'];
                    }
                }
                break;
        }

        return [
            'promotionType' => $promotionType,
            'label' => $label,
            'value' => $value
        ];
    }

    public function promotions()
    {
        $this->userPrivilege->canViewPromotions();
        $data = FatApp::getPostedData();
        $frmSearch = $this->getPromotionSearchForm($this->siteLangId);
        if ($data) {
            $frmSearch->fill($data);
        }
        $userId = $this->userParentId;
        $srch = new PromotionSearch($this->siteLangId);
        $srch->addMultipleFields(array(
            'promotion_id'
        ));
        $srch->addCondition('promotion_user_id', '=', $userId);
        $srch->addCondition('promotion_deleted', '=', applicationConstants::NO);
        $srch->addCondition('promotion_active', '=', applicationConstants::YES);
        $srch->addCondition('promotion_end_date', '>=', date("Y-m-d"));
        $srch->addOrder('promotion_id', 'DESC');

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs, 'promotion_id');

        $this->_template->addJs(array('js/jquery.datetimepicker.js'), false);
        $this->_template->addCss(array('css/jquery.datetimepicker.css'), false);
        $this->_template->addJs('js/cropper.js');
        $this->_template->addJs('js/cropper-main.js');
        $this->set('canEdit', $this->userPrivilege->canEditPromotions(0, true));
        $this->set("frmSearch", $frmSearch);
        $this->set("records", $records);
        $this->set("keywordPlaceholder", Labels::getLabel('LBL_SEARCH_BY_PROMOTION_NAME', $this->siteLangId));
        $this->_template->addJs(array('js/select2.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->_template->render(true, true);
    }

    public function promotionCharges()
    {
        $this->userPrivilege->canViewPromotions();
        $this->_template->render(true, true);
    }

    public function searchPromotionCharges()
    {
        $this->userPrivilege->canViewPromotions();
        $userId = $this->userParentId;
        $pagesize = FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10);
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $prmSrch = new SearchBase(Promotion::DB_TBL_CHARGES, 'tpc');
        $prmSrch->joinTable(Promotion::DB_TBL, 'INNER JOIN', 'pr.' . Promotion::DB_TBL_PREFIX . 'id = tpc.' . Promotion::DB_TBL_CHARGES_PREFIX . 'promotion_id', 'pr');
        $prmSrch->addCondition('pr.promotion_user_id', '=', $userId);
        $prmSrch->addMultipleFields(array(
            'promotion_id',
            'promotion_type',
            'promotion_identifier',
            'sum(pcharge_charged_amount) as totChargedAmount',
            'sum(pcharge_clicks) as totClicks',
            'pcharge_date'
        ));
        $prmSrch->addGroupBy('promotion_id');
        $this->setRecordCount(clone $prmSrch, $pagesize, $page, $data, true);
        $prmSrch->doNotCalculateRecords();
        $prmSrch->addOrder('tpc.' . Promotion::DB_TBL_CHARGES_PREFIX . 'id', 'desc');
        $prmSrch->setPageNumber($page);
        $prmSrch->setPageSize($pagesize);
        $this->set("arrListing", FatApp::getDb()->fetchAll($prmSrch->getResultSet()));
        $this->set('typeArr', Promotion::getTypeArr($this->siteLangId));
        $this->set('postedData', $data);
        $this->_template->render(false, false);
    }

    public function promotionForm($recordId = 0)
    {
        $userId = $this->userParentId;
        $recordId = FatUtility::int($recordId);

        $promotionDetails = array();
        $promotionType = 0;
        $identifier = '';
        if ($recordId) {
            $srch = new PromotionSearch($this->siteLangId);
            $srch->joinBannersAndLocation($this->siteLangId, Promotion::TYPE_BANNER, 'b');
            $srch->joinSlides($this->siteLangId);
            if (User::isSeller()) {
                $srch->joinShops($this->siteLangId, false, false);
                $srch->addFld(array(
                    'ifnull(shop_name,shop_identifier) as promotion_shop'
                ));
            }
            $srch->addCondition('promotion_id', '=', $recordId);
            $srch->addCondition('promotion_user_id', '=', $userId);
            $srch->addMultipleFields(array(
                'promotion_id',
                'promotion_identifier',
                'IFNULL(promotion_name,promotion_identifier) as promotion_name',
                'promotion_user_id',
                'promotion_type',
                'promotion_budget',
                'promotion_cpc',
                'promotion_duration',
                'promotion_start_date',
                'promotion_end_date',
                'promotion_start_time',
                'promotion_end_time',
                'promotion_active',
                'promotion_approved',
                'banner_url',
                'banner_target',
                'banner_blocation_id',
                'slide_url',
                'slide_target'
            ));
            $rs = $srch->getResultSet();
            $promotionDetails = FatApp::getDb()->fetch($rs);
            if (false == $promotionDetails) {
                FatUtility::dieJsonError($this->str_invalid_request);
            }

            $promotionType = $promotionDetails['promotion_type'];
            if ($promotionDetails) {
                $promotionDetails['promotion_start_time'] = date('H:i', strtotime($promotionDetails['promotion_start_time']));
                $promotionDetails['promotion_end_time'] = date('H:i', strtotime($promotionDetails['promotion_end_time']));
                if ($promotionDetails['promotion_type'] == Promotion::TYPE_SHOP) {
                    $promotionDetails['promotion_shop_cpc'] = $promotionDetails['promotion_cpc'];
                } elseif ($promotionDetails['promotion_type'] == Promotion::TYPE_PRODUCT) {
                    $promotionDetails['promotion_product_cpc'] = $promotionDetails['promotion_cpc'];
                } elseif ($promotionDetails['promotion_type'] == Promotion::TYPE_SLIDES) {
                    $promotionDetails['promotion_slides_cpc'] = $promotionDetails['promotion_cpc'];
                }

                $typeData = $this->getTypeData($promotionDetails['promotion_id'], $promotionDetails['promotion_type']);
                $this->recordData = ['id' => $typeData['value'], 'label' => $typeData['label']];
            }
            $identifier = $promotionDetails[Promotion::tblFld('identifier')];
        }

        $srch = Shop::getSearchObject(true, $this->siteLangId);
        $srch->addCondition('shop_user_id', '=', $userId);
        $srch->setPageSize(1);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(array('ifnull(shop_name,shop_identifier) as shop_name', 'shop_id'));
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (false != $row) {
            $promotionDetails['promotion_shop'] = $row['shop_name'];
        }


        $frm = $this->getPromotionForm($recordId);
        $frm->fill($promotionDetails);

        $this->set('frm', $frm);
        $this->set('recordId', $recordId);
        $this->set('promotionType', $promotionType);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('languages', Language::getAllNames());
        $this->set('identifier', $identifier);
        $this->_template->render(false, false);
    }

    public function promotionLangForm($recordId, $langId, $autoFillLangData = 0)
    {
        $recordId = FatUtility::int($recordId);
        $langId = FatUtility::int($langId);

        $langFrm = $this->getPromotionLangForm($recordId, $langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(Promotion::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($recordId, $langId, CommonHelper::getDefaultFormLangId());
            if (false === $translatedData) {
                Message::addErrorMessage($updateLangDataobj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
            $langData = current($translatedData);
        } else {
            $langData = Promotion::getAttributesByLangId($langId, $recordId);
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        $promotionType = 0;
        $row = Promotion::getAttributesById($recordId, array('promotion_type'));
        if (!empty($row)) {
            $promotionType = $row['promotion_type'];
        }

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('langId', $langId);
        $this->set('promotionType', $promotionType);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->_template->render(false, false);
    }

    public function promotionMediaForm($recordId = 0)
    {
        $userId = $this->userParentId;
        $recordId = FatUtility::int($recordId);

        if (1 > $recordId) {
            FatUtility::dieWithError(Labels::getLabel('Lbl_Invalid_request', $this->siteLangId));
        }

        $promotionType = 0;

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
        $srch->addCondition('promotion_user_id', '=', $userId);
        $srch->addMultipleFields(array(
            'promotion_id',
            'promotion_type',
            'banner_id',
            'blocation_banner_width',
            'blocation_banner_height',
            'slide_id',
            'collection_layout_type',
        ));
        $promotionDetails = FatApp::getDb()->fetch($srch->getResultSet());
        if (empty($promotionDetails)) {
            FatUtility::dieWithError(Labels::getLabel('Lbl_Invalid_request', $this->siteLangId));
        }
        $promotionType = $promotionDetails['promotion_type'];

        $mediaFrm = $this->getPromotionMediaForm($recordId, $promotionType, $promotionDetails['collection_layout_type']);
        $bannerWidth = '';
        $bannerHeight = '';
        if ($promotionType == Promotion::TYPE_BANNER) {
            $bannerWidth = FatUtility::convertToType($promotionDetails['blocation_banner_width'], FatUtility::VAR_FLOAT);
            $bannerHeight = FatUtility::convertToType($promotionDetails['blocation_banner_height'], FatUtility::VAR_FLOAT);
        }

        $silesScreenDimensions = ImageDimension::getScreenSizes(ImageDimension::TYPE_SLIDE);

        $this->set('bannerWidth', $bannerWidth);
        $this->set('bannerHeight', $bannerHeight);
        $this->set('silesScreenDimensions', $silesScreenDimensions);

        $this->set('promotionType', $promotionType);
        $this->set('bannerTypeArr', applicationConstants::getAllLanguages());
        $this->set('screenTypeArr', array(
            0 => ''
        ) + applicationConstants::getDisplaysArr($this->siteLangId));
        $this->set('recordId', $recordId);
        $this->set('languages', Language::getAllNames());
        $this->set('mediaFrm', $mediaFrm);
        $this->_template->render(false, false);
    }

    public function images($promotionId = 0, $langId = 0, $screen = 0)
    {
        $this->userPrivilege->canViewPromotions();
        $userId = $this->userParentId;
        $promotionId = FatUtility::int($promotionId);

        if (1 > $promotionId) {
            FatUtility::dieWithError(Labels::getLabel('Lbl_Invalid_request', $this->siteLangId));
        }

        $promotionType = 0;

        $srch = new PromotionSearch($this->siteLangId);
        $srch->joinBannersAndLocation($this->siteLangId, Promotion::TYPE_BANNER, 'b');
        $srch->joinSlides();
        $srch->addCondition('promotion_id', '=', $promotionId);
        $srch->addCondition('promotion_user_id', '=', $userId);
        $srch->addMultipleFields(array(
            'promotion_id',
            'promotion_type',
            'banner_id',
            'blocation_banner_width',
            'blocation_banner_height',
            'slide_id'
        ));
        $rs = $srch->getResultSet();
        $promotionDetails = FatApp::getDb()->fetch($rs);
        if (empty($promotionDetails)) {
            FatUtility::dieWithError(Labels::getLabel('Lbl_Invalid_request', $this->siteLangId));
        }
        $promotionType = $promotionDetails['promotion_type'];

        $recordId = 0;
        $attachedFileType = 0;
        $imgDetail = false;
        switch ($promotionType) {
            case Promotion::TYPE_BANNER:
                $imgDetail = Banner::getAttributesById($promotionDetails['banner_id']);
                $attachedFileType = AttachedFile::FILETYPE_BANNER;
                $recordId = $promotionDetails['banner_id'];
                break;
            case Promotion::TYPE_SLIDES:
                $imgDetail = Slides::getAttributesById($promotionDetails['slide_id']);
                $attachedFileType = AttachedFile::FILETYPE_HOME_PAGE_BANNER;
                $recordId = $promotionDetails['slide_id'];
                break;
        }

        if (!false == $imgDetail) {
            $image = AttachedFile::getAttachment($attachedFileType, $recordId, 0, $langId, false, $screen);
            $this->set('image', $image);
        }

        $this->set('promotionType', $promotionType);
        $this->set('bannerTypeArr', applicationConstants::getAllLanguages());
        $this->set('screenTypeArr', array(
            0 => ''
        ) + applicationConstants::getDisplaysArr($this->siteLangId));
        $this->set('promotionId', $promotionId);
        $this->set('canEdit', $this->userPrivilege->canEditPromotions(0, true));
        $this->_template->render(false, false);
    }

    public function removePromotionBanner()
    {
        $this->userPrivilege->canEditPromotions();
        $promotionId = FatApp::getPostedData('promotionId', FatUtility::VAR_INT, 0);
        $bannerId = FatApp::getPostedData('bannerId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        $screen = FatApp::getPostedData('screen', FatUtility::VAR_INT, 0);

        $data = Promotion::getAttributesById($promotionId, array(
            'promotion_id',
            'promotion_type',
            'promotion_user_id'
        ));
        if (!$data || $data['promotion_user_id'] != $this->userParentId) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST_ID', $this->siteLangId));
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
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }

        if (!$fileHandlerObj->deleteFile($attachedFileType, $bannerId, 0, 0, $langId, $screen)) {
            FatUtility::dieJsonError($fileHandlerObj->getError());
        }

        $this->set('msg', Labels::getLabel('MSG_Deleted_successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function autoCompleteSelprods()
    {
        $pagesize = 20;
        $post = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }

        $userId = $this->userParentId;
        $db = FatApp::getDb();

        $srch = new ProductSearch($this->siteLangId);
        $srch->joinSellerProducts();
        $srch->joinProductToCategory();
        $srch->joinSellerSubscription($this->siteLangId, true);
        $srch->addSubscriptionValidCondition();

        $post = FatApp::getPostedData();
        $srch->addCondition('selprod_id', '>', 0);
        $srch->addCondition('selprod_user_id', '=', $userId);
        if (!empty($post['keyword'])) {
            /* $srch->addCondition('selprod_title', 'LIKE', '%' . $post['keyword'] . '%');
              $srch->addCondition('product_name', 'LIKE', '%' . $post['keyword'] . '%','OR');
              $srch->addCondition('product_identifier', 'LIKE', '%' . $post['keyword'] . '%','OR'); */
            $srch->addDirectCondition("(selprod_title like " . $db->quoteVariable($post['keyword']) . " or selprod_title like " . $db->quoteVariable('%' . $post['keyword'] . '%') . " or product_name LIKE " . $db->quoteVariable('%' . $post['keyword'] . '%') . " or product_identifier LIKE " . $db->quoteVariable('%' . $post['keyword'] . '%') . ")", 'and');
        }
        $srch->setPageSize(FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10));

        $srch->addMultipleFields(array(
            'selprod_id as id',
            'IFNULL(product_name,product_identifier) as product_name, IFNULL(selprod_title,product_identifier) as selprod_title'
        ));

        $srch->setPageSize($pagesize);
        $srch->setPageNumber($page);
        $rs = $srch->getResultSet();

        $products = $db->fetchAll($rs, 'id');
        $pageCount = $srch->pages();

        $json = array();
        foreach ($products as $key => $product) {
            $options = SellerProduct::getSellerProductOptions($key, true, $this->siteLangId);
            $variantsStr = '';
            array_walk($options, function ($item, $key) use (&$variantsStr) {
                $variantsStr .= ' | ' . $item['option_name'] . ' : ' . $item['optionvalue_name'];
            });
            $json[] = array(
                'id' => $key,
                'text' => strip_tags(html_entity_decode(($product['selprod_title'] != '') ? $product['selprod_title'] . $variantsStr : $product['product_name'] . $variantsStr, ENT_QUOTES, 'UTF-8'))
            );
        }
        die(json_encode(['pageCount' => $pageCount, 'results' => $json]));
    }

    public function analytics($promotionId = 0)
    {
        $this->userPrivilege->canViewPromotions();
        $userId = $this->userParentId;
        $frmSearch = $this->getPPCAnalyticsSearchForm($this->siteLangId);
        $frmSearch->fill(array(
            'promotion_id' => $promotionId
        ));

        $srch = new PromotionSearch($this->siteLangId);
        $srch->addCondition('promotion_id', '=', $promotionId);
        $srch->addCondition('promotion_user_id', '=', $userId);
        $srch->addMultipleFields(array(
            'promotion_id',
            'promotion_type',
            'ifnull(promotion_name,promotion_identifier)as promotion_name'
        ));
        $rs = $srch->getResultSet();
        $promotionDetails = FatApp::getDb()->fetch($rs);

        if (empty($promotionDetails)) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            CommonHelper::redirectUserReferer();
        }

        $this->set('frmSearch', $frmSearch);
        $this->set('promotionDetails', $promotionDetails);

        $this->_template->render(true, true);
    }

    public function searchAnalyticsData()
    {
        $this->userPrivilege->canViewPromotions();
        $userId = $this->userParentId;
        $data = FatApp::getPostedData();
        $pageSize = FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10);

        $promotionId = FatUtility::int($data['promotion_id']);

        if ($promotionId < 1) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('advertiser', '', [], CONF_WEBROOT_DASHBOARD));
        }
        $promotionDetails = Promotion::getAttributesById($promotionId);
        if ($promotionDetails['promotion_user_id'] != $userId) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $frmSearch = $this->getPPCAnalyticsSearchForm($this->siteLangId);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $frmSearch->getFormDataFromArray($data);
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);

        $fromDate = $post['date_from'];
        $toDate = $post['date_to'];

        $srch = new SearchBase(Promotion::DB_TBL_LOGS, 'i');
        $srch->addMultipleFields(array(
            'i.plog_promotion_id',
            'sum(i.plog_impressions) as impressions',
            'sum(i.plog_clicks) as clicks',
            'sum(i.plog_orders) as orders',
            'plog_date'
        ));

        $srch->addGroupBy('plog_date');
        $srch->addOrder('plog_date', 'DESC');
        if ($fromDate != '') {
            $srch->addCondition('i.plog_date', '>=', $fromDate . ' 00:00:00');
        }
        if ($toDate != '') {
            $srch->addCondition('i.plog_date', '<=', $toDate . ' 23:59:59');
        }
        if ($promotionId != '') {
            $srch->addCondition('i.plog_promotion_id', '=', $promotionId);
        }


        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        $rs = $srch->getResultSet();
        $promotionDetails = FatApp::getDb()->fetchAll($rs);

        $this->set('pageSize', $pageSize);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('arrListing', $promotionDetails);
        $this->set('promotion_id', $promotionId);
        $this->set('page', $page);
        $this->_template->render(false, false);
    }

    private function getPromotionForm($promotionId = 0)
    {
        $frm = new Form('frmPromotion');
        $frm->addHiddenField('', 'promotion_id', $promotionId);
        $frm->addRequiredField(Labels::getLabel('FRM_PROMOTION_NAME', $this->siteLangId), 'promotion_name');

        $userId = $this->userParentId;
        $shopSrch = Shop::getSearchObject(true, $this->siteLangId);
        $shopSrch->addCondition('shop_user_id', '=', $userId);
        $shopSrch->setPageSize(1);
        $shopSrch->doNotCalculateRecords();
        $shopSrch->addMultipleFields(array(
            'shop_id'
        ));
        $rs = $shopSrch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        $displayAdvertiserOnly = false;
        if (empty($row)) {
            $displayAdvertiserOnly = true;
        }

        if ($promotionId > 0) {
            $srch = new PromotionSearch($this->siteLangId);
            $srch->addCondition('promotion_id', '=', $promotionId);
            $srch->addMultipleFields(array(
                'promotion_type'
            ));
            $rs = $srch->getResultSet();
            $promotioType = FatApp::getDb()->fetch($rs);
            $promotionTypeArr = Promotion::getTypeArr($this->siteLangId, $displayAdvertiserOnly);
            $promotioTypeValue = $promotionTypeArr[$promotioType['promotion_type']];
            $promotioTypeArr = array(
                $promotioType['promotion_type'] => $promotioTypeValue
            );
        } else {
            $promotioTypeArr = Promotion::getTypeArr($this->siteLangId, $displayAdvertiserOnly);
            if (!User::isSeller()) {
                unset($promotioTypeArr[Promotion::TYPE_SHOP]);
                unset($promotioTypeArr[Promotion::TYPE_PRODUCT]);
            }
        }

        $pTypeFld = $frm->addSelectBox(Labels::getLabel('FRM_TYPE', $this->siteLangId), 'promotion_type', $promotioTypeArr, '', array(), '');

        if (User::isSeller()) {
            /* Shop [ */
            $frm->addTextBox(Labels::getLabel('FRM_SHOP', $this->siteLangId), 'promotion_shop', '', array(
                'readonly' => true
            ))->requirements()->setRequired(true);
            $shopUnReqObj = new FormFieldRequirement('promotion_shop', Labels::getLabel('FRM_SHOP', $this->siteLangId));
            $shopUnReqObj->setRequired(false);

            $shopReqObj = new FormFieldRequirement('promotion_shop', Labels::getLabel('FRM_SHOP', $this->siteLangId));
            $shopReqObj->setRequired(true);

            $frm->addTextBox(Labels::getLabel('FRM_CPC', $this->siteLangId) . '[' . commonHelper::getDefaultCurrencySymbol() . ']', 'promotion_shop_cpc', FatApp::getConfig('CONF_CPC_SHOP', FatUtility::VAR_FLOAT, 0), array(
                'readonly' => true
            ));
            /* ] */

            /* Product [ */
            $selectedProduct = [];
            if (!empty($this->recordData)) {
                $selectedProduct[$this->recordData['id']] = $this->recordData['label'];
            }

            $frm->addSelectBox(Labels::getLabel('FRM_PRODUCT', $this->siteLangId), 'promotion_record_id', $selectedProduct, key($selectedProduct), array(), Labels::getLabel('FRM_SELECT', $this->siteLangId));
            /* $frm->addTextBox(Labels::getLabel('FRM_PRODUCT', $this->siteLangId), 'promotion_record_id')->requirements()->setRequired(true); */
            $prodUnReqObj = new FormFieldRequirement('promotion_record_id', Labels::getLabel('FRM_PRODUCT', $this->siteLangId));
            $prodUnReqObj->setRequired(false);

            $prodReqObj = new FormFieldRequirement('promotion_record_id', Labels::getLabel('FRM_PRODUCT', $this->siteLangId));
            $prodReqObj->setRequired(true);

            $frm->addTextBox(Labels::getLabel('FRM_CPC' . '_[' . CommonHelper::getDefaultCurrencySymbol() . ']', $this->siteLangId), 'promotion_product_cpc', FatApp::getConfig('CONF_CPC_PRODUCT', FatUtility::VAR_FLOAT, 0), array(
                'readonly' => true
            ));
            /* ] */

            /* Banner Url [ */
            $frm->addTextBox(Labels::getLabel('FRM_URL', $this->siteLangId), 'banner_url')->requirements()->setRequired(true);
            $urlUnReqObj = new FormFieldRequirement('banner_url', Labels::getLabel('FRM_URL', $this->siteLangId));
            $urlUnReqObj->setRequired(false);

            $urlReqObj = new FormFieldRequirement('banner_url', Labels::getLabel('FRM_URL', $this->siteLangId));
            $urlReqObj->setRequired(true);
            /* ] */

            /* Slide Url [ */
            $frm->addTextBox(Labels::getLabel('FRM_URL', $this->siteLangId), 'slide_url')->requirements()->setRequired(true);
            $urlSlideUnReqObj = new FormFieldRequirement('slide_url', Labels::getLabel('FRM_URL', $this->siteLangId));
            $urlSlideUnReqObj->setRequired(false);

            $urlSlideReqObj = new FormFieldRequirement('slide_url', Labels::getLabel('FRM_URL', $this->siteLangId));
            $urlSlideReqObj->setRequired(true);

            $frm->addTextBox(Labels::getLabel('FRM_CPC', $this->siteLangId) . '[' . commonHelper::getDefaultCurrencySymbol() . ']', 'promotion_slides_cpc', FatApp::getConfig('CONF_CPC_SLIDES', FatUtility::VAR_FLOAT, 0), array(
                'readonly' => true
            ));

            /* $frm->addSelectBox(Labels::getLabel('FRM_OPEN_IN',$this->siteLangId), 'slide_target', $linkTargetsArr, '',array(),'');     */
            /* ] */

            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SHOP, 'eq', 'banner_url', $urlUnReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_PRODUCT, 'eq', 'banner_url', $urlUnReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_BANNER, 'eq', 'banner_url', $urlReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SLIDES, 'eq', 'banner_url', $urlUnReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_BANNER, 'eq', 'promotion_record_id', $prodUnReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SHOP, 'eq', 'promotion_record_id', $prodUnReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_PRODUCT, 'eq', 'promotion_record_id', $prodReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SLIDES, 'eq', 'promotion_record_id', $prodUnReqObj);

            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_BANNER, 'eq', 'promotion_shop', $shopUnReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SHOP, 'eq', 'promotion_shop', $shopReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_PRODUCT, 'eq', 'promotion_shop', $shopUnReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SLIDES, 'eq', 'promotion_shop', $shopUnReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SHOP, 'eq', 'slide_url', $urlSlideUnReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_PRODUCT, 'eq', 'slide_url', $urlSlideUnReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_BANNER, 'eq', 'slide_url', $urlSlideUnReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SLIDES, 'eq', 'slide_url', $urlSlideReqObj);
        } else {
            /* $frm->addHiddenField('','promotion_type',Promotion::TYPE_BANNER);
              $frm->addTextBox(Labels::getLabel('FRM_URL',$this->siteLangId), 'banner_url')->requirements()->setRequired(true); */

            /* Banner Url [ */
            $frm->addTextBox(Labels::getLabel('FRM_URL', $this->siteLangId), 'banner_url')->requirements()->setRequired(true);
            $urlUnReqObj = new FormFieldRequirement('banner_url', Labels::getLabel('FRM_URL', $this->siteLangId));
            $urlUnReqObj->setRequired(false);

            $urlReqObj = new FormFieldRequirement('banner_url', Labels::getLabel('FRM_URL', $this->siteLangId));
            $urlReqObj->setRequired(true);
            /* ] */

            /* Slide Url [ */
            $frm->addTextBox(Labels::getLabel('FRM_URL', $this->siteLangId), 'slide_url')->requirements()->setRequired(true);
            $urlSlideUnReqObj = new FormFieldRequirement('slide_url', Labels::getLabel('FRM_URL', $this->siteLangId));
            $urlSlideUnReqObj->setRequired(false);

            $urlSlideReqObj = new FormFieldRequirement('slide_url', Labels::getLabel('FRM_URL', $this->siteLangId));
            $urlSlideReqObj->setRequired(true);

            $frm->addTextBox(Labels::getLabel('FRM_CPC' . '_[' . commonHelper::getDefaultCurrencySymbol() . ']', $this->siteLangId), 'promotion_slides_cpc', FatApp::getConfig('CONF_CPC_SLIDES', FatUtility::VAR_FLOAT, 0), array(
                'readonly' => true
            ));

            /* $frm->addSelectBox(Labels::getLabel('FRM_OPEN_IN',$this->siteLangId), 'slide_target', $linkTargetsArr, '',array(),''); */
            /* ] */

            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_BANNER, 'eq', 'banner_url', $urlReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SLIDES, 'eq', 'banner_url', $urlUnReqObj);

            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_BANNER, 'eq', 'slide_url', $urlSlideUnReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SLIDES, 'eq', 'slide_url', $urlSlideReqObj);
        }

        //$frm->addTextBox(Labels::getLabel('FRM_URL',$this->siteLangId), 'banner_url')->requirements()->setRequired(true);


        /* $frm->addSelectBox(Labels::getLabel('FRM_OPEN_IN',$this->siteLangId), 'banner_target', $linkTargetsArr, '',array(),'');
         */

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

        $fld = $frm->addTextBox(Labels::getLabel('FRM_BUDGET' . '_[' . commonHelper::getDefaultCurrencySymbol() . ']', $this->siteLangId), 'promotion_budget');
        $fld->requirements()->setRequired();
        $fld->requirements()->setFloatPositive(true);

        $frm->addSelectBox(Labels::getLabel('FRM_LAYOUT_TYPE', $this->siteLangId), 'banner_blocation_id', $locationArr, '', array(), Labels::getLabel('FRM_SELECT', $this->siteLangId))->requirements()->setRequired(true);
        $locIdFldUnReqObj = new FormFieldRequirement('banner_blocation_id', Labels::getLabel('FRM_LAYOUT_TYPE', $this->siteLangId));
        $locIdFldUnReqObj->setRequired(false);

        $locIdFldReqObj = new FormFieldRequirement('banner_blocation_id', Labels::getLabel('FRM_LAYOUT_TYPE', $this->siteLangId));
        $locIdFldReqObj->setRequired(true);

        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_BANNER, 'eq', 'banner_blocation_id', $locIdFldReqObj);
        $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SLIDES, 'eq', 'banner_blocation_id', $locIdFldUnReqObj);

        if (User::isSeller()) {
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_SHOP, 'eq', 'banner_blocation_id', $locIdFldUnReqObj);
            $pTypeFld->requirements()->addOnChangerequirementUpdate(Promotion::TYPE_PRODUCT, 'eq', 'banner_blocation_id', $locIdFldUnReqObj);
        }


        $frm->addSelectBox(Labels::getLabel('FRM_BUDGET_DURATION_FOR', $this->siteLangId), 'promotion_duration', Promotion::getPromotionBudgetDurationArr($this->siteLangId), '', array(
            'id' => 'promotion_duration'
        ), Labels::getLabel('FRM_SELECT', $this->siteLangId))->requirements()->setRequired();

        $frm->addDateField(Labels::getLabel('FRM_START_DATE', $this->siteLangId), 'promotion_start_date', '', array(
            'placeholder' => Labels::getLabel('FRM_DATE_FROM', $this->siteLangId),
            'readonly' => 'readonly'
        ))->requirements()->setRequired();
        $frm->addDateField(Labels::getLabel('FRM_END_DATE', $this->siteLangId), 'promotion_end_date', '', array(
            'placeholder' => Labels::getLabel('FRM_DATE_TO', $this->siteLangId),
            'readonly' => 'readonly'
        ))->requirements()->setRequired();

        $fld = $frm->addRequiredField(Labels::getLabel('FRM_PROMOTION_START_TIME', $this->siteLangId), 'promotion_start_time', '', array(
            'class' => 'time',
            'readonly' => 'readonly'
        ));
        $fld = $frm->addRequiredField(Labels::getLabel('FRM_PROMOTION_END_TIME', $this->siteLangId), 'promotion_end_time', '', array(
            'class' => 'time',
            'readonly' => 'readonly'
        ));

        $frm->addCheckBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'promotion_active', applicationConstants::ACTIVE, array(), true, applicationConstants::INACTIVE);

        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }

    private function getPromotionLangForm($promotionId, $langId)
    {
        $frm = new Form('frmPromotionLang');
        $frm->addHiddenField('', 'promotion_id', $promotionId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_PROMOTION_NAME', $langId), 'promotion_name');

        return $frm;
    }

    public function imgCropper()
    {
        $this->_template->render(false, false, 'cropper/index.php');
    }

    private function getPromotionMediaForm($promotionId = 0, $promotionType = 0, $layoutType = 0)
    {
        $promotionId = FatUtility::int($promotionId);
        $frm = new Form('frmPromotionMedia');

        $frm->addHiddenField('', 'promotion_id', $promotionId);
        $frm->addHiddenField('', 'promotion_type', $promotionType);

        $bannerTypeArr = applicationConstants::getAllLanguages();
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', $bannerTypeArr, '', array(), '');

        if ($layoutType == Collections::TYPE_BANNER_LAYOUT2 || empty($layoutType)) {
            $frm->addHiddenField('', 'banner_screen', applicationConstants::SCREEN_DESKTOP);
        } else {
            $screenArr = applicationConstants::getDisplaysArr($this->siteLangId);
            $frm->addSelectBox(Labels::getLabel("FRM_DISPLAY_FOR", $this->siteLangId), 'banner_screen', $screenArr, '', array(), '');
        }

        $frm->addHiddenField('', 'banner_min_width');
        $frm->addHiddenField('', 'banner_min_height');
        $frm->addHTML('', 'banner_html', '');
        return $frm;
    }

    private function getPromotionSearchForm($langId)
    {
        $langId = FatUtility::int($langId);

        $frm = new Form('frmPromotionSearch');
        $frm->addTextBox('', 'keyword', '', array(
            'placeholder' => Labels::getLabel('FRM_KEYWORD', $langId)
        ));

        $typeArr = Promotion::getTypeArr($langId);
        if (!User::isSeller()) {
            unset($typeArr[Promotion::TYPE_SHOP]);
            unset($typeArr[Promotion::TYPE_PRODUCT]);
        }
        $frm->addSelectBox(Labels::getLabel('FRM_PROMOTION_STATUS'), 'active_promotion', array(
            '-1' => Labels::getLabel('FRM_ALL', $langId),
            '1' => Labels::getLabel('FRM_RUNNING_/_SCHEDULED', $langId)
        ), '', array(), '');
        $frm->addSelectBox(Labels::getLabel('FRM_TYPE'), 'type', array(
            '-1' => Labels::getLabel('FRM_ALL_TYPE', $langId)
        ) + $typeArr, '', array(), '');

        $frm->addDateField(Labels::getLabel('FRM_DATE_FROM'), 'date_from', '', array(
            'readonly' => 'readonly',
            'class' => 'field--calender',
            'placeholder' => Labels::getLabel('FRM_DATE_FROM', $langId)
        ));
        $frm->addDateField(Labels::getLabel('FRM_DATE_TO'), 'date_to', '', array(
            'readonly' => 'readonly',
            'class' => 'field--calender',
            'placeholder' => Labels::getLabel('FRM_DATE_TO', $langId)
        ));

        $frm->addHiddenField('', 'total_record_count', '');
        /* $fldSubmit->attachField($fldClear); */
        $frm->addHiddenField('', 'page');

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm, 'btn btn-clear');
        return $frm;
    }

    private function getPPCAnalyticsSearchForm($langId)
    {
        $langId = FatUtility::int($langId);

        $frm = new Form('frmRecordSearch');

        $frm->addDateField('', 'date_from', '', array(
            'readonly' => 'readonly',
            'class' => 'field--calender',
            'placeholder' => Labels::getLabel('FRM_DATE_FROM', $langId)
        ));
        $frm->addDateField('', 'date_to', '', array(
            'readonly' => 'readonly',
            'class' => 'field--calender',
            'placeholder' => Labels::getLabel('FRM_DATE_TO', $langId)
        ));

        /* $fldSubmit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEARCH', $langId));
        $fldClear = $frm->addButton("", "btn_clear", Labels::getLabel("FRM_CLEAR", $langId), array(
            'onclick' => 'clearPromotionSearch();'
        )); */
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm, 'btn btn-clear');

        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'promotion_id');
        return $frm;
    }

    private function getRechargeWalletForm($langId)
    {
        $frm = new Form('frmRechargeWallet');
        $fld = $frm->addFloatField('', 'amount');
        //$fld->requirements()->setRequired();
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_ADD_MONEY_TO_WALLET', $langId));
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
            FatUtility::dieJsonError(Labels::getLabel("ERR_BUDGET_SHOULD_BE_GREATER_THAN_CPC", $this->siteLangId));
        }
        FatUtility::dieJsonSuccess(Message::getHtml());
    }

    public function getBannerLocationDimensions($promotionId, $deviceType)
    {
        $srch = new PromotionSearch($this->siteLangId);
        $srch->joinBannersAndLocation($this->siteLangId, Promotion::TYPE_BANNER, 'b', $deviceType);
        $srch->addCondition('promotion_id', '=', $promotionId);
        $srch->addMultipleFields(array(
            'blocation_banner_width',
            'blocation_banner_height'
        ));
        $rs = $srch->getResultSet();
        $bannerDimensions = FatApp::getDb()->fetch($rs);
        $this->set('bannerWidth', $bannerDimensions['blocation_banner_width']);
        $this->set('bannerHeight', $bannerDimensions['blocation_banner_height']);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function changePromotionStatus()
    {
        $this->userPrivilege->canEditPromotions();
        $promotionId = FatApp::getPostedData('promotionId', FatUtility::VAR_INT, 0);
        $userId = $this->userParentId;

        $promotionData = Promotion::getAttributesById($promotionId, array('promotion_user_id', 'promotion_active'));
        if (!$promotionData || ($promotionData && $promotionData['promotion_user_id'] != $userId)) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $status = ($promotionData['promotion_active'] == applicationConstants::ACTIVE) ? applicationConstants::INACTIVE : applicationConstants::ACTIVE;

        $this->updatePromotionStatus($promotionId, $status);

        $this->set('msg', Labels::getLabel('MSG_Status_changed_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updatePromotionStatus($promotionId, $status)
    {
        $this->userPrivilege->canEditPromotions();
        $promotionId = FatUtility::int($promotionId);
        $status = FatUtility::int($status);
        if (1 > $promotionId || -1 == $status) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }
        $promotion = new Promotion($promotionId);
        if (!$promotion->changeStatus($status)) {
            Message::addErrorMessage($promotion->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
    }

    public function getBreadcrumbNodes($action)
    {
        if (FatUtility::isAjaxCall()) {
            return;
        }

        $className = get_class($this);
        $arr = explode('-', FatUtility::camel2dashed($className));
        array_pop($arr);
        $className = ucwords(implode(' ', $arr));

        if ($action == 'analytics') {
            $action = str_replace('-', ' ', FatUtility::camel2dashed($action));
            $this->nodes[] = array('title' => Labels::getLabel('LBL_PROMOTIONS'), 'href' => UrlHelper::generateUrl("Advertiser", "promotions"));
            $this->nodes[] = array('title' => ucwords($action));
        } else {
            $action = str_replace('-', ' ', FatUtility::camel2dashed($action));
            $title = CommonHelper::replaceStringData(Labels::getLabel('LBL_{ACTION}', $this->siteLangId), ['{ACTION}' => ucwords($action)]);
            $this->nodes[] = array('title' => ucwords($title));
        }
        return $this->nodes;
    }
}
