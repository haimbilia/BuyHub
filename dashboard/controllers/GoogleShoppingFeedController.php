<?php

require_once CONF_INSTALLATION_PATH . 'vendor/autoload.php';

class GoogleShoppingFeedController extends AdvertisementFeedBaseController
{
    public const KEY_NAME = 'GoogleShoppingFeed';
    public const SCOPE = 'https://www.googleapis.com/auth/content';

    private $client;
    private $googleShoppingFeed;
    private $accessToken;
    private $adsBatchId;
    private $recordData = [];
    private $batchRow = [];

    /**
     * __construct
     *
     * @param  mixed $action
     * @return void
     */
    public function __construct(string $action)
    {
        parent::__construct($action);
        $this->init();
        $this->userPrivilege->canViewAdvertisementFeed(UserAuthentication::getLoggedUserId());
        if (!UserPrivilege::isUserHasValidSubsription($this->userParentId)) {
            Message::addInfo(Labels::getLabel("MSG_Please_buy_subscription", $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'Packages'));
        }
    }

    /**
     * init
     *
     * @return void
     */
    private function init()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $this->googleShoppingFeed = LibHelper::callPlugin(self::KEY_NAME, [$this->siteLangId, $userId], $error, $this->siteLangId);
        if (false === $this->googleShoppingFeed) {
            $this->setError($error, 'Seller');
        }

        if (false === $this->googleShoppingFeed->validateSettings($this->siteLangId)) {
            $this->setError('', 'Seller');
        }

        $this->settings = $this->googleShoppingFeed->getSettings();
        if (empty($this->settings)) {
            $this->setError('', 'Seller');
        }
    }

    /**
     * setError
     *
     * @param  string $msg
     * @param  string $controller
     * @param  string $action
     * @return void
     */
    private function setError(string $msg = '', string $controller = '', string $action = '')
    {
        $msg = !empty($msg) ? $msg : $this->googleShoppingFeed->getError();
        LibHelper::exitWithError($msg, false, true);
        $this->redirectBack($controller, $action);
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $this->set('userData', $this->getUserMeta());
        $this->set('keyName', self::KEY_NAME);
        $this->set('pluginName', $this->settings['plugin_name']);

        $frm = $this->getSearchForm($this->siteLangId);
        $this->set('frmSearch', $frm);
        $this->set('keywordPlaceholder', Labels::getLabel('LBL_SEARCH_BY_BATCH_NAME', $this->siteLangId));
        $this->_template->render();
    }

    /**
     * getSearchForm
     *
     * @param  int $langId
     * @return object
     */
    private function getSearchForm(int $langId): Form
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page', 1);
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');
        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    /**
     * setupConfiguration
     *
     * @return void
     */
    private function setupConfiguration(): void
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName(FatApp::getConfig('CONF_WEBSITE_NAME_' . $this->siteLangId)); // Set your application name
        $this->client->setScopes(self::SCOPE);
        $this->client->setClientId($this->settings['client_id']);
        $this->client->setClientSecret($this->settings['client_secret']);
        $this->client->setRedirectUri(UrlHelper::generateFullUrl(static::KEY_NAME, 'getAccessToken', [], '', false));
        $this->client->setDeveloperKey($this->settings['developer_key']);
        $this->client->setAccessType('offline');
        $this->client->setApprovalPrompt('force');
    }

    /**
     * getAccessToken
     *
     * @return void
     */
    public function getAccessToken()
    {
        $this->setupConfiguration();

        $get = FatApp::getQueryStringData();
        if (isset($get['code'])) {
            $this->client->authenticate($get['code']);
            $this->accessToken = $this->client->getAccessToken();
            if (!empty($this->accessToken)) {
                $this->setupMerchantDetail();
            }
            $this->redirectBack();
        }
        $authUrl = $this->client->createAuthUrl();
        FatApp::redirectUser($authUrl);
    }

    /**
     * setupMerchantDetail
     *
     * @return void
     */
    private function setupMerchantDetail()
    {
        $this->userPrivilege->canEditAdvertisementFeed();
        $this->client->setAccessToken($this->accessToken);
        $service = new Google_Service_ShoppingContent($this->client);
        $authDetail = $service->accounts->authinfo();
        $accountDetail = $authDetail->accountIdentifiers;
        if (empty($accountDetail)) {
            $msg = Labels::getLabel("MSG_MERCHANT_ACCOUNT_DETAIL_NOT_FOUND", $this->siteLangId);
            $this->setError($msg, 'Seller');
        }
        $accountDetail = array_shift($accountDetail);
        $merchantId = $accountDetail->merchantId;
        $aggregatorId = $accountDetail->aggregatorId;
        if (!empty($aggregatorId)) {
            $this->updateMerchantInfo([self::KEY_NAME . '_aggregatorId' => $aggregatorId]);
        }

        if (!empty($merchantId)) {
            $this->updateMerchantInfo([self::KEY_NAME . '_merchantId' => $merchantId]);
        }
    }

    /**
     * getServiceAccountForm
     *
     * @return object
     */
    private function getServiceAccountForm(): object
    {
        $frm = new Form('frmServiceAccount');
        $privateKey = $frm->addTextArea(Labels::getLabel('FRM_SERVICE_ACCOUNT_DETAIL', $this->siteLangId), 'service_account');
        $privateKey->requirements()->setRequired();
        $frm->addHTML('', 'plugin_description', $this->settings['plugin_description']);
        return $frm;
    }

    /**
     * serviceAccountForm
     *
     * @return void
     */
    public function serviceAccountForm()
    {
        $this->userPrivilege->canEditAdvertisementFeed();
        $data = $this->getUserMeta();
        $frm = $this->getServiceAccountForm();
        if (!empty($data) && 0 < count($data)) {
            $frm->fill($data);
        }
        $this->set('frm', $frm);
        $this->set('keyName', self::KEY_NAME);
        $this->_template->render(false, false);
    }

    /**
     * setupServiceAccountForm
     *
     * @return void
     */
    public function setupServiceAccountForm()
    {
        $this->userPrivilege->canEditAdvertisementFeed();
        $frm = $this->getServiceAccountForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['btn_submit']);
        $this->updateMerchantInfo($post, false);
    }

    /**
     * validateBatchRequest
     *
     * @return void
     */
    private function validateBatchRequest()
    {
        $recordData = AdsBatch::getBatchesByUserId(UserAuthentication::getLoggedUserId(), $this->adsBatchId);

        if (1 > $this->adsBatchId || empty($recordData)) {
            $this->error = Labels::getLabel("ERR_INVALID_REQUEST", $this->siteLangId);
            return false;
        }

        $this->batchRow = current($recordData);
        return true;
    }

    /**
     * getBatchForm
     *
     * @return object
     */
    private function getBatchForm(int $langId): object
    {
        $frm = new Form('frmAdsBatch');
        $frm->addHiddenField('', 'adsbatch_id');
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'adsbatch_lang_id', Language::getAllNames(), $langId, [], '');
        $fld->requirement->setRequired(true);
        $frm->addRequiredField(Labels::getLabel('FRM_BATCH_NAME', $langId), 'adsbatch_name');
        $countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesAssocArr($langId);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_TARGET_COUNTRY', $langId), 'adsbatch_target_country_id', $countriesArr, '', []);
        $fld->requirement->setRequired(true);

        $frm->addDateField(Labels::getLabel('FRM_EXPIRY_DATE', $langId), 'adsbatch_expired_on', '', array('readonly' => 'readonly'));
        return $frm;
    }

    /**
     * getBindProductForm
     *
     * @return object
     */
    private function getBindProductForm(): object
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', 'abprod_adsbatch_id');
        $frm->addHiddenField('', 'is_edit', 0);

        $selectedProduct = [];
        $selectedProductCategory = [];
        if (!empty($this->recordData)) {
            $selectedProduct[$this->recordData['abprod_selprod_id']] = $this->recordData['selprod_title'];
            $selectedProductCategory[$this->recordData['abprod_cat_id']] = $this->recordData['abprod_cat_name'];
        }

        $fld = $frm->addSelectBox(Labels::getLabel('FRM_PRODUCT', $this->siteLangId), 'abprod_selprod_id', $selectedProduct, key($selectedProduct), ['placeholder' => Labels::getLabel('FRM_SEARCH_PRODUCT', $this->siteLangId)]);
        $fld->requirement->setRequired(true);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_GOOGLE_PRODUCT_CATEGORY', $this->siteLangId), 'abprod_cat_id', $selectedProductCategory, key($selectedProductCategory), ['placeholder' => Labels::getLabel('FRM_SEARCH_GOOGLE_PRODUCT_CATEGORY', $this->siteLangId)]);
        $fld->requirement->setRequired(true);

        $fld = $frm->addSelectBox(Labels::getLabel('FRM_AGE_GROUP', $this->siteLangId), 'abprod_age_group', (self::KEY_NAME)::ageGroup($this->siteLangId));
        $fld->requirement->setRequired(true);
        return $frm;
    }

    /**
     * batchForm
     *
     * @param  int $adsBatchId
     * @return void
     */
    public function batchForm(int $adsBatchId = 0, int $langId = 0)
    {
        $langId = 1 > $langId ? $this->siteLangId : $langId;
        $this->userPrivilege->canEditAdvertisementFeed();
        $prodBatchAdsFrm = $this->getBatchForm($langId);

        if (0 < $adsBatchId) {
            $data = AdsBatch::getAttributesById($adsBatchId);
            if ($data === false) {
                LibHelper::dieJsonError($this->str_invalid_request);
            }
            $data['adsbatch_lang_id'] = $langId;
            $prodBatchAdsFrm->fill($data);
        }

        $this->set('frm', $prodBatchAdsFrm);
        $this->set('langId', $langId);
        $this->set('adsBatchId', $adsBatchId);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->_template->render(false, false);
    }

    /**
     * getProductsSearchForm
     *
     * @param  int $langId
     * @return object
     */
    private function getProductsSearchForm(int $langId): Form
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page', 1);
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');
        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    /**
     * bindProducts
     *
     * @param  int $adsBatchId
     * @return void
     */
    public function bindProducts(int $adsBatchId)
    {
        $this->userPrivilege->canEditAdvertisementFeed();
        if (1 > $adsBatchId) {
            $this->setError(Labels::getLabel('LBL_INVALID_REQUEST'), LibHelper::getControllerName());
        }

        $this->set('adsBatchId', $adsBatchId);
        $this->set('frmSearch', $this->getProductsSearchForm($this->siteLangId));
        $this->set('keywordPlaceholder', Labels::getLabel('LBL_SEARCH_BY_PRODUCT_NAME', $this->siteLangId));
        $this->_template->addJs(['js/select2.js']);
        $this->_template->addCss(['css/select2.min.css']);
        $this->_template->render();
    }

    /**
     * viewProducts
     *
     * @param  int $adsBatchId
     * @return void
     */
    public function viewProducts(int $adsBatchId)
    {
        $this->userPrivilege->canEditAdvertisementFeed();
        $adsBatchId = FatUtility::int($adsBatchId);
        $this->set('adsBatchId', $adsBatchId);
        $this->set('bindProductForm', false);
        $this->_template->render(true, true, 'google-shopping-feed/bind-products.php');
    }

    /**
     * bindProductForm
     *
     * @param  int $adsBatchId
     * @param  int $selProdId
     * @return void
     */
    public function bindProductForm(int $adsBatchId, int $selProdId = 0)
    {
        $this->userPrivilege->canEditAdvertisementFeed();
        $this->adsBatchId = $adsBatchId;
        if (false === $this->validateBatchRequest()) {
            $this->setError($this->error, 'Seller');
        }

        $data = ['abprod_adsbatch_id' => $this->adsBatchId];
        if (1 < $selProdId) {
            $attr = [
                'abprod_adsbatch_id',
                'abprod_selprod_id',
                'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title',
                'abprod_cat_id',
                'abprod_age_group'
            ];

            $srch = $this->getBatchProductsObj();
            $srch->addCondition(AdsBatch::DB_TBL_BATCH_PRODS_PREFIX . 'selprod_id', '=', $selProdId);
            $srch->addMultipleFields($attr);
            $this->recordData = FatApp::getDb()->fetch($srch->getResultSet());
            if (!empty($this->recordData)) {
                $catIdArr = $this->getProductCategory(true);
                $this->recordData['abprod_cat_name'] = html_entity_decode($catIdArr[$this->recordData['abprod_cat_id']], ENT_QUOTES, 'UTF-8');

                $options = SellerProduct::getSellerProductOptions($this->recordData['abprod_selprod_id'], true, $this->siteLangId);
                $variantsStr = '';
                array_walk($options, function ($item, $key) use (&$variantsStr) {
                    $variantsStr .= ' | ' . $item['option_name'] . ' : ' . $item['optionvalue_name'];
                });
                $this->recordData['selprod_title'] .= $variantsStr;
            }

            $this->recordData['is_edit'] = 1;
            $data = $this->recordData;
        }
        $frm = $this->getBindProductForm();
        $frm->fill($data);
        $this->set('frm', $frm);
        $this->set('selProdId', $selProdId);
        $this->set('adsBatchId', $adsBatchId);
        $this->_template->render(false, false);
    }

    /**
     * setupBatch
     *
     * @return void
     */
    public function setupBatch()
    {
        $this->userPrivilege->canEditAdvertisementFeed();
        $frm = $this->getBatchForm($this->siteLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::dieJsonError(current($frm->getValidationErrors()));
        }

        $expiredOn = FatApp::getPostedData('adsbatch_expired_on', FatUtility::VAR_STRING, '');
        if (!empty($expiredOn) && strtotime($expiredOn) < strtotime(date("Y-m-d"))) {
            LibHelper::dieJsonError(Labels::getLabel('ERR_EXPIRE_DATE_MUST_BE_GREATER_THAN_TODAY_OR_BLANK', $this->siteLangId));
        }

        $this->adsBatchId = $post['adsbatch_id'];
        if (0 < $this->adsBatchId) {
            if (false === $this->validateBatchRequest()) {
                LibHelper::dieJsonError($this->error);
            }
        }
        unset($post['adsbatch_id']);
        $post['adsbatch_user_id'] = UserAuthentication::getLoggedUserId();
        $adsBatchObj = new AdsBatch($this->adsBatchId);
        $adsBatchObj->assignValues($post);

        if (!$adsBatchObj->save()) {
            LibHelper::dieJsonError($adsBatchObj->getError());
        }

        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_ADS_BATCH_SETUP_SUCCESSFULLY', $this->siteLangId));
    }

    /**
     * setupProductsToBatch
     *
     * @return void
     */
    public function setupProductsToBatch()
    {
        $this->userPrivilege->canEditAdvertisementFeed();
        $frm = $this->getBindProductForm();
        $post = FatApp::getPostedData();
        $postedData = $frm->getFormDataFromArray($post);

        if (false === $postedData) {
            LibHelper::dieJsonError(current($frm->getValidationErrors()));
        }
        $isEdit = FatApp::getPostedData('is_edit', FatUtility::VAR_INT, 0);

        $adsBatchId = FatApp::getPostedData('abprod_adsbatch_id', FatUtility::VAR_INT, 0);
        if (1 > $adsBatchId) {
            LibHelper::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }

        $adsBatchData = (array)AdsBatch::getAttributesById($adsBatchId, ['adsbatch_user_id', 'adsbatch_status']);
        if (empty($adsBatchData) || $adsBatchData['adsbatch_user_id'] != UserAuthentication::getLoggedUserId()) {
            LibHelper::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }

        $adsBatchObj = AdsBatch::getSearchObject(true);
        $adsBatchObj->addCondition('abprod_selprod_id', '=', $post['abprod_selprod_id']);
        $adsBatchObj->addCondition('abprod_adsbatch_id', '=', $post['abprod_adsbatch_id']);
        $record = (array) FatApp::getDb()->fetch($adsBatchObj->getResultSet());
        if (!empty($record) && 1 > $isEdit) {
            LibHelper::dieJsonError(Labels::getLabel('ERR_ALREADY_BOUND', $this->siteLangId));
        }

        $productId = SellerProduct::getAttributesById($post['abprod_selprod_id'], 'selprod_product_id');
        $productIdentifier = strtoupper(Product::getAttributesById($productId, 'product_identifier'));
        $productIdentifier = explode(' ', $productIdentifier);
        $post['abprod_item_group_identifier'] = $productIdentifier[0] . $productId;

        unset($post['is_edit'], $post['fOutMode'], $post['fIsAjax']);
        $db = FatApp::getDb();
        if (!$db->insertFromArray(AdsBatch::DB_TBL_BATCH_PRODS, $post, false, array(), $post)) {
            LibHelper::dieJsonError($db->getError());
        }

        if (AdsBatch::STATUS_PUBLISHED == $adsBatchData['adsbatch_status']) {
            $adsBatchObj = new AdsBatch($adsBatchId);
            $adsBatchObj->assignValues(['adsbatch_status' => AdsBatch::STATUS_PARTIALLY_PENDING]);

            if (!$adsBatchObj->save()) {
                LibHelper::dieJsonError($adsBatchObj->getError());
            }
        }

        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_ADS_BATCH_SETUP_SUCCESSFULLY', $this->siteLangId));
    }

    /**
     * search
     *
     * @return void
     */
    public function search()
    {
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $pagesize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);

        $srch = AdsBatch::getSearchObject();
        $attr = [
            'adsbatch_id',
            'adsbatch_name',
            'adsbatch_lang_id',
            'adsbatch_target_country_id',
            'adsbatch_expired_on',
            'adsbatch_synced_on',
            'adsbatch_status',
        ];
        $srch->addMultipleFields($attr);
        $srch->addCondition(AdsBatch::DB_TBL_PREFIX . 'user_id', '=', UserAuthentication::getLoggedUserId());
        $srch->addCondition(AdsBatch::DB_TBL_PREFIX . 'status', '!=', AdsBatch::STATUS_DELETED);

        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        if ('' !== $keyword) {
            $srch->addCondition(AdsBatch::DB_TBL_PREFIX . 'name', 'LIKE', '%' . $keyword . '%');
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $arrListing = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set("arrListing", $arrListing);

        $this->set('keyName', self::KEY_NAME);
        $this->set('page', $page);
        $this->set('pageCount', $srch->pages());
        $this->set('postedData', FatApp::getPostedData());
        $this->set('recordCount', $srch->recordCount());
        $this->set('pageSize', FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10));
        $this->set('canEdit', $this->userPrivilege->canEditAdvertisementFeed(0, true));
        $this->set('canView', $this->userPrivilege->canViewAdvertisementFeed(0, true));
        $this->set('merchantId', $this->getUserMeta(self::KEY_NAME . '_merchantId'));
        $this->_template->render(false, false);
    }

    /**
     * deleteBatch
     *
     * @param  int $adsBatchId
     * @return void
     */
    public function deleteBatch(int $adsBatchId)
    {
        $this->userPrivilege->canEditAdvertisementFeed();
        $this->adsBatchId = $adsBatchId;
        if (false === $this->validateBatchRequest()) {
            LibHelper::dieJsonError($this->error);
        }

        $adsBatchObj = new AdsBatch($this->adsBatchId);
        $adsBatchObj->assignValues(['adsbatch_status' => AdsBatch::STATUS_DELETED]);

        if (!$adsBatchObj->save()) {
            LibHelper::dieJsonError($adsBatchObj->getError());
        }

        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_SUCCESSFULLY_DELETED', $this->siteLangId));
    }

    /**
     * getBatchProductsObj
     *
     * @return object
     */
    private function getBatchProductsObj(): object
    {
        $srch = AdsBatch::getSearchObject(true);
        $srch->addCondition(AdsBatch::DB_TBL_BATCH_PRODS_PREFIX . 'adsbatch_id', '=', $this->adsBatchId);
        $srch->addCondition(AdsBatch::DB_TBL_PREFIX . 'user_id', '=', UserAuthentication::getLoggedUserId());
        return $srch;
    }

    /**
     * searchProducts
     *
     * @param  int $adsBatchId
     * @return void
     */
    public function searchProducts(int $adsBatchId)
    {
        $this->adsBatchId = $adsBatchId;
        if (1 > $this->adsBatchId) {
            LibHelper::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        $pagesize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);

        $attr = [
            'abprod_adsbatch_id',
            'abprod_selprod_id',
            'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title',
            'product_identifier',
            'adsbatch_name',
            'abprod_cat_id',
            'abprod_age_group',
            'abprod_item_group_identifier',
        ];

        $srch = $this->getBatchProductsObj();
        $srch->addMultipleFields($attr);

        if (!empty($keyword)) {
            $cnd = $srch->addCondition('selprod_title', 'LIKE', '%' . $keyword . '%');
            $cnd->attachCondition('product_name', 'LIKE', '%' . $keyword . '%');
            $cnd->attachCondition('product_identifier', 'LIKE', '%' . $keyword . '%');
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $db = FatApp::getDb();
        $rs = $srch->getResultSet();
        $arrListing = $db->fetchAll($rs);
        $this->set("arrListing", $arrListing);

        $status = (int) AdsBatch::getAttributesById($adsBatchId, 'adsbatch_status');
        $this->set('isPublished', (AdsBatch::STATUS_PUBLISHED == $status));
        $this->set('page', $page);
        $this->set('pageCount', $srch->pages());
        $this->set('postedData', FatApp::getPostedData());
        $this->set('recordCount', $srch->recordCount());
        $this->set('pageSize', FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10));
        $this->set('catIdArr', $this->getProductCategory(true));
        $this->_template->render(false, false);
    }

    /**
     * unlinkProduct
     *
     * @param  int $adsBatchId
     * @param  int $selProdId
     * @param  bool $return
     * @return void
     */
    public function unlinkProduct(int $adsBatchId, int $selProdId, bool $return = false)
    {
        $this->userPrivilege->canEditAdvertisementFeed();
        $this->adsBatchId = $adsBatchId;
        if (false === $this->validateBatchRequest()) {
            LibHelper::dieJsonError($this->error);
        }

        $db = FatApp::getDb();
        if (!$db->deleteRecords(AdsBatch::DB_TBL_BATCH_PRODS, ['smt' => 'abprod_adsbatch_id = ? AND abprod_selprod_id = ?', 'vals' => [$this->adsBatchId, $selProdId]])) {
            LibHelper::dieJsonError($db->getError());
        }

        if (true == $return) {
            return true;
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_SUCCESSFULLY_DELETED', $this->siteLangId));
    }

    /**
     * unlinkProducts
     *
     * @param  mixed $adsBatchId
     * @return void
     */
    public function unlinkProducts(int $adsBatchId)
    {
        $this->userPrivilege->canEditAdvertisementFeed();
        $adsBatchId = FatUtility::int($adsBatchId);
        $sellerProducts = FatApp::getPostedData('selprod_ids');
        if (1 > $adsBatchId || !is_array($sellerProducts) || 1 > count($sellerProducts)) {
            LibHelper::dieJsonError(Labels::getLabel("ERR_INVALID_REQUEST", $this->siteLangId));
        }

        foreach ($sellerProducts as $selProdId) {
            $this->unlinkProduct($adsBatchId, $selProdId, true);
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_SUCCESSFULLY_DELETED', $this->siteLangId));
    }

    /**
     * getProductCategory
     *
     * @param  bool $returnFullArray
     * @return void
     */
    public function getProductCategory(bool $returnFullArray = false)
    {
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        $data = $this->googleShoppingFeed->getProductCategory($keyword, $returnFullArray);
        if (true === $returnFullArray) {
            return $data;
        }
        CommonHelper::jsonEncodeUnicode($data, true);
    }

    /**
     * getProductCategoryAutocomplete
     *
     * @return void
     */
    public function getProductCategoryAutocomplete()
    {
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        $data = $this->googleShoppingFeed->getProductCategoryAutocomplete($keyword);
        CommonHelper::jsonEncodeUnicode($data, true);
    }

    /**
     * publishBatch
     *
     * @param  int $adsBatchId
     * @return void
     */
    public function publishBatch(int $adsBatchId, int $download = 0)
    {
        $this->userPrivilege->canEditAdvertisementFeed();

        if (empty($this->getUserMeta(self::KEY_NAME . '_merchantId'))) {
            LibHelper::dieJsonError(Labels::getLabel('ERR_YOUR_ACCOUNT_IS_NOT_COMPLETLY_CONFIGURED', $this->siteLangId));
        }

        $this->adsBatchId = $adsBatchId;
        if (false === $this->validateBatchRequest()) {
            LibHelper::dieJsonError($this->error);
        }
        // after max days
        $strToTime = strtotime("+" . $this->googleShoppingFeed->getMaxPublishDays() . " days");

        if ($this->batchRow['adsbatch_expired_on'] == '0000-00-00 00:00:00') {
            $expireOn = date('Y-m-d', $strToTime);
        } elseif (strtotime($this->batchRow['adsbatch_expired_on']) < strtotime(date("Y-m-d H:i:s"))) {
            LibHelper::dieJsonError(Labels::getLabel('ERR_CANNOT_PUBLISH_AS_EXPIRE_DATE_ALREADY_PASSED', $this->siteLangId));
        } elseif ($strToTime >  strtotime($this->batchRow['adsbatch_expired_on'])) {
            $expireOn = date("Y-m-d", strtotime($this->batchRow['adsbatch_expired_on']));
        } else {
            $expireOn = date("Y-m-d", $strToTime);
        }

        $adsBatchobj = new AdsBatch($this->adsBatchId);
        $productData = $adsBatchobj->getBatchDataForFeed(UserAuthentication::getLoggedUserId(), $this->batchRow['adsbatch_lang_id']);
        if (empty($productData)) {
            LibHelper::dieJsonError(Labels::getLabel("ERR_PLEASE_ADD_ATLEAST_ONE_PRODUCT_TO_THE_BATCH", $this->siteLangId));
        }

        $data = [
            'batchId' => $this->adsBatchId,
            'batchTitle' => AdsBatch::getAttributesById($this->adsBatchId, 'adsbatch_name'),
            'currency_code' => strtoupper(Currency::getAttributesById(CommonHelper::getCurrencyId(), 'currency_code')),
            'data' => $productData,
            'expire_on' => $expireOn,
        ];
        $response = $this->googleShoppingFeed->publishBatch($data, (0 < $download));
        if (false === $response['status'] || Plugin::RETURN_FALSE === $response['status']) {
            LibHelper::dieJsonError($this->googleShoppingFeed->getError());
        }

        $dataToUpdate = [
            'adsbatch_status' => AdsBatch::STATUS_PUBLISHED,
            'adsbatch_synced_on' => date('Y-m-d H:i:s'),
            'adsbatch_next_execution_on' => $expireOn,
        ];

        if (false === AdsBatch::updateDetail($this->adsBatchId, $dataToUpdate)) {
            LibHelper::dieJsonError(Labels::getLabel("ERR_UNABLE_TO_UPDATE", $this->siteLangId));
        }

        if (true) {
            $this->set('redirect_url', UrlHelper::generateUrl('GoogleShoppingFeed', 'downloadXmlFile', [$this->adsBatchId]));
        }
        $this->set('msg', $response['msg']);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function downloadXmlFile(int $batchId)
    {
        $title = AdsBatch::getAttributesById($batchId, 'adsbatch_name');
        if (empty($title)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_FILE_NOT_FOUND', $this->siteLangId), false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('GoogleShoppingFeed'));
        }

        $xmlFileName = $batchId . str_replace(' ', '_', strtolower($title)) . '.xml';
        if (!file_exists(CONF_UPLOADS_PATH . $xmlFileName)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_FILE_NOT_FOUND', $this->siteLangId), false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('GoogleShoppingFeed'));
        }

        AttachedFile::downloadAttachment($xmlFileName, $xmlFileName);
        unlink(CONF_UPLOADS_PATH . $xmlFileName);
    }

    public function getBreadcrumbNodes($action)
    {
        if (FatUtility::isAjaxCall()) {
            return;
        }

        $className = get_class($this);
        $arr = explode('-', FatUtility::camel2dashed($className));
        array_pop($arr);
        $urlController = implode('-', $arr);
        $className = ucwords(implode('_', $arr));


        if ($action == 'index') {
            $this->nodes[] = array('title' => ucwords(Labels::getLabel('BCN_' . $className)));
        } else if ($action == 'viewProducts') {
            $action = str_replace('-', '_', FatUtility::camel2dashed($action));
            $this->nodes[] = array('title' => ucwords(Labels::getLabel('BCN_' . $className)), 'href' => UrlHelper::generateUrl($urlController));
            $this->nodes[] = array('title' => ucwords(Labels::getLabel('BCN_' . $action)));
        } else {
            $action = str_replace('-', '_', FatUtility::camel2dashed($action));
            $this->nodes[] = array('title' => ucwords(Labels::getLabel('BCN_' . $action)));
        }
        return $this->nodes;
    }

    public function getSubUsersAccountList()
    {
        $userData = $this->getUserMeta();
        $serviceAccountInfo = $userData['service_account'] ?? '';
        if (empty($serviceAccountInfo)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_ADD_SERVICE_ACCOUNT_INFO', $this->siteLangId), true);
        }
        $aggregatorId = $userData[self::KEY_NAME . '_aggregatorId'] ?? '';
        if (empty($aggregatorId)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_AGGREGATOR_ID', $this->siteLangId), true);
        }

        $client = new Google_Client();
        $client->setAuthConfig(json_decode($serviceAccountInfo, true));
        $client->setScopes([Google_Service_ShoppingContent::CONTENT]);

        $service = new Google_Service_ShoppingContent($client);
        $accounts = $service->accounts->listAccounts($aggregatorId);
        if (empty($aggregatorId)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_NO_SUB_ACCOUNT_FOUND', $this->siteLangId), true);
        }

        $this->set('merchantId', ($userData[self::KEY_NAME . '_merchantId'] ?? 0));
        $this->set('accounts', $accounts);
        $this->set('html', $this->_template->render(false, false, NULL, true, false));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function updateMerchantId()
    {
        $merchantId = FatApp::getPostedData('merchantId', FatUtility::VAR_INT, 0);  
        if (1 > $merchantId) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_MERCHANT_ID', $this->siteLangId), true);
        }
        $this->updateMerchantInfo([self::KEY_NAME . '_merchantId' => $merchantId], false);
    }
}
