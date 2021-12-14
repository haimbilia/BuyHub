<?php
class ProductsController extends ListingBaseController
{
    protected string $modelClass = 'Product';
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewProducts();
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
            $this->set("canEdit", $this->objPrivilege->canEditProducts($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditProducts();
        }
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey('MANAGE_PRODUCTS', $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);
        $actionItemsData['newRecordBtnAttrs'] = ['attr' => ['href' => UrlHelper::generateUrl('products', 'form'), 'onclick' => '']];

        $actionItemsData['deleteButton'] = true;
        $actionItemsData['searchFrmTemplate'] = 'products/search-form.php';

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_PRODUCT_NAME_AND_MODEL', $this->siteLangId));

        $this->checkEditPrivilege(true);
        $this->getListingData();

        $this->_template->addCss(array('css/select2.min.css'));
        $this->_template->addJs(array('products/page-js/index.js', 'js/select2.js'));
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'products/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'product_added_on');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = 'product_added_on';
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_DESC));

        $searchForm = $this->getSearchForm($fields);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());

        $srch = Product::getSearchObject($this->siteLangId);
        $srch->joinTable(AttributeGroup::DB_TBL, 'LEFT OUTER JOIN', 'product_attrgrp_id = attrgrp_id', 'attrgrp');
        $srch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'product_seller_id = user_id', 'tu');
        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('product_name', 'like', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('product_model', 'like', '%' . $post['keyword'] . '%', 'OR');
            $cnd->attachCondition('product_identifier', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $active = FatApp::getPostedData('active');
        if ('' != $active && $active > -1) {
            $srch->addCondition('product_active', '=', $active);
        }

        $product_approved = FatApp::getPostedData('product_approved');
        if ('' != $product_approved && $product_approved > -1) {
            $srch->addCondition('product_approved', '=', $product_approved);
        }

        $product_seller_id = FatApp::getPostedData('product_seller_id', FatUtility::VAR_INT, 0);

        if (FatApp::getConfig('CONF_ENABLED_SELLER_CUSTOM_PRODUCT')) {
            $is_custom_or_catalog = FatApp::getPostedData('is_custom_or_catalog', FatUtility::VAR_INT, -1);
            if ($is_custom_or_catalog > -1) {
                if ($is_custom_or_catalog > 0) {
                    if (0 < $product_seller_id) {
                        $srch->addCondition('product_seller_id', '=', $product_seller_id);
                    } else {
                        $srch->addCondition('product_seller_id', '>', 0);
                    }
                } else {
                    if (0 < $product_seller_id) {
                        $srch->addCondition('product_seller_id', '=', $product_seller_id);
                    }
                }
            } else {
                if (0 < $product_seller_id) {
                    $srch->addCondition('product_seller_id', '=', $product_seller_id);
                }
            }
        } else {
            if (0 < $product_seller_id) {
                $srch->addCondition('product_seller_id', '=', $product_seller_id);
            }
        }

        $product_attrgrp_id = FatApp::getPostedData('product_attrgrp_id', FatUtility::VAR_INT, -1);
        if ($product_attrgrp_id > -1) {
            $srch->addCondition('product_attrgrp_id', '=', $product_attrgrp_id);
        }

        $prodcat_id = FatApp::getPostedData('prodcat_id', FatUtility::VAR_INT, -1);
        if ($prodcat_id > 0) {
            $srch->joinTable(Product::DB_TBL_PRODUCT_TO_CATEGORY, 'LEFT OUTER JOIN', 'product_id = ptc_product_id', 'ptcat');
            $srch->addCondition('ptcat.ptc_prodcat_id', '=', $prodcat_id);
        }

        $product_type = FatApp::getPostedData('product_type', FatUtility::VAR_INT, 0);
        if ($product_type > 0) {
            $srch->addCondition('product_type', '=', $product_type);
        }

        $date_from = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
        if (!empty($date_from)) {
            $srch->addCondition('tp.product_added_on', '>=', $date_from . ' 00:00:00');
        }

        $date_to = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');
        if (!empty($date_to)) {
            $srch->addCondition('tp.product_added_on', '<=', $date_to . ' 23:59:59');
        }

        $product_id = FatApp::getPostedData('product_id', FatUtility::VAR_INT, '');
        if (!empty($product_id)) {
            $srch->addCondition('product_id', '=', $product_id);
        }

        $srch->addMultipleFields(
            array(
                'product_id', 'product_attrgrp_id',
                'product_identifier', 'product_approved', 'product_active', 'product_seller_id', 'product_added_on',
                'product_name', 'attrgrp_name', 'user_name', 'product_updated_on'
            )
        );

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->siteLangId));
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);

        $this->set('frmSearch', $searchForm);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditEmptyCartItems($this->admin_id, true));
        $this->set('canViewUsers', $this->objPrivilege->canViewUsers($this->admin_id, true));
    }


    public function form($productId = 0, $productType = 0)
    {
        $this->objPrivilege->canEditProducts();

        $productId = FatUtility::int($productId);
        $productType = FatUtility::int($productType);

        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        if (1 > $langId) {
            $langId = CommonHelper::getDefaultFormLangId();
        }

        $frm = $this->getForm($langId, $productType, $productId);
        $imgFrm = $this->getImageFrm();
        $isSelProdCreatedBySeller = false;
        $isProductAddedByAdmin = true;
        $productOptions = [];
        if (1 < $productId) {
            $this->setModel([$productId]);
            if (0 < FatApp::getPostedData('autoFillLangData', FatUtility::VAR_INT, 0)) {
                $updateLangDataobj = new TranslateLangData($this->modelObj::DB_TBL_LANG);
                $translatedData = $updateLangDataobj->getTranslatedData($productId, $langId, CommonHelper::getDefaultFormLangId());
                if (false === $translatedData) {
                    LibHelper::exitWithError($updateLangDataobj->getError(), true);
                }
                $productData = current($translatedData);
                $productData += $this->modelObj::getAttributesById($productId);
            } else {
                $productData = $this->modelObj::getAttributesByLangId($langId, $productId, null, true);
            }

            if (0 < $productType) {
                $productData['product_type'] =  $productType;
            } else {
                $frm = $this->getForm($langId, $productData['product_type'], $productId);
            }

            $fld = $frm->getField('product_seller_id');
            if ($productData['product_seller_id'] > 0) {
                $userShopName = User::getUserShopName($productData['product_seller_id'], $langId);
                $fld->options = [$productData['product_seller_id'] => $userShopName['user_name'] . ' (' . $userShopName['shop_name'] . ')'];
            } else {
                $fld->options = [0 => Labels::getLabel('FRM_ADMIN', $langId)];
            }

            if (empty($productData)) {
                LibHelper::exitWithError($this->str_invalid_request_id, false, true);
                FatApp::redirectUser(UrlHelper::generateUrl('Products'));
            }

            $prodSpecificsDetails = Product::getProductSpecificsDetails($productId);
            if (false != $prodSpecificsDetails) {
                $productData +=  $prodSpecificsDetails;
            }

            $productTags = Product::getProductTags($productId, $langId);
            $tagData = [];
            foreach ($productTags as $key => $data) {
                $tagData[$key]['id'] = $data['tag_id'];
                $tagData[$key]['value'] = htmlspecialchars($data['tag_name'], ENT_QUOTES, 'UTF-8');
            }

            $productData['product_tags'] = json_encode($tagData);

            if (1 < $productData['product_brand_id']) {
                $brandData = Brand::getAttributesByLangId($langId, $productData['product_brand_id'], [Brand::tblFld('name'), Brand::tblFld('identifier')], true, applicationConstants::YES, applicationConstants::NO);
                if (false != $brandData) {
                    $fld = $frm->getField('product_brand_id');
                    $fld->options = [$productData['product_brand_id'] => $brandData[Brand::tblFld('name')] ?? $brandData[Brand::tblFld('identifier')]];
                }
            }

            $productCategories = $this->modelObj->getProductCategories($productId);
            if (!empty($productCategories)) {
                $selectedCat = current($productCategories)['prodcat_id'];
                $productData['ptc_prodcat_id'] = $selectedCat;
                $catData = ProductCategory::getAttributesByLangId($langId, $selectedCat, [ProductCategory::tblFld('name'), ProductCategory::tblFld('identifier')], true, applicationConstants::YES, applicationConstants::NO);
                if (false != $catData) {
                    $fld = $frm->getField('ptc_prodcat_id');
                    $fld->options = [$productData['ptc_prodcat_id'] => $catData[ProductCategory::tblFld('name')] ?? $catData[ProductCategory::tblFld('identifier')]];
                }
            }

            if (Tax::getActivatedServiceId()) {
                $taxCatMultiFields = ['concat(IFNULL(taxcat_name,taxcat_identifier)', '" (",taxcat_code,")") as taxcat_name', 'taxcat_id'];
            } else {
                $taxCatMultiFields = ['IFNULL(taxcat_name,taxcat_identifier) as taxcat_name', 'taxcat_id'];
            }

            $taxData = Tax::getTaxCatByProductId($productId, $productData['product_seller_id'], $langId, $taxCatMultiFields);
            if (false != $taxData) {
                $productData['ptt_taxcat_id']  = $taxData[Tax::tblFld('id')];
                $fld = $frm->getField('ptt_taxcat_id');
                $fld->options = [$productData['ptt_taxcat_id'] => $taxData[Tax::tblFld('name')] ?? $taxData[Tax::tblFld('identifier')]];
            }

            $prodShippingDetails = Product::getProductShippingDetails($productId, $langId, $productData['product_seller_id']);

            if (false != $prodShippingDetails) {
                $productData['ps_from_country_id']  = $prodShippingDetails['ps_from_country_id'];
                $countryData = Countries::getAttributesByLangId($langId, $prodShippingDetails['ps_from_country_id'], [Countries::tblFld('name'), Countries::tblFld('code')], true, applicationConstants::YES);
                if (false != $countryData) {
                    $fld = $frm->getField('ps_from_country_id');
                    $fld->options = [$prodShippingDetails['ps_from_country_id'] => $countryData[Countries::tblFld('name')] ?? $countryData[Tax::tblFld('code')]];
                }
            }

            /* [ GET ATTACHED PROFILE ID */
            $profSrch = ShippingProfileProduct::getSearchObject();
            $profSrch->addCondition('shippro_product_id', '=', $productId);
            $profSrch->addCondition('shippro_user_id', '=', $productData['product_seller_id']);
            $profSrch->doNotCalculateRecords();
            $profSrch->setPageSize(1);
            $proRs = $profSrch->getResultSet();
            $profileData = FatApp::getDb()->fetch($proRs);
            if (!empty($profileData)) {
                $productData['shipping_profile'] = $profileData['profile_id'];
            }
            /* ]*/
            $isSelProdCreatedBySeller = 0 < Product::getCatalogProductCount($productId);
            $isProductAddedByAdmin = applicationConstants::YES == $productData['product_added_by_admin_id'];
            $productOptions = Product::getProductOptions($productId, $langId, true);

            $srch = new SearchBase(UpcCode::DB_TBL);
            $srch->addCondition('upc_product_id', '=', $productId);
            $srch->addFld('upc_options');
            $row = FatApp::getDb()->fetch($srch->getResultSet());
            $productData['upc_type'] = applicationConstants::NO;
            if (false != $row) {
                if ($row['upc_options'] != 0 || $row['upc_options'] != '') {
                    $productData['upc_type'] = applicationConstants::YES;
                }
            }
            $frm->fill($productData);
            $imgFrm->fill(['file_type' => AttachedFile::FILETYPE_PRODUCT_IMAGE, 'product_id' => $productId]);
        } else {
            $tempProductId = time() . $this->admin_id;
            $frm->fill(['temp_product_id' => $tempProductId]);
            $imgFrm->fill(['file_type' => AttachedFile::FILETYPE_PRODUCT_IMAGE_TEMP, 'product_id' => $tempProductId]);
        }

        // $attachDownloadsWithInv = 0;
        // $productType = Product::PRODUCT_TYPE_PHYSICAL;
        // if (0 < $productId) {
        //     $prodData = Product::getAttributesById($productId, ['product_type', 'product_attachements_with_inventory']);
        //     $productType = $prodData['product_type'] ?? 0;
        //     $attachDownloadsWithInv = $prodData['product_attachements_with_inventory'] ?? 0;
        // }

        // $this->set('productId', $productId);
        // $this->set('productType', $productType);
        // $this->set('attachDownloadsWithInv', $attachDownloadsWithInv);
        $this->set("frm", $frm);
        $this->set("imgFrm", $imgFrm);
        $codEnabled = true;
        $paymentMethod = new PaymentMethods();
        if (!$paymentMethod->cashOnDeliveryIsActive()) {
            $codEnabled = false;
        }
        $this->set("codEnabled", $codEnabled);
        $this->set("canEditTags",  $this->objPrivilege->canEditTags($this->admin_id, true));
        $this->set("langId", $langId);
        $this->set("productId", $productId);

        $this->set('isSelProdCreatedBySeller', $isSelProdCreatedBySeller);
        $this->set('isProductAddedByAdmin', $isProductAddedByAdmin);
        $this->set('productOptions', $productOptions);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        if (FatUtility::isAjaxCall()) {
            $this->_template->render(false, false);
            return;
        }

        $this->_template->addJs(array('js/cropper.js', 'js/cropper-main.js', 'js/select2.js', 'js/tagify.min.js', 'js/tagify.polyfills.min.js', 'js/jquery-sortable-lists.js'));
        $this->_template->addCss(['css/cropper.css', 'css/tagify.min.css', 'css/select2.min.css']);
        $this->set("includeEditor", true);
        $this->_template->render();
    }

    private function getForm($langId, $productType = 0, $productId = 0)
    {
        $frm = new Form('frmProduct');
        $productTypeArr = Product::getProductTypes($langId);

        $productType = $productType == 0 ? array_key_first($productTypeArr) : $productType;

        if (0 < $productId) {
            $fld = $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(), $langId, [], '');
        } else {
            $fld = $frm->addHiddenField('', 'lang_id', $langId);
            $fld->requirements()->setRequired();
        }

        $fld = $frm->addRadioButtons(Labels::getLabel('FRM_PRODUCT_TYPE', $langId), 'product_type', $productTypeArr, $productType);
        $fld->requirements()->setRequired();

        $fld = $frm->addSelectBox(Labels::getLabel('FRM_USER', $langId), 'product_seller_id', [], '', [], Labels::getLabel('FRM_ADMIN', $langId));

        $frm->addRequiredField(Labels::getLabel('FRM_PRODUCT_IDENTIFIER', $langId), 'product_identifier');
        $frm->addRequiredField(Labels::getLabel('FRM_PRODUCT_NAME', $langId), 'product_name');


        $fld = $frm->addSelectBox(Labels::getLabel('FRM_BRAND', $langId), 'product_brand_id', []);
        if (FatApp::getConfig("CONF_PRODUCT_BRAND_MANDATORY", FatUtility::VAR_INT, 1)) {
            $fld->requirements()->setRequired();
        }

        $fld = $frm->addSelectBox(Labels::getLabel('FRM_CATEGORY', $langId), 'ptc_prodcat_id', []);
        $fld->requirements()->setRequired();

        $fld = $frm->addTextBox(Labels::getLabel('FRM_MODEL', $langId), 'product_model');
        if (FatApp::getConfig("CONF_PRODUCT_MODEL_MANDATORY", FatUtility::VAR_INT, 1)) {
            $fld->requirements()->setRequired();
        }

        $fld = $frm->addFloatField(Labels::getLabel('FRM_MINIMUM_SELLING_PRICE', $langId) . ' [' . CommonHelper::getCurrencySymbol(true) . ']', 'product_min_selling_price', '');
        $fld->requirements()->setPositive();

        if ($productType != Product::PRODUCT_TYPE_DIGITAL) {
            $fld = $frm->addRequiredField(Labels::getLabel('FRM_PRODUCT_WARRANTY', $langId), 'product_warranty');
            $fld->requirements()->setInt();
            $fld->requirements()->setPositive();
            $frm->addHiddenField('', 'product_warranty_unit', current(Product::getWarrantyUnits($langId)));
        }
        $frm->addHtmlEditor(Labels::getLabel('FRM_DESCRIPTION', $langId), 'product_description');
        $frm->addTextBox(Labels::getLabel('FRM_YOUTUBE_VIDEO_URL', $langId), 'product_youtube_video');


        //$frm->addSelectBox(Labels::getLabel('FRM_PRODUCT_DOWNLOAD_ATTACHEMENTS_AT_INVENTORY_LEVEL', $langId), 'product_attachements_with_inventory', applicationConstants::getYesNoArr($langId), '', array(), '');

        // $downloadAttachementsWithInventoryTrue = new FormFieldRequirement('product_attachements_with_inventory', 'value');
        // $downloadAttachementsWithInventoryTrue->setRequired();
        // $downloadAttachementsWithInventoryFalse = new FormFieldRequirement('product_attachements_with_inventory', 'value');
        // $downloadAttachementsWithInventoryFalse->setRequired(false);

        // $prodTypeFld = $frm->getField('product_type');
        // $prodTypeFld->requirements()->addOnChangerequirementUpdate(applicationConstants::YES, 'eq', 'product_attachements_with_inventory', $downloadAttachementsWithInventoryTrue);
        // $prodTypeFld->requirements()->addOnChangerequirementUpdate(applicationConstants::NO, 'eq', 'product_attachements_with_inventory', $downloadAttachementsWithInventoryFalse);

        $frm->addCheckBox(Labels::getLabel('FRM_MARK_THIS_PRODUCT_AS_FEATURED', $langId), 'product_featured', 1, array(), false, 0);

        // $approveUnApproveArr = Product::getApproveUnApproveArr($langId);
        // $frm->addSelectBox(Labels::getLabel('FRM_APPROVAL_STATUS', $langId), 'product_approved', $approveUnApproveArr, Product::APPROVED, array(), '');

        $frm->addCheckBox(Labels::getLabel("LBL_ACTIVE", $langId), 'product_active', applicationConstants::YES, array(), true, 0);

        $frm->addTextBox(Labels::getLabel('FRM_PRODUCT_TAGS', $langId), 'product_tags');

        $fld = $frm->addSelectBox(Labels::getLabel('FRM_TAX_CATEGORY', $langId), 'ptt_taxcat_id', []);
        $fld->requirements()->setRequired();

        $frm->addSelectBox(Labels::getLabel('LBL_COUNTRY_OF_ORIGIN', $langId), 'ps_from_country_id', []);
        if ($productType == Product::PRODUCT_TYPE_DIGITAL) {
            $frm->addRadioButtons(Labels::getLabel('FRM_PRODUCT_DOWNLOAD_ATTACHEMENTS_AT_INVENTORY_LEVEL', $this->siteLangId), 'product_attachements_with_inventory', applicationConstants::getYesNoArr($langId), applicationConstants::NO);
        } else {

            $fld = $frm->addCheckBox(Labels::getLabel('FRM_PRODUCT_IS_AVAILABLE_FOR_CASH_ON_DELIVERY_(COD)', $langId), 'product_cod_enabled', 1, array(), false, 0);

            $fulFillmentArr = Shipping::getFulFillmentArr($langId, FatApp::getConfig('CONF_FULFILLMENT_TYPE', FatUtility::VAR_INT, -1));
            $fld = $frm->addSelectBox(Labels::getLabel('FRM_FULFILLMENT_METHOD', $langId), 'product_fulfillment_type', $fulFillmentArr, applicationConstants::NO, ['class' => 'fieldsVisibilityJs'], Labels::getLabel('FRM_SELECT', $langId));
            $fld->requirements()->setRequired();
            if (FatApp::getConfig("CONF_PRODUCT_DIMENSIONS_ENABLE", FatUtility::VAR_INT, 1)) {
                $shipPackArr = ShippingPackage::getAllNames();
                $frm->addSelectBox(Labels::getLabel('FRM_SHIPPING_PACKAGE', $langId), 'product_ship_package', $shipPackArr, '', [], Labels::getLabel('FRM_SELECT', $langId))->requirements()->setRequired();

                $weightUnitsArr = applicationConstants::getWeightUnitsArr($langId);
                $frm->addSelectBox(Labels::getLabel('FRM_WEIGHT_UNIT', $langId), 'product_weight_unit', $weightUnitsArr, '', [], Labels::getLabel('FRM_SELECT', $langId))->requirements()->setRequired();

                $weightFld = $frm->addFloatField(Labels::getLabel('FRM_WEIGHT', $langId), 'product_weight', '0.00');
                $weightFld->requirements()->setRequired(true);
                $weightFld->requirements()->setFloatPositive();
                $weightFld->requirements()->setRange('0.01', '9999999999');
            }
            $frm->addSelectBox(Labels::getLabel('FRM_SHIPPING_PROFILE', $langId), 'shipping_profile', [], '', [], '');
        }


        if (0 < $productId) {
            $frm->addCheckBox(Labels::getLabel('FRM_APPROVAL_STATUS', $langId), 'product_approved', 1, array(), false, 0);
        }

        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && $langId == CommonHelper::getDefaultFormLangId() && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        $fld = $frm->addRadioButtons('', 'upc_type', applicationConstants::getYesNoArr($langId), applicationConstants::NO);
        $fld->requirements()->setRequired();

        $frm->addHiddenField('', 'product_upcs');
        $frm->addHiddenField('', 'options');
        $frm->addHiddenField('', 'optionValues');
        $frm->addHiddenField('', 'specifications');
        $frm->addHiddenField('', 'product_id', 0);
        if (1 > $productId) {
            $fld = $frm->addHiddenField('', 'temp_product_id');
            $fld->requirements()->setRequired();
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('FRM_SAVE_AND_NEXT', $langId));

        return $frm;
    }

    public function setup()
    {
        $this->checkEditPrivilege();

        $productId = FatApp::getPostedData('product_id', FatUtility::VAR_INT, 0);
        $productType = FatApp::getPostedData('product_type', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        if (1 > $langId ||  !array_key_exists($productType, Product::getProductTypes($langId))) {
            FatUtility::dieJsonError($this->str_invalid_request, true);
        }

        $frm = $this->getForm($langId, $productType, $productId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        /* [select2 data */
        $post['product_brand_id'] = FatApp::getPostedData('product_brand_id', FatUtility::VAR_INT, 0);
        $post['ptc_prodcat_id'] = FatApp::getPostedData('ptc_prodcat_id', FatUtility::VAR_INT, 0);
        $post['ptt_taxcat_id'] = FatApp::getPostedData('ptt_taxcat_id', FatUtility::VAR_INT, 0);
        $post['ps_from_country_id'] = FatApp::getPostedData('ps_from_country_id', FatUtility::VAR_INT, 0);
        $post['product_seller_id'] = FatApp::getPostedData('product_seller_id', FatUtility::VAR_INT, 0);
        /* select2 data ] */

        $this->validateGetForm($post);

        $productId = $post['product_id'];
        $langId = $post['lang_id'];

        /* sendApprovalStatusUpdate to seller */
        $sendApprovalStatusUpdate = false;
        $isNewProduct = false;
        if (0 < $productId && isset($post['product_approved'])) {
            $oldProductData = Product::getAttributesById($productId, ['product_approved', 'product_seller_id']);
            if (0 < $oldProductData['product_seller_id'] && $oldProductData['product_approved'] != $post['product_approved']) {
                $sendApprovalStatusUpdate = true;
            }
        }
        if (1 > $productId) {
            $isNewProduct = true;
            $post['product_approved'] = applicationConstants::YES;
        }

        /* TODO:
                    1) in case productid > 0 (edit product) need to check
                        a) product_attachements_with_inventory is yes and attachments/links added with product catalog then return with error to remove the links/files first.
                        b) a) product_attachements_with_inventory is no and attachments/links added with inventory then return with error to remove the links/files first.
                */

        // if ($post['product_attachements_with_inventory'] < 0 || $post['product_attachements_with_inventory'] > 1) {
        //     $post['product_attachements_with_inventory'] = 0;
        // }

        $prodObj = new Product($productId);
        $db = FatApp::getDb();
        $db->startTransaction();

        if (!$prodObj->saveProductData($post)) {
            $db->rollbackTransaction();
            LibHelper::exitWithError($prodObj->getError(), true);
        }
        $productId = $prodObj->getMainTableRecordId();

        $this->setLangData($prodObj, [
            $prodObj::tblFld('name') => $post[$prodObj::tblFld('name')],
            $prodObj::tblFld('description') => $post[$prodObj::tblFld('description')],
            $prodObj::tblFld('youtube_video') => $post[$prodObj::tblFld('youtube_video')]
        ], $langId);

        if (!$prodObj->saveProductCategory($post['ptc_prodcat_id'])) {
            $db->rollbackTransaction();
            LibHelper::exitWithError($prodObj->getError(), true);
        }

        if (!$prodObj->saveProductTax($post['ptt_taxcat_id'], $post['product_seller_id'])) {
            $db->rollbackTransaction();
            LibHelper::exitWithError($prodObj->getError(), true);
        }

        if (isset($post['specifications']) && is_array($post['specifications'])) {
            foreach ($post['specifications'] as $specification) {
                if (!$prodObj->saveProductSpecifications($specification['id'], $langId, $specification['name'], $specification['value'], $specification['group'])) {
                    $db->rollbackTransaction();
                    LibHelper::exitWithError($prodObj->getError(), true);
                }
            }
        }

        $psFree = isset($post['ps_free']) ? $post['ps_free'] : 0;
        if (!$prodObj->saveProductSellerShipping($post['product_seller_id'], $psFree, $post['ps_from_country_id'])) {
            $db->rollbackTransaction();
            LibHelper::exitWithError($prodObj->getError(), true);
        }

        if (isset($post['shipping_profile'])) {
            $shipProProdData = array(
                'shippro_shipprofile_id' => !empty($post['shipping_profile']) ? $post['shipping_profile'] : ShippingProfile::getDefaultProfileId($post['product_seller_id']),
                'shippro_product_id' => $productId
            );
            $spObj = new ShippingProfileProduct();
            if (!$spObj->addProduct($shipProProdData)) {
                $db->rollbackTransaction();
                LibHelper::exitWithError($spObj->getError(), true);
            }
        }

        $productSpecifics = new ProductSpecifics($productId);
        $productSpecifics->assignValues(($post + ['ps_product_id' => $productId]));
        $data = $productSpecifics->getFlds();
        if (!$productSpecifics->addNew(array(), $data)) {
            $db->rollbackTransaction();
            LibHelper::exitWithError($productSpecifics->getError(), true);
        }

        if (isset($post['product_tags']) && !empty($post['product_tags'])) {
            $productTags = json_decode($post['product_tags'], true);
            foreach ($productTags as $tag) {
                if (!isset($tag['id'])) {
                    $tagObj = new Tag();
                    $tagObj->assignValues(['tag_name' => $tag['value'], 'tag_lang_id' => $langId]);
                    if (!$tagObj->save()) {
                        $db->rollbackTransaction();
                        LibHelper::exitWithError($tagObj->getError(), true);
                    }
                    $tagId = $tagObj->getMainTableRecordId();
                } else {
                    $tagId = $tag['id'];
                }
                if (!$prodObj->addUpdateProductTag($tagId)) {
                    $db->rollbackTransaction();
                    LibHelper::exitWithError($prodObj->getError(), true);
                }
            }
        }

        if (isset($post['options'])  && isset($post['optionValues'])) {
            foreach ($post['options'] as $index => $optionId) {
                $opValuesArr = array_column(json_decode($post['optionValues'][$index]), 'id');
                if (!$prodObj->addUpdateProductOption($optionId, implode(",", $opValuesArr))) {
                    $db->rollbackTransaction();
                    LibHelper::exitWithError($prodObj->getError(), true);
                }
            }
        }

        UpcCode::remove($productId);
        foreach ($post['product_upcs'] as $optionsIds => $upcCode) {
            $dataToSave = array(
                'upc_code' => $upcCode,
                'upc_product_id' => $productId,
                'upc_options' => $optionsIds,
            );
            if (!$db->insertFromArray(UpcCode::DB_TBL, $dataToSave, false, [], $dataToSave)) {
                $db->rollbackTransaction();
                LibHelper::exitWithError($db->getError(), true);
            }
        }

        if (true == $sendApprovalStatusUpdate) {
            $email = new EmailHandler();
            $emailData['status'] = $post['product_approved'];
            $emailData['product_name'] = $post['product_name'];
            $emailData['seller_id'] = $oldProductData['product_seller_id'];
            if (!$email->sendCatalogRequestStatusChangeNotification($langId, $emailData)) {
                $db->rollbackTransaction();
                LibHelper::exitWithError(Labels::getLabel('ERR_EMAIL_COULD_NOT_BE_SENT', $langId), true);
            }
        }
        Tag::updateProductTagString($productId);
        Product::updateMinPrices($productId);
        if ($isNewProduct) {
            $prodObj->moveTempFiles(AttachedFile::FILETYPE_PRODUCT_IMAGE_TEMP, $post['temp_product_id']);
        }
        $db->commitTransaction();
        $this->set('productId', $productId);
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function validateGetForm(&$post)
    {
        $langId = $post['lang_id'];
        $productId = $post['product_id'];
        if (1 > $productId) {
            if (!isset($post['temp_product_id']) || 1 > $post['temp_product_id']) {
                LibHelper::exitWithError($this->str_invalid_request . "111");
            }
        }

        if (isset($post['options'])) {
            $post['options'] = is_array($post['options']) ? array_filter($post['options']) : [];
            if (count($post['options'])) {
                if (!isset($post['optionValues']) || empty($post['optionValues']) ||  count($post['options']) != count($post['optionValues'])) {
                    LibHelper::exitWithError(Labels::getLabel('ERR_OPTION_VALUES_IS_REQUIRED', $langId), true);
                }

                $srch = Option::getSearchObject(0);
                $srch->addMultipleFields(['option_id', 'option_is_separate_images']);
                $srch->doNotLimitRecords();
                $srch->addCondition(Option::tblFld('id'), 'IN', $post['options']);
                $rs = $srch->getResultSet();

                if ($srch->recordCount() != count($post['options'])) {
                    LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_OPTION_ID', $langId), true);
                }
                $records =  FatApp::getDb()->fetchAll($rs);
                $opImageCount = 0;
                foreach ($records as $records) {
                    if ($records['option_is_separate_images'] == 1) {
                        $opImageCount++;
                    }
                    if (1 < $opImageCount) {
                        LibHelper::exitWithError(Labels::getLabel('ERR_YOU_HAVE_ALREADY_ADDED_OPTION_HAVING_SEPARATE_IMAGE', $langId), true);
                        break;
                    }
                }

                if (0 < $productId) {
                    $srch = new SearchBase(Product::DB_PRODUCT_TO_OPTION);
                    $srch->doNotLimitRecords();
                    $srch->addCondition(Product::DB_PRODUCT_TO_OPTION_PREFIX . 'product_id', '=', $productId);
                    $srch->addFld('prodoption_option_id');
                    $oldOptions = FatApp::getDb()->fetchAll($srch->getResultSet());
                    if ($oldOptions) {
                        $oldOptions = array_column($records, 'prodoption_option_id');
                        $oldDeletedOptions = array_diff(array_column($records, 'prodoption_option_id'), $post['options']);
                        if ($oldDeletedOptions) {
                            if (SellerProduct::isOptionLinked($oldDeletedOptions, $productId)) {
                                LibHelper::exitWithError(Labels::getLabel('ERR_OPTION_IS_LINKED_WITH_SELLER_INVENTORY', $this->siteLangId), true);
                            }
                        }
                    }
                }

                foreach ($post['options'] as $index => $optionId) {
                    if (!isset($post['optionValues'][$index])) {
                        LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_OPTION_VALUES_ID', $langId), true);
                    }
                    $opValuesArr = array_column(json_decode($post['optionValues'][$index]), 'id');
                    $srch = OptionValue::getSearchObject(0, false);
                    $srch->doNotLimitRecords();
                    $srch->addCondition(OptionValue::tblFld('option_id'), '=', $optionId);
                    $srch->addCondition(OptionValue::tblFld('id'), 'IN', $opValuesArr);
                    $srch->getResultSet();
                    if ($srch->recordCount() != count($opValuesArr)) {
                        LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_OPTION_VALUES_ID', $langId), true);
                    }
                }
            }
        }

        foreach ($post['product_upcs'] as $optionsIds => $upcCode) {
            if (empty($upcCode)) {
                unset($post['product_upcs'][$optionsIds]);
                continue;
            }
            $row = UpcCode::getUpcDataByCode($upcCode);

            if ($row && $row['upc_product_id'] != $productId) {
                LibHelper::exitWithError(Labels::getLabel('ERR_THIS_UPC/EAN_CODE_ALREADY_ASSIGNED_TO_ANOTHER_PRODUCT', $langId), true);
            }
        }
    }

    public function productAttributeGroupForm()
    {
        $this->set('productAttributeGroupForm', $this->getProductAttributeGroupForm());
        $this->_template->render(false, false);
    }

    private function getProductAttributeGroupForm()
    {
        $groupsArr = AttributeGroup::getAllNames();
        $frm = new Form('frmProductAttributeGroup');
        $frm->addSelectBox(Labels::getLabel('LBL_Seller_Attribute_Group', $this->siteLangId), 'attrgrp_id', $groupsArr, '', array(), Labels::getLabel('LBL_None', $this->siteLangId));
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Next', $this->siteLangId));
        return $frm;
    }

    // public function updateProductOption()
    // {
    //     $this->objPrivilege->canEditProducts();
    //     $post = FatApp::getPostedData();
    //     if (false === $post) {
    //         FatUtility::dieJsonError($this->str_invalid_request);
    //     }
    //     $product_id = FatUtility::int($post['product_id']);
    //     $option_id = FatUtility::int($post['option_id']);
    //     if (!$product_id || !$option_id) {
    //         FatUtility::dieJsonError($this->str_invalid_request);
    //     }

    //     $productOptions = Product::getProductOptions($product_id, $this->siteLangId, false, 1);
    //     $optionSeparateImage = Option::getAttributesById($option_id, 'option_is_separate_images');
    //     if (count($productOptions) > 0 && $optionSeparateImage == 1) {
    //         FatUtility::dieJsonError(Labels::getLabel('LBL_you_have_already_added_option_having_separate_image', $this->siteLangId));
    //     }

    //     $prodObj = new Product($product_id);
    //     if (!$prodObj->addUpdateProductOption($option_id)) {
    //         FatUtility::dieJsonError($prodObj->getError());
    //     }

    //     UpcCode::remove($product_id);
    //     Product::updateMinPrices($product_id);
    //     Tag::updateProductTagString($product_id);
    //     $this->set('msg', Labels::getLabel('LBL_Record_Updated_Successfully', $this->siteLangId));
    //     $this->_template->render(false, false, 'json-success.php');
    // }

    public function removeProductOption()
    {
        $this->objPrivilege->canEditProducts();

        $productId = FatApp::getPostedData('productId', FatUtility::VAR_INT, 0);
        $optionId = FatApp::getPostedData('optionId', FatUtility::VAR_INT, 0);

        if (1 > $productId || 1 > $optionId) {
            LibHelper::exitWithError(Labels::getLabel($this->str_invalid_request, $this->siteLangId));
        }

        if (SellerProduct::isOptionLinked($optionId, $productId)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_OPTION_IS_LINKED_WITH_SELLER_INVENTORY', $this->siteLangId), true);
        }

        $prodObj = new Product($productId);
        if (!$prodObj->removeProductOption($optionId)) {
            LibHelper::exitWithError($prodObj->getError(), true);
        }
        UpcCode::remove($productId);
        $this->set('msg', Labels::getLabel('MSG_OPTION_REMOVED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    /** use while deleting opvalue from catalog form */
    public function canDeleteOpValue()
    {
        $productId = FatApp::getPostedData('productId', FatUtility::VAR_INT, 0);
        $optionId = FatApp::getPostedData('optionId', FatUtility::VAR_INT, 0);
        $optionValueId = FatApp::getPostedData('optionValueId', FatUtility::VAR_INT, 0);

        if (1 > $productId || 1 > $optionId || 1 > $optionValueId) {
            LibHelper::exitWithError(Labels::getLabel($this->str_invalid_request, $this->siteLangId));
        }

        if (SellerProduct::isOptionValueLinked($optionId, $optionValueId, $productId)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_OPTION_VALUE_IS_LINKED_WITH_SELLER_INVENTORY', $this->siteLangId), true);
        }
        FatUtility::dieJsonSuccess('');
    }

    public function updateProductTag()
    {
        $this->objPrivilege->canEditProducts();
        $productId = FatApp::getPostedData('product_id', FatUtility::VAR_INT, 0);
        $tagId = FatApp::getPostedData('tag_id', FatUtility::VAR_INT, 0);
        if ($productId < 1 || $tagId < 1) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieWithError(Message::getHtml());
        }
        $prod = new Product($productId);
        if (!$prod->addUpdateProductTag($tagId)) {
            Message::addErrorMessage(Labels::getLabel($prod->getError(), $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        Tag::updateProductTagString($productId);

        $this->set('msg', Labels::getLabel('LBL_Record_Updated_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeProductTag()
    {
        $this->objPrivilege->canEditProducts();
        $productId = FatApp::getPostedData('product_id', FatUtility::VAR_INT, 0);
        $tagId = FatApp::getPostedData('tag_id', FatUtility::VAR_INT, 0);
        if ($productId < 1 || $tagId < 1) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieWithError(Message::getHtml());
        }

        $prod = new Product($productId);
        if (!$prod->removeProductTag($tagId)) {
            Message::addErrorMessage(Labels::getLabel($prod->getError(), $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        Tag::updateProductTagString($productId);

        $this->set('msg', Labels::getLabel('LBL_Tag_Removed_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function autoComplete()
    {
        $srch = Product::getSearchObject($this->siteLangId);
        $srch->doNotLimitRecords();
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('product_name', 'LIKE', '%' . $keyword . '%');
            $cnd->attachCondition('product_identifier', 'LIKE', '%' . $keyword . '%', 'OR');
        }

        $sellerId = FatApp::getPostedData('product_seller_id', FatUtility::VAR_STRING, '');
        if (!empty($sellerId)) {
            $srch->addCondition('product_seller_id', '=', $sellerId);
        }

        $excludeRecords = FatApp::getPostedData('excludeRecords', FatUtility::VAR_INT);
        if (!empty($excludeRecords) && is_array($excludeRecords)) {
            $srch->addCondition('product_id', 'NOT IN', $excludeRecords);
        }

        $srch->addMultipleFields(array('product_id as id', 'COALESCE(product_name, product_identifier) as text'));
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();
        $products = $db->fetchAll($rs);
        $json['results'] = $products;
        die(json_encode($json));
    }

    // private function getSeparateImageOptions($product_id, $langId)
    // {
    //     return Product::getSeparateImageOptions($product_id, $langId);
    // }

    public function countries_autocomplete()
    {
        $pagesize = 10;
        $post = FatApp::getPostedData();
        $srch = Countries::getSearchObject(true, $this->siteLangId);
        $srch->addOrder('country_name');

        $srch->addMultipleFields(array('country_id, country_name'));

        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('country_name', 'LIKE', '%' . $post['keyword'] . '%');
        }

        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();

        $countries = $db->fetchAll($rs, 'country_id');
        if (isset($post['includeEverywhere']) && $post['includeEverywhere']) {
            $everyWhereArr = array('country_id' => '-1', 'country_name' => Labels::getLabel('LBL_Everywhere_Else', $this->siteLangId));
            $countries[] = $everyWhereArr;
        }

        $json = array();
        foreach ($countries as $key => $country) {
            $json[] = array(
                'id' => $country['country_id'],
                'name' => strip_tags(html_entity_decode(isset($country['country_name']) ? $country['country_name'] : '', ENT_QUOTES, 'UTF-8')),

            );
        }
        die(json_encode($json));
    }

    public function getShippingTab()
    {
        $post = FatApp::getPostedData();
        $product_id = $post['product_id'];
        $userId = 0;
        if ($product_id) {
            $product = Product::getAttributesById($product_id);
            if ($product['product_seller_id'] > 0) {
                $userId = $product['product_seller_id'];
            }
        }

        $this->set('siteLangId', $this->siteLangId);
        $shipping_rates = array();
        $shipping_rates = Product::getProductShippingRates($product_id, $this->siteLangId, 0, $userId);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('product_id', $product_id);
        $this->set('shipping_rates', $shipping_rates);
        $this->_template->render(false, false);
    }

    public function shippingMethodsAutocomplete()
    {
        $pagesize = 10;
        $post = FatApp::getPostedData();
        $srch = ShippingApi::getSearchObject(true, $this->siteLangId);
        $srch->addOrder('shippingapi_name');

        $srch->addMultipleFields(array('shippingapi_id, shippingapi_name'));

        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('shippingapi_name', 'LIKE', '%' . $post['keyword'] . '%');
        }

        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();

        $shippingMethods = $db->fetchAll($rs, 'shippingapi_id');


        $json = array();
        foreach ($shippingMethods as $key => $sMethod) {
            $json[] = array(
                'id' => $key,
                'name' => strip_tags(html_entity_decode($sMethod['shippingapi_name'], ENT_QUOTES, 'UTF-8')),

            );
        }
        die(json_encode($json));
    }

    public function shippingMethodDurationAutocomplete()
    {
        $pagesize = 10;
        $db = FatApp::getDb();
        $post = FatApp::getPostedData();
        $srch = ShippingDurations::getSearchObject($this->siteLangId, true);
        $srch->addOrder('sduration_name');

        $srch->addMultipleFields(array('sduration_id, IFNULL(sduration_name, sduration_identifier) as sduration_name', 'sduration_from', 'sduration_to', 'sduration_days_or_weeks'));

        if (!empty($post['keyword'])) {
            $srch->addDirectCondition("(sduration_identifier like " . $db->quoteVariable('%' . $post['keyword'] . '%') . " OR sduration_name like " . $db->quoteVariable('%' . $post['keyword'] . '%') . ")");
        }

        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();

        $shipDurations = $db->fetchAll($rs, 'sduration_id');
        $json = array();
        foreach ($shipDurations as $key => $shipDuration) {
            $json[] = array(
                'id' => $key,
                'name' => strip_tags(html_entity_decode($shipDuration['sduration_name'], ENT_QUOTES, 'UTF-8')),
                'duraion' => ShippingDurations::getShippingDurationTitle($shipDuration, $this->siteLangId),

            );
        }
        die(json_encode($json));
    }

    protected function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'user_id');
        }
        $frm->setRequiredStarWith('caption');
        $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');

        if (FatApp::getConfig('CONF_ENABLED_SELLER_CUSTOM_PRODUCT')) {
            $frm->addSelectBox(Labels::getLabel('FRM_PRODUCT', $this->siteLangId), 'is_custom_or_catalog', array(-1 => Labels::getLabel('FRM_ALL', $this->siteLangId)) + applicationConstants::getCatalogTypeArr($this->siteLangId), -1, array(), '');
        }

        $frm->addSelectBox(Labels::getLabel('FRM_SELLER_NAME', $this->siteLangId), 'product_seller_id', []);
        $prodCatObj = new ProductCategory();
        $arrCategories = $prodCatObj->getCategoriesForSelectBox($this->siteLangId);
        $categories = $prodCatObj->makeAssociativeArray($arrCategories);

        $frm->addSelectBox(Labels::getLabel('FRM_CATEGORY', $this->siteLangId), 'prodcat_id', $categories);
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_ACTIVE', $this->siteLangId), 'active', array(-1 => Labels::getLabel('FRM_DOES_NOT_MATTER', $this->siteLangId)) + $activeInactiveArr, '', array(), '');

        $approveUnApproveArr = Product::getApproveUnApproveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_APPROVAL_STATUS', $this->siteLangId), 'product_approved', array(-1 => Labels::getLabel('FRM_DOES_NOT_MATTER', $this->siteLangId)) + $approveUnApproveArr, '', array(), '');

        $frm->addSelectBox(Labels::getLabel('FRM_PRODUCT_TYPE', $this->siteLangId), 'product_type', Product::getProductTypes($this->siteLangId), array(), [], Labels::getLabel('FRM_SELECT', $this->siteLangId));

        $frm->addDateField(Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'date_from', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addDateField(Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'date_to', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'product_id');

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm, 'btn btn-outline-brand');

        return $frm;
    }

    public function sellerCatalog()
    {
        $srchFrm = $this->getSearchForm();
        $this->set("frmSearch", $srchFrm);
        $this->_template->render();
    }

    public function removeProductShippingRates($product_id, $userId)
    {
        return Product::removeProductShippingRates($product_id, $userId);
    }

    public function addUpdateProductShippingRates($product_id, $data, $userId = 0)
    {
        return Product::addUpdateProductShippingRates($product_id, $data, $userId);
    }

    public function shippingCompanyAutocomplete()
    {
        $pagesize = 10;
        $post = FatApp::getPostedData();

        $srch = ShippingCompanies::getSearchObject(true, $this->siteLangId);
        $srch->addOrder('scompany_name');

        $srch->addMultipleFields(array('scompany_id, scompany_name'));

        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('scompany_name', 'LIKE', '%' . $post['keyword'] . '%');
        }

        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();

        $shippingCompanies = $db->fetchAll($rs, 'scompany_id');


        $json = array();
        foreach ($shippingCompanies as $key => $sCompany) {
            $json[] = array(
                'id' => $key,
                'name' => strip_tags(html_entity_decode($sCompany['scompany_name'], ENT_QUOTES, 'UTF-8')),

            );
        }
        die(json_encode($json));
    }


    public function customProductSpecifications($product_id)
    {
        $this->objPrivilege->canEditProducts();
        $hideListBox = false;
        if (0 < $product_id) {
            $productObj = new Product();
            $data = $productObj->getProductSpecifications($product_id, $this->siteLangId);

            if ($data === false) {
                FatUtility::dieWithError($this->str_invalid_request);
            }

            if (empty($data)) {
                $hideListBox = true;
            }
        }
        $this->set('product_id', $product_id);
        $this->set('hideListBox', $hideListBox);
        $languages = Language::getAllNames();
        $this->set('languages', $languages);
        $this->set('activeTab', 'SPECIFICATIONS');
        $this->set('siteLangId', $this->siteLangId);
        $this->_template->render(false, false);
    }

    public function addUpdateProductSellerShipping($product_id, $data_to_be_save, $userId)
    {
        return Product::addUpdateProductSellerShipping($product_id, $data_to_be_save, $userId);
    }

    // public function changeStatus()
    // {
    //     $this->objPrivilege->canEditProducts();
    //     $productId = FatApp::getPostedData('productId', FatUtility::VAR_INT, 0);
    //     if (0 >= $productId) {
    //         Message::addErrorMessage($this->str_invalid_request_id);
    //         FatUtility::dieWithError(Message::getHtml());
    //     }

    //     $productData = Product::getAttributesById($productId, array('product_active'));
    //     if (false == $productData) {
    //         Message::addErrorMessage($this->str_invalid_request_id);
    //         FatUtility::dieWithError(Message::getHtml());
    //     }

    //     $status = ($productData['product_active'] == applicationConstants::ACTIVE) ? applicationConstants::INACTIVE : applicationConstants::ACTIVE;

    //     $this->updateProductStatus($productId, $status);
    //     Product::updateMinPrices($productId);
    //     $this->set("msg", $this->str_update_record);
    //     $this->_template->render(false, false, 'json-success.php');
    // }

    // public function toggleBulkStatuses()
    // {
    //     $this->objPrivilege->canEditProducts();

    //     $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
    //     $productIdsArr = FatUtility::int(FatApp::getPostedData('product_ids'));
    //     if (empty($productIdsArr) || -1 == $status) {
    //         FatUtility::dieWithError(
    //             Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
    //         );
    //     }

    //     foreach ($productIdsArr as $productId) {
    //         if (1 > $productId) {
    //             continue;
    //         }

    //         $this->updateProductStatus($productId, $status);
    //     }
    //     $this->set('msg', $this->str_update_record);
    //     $this->_template->render(false, false, 'json-success.php');
    // }

    // private function updateProductStatus($productId, $status)
    // {
    //     $status = FatUtility::int($status);
    //     $productId = FatUtility::int($productId);
    //     if (1 > $productId || -1 == $status) {
    //         FatUtility::dieWithError(
    //             Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
    //         );
    //     }

    //     $productObj = new Product($productId);

    //     if (!$productObj->changeStatus($status)) {
    //         Message::addErrorMessage($productObj->getError());
    //         FatUtility::dieWithError(Message::getHtml());
    //     }
    // }

    public function deleteProduct()
    {
        $this->objPrivilege->canEditProducts();
        $productId = FatApp::getPostedData('productId', FatUtility::VAR_INT, 0);
        if (1 > $productId) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieWithError(Message::getHtml());
        }

        $this->markAsDeleted($productId);
        Product::updateMinPrices($productId);
        $this->set("msg", $this->str_delete_record);
        FatUtility::dieJsonSuccess($this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditProducts();
        $productIdsArr = FatUtility::int(FatApp::getPostedData('record_ids'));

        if (empty($productIdsArr)) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }

        foreach ($productIdsArr as $productId) {
            if (1 > $productId) {
                continue;
            }
            $this->markAsDeleted($productId);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function markAsDeleted($productId)
    {
        $productId = FatUtility::int($productId);
        if (1 > $productId) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }
        $productObj = new Product($productId);

        if (!$productObj->deleteProduct()) {
            Message::addErrorMessage($productObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
    }

    /*

    public function updateUpc($product_id = 0)
    {
        $this->objPrivilege->canEditProducts();
        $product_id = FatUtility::int($product_id);
        if (!$product_id) {
            FatUtility::dieWithError($this->str_invalid_request);
        }

        $post = FatApp::getPostedData();
        if (false === $post || $post['code'] == '') {
            Message::addErrorMessage(Labels::getLabel('MSG_Please_fill_UPC/EAN_code', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        $options = str_replace('|', ',', $post['optionValueId']);

        $srch = UpcCode::getSearchObject();
        $srch->addCondition('upc_product_id', '!=', $product_id);
        $srch->addCondition('upc_code', '=', $post['code']);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if ($row && $row['upc_product_id'] != $product_id) {
            Message::addErrorMessage(Labels::getLabel('MSG_This_UPC/EAN_code_already_assigned_to_another_product', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $srch = UpcCode::getSearchObject();
        $srch->addCondition('upc_product_id', '=', $product_id);
        $srch->addCondition('upc_options', '=', $options);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        $data = array(
            'upc_code' => $post['code'],
            'upc_product_id' => $product_id,
            'upc_options' => $options,
        );

        if ($row && $row['upc_product_id'] == $product_id && $row['upc_options'] == $options) {
            $upcObj = new UpcCode($row['upc_code_id']);
        } else {
            $upcObj = new UpcCode();
        }

        $upcObj->assignValues($data);
        if (!$upcObj->save()) {
            Message::addErrorMessage($upcObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
        Tag::updateProductTagString($product_id);

        $this->set('msg', Labels::getLabel('LBL_Record_Updated_Successfully', $this->siteLangId));
        $this->set('product_id', $product_id);
        $this->set('lang_id', FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1));
        $this->_template->render(false, false, 'json-success.php');
    }

    */

    public function autoCompleteSellerJson()
    {
        $pagesize = applicationConstants::PAGE_SIZE;
        $post = FatApp::getPostedData();
        $srch = User::getSearchObject(true);
        $srch->addCondition('user_is_supplier', '=', applicationConstants::YES);
        $srch->addCondition('credential_active', '=', applicationConstants::ACTIVE);

        $srch->addMultipleFields(array('credential_user_id', 'credential_username', 'credential_email'));

        if ('' != $post['keyword']) {
            $srch->addCondition('credential_username', 'like', '%' . $post['keyword'] . '%');
            $srch->addCondition('credential_email', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $sellers = FatApp::getDb()->fetchAll($rs, 'credential_user_id');

        die(json_encode($sellers));
    }

    public function getTranslatedSpecData()
    {
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $prodSpecName = FatApp::getPostedData('prod_spec_name');
        $prodSpecValue = FatApp::getPostedData('prod_spec_value');

        if (empty($prodSpecName) || empty($prodSpecValue)) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
        }

        $translatedText = $this->translateLangFields(ProdSpecification::DB_TBL_LANG, ['prod_spec_name' => $prodSpecName[$siteDefaultLangId], 'prod_spec_value' => $prodSpecValue[$siteDefaultLangId]]);
        $data = [];
        foreach ($translatedText as $langId => $value) {
            $data[$langId]['prod_spec_name[' . $langId . ']'] = $value['prod_spec_name'];
            $data[$langId]['prod_spec_value[' . $langId . ']'] = $value['prod_spec_value'];
        }
        CommonHelper::jsonEncodeUnicode($data, true);
    }

    public function imageForm(int $productId = 0, $tempProductId = 0)
    {
        $frm = $this->getImageFrm();
        if (1 > $productId) {
            $frm->fill(['file_type' => AttachedFile::FILETYPE_PRODUCT_IMAGE_TEMP, 'product_id' => $tempProductId]);
        } else {
            $frm->fill(['file_type' => AttachedFile::FILETYPE_PRODUCT_IMAGE, 'product_id' => $productId]);
        }

        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    private function getImageFrm()
    {
        $frm = new Form('imageFrm');
        $frm->addSelectBox(Labels::getLabel('FRM_IMAGE_FILE_TYPE', $this->siteLangId), 'option_id', [], '', array(), Labels::getLabel('FRM_FOR_ALL_OPTIONS', $this->siteLangId));
        $languagesAssocArr = Language::getAllNames();
        if (count($languagesAssocArr) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', array(0 => Labels::getLabel('LBL_All_Languages', $this->siteLangId)) + $languagesAssocArr, '', array(), '');
        } else {
            $langId = array_key_first($languagesAssocArr);
            $frm->addHiddenField('', 'lang_id', $langId);
        }
        $frm->addFileUpload(Labels::getLabel('FRM_UPLOAD', $this->siteLangId), 'prod_image');
        $frm->addHtml('', 'images', '');
        $frm->addHiddenField('', 'min_width', 500);
        $frm->addHiddenField('', 'min_height', 500);
        $frm->addHiddenField('', 'product_id');
        $frm->addHiddenField('', 'file_type');

        return $frm;
    }

    public function images($productId, $fileType = 0, $optionId = 0, $langId = 0)
    {
        $productId = FatUtility::int($productId);
        $fileType = FatUtility::int($fileType);
        if (1  > $productId) {
            LibHelper::exitWithError($this->str_invalid_request_id);
        }

        $languages = Language::getAllNames();
        if (count($languages) <= 1) {
            $langId =  array_key_first($languages);
        }

        if ($fileType == AttachedFile::FILETYPE_PRODUCT_IMAGE_TEMP) {
            $images = AttachedFileTemp::getMultipleAttachments($fileType, $productId, $optionId, $langId, (count($languages) <= 1) ? true : false, 0, 0, true);
        } else {
            $fileType = AttachedFile::FILETYPE_PRODUCT_IMAGE;
            if (!Product::getAttributesById($productId, 'product_id')) {
                LibHelper::exitWithError($this->str_invalid_request_id);
            }
            $images = AttachedFile::getMultipleAttachments($fileType, $productId, $optionId, $langId, (count($languages) <= 1) ? true : false, 0, 0, true);
        }

        $this->set('images', $images);
        $this->set('product_id', $productId);
        $this->set('isDefaultLayout', FatApp::getPostedData('isDefaultLayout', FatUtility::VAR_INT, 0));
        $this->set('canEdit', $this->objPrivilege->canEditProducts(0, true));
        $this->_template->render(false, false);
    }

    public function setImageOrder()
    {
        $this->objPrivilege->canEditProducts();
        $post = FatApp::getPostedData();
        $productId = FatUtility::int($post['product_id']);
        $fileType = FatUtility::int($post['file_type']);
        $imageIds = explode('-', $post['ids']);
        $count = 1;
        foreach ($imageIds as $row) {
            $order[$count] = $row;
            $count++;
        }
        $product = new Product();
        if (!$product->updateProdImagesOrder($productId, $fileType, $order)) {
            Message::addErrorMessage($product->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
        $this->set("msg", Labels::getLabel('LBL_Ordered_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function uploadMedia()
    {
        $this->objPrivilege->canEditProducts();
        $post = FatApp::getPostedData();
        if (empty($post)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST_OR_FILE_NOT_SUPPORTED', $this->siteLangId), true);
        }
        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_SELECT_A_FILE', $this->siteLangId), true);
        }

        $productId = $productId = FatUtility::int($post['product_id']);
        $optionId = FatUtility::int($post['option_id']);
        $fileType = FatUtility::int($post['file_type']);
        if (!in_array($fileType, [AttachedFile::FILETYPE_PRODUCT_IMAGE, AttachedFile::FILETYPE_PRODUCT_IMAGE_TEMP])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (1 > $productId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $langId = FatUtility::int($post['lang_id']);
        } else {
            $langId = array_key_first($languages);
        }

        if ($fileType == AttachedFile::FILETYPE_PRODUCT_IMAGE_TEMP) {
            $fileHandlerObj = new AttachedFileTemp();
            $fileHandlerObj->setDownloadedAttr(true);
        } else {
            $fileHandlerObj = new AttachedFile();
        }
        if (!$fileHandlerObj->saveImage($_FILES['cropped_image']['tmp_name'], $fileType, $productId, $optionId, $_FILES['cropped_image']['name'], -1, false, $langId)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        if (AttachedFile::FILETYPE_PRODUCT_IMAGE ==  $fileType) {
            FatApp::getDb()->updateFromArray('tbl_products', array('product_image_updated_on' => date('Y-m-d H:i:s')), array('smt' => 'product_id = ?', 'vals' => array($productId)));
        }

        if (count($languages) > 1) {
            $this->set("isDefaultLayout", $langId == 0 &&  $optionId == 0);
        } else {
            $this->set("isDefaultLayout", $langId == CommonHelper::getDefaultFormLangId() &&  $optionId == 0);
        }

        $this->set("lang_id", $langId);
        $this->set("option_id", $optionId);
        $this->set("product_id", $productId);
        $this->set("file_type", $fileType);
        $this->set("msg", Labels::getLabel('MSG_FILE_UPLOADED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteImage($productId, $imageId, $fileType)
    {
        $this->objPrivilege->canEditProducts();
        $productId = FatUtility::int($productId);
        $imageId = FatUtility::int($imageId);
        $fileType = FatUtility::int($fileType);

        if (1 > $imageId || 1 > $productId  || 1 > $fileType) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if ($fileType == AttachedFile::FILETYPE_PRODUCT_IMAGE_TEMP) {
            $fileHandlerObj = new AttachedFileTemp();
        } else {
            $fileHandlerObj = new AttachedFile();
        }

        $data = $fileHandlerObj::getAttributesById($imageId, ['afile_lang_id', 'afile_record_subid']);
        if (false == $data) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $productObj = new Product();
        if (!$productObj->deleteProductImage($productId, $imageId, $fileType)) {
            LibHelper::exitWithError($productObj->getError(), true);
        }

        FatApp::getDb()->updateFromArray('tbl_products', array('product_image_updated_on' => date('Y-m-d H:i:s')), array('smt' => 'product_id = ?', 'vals' => array($productId)));
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $this->set("isDefaultLayout", $data['afile_lang_id'] == 0 &&  $data['afile_record_subid'] == 0);
        } else {
            $this->set("isDefaultLayout", $data['afile_lang_id'] == CommonHelper::getDefaultFormLangId() &&  $data['afile_record_subid'] == 0);
        }
        $this->set("optionId", $data['afile_record_subid']);
        $this->set("langId", $data['afile_lang_id']);
        $this->set("msg", $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function productInitialSetUpFrm($productId, $prodCatId = 0)
    {
        $this->objPrivilege->canEditProducts();
        $productId = FatUtility::int($productId);
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $languages = Language::getAllNames();
        $productFrm = $this->getProductIntialSetUpFrm($productId, $prodCatId);
        $productType = Product::PRODUCT_TYPE_PHYSICAL;
        $attachDownloadsWithInv = 0;
        if ($productId > 0) {
            $prodData = Product::getAttributesById($productId);
            foreach ($languages as $langId => $data) {
                $prod = new Product();
                $productLangData = $prod->getAttributesByLangId($langId, $productId);
                if (!empty($productLangData)) {
                    $prodData['product_name'][$langId] = $productLangData['product_name'];
                    $prodData['product_youtube_video'][$langId] = $productLangData['product_youtube_video'];
                    $prodData['product_description_' . $langId] = $productLangData['product_description'];
                }
            }

            $taxData = array();
            $tax = Tax::getTaxCatObjByProductId($productId, $this->siteLangId);
            if ($prodData['product_seller_id'] > 0) {
                $tax->addCondition('ptt_seller_user_id', '=', $prodData['product_seller_id']);
            } else {
                $tax->addCondition('ptt_seller_user_id', '=', 0);
            }

            $tax->addFld('ptt_taxcat_id');

            if (Tax::getActivatedServiceId()) {
                $tax->addFld('concat(IFNULL(taxcat_name,taxcat_identifier), " (",taxcat_code,")")as taxcat_name');
            } else {
                $tax->addFld('IFNULL(taxcat_name,taxcat_identifier)as taxcat_name');
            }

            $tax->doNotCalculateRecords();
            $tax->setPageSize(1);
            $tax->addOrder('ptt_seller_user_id', 'ASC');
            $tax->doNotCalculateRecords();
            $tax->setPageSize(1);
            $rs = $tax->getResultSet();
            $taxData = FatApp::getDb()->fetch($rs);
            if (!empty($taxData)) {
                $prodData['ptt_taxcat_id'] = $taxData['ptt_taxcat_id'];
                $prodData['taxcat_name'] = $taxData['taxcat_name'];
            }

            $srch = Product::getSearchObject($this->siteLangId);
            $srch->joinTable(Brand::DB_TBL, 'LEFT OUTER JOIN', 'tp.product_brand_id = brand.brand_id', 'brand');
            $srch->joinTable(Brand::DB_TBL_LANG, 'LEFT OUTER JOIN', 'brandlang_brand_id = brand.brand_id AND brandlang_lang_id = ' . $this->siteLangId);
            $srch->addMultipleFields(array('product_brand_id', 'IFNULL(brand_name,brand_identifier) as brand_name', 'IFNULL(brand.brand_active,1) AS brand_active', 'IFNULL(brand.brand_deleted,0) AS brand_deleted'));
            $srch->addCondition('product_id', '=', $productId);
            $srch->addHaving('brand_active', '=', applicationConstants::YES);
            $srch->addHaving('brand_deleted', '=', applicationConstants::NO);
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $rs = $srch->getResultSet();
            $brandData = FatApp::getDb()->fetch($rs);
            if (!empty($brandData)) {
                $prodData['product_brand_id'] = $brandData['product_brand_id'];
                $prodData['brand_name'] = $brandData['brand_name'];
            }

            $prod = new Product();
            $productCategories = $prod->getProductCategories($productId);
            if (!empty($productCategories)) {
                $selectedCat = array_keys($productCategories);
                $prodCat = new ProductCategory();
                $selectedCatName = $prodCat->getParentTreeStructure($selectedCat[0], 0, '', $this->siteLangId);
                $prodData['category_name'] = html_entity_decode($selectedCatName);
                $prodData['ptc_prodcat_id'] = $selectedCat[0];
            }

            $productFrm->fill($prodData);

            $productType = $prodData['product_type'];

            $attachDownloadsWithInv = $prodData['product_attachements_with_inventory'];
        }

        unset($languages[$siteDefaultLangId]);
        $this->set('productFrm', $productFrm);
        $this->set('siteDefaultLangId', $siteDefaultLangId);
        $this->set('otherLanguages', $languages);
        $this->set('prodCatId', $prodCatId);
        $this->set('productType', $productType);
        $this->set('attachDownloadsWithInv', $attachDownloadsWithInv);
        $this->_template->render(false, false, 'products/product-initial-setup-frm.php');
    }

    private function getProductIntialSetUpFrm($productId, $prodCatId = 0)
    {
        $prodCatId = FatUtility::int($prodCatId);
        $frm = new Form('frmProductIntialSetUp');
        $frm->addRequiredField(Labels::getLabel('LBL_Product_Identifier', $this->siteLangId), 'product_identifier');
        $frm->addSelectBox(Labels::getLabel('LBL_Product_Type', $this->siteLangId), 'product_type', Product::getProductTypes($this->siteLangId), Product::PRODUCT_TYPE_PHYSICAL, array(), '');

        $frm->addSelectBox(Labels::getLabel('LBL_Product_Download_attachements_at_inventory_level', $this->siteLangId), 'product_attachements_with_inventory', applicationConstants::getYesNoArr($this->siteLangId), '', array(), '');

        $downloadAttachementsWithInventoryTrue = new FormFieldRequirement('product_attachements_with_inventory', 'value');
        $downloadAttachementsWithInventoryTrue->setRequired();
        $downloadAttachementsWithInventoryFalse = new FormFieldRequirement('product_attachements_with_inventory', 'value');
        $downloadAttachementsWithInventoryFalse->setRequired(false);

        $prodTypeFld = $frm->getField('product_type');
        $prodTypeFld->requirements()->addOnChangerequirementUpdate(applicationConstants::YES, 'eq', 'product_attachements_with_inventory', $downloadAttachementsWithInventoryTrue);
        $prodTypeFld->requirements()->addOnChangerequirementUpdate(applicationConstants::NO, 'eq', 'product_attachements_with_inventory', $downloadAttachementsWithInventoryFalse);

        $brandFld = $frm->addTextBox(Labels::getLabel('LBL_Brand', $this->siteLangId), 'brand_name');
        if (FatApp::getConfig("CONF_PRODUCT_BRAND_MANDATORY", FatUtility::VAR_INT, 1)) {
            $brandFld->requirements()->setRequired();
        }
        if ($prodCatId > 0) {
            $prodCat = new ProductCategory();
            $selectedCatName = $prodCat->getParentTreeStructure($prodCatId, 0, '', $this->siteLangId);
            $prodCatName = html_entity_decode($selectedCatName);
            $frm->addRequiredField(Labels::getLabel('LBL_Category', $this->siteLangId), 'category_name', $prodCatName);
        } else {
            $frm->addRequiredField(Labels::getLabel('LBL_Category', $this->siteLangId), 'category_name');
        }
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $lang) {
            if ($langId == $siteDefaultLangId) {
                $frm->addRequiredField(Labels::getLabel('LBL_Product_Name', $this->siteLangId), 'product_name[' . $langId . ']');
            } else {
                $frm->addTextBox(Labels::getLabel('LBL_Product_Name', $this->siteLangId), 'product_name[' . $langId . ']');
            }
            //$frm->addTextArea(Labels::getLabel('LBL_Description', $this->siteLangId), 'product_description['.$langId.']');
            $frm->addHtmlEditor(Labels::getLabel('LBL_Description', $this->siteLangId), 'product_description_' . $langId);
            $frm->addTextBox(Labels::getLabel('LBL_Youtube_Video_Url', $this->siteLangId), 'product_youtube_video[' . $langId . ']');
        }

        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        unset($languages[$siteDefaultLangId]);
        if (!empty($translatorSubscriptionKey) && count($languages) > 0) {
            $frm->addCheckBox(Labels::getLabel('LBL_Translate_To_Other_Languages', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        $fldMinSelPrice = $frm->addFloatField(Labels::getLabel('LBL_Minimum_Selling_Price', $this->siteLangId) . ' [' . CommonHelper::getCurrencySymbol(true) . ']', 'product_min_selling_price', '');
        $fldMinSelPrice->requirements()->setPositive();

        $approveUnApproveArr = Product::getApproveUnApproveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Approval_Status', $this->siteLangId), 'product_approved', $approveUnApproveArr, Product::APPROVED, array(), '');

        $frm->addHiddenField('', 'product_id', $productId);
        $frm->addHiddenField('', 'product_brand_id');
        $frm->addHiddenField('', 'ptt_taxcat_id');
        $frm->addHiddenField('', 'ptc_prodcat_id', $prodCatId);
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_And_Next', $this->siteLangId));
        $frm->addButton("", "btn_discard", Labels::getLabel('LBL_Discard', $this->siteLangId));
        return $frm;
    }

    public function setUpProduct()
    {
        $this->objPrivilege->canEditProducts();
        $productId = FatApp::getPostedData('product_id', FatUtility::VAR_INT, 0);
        $frm = $this->getProductIntialSetUpFrm($productId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieWithError(Message::getHtml());
        }
        if ($post['product_brand_id'] < 1 && FatApp::getConfig("CONF_PRODUCT_BRAND_MANDATORY", FatUtility::VAR_INT, 1)) {
            Message::addErrorMessage(Labels::getLabel('MSG_Please_Choose_Brand_From_List', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        if ($post['ptc_prodcat_id'] < 1) {
            Message::addErrorMessage(Labels::getLabel('MSG_Please_Choose_Category_From_List', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        /* sendApprovalStatusUpdate to seller */
        $sendApprovalStatusUpdate = false;
        if (0 < $productId) {
            $oldProductData = Product::getAttributesById($productId, ['product_approved', 'product_seller_id']);
            if (0 < $oldProductData['product_seller_id'] && $oldProductData['product_approved'] != $post['product_approved']) {
                $sendApprovalStatusUpdate = true;
            }
        }


        /* TODO:
            1) in case productid > 0 (edit product) need to check
                a) product_attachements_with_inventory is yes and attachments/links added with product catalog then return with error to remove the links/files first.
                b) a) product_attachements_with_inventory is no and attachments/links added with inventory then return with error to remove the links/files first.
        */

        if ($post['product_attachements_with_inventory'] < 0 || $post['product_attachements_with_inventory'] > 1) {
            $post['product_attachements_with_inventory'] = 0;
        }

        $prod = new Product($productId);
        if (!$prod->saveProductData($post)) {
            Message::addErrorMessage($prod->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
        Product::updateMinPrices($productId);

        if (!$prod->saveProductLangData($post)) {
            Message::addErrorMessage($prod->getError());
            FatUtility::dieWithError(Message::getHtml());
        }

        if (true == $sendApprovalStatusUpdate) {
            $email = new EmailHandler();
            $emailData['status'] = $post['product_approved'];
            $emailData['product_name'] = !empty($post['product_name' . $this->siteLangId]) ? $post['product_name' . $this->siteLangId] : $post['product_identifier'];
            $emailData['seller_id'] = $oldProductData['product_seller_id'];

            if (!$email->sendCatalogRequestStatusChangeNotification($this->siteLangId, $emailData)) {
                Message::addErrorMessage(Labels::getLabel('LBL_Email_Could_Not_Be_Sent', $this->siteLangId));
                FatUtility::dieWithError(Message::getHtml());
            }
        }

        if (!$prod->saveProductCategory($post['ptc_prodcat_id'])) {
            Message::addErrorMessage($prod->getError());
            FatUtility::dieWithError(Message::getHtml());
        }

        $productSellerId = Product::getAttributesById($productId, 'product_seller_id');
        if (!$productSellerId) {
            $productSellerId = 0;
        }
        if (!$prod->saveProductTax($post['ptt_taxcat_id'], $productSellerId)) {
            Message::addErrorMessage($prod->getError());
            FatUtility::dieWithError(Message::getHtml());
        }

        $this->set('msg', Labels::getLabel('LBL_Product_Setup_Successful', $this->siteLangId));
        $this->set('productId', $prod->getMainTableRecordId());
        $this->set('productType', $post['product_type']);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function productAttributeAndSpecificationsFrm($productId)
    {
        $this->objPrivilege->canEditProducts();
        $productId = FatUtility::int($productId);
        if ($productId < 1) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieWithError(Message::getHtml());
        }
        $productFrm = $this->getProductAttributeAndSpecificationsFrm($productId);

        $productData = Product::getAttributesById($productId);
        $prodShippingDetails = Product::getProductShippingDetails($productId, $this->siteLangId, $productData['product_seller_id']);
        $productData['ps_free'] = isset($prodShippingDetails['ps_free']) ? $prodShippingDetails['ps_free'] : 0;
        if ($productData['product_seller_id'] > 0) {
            $userShopName = User::getUserShopName($productData['product_seller_id'], $this->siteLangId);
            $productData['selprod_user_shop_name'] = $userShopName['user_name'] . ' - ' . $userShopName['shop_identifier'];
        } else {
            $productData['selprod_user_shop_name'] = 'Admin';
        }
        $prodSpecificsDetails = Product::getProductSpecificsDetails($productId);
        $productData['product_warranty'] = isset($prodSpecificsDetails['product_warranty']) ? $prodSpecificsDetails['product_warranty'] : 0;
        $productFrm->fill($productData);

        $totalProducts = Product::getCatalogProductCount($productId);
        $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $languages = Language::getAllNames();
        unset($languages[$siteDefaultLangId]);

        $this->set('productFrm', $productFrm);
        $this->set('productData', $productData);
        $this->set('totalProducts', $totalProducts);
        $this->set('siteDefaultLangId', $siteDefaultLangId);
        $this->set('otherLanguages', $languages);
        $this->_template->render(false, false, 'products/product-attribute-and-specifications-frm.php');
    }

    private function getProductAttributeAndSpecificationsFrm($productId)
    {
        $frm = new Form('frmProductAttributeAndSpecifications');
        $frm->addTextBox(Labels::getLabel('LBL_User', $this->siteLangId), 'selprod_user_shop_name');
        $fldModel = $frm->addTextBox(Labels::getLabel('LBL_Model', $this->siteLangId), 'product_model');
        if (FatApp::getConfig("CONF_PRODUCT_MODEL_MANDATORY", FatUtility::VAR_INT, 1)) {
            $fldModel->requirements()->setRequired();
        }
        $warrantyFld = $frm->addRequiredField(Labels::getLabel('LBL_PRODUCT_WARRANTY', $this->siteLangId), 'product_warranty');
        $warrantyFld->requirements()->setInt();
        $warrantyFld->requirements()->setPositive();


        $productType = Product::getAttributesById($productId, 'product_type');
        if ($productType == Product::PRODUCT_TYPE_DIGITAL) {
            $warrantyFld->requirements()->setRequired(false);
        }

        $frm->addHiddenField('', 'product_seller_id');
        $frm->addHiddenField('', 'product_id', $productId);
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_And_Next', $this->siteLangId));
        $frm->addButton("", "btn_back", Labels::getLabel('LBL_Back', $this->siteLangId), array('onclick' => 'productInitialSetUpFrm(' . $productId . ');'));
        return $frm;
    }

    public function setUpProductAttributes()
    {
        $this->objPrivilege->canEditProducts();
        $productId = FatApp::getPostedData('product_id', FatUtility::VAR_INT, 0);
        $frm = $this->getProductAttributeAndSpecificationsFrm($productId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieWithError(Message::getHtml());
        }

        $prod = new Product($productId);
        if (!$prod->saveProductData($post)) {
            Message::addErrorMessage($prod->getError());
            FatUtility::dieWithError(Message::getHtml());
        }

        $post['ps_product_id'] = $productId;
        $productSpecifics = new ProductSpecifics($productId);
        $productSpecifics->assignValues($post);
        $data = $productSpecifics->getFlds();
        if (!$productSpecifics->addNew(array(), $data)) {
            Message::addErrorMessage($productSpecifics->getError());
            FatUtility::dieWithError(Message::getHtml());
        }

        /*  $productType = Product::getAttributesById($productId, 'product_type');
         if ($productType == Product::PRODUCT_TYPE_PHYSICAL) {
             $psFree = isset($post['ps_free']) ? $post['ps_free'] : 0;
             $psFromCountryId = 0;
             $prodShippingDetails = Product::getProductShippingDetails($productId, $this->siteLangId, $post['product_seller_id']);
             if (!empty($prodShippingDetails)) {
                 $psFromCountryId = $prodShippingDetails['ps_from_country_id'];
             }
             if (!$prod->saveProductSellerShipping($post['product_seller_id'], $psFree, $psFromCountryId)) {
                 Message::addErrorMessage($prod->getError());
                 FatUtility::dieWithError(Message::getHtml());
             }
         } */

        $this->set('msg', Labels::getLabel('LBL_Product_Attributes_Setup_Successful', $this->siteLangId));
        $this->set('productId', $prod->getMainTableRecordId());
        $this->_template->render(false, false, 'json-success.php');
    }

    public function prodSpecificationFrm($productId)
    {
        $this->objPrivilege->canEditProducts();
        $productId = FatUtility::int($productId);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        $prodSpecId = FatApp::getPostedData('prodSpecId', FatUtility::VAR_INT, 0);
        if ($productId < 1 || $langId < 1) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieWithError(Message::getHtml());
        }

        $prodSpecData = array();
        if ($prodSpecId > 0) {
            $prodSpec = new ProdSpecification();
            $prodSpecData = $prodSpec->getProdSpecification($prodSpecId, $productId, $langId, false);
        }

        $this->set('langId', $langId);
        $this->set('prodSpecData', $prodSpecData);
        $this->_template->render(false, false, 'products/prod-specification-form.php');
    }

    public function prodSpecifications()
    {
        $productId = FatApp::getPostedData('product_id', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        if (1 > $langId) {
            $langId = CommonHelper::getDefaultFormLangId();
        }
        $productSpecifications =  [];
        if (0 < $productId) {
            $prod = new Product($productId);
            $productSpecifications = $prod->getProdSpecificationsByLangId($langId);
        }
        $this->set('productSpecifications', $productSpecifications);
        $this->set('langId', $langId);
        $this->_template->render(false, false);
    }

    public function setUpProductSpecifications()
    {
        $this->objPrivilege->canEditProducts();
        $post = FatApp::getPostedData();
        $productId = FatApp::getPostedData('product_id', FatUtility::VAR_INT, 0);
        if ($productId < 1) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieJsonError(Message::getHtml());
        }
        $prod = new Product($productId);
        if (!$prod->saveProductSpecifications($post['prodSpecId'], $post['langId'], $post['prodspec_name'], $post['prodspec_value'], $post['prodspec_group'])) {
            Message::addErrorMessage($prod->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
        $this->set('msg', Labels::getLabel('LBL_Specification_added_successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteProdSpec()
    {
        $this->objPrivilege->canEditProducts();
        $prodSpecId = FatApp::getPostedData('prodSpecId', FatUtility::VAR_INT, 0);
        if ($prodSpecId < 1) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $prodSpec = new ProdSpecification($prodSpecId);
        if (!$prodSpec->deleteRecord(true)) {
            LibHelper::exitWithError($prodSpec->getError(), true);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    // public function productOptionsAndTag($productId)
    // {
    //     $this->objPrivilege->canEditProducts();
    //     $productId = FatUtility::int($productId);
    //     if ($productId < 1) {
    //         Message::addErrorMessage($this->str_invalid_request);
    //         FatUtility::dieWithError(Message::getHtml());
    //     }
    //     $productTags = Product::getProductTags($productId);
    //     $productOptions = Product::getProductOptions($productId, $this->siteLangId);
    //     $productType = Product::getAttributesById($productId, 'product_type');
    //     $this->set('productTags', $productTags);
    //     $this->set('productOptions', $productOptions);
    //     $this->set('productId', $productId);
    //     $this->set('productType', $productType);
    //     $this->_template->render(false, false, 'products/product-options-and-tag.php');
    // }

    public function upcListing($productId = 76)
    {
        $productId = FatUtility::int($productId);
        if ($productId < 1) {
            FatUtility::dieWithError($this->str_invalid_request);
        }

        $productId = FatApp::getPostedData('productId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        $productOptions = FatApp::getPostedData('productOptions');

        $type = FatApp::getPostedData('type', FatUtility::VAR_INT, 0);

        $upcCodeData = [];
        if (0 < $productId) {
            $srch = UpcCode::getSearchObject();
            $srch->addCondition('upc_product_id', '=', $productId);
            $srch->doNotCalculateRecords();
            $upcCodeData = FatApp::getDb()->fetchAll($srch->getResultSet(), 'upc_options');
        }

        $optionCombinations = [];
        if ($type == applicationConstants::YES && is_array($productOptions)) {
            $optionCombinations = CommonHelper::combinationOfElementsOfArr($productOptions, 'optionValues');
        }
        // $productOptions = Product::getProductOptions($productId, $this->siteLangId, true);

        $this->set('optionCombinations', $optionCombinations);
        $this->set('upcCodeData', $upcCodeData);
        $this->set('productId', $productId);
        $this->set('langId', $langId);
        $this->_template->render(false, false);
    }

    public function productShippingFrm($productId)
    {
        $this->objPrivilege->canEditProducts();
        $productId = FatUtility::int($productId);
        if ($productId < 1) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieWithError(Message::getHtml());
        }

        $productData = Product::getAttributesById($productId);
        $shippedByUserId = $productData['product_seller_id'];
        if (FatApp::getConfig('CONF_SHIPPED_BY_ADMIN_ONLY', FatUtility::VAR_INT, 0)) {
            $shippedByUserId = 0;
        }

        $productFrm = $this->getProductShippingFrm($productId, $shippedByUserId);

        $prodShippingDetails = Product::getProductShippingDetails($productId, $this->siteLangId, $shippedByUserId);
        if (isset($prodShippingDetails['ps_from_country_id'])) {
            $productData['shipping_country'] = Countries::getCountryById($prodShippingDetails['ps_from_country_id'], $this->siteLangId, 'country_name');
            $productData['ps_from_country_id'] = $prodShippingDetails['ps_from_country_id'];
        }
        $productData['ps_free'] = isset($prodShippingDetails['ps_free']) ? $prodShippingDetails['ps_free'] : 0;

        /* [ GET ATTACHED PROFILE ID */
        $profSrch = ShippingProfileProduct::getSearchObject();
        $profSrch->addCondition('shippro_product_id', '=', $productId);
        $profSrch->addCondition('shippro_user_id', '=', $shippedByUserId);
        $profSrch->doNotCalculateRecords();
        $profSrch->setPageSize(1);
        $proRs = $profSrch->getResultSet();
        $profileData = FatApp::getDb()->fetch($proRs);
        if (!empty($profileData)) {
            $productData['shipping_profile'] = $profileData['profile_id'];
        }
        /* ]*/

        $productFrm->fill($productData);
        $this->set('productFrm', $productFrm);
        $this->set('shippedByUserId', $shippedByUserId);
        $this->_template->render(false, false, 'products/product-shipping-frm.php');
    }

    private function getProductShippingFrm($productId, $shippedByUserId = 0)
    {
        $frm = new Form('frmProductShipping');
        $productData = Product::getAttributesById($productId, ['product_type', 'product_seller_id']);


        $frm->addHiddenField('', 'product_id', $productId);
        $frm->addButton("", "btn_back", Labels::getLabel('LBL_Back', $this->siteLangId), array('onclick' => 'productOptionsAndTag(' . $productId . ');'));
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_And_Next', $this->siteLangId));
        return $frm;
    }

    public function setUpProductShipping()
    {
        $this->objPrivilege->canEditProducts();
        $productId = FatApp::getPostedData('product_id', FatUtility::VAR_INT, 0);

        $productData = Product::getAttributesById($productId, ['product_seller_id', 'product_type']);
        if (empty($productData)) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieWithError(Message::getHtml());
        }
        if (Product::PRODUCT_TYPE_DIGITAL == $productData['product_type']) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_DIGITAL_PRODUCTS_ARE_NOT_ALLOWED', $this->siteLangId));
        }
        $shippedByUserId = $productData['product_seller_id'];
        if (FatApp::getConfig('CONF_SHIPPED_BY_ADMIN_ONLY', FatUtility::VAR_INT, 0)) {
            $shippedByUserId = 0;
        }

        $frm = $this->getProductShippingFrm($productId, $shippedByUserId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieWithError(Message::getHtml());
        }

        $prod = new Product($productId);
        if (!$prod->saveProductData($post)) {
            Message::addErrorMessage($prod->getError());
            FatUtility::dieWithError(Message::getHtml());
        }

        $psFree = isset($post['ps_free']) ? $post['ps_free'] : 0;

        if (!$prod->saveProductSellerShipping($productData['product_seller_id'], $psFree, $post['ps_from_country_id'])) {
            Message::addErrorMessage($prod->getError());
            FatUtility::dieWithError(Message::getHtml());
        }

        if (isset($post['shipping_profile'])) {
            $shipProProdData = array(
                'shippro_shipprofile_id' => !empty($post['shipping_profile']) ? $post['shipping_profile'] : ShippingProfile::getDefaultProfileId($productData['product_seller_id']),
                'shippro_product_id' => $productId
            );
            $spObj = new ShippingProfileProduct();
            if (!$spObj->addProduct($shipProProdData)) {
                Message::addErrorMessage($spObj->getError());
                FatUtility::dieJsonError(Message::getHtml());
            }
        }

        $this->set('msg', Labels::getLabel('LBL_Product_Shipping_Setup_Successful', $this->siteLangId));
        $this->set('productId', $prod->getMainTableRecordId());
        $this->_template->render(false, false, 'json-success.php');
    }

    public function translatedProductData()
    {
        $prodName = FatApp::getPostedData('product_name', FatUtility::VAR_STRING, '');
        $prodDesc = FatApp::getPostedData('product_description', FatUtility::VAR_STRING, '');
        $toLangId = FatApp::getPostedData('toLangId', FatUtility::VAR_INT, 0);
        $data = array(
            'product_name' => $prodName,
            'product_description' => $prodDesc,
        );
        $product = new Product();
        $translatedData = $product->getTranslatedProductData($data, $toLangId);
        if (!$translatedData) {
            Message::addErrorMessage($product->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
        $this->set('productName', $translatedData[$toLangId]['product_name']);
        $this->set('productDesc', $translatedData[$toLangId]['product_description']);
        $this->set('msg', Labels::getLabel('LBL_Product_Data_Translated_Successful', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function prodSpecGroupAutoComplete()
    {
        $post = FatApp::getPostedData();
        $srch = ProdSpecification::getSearchObject($post['langId'], false);
        if (!empty($post['keyword'])) {
            $srch->addCondition('prodspec_group', 'LIKE', '%' . $post['keyword'] . '%');
        }
        $srch->setPageSize(FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        $srch->addMultipleFields(array('DISTINCT(prodspec_group)'));
        $rs = $srch->getResultSet();
        $prodSpecGroup = FatApp::getDb()->fetchAll($rs);
        $json = array();
        foreach ($prodSpecGroup as $key => $group) {
            $json[] = array(
                'name' => strip_tags(html_entity_decode($group['prodspec_group'], ENT_QUOTES, 'UTF-8'))
            );
        }
        die(json_encode($json));
    }

    public function digitalDownloadForm($productId, $type)
    {

        $this->objPrivilege->canEditProducts();

        $productId = FatUtility::int($productId);
        if (1 > $productId) {
            LibHelper::exitWithError($this->str_invalid_request_id);
        }

        $productType = Product::getAttributesById($productId, 'product_type');
        if ($productType == false || $productType != Product::PRODUCT_TYPE_DIGITAL) {
            LibHelper::exitWithError($this->str_invalid_request_id);
        }

        if (!array_key_exists($type, applicationConstants::digitalDownloadTypeArr($this->siteLangId))) {
            LibHelper::exitWithError($this->str_invalid_request);
        }

        $frm = DigitalDownload::getDownloadForm($this->siteLangId, $type, $productId);

        $productOptions = Product::getProductOptions($productId, $this->siteLangId, true);
        $optionCombinations = CommonHelper::combinationOfElementsOfArr($productOptions, 'optionValues', '_');

        $fld = $frm->getField('option_comb_id');
        if (1 > count($optionCombinations)) {
            $frm->removeField($fld);
        } else {
            $optionCombinations = array('0' => Labels::getLabel('LBL_All', $this->siteLangId)) + $optionCombinations;
            $fld->options = $optionCombinations;
        }


        // $frmData = [
        //     'product_id' => $productId
        // ];

        // if (1 <= $linkId) {
        //     $linkDetail = DigitalDownloadSearch::getLinkDetail($linkId);

        //     $frmData['download_type'] = applicationConstants::DIGITAL_DOWNLOAD_LINK;
        //     if (!empty($linkDetail)) {
        //         $frmData['dd_link_id'] = $linkId;
        //         $frmData['dd_link_ref_id'] = $linkDetail['pddr_id'];
        //         $frmData['option_comb_id'] = $linkDetail['pddr_options_code'];
        //         $frmData['lang_id'] = $linkDetail['pdl_lang_id'];
        //         $frmData['product_downloadable_link'] = $linkDetail['pdl_download_link'];
        //         $frmData['product_preview_link'] = $linkDetail['pdl_preview_link'];
        //         $fld = $frm->getField('attachment_link_btn');
        //         $fld->value = Labels::getLabel('LBL_Update', $this->siteLangId);
        //     } else {
        //         $msg = 'Invalid Link. Please refresh to get latest list!!!';
        //     }
        // }
        // $frm->fill($frmData);

        $this->set('frm', $frm);
        $this->set('type', $type);
        //$this->set('canDo', $canDo);
        //$this->_template->render(false, false, 'products/download-setup-frm.php');
        $this->_template->render(false, false);
    }

    public function setupDigitalDownload()
    {
        $this->objPrivilege->canEditProducts();  

        $productId = FatApp::getPostedData('record_id', FatUtility::VAR_INT, 0);
        $type = FatApp::getPostedData('download_type', FatUtility::VAR_INT, 0);

        if (1 > $productId) {
            LibHelper::exitWithError($this->str_invalid_request_id);
        }

        $productType = Product::getAttributesById($productId, 'product_type');
        if ($productType == false || $productType != Product::PRODUCT_TYPE_DIGITAL) {
            LibHelper::exitWithError($this->str_invalid_request);
        }

        if (!array_key_exists($type, applicationConstants::digitalDownloadTypeArr($this->siteLangId))) {
            LibHelper::exitWithError($this->str_invalid_request);
        }

        $frm = DigitalDownload::getDownloadForm($this->siteLangId, $type, $productId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()));
        }

        $ddpObj = new DigitalDownloadPrivilages();

        $canDo = $ddpObj->canEdit($productId, Product::CATALOG_TYPE_PRIMARY, 0, $this->siteLangId, false, true);
        if (false == $canDo) {
            LibHelper::exitWithError($ddpObj->getError());
        }

        $optionValId = FatApp::getPostedData('option_comb_id', null, 0);

        $ddObj = new DigitalDownload();
        $refId = $ddObj->getReferenceId($productId, $optionValId);
        if (1 > $refId) {
            if (!$ddObj->saveReference($productId, $optionValId)) {
                LibHelper::exitWithError($ddObj->getError());
            }
        }else{
            $ddObj->setMainTableRecordId($refId);
        }

        if (applicationConstants::DIGITAL_DOWNLOAD_LINK == $type) {
            $this->setupDigitalLink($ddObj, $post);
        } else {
            $this->setupDigitalFile($ddObj, $post);
        }
    }

    private function setupDigitalFile($ddObj, $post)
    {
        if ((!isset($_FILES['downloadable_file']['tmp_name']) || !is_uploaded_file($_FILES['downloadable_file']['tmp_name']))
            && (!isset($_FILES['preview_file']['tmp_name']) || !is_uploaded_file($_FILES['preview_file']['tmp_name']))
        ) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_PLEASE_SELECT_A_FILE', $this->siteLangId));
        }

        $langId = FatUtility::int($post['lang_id']);
        $isPreview = FatUtility::int($post['is_preview']);
        $refFileId = FatUtility::int($post['ref_file_id']);
        $mainFileId = 0;
        if (1 == $isPreview) {
            if (array_key_exists('downloadable_file', $_FILES)) {
                unset($_FILES['downloadable_file']);
            }
            $mainFileId = $refFileId;
        }

        if (
            isset($_FILES['downloadable_file']['tmp_name'])
            && is_uploaded_file($_FILES['downloadable_file']['tmp_name'])
        ) {
            $mainFileId = $this->setupDigitalMainFile($ddObj, $langId);
            if (1 > $mainFileId) {
                FatUtility::dieJsonError($ddObj->getError());
            }

            $attachWithExistingOrders = $post['attach_with_existing_orders'];
            if (1 === $attachWithExistingOrders) {
                $optionComb = FatUtility::int($post['option_comb_id']);
                $ddObj->attachFileWithOrderedProducts($mainFileId, $post['record_id'], Product::CATALOG_TYPE_PRIMARY, $langId, $optionComb);
            }
        }

        if (
            isset($_FILES['preview_file']['tmp_name'])
            && is_uploaded_file($_FILES['preview_file']['tmp_name'])
        ) {
            if (1 > $this->setupDigitalPreviewFile($ddObj, $langId, $mainFileId)) {
                FatUtility::dieJsonError($ddObj->getError());
            }
        }
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function setupDigitalMainFile($ddObj, $langId)
    {
        $fileId = $ddObj->saveAttachment(
            $_FILES['downloadable_file']['tmp_name'],
            $_FILES['downloadable_file']['name'],
            $ddObj->getMainTableRecordId(),
            0,
            $langId
        );
        if (1 > $fileId) {
            return 0;
        }

        return $fileId;
    }

    private function setupDigitalPreviewFile($ddObj, $langId, $mainFileId = 0)
    {
        $fileId = $ddObj->saveAttachment(
            $_FILES['preview_file']['tmp_name'],
            $_FILES['preview_file']['name'],
            $ddObj->getMainTableRecordId(),
            $mainFileId,
            $langId,
            true
        );

        if (1 > $fileId) {
            return 0;
        }

        return $fileId;
    }

    private function setupDigitalLink($ddObj, $post)
    {
        $downloadLink = FatApp::getPostedData('product_downloadable_link', null, '');
        $previewLink = FatApp::getPostedData('product_preview_link', null, '');

        if ('' == $post['product_downloadable_link'] && '' == $post['product_preview_link']) {     
            FatUtility::dieJsonError(Labels::getLabel('ERR_PLEASE_ADD_LINK', $this->siteLangId));         
        }

        $langId = FatUtility::int($post['lang_id']);
        $ddLinkId = FatUtility::int($post['dd_link_id']);
        $ddRefId = FatUtility::int($post['dd_link_ref_id']);

        if (!$ddObj->saveLink($langId, $downloadLink, $previewLink, $ddLinkId)) {
            FatUtility::dieJsonError($ddObj->getError());
        }

        if (1 <= $ddLinkId) {
            $totalLinksCount = DigitalDownloadSearch::getTotalLinksCount($ddRefId);
            $totalAttachmentCount = DigitalDownloadSearch::getTotalAttachmentsCount($ddRefId);
            if (1 > $totalLinksCount && 1 > $totalAttachmentCount) {
                $ddObj->deleteReference($ddRefId);
            }
        }
        $optionComb = FatUtility::int($post['option_comb_id']);
        $attachWithExistingOrders = FatUtility::int($post['attach_with_existing_orders']);
        if ($attachWithExistingOrders == applicationConstants::YES && '' != $downloadLink) {
            $ddObj->attachLinkWithOrderedProducts($downloadLink, $post['record_id'], Product::CATALOG_TYPE_PRIMARY, $optionComb);
        }

        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function getDigitalDownloadLinks()
    {
        $this->objPrivilege->canViewProducts();

        $productId = FatApp::getPostedData('record_id', FatUtility::VAR_INT, 0);
        if (1 > $productId) {
            FatUtility::dieWithError($this->str_invalid_request);
        }

        $optionCombi = FatApp::getPostedData('option_comb', null, '0');
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);

        $ddpObj = new DigitalDownloadPrivilages();

        $canDo = $ddpObj->canEdit($productId, Product::CATALOG_TYPE_PRIMARY, 0, $this->siteLangId, false, true);
        $this->set('canDo', $canDo);

        $product = $ddpObj->getProduct($productId);
        $this->set('product', $product);

        $rows = DigitalDownloadSearch::getLinks($productId, Product::CATALOG_TYPE_PRIMARY, $optionCombi, $langId);

        $this->set('links', $rows);
        $languages = Language::getAllNames();
        $languages = array('0' => Labels::getLabel('LBL_All', $this->siteLangId)) + $languages;
        $this->set('languages', $languages);
        $productOptions = Product::getProductOptions($productId, $this->siteLangId, true);
        $optionCombinations = CommonHelper::combinationOfElementsOfArr($productOptions, 'optionValues', '_');
        $optionCombinations = array('0' => Labels::getLabel('LBL_All', $this->siteLangId)) + $optionCombinations;

        $this->set('options', $optionCombinations);
        $this->_template->render(false, false, 'products/digital-download-links-list.php', true);
    }

    public function getDigitalDownloadAttachments()
    {
        $this->objPrivilege->canViewProducts();

        $productId = FatApp::getPostedData('product_id', FatUtility::VAR_INT, 0);
        $optionComb = FatApp::getPostedData('option_comb', null, '0');
        $langId = FatApp::getPostedData('langId', null, 0);

        if (1 > $productId) {
            FatUtility::dieWithError($this->str_invalid_request);
        }

        $ddpObj = new DigitalDownloadPrivilages();

        $canDo = $ddpObj->canEdit($productId, Product::CATALOG_TYPE_PRIMARY, 0, $this->siteLangId, false, true);
        $this->set('canDo', $canDo);

        $product = $ddpObj->getProduct($productId);

        $attachments = DigitalDownloadSearch::getAttachments($productId, Product::CATALOG_TYPE_PRIMARY, $optionComb, $langId, true);

        $attachments = DigitalDownloadSearch::processAttachmentsWithPreview($attachments);

        $this->set('attachments', $attachments);
        $languages = Language::getAllNames();
        $languages = array('0' => Labels::getLabel('LBL_All', $this->siteLangId)) + $languages;
        $this->set('languages', $languages);
        $productOptions = Product::getProductOptions($productId, $this->siteLangId, true);
        $optionCombinations = CommonHelper::combinationOfElementsOfArr($productOptions, 'optionValues', '_');
        $optionCombinations = array('0' => Labels::getLabel('LBL_All', $this->siteLangId)) + $optionCombinations;
        $this->set('options', $optionCombinations);

        $this->set('recordId', $productId);
        $this->set('product', $product);
        $this->set('downloadrefType', Product::CATALOG_TYPE_PRIMARY);
        $this->_template->render(false, false, 'products/digital-download-attachments-list.php', true);
    }

    public function deleteDigitalLink($linkId, $refId)
    {
        $this->objPrivilege->canEditProducts();
        $refId = FatUtility::int($refId);
        $linkId = FatUtility::int($linkId);

        if (1 > $refId || 1 > $linkId) {
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $reference = DigitalDownload::getAttributesById($refId);

        if (false == $reference) {
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $link = DigitalDownloadSearch::getLinkDetail($linkId);
        if (1 > count($link)) {
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $ddpObj = new DigitalDownloadPrivilages();

        $canDo = $ddpObj->canEdit(
            $link['pddr_record_id'],
            $link['pddr_type'],
            0,
            $this->siteLangId,
            false,
            true
        );

        if (false == $canDo) {
            FatUtility::dieJsonError($ddpObj->getError());
        }

        $ddObj = new DigitalDownload();

        if (!$ddObj->deleteLink($linkId, $refId)) {
            FatUtility::dieJsonError($ddObj->getError());
        }

        $totalLinksCount = DigitalDownloadSearch::getTotalLinksCount($refId);
        $totalAttachmentCount = DigitalDownloadSearch::getTotalAttachmentsCount($refId);

        if (1 > $totalLinksCount && 1 > $totalAttachmentCount) {
            $ddObj->deleteReference($refId);
        }

        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_Removed_successfully', $this->siteLangId));
    }

    public function deleteDigitalFile()
    {
        $this->objPrivilege->canEditProducts();
        $refId = FatApp::getPostedData('ref_id', FatUtility::VAR_INT, 0);
        $aFileId = FatApp::getPostedData('afile_id', FatUtility::VAR_INT, 0);
        $isPreviewFile = FatApp::getPostedData('is_preview', FatUtility::VAR_INT, 0);
        $delFullRow = FatApp::getPostedData('frow', FatUtility::VAR_INT, 0);

        if (1 > $refId || 1 > $aFileId) {
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $reference = DigitalDownload::getAttributesById($refId);

        if (false == $reference) {
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $ddpObj = new DigitalDownloadPrivilages();

        $canDo = $ddpObj->canEdit(
            $reference['pddr_record_id'],
            $reference['pddr_type'],
            0,
            $this->siteLangId,
            false,
            true
        );

        if (false == $canDo) {
            FatUtility::dieJsonError($ddpObj->getError());
        }

        $digDownload = new DigitalDownload();

        if (!$digDownload->deleteAttachment($aFileId, $refId, $isPreviewFile, $delFullRow)) {
            FatUtility::dieJsonError($digDownload->getError());
        }

        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_Removed_successfully', $this->siteLangId));
    }

    public function downloadAttachment($aFileId, $recordId, $requestType, $isPreview = 0)
    {
        $this->objPrivilege->canViewProducts();

        $aFileId = FatUtility::int($aFileId);
        $recordId = FatUtility::int($recordId);
        $isPreview = FatUtility::int($isPreview);
        $requestType = FatUtility::int($requestType);

        if (1 > $aFileId || 1 > $recordId) {
            FatUtility::dieWithError(Labels::getLabel("LBL_Invalid_Request", $this->siteLangId));
        }

        /* $product = Product::getAttributesById($recordId, array('product_seller_id'));

        if (false == $product) {
            FatUtility::dieWithError(Labels::getLabel("LBL_Invalid_Request", $this->siteLangId));
        } */

        $ddpObj = new DigitalDownloadPrivilages();

        $canDo = $ddpObj->canDownload($recordId, $requestType, 0, $this->siteLangId, $isPreview, true);

        if (false == $canDo) {
            FatUtility::dieJsonError($ddpObj->getError());
        }

        $file = DigitalDownloadSearch::getAttachmentDetail($aFileId, $recordId, $requestType, $isPreview);

        if (1 > count($file)) {
            FatUtility::dieWithError(Labels::getLabel("LBL_File_not_found", $this->siteLangId));
        }

        if ($file['pddr_record_id'] != $recordId) {
            FatUtility::dieWithError(Labels::getLabel("MSG_INVALID_ACCESS", $this->siteLangId));
        }

        if (!file_exists(CONF_UPLOADS_PATH . $file['afile_physical_path'])) {
            FatUtility::dieWithError(Labels::getLabel("LBL_File_not_found", $this->siteLangId));
        }

        $fileName = isset($file['afile_physical_path']) ? $file['afile_physical_path'] : '';
        AttachedFile::downloadAttachment($fileName, $file['afile_name']);
    }

    public function viewProdOptions(int $product_id)
    {
        if (1 > $product_id) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
        }

        $productOptions = Product::getProductOptions($product_id, $this->siteLangId, true);
        if (empty($productOptions)) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_NO_RECORD_FOUND', $this->siteLangId));
        }

        $this->set('productOptions', $productOptions);
        $json['html'] = $this->_template->render(false, false, 'products/prod-options.php', true);
        FatUtility::dieJsonSuccess($json);
    }

    public function getShippingProfileOptions()
    {

        $userId = FatApp::getPostedData('userId', FatUtility::VAR_INT);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT);
        if (1 > $langId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $shippingObj = new Shipping($userId);
        $shipProfileArr = [];
        $shippingApiActive = 1;
        if (!$shippingObj->getShippingApiObj($userId)) {
            $shippingApiActive = 0;
            $shipProfileArr = ShippingProfile::getProfileArr($langId, $userId, true, true);
        }

        FatUtility::dieJsonSuccess(['shipProfileArr' => $shipProfileArr, 'shippingApiActive' => $shippingApiActive]);
    }

    protected function getFormColumns(): array
    {
        $emptyCartItemsTblHeadingCols = CacheHelper::get('productsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($emptyCartItemsTblHeadingCols) {
            return json_decode($emptyCartItemsTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'images' => Labels::getLabel('LBL_IMAGES', $this->siteLangId),
            'product_identifier' => Labels::getLabel('LBL_NAME', $this->siteLangId),
            'user_name' => Labels::getLabel('LBL_USER', $this->siteLangId),
            'product_added_on' => Labels::getLabel('LBL_CREATED_ON', $this->siteLangId),
            'product_approved' => Labels::getLabel('LBL_APPROVED', $this->siteLangId),
            'product_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('productsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'images',
            'product_identifier',
            'user_name',
            'product_added_on',
            'product_approved',
            'product_active',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['images'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'index':
                $pageData = PageLanguageData::getAttributesByKey('MANAGE_PRODUCTS', $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
                $this->nodes = [
                    ['title' => $pageTitle]
                ];
                break;
            default:
                parent::getBreadcrumbNodes($action);
                break;
        }
        return $this->nodes;
    }
}
