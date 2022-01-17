<?php
class ProductsController extends SellerBaseController
{   

    use CatalogProduct;

    public function __construct($action)
    {        
        parent::__construct($action);
        $this->userPrivilege->canViewProducts();
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
            $this->set("canEdit", $this->userPrivilege->canEditProducts(UserAuthentication::getLoggedUserId(), true));
        } else {
            $this->userPrivilege->canEditProducts();
        }
    }

    public function form($recordId = 0, $productType = 0)
    {
        $this->checkEditPrivilege(); 

        $userId = $this->userParentId;
        
        if (0 == $recordId && FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE', FatUtility::VAR_INT, 0) &&
            Product::getActiveCount($userId) >= SellerPackages::getAllowedLimit($userId, $this->siteLangId, 'ossubs_products_allowed')) {
            LibHelper::exitWithError(Labels::getLabel('ERR_YOU_HAVE_CROSSED_YOUR_PACKAGE_LIMIT', $this->siteLangId),false,true);
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'Packages'));            
        }

        if (!$this->isShopActive($userId, 0, true)) {          
            LibHelper::exitWithError($this->str_invalid_request, false ,true);         
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'shop'));
        }

        if (!User::canAddCustomProduct()) {
            LibHelper::exitWithError($this->str_invalid_request, false ,true);           
            FatApp::redirectUser(UrlHelper::generateUrl('Products'));
        }

        if (!UserPrivilege::isUserHasValidSubsription($userId)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_BUY_SUBSCRIPTION', $this->siteLangId),false,true);
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'Packages'));
        }

        $recordId = FatUtility::int($recordId);
        $productType = FatUtility::int($productType);

        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        if (1 > $langId) {
            $langId = CommonHelper::getDefaultFormLangId();
        }


        $shippingObj = new Shipping($userId);

        $frm = $this->getForm($langId, $productType, $recordId);
        if (FatApp::getConfig('CONF_SHIPPED_BY_ADMIN_ONLY', FatUtility::VAR_INT, 0) || ($shippingObj->getShippingApiObj($userId) && !Shop::getAttributesByUserId($userId, 'shop_use_manual_shipping_rates') )) {    
                       
            $frm->removeField($frm->getField('shipping_profile'));
        }else{

        }   
        $imgFrm = $this->getImageFrm();   
        $productOptions = [];
        if (1 < $recordId) {           
            if (0 < FatApp::getPostedData('autoFillLangData', FatUtility::VAR_INT, 0)) {
                $updateLangDataobj = new TranslateLangData(Product::DB_TBL_LANG);
                $translatedData = $updateLangDataobj->getTranslatedData($recordId, $langId, CommonHelper::getDefaultFormLangId());
                if (false === $translatedData) {
                    LibHelper::exitWithError($updateLangDataobj->getError());
                }
                $productData = current($translatedData);
                $productData += Product::getAttributesById($recordId);
            } else {
                $productData = Product::getAttributesByLangId($langId, $recordId, null, true);
            }  
            if (empty($productData)) {
                LibHelper::exitWithError($this->str_invalid_request, false ,true);        
                FatApp::redirectUser(UrlHelper::generateUrl('Products'));                
            }

            $productData['record_id'] = $recordId;

            if ($productData['product_seller_id'] != $this->userParentId) {
                FatUtility::dieWithError(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
            }

            if (1 > $productType) {
                $frm = $this->getForm($langId, $productData['product_type'], $recordId);
            }

            $fld = $frm->getField('product_seller_id');
            if ($productData['product_seller_id'] > 0) {
                $userShopName = User::getUserShopName($productData['product_seller_id'], $langId);
                $fld->options = [$productData['product_seller_id'] => $userShopName['user_name'] . ' (' . $userShopName['shop_name'] . ')'];
            } else {
                $fld->options = [0 => Labels::getLabel('FRM_ADMIN', $langId)];
            }

            $prodSpecificsDetails = Product::getProductSpecificsDetails($recordId);
            if (false != $prodSpecificsDetails) {
                $productData += $prodSpecificsDetails;
            }

            $productTags = Product::getProductTags($recordId, $langId);
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

            $productCategories = (new Product())->getProductCategories($recordId);
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

            $taxData = Tax::getTaxCatByProductId($recordId, $productData['product_seller_id'], $langId, $taxCatMultiFields);
            if (false != $taxData) {
                $productData['ptt_taxcat_id'] = $taxData[Tax::tblFld('id')];
                $fld = $frm->getField('ptt_taxcat_id');
                $fld->options = [$productData['ptt_taxcat_id'] => $taxData[Tax::tblFld('name')] ?? $taxData[Tax::tblFld('identifier')]];
            }

            $prodShippingDetails = Product::getProductShippingDetails($recordId, $langId, $productData['product_seller_id']);

            if (false != $prodShippingDetails) {
                $productData['ps_from_country_id'] = $prodShippingDetails['ps_from_country_id'];
                $countryData = Countries::getAttributesByLangId($langId, $prodShippingDetails['ps_from_country_id'], [Countries::tblFld('name'), Countries::tblFld('code')], true, applicationConstants::YES);
                if (false != $countryData) {
                    $fld = $frm->getField('ps_from_country_id');
                    $fld->options = [$prodShippingDetails['ps_from_country_id'] => $countryData[Countries::tblFld('name')] ?? $countryData[Tax::tblFld('code')]];
                }
            }

            /* [ GET ATTACHED PROFILE ID */
            $profSrch = ShippingProfileProduct::getSearchObject();
            $profSrch->addCondition('shippro_product_id', '=', $recordId);
            $profSrch->addCondition('shippro_user_id', '=', $productData['product_seller_id']);
            $profSrch->doNotCalculateRecords();
            $profSrch->setPageSize(1);
            $proRs = $profSrch->getResultSet();
            $profileData = FatApp::getDb()->fetch($proRs);
            if (!empty($profileData)) {
                $productData['shipping_profile'] = $profileData['profile_id'];
            }
            /* ] */
            $isSelProdCreatedBySeller = 0 < Product::getCatalogProductCount($recordId);
            $isProductAddedByAdmin = applicationConstants::YES == $productData['product_added_by_admin_id'];
            $productOptions = Product::getProductOptions($recordId, $langId, true);

            $srch = new SearchBase(UpcCode::DB_TBL);
            $srch->addCondition('upc_product_id', '=', $recordId);
            $srch->addFld('upc_options');
            $row = FatApp::getDb()->fetch($srch->getResultSet());
            $productData['upc_type'] = applicationConstants::YES;
            if (false != $row) {
                if ($row['upc_options'] != 0) {
                    $productData['upc_type'] = applicationConstants::NO;
                }
            }

            $this->set("productData", [
                'product_type' => $productData['product_type'],
                'product_seller_id' => $productData['product_seller_id'],
                'product_attachements_with_inventory' => $productData['product_attachements_with_inventory'],
            ]);

            /* to select product type in get */
            if (0 < $productType) {
                $productData['product_type'] = $productType;
            }

            $frm->fill($productData);
            $imgFrm->fill(['file_type' => AttachedFile::FILETYPE_PRODUCT_IMAGE, 'record_id' => $recordId]);
        } else {
            $tempProductId = time() .$this->userParentId;
            $frm->fill(['temp_product_id' => $tempProductId]);
            $imgFrm->fill(['file_type' => AttachedFile::FILETYPE_PRODUCT_IMAGE_TEMP, 'record_id' => $tempProductId]);
        }

        $this->set("frm", $frm);
        $this->set("imgFrm", $imgFrm);

        $codEnabled = true;
        $paymentMethod = new PaymentMethods();
        if (!$paymentMethod->cashOnDeliveryIsActive()) {
            $codEnabled = false;
        }
        $this->set("codEnabled", $codEnabled);
        $this->set("canEditTags", true);
        $this->set("langId", $langId);
        $this->set("recordId", $recordId);
 
        $this->set('productOptions', $productOptions);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        if (FatUtility::isAjaxCall()) {
            $this->set('html', $this->_template->render(false, false, NULL, true));
            $this->_template->render(false, false, 'json-success.php', true, false);
            return;
        }
        $this->_template->addJs(array('js/cropper.js', 'js/cropper-main.js', 'js/select2.js', 'js/tagify.min.js', 'js/tagify.polyfills.min.js'));     
        $this->_template->addCss(array('css/select2.min.css'));
        $this->set("includeEditor", true);  
        $this->_template->render();
    }

    public function prodSpecifications()
    {
        $recordId = FatApp::getPostedData('record_id', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        if (1 > $langId) {
            $langId = CommonHelper::getDefaultFormLangId();
        }
        $productSpecifications = [];
        if (0 < $recordId) {
            if (!UserPrivilege::canSellerEditCustomProduct($this->userParentId, $recordId)) {
                LibHelper::exitWithError($this->str_invalid_request_id);
            }
            $prod = new Product($recordId);
            $productSpecifications = $prod->getProdSpecificationsByLangId($langId);
        }
        $this->set('productSpecifications', $productSpecifications);
        $this->set('langId', $langId);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function images($recordId, $fileType = 0, $optionId = 0, $langId = 0)
    {
        $recordId = FatUtility::int($recordId);
        $fileType = FatUtility::int($fileType);
        if (1 > $recordId) {            
           LibHelper::exitWithError($this->str_invalid_request, true);            
        }

        $languages = Language::getAllNames();
        if (count($languages) <= 1) {
            $langId = array_key_first($languages);
        }

        if ($fileType == AttachedFile::FILETYPE_PRODUCT_IMAGE_TEMP) {
            $images = AttachedFileTemp::getMultipleAttachments($fileType, $recordId, $optionId, $langId, (count($languages) <= 1) ? true : false, 0, 0, true);
        } else {
            $fileType = AttachedFile::FILETYPE_PRODUCT_IMAGE;
            if (!Product::getAttributesById($recordId, 'product_id')) {           
                LibHelper::exitWithError($this->str_invalid_request, true);            
            }
            $images = AttachedFile::getMultipleAttachments($fileType, $recordId, $optionId, $langId, (count($languages) <= 1) ? true : false, 0, 0, true);
        }

        $this->set('images', $images);
        $this->set('recordId', $recordId);
        $this->set('isDefaultLayout', FatApp::getPostedData('isDefaultLayout', FatUtility::VAR_INT, 0));
        $this->checkEditPrivilege(true);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    // public function getShippingProfileOptions()
    // {
    //     $userId = FatApp::getPostedData('userId', FatUtility::VAR_INT);
    //     $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT);
    //     if (1 > $langId) {            
    //         LibHelper::exitWithError($this->str_invalid_request, true);            
    //     }
    //     $shippingObj = new Shipping($userId);
    //     $shipProfileArr = [];
    //     $shippingApiActive = 1;
    //     if (!$shippingObj->getShippingApiObj($userId)) {
    //         $shippingApiActive = 0;
    //         $shipProfileArr = ShippingProfile::getProfileArr($langId, $userId, true, true);
    //     }

    //     FatUtility::dieJsonSuccess(['shipProfileArr' => $shipProfileArr, 'shippingApiActive' => $shippingApiActive]);
    // }

    public function upcListing()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        $productOptions = FatApp::getPostedData('productOptions');
        $type = FatApp::getPostedData('type', FatUtility::VAR_INT, 0);

        $upcCodeData = [];
        if (0 < $recordId) {
            if (!UserPrivilege::canSellerEditCustomProduct($this->userParentId, $recordId)) {
                LibHelper::exitWithError($this->str_invalid_request_id);
            }

            $srch = UpcCode::getSearchObject();
            $srch->addCondition('upc_product_id', '=', $recordId);
            $srch->doNotCalculateRecords();
            $upcCodeData = FatApp::getDb()->fetchAll($srch->getResultSet(), 'upc_options');
        }

        $optionCombinations = [];
        if ($type == applicationConstants::NO && is_array($productOptions)) {
            $optionCombinations = CommonHelper::combinationOfElementsOfArr($productOptions, 'optionValues');
        }        

        $this->set('optionCombinations', $optionCombinations);
        $this->set('upcCodeData', $upcCodeData);
        $this->set('recordId', $recordId);
        $this->set('langId', $langId);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getForm($langId, $productType = 0, $recordId = 0)
    {
        return $this->getCatalogForm($langId, $productType, $recordId);
    }

    private function isShopActive($userId, $shopId = 0, $returnResult = false)
    {
        $shop = new Shop($shopId, $userId);
        if (false == $returnResult) {
            return $shop->isActive();
        }

        if ($shop->isActive()) {
            return $shop->getData();
        }

        return false;        
    }    
}
