<?php

class AttributesController extends ListingBaseController
{
    private $canView;
    private $canEdit;
    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewAttributes($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditAttributes($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }
    public function index()
    {
        $this->objPrivilege->canViewAttributes();
        $search = $this->getSearchForm();
        $this->set("search", $search);
        $this->_template->render();
    }

    public function search()
    {
        $this->objPrivilege->canViewAttributes();
        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $post = $searchForm->getFormDataFromArray($data);

        $srch = AttributeGroup::getSearchObject();
        $srch->addFld('ag.*');

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $srch->addCondition('ag.attrgrp_name', 'like', '%' . $post['keyword'] . '%');
        }

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();

        $records = array();
        if ($rs) {
            $records = FatApp::getDb()->fetchAll($rs);
        }

        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function form($attrgrp_id = 0)
    {
        $this->objPrivilege->canEditAttributes();

        $attrgrp_id = FatUtility::int($attrgrp_id);
        $frm = $this->getForm($attrgrp_id);

        if (0 < $attrgrp_id) {
            $data = Brand::getAttributesById($attrgrp_id, array('attrgrp_id', 'attrgrp_name'));
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $this->set('attrgrp_id', $attrgrp_id);
        $this->set('frm', $frm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditAttributes();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $attrgrp_id = $post['attrgrp_id'];
        unset($post['attrgrp_id']);

        $record = new AttributeGroup($attrgrp_id);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_ATTRIBUTE_GROUP_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function attributes($attrgrp_id)
    {
        $this->objPrivilege->canViewAttributes();
        $attrgrp_id = FatUtility::int($attrgrp_id);
        if (!$attrgrp_id) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Attributes'));
        }
        $attrgrp_row = AttributeGroup::getAttributesById($attrgrp_id);
        if (!$attrgrp_row) {
            Message::addErrorMessage(Labels::getLabel('ERR_NO_RECORD_EXIST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Attributes'));
        }

        $attrGrpAttrObj = new AttrGroupAttribute();
        $attributes = $attrGrpAttrObj->getAttributesByGroupId($attrgrp_row['attrgrp_id'], array('attr_fld_name', 'attr_identifier', 'attr_type'));

        $frm_data = array();
        for ($i = 1; $i <= AttrGroupAttribute::MAX_NUMERIC_ATTRIBUTE_ROWS; $i++) {
            foreach ($attributes as $val) {

                /* filling num data[ */
                if ($val['attr_fld_name'] == 'prodnumattr_num_' . $i) {
                    $frm_data['prodnumattr_num_' . $i] = $i;
                    $frm_data['attr_identifier_num_' . $i] = $val['attr_identifier'];
                    $frm_data['attr_type_num_' . $i] = $val['attr_type'];
                }
                /* ] */

                /* filling textual data[ */
                /* if( $val['attr_fld_name'] == 'prodtxtattr_text_'.$i ){
                $frm_data['prodtxtattr_text_'.$i] = $i;
                $frm_data['attr_identifier_text_'.$i] = $val['attr_identifier'];
                $frm_data['attr_type_text_'.$i] = $val['attr_type'];
                } */
                /* ] */
            }
        }

        for ($i = 1; $i <= AttrGroupAttribute::MAX_TEXTUAL_ATTRIBUTE_ROWS; $i++) {
            foreach ($attributes as $val) {
                /* filling textual data[ */
                if ($val['attr_fld_name'] == 'prodtxtattr_text_' . $i) {
                    $frm_data['prodtxtattr_text_' . $i] = $i;
                    $frm_data['attr_identifier_text_' . $i] = $val['attr_identifier'];
                    $frm_data['attr_type_text_' . $i] = $val['attr_type'];
                }
                /* ] */
            }
        }

        $frm = $this->getAttributeFrm();
        $frm_data['attrgrp_id'] = $attrgrp_row['attrgrp_id'];
        $frm->fill($frm_data);

        $this->set('attrgrp_row', $attrgrp_row);
        //$this->set('MAX_NUMERIC_ATTRIBUTE_ROWS', AttrGroupAttribute::MAX_NUMERIC_ATTRIBUTE_ROWS);
        $this->set('frm', $frm);
        $this->_template->render(true, true, 'attributes/attributes.php');
    }

    public function setupAttributes()
    {
        $this->objPrivilege->canEditAttributes();

        $frm = $this->getAttributeFrm();
        $data = FatApp::getPostedData();
        $post = $frm->getFormDataFromArray($data);
        if ($post == false) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatApp::redirectUser(UrlHelper::generateUrl('Attributes'));
        }
        $attrgrp_id = FatUtility::int($post['attrgrp_id']);
        $attrgrp_row = AttributeGroup::getAttributesById($attrgrp_id);
        if (!$attrgrp_row) {
            Message::addErrorMessage(Labels::getLabel('ERR_ATTRIBUTE_GROUP_NOT_SELECTED', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Attributes'));
        }
        $attrgrp_id = $attrgrp_row['attrgrp_id'];

        /* gathering numeric data info to be save in db[ */
        $data_to_save = array();

        // validation check
        for ($i = 1; $i <= AttrGroupAttribute::MAX_NUMERIC_ATTRIBUTE_ROWS; $i++) {
            if ($post['prodnumattr_num_' . $i] == '') {
                continue;
            }
            if (empty($post['attr_identifier_num_' . $i]) || empty($post['attr_type_num_' . $i])) {
                Message::addErrorMessage(Labels::getLabel('ERR_COULD_NOT_SAVE_DATA', $this->siteLangId));
                $this->attributes($attrgrp_id);
                return;
            }
        }

        for ($i = 1; $i <= AttrGroupAttribute::MAX_NUMERIC_ATTRIBUTE_ROWS; $i++) {
            if ($post['prodnumattr_num_' . $i] == '') {
                continue;
            }

            $attr_fld_name = 'prodnumattr_num_' . $i;
            $data_to_save[] = array(
                'attr_attrgrp_id' => $attrgrp_id,
                'attr_identifier' => $post['attr_identifier_num_' . $i],
                'attr_type' => $post['attr_type_num_' . $i],
                'attr_fld_name' => $attr_fld_name
            );
        }
        /* ] */

        /* gathering textual data info to be save in db[ */

        // validation check
        for ($i = 1; $i <= AttrGroupAttribute::MAX_TEXTUAL_ATTRIBUTE_ROWS; $i++) {
            if ($post['prodtxtattr_text_' . $i] == '') {
                continue;
            }
            if (empty($post['attr_identifier_text_' . $i]) || empty($post['attr_type_text_' . $i])) {
                Message::addErrorMessage(Labels::getLabel('ERR_COULD_NOT_SAVE_DATA', $this->siteLangId));
                $this->attributes($attrgrp_id);
                return;
            }
        }

        for ($i = 1; $i <= AttrGroupAttribute::MAX_TEXTUAL_ATTRIBUTE_ROWS; $i++) {
            if ($post['prodtxtattr_text_' . $i] == '') {
                continue;
            }
            $attr_fld_name = 'prodtxtattr_text_' . $i;
            $data_to_save[] = array(
                'attr_attrgrp_id' => $attrgrp_id,
                'attr_identifier' => $post['attr_identifier_text_' . $i],
                'attr_type' => $post['attr_type_text_' . $i],
                'attr_fld_name' => $attr_fld_name
            );
        }
        /* ] */

        $attrGrpAttrObj = new AttrGroupAttribute();
        if (!$attrGrpAttrObj->addUpdateAttributes($attrgrp_id, $data_to_save)) {
            Message::addErrorMessage($attrGrpAttrObj->getError());
            FatApp::redirectUser(UrlHelper::generateUrl('Attributes'));
        }

        Message::addMessage(Labels::getLabel('MSG_RECORD_ADDED_SUCCESSFULLY', $this->siteLangId));
        FatApp::redirectUser(UrlHelper::generateUrl('Attributes'));
    }

    public function searchAttributes()
    {
        $this->objPrivilege->canViewAttributes();

        $post = FatApp::getPostedData();
        $attrgrp_id = FatUtility::int($post['attrgrp_id']);
        $attrgrp_row = AttributeGroup::getAttributesById($attrgrp_id);
        if (!$attrgrp_row) {
            LibHelper::exitWithError(Labels::getLabel('ERR_ATTRIBUTE_GROUP_NOT_SELECTED', $this->siteLangId), true);
        }

        $attrgrp_id = $attrgrp_row['attrgrp_id'];

        $db = FatApp::getDb();
        $srch = AttrGroupAttribute::getSearchObject();
        $srch->joinTable(AttrGroupAttribute::DB_TBL . '_lang', 'LEFT JOIN', 'lang.attrlang_attr_id = ' . AttrGroupAttribute::DB_TBL_PREFIX . 'id AND attrlang_lang_id = ' . $this->siteLangId, 'lang');
        $srch->addCondition(AttrGroupAttribute::DB_TBL_PREFIX . 'attrgrp_id', '=', 'mysql_func_' . $attrgrp_id, 'AND', true);
        $srch->addOrder(AttrGroupAttribute::DB_TBL_PREFIX . 'display_order');
        $srch->addMultipleFields(array('attrgrp.*', 'attr_name'));

        $rs = $srch->getResultSet();
        $attributes = $db->fetchAll($rs);

        $this->set('arrListing', $attributes);
        $this->set('attrgrp_row', $attrgrp_row);
        $this->set('attrgrp_id', $attrgrp_id);
        $this->set('postedData', $post);
        $this->set('languages', Language::getAllNames());
        $this->set('adminDefaultLangId', $this->siteLangId);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function manageAttributes($attrgrp_id)
    {
        $this->objPrivilege->canViewAttributes();
        $attrgrp_id = FatUtility::int($attrgrp_id);
        $attrgrp_row = AttributeGroup::getAttributesById($attrgrp_id);
        if (!$attrgrp_row) {
            Message::addErrorMessage(Labels::getLabel('ERR_ATTRIBUTE_GROUP_NOT_SELECTED', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Attributes'));
        }

        $attrgrp_id = $attrgrp_row['attrgrp_id'];
        $this->set('attrgrp_row', $attrgrp_row);
        $this->set('attrgrp_id', $attrgrp_id);
        $this->_template->render();
    }

    public function updateOrder()
    {
        $this->objPrivilege->canEditAttributes();

        $post = FatApp::getPostedData();
        $attrgrp_id = FatUtility::int($post['attrgrp_id']);
        if (!empty($post)) {
            $attrGrpAttrObj = new AttrGroupAttribute();
            if (!$attrGrpAttrObj->updateOrder($post['attributes'])) {
                LibHelper::exitWithError($attrGrpAttrObj->getError(), true);
            }
            FatUtility::dieJsonSuccess(Labels::getLabel('MSG_ORDER_UPDATED_SUCCESSFULLY', $this->siteLangId));
        }
    }

    public function langForm($autoFillLangData = 0)
    {
        $this->objPrivilege->canEditAttributes();
        $recordId = FatApp::getPostedData('attr_id', FatUtility::VAR_INT, 0);
        $lang_id = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        $lang_id = (!$lang_id) ? $this->siteLangId : $lang_id;
        if ($recordId == 0 || $lang_id == 0) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId), true);
        }
        $attrLangFrm = $this->getAttributeLangForm($recordId, $lang_id);

        $attrLangData = AttrGroupAttribute::getAttributesByLangId($lang_id, $recordId);
        if ($attrLangData) {
            $attrLangFrm->fill($attrLangData);
        }
        $this->set('languages', Language::getAllNames());
        $this->set('attr_id', $$recordId);
        $this->set('attr_lang_id', $lang_id);
        $this->set('attrLangFrm', $attrLangFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditAttributes();
        $post = FatApp::getPostedData();

        $attr_id = $post['attr_id'];
        $lang_id = $post['lang_id'];

        if ($attr_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId), true);
        }
        $frm = $this->getAttributeLangForm($attr_id, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['attr_id']);
        unset($post['lang_id']);
        $data_to_update = array(
            'attrlang_attr_id' => $attr_id,
            'attrlang_lang_id' => $lang_id,
            'attr_name' => $post['attr_name'],
            'attr_prefix' => $post['attr_prefix'],
            'attr_postfix' => $post['attr_postfix'],
        );

        if (isset($post['attr_options'])) {
            $data_to_update['attr_options'] = $post['attr_options'];
        }

        $attrGrpAttrObj = new AttrGroupAttribute($attr_id);
        if (!$attrGrpAttrObj->updateLangData($lang_id, $data_to_update)) {
            LibHelper::exitWithError($attrGrpAttrObj->getError(), true);
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = AttrGroupAttribute::getAttributesByLangId($langId, $attr_id)) {
                $newTabLangId = $langId;
                break;
            }
        }
        $this->set('msg', $this->str_update_record);
        $this->set('attr_id', $attr_id);
        $this->set('lang_id', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getAttributeFrm()
    {
        $frm = new Form('frmAttributes');
        $frm->addHtml('', 'numeric_section_heading', '');
        $langId = $this->siteLangId;
        /* numeric data input fields[ */
        for ($i = 1; $i <= AttrGroupAttribute::MAX_NUMERIC_ATTRIBUTE_ROWS; $i++) {
            //$frm->addHiddenField('','attr_id_num_'.$i);
            $frm->addCheckBox(Labels::getLabel('FRM_SELECT_THIS', $this->siteLangId), 'prodnumattr_num_' . $i, $i);
            $frm->addTextBox(Labels::getLabel('FRM_IDENTIFIER', $this->siteLangId), 'attr_identifier_num_' . $i);
            $frm->addSelectBox(Labels::getLabel('FRM_TYPE', $this->siteLangId), 'attr_type_num_' . $i, AttrGroupAttribute::getNumericAttributeTypeArr($langId), '', [], Labels::getLabel('FRM_SELECT', $this->siteLangId));
        }
        /* ] */

        $frm->addHtml('', 'text_section_heading', '');
        /* textual data input fields[ */
        for ($i = 1; $i <= AttrGroupAttribute::MAX_TEXTUAL_ATTRIBUTE_ROWS; $i++) {
            //$frm->addHiddenField('','attr_id_text_'.$i);
            $frm->addCheckBox(Labels::getLabel('FRM_SELECT_THIS', $this->siteLangId), 'prodtxtattr_text_' . $i, $i);
            $frm->addTextBox(Labels::getLabel('FRM_IDENTIFIER', $this->siteLangId), 'attr_identifier_text_' . $i);
            // $frm->addSelectBox( 'Type', 'attr_type_text_'.$i, AttrGroupAttribute::getTextualAttributeTypeArr($langId), '', array(), '' );
            $frm->addHiddenField(Labels::getLabel('FRM_TYPE', $this->siteLangId), 'attr_type_text_' . $i, AttrGroupAttribute::ATTRTYPE_TEXT);
        }
        /* ] */

        $frm->addHiddenField('', 'attrgrp_id');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    private function getAttributeLangForm($attr_id = 0, $lang_id = 0)
    {
        $attribute_row = AttrGroupAttribute::getAttributesById($attr_id);

        $frm = new Form('frmAttribute');
        $frm->addHiddenField('', 'attr_id', $attr_id);
        $frm->addHiddenField('', 'lang_id', $lang_id);
        $frm->addRequiredField(Labels::getLabel('FRM_ATTRIBUTE_NAME', $this->siteLangId), 'attr_name');
        $frm->addTextBox(Labels::getLabel('FRM_ATTRIBUTE_PREFIX', $this->siteLangId), 'attr_prefix');
        $frm->addTextBox(Labels::getLabel('FRM_ATTRIBUTE_SUFFIX', $this->siteLangId), 'attr_postfix');

        if ($attribute_row && ($attribute_row['attr_type'] == AttrGroupAttribute::ATTRTYPE_SELECT_BOX)) {
            /* i.e if type is select box, then need to enter options data */
            $fld = $frm->addTextArea(Labels::getLabel('FRM_OPTION_DATA', $this->siteLangId), 'attr_options');
            $fld->htmlAfterField = Labels::getLabel('FRM_ENTER_DATA_SEPARATED_BY_NEW_LINE:<br/>_E.g:<br/>_Yes<br/>No', $this->siteLangId);
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    private function getForm($attrgrp_id = 0)
    {
        $this->objPrivilege->canEditAttributes();
        $attrgrp_id = FatUtility::int($attrgrp_id);

        $action = Labels::getLabel('FRM_ADD_NEW', $this->siteLangId);
        if ($attrgrp_id > 0) {
            $action = Labels::getLabel('FRM_UPDATE', $this->siteLangId);
        }

        $frm = new Form('frmAttrGroup', array('id' => 'frmAttrGroup'));
        $frm->addHiddenField('', 'attrgrp_id', $attrgrp_id);
        $frm->addRequiredField(Labels::getLabel('FRM_ATTRIBUTE_GROUP_NAME', $this->siteLangId), 'attrgrp_name');
        return $frm;
    }
}
