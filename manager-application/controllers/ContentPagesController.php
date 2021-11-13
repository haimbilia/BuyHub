<?php

class ContentPagesController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewContentPages();       
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm(false, $fields);
        $this->set('canEdit', $this->objPrivilege->canEditContentPages($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_CONTENT_PAGES', $this->admin_id));
        $this->getListingData();

        $this->_template->addCss('css/cropper.css');
        $this->_template->addJs(['js/cropper.js', 'js/cropper-main.js']);
        $this->set('includeEditor', true);
        $this->_template->render();
    }

    public function getSearchForm($request = false, $fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_Page_Title', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');

        if (!empty($fields)) {
            $this->addSortingElements($frm, 'cpage_title');
        }

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'content-pages/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $data = FatApp::getPostedData();

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $searchForm = $this->getSearchForm(false, $fields);

        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        $srch = ContentPage::getSearchObject($this->siteLangId);

        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('cpage_title', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('cpage_identifier', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);

        $srch->addOrder($sortBy, $sortOrder); 
        
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();

        $records = array();
        if ($rs) {
            $records = FatApp::getDb()->fetchAll($rs);
        }

        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditContentPages($this->admin_id, true));
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    public function form()
    {
        $this->objPrivilege->canEditContentPages();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);

        if (0 < $recordId) {
            $arrayFlds = array(
                'cpage_id', 'cpage_identifier', 'cpage_content','cpage_title', 'cpage_layout', 
                'cpage_image_content', 'cpage_image_title'
            );
            $data = ContentPage::getAttributesByLangId($this->getDefaultFormLangId(), $recordId, $arrayFlds, true);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            /* url data[ */
            $urlSrch = UrlRewrite::getSearchObject();
            $urlSrch->doNotCalculateRecords();
            $urlSrch->setPageSize(1);
            $urlSrch->addFld('urlrewrite_custom');
            $urlSrch->addCondition('urlrewrite_original', '=', ContentPage::REWRITE_URL_PREFIX . $recordId);
            $rs = $urlSrch->getResultSet();
            $urlRow = FatApp::getDb()->fetch($rs);
            if ($urlRow) {
                $data['urlrewrite_custom'] = $urlRow['urlrewrite_custom'];
            }
            /* ] */
            $frm->fill($data);
        }

        $this->set('languages', Language::getDropDownList($this->getDefaultFormLangId()));
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }


    public function setup() {

        $this->objPrivilege->canEditContentPages();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = $post['cpage_id'];
        unset($post['cpage_id']);
        $contentPage = new ContentPage($recordId);
        $post[$contentPage::tblFld('identifier')] = $post[$contentPage::tblFld('title')];
        $contentPage->assignValues($post);

        if (!$contentPage->save()) {
            LibHelper::exitWithError($contentPage->getError(), true);
        }

        $recordId = $contentPage->getMainTableRecordId();
        $this->setLangData($contentPage, [$contentPage::tblFld('title') => $post[$contentPage::tblFld('title')]]);

        /* url data[ */
        $originalUrl = ContentPage::REWRITE_URL_PREFIX . $recordId;
        if ($post['urlrewrite_custom'] == '') {
            UrlRewrite::remove($originalUrl);
        } else {
            $contentPage->rewriteUrl($post['urlrewrite_custom']);
        }
        /* ] */

        $newTabLangId = 0;
        if ($recordId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = ContentPage::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $recordId = $contentPage->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        $this->set('msg', Labels::getLabel('MSG_Setup_Successful', $this->siteLangId));
        $this->set('pageId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->set('cpage_layout', $post['cpage_layout']);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);

        $frm = new Form('frmCMSPage', [ 'id' => 'frmCMSPage']);
        $frm->addRequiredField(Labels::getLabel('FRM_Page_Title', $this->siteLangId), 'cpage_title');
        $frm->addHiddenField('', 'cpage_id', 0);
        $fld = $frm->addTextBox(Labels::getLabel('FRM_SEO_Friendly_URL', $this->siteLangId), 'urlrewrite_custom');
        $fld->requirements()->setRequired();
        $frm->addSelectBox(Labels::getLabel('FRM_Layout_Type', $this->siteLangId), 'cpage_layout', $this->getAvailableLayouts(), '', array('id' => 'cpage_layout'), Labels::getLabel('FRM_Select', $this->siteLangId))->requirements()->setRequired();
        return $frm;
    }

    protected function getLangForm($recordId = 0, $lang_id = 0)
    {
        $cpageData = ContentPage::getAttributesByLangId($this->siteLangId, $recordId, NULL, TRUE);
        $cpage_layout = $cpageData['cpage_layout'];

        $frm = new Form('frmContentPageLang', array('id' => 'frmContentPageLang'));
        $frm->addHiddenField('', 'cpage_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $lang_id), 'lang_id', Language::getDropDownList(), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_Page_Title', $lang_id), 'cpage_title');
        $frm->addHiddenField('', 'cpage_layout', $cpage_layout);
        if ($cpage_layout == ContentPage::CONTENT_PAGE_LAYOUT1_TYPE) {
            $frm->addTextBox(Labels::getLabel('FRM_Background_Image_Title', $lang_id), 'cpage_image_title');
            $frm->addHtmlEditor(Labels::getLabel('FRM_Background_Image_Description', $lang_id), 'cpage_image_content');
            for ($i = 1; $i <= ContentPage::CONTENT_PAGE_LAYOUT1_BLOCK_COUNT; $i++) {
                $frm->addHtmlEditor(Labels::getLabel('FRM_Content_Block_' . $i, $lang_id), 'cpblock_content_block_' . $i);
            }
        } else {
            $frm->addHtmlEditor(Labels::getLabel('LBL_Page_Content', $lang_id), 'cpage_content');
        }
        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $lang_id), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }
    
    public function langForm($autoFillLangData = 0)
    {
        $this->mainTableRecordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);

        
        if (1 > $this->mainTableRecordId || 1 > $langId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $cpageData = ContentPage::getAttributesByLangId($langId, $recordId, NULL, TRUE);
        $cpage_layout = $cpageData['cpage_layout'];

        $this->setLangTemplateData();     
        $langFrm = $this->getLangForm($this->mainTableRecordId, $langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData($this->modelObj::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($this->mainTableRecordId, $langId);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = $this->modelObj::getAttributesByLangId($langId, $this->mainTableRecordId);
        }

        if ($langData) {
            $srch = new searchBase(ContentPage::DB_TBL_CONTENT_PAGES_BLOCK_LANG);
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $srch->addMultipleFields(array("cpblocklang_text", 'cpblocklang_block_id'));
            $srch->addCondition('cpblocklang_cpage_id', '=', $recordId);

            if (0 < $autoFillLangData) {
                $srch->addCondition('cpblocklang_lang_id', '=', FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1));
            } else {
                $srch->addCondition('cpblocklang_lang_id', '=', $langId);
            }

            $srchRs = $srch->getResultSet();
            $blockData = FatApp::getDb()->fetchAll($srchRs, 'cpblocklang_block_id');
            foreach ($blockData as $blockKey => $blockContent) {
                if (0 < $autoFillLangData) {
                    $blockContent = $updateLangDataobj->directTranslate(['cpblocklang_text' => $blockContent['cpblocklang_text']], $langId);
                    if (false === $blockContent) {
                        LibHelper::exitWithError($updateLangDataobj->getError(), true);
                    }
                    $blockContent = current($blockContent);
                }
                $langData['cpblock_content_block_' . $blockKey] = $blockContent['cpblocklang_text'];
            }
            $langFrm->fill($langData);
        }

        if (true === $this->isPlugin) {
            $pluginDetail = Plugin::getAttributesById($this->mainTableRecordId, ['plugin_type', 'plugin_identifier']);
            if (!in_array($pluginDetail['plugin_type'], Plugin::HAVING_DESCRIPTION)) {
                $langFrm->removeField($langFrm->getField('plugin_description'));
            }
        }

        $this->set('languages', Language::getDropDownList($this->getDefaultFormLangId()));
        $this->set('recordId', $this->mainTableRecordId);
        $this->set('lang_id', $langId);
        $this->set('langFrm', $langFrm);
        $this->set('cpage_layout', $cpage_layout);
        $this->set('formLayout', Language::getLayoutDirection($langId));

        $className = get_called_class();
        $directory = (str_replace("-controller", "", strtolower(FatUtility::camel2dashed($className))));
        $renderPath = CONF_THEME_PATH . $directory . DIRECTORY_SEPARATOR . "lang-form.php";
        if (file_exists($renderPath)) {
            $this->_template->render(false, false);
        } else {
            $this->_template->render(false, false, '_partial/listing/lang-form.php');
        }
    }
    
    public function languageSetup()
    {
        $this->objPrivilege->canEditContentPages();
        $post = FatApp::getPostedData();
        $recordId = $post['cpage_id'];
        $lang_id = $post['lang_id'];
        $cpage_layout = $post['cpage_layout'];

        if ($recordId == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        /* $frm = $this->getLangForm( $recordId , $lang_id );
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        */
        unset($post['cpage_id']);
        unset($post['lang_id']);
        $data = array(
        'cpagelang_lang_id' => $lang_id,
        'cpagelang_cpage_id' => $recordId,
        'cpage_title' => $post['cpage_title'],

        );

        if ($cpage_layout == ContentPage::CONTENT_PAGE_LAYOUT1_TYPE) {
            $data['cpage_image_title'] = $post['cpage_image_title'];
            $data['cpage_image_content'] = $post['cpage_image_content'];
        } else {
            $data['cpage_content'] = $post['cpage_content'];
        }

        $pageObj = new ContentPage($recordId);
        if (!$pageObj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($pageObj->getError(), true);
        }
        $recordId = $pageObj->getMainTableRecordId();
        if (!$recordId) {
            $recordId = FatApp::getDb()->getInsertId();
        }
        $pageObj = new ContentPage($recordId);
        if ($cpage_layout == ContentPage::CONTENT_PAGE_LAYOUT1_TYPE) {
            for ($i = 1; $i <= ContentPage::CONTENT_PAGE_LAYOUT1_BLOCK_COUNT; $i++) {
                $data['cpblocklang_text'] = $post['cpblock_content_block_' . $i];
                $data['cpblocklang_block_id'] = $i;
                if (!$pageObj->addUpdateContentPageBlocks($lang_id, $recordId, $data)) {
                    LibHelper::exitWithError($pageObj->getError(), true);
                }
            }
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(ContentPage::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = ContentPage::getAttributesByLangId($langId, $recordId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', Labels::getLabel('MSG_Setup_Successful', $lang_id));
        $this->set('pageId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->set('cpage_layout', $cpage_layout);
        $this->_template->render(false, false, 'json-success.php');
    }

     /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->objPrivilege->canEditContentPages();
        $this->modelObj = (new ReflectionClass('ContentPage'))->newInstanceArgs($constructorArgs);
        $this->formLangFields = [
            $this->modelObj::tblFld('title'), 
            // $this->modelObj::tblFld('content'),
            $this->modelObj::tblFld('image_title'),
            $this->modelObj::tblFld('image_content'),
        ];
        $this->set('formTitle', Labels::getLabel('LBL_CONTENT_PAGE_SETUP', $this->siteLangId));
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function getFormColumns(): array
    {
        $ContentPageTblHeadingCols = CacheHelper::get('ContentPageTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($ContentPageTblHeadingCols) {
            return json_decode($ContentPageTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'cpage_id' => Labels::getLabel('LBL_ID', $this->siteLangId),
            'cpage_title' => Labels::getLabel('LBL_Title', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('ContentPageTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'cpage_title',
            'action',
        ];
    }

    /**
     * Undocumented function
     *
     * @param array $fields
     * @return array
     */
    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['cpage_id'], Common::excludeKeysForSort());
    }
   
    /**
     * Undocumented function
     *
     * @param [type] $recordId
     * @param string $file_type
     * @param integer $lang_id
     * @return void
     */
    public function images($recordId, $file_type = 'image', $lang_id = 0)
    {
        $languages = Language::getAllNames();
        $recordId = FatUtility::int($recordId);
        if (count($languages) > 1) {
            $universalImage = true;
            $lang_id = FatUtility::int($lang_id);
        } else {
            $universalImage = false;
            $lang_id = array_key_first($languages);
        }
        $lang_id = $lang_id == 0 ?  $this->siteLangId : $lang_id;

        $cbgImage = AttachedFile::getAttachment(AttachedFile::FILETYPE_CPAGE_BACKGROUND_IMAGE, $recordId, 0, $lang_id, $universalImage);
        $this->set('image', $cbgImage);
        $this->set('imageFunction', 'cpageBackgroundImage');

        $this->set('file_type', $file_type);
        $this->set('recordId', $recordId);
        $this->set('canEdit', $this->objPrivilege->canEditContentPages($this->admin_id, true));
        $this->_template->render(false, false);
    }

    /**
     * Undocumented function
     *
     * @param [type] $recordId
     * @return void
     */
    public function media($recordId) {
        $this->objPrivilege->canEditContentPages($this->admin_id, true);
        $recordId = FatUtility::int($recordId);
        $languages = Language::getAllNames();
        if (1 == count($languages)) {
            $langId = array_key_first($languages);
        }else{
            $langId = $this->siteLangId;
        }
        $data['lang_id'] = $langId;

        $cbgForm = $this->getContentBgForm($recordId, $this->siteLangId);
        $cbgForm->fill($data);

        $this->set('languages', Language::getDropDownList($this->getDefaultFormLangId()));
        $this->set('recordId', $recordId);
        
        $cpageData = ContentPage::getAttributesByLangId($langId, $recordId, NULL, TRUE);
        $this->set('contentPageDetails', $cpageData);
        $this->set('cbgForm', $cbgForm);
        $this->set('bannerTypeArr', applicationConstants::bannerTypeArr());
        $this->set('languages', Language::getDropDownList($this->getDefaultFormLangId()));
        $this->_template->render(false, false);
    }

    /**
     * Undocumented function
     *
     * @param integer $recordId
     * @param integer $land_id
     * @return object
     */
    private function getContentBgForm(int $recordId, int $land_id) {
        $land_id = FatUtility::int($land_id);
        $frm = new Form('frmBGImage');
        $frm->addHTML('', Labels::getLabel('FRM_BACKGROUND_IMAGE', $this->siteLangId), '<h3>' . Labels::getLabel('LBL_BACKGROUND_IMAGE', $this->siteLangId) . '</h3>');
        $frm->addHiddenField('', 'cpage_id', $recordId);
        $bannerTypeArr = applicationConstants::bannerTypeArr();
        if (count($bannerTypeArr) > 1) {
            $frm->addSelectBox(Labels::getLabel('LBL_Language', $this->siteLangId), 'lang_id', $bannerTypeArr, '', array(), '');
        } else {
            $land_id = array_key_first($bannerTypeArr);
            $frm->addHiddenField('', 'lang_id', $land_id);
        }
        $frm->addHiddenField('', 'file_type', AttachedFile::FILETYPE_CPAGE_BACKGROUND_IMAGE);
        $frm->addHiddenField('', 'min_width');
        $frm->addHiddenField('', 'min_height');
        $frm->addHTML('', 'cpage_bg_image', '');

        return $frm;
    } 

    /**
     * Undocumented function
     *
     * @return void
     */
    public function uploadMedia() {
        $this->objPrivilege->canEditContentPages();
        $post = FatApp::getPostedData();
        if (empty($post)) {
            LibHelper::exitWithError(Labels::getLabel('MSG_Invalid_Request_Or_File_not_supported', $this->siteLangId), true);
        }
        $recordId = FatApp::getPostedData('cpage_id', FatUtility::VAR_INT, 0);
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, $this->siteLangId);
        } else {
            $lang_id = array_key_first($languages);
        }
        $file_type = FatApp::getPostedData('file_type', FatUtility::VAR_INT, 0);
        $slide_screen = FatApp::getPostedData('slide_screen', FatUtility::VAR_INT, 0);

        if (!$recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('MSG_Please_Select_A_File', $this->siteLangId), true);
        }

        $fileHandlerObj = new AttachedFile();
        $fileHandlerObj->deleteFile($file_type, $recordId, 0, 0, $lang_id, $slide_screen);

        if (!$fileHandlerObj->saveAttachment(
            $_FILES['cropped_image']['tmp_name'],
            $file_type,
            $recordId,
            0,
            $_FILES['cropped_image']['name'],
            -1,
            false,
            $lang_id,
        )) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('recordId', $recordId);
        $this->set('file', $_FILES['cropped_image']['name']);
        $this->set('msg', $_FILES['cropped_image']['name'] .' '. Labels::getLabel('MSG_File_Uploaded_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    /**
     * Undocumented function
     *
     * @param integer $recordId
     * @param string $imageType
     * @param integer $afileId
     * @return void
     */
    public function removeMedia(int $recordId, string $imageType = 'image', int $afileId = 0) {
        $recordId = FatUtility::int($recordId);
        if (!$recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile(AttachedFile::FILETYPE_CPAGE_BACKGROUND_IMAGE, $recordId, $afileId)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_Deleted_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function deleteRecord()
    {
        $this->objPrivilege->canEditContentPages();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($recordId);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditContentPages();
        $cpageIdsArr = FatUtility::int(FatApp::getPostedData('cpage_ids'));

        if (empty($cpageIdsArr)) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }

        foreach ($cpageIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }
            $this->markAsDeleted($recordId);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }
        $obj = new ContentPage($recordId);
        if (!$obj->canRecordMarkDelete($recordId)) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $obj->assignValues(array(ContentPage::tblFld('deleted') => 1));
        if (!$obj->save()) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    public function autoComplete()
    {
        $srch = ContentPage::getSearchObject($this->siteLangId);

        $post = FatApp::getPostedData();
        if (!empty($post['keyword'])) {
            $srch->addCondition('cpage_title', 'LIKE', '%' . $post['keyword'] . '%');
        }

        $srch->setPageSize(FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        $srch->addMultipleFields(array('cpage_id', 'IFNULL(cpage_title,cpage_identifier) as cpage_name'));
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();
        $products = $db->fetchAll($rs, 'cpage_id');
        $json = array();
        foreach ($products as $key => $product) {
            $json[] = array(
            'id' => $key,
            'name' => strip_tags(html_entity_decode($product['cpage_name'], ENT_QUOTES, 'UTF-8'))
            );
        }
        die(json_encode($json));
    }

    private function getAvailableLayouts()
    {
        $collectionLayouts = array(
            ContentPage::CONTENT_PAGE_LAYOUT1_TYPE => Labels::getLabel('LBL_Content_Page_Layout1', $this->siteLangId),
            ContentPage::CONTENT_PAGE_LAYOUT2_TYPE => Labels::getLabel('LBL_Content_Page_Layout2', $this->siteLangId),
        );
        return $collectionLayouts;
    }
}
