<?php

trait SellerCollections
{
    public function shopCollections()
    {
        $this->userPrivilege->canViewShop(UserAuthentication::getLoggedUserId());
        $this->commonShopCollection();
        $this->_template->render(false, false);
    }

    public function searchShopCollections()
    {
        $userId = $this->userParentId;
        $shopDetails = Shop::getAttributesByUserId($userId, null, false);
        if (false == $shopDetails) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        $records = ShopCollection::getCollectionGeneralDetail($shopDetails['shop_id']);
        $this->set('canEdit', $this->userPrivilege->canEditShop(UserAuthentication::getLoggedUserId(), true));
        $this->set("arrListing", $records);
        $this->_template->render(false, false);
    }

    public function commonShopCollection()
    {
        $userId = $this->userParentId;
        $shopDetails = Shop::getAttributesByUserId($userId, null, false);

        if (!false == $shopDetails && $shopDetails['shop_active'] != applicationConstants::ACTIVE) {
            Message::addErrorMessage(Labels::getLabel('ERR_YOUR_SHOP_DEACTIVATED_CONTACT_ADMIN', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        if (!false == $shopDetails) {
            $shop_id = $shopDetails['shop_id'];
            $stateId = $shopDetails['shop_state_id'];
        }
        $this->set('shop_id', $shop_id);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('language', Language::getAllNames());
        return $shop_id;
    }

    public function shopCollection()
    {
        $userId = $this->userParentId;
        if (!UserPrivilege::canEditSellerCollection($userId)) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_INVALID_ACCESS", $this->siteLangId));
        }

        $this->commonShopCollection();

        $this->_template->render(false, false);
    }

    public function shopCollectionGeneralForm($scollection_id = 0)
    {
        $scollection_id = FatUtility::int($scollection_id);       
        $shop_id = $this->commonShopCollection();
        $colectionForm = $this->getCollectionGeneralForm($scollection_id, $shop_id); 
        $identifier = ''; 
        $baseUrl = '';      
        if(0 < $scollection_id){
            $shopcolDetails = ShopCollection::getCollectionGeneralDetail($shop_id, $scollection_id, CommonHelper::getDefaultFormLangId());
            $baseUrl = Shop::getRewriteCustomUrl($shop_id);
            if (!empty($shopcolDetails)) {
                /* url data[ */
                $urlSrch = UrlRewrite::getSearchObject();
                $urlSrch->doNotCalculateRecords();
                $urlSrch->setPageSize(1);
                $urlSrch->addFld('urlrewrite_custom');
    
                $urlSrch->addCondition('urlrewrite_original', '=', 'shops/collection/' . $shop_id . '/' . $scollection_id);
                $rs = $urlSrch->getResultSet();
                $urlRow = FatApp::getDb()->fetch($rs);
                if ($urlRow) {
                    $shopcolDetails['urlrewrite_custom'] = str_replace('-' . $baseUrl, '', $urlRow['urlrewrite_custom']);
                }
                /* ] */
                $scollection_id = (array_key_exists('scollection_id', $shopcolDetails)) ? $shopcolDetails['scollection_id'] : 0;
                $shopcolDetails['scollection_name'] = !empty($shopcolDetails[ShopCollection::tblFld('name')]) ? $shopcolDetails[ShopCollection::tblFld('name')] : $shopcolDetails[ShopCollection::tblFld('identifier')];
                
                $colectionForm->fill($shopcolDetails);
                $identifier = $shopcolDetails[ShopCollection::tblFld('identifier')];
            }
        }
        
        $this->set('scollection_id', $scollection_id);
        $this->set('identifier', $identifier);
        $this->set('baseUrl', $baseUrl);
        $this->set('shop_id', $shop_id);
        $this->set('colectionForm', $colectionForm);
        $this->set('languages', Language::getAllNames());
        $this->_template->render(false, false);
    }

    public function deleteShopCollection($scollection_id)
    {
        $scollection_id = FatUtility::int($scollection_id);
        $shop_id = $this->commonShopCollection();
        $this->markCollectionAsDeleted($shop_id, $scollection_id);
        FatUtility::dieJsonSuccess(
            Labels::getLabel('MSG_RECORD_DELETED', $this->siteLangId)
        );
    }

    public function deleteSelectedCollections()
    {
        $scollectionIdsArr = FatUtility::int(FatApp::getPostedData('scollection_ids'));
        $shop_id = $this->commonShopCollection();

        if (empty($scollectionIdsArr)) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }

        foreach ($scollectionIdsArr as $scollection_id) {
            if (1 > $scollection_id) {
                continue;
            }
            $shopcolDetails = ShopCollection::getCollectionGeneralDetail($shop_id, $scollection_id);
            if (empty($shopcolDetails)) {
                continue;
            }

            $this->markCollectionAsDeleted($shop_id, $scollection_id);
        }
        FatUtility::dieJsonSuccess(
            Labels::getLabel('MSG_RECORD_DELETED', $this->siteLangId)
        );
    }

    private function markCollectionAsDeleted($shop_id, $scollection_id)
    {
        $shopcolDetails = ShopCollection::getCollectionGeneralDetail($shop_id, $scollection_id);
        if (empty($shopcolDetails)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }
        $collection = new ShopCollection();
        if (!$collection->deleteCollection($scollection_id)) {
            FatUtility::dieJsonError($collection->getError());
        }
    }

    private function getCollectionGeneralForm($scollection_id = 0, $shop_id = 0)
    {
        $shop_id = FatUtility::int($shop_id);
        $frm = new Form('frmShopCollection');
        $frm->addHiddenField('', 'scollection_id', $scollection_id);
        $frm->addHiddenField('', 'scollection_shop_id', $shop_id);      
        $frm->addRequiredField(Labels::getLabel('FRM_COLLECTION_NAME', $this->siteLangId), 'scollection_name');  
        $fld = $frm->addTextBox(Labels::getLabel('FRM_SEO_FRIENDLY_URL', $this->siteLangId), 'urlrewrite_custom');
        $fld->requirements()->setRequired(); 
        $frm->addCheckBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'scollection_active', applicationConstants::ACTIVE, array(), true, applicationConstants::INACTIVE);
        
        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        
        return $frm;
    }

    public function setupShopCollection()
    {
        $this->userPrivilege->canEditShop(UserAuthentication::getLoggedUserId());
        $post = FatApp::getPostedData();
        $shop_id = FatUtility::int($post['scollection_shop_id']);
        $scollection_id = FatUtility::int($post['scollection_id']);
        if (!UserPrivilege::canEditSellerCollection($shop_id)) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_INVALID_ACCESS", $this->siteLangId));
        }        
        $frm = $this->getCollectionGeneralForm($scollection_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }        

        $record = new ShopCollection($scollection_id);
        $post[$record::tblFld('identifier')] = $post[$record::tblFld('name')];

        $record->assignValues($post);
        if (!$collection_id = $record->save()) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_THIS_IDENTIFIER_IS_NOT_AVAILABLE._PLEASE_TRY_WITH_ANOTHER_ONE.", $this->siteLangId));
        }

        $this->setLangData($record, [$record::tblFld('name') => $post[$record::tblFld('name')]]);
        /* url data[ */

        $langs = Language::getAllNames();
        if (1 == count($langs) && !$this->isCollectionLinkFormFilled($record->getMainTableRecordId())) {             
            $this->set('openCollectionLinkForm', true);
        }

        $shopOriginalUrl = Shop::SHOP_COLLECTION_ORGINAL_URL . $shop_id . '/' . $collection_id;
        if ($post['urlrewrite_custom'] == '') {
            FatApp::getDb()->deleteRecords(UrlRewrite::DB_TBL, array('smt' => 'urlrewrite_original = ?', 'vals' => array($shopOriginalUrl)));
        } else {
            $shop = new Shop($shop_id);
            $shop->setupCollectionUrl($post['urlrewrite_custom'], $collection_id);
        }
        /* ] */
        
        $this->set('collection_id', $collection_id);       
        $this->_template->render(false, false, 'json-success.php');
    }

    public function changeShopCollectionStatus()
    {
        $this->userPrivilege->canEditShop(UserAuthentication::getLoggedUserId());
        $scollectionId = FatApp::getPostedData('scollection_id', FatUtility::VAR_INT, 0);
        $shopId = $this->commonShopCollection();
        $shopcolDetails = ShopCollection::getCollectionGeneralDetail($shopId, $scollectionId);
        $status = ($shopcolDetails['scollection_active'] == applicationConstants::ACTIVE) ? applicationConstants::INACTIVE : applicationConstants::ACTIVE;

        $this->updateShopCollectionStatus($scollectionId, $status);

        $this->set('msg', Labels::getLabel('MSG_Status_changed_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleBulkCollectionStatuses()
    {
        $this->userPrivilege->canEditShop(UserAuthentication::getLoggedUserId());
        $this->commonShopCollection();
        $status = FatApp::getPostedData('collection_status', FatUtility::VAR_INT, -1);
        $scollectionIdsArr = FatUtility::int(FatApp::getPostedData('scollection_ids'));

        if (empty($scollectionIdsArr) || -1 == $status) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }

        foreach ($scollectionIdsArr as $scollectionId) {
            if (1 > $scollectionId) {
                continue;
            }
            $this->updateShopCollectionStatus($scollectionId, $status);
        }
        $this->set('msg', Labels::getLabel('MSG_Status_changed_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updateShopCollectionStatus($scollectionId, $status)
    {
        $this->userPrivilege->canEditShop(UserAuthentication::getLoggedUserId());
        $scollectionId = FatUtility::int($scollectionId);
        $status = FatUtility::int($status);
        if (1 > $scollectionId || -1 == $status) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }
        $scollection = new ShopCollection($scollectionId);
        if (!$scollection->changeStatus($status)) {
            Message::addErrorMessage($scollection->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
    }

    public function shopCollectionLangForm($scollection_id, $langId, $autoFillLangData = 0)
    {
        $scollection_id = Fatutility::int($scollection_id);
        if (!$scollection_id) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_INVALID_ACCESS", $this->siteLangId));
        }

        $shopColLangFrm = $this->getCollectionLangForm($scollection_id, $langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(ShopCollection::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($scollection_id, $langId, CommonHelper::getDefaultFormLangId());
            if (false === $translatedData) {
                Message::addErrorMessage($updateLangDataobj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
            $row = current($translatedData);
        } else {
            $row = ShopCollection::getAttributesByLangId($langId, $scollection_id);
        }

        if (!empty($row) && 0 < count($row)) {
            $row['scollection_id'] = $row['scollectionlang_scollection_id'];
            $row['lang_id'] = $row['scollectionlang_lang_id'];          
            $shopColLangFrm->fill($row);
        }
       
        $this->set('shopColLangFrm', $shopColLangFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('userId', $this->userParentId);
        $this->set('scollection_id', $scollection_id);
        $this->set('langId', $langId);
        $this->set('languages', Language::getAllNames());
        $this->commonShopCollection();
        $this->_template->render(false, false);
    }

    private function getCollectionLangForm($scollection_id = 0, $langId = 0)
    {
        $frm = new Form('frmMetaTagLang');
        $frm->addHiddenField('', 'scollection_id', $scollection_id);        
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $fld->requirements()->setRequired(); 
        $fld->requirements()->setInt(); 
        $frm->addRequiredField(Labels::getLabel('FRM_COLLECTION_NAME', $langId), 'scollection_name');
        return $frm;
    }

    public function setupShopCollectionLang()
    {
        $this->userPrivilege->canEditShop(UserAuthentication::getLoggedUserId());
        $post = FatApp::getPostedData();
        $scollection_id = FatUtility::int($post['scollection_id']);
        if (!UserPrivilege::canEditSellerCollection($scollection_id)) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_INVALID_ACCESS", $this->siteLangId));
        }        
        $frm = $this->getCollectionLangForm($scollection_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }        
        $record = new ShopCollection($scollection_id);
        $this->setLangData($record, [$record::tblFld('name') => $post[$record::tblFld('name')]], $post['lang_id']);
       
        if ($this->get('langId') == 0 && !$this->isCollectionLinkFormFilled($scollection_id)) {             
            $this->set('openCollectionLinkForm', true);
        }
        $this->set('scollection_id', $scollection_id);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function isCollectionLinkFormFilled($scollection_id)
    {
        $sCollectionobj = new ShopCollection();
        if ($sCollectionobj->getShopCollectionProducts($scollection_id, $this->siteLangId)) {
            return true;
        }
        return false;
    }


    /*  - --- Seller Product Links  ----- [*/

    public function shopCollectionProductLinkFrm($scollection_id)
    {
        $post = FatApp::getPostedData();
        $scollection_id = FatUtility::int($scollection_id);
        $shop_id = $this->commonShopCollection();
        if (!UserPrivilege::canEditSellerCollection($scollection_id)) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_INVALID_ACCESS", $this->siteLangId));
        }
        $sellProdObj = new ShopCollection();
        $products = $sellProdObj->getShopCollectionProducts($scollection_id, $this->siteLangId);
       
        $collectionLinkFrm = $this->getCollectionLinksFrm();       
        if (!empty($products)) {
            $sellerProducts = [];
            foreach ($products as $key => $val) {
                $options = SellerProduct::getSellerProductOptions($val['selprod_id'], true, $this->siteLangId);
                $variantsStr = '';
                array_walk($options, function ($item, $key) use (&$variantsStr) {
                    $variantsStr .= ' | ' . $item['option_name'] . ' : ' . $item['optionvalue_name'];
                });
                $productName = strip_tags(html_entity_decode(($val['product_name'] != '') ? $val['product_name'] : $val['product_identifier'], ENT_QUOTES, 'UTF-8'));
                $productName .= $variantsStr;
                $sellerProducts[$val['selprod_id']] = $productName;   
                
                $data['scp_selprod_id'] = array_keys($sellerProducts);
                $fld = $collectionLinkFrm->getField('scp_selprod_id[]');
                $fld->options = $sellerProducts;
               
            }           
            $data['scp_scollection_id'] = $scollection_id; 
        }
        $data['scp_scollection_id'] = $scollection_id;
        $collectionLinkFrm->fill($data);
        $this->set('collectionLinkFrm', $collectionLinkFrm);
        $this->set('scollection_id', $scollection_id);
        $this->set('products', $products);
        $this->set('languages', Language::getAllNames()); 
        $this->_template->render(false, false);
    }

    private function getCollectionLinksFrm()
    {
        $frm = new Form('frmLinks1', array('id' => 'frmLinks1'));
        $frm->addHiddenField('', 'scp_scollection_id');
        $frm->addSelectBox(Labels::getLabel('FRM_SELLER_PRODUCTS', $this->siteLangId), 'scp_selprod_id[]', [], '', array('id' => 'scp_selprod_id'), false);
        $frm->addHtml('', 'buy_together', '<div id="selprod-products"><ul class="list-vertical"></ul></div>');
        return $frm;
    }

    public function setupSellerCollectionProductLinks()
    {
        $this->userPrivilege->canEditShop(UserAuthentication::getLoggedUserId());
        $post = FatApp::getPostedData();
        $scollection_id = FatUtility::int($post['scp_scollection_id']);
        if (!UserPrivilege::canEditSellerCollection($scollection_id)) {
            FatUtility::dieJsonError(Labels::getLabel("ERR_INVALID_ACCESS", $this->siteLangId));
        }
        $product_ids = (isset($post['scp_selprod_id'])) ? $post['scp_selprod_id'] : array();

        if ($scollection_id <= 0) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $shopColObj = new ShopCollection();
        /* saving of product Upsell Product[ */
        if (!$shopColObj->addUpdateSellerCollectionProducts($scollection_id, $product_ids)) {
            Message::addErrorMessage($shopColObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
        
        $attachment = AttachedFile::getAttachment(AttachedFile::FILETYPE_SHOP_COLLECTION_IMAGE, $scollection_id);       
        if (false == $attachment || 1 > $attachment['afile_id']) {
            $this->set('openMediaForm', true);
        } 
        $this->set('scollection_id', $scollection_id);
        $this->set('msg', Labels::getLabel('MSG_RECORD_UPDATED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function shopCollectionMediaForm($scollection_id)
    {
        $collectionMediaFrm = $this->getShopCollectionMediaForm($scollection_id);
        $this->set('frm', $collectionMediaFrm);
        $this->set('imageDimension', ImageDimension::getData(ImageDimension::TYPE_SHOP_COLLECTION_IMAGE, ImageDimension::VIEW_SHOP));
        $this->set('languages', Language::getAllNames());
        $this->set('scollection_id', $scollection_id);
        $this->_template->render(false, false);
    }

    private function getShopCollectionMediaForm($scollection_id)
    {
        $frm = new Form('frmCollectionMedia');
        $frm->addHiddenField('', 'scollection_id', $scollection_id);
        $bannerTypeArr = applicationConstants::getAllLanguages();
        if (count($bannerTypeArr) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', $bannerTypeArr, '', array('class' => 'collection-language-js'), '');
        } else {
            $langid = array_key_first($bannerTypeArr);
            $frm->addHiddenField('', 'lang_id', $langid);
        }
        $frm->addHtml('', 'collection_image', '');
        return $frm;
    }

    public function shopCollectionImages($scollection_id, $lang_id = 0)
    {
        $scollection_id = FatUtility::int($scollection_id);
        $lang_id = FatUtility::int($lang_id);

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = FatUtility::int($lang_id);
        } else {
            $lang_id = array_key_first($languages);
        }
        $this->commonShopCollection();
        if (1 > $scollection_id) {
            FatUtility::dieWithError($this->str_invalid_request);
        }

        $collectionImg = AttachedFile::getAttachment(AttachedFile::FILETYPE_SHOP_COLLECTION_IMAGE, $scollection_id, 0, $lang_id, false);
        $this->set('image', $collectionImg);       
        $this->set('scollection_id', $scollection_id);
        $this->set('lang_id', $lang_id);
        $this->set('canEdit', $this->userPrivilege->canEditShop(UserAuthentication::getLoggedUserId(), true));
        $this->_template->render(false, false);
    }

    public function uploadCollectionImage()
    {
        if (!$this->userPrivilege->canEditShop(UserAuthentication::getLoggedUserId(), true)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_UNAUTHORIZED_ACCESS!', $this->siteLangId));
        }
        $post = FatApp::getPostedData();
        if (empty($post)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST_OR_FILE_NOT_SUPPORTED', $this->siteLangId));
        }

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        } else {
            $lang_id = array_key_first($languages);
        }

        $scollection_id = FatApp::getPostedData('scollection_id', FatUtility::VAR_INT, 0);

        if ($scollection_id == 0) {
            FatUtility::dieJsonError($this->str_invalid_request);
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_PLEASE_SELECT_A_FILE', $this->siteLangId));
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->saveImage($_FILES['cropped_image']['tmp_name'], AttachedFile::FILETYPE_SHOP_COLLECTION_IMAGE, $scollection_id, 0, $_FILES['cropped_image']['name'], -1, true, $lang_id)) {
            FatUtility::dieJsonError($fileHandlerObj->getError());
        }

        $this->set('file', $_FILES['cropped_image']['name']);
        $this->set('scollection_id', $scollection_id);
        $this->set('msg', Labels::getLabel('MSG_File_uploaded_successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeCollectionImage($scollection_id, $lang_id = 0)
    {
        $this->userPrivilege->canEditShop(UserAuthentication::getLoggedUserId());
        $scollection_id = FatUtility::int($scollection_id);
        $lang_id = FatUtility::int($lang_id);

        $this->commonShopCollection();
        if (1 > $scollection_id) {
            FatUtility::dieWithError($this->str_invalid_request);
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile(AttachedFile::FILETYPE_SHOP_COLLECTION_IMAGE, $scollection_id, 0, 0, $lang_id)) {
            FatUtility::dieJsonError($fileHandlerObj->getError());
        }

        $this->set('msg', Labels::getLabel('MSG_File_deleted_successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
}
