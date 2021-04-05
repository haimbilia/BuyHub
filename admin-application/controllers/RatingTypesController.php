<?php

use PhpParser\Node\Stmt\Label;

class RatingTypesController extends AdminBaseController
{
    private $canEdit;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();

        $this->objPrivilege->canViewRatingTypes($this->admin_id);
    }

    public function index()
    {        
        $frmSearch = $this->getSearchForm();
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
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

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

        $this->set('msg', Labels::getLabel('MGS_ADDED_SUCCESSFULL', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditRatingTypes();

        $rtId = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if ($rtId < 1) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        if (false == RatingType::getAttributesById($rtId)) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        $this->markAsDeleted($rtId);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditRatingTypes();
        $ratingTypeIdsArr = FatUtility::int(FatApp::getPostedData('rt_ids'));

        if (empty($ratingTypeIdsArr)) {
            FatUtility::dieJsonError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId)
            );
        }

        foreach ($ratingTypeIdsArr as $rtId) {
            if (1 > $rtId || false === RatingType::getAttributesById($rtId)) {
                continue;
            }

            $this->markAsDeleted($rtId);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function markAsDeleted($rtId)
    {
        $rtId = FatUtility::int($rtId);
        if (1 > $rtId) {
            FatUtility::dieJsonError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId)
            );
        }
        $obj = new RatingType($rtId);
        if (!$obj->deleteRecord(false)) {
            FatUtility::dieJsonError($obj->getError());
        }
    }

    private function getSearchForm(int $langId = 0)
    {
        $langId = 1 > $langId ? $this->adminLangId : $langId;
        $frm = new Form('frmWordSearch');
        $frm->addTextBox(Labels::getLabel('LBL_KEYWORD', $langId), 'keyword', '');
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $langId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $langId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function getForm(int $langId = 0)
    {
        $langId = 1 > $langId ? $this->adminLangId : $langId;
        $frm = new Form('frmRatingTypes');
        $frm->addHiddenField('', 'rt_id');
        $languages = Language::getAllNames();
        $frm->addSelectBox(Labels::getLabel('LBL_Language', $langId), 'rtlang_lang_id', $languages, '', array(), Labels::getLabel('LBL_Select', $langId));
        $frm->addTextbox(Labels::getLabel('LBL_RATING_TYPE', $langId), 'rt_name');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SAVE', $langId));
        return $frm;
    }
}
