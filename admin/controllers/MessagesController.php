<?php
class MessagesController extends ListingBaseController
{
    protected $pageKey = 'MANAGE_MESSAGES';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewMessages();
    }

    public function getMsgSearchForm()
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page', 1);
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '', ['title'=> Labels::getLabel('FRM_SEARCH_BY_SUBJECT_AND_MESSAGE', $this->siteLangId),'placeholder' => Labels::getLabel('FRM_SEARCH_BY_SUBJECT_OR_MESSAGE', $this->siteLangId)]);
        $fld->overrideFldType('search');

        $frm->addSelectBox(Labels::getLabel('FRM_MESSAGE_BY', $this->siteLangId), 'message_by', [], '', ['placeholder' => Labels::getLabel('FRM_SEARCH', $this->siteLangId)]);
        $frm->addSelectBox(Labels::getLabel('FRM_MESSAGE_TO', $this->siteLangId), 'message_to', [], '', ['placeholder' => Labels::getLabel('FRM_SEARCH', $this->siteLangId)]);
        $frm->addDateField(Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'date_from', '', array('placeholder' => Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addDateField(Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'date_to', '', array('placeholder' => Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);/*clearBtn*/
        return $frm;
    }

    public function index()
    {
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $frmSearch = $this->getMsgSearchForm();
        $this->set('frmSearch', $frmSearch);
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->getListingData();

        $this->_template->addJs(array('js/select2.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'messages/search.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }
        
    /**
     * Used for load more functionality
     */
    public function getRows()
    {
        $this->getListingData();
        $jsonData = [
            'html' => $this->_template->render(false, false, 'messages/search.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'message_date');
        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING), applicationConstants::SORT_DESC);
        $srchFrm = $this->getMsgSearchForm();

        $postedData = FatApp::getPostedData();
        $post = $srchFrm->getFormDataFromArray($postedData);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = new MessageSearch();
        $srch->joinThreadLastMessage();
        $srch->joinMessagePostedFromUser(true, $this->siteLangId);
        $srch->joinMessagePostedToUser(true, $this->siteLangId);
        $srch->joinThreadStartedByUser();
        $srch->addMultipleFields(array(
            'tth.*', 'ttm.*', 'tfr.user_id as message_sent_by', 'tfr.user_updated_on as message_from_user_updated_on',
            'tfr.user_phone as message_from_user_phone', 'tfr.user_phone_dcode as message_from_user_phone_dcode',
            'tfr.user_name as message_sent_by_username', 'tfto.user_id as message_sent_to', 'tfto.user_updated_on as message_to_user_updated_on',
            'tfto.user_name as message_sent_to_name', 'tfto_c.credential_email as message_sent_to_email',
            'tfrs.shop_id as message_from_shop_id', 'tftos.shop_id as message_to_shop_id',
            'tfto.user_name as message_sent_to_name', 'IFNULL(tftos_l.shop_name, tftos.shop_identifier) as message_to_shop_name',
             'IFNULL(tfrs_l.shop_name, tfrs.shop_identifier) as message_from_shop_name'
        ));

        $srch->addGroupBy('ttm.message_thread_id');
        if (!empty($post['thread_id'])) {
            $srch->addCondition('tth.thread_id', '=', $post['thread_id']);
        }
        $srch->addCondition('ttm.message_deleted', '=', 0);
        $srch->addCondition('tfr.user_deleted', '=', applicationConstants::NO);
        $srch->addCondition('tfto.user_deleted', '=', applicationConstants::NO);

        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        if (!empty($keyword)) {
            $condition = $srch->addCondition('tth.thread_subject', 'like', '%' . $keyword . '%');
            $condition->attachCondition('ttm.message_text', 'like', '%' . $keyword . '%');
        }

        $date_from = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
        if (!empty($date_from)) {
            $srch->addCondition('ttm.message_date', '>=', $date_from . ' 00:00:00');
        }

        $date_to = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');
        if (!empty($date_to)) {
            $srch->addCondition('ttm.message_date', '<=', $date_to . ' 23:59:59');
        }

        $messageBy = FatApp::getPostedData('message_by', FatUtility::VAR_INT, '');
        if (!empty($messageBy)) {
            $srch->addCondition('tfr.user_id', '=', $messageBy);
        }

        $messageTo = FatApp::getPostedData('message_to', FatUtility::VAR_INT, '');
        if (!empty($messageTo)) {
            $srch->addCondition('tfto.user_id', '=', $messageTo);
        }

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('searchkeyword', FatApp::getPostedData('keyword', FatUtility::VAR_STRING));        

        $paginationArr = empty($postedData) ? $post : $postedData;
        $this->set('postedData', $paginationArr);

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('canEdit', $this->objPrivilege->canEditCommissionSettings($this->admin_id, true));
    }

    public function viewThread(int $threadId)
    {
        if (empty($threadId)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $srch = new MessageSearch();
        $srch->joinThreadMessage();
        $srch->joinMessagePostedFromUser(true, $this->siteLangId);
        $srch->joinMessagePostedToUser();
        $srch->joinShops($this->siteLangId);
        $srch->joinOrderProducts($this->siteLangId);
        $srch->addMultipleFields(array(
            'tth.*', 'ttm.*',
            'tfr.user_id as message_sent_by', 'tfr.user_updated_on as message_from_user_updated_on', 'tfr.user_phone as message_from_user_phone', 'tfr.user_phone_dcode as message_from_user_phone_dcode', 'tfr.user_name as message_sent_by_username', 'tfto.user_id as message_sent_to', 'tfto.user_updated_on as message_to_user_updated_on',
            'tfto.user_name as message_sent_to_name', 'tfto_c.credential_email as message_sent_to_email',
            'tfrs.shop_id as message_from_shop_id', 'tfrs.shop_user_id as message_from_shop_user_id', 'tfto.user_name as message_sent_to_name', 'IFNULL(tfrs_l.shop_name, tfrs.shop_identifier) as message_from_shop_name'
        ));
        $srch->addCondition('message_deleted', '=', applicationConstants::NO);
        $srch->addCondition('tth.thread_id', '=', $threadId);
        $srch->addCondition('tfr.user_deleted', '=', applicationConstants::NO);
        $srch->addCondition('tfto.user_deleted', '=', applicationConstants::NO);

        $records = FatApp::getDb()->fetchAll($srch->getResultSet());      
        $this->set("threadListing", $records);       
        $this->set('searchkeyword', FatApp::getPostedData('searchkeyword', FatUtility::VAR_STRING)); 
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
}
