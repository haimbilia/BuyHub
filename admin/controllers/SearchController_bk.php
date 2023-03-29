<?php

class SearchController extends ListingBaseController
{
    public function __construct($action)
    {
        AdminPrivilege::canViewUsers();
        parent::__construct($action);
    }
    
    public function index()
    {
    }
    
    public function getSearchForm(array $fields = [])
    {
        $frm = new Form('search_form');
        $frm->addTextBox(Labels::getLabel('FRM_NAME_OR_EMAIL_ID:', $this->siteLangId), 'name');
        $frm->addSelectBox(Labels::getLabel('FRM_ACTIVATION_STATUS', $this->siteLangId), 'user_active', array(-1 => 'Does not Matter', 0 => 'No', 1 => 'Yes'), -1, array(), Labels::getLabel('FRM_SELECT', $this->siteLangId));
        $frm->addSelectBox(Labels::getLabel('FRM_VERIFIED', $this->siteLangId), 'user_verified', array(-1 => 'Does not Matter', 0 => 'No', 1 => 'Yes'), -1, array(), Labels::getLabel('FRM_SELECT', $this->siteLangId));
        $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('BTN_SEARCH', $this->siteLangId));
        return $frm;
    }
}
