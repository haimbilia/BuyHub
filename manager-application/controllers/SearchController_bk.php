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
    
    public function getSearchForm()
    {
        $frm = new Form('search_form');
        $frm->addTextBox(Labels::getLabel('LBL_Name_or_Email_ID:', $this->siteLangId), 'name');
        $frm->addSelectBox(Labels::getLabel('LBL_Active', $this->siteLangId), 'user_active', array(-1 => 'Does not Matter', 0 => 'No', 1 => 'Yes'), -1, array(), Labels::getLabel('LBL_Select', $this->siteLangId));
        $frm->addSelectBox(Labels::getLabel('LBL_Verified', $this->siteLangId), 'user_verified', array(-1 => 'Does not Matter', 0 => 'No', 1 => 'Yes'), -1, array(), Labels::getLabel('LBL_Select', $this->siteLangId));
        $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_Search', $this->siteLangId));
        return $frm;
    }
}
