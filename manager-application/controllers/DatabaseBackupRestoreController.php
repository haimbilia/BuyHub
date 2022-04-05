<?php

class DatabaseBackupRestoreController extends ListingBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->siteLangId = CommonHelper::getLangId();
    }
    public function index()
    {
        $this->objPrivilege->canViewDatabaseBackupView();
        $settingsObj = new Settings();
        $backup_frm = $this->getBackupForm();
        $upload_frm = $this->getUploadForm();
        $post = FatApp::getPostedData();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($post['submit_backup'])) {
            $this->objPrivilege->canEditDatabaseBackupView();
            $settingsObj = new Settings();
            $settingsObj->backupDatabase(trim($post["name"]));
            Message::addMessage(Labels::getLabel('SUC_DATABASE_BACKUP_ON_SERVER_CREATED_SUCCESSFULLY', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('DatabaseBackupRestore'));
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($post['submit_upload'])) {
            $this->objPrivilege->canEditDatabaseBackupView();
            $ext = strrchr($_FILES['file']['name'], '.');
            if (strtolower($ext) != '.sql') {
                Message::addErrorMessage(Labels::getLabel('ERR_FILE_TYPE_UNSUPPORTE._PLEASE_UPLOAD_SQL_FILE', $this->siteLangId));
                FatApp::redirectUser(UrlHelper::generateUrl('DatabaseBackupRestore'));
            }
            if (!self::saveFile($_FILES['file']['tmp_name'], $_FILES['file']['name'], CONF_DB_BACKUP_DIRECTORY . '/')) {
                Message::addErrorMessage(Labels::getLabel('ERR_FILE_COULD_NOT_BE_SAVED', $this->siteLangId));
                FatApp::redirectUser(UrlHelper::generateUrl('DatabaseBackupRestore'));
            }
            Message::addMessage(Labels::getLabel('SUC_DATABASE_UPLOADED_SUCCESSFULLY', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('DatabaseBackupRestore'));
        }

        $this->set('backup_frm', $backup_frm);
        $this->set('upload_frm', $upload_frm);
        $this->_template->render();
    }

    public function search()
    {
        $this->objPrivilege->canViewDatabaseBackupView();
        $settingsObj = new Settings();
        $files_array = $settingsObj->getDatabaseDirectoryFiles();
        $this->set("arrListing", $files_array);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function download($file)
    {
        $this->objPrivilege->canViewDatabaseBackupView();
        $this->objPrivilege->canEditDatabaseBackupView();
        if (isset($file) and trim($file) != "") {
            $settingsObj = new Settings();
            if (!$settingsObj->download_file($file)) {
                Message::addErrorMessage(Labels::getLabel('ERR_THE_FILE_IS_NOT_AVAILABLE_FOR_DOWNLOAD.', $this->siteLangId));
                FatApp::redirectUser(UrlHelper::generateUrl('DatabaseBackupRestore'));
            }
        }
    }

    public function restore($file)
    {
        $this->objPrivilege->canViewDatabaseBackupView();
        $this->objPrivilege->canEditDatabaseBackupView();

        if (isset($file) and trim($file) != "") {
            $settingsObj = new Settings();
            $settingsObj->restoreDatabase($file);
            Message::addMessage(Labels::getLabel('SUC_DATABASE_RESTORED_SUCCESSFULLY', $this->siteLangId));
        }
        $this->set('msg', Labels::getLabel('MSG_DATABASE_RESTORED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function delete($file)
    {
        $this->objPrivilege->canViewDatabaseBackupView();
        $this->objPrivilege->canEditDatabaseBackupView();

        if (isset($file) and trim($file) != "") {
            unlink(CONF_DB_BACKUP_DIRECTORY_FULL_PATH . $file);
        }
        $this->set('msg', Labels::getLabel('MSG_DATABASE_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getBackupForm()
    {
        $frm = new Form('frmdatabaseBackup', array('id' => 'frmdatabaseBackup'));
        $fld = $frm->addRequiredField(Labels::getLabel('FRM_FILE_NAME', $this->siteLangId), 'name');
        $fld = $frm->addSubmitButton('', 'submit_backup', Labels::getLabel('BTN_BACKUP_ON_SERVER', $this->siteLangId));
        return $frm;
    }

    protected function getUploadForm()
    {
        $frm = new Form('frmdatabaseUpload', array('id' => 'frmdatabaseUpload'));
        $fld = $frm->addFileUpload(Labels::getLabel('FRM_DB_UPLOAD', $this->siteLangId), 'file', array('autocomplete' => 'off'));
        $fld->html_before_field = '<div class="filefield"><span class="filename"></span>';
        $fld->html_after_field = '<label class="filelabel">' . Labels::getLabel('FRM_DOWNLOAD_FILE', $this->siteLangId) . '</label></div>';
        $fld->requirements()->setRequired();
        $frm->addSubmitButton('', 'submit_upload', Labels::getLabel('FRM_UPLOAD_ON_SERVER', $this->siteLangId));
        return $frm;
    }

    public static function saveFile($fl, $name)
    {
        $dir = CONF_DB_BACKUP_DIRECTORY_FULL_PATH;
        if (!is_writable($dir)) {
            Message::addErrorMessage(sprintf(Labels::getLabel('LBL_DIRECTORY_%S_IS_NOT_WRITABLE', CommonHelper::getLangId()), $dir));
            return false;
        }
        $fname = preg_replace('/[^a-zA-Z0-9\/\-\_\.]/', '', $name);
        while (file_exists($dir . $fname)) {
            /* $fname = rand(10, 999999).'_'.$fname; */
            $fname = microtime() . '_' . $fname;
        }
        if (!copy($fl, $dir . $fname)) {
            Message::addErrorMessage(Labels::getLabel('ERR_COULD_NOT_SAVE_FILE', CommonHelper::getLangId()));
            return false;
        }
        return true;
    }
}
