<?php

class SupportController extends ListingBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
    }
    
    public function index()
    {
        $data = AdminUsers::getAttributesById($this->admin_id, array('admin_username', 'admin_name', 'admin_email'));
        $frm = $this->getForm();
        $frm->fill($data);
        $this->set("frm", $frm);
        $this->_template->render();
    }

    private function getForm()
    {
        $frm = new Form('frmReportAnIssue');
        $frm->addTextBox(Labels::getLabel('LBL_User_Name', $this->siteLangId), 'admin_username', '', array('readonly' => 'readonly'));
        $frm->addTextBox(Labels::getLabel('LBL_User_Email', $this->siteLangId), 'admin_email');
        $frm->addRequiredField(Labels::getLabel('LBL_Title', $this->siteLangId), 'title');
        $frm->addTextArea(Labels::getLabel('LBL_Description', $this->siteLangId), 'description')->requirement->setRequired(true);
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Send', $this->siteLangId));
        return $frm;
    }
    
    public function reportIssue()
    {
        $data = FatApp::getPostedData();
        $adminData = AdminUsers::getAttributesById($this->admin_id, array('admin_username', 'admin_name', 'admin_email'));
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray($data);
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }
        
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: ' . FatApp::getConfig("CONF_FROM_NAME_" . $this->siteLangId) . "<" . $post['admin_email'] . ">" . "\r\nReply-to: " . $post['admin_email'];
        
        $body = "<b>Username:</b> " . $adminData['admin_username'] . '<br/>';
        $body .= "<b>Website:</b> " . FatApp::getConfig("CONF_WEBSITE_NAME_" . $this->siteLangId, FatUtility::VAR_STRING, '') . '<br/>';
        $body .= "<b>Description:</b> " . $post['description'] . '<br/>';
        
        if (!mail("team@fatbit.com", $post['title'], $body, $headers)) {
            Message::addErrorMessage($record->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $this->set('msg', Labels::getLabel('LBL_Mail_Sent_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
}
