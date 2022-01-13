<?php
class GettingStartedController extends ListingBaseController
{
    protected $pageKey = 'GETTING_STARTED';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewGettingStarted();
    }

    public function index()
    {
        $tourSteps = SiteTourHelper::getStepsData($this->siteLangId);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('tourSteps', $tourSteps);
        $this->_template->render();
    }
}
