<?php

class TestController extends AdminBaseController
{
    public function checkEditor()
    {
        $this->_template->render();
    }

    public function loadForm()
    {
        $frm = new Form('frmWithEditor');
        $frm->addTextBox(Labels::getLabel('LBL_Name', $this->siteLangId), 'name');
        $frm->addHtmlEditor(Labels::getLabel('LBL_HTML', $this->siteLangId), 'html');

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Submit', $this->siteLangId));

        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function submitForm()
    {
        die(print_r(FatApp::getPostedData(), true));
    }
}
