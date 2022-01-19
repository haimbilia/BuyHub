<?php

class TestController extends ListingBaseController
{
    public function checkEditor()
    {
        $this->_template->render();
    }

    public function loadForm()
    {
        $frm = new Form('frmWithEditor');
        $frm->addTextBox(Labels::getLabel('FRM_NAME', $this->siteLangId), 'name');
        $frm->addHtmlEditor(Labels::getLabel('FRM_HTML', $this->siteLangId), 'html');

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SUBMIT', $this->siteLangId));

        $this->set('frm', $frm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function submitForm()
    {
        die(print_r(FatApp::getPostedData(), true));
    }
}
