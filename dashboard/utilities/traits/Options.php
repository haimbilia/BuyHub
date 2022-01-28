<?php

trait Options
{
    public function options()
    {
        $this->userPrivilege->canViewProductOptions(UserAuthentication::getLoggedUserId());
        $canAddCustomProd = FatApp::getConfig('CONF_ENABLED_SELLER_CUSTOM_PRODUCT', FatUtility::VAR_INT, 0);
        if (1 > $canAddCustomProd) {
            FatApp::redirectUser(UrlHelper::generateUrl('Seller'));
        }
        $this->set('canEdit', $this->userPrivilege->canEditProductOptions(UserAuthentication::getLoggedUserId(), true));
        $frmSearch = $this->getSearchForm();
        $this->set("frmSearch", $frmSearch);
        $this->_template->addJs('js/jscolor.js');
        $this->_template->addJs('js/jquery.tablednd.js');
        $this->_template->render(true, true);
    }

    private function getSearchForm()
    {
        $frm = new Form('frmOptionSearch', array('id' => 'frmOptionSearch'));
        $frm->addTextBox('', 'keyword');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->siteLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel("LBL_Clear", $this->siteLangId), array('onclick' => 'clearOptionSearch();'));
        return $frm;
    }

    public function searchOptions()
    {
        $pagesize = FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10);
        $frmSearch = $this->getSearchForm();

        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $post = $frmSearch->getFormDataFromArray($data);
        $userId = $this->userParentId;
        $srch = Option::getSearchObject($this->siteLangId);
        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('o.option_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('ol.option_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        $srch->addCondition('o.option_seller_id', '=', $userId);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $srch->addMultipleFields(array( "o.*", "IFNULL( ol.option_name, o.option_identifier ) as option_name"));

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set('canEdit', $this->userPrivilege->canEditProductOptions(UserAuthentication::getLoggedUserId(), true));
        $this->set("ignoreOptionValues", Option::ignoreOptionValues());
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set("frmSearch", $frmSearch);
        $this->_template->render(false, false);
    }

    public function setupOptions()
    {
        $this->userPrivilege->canEditProductOptions(UserAuthentication::getLoggedUserId());
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $option_id = FatUtility::int($post['option_id']);
        if ($option_id > 0) {
            UserPrivilege::canSellerEditOption($this->userParentId, $option_id, $this->siteLangId);
        }
        unset($post['option_id']);

        $optionObj = new Option($option_id);
        /* if($option_id == 0){
        $displayOrder = $optionObj->getMaxOrder();
        $post['option_display_order'] = $displayOrder;
        } */
        $userId = $this->userParentId;
        $post['option_seller_id'] = $userId;
        $optionObj->assignValues($post);
        if (!$optionObj->save()) {
            Message::addErrorMessage(Labels::getLabel('MSG_Option_Identifier_already_exists', $this->siteLangId));
            /* Message::addErrorMessage($optionObj->getError()); */
            FatUtility::dieJsonError(Message::getHtml());
        }

        $option_id = ($option_id > 0) ? $option_id : $optionObj->getMainTableRecordId();

        $option_type = FatUtility::int($post['option_type']);

        if (in_array($option_type, Option::ignoreOptionValues())) {
            $optionValueObj = new OptionValue();
            $arr = $optionValueObj->getAttributesByOptionId($option_id, array('optionvalue_id'));
            foreach ($arr as $val) {
                $optionValueObj = new OptionValue($val['optionvalue_id']);
                $optionValueObj->deleteRecord(true);
            }
        }

        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            $data = array(
            'optionlang_lang_id' => $langId,
            'optionlang_option_id' => $option_id,
            'option_name' => $post['option_name' . $langId],
            );

            if (!$optionObj->updateLangData($langId, $data)) {
                Message::addErrorMessage($optionObj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
        }

        $this->set('msg', Labels::getLabel('MSG_SET_UP_SUCCESSFULLY', $this->siteLangId));
        $this->set('optionId', $option_id);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function optionForm($option_id = 0)
    {
        $option_id = FatUtility::int($option_id);
        if ($option_id > 0) {
            UserPrivilege::canSellerEditOption($this->userParentId, $option_id, $this->siteLangId);
        }
        $hideListBox = false;

        if (0 < $option_id) {
            $optionObj = new Option();
            $data = $optionObj->getOption($option_id);

            if ($data === false) {
                FatUtility::dieWithError($this->str_invalid_request);
            }

            if (in_array($data['option_type'], Option::ignoreOptionValues())) {
                $hideListBox = true;
            }
        }

        $this->set('option_id', $option_id);
        $this->set('hideListBox', $hideListBox);
        $this->set('langId', $this->siteLangId);
        $this->_template->render(false, false);
    }

    public function addOptionForm($option_id = 0)
    {
        $option_id = FatUtility::int($option_id);
        $frmOptions = $this->getForm($option_id);


        if (0 < $option_id) {
            $optionObj = new Option();
            if ($option_id > 0) {
                UserPrivilege::canSellerEditOption($this->userParentId, $option_id, $this->siteLangId);
            }
            $data = $optionObj->getOption($option_id);

            if ($data === false) {
                FatUtility::dieWithError(
                    Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
                );
            }

            $frmOptions->fill($data);
        }

        $this->set('frmOptions', $frmOptions);
        $this->_template->render(false, false);
    }

    private function getForm($option_id = 0)
    {

        /*Used when option created from product form */
        $post = FatApp::getPostedData();
        if (isset($post['product_id']) && $post['product_id'] != '') {
            $product_id = FatUtility::int($post['product_id']);
        }

        $option_id = FatUtility::int($option_id);
        if ($option_id > 0) {
            UserPrivilege::canSellerEditOption($this->userParentId, $option_id, $this->siteLangId);
        }

        $optionObj = new Option();
        $frm = new Form('frmOptions', array('id' => 'frmOptions'));
        $frm->addHiddenField('', 'option_id', $option_id);
        $frm->developerTags['colClassPrefix'] = 'col-md-';
        $frm->developerTags['fld_default_col'] = 6;
        $frm->addRequiredField(
            Labels::getLabel('LBL_OPTION_IDENTIFIER', $this->siteLangId),
            'option_identifier'
        );

        $languages = Language::getAllNames();
        $defaultLang = true;
        foreach ($languages as $langId => $langName) {
            $attr['class'] = 'langField_' . $langId;
            if (true === $defaultLang) {
                $attr['class'] .= ' defaultLang';
                $defaultLang = false;
            }
            $fld = $frm->addRequiredField(
                Labels::getLabel('LBL_OPTION_NAME', $this->siteLangId) . ' ' . $langName,
                'option_name' . $langId,
                '',
                $attr
            );
            $fld->setWrapperAttribute('class', 'layout--' . Language::getLayoutDirection($langId));
        }

        /* $optionTypeArr = Option::getOptionTypes($this->siteLangId );
        $frm->addSelectBox(Labels::getLabel('LBL_OPTION_TYPE',$this->siteLangId),'option_type',
        $optionTypeArr,'',array('onChange'=>'showHideValues(this)'),'')->requirements()->setRequired();
        */

        $frm->addHiddenField('', 'option_type', Option::OPTION_TYPE_SELECT);

        $yesNoArr = applicationConstants::getYesNoArr($this->siteLangId);
        $frm->addSelectBox(
            Labels::getLabel('LBL_OPTION_HAVE_SEPARATE_IMAGE', $this->siteLangId),
            'option_is_separate_images',
            $yesNoArr,
            0,
            array(),
            ''
        )->requirements()->setRequired();

        $frm->addSelectBox(Labels::getLabel('LBL_Option_is_Color', $this->siteLangId), 'option_is_color', $yesNoArr, 0, array(), '')->requirements()->setRequired();

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        if (isset($product_id) && $product_id > 0) {
            $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('BTN_CANCEL', $this->siteLangId), array('onClick' => 'productOptionsForm(' . $product_id . ')'));
            $fld_submit->attachField($fld_cancel);
        }

        return $frm;
    }

    public function canSetValue()
    {
        $hideBox = false;
        $post = FatApp::getPostedData();
        // var_dump($post);exit;
        $option_type = FatUtility::int($post['optionType']);
        if (in_array($option_type, Option::ignoreOptionValues())) {
            $hideBox = true;
        }
        $this->set('hideBox', $hideBox);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function bulkOptionsDelete()
    {
        $this->userPrivilege->canEditProductOptions(UserAuthentication::getLoggedUserId());
        $optionId_arr = FatApp::getPostedData('option_id');
        if (is_array($optionId_arr) && count($optionId_arr)) {
            foreach ($optionId_arr as $option_id) {
                $this->deleteOption(FatUtility::int($option_id));
            }
            FatUtility::dieJsonSuccess(
                Labels::getLabel('MSG_RECORD_DELETED_SUCCESSFULLY', $this->siteLangId)
            );
        }
        FatUtility::dieWithError(
            Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
        );
    }

    public function deleteSellerOption()
    {
        $this->userPrivilege->canEditProductOptions(UserAuthentication::getLoggedUserId());
        $option_id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        $this->deleteOption($option_id);

        FatUtility::dieJsonSuccess(
            Labels::getLabel('MSG_RECORD_DELETED_SUCCESSFULLY', $this->siteLangId)
        );
    }

    private function deleteOption($option_id)
    {
        $this->userPrivilege->canEditProductOptions(UserAuthentication::getLoggedUserId());
        if ($option_id < 1 || empty($option_id)) {
            Message::addErrorMessage(
                Labels::getLabel('MSG_INVALID_REQUEST_ID', $this->siteLangId)
            );
            FatUtility::dieJsonError(Message::getHtml());
        }
        if ($option_id > 0) {
            UserPrivilege::canSellerEditOption($this->userParentId, $option_id, $this->siteLangId);
        }

        $optionObj = new Option($option_id);
        if (!$optionObj->canRecordMarkDelete($option_id)) {
            Message::addErrorMessage(
                Labels::getLabel('MSG_INVALID_REQUEST_ID', $this->siteLangId)
            );
            FatUtility::dieJsonError(Message::getHtml());
        }

        if ($optionObj->isLinkedWithProduct($option_id)) {
            Message::addErrorMessage(
                Labels::getLabel('MSG_This_option_is_linked_with_product', $this->siteLangId)
            );
            FatUtility::dieJsonError(Message::getHtml());
        }

        $optionObj->assignValues(array(Option::tblFld('deleted') => 1));
        if (!$optionObj->save()) {
            Message::addErrorMessage($optionObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
    }

    public function autoCompleteOptions()
    {
        
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }

        $post = FatApp::getPostedData();
        $userId = $this->userParentId;
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, $this->siteLangId);
        $srch = Option::getSearchObject($langId);
        $srch->addOrder('option_identifier');

        $cnd = $srch->addCondition('option_seller_id', '=', $userId);
        $cnd->attachCondition('option_seller_id', '=', 0, 'OR');
        $srch->addMultipleFields(array('option_id as id, COALESCE(option_name, option_identifier) as option_name','option_identifier', 'option_is_separate_images'));

        $srch->setPageNumber($page);
        $srch->setPageSize(20);

        $disAllowOptions = FatApp::getPostedData('disAllowOptions');
        if (is_array($disAllowOptions)) {
            $srch->addCondition('option_id', 'NOT IN', $disAllowOptions);
        }

        $doNotIncludeImageOption = FatApp::getPostedData('doNotIncludeImageOption', FatUtility::VAR_INT, 0);
        if (0 < $doNotIncludeImageOption) {
            $srch->addCondition('option_is_separate_images', '=', applicationConstants::NO);
        }

        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('option_name', 'LIKE', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('option_identifier', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
        }       
        $options = FatApp::getDb()->fetchAll($srch->getResultSet());
        $results = [];
        foreach($options as $option){
            $optionName = $option['option_name'];       
            if($option['option_name']  != $option['option_identifier'] ){
                $optionName.="(".$option['option_identifier'] .")"; 
            }
            $results[]= ['id'=> $option['id'],'text'=> $optionName];
        }

        $json = array(
            'pageCount' => $srch->pages(),
            'results' => $results
        );
        die(json_encode($json));
    }

    public function autoCompleteValues()
    { 
        $post = FatApp::getPostedData();

        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, $this->siteLangId);
        $optionId = FatApp::getPostedData('optionId', FatUtility::VAR_INT, 0);

        $srch = OptionValue::getSearchObject($langId, true);    
        $srch->addCondition('ov.optionvalue_option_id', '=', $optionId);
        $srch->addMultipleFields(array('optionvalue_id as id, COALESCE(optionvalue_name, optionvalue_identifier) as text'));

        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('optionvalue_identifier', 'LIKE', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('optionvalue_name', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
        }

        if(FatApp::getPostedData('doNotLimitRecords', FatUtility::VAR_INT, 1)){
            $pagesize = 20;
            $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
            if ($page < 2) {
                $page = 1;
            }    
            $srch->setPageNumber($page);
            $srch->setPageSize($pagesize);
        }else{
            $srch->doNotLimitRecords();
        }       

        $options = FatApp::getDb()->fetchAll($srch->getResultSet());

        $json = array(
            'pageCount' => $srch->pages(),
            'results' => $options
        );        
        die(FatUtility::convertToJson($json));
    }


}
