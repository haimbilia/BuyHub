<?php

class SettingsController extends ListingBaseController
{
    protected $pageKey = 'SETTINGS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSettings();
    }

    public function index()
    {
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->set('pageTitle', $pageTitle);

        $this->set('pageData', $pageData);
        $this->set('objPrivilege', $this->objPrivilege);
        $this->_template->render();
    }

    public function getBreadcrumbNodes($action)
    {
        $nodes = array();
        switch ($action) {
            case 'index':
                $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
                $nodes[] = array('title' => $pageTitle);
                break;
            default:
                parent::getBreadcrumbNodes($action);
                break;
        }
        return $nodes;
    }
}
