<?php

use PhpParser\Node\Stmt\Label;

class RatingTypesController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();

        $this->objPrivilege->canViewRatingTypes($this->admin_id);
    }

    public function index()
    {        
        $frmSearch = $this->getSearchForm();
        $this->set("canEdit", $this->objPrivilege->canEditRatingTypes($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->_template->render();
    }

    public function search()
    {
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            FatUtility::dieJsonError(current($searchForm->getValidationErrors()));
        }

        $srch = new RatingTypeSearch($this->adminLangId);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $keyword = $post['keyword'];
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('rt_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('rt_identifier', 'like', '%' . $keyword . '%');
        }
        $srch->addOrder('rt_id', 'DESC');
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set("canEdit", $this->objPrivilege->canEditRatingTypes($this->admin_id, true));
        $this->set("arr_listing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    public function form(int $rtId)
    {
        $this->objPrivilege->canEditRatingTypes();
        $frm = $this->getForm();

        $data = [];
        if ($rtId > 0) {
            $data = (array) RatingType::getAttributesById($rtId);
            if (empty($data)) {
                FatUtility::dieWithError($this->str_invalid_request);
            }
        }

        $frm->fill($data);
        $this->set('frm', $frm);
        $this->set('rtId', $rtId);
        $this->_template->render(false, false);
    }

    public function langForm(int $rtId, int $langId, int $autoFillLangData = 0)
    {
        $this->objPrivilege->canEditRatingTypes();
        $frm = $this->getLangForm($langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(RatingType::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($rtId, $langId);
            if (false === $translatedData) {
                Message::addErrorMessage($updateLangDataobj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
            $langData = current($translatedData);
        } else {
            $langData = RatingType::getAttributesByLangId($langId, $rtId);
        }

        $langData['rtlang_rt_id'] = $rtId;
        $langData['rtlang_lang_id'] = $langId;
        $frm->fill($langData);

        $this->set('languages', Language::getAllNames());
        $this->set('rt_id', $rtId);
        $this->set('rt_lang_id', $langId);
        $this->set('frm', $frm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditRatingTypes();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $rtId = FatApp::getPostedData('rt_id', FatUtility::VAR_INT, 0);

        $record = new RatingType($rtId);
        $record->assignValues($post);
        if (!$record->save()) {
            FatUtility::dieJsonError($record->getError());
        }

        $rtId = $record->getMainTableRecordId();
        $newTabLangId = 0;
        if ($rtId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!RatingType::getAttributesByLangId($langId, $rtId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        $this->set('rtId', $rtId);
        $this->set('langId', $newTabLangId);
        $this->set('msg', Labels::getLabel('MGS_ADDED_SUCCESSFULLY', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditRatingTypes();

        $langId = FatApp::getPostedData('rtlang_lang_id', FatUtility::VAR_INT, $this->adminLangId);
        $frm = $this->getLangForm($langId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $rtId = FatApp::getPostedData('rtlang_rt_id', FatUtility::VAR_INT, 0);
        if (1 > $rtId) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }
        unset($post['auto_update_other_langs_data'], $post['btn_submit']);

        $ratingTypeObj = new RatingType($rtId);
        if (!$ratingTypeObj->updateLangData($langId, $post)) {
            FatUtility::dieJsonError($ratingTypeObj->getError());
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(RatingType::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($rtId)) {
                FatUtility::dieJsonError($updateLangDataobj->getError());
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!RatingType::getAttributesByLangId($langId, $rtId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', Labels::getLabel('MSG_UPDATED_SUCCESSFULLY', $this->adminLangId));
        $this->set('rtId', $rtId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getSearchForm()
    {
        $frm = new Form('frmWordSearch');
        $frm->addTextBox(Labels::getLabel('LBL_KEYWORD', $this->adminLangId), 'keyword', '');
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function getForm()
    {
        $frm = new Form('frmRatingTypes');
        $frm->addHiddenField('', 'rt_id');
        $frm->addRequiredField(Labels::getLabel('LBL_RATING_TYPE', $this->adminLangId), 'rt_identifier');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SAVE', $this->adminLangId));
        return $frm;
    }

    private function getLangForm(int $langId)
    {
        $frm = new Form('frmRatingTypes');
        $frm->addHiddenField('', 'rtlang_rt_id');
        $languages = Language::getAllNames();
        $frm->addSelectBox(Labels::getLabel('LBL_Language', $langId), 'rtlang_lang_id', $languages, $langId, [], '');
        $frm->addRequiredField(Labels::getLabel('LBL_RATING_TYPE', $langId), 'rt_name');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $langId == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $langId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SAVE', $langId));
        return $frm;
    }
}
