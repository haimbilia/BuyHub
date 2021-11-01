<?php

class PluginsController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewPlugins();
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->objPrivilege->canEditPlugins();
        $this->modelObj = (new ReflectionClass('Plugin'))->newInstanceArgs($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('name'), $this->modelObj::tblFld('description')];
        $this->isPlugin = true;
        $identifier = Plugin::getAttributesById($this->mainTableRecordId, 'plugin_identifier');
        $this->set('formTitle', CommonHelper::replaceStringData(Labels::getLabel('LBL_{PLUGIN-NAME}_PLUGIN_SETUP', $this->siteLangId), ['{PLUGIN-NAME}' => $identifier]));
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'type');
        $frm->addHiddenField('', 'page', 1);
        if (!empty($fields)) {
            $this->addSortingElements($frm);
        }
        return $frm;
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $frmSearch->fill(['type' => Plugin::TYPE_CURRENCY_CONVERTER]);

        $this->set('frmSearch', $frmSearch);
        $this->set('activeTab', Plugin::TYPE_CURRENCY_CONVERTER);
        $this->set('includeEditor', true);
        $this->getListingData();

        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'plugins/search.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $db = FatApp::getDb();

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);

        $type = FatApp::getPostedData('type', FatUtility::VAR_INT, PluginCommon::TYPE_CURRENCY_CONVERTER);

        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'plugin_display_order');
        if ((empty($sortBy) || 'listSerial' == $sortBy) && !in_array($type, Plugin::getKingpinTypeArr())) {
            $sortBy = 'plugin_display_order';
        } else if (!array_key_exists($sortBy, $fields) && 'plugin_display_order' != $sortBy) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_ASC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $attr = array(
            'plg.*',
            'plg_l.*',
            'conf.*',
            'plugin_id as listSerial'
        );
        $srch = Plugin::getSearchObject($this->siteLangId, false);
        $srch->joinTable(Configurations::DB_TBL, 'LEFT JOIN', "conf_val = plugin_id AND conf_name = 'CONF_DEFAULT_PLUGIN_" . $type . "'", 'conf');
        $srch->addCondition('plugin_type', '=', $type);
        $srch->addMultipleFields($attr);

        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $srch->addOrder('plugin_active', 'DESC');
        $srch->addOrder($sortBy, $sortOrder);
        $srch->doNotLimitRecords();
        $arrListing = $db->fetchAll($srch->getResultSet());
        $activeTaxPluginFound = false;
        if (Plugin::TYPE_TAX_SERVICES == $type) {
            array_walk($arrListing, function ($val) use (&$activeTaxPluginFound) {
                if (Plugin::ACTIVE == $val[Plugin::DB_TBL_PREFIX . 'active']) {
                    $activeTaxPluginFound = true;
                    return;
                }
            });
        }

        $pluginTypes = Plugin::getTypeArr($this->siteLangId);
        $groupType = Plugin::getGroupType($type);
        $otherPluginTypes = '';
        if (!empty($groupType)) {
            foreach ($groupType as $pluginType) {
                if ($type == $pluginType) {
                    continue;
                }
                $gptSrch = Plugin::getSearchObject(0, true);
                $gptSrch->addCondition('plg.'. Plugin::DB_TBL_PREFIX . 'type', '=', $pluginType);
                $gptSrch->setPageSize(1);
                $gptSrch->getResultSet();
                if (0 < $gptSrch->recordCount()) {
                    $otherPluginTypes .= $pluginTypes[$pluginType] . ', ';
                }
            }
            $otherPluginTypes = rtrim($otherPluginTypes, ', ');
        }

        $this->set("arrListing", $arrListing);
        $this->set('recordCount', $srch->recordCount());
        $this->set('postedData', FatApp::getPostedData());
        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->siteLangId));

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set("activeTaxPluginFound", $activeTaxPluginFound);
        $this->set("type", $type);
        $this->set("pluginTypes", $pluginTypes);
        $this->set("otherPluginTypes", $otherPluginTypes);
        $this->set('canEdit', $this->objPrivilege->canEditCommissionSettings($this->admin_id, true));
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = Plugin::getAttributesByLangId($this->getDefaultFormLangId(), $recordId, null, true);
        $pluginType = $data['plugin_type'];
        $frm = $this->getForm($pluginType, $recordId);
        $identifier = '';
        if (0 < $recordId) {
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }

            if (in_array($pluginType, Plugin::getKingpinTypeArr())) {
                $defaultCurrConvAPI = FatApp::getConfig('CONF_DEFAULT_PLUGIN_' . $pluginType, FatUtility::VAR_INT, 0);
                if (!empty($defaultCurrConvAPI)) {
                    $data['CONF_DEFAULT_PLUGIN_' . $pluginType] = $defaultCurrConvAPI;
                }
            }
            $identifier = $data['plugin_identifier'];
            $frm->fill($data);
        }

        $this->set('languages', Language::getDropDownList($this->getDefaultFormLangId()));
        $this->set('recordId', $recordId);
        $this->set('type', $pluginType);
        $this->set('frm', $frm);
        $this->set('formTitle', CommonHelper::replaceStringData(Labels::getLabel('LBL_{PLUGIN-NAME}_PLUGIN_SETUP', $this->siteLangId), ['{PLUGIN-NAME}' => $identifier]));
        $this->_template->render(false, false, '_partial/listing/form.php');
    }

    public function setup()
    {
        $this->objPrivilege->canEditPlugins();
        $post = FatApp::getPostedData();
        $recordId = $post['plugin_id'];
        $pluginType = $post['plugin_type'];
        $frm = $this->getForm($pluginType, $recordId);
        $post = $frm->getFormDataFromArray($post);
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }
        unset($post['plugin_id'], $post['plugin_type']);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (0 < $recordId) {
            $recordId = Plugin::getAttributesById($recordId, 'plugin_id');
            if ($recordId === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
        }

        $record = new Plugin($recordId);
        $post['plugin_identifier'] = $post['plugin_name'];
        $record->assignValues($post);
        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }
        $this->setLangData($record, [$record::tblFld('name') => $post[$record::tblFld('name')]]);

        $newTabLangId = 0;
        if ($recordId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = Plugin::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $recordId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        if (in_array($pluginType, Plugin::getKingpinTypeArr())) {
            $defaultCurrConvAPI = FatApp::getConfig('CONF_DEFAULT_PLUGIN_' . $pluginType, FatUtility::VAR_INT, 0);
            if (!empty($post['CONF_DEFAULT_PLUGIN_' . $pluginType]) || empty($defaultCurrConvAPI)) {
                $confVal = empty($defaultCurrConvAPI) ? $recordId : $post['CONF_DEFAULT_PLUGIN_' . $pluginType];
                $confRecord = new Configurations();
                if (!$confRecord->update(['CONF_DEFAULT_PLUGIN_' . $pluginType => $confVal])) {
                    LibHelper::exitWithError($confRecord->getError(), true);
                }
            }
        }

        $this->set('msg', $this->str_update_record);
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function uploadIcon($plugin_id)
    {
        $this->objPrivilege->canEditPlugins();

        $plugin_id = FatUtility::int($plugin_id);

        if (1 > $plugin_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $post = FatApp::getPostedData();

        if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('MSG_Please_select_a_file', $this->siteLangId), true);
        }

        $fileHandlerObj = new AttachedFile();
        $res = $fileHandlerObj->saveAttachment($_FILES['file']['tmp_name'], AttachedFile::FILETYPE_PLUGIN_LOGO, $plugin_id, 0, $_FILES['file']['name'], -1, $unique_record = true);
        if (!$res) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('pluginId', $plugin_id);
        $this->set('file', $_FILES['file']['name']);
        $this->set('msg', $_FILES['file']['name'] . ' ' . Labels::getLabel('LBL_File_Uploaded_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateOrder()
    {
        $this->objPrivilege->canEditPlugins();

        $post = FatApp::getPostedData();

        if (!empty($post)) {
            $pluginObj = new Plugin();
            if (!$pluginObj->updateOrder($post['plugin'])) {
                LibHelper::exitWithError($pluginObj->getError(), true);
            }

            $this->set('msg', Labels::getLabel('LBL_Order_Updated_Successfully', $this->siteLangId));
            $this->_template->render(false, false, 'json-success.php');
        }
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditPlugins();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (0 >= $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = Plugin::getAttributesById($recordId, array('plugin_id', 'plugin_active', 'plugin_type'));

        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (false == Plugin::updateStatus($data['plugin_type'], $status, $recordId, $error)) {
            LibHelper::exitWithError($error, true);
        }

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function changeStatusByType()
    {
        $this->objPrivilege->canEditPlugins();
        $recordId = FatApp::getPostedData('pluginId', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (0 >= $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = Plugin::getAttributesById($recordId, array('plugin_id', 'plugin_active', 'plugin_type'));

        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (false == Plugin::updateStatus($data['plugin_type'], $status, $recordId, $error)) {
            LibHelper::exitWithError($error, true);
        }

        if (Plugin::ACTIVE == $status) {
            $groupType = Plugin::getGroupType($data['plugin_type']);
            $eitherPluginTypes = array_values(array_diff($groupType, [$data['plugin_type']]));

            foreach ($eitherPluginTypes as $pluginType) {
                if (false == Plugin::updateStatus($pluginType, Plugin::INACTIVE, null, $error)) {
                    LibHelper::exitWithError($error, true);
                }
            }
        }

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($pluginType, $recordId = 0)
    {
        $recordId = FatUtility::int($recordId);

        $frm = new Form('frmPlugin');
        $frm->addHiddenField('', 'plugin_id', $recordId);
        $frm->addHiddenField('', 'plugin_type', $pluginType);
        $frm->addRequiredField(Labels::getLabel('LBL_Plugin_Name', $this->siteLangId), 'plugin_name');

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->siteLangId), 'plugin_active', $activeInactiveArr, '', array(), '');

        if (in_array($pluginType, Plugin::getKingpinTypeArr())) {
            $frm->addCheckBox(Labels::getLabel('LBL_MARK_AS_DEFAULT', $this->siteLangId), 'CONF_DEFAULT_PLUGIN_' . $pluginType, $recordId, array(), false, 0);
        }

        if (in_array($pluginType, Plugin::getSeparateIconTypeArr())) {
            $fld = $frm->addButton(
                'Icon',
                'plugin_icon',
                Labels::getLabel('LBL_Upload_File', $this->siteLangId),
                array('class' => 'btn btn-outline-brand btn-sm uploadFile-Js', 'id' => 'plugin_icon', 'data-plugin_id' => $recordId)
            );
            if ($attachment = AttachedFile::getAttachment(AttachedFile::FILETYPE_PLUGIN_LOGO, $recordId)) {
                $uploadedTime = AttachedFile::setTimeParam($attachment['afile_updated_at']);
                $fld->htmlAfterField .= '<div class="uploaded--image">
                <img src="'.UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'plugin', array($recordId,'LARGE'), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg').'"></div>';

            }
        }

        return $frm;
    }

    protected function getLangForm($recordId = 0, $lang_id = 0)
    {
        $frm = new Form('frmPluginLang');
        $frm->addHiddenField('', 'plugin_id', $recordId);

        $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->siteLangId), 'lang_id', Language::getDropDownList($this->getDefaultFormLangId()), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('LBL_Plugin_Name', $this->siteLangId), 'plugin_name');
        $frm->addHtmlEditor(Labels::getLabel('LBL_EXTRA_INFO', $this->siteLangId), 'plugin_description');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditPlugins();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $pluginType = FatApp::getPostedData('plugin_type', FatUtility::VAR_INT, 0);
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('plugin_ids'));
        if (empty($recordIdsArr) || -1 == $status || 1 > $pluginType) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true);
        }
        $error = '';
        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }
            Plugin::updateStatus($pluginType, $status, $recordId, $error);
        }
        $msg = !empty($error) ? $error : $this->str_update_record;
        $this->set('msg', $msg);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function changeBulkStatusByType()
    {
        $this->objPrivilege->canEditPlugins();
        $pluginGroupType = FatApp::getPostedData('plugin_type', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);

        $recordIdsArr = FatUtility::int(FatApp::getPostedData('plugin_ids'));
        if (empty($recordIdsArr) || -1 == $status || 1 > $pluginGroupType) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }
            Plugin::updateStatus($pluginGroupType, $status, $recordId);
        }

        if (Plugin::ACTIVE == $status) {
            $groupType = Plugin::getGroupType($pluginGroupType);
            $eiherPluginTypes = array_values(array_diff($groupType, [$pluginGroupType]));

            foreach ($eiherPluginTypes as $pluginType) {
                if (false == Plugin::updateStatus($pluginType, Plugin::INACTIVE, null, $error)) {
                    LibHelper::exitWithError($error, true);
                }
            }
        }

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getFormColumns(): array
    {
        $pluginsTblHeadingCols = CacheHelper::get('pluginsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($pluginsTblHeadingCols) {
            return json_decode($pluginsTblHeadingCols);
        }

        $arr = [
            'dragdrop' => '',
            'select_all' => Labels::getLabel('LBL_Select_all', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'plugin_icon' => Labels::getLabel('LBL_PLUGIN_ICON', $this->siteLangId),
            'plugin_name' => Labels::getLabel('LBL_PLUGIN', $this->siteLangId),
            'plugin_active' => Labels::getLabel('LBL_Status', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('pluginsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'dragdrop',
            'select_all',
            'listSerial',
            'plugin_icon',
            'plugin_name',
            'plugin_active',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['dragdrop', 'plugin_icon', 'plugin_active'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_SETTINGS', $this->siteLangId), 'href' => UrlHelper::generateUrl('Settings')],
                    ['title' => Labels::getLabel('LBL_PLUGINS', $this->siteLangId)]
                ];
        }
        return $this->nodes;
    }
}
