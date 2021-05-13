<?php

class EarningsReportController extends AdminBaseController
{

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewAffiliatesReport();
    }

    public function index($orderDate = '')
    {
        $flds = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($flds);
        $this->set('frmSearch', $frmSearch);
        $this->_template->render();
    }
}
