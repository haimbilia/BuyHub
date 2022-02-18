<?php

class UploadBulkImagesController extends ListingBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->objPrivilege->canUploadBulkImages();
        $this->langId = $this->siteLangId;
    }

    public function index()
    {
        $srchFrm = $this->getSearchForm();
        $this->set("frmSearch", $srchFrm);
        $this->_template->render();
    }

    private function getUploadForm()
    {
        $frm = new Form('uploadBulkImages', array('id' => 'uploadBulkImages'));

        $fldImg = $frm->addFileUpload(Labels::getLabel('FRM_FILE_TO_BE_UPLOADED:', $this->langId), 'bulk_images', array('id' => 'bulk_images', 'accept' => '.zip'));
        $fldImg->requirement->setRequired(true);
        $fldImg->setFieldTagAttribute('onChange', '$("#uploadFileName").html(this.value)');
        $fldImg->htmlBeforeField = '<div class="filefield"><span class="filename" id="uploadFileName"></span>';
        $fldImg->htmlAfterField = '<label class="filelabel">' . Labels::getLabel('FRM_BROWSE_FILE', $this->langId) . '</label></div>';

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SUBMIT', $this->langId));
        return $frm;
    }

    public function uploadForm()
    {
        $uploadFrm = $this->getUploadForm();
        $this->set("frm", $uploadFrm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function upload()
    {
        $frm = $this->getUploadForm();
        $post = $frm->getFormDataFromArray($_FILES);

        if (false === $post) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Invalid_Data', $this->langId), true);
        }

        $fileName = $_FILES['bulk_images']['name'];
        $tmpName = $_FILES['bulk_images']['tmp_name'];

        $uploadBulkImgobj = new UploadBulkImages();
        $savedFile = $uploadBulkImgobj->upload($fileName, $tmpName);
        if (false === $savedFile) {
            LibHelper::exitWithError($uploadBulkImgobj->getError(), true);
        }

        $path = CONF_UPLOADS_PATH . AttachedFile::FILETYPE_BULK_IMAGES_PATH;
        $filePath = AttachedFile::FILETYPE_BULK_IMAGES_PATH . $savedFile;

        $msg = '<br>' . str_replace('{path}', '<br><b>' . $filePath . '</b>', Labels::getLabel('MSG_Your_uploaded_files_path_will_be:_{path}', $this->langId));
        $msg = Labels::getLabel('MSG_Uploaded_Successfully.', $this->langId) . ' ' . $msg;
        $json = [
            "msg" => $msg,
            "path" => base64_encode($path . $savedFile)
        ];
        FatUtility::dieJsonSuccess($json);
    }

    public function getSearchForm(array $fields = [])
    {
        $frm = new Form('frmSearch', array('id' => 'frmSearch'));
        $frm->setRequiredStarWith('caption');
        $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');

        $frm->addTextBox(Labels::getLabel('FRM_USER', $this->siteLangId), 'user', '');

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEARCH', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('BTN_CLEAR', $this->siteLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'afile_record_id');
        return $frm;
    }

    public function search()
    {
        $db = FatApp::getDb();
        $srchFrm = $this->getSearchForm();

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());

        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);

        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

        $obj = new UploadBulkImages();
        $srch = $obj->bulkMediaFileObject();

        $keyword = FatApp::getPostedData('keyword', null, '');

        if (!empty($keyword)) {
            $cnd = $srch->addCondition('afile_physical_path', 'like', '%' . $keyword . '%');
        }

        $uploadedBy = FatApp::getPostedData('afile_record_id');
        if ('' != $uploadedBy) {
            $srch->addCondition('afile_record_id', '=', $uploadedBy);
        }

        $srch->addOrder('afile_id', 'DESC');
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $arrListing = $db->fetchAll($rs);

        $this->set("arrListing", $arrListing);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('canViewUsers', $this->objPrivilege->canViewUsers($this->siteLangId, true));
        $this->set('siteLangId', $this->siteLangId);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function removeDir($directory)
    {
        $directory = CONF_UPLOADS_PATH . base64_decode($directory);
        $obj = new UploadBulkImages();
        $msg = $obj->deleteSingleBulkMediaDir($directory);
        FatUtility::dieJsonSuccess($msg);
    }

    public function deleteSelected()
    {
        $uploadDirsArr = FatApp::getPostedData('uploadDirs');

        if (empty($uploadDirsArr)) {
            LibHelper::exitWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId),
                true
            );
        }
        $obj = new UploadBulkImages();
        foreach ($uploadDirsArr as $uploadDir) {
            if (empty($uploadDir)) {
                continue;
            }
            $directory = CONF_UPLOADS_PATH . base64_decode($uploadDir) . '/';
            $msg = $obj->deleteSingleBulkMediaDir($directory);
        }
        $this->set('msg', $msg);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function downloadPathsFile($path)
    {
        if (empty($path)) {
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
        }
        $filesPathArr = UploadBulkImages::getAllFilesPath(base64_decode($path));
        if (!empty($filesPathArr) && 0 < count($filesPathArr)) {
            $headers[] = ['File Path', 'File Name'];
            $filesPathArr = array_merge($headers, $filesPathArr);
            CommonHelper::convertToCsv($filesPathArr, time() . '.csv');
            exit;
        }
        Message::addErrorMessage(Labels::getLabel('MSG_No_File_Found', $this->siteLangId));
        CommonHelper::redirectUserReferer();
    }
}
