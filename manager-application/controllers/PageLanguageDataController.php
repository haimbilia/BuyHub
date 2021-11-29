<?php
class PageLanguageDataController extends ListingBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function displayAlert()
    {
        $plangId = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if (1 > $plangId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $pageData = PageLanguageData::getAttributesById($plangId);
        if (false == $pageData) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $this->set('pageData', $pageData);
        $jsonData = [
            'html' => $this->_template->render(false, false, 'page-language-data/display-alert.php', true, true)
        ];        

        LibHelper::exitWithSuccess($jsonData, true);
    }
}
