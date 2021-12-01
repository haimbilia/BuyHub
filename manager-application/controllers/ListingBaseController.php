<?php
class ListingBaseController extends AdminBaseController
{
    protected int $mainTableRecordId = 0;
    protected bool $isPlugin = false;
    protected object $modelObj;
    protected array $formLangFields;
    protected bool $checkMediaExist = false;

    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function langForm($autoFillLangData = 0)
    {
        $this->mainTableRecordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);

        if (1 > $this->mainTableRecordId || 1 > $langId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $this->setLangTemplateData();
        $langFrm = $this->getLangForm($this->mainTableRecordId, $langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData($this->modelObj::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($this->mainTableRecordId, $langId);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = $this->modelObj::getAttributesByLangId($langId, $this->mainTableRecordId, null, true);
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        if (true === $this->isPlugin) {
            $pluginDetail = Plugin::getAttributesById($this->mainTableRecordId, ['plugin_type', 'plugin_identifier']);
            if (!in_array($pluginDetail['plugin_type'], Plugin::HAVING_DESCRIPTION)) {
                $langFrm->removeField($langFrm->getField('plugin_description'));
            }
        }

        $this->set('recordId', $this->mainTableRecordId);
        $this->set('lang_id', $langId);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));

        $className = get_called_class();
        $directory = (str_replace("-controller", "", strtolower(FatUtility::camel2dashed($className))));
        $renderPath = CONF_THEME_PATH . $directory . DIRECTORY_SEPARATOR . "lang-form.php";
        if (file_exists($renderPath)) {
            $this->_template->render(false, false);
        } else {
            $this->_template->render(false, false, '_partial/listing/lang-form.php');
        }
    }

    public function langSetup()
    {
        $this->setLangTemplateData();

        $recordId = FatApp::getPostedData($this->modelObj::tblFld('id'), FatUtility::VAR_INT, 0);
        $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);

        if (1 > $recordId || 1 > $lang_id) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($recordId, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $this->setLangTemplateData([$recordId]);

        if (1 > count($this->formLangFields)) {
            trigger_error('formLangFields must have array lang feild', E_USER_ERROR);
        }

        $data = [];
        foreach ($this->formLangFields as $fld) {
            $data[$fld] = $post[$fld];
        }

        $this->setLangData($this->modelObj, $data, $lang_id);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function setLangData(object $classObj, array $langDataArr, $langId = 0)
    {
        $recordId = $classObj->getMainTableRecordId(); 
        if (!$classObj->updateLangData((0 < $langId  ? $langId : CommonHelper::getDefaultFormLangId()), $langDataArr)) {
            LibHelper::exitWithError($classObj->getError(), true);
        } 
        $newTabLangId = 0;
        $languages = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        if (0 < count($languages)) {
            foreach ($languages as $languageId => $langName) {
                if (!$classObj::getAttributesByLangId($languageId, $recordId)) {
                    $newTabLangId = $languageId;
                    break;
                }
            }
        }

        if (1 > $langId) {
            $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
            if (0 < $autoUpdateOtherLangsData) {
                $updateLangDataobj = new TranslateLangData($classObj::DB_TBL_LANG);
                if (false === $updateLangDataobj->updateTranslatedData($recordId)) {
                    LibHelper::exitWithError($updateLangDataobj->getError(), true);
                }
            }
        }

        if ($this->checkMediaExist == true && $newTabLangId == 0 && !$this->isMediaUploaded($recordId)) {
            $this->set('openMediaForm', true);
        }

        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->set('msg', $this->str_setup_successful);
    }

    protected function getSearchForm($fields = [])
    {
        $fields = $this->getFormColumns();
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));

        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        if (!empty($fields)) {
            $this->addSortingElements($frm, current($allowedKeysForSorting));
        }

        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    /**
     * setModel - This function is used to set related model class and used by its parent class.
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setModel(array $constructorArgs = []): void
    {
        $this->modelObj = (new ReflectionClass($this->modelClass))->newInstanceArgs($constructorArgs);
    }

    public function updateStatus()
    {
        $this->checkEditPrivilege();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 == $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (!in_array($status, [applicationConstants::ACTIVE, applicationConstants::INACTIVE])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $this->changeStatus($recordId, $status);
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function changeStatus($recordId, $status)
    {
        $status = FatUtility::int($status);
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $this->setModel([$recordId]);
        if (!$this->modelObj->changeStatus($status)) {
            LibHelper::exitWithError($this->modelObj->getError(), true);
        }
    }

    public function toggleBulkStatuses()
    {
        $this->checkEditPrivilege();
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $recordsArr = FatUtility::int(FatApp::getPostedData('record_ids'));
        if (empty($recordsArr) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $this->setModel([0]);

        foreach ($recordsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }
            $this->changeStatus($recordId, $status);
        }
        /*
        if ($this->modelObj->bulkStatusUpdate($recordsArr, $status) == false) {
            LibHelper::exitWithError(Labels::getLabel($this->modelObj->getError(), $this->siteLangId), true);
        }
        */
        Product::updateMinPrices();
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->checkEditPrivilege();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        $this->markAsDeleted($recordId);
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteSelected()
    {
        $this->checkEditPrivilege();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('record_ids'));

        if (empty($recordIdsArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }
            $this->markAsDeleted($recordId);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        $this->setModel([$recordId]);
        /*
        if (!$this->modelObj->canMarkRecordDelete($recordId)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        */
        $this->modelObj->assignValues(
            [
                $this->modelObj::tblFld('deleted') => 1,
                $this->modelObj::tblFld('identifier') => 'mysql_func_CONCAT(' . $this->modelObj::tblFld('identifier') . ',"{deleted}",' . $this->modelObj::tblFld('id') . ')'
            ],
            false,
            '',
            '',
            true
        );
        if (!$this->modelObj->save()) {
            LibHelper::exitWithError($this->modelObj->getError(), true);
        }
    }

    protected function addSortingElements(Form $frm, string $sortBy, string $sortOrder = applicationConstants::SORT_ASC, int $pageSize = 0): void
    {
        $sortOrder = ($sortOrder != applicationConstants::SORT_ASC) ? applicationConstants::SORT_DESC : $sortOrder;
        $pageSize = empty($pageSize) ? FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10) : $pageSize;

        $frm->addHiddenField('', 'sortBy', $sortBy, ['id' => 'sortBy']);
        $frm->addHiddenField('', 'sortOrder', $sortOrder, ['id' => 'sortOrder']);
        $frm->addHiddenField('', 'pageSize', $pageSize);
        $frm->addHiddenField('', 'listingColumns', '');
    }
}
