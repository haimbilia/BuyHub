<?php
class SavedProductsSearchController extends LoggedUserController
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function listing()
    {
        $this->_template->render(true, true);
    }

    public function search()
    {
        $post = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $pageSize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);

        $srch = SavedSearchProduct::getSearchObject();
        $srch->addCondition('pssearch_user_id', '=', $this->userId); 
        $this->setRecordCount(clone $srch, $pageSize, $page, $post); 
        $srch->doNotCalculateRecords(); 
        $srch->addOrder('pssearch_added_on', 'DESC');
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();
        $arrListing = FatApp::getDb()->fetchAll($rs, 'pssearch_id');

        foreach ($arrListing as $key => $val) {
            $searchedArr = SearchItem::convertUrlStringToArr($val['pssearch_url']);
            $searchItems = SearchItem::convertArrToSrchFiltersAssocArr($searchedArr);
            $arrListing[$key]['search_items'] = SavedSearchProduct::getSearhResultFormat($searchItems, $this->siteLangId);
            $arrListing[$key]['search_url'] = SavedSearchProduct::getSearchPageFullUrl($val['pssearch_type'], $val['pssearch_record_id']) . '?' . $val['pssearch_url'];
            $arrListing[$key]['totalRecords'] = 0;
            $arrListing[$key]['newRecords'] = 0;
        } 
        $this->set('postedData', $post);
        $this->set('arrListing', $arrListing);
        $this->_template->render(false, false);
    }

    public function form()
    {
        $frm = $this->getForm();
        $frm->fill(array('user_id' => $this->userId));
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $frm = $this->getForm();

        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $curr_page = FatApp::getPostedData('curr_page', FatUtility::VAR_STRING, UrlHelper::generateFullUrl('', '', [], CONF_WEBROOT_FRONTEND));
        $searchedUrlString = !isset($_SERVER['HTTP_REFERER']) ? $curr_page : str_replace($curr_page, '', $_SERVER['HTTP_REFERER']);

        $url = ltrim(ltrim($searchedUrlString, '/'), '?');
        $srch = SavedSearchProduct::getSearchObject();
        $srch->addFld('pssearch_id');
        $srch->addCondition('pssearch_url', 'LIKE', $url);
        $srch->setPageSize(1);
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $result = FatApp::getDb()->fetch($rs);
        if (!empty($result)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_THIS_SEARCH_QUERY_ALREADY_SAVED_UNDER_SAVED_SEARCHES.'), true);
        }

        $post['pssearch_type'] = FatApp::getPostedData('pssearch_type', FatUtility::VAR_INT, 0);
        $post['pssearch_record_id'] = FatApp::getPostedData('pssearch_record_id', FatUtility::VAR_INT, 0);
        $post['pssearch_user_id'] = $this->userId;
        $post['pssearch_added_on'] = date('Y-m-d H:i:s');
        $post['pssearch_updated_on'] = date('Y-m-d H:i:s');
        $post['pssearch_url'] = ltrim(ltrim($searchedUrlString, '/'), '?');        
        $savedSearchProduct = new SavedSearchProduct();
        $savedSearchProduct->assignValues($post);

        if (!$savedSearchProduct->save()) {
            LibHelper::exitWithError(Labels::getLabel('ERR_CAN_NOT_BE_SAVED', $this->siteLangId), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Saved_successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm()
    {
        $frm = new Form('frmSavedSearch');
        $frm->setRequiredStarWith('NONE');
        $frm->addRequiredField('', 'pssearch_name');
        //$frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_ADD', $this->siteLangId));
        $frm->addHtml('', 'btn_submit', HtmlHelper::addButtonHtml(Labels::getLabel('BTN_ADD', $this->siteLangId), 'submit', 'btn_submit', 'btn-apply'));
        $frm->setJsErrorDisplay('afterfield');
        return $frm;
    }

    public function deleteSavedSearch()
    {
        $post = FatApp::getPostedData();
        if ($post == false) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $pssearch_id = FatUtility::int($post['pssearch_id']);
        if (1 > $pssearch_id) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $srch = SavedSearchProduct::getSearchObject();
        $srch->addCondition('pssearch_id', '=', $pssearch_id);
        $rs = $srch->getResultSet();
        $data = FatApp::getDb()->fetchAll($rs, 'pssearch_id');
        if ($data === false) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $savedSearch = new SavedSearchProduct($pssearch_id);
        if (!$savedSearch->deleteRecord()) {
            Message::addErrorMessage($savedSearch->getError());
            FatUtility::dieWithError(Message::getHtml());
        }

        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_Deleted_successfully', $this->siteLangId));
    }
}
