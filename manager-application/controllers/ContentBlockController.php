<?php

class ContentBlockController extends ListingBaseController
{
    protected $modelClass = 'Extrapage';

    public function __construct($action) 
    {
        parent::__construct($action);
        $this->objPrivilege->canViewContentBlocks();
    }

     /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->checkEditPrivilege();
        $this->modelObj = (new ReflectionClass('Extrapage'))->newInstanceArgs($constructorArgs);
        $this->formLangFields = [
            $this->modelObj::tblFld('label'), 
            $this->modelObj::tblFld('content'),
            // $this->modelObj::tblFld('image_content'),
        ];
        $this->set('formTitle', Labels::getLabel('LBL_CONTENT_PAGE_SETUP', $this->siteLangId));
    }

    /**
     * checkEditPrivilege - This function is used to check, set previlege and can be also used in parent class to validate request.
     *
     * @param  bool $setVariable
     * @return void
     */
    protected function checkEditPrivilege(bool $setVariable = false): void
    {
        if (true === $setVariable) {
            $this->set("canEdit", $this->objPrivilege->canEditContentBlocks($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditContentBlocks();
        }
    }
   
    public function index(int $recordId = 0)
    {
        $this->checkEditPrivilege(true);
        $this->set('epage_id', $recordId);
        
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        
        $pageData = PageLanguageData::getAttributesByKey('MANAGE_CONTENT_BLOCK', $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        
        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['statusButtons'] = true;
        $actionItemsData['newRecordBtn'] = false;
        
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_TITLE', $this->siteLangId));
        $this->getListingData();
        $this->_template->addCss('css/cropper.css');
        $this->_template->addJs(['js/cropper.js', 'js/cropper-main.js']);
        $this->set('includeEditor', true);
        $this->_template->render();
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
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $searchForm = $this->getSearchForm(false, $fields);
        $post = $searchForm->getFormDataFromArray($data);
        $srch = Extrapage::getSearchObject($this->siteLangId, false);
        $srch->addCondition('epage_content_for', '=', Extrapage::CONTENT_PAGES);
        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('epage_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('epage_label', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        $srch->addMultipleFields([
            'epage_id', 'IFNULL(epage_label,epage_identifier) AS epage_label',
            'epage_type', 'epage_content_for', 'epage_active', 'epage_default', 
            'epagelang_lang_id', 'IFNULL(epage_content, epage_default_content) AS epage_content', 'epage_updated_on'
        ]);
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->addOrder($sortBy, $sortOrder); 
        $srch->setPageSize($pageSize);
        $records = FatApp::getDb()->fetchAll( $srch->getResultSet());
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $this->set("activeInactiveArr", $activeInactiveArr);
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
        $this->checkEditPrivilege(true);
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'content-block/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $universalImage = true;
        } else {
            $universalImage = false;
        }
        if (0 < $recordId) {
            $fieldsArray = [
                'epage_id', 'epage_identifier', 'epage_active','epage_label', 'epage_content'
            ];
            $data = Extrapage::getAttributesByLangId($this->siteLangId, $recordId, $fieldsArray, true);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }

            /* url data[ */
            $urlRow = UrlRewrite::getDataByOriginalUrl(Extrapage::REWRITE_URL_PREFIX . $recordId);
            if (!empty($urlRow)) {
                $data['urlrewrite_custom'] = $urlRow['urlrewrite_custom'];
            }
            /*]*/
            $frm->fill($data);
        }

        
        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        
        if ($recordId == Extrapage::SELLER_BANNER_SLOGAN) {
            $fileType = AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE;
        } elseif ($recordId == Extrapage::ADVERTISER_BANNER_SLOGAN) {
            $fileType = AttachedFile::FILETYPE_ADVERTISER_PAGE_SLOGAN_BG_IMAGE;
        } elseif ($recordId == Extrapage::AFFILIATE_BANNER_SLOGAN) {
            $fileType = AttachedFile::FILETYPE_AFFILIATE_PAGE_SLOGAN_BG_IMAGE;
        } else {
            $fileType = AttachedFile::FILETYPE_CPAGE_BACKGROUND_IMAGE;
        }
        
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $universalImage = true;
        } else {
            $universalImage = false;
        }
        $cbgImage = AttachedFile::getAttachment($fileType, $recordId, 0, $this->siteLangId, $universalImage);
        $this->set('image', $cbgImage);
        
        $this->set('imageFunction', 'cblockBackgroundImage');
        $this->checkEditPrivilege(true);

        $this->_template->render(false, false);
    }

    private function getForm(int $recordId = 0)
    {
        $frm = new Form('frmAddBlock');
        $frm->addHiddenField('', 'epage_id', $recordId);
        $frm->addHiddenField('', 'lang_id', $this->siteLangId );
        $frm->addRequiredField(Labels::getLabel('FRM_PAGE_TITLE', $this->siteLangId), 'epage_label');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_SEO_FRIENDLY_URL', $this->siteLangId), 'urlrewrite_custom');
        // $fld->requirements()->setRequired();

        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'epage_active', applicationConstants::getActiveInactiveArr($this->siteLangId), '', [], '');
        if (array_key_exists($recordId, Extrapage::getContentBlockArrWithBg($this->siteLangId))) {
            if ($recordId == Extrapage::SELLER_BANNER_SLOGAN) {
                $fileType = AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE;
            } elseif ($recordId == Extrapage::ADVERTISER_BANNER_SLOGAN) {
                $fileType = AttachedFile::FILETYPE_ADVERTISER_PAGE_SLOGAN_BG_IMAGE;
            } elseif ($recordId == Extrapage::AFFILIATE_BANNER_SLOGAN) {
                $fileType = AttachedFile::FILETYPE_AFFILIATE_PAGE_SLOGAN_BG_IMAGE;
            } else {
                $fileType = AttachedFile::FILETYPE_CPAGE_BACKGROUND_IMAGE;
            }
            $frm->addHTML('', Labels::getLabel('FRM_BACKGROUND_IMAGE', $this->siteLangId), Labels::getLabel('FRM_BACKGROUND_IMAGE', $this->siteLangId) );
            $frm->addHTML('', 'cblock_bg_image', '');
            $frm->addHiddenField('', 'file_type', $fileType);
            $frm->addHiddenField('', 'min_width', 1300);
            $frm->addHiddenField('', 'min_height', 400);
        }
        $frm->addHtmlEditor(Labels::getLabel('FRM_Page_Content', $this->siteLangId), 'epage_content');
        return $frm;
    }

    
    protected function getLangForm(int $recordId = 0, int $langId = 0) 
    {
        if ($recordId == 0 || $langId == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $frm = new Form('frmBlock', array('id' => 'frmBlock'));
        $frm->addHiddenField('', 'epage_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_PAGE_TITLE', $langId), 'epage_label');
        if (array_key_exists($recordId, Extrapage::getContentBlockArrWithBg($langId))) {
            if ($recordId == Extrapage::SELLER_BANNER_SLOGAN) {
                $fileType = AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE;
            } elseif ($recordId == Extrapage::ADVERTISER_BANNER_SLOGAN) {
                $fileType = AttachedFile::FILETYPE_ADVERTISER_PAGE_SLOGAN_BG_IMAGE;
            } elseif ($recordId == Extrapage::AFFILIATE_BANNER_SLOGAN) {
                $fileType = AttachedFile::FILETYPE_AFFILIATE_PAGE_SLOGAN_BG_IMAGE;
            } else {
                $fileType = AttachedFile::FILETYPE_CPAGE_BACKGROUND_IMAGE;
            }
            $frm->addHTML('', Labels::getLabel('FRM_BACKGROUND_IMAGE', $this->siteLangId), Labels::getLabel('FRM_BACKGROUND_IMAGE', $this->siteLangId) );
            $frm->addHTML('', 'cblock_bg_image', '');
            $frm->addHiddenField('', 'file_type', $fileType);
            $frm->addHiddenField('', 'min_width', 1300);
            $frm->addHiddenField('', 'min_height', 400);
        }
        $frm->addHtmlEditor(Labels::getLabel('FRM_PAGE_CONTENT', $langId), 'epage_content');
        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $langId == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $langId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }
    
    public function langForm($autoFillLangData = 0) 
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);

        if (1 > $recordId || 1 > $langId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $epageData = Extrapage::getAttributesById($recordId);
        $langFrm = $this->getLangForm($recordId, $langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(Extrapage::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($recordId, $langId);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = Extrapage::getAttributesByLangId($langId, $recordId);
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        if ($recordId == Extrapage::SELLER_BANNER_SLOGAN) {
            $fileType = AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE;
        } elseif ($recordId == Extrapage::ADVERTISER_BANNER_SLOGAN) {
            $fileType = AttachedFile::FILETYPE_ADVERTISER_PAGE_SLOGAN_BG_IMAGE;
        } elseif ($recordId == Extrapage::AFFILIATE_BANNER_SLOGAN) {
            $fileType = AttachedFile::FILETYPE_AFFILIATE_PAGE_SLOGAN_BG_IMAGE;
        } else {
            $fileType = AttachedFile::FILETYPE_CPAGE_BACKGROUND_IMAGE;
        }
        
        if (true === $this->isPlugin) {
            $pluginDetail = Plugin::getAttributesById($this->mainTableRecordId, ['plugin_type', 'plugin_identifier']);
            if (!in_array($pluginDetail['plugin_type'], Plugin::HAVING_DESCRIPTION)) {
                $langFrm->removeField($langFrm->getField('plugin_description'));
            }
        }
        
        $bgImages = AttachedFile::getMultipleAttachments($fileType, $recordId, 0, $langId);
        $bannerTypeArr = applicationConstants::bannerTypeArr();
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $universalImage = true;
        } else {
            $universalImage = false;
            $langId = array_key_first($languages);
        }
        $cbgImage = AttachedFile::getAttachment($fileType, $recordId, 0, $langId, $universalImage);
        $this->set('image', $cbgImage);
        
        $this->set('imageFunction', 'cblockBackgroundImage');
        $this->set('bgImages', $bgImages);
        $this->set('bannerTypeArr', $bannerTypeArr);
        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('lang_id', $langId);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('epageData', $epageData);
        $this->set('contentBlockArrWithBg', Extrapage::getContentBlockArrWithBg($this->siteLangId));
        $this->set('activeLangtab', true);
        $this->checkEditPrivilege(true);
        $this->_template->render(false, false);
    }
    

    public function setup()
    {
        $this->checkEditPrivilege();
        $frm = $this->getForm(0, $this->siteLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = $post['epage_id'];
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $data = Extrapage::getAttributesById($recordId, array('epage_id', 'epage_identifier'));
        if ($data === false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $record = new Extrapage($recordId); 
        $urlrewrite_custom = $post['urlrewrite_custom'];
        $post['epage_identifier'] = $post['epage_label'];

        $languageId =  $post['lang_id'] ? $post['lang_id'] : $this->siteLangId;
        $data = array(
            'epagelang_lang_id' => $languageId,
            'epagelang_epage_id' => $recordId,
            'epage_label' => $post['epage_label'],
            'epage_content' => $post['epage_content'],
        );
        unset($post['lang_id'], $post['epage_content'], $post['epage_label'], $post['urlrewrite_custom']);

        if (!$record->updatePageContent($post)) {
            LibHelper::exitWithError($record->getError(), true);
        }

        if (!$record->updateLangData($languageId, $data)) {
            LibHelper::exitWithError($record->getError(), true);
        }


        /* url data[ */
        $originalUrl = Extrapage::REWRITE_URL_PREFIX . $recordId;
        if ($urlrewrite_custom == '') {
            UrlRewrite::remove($originalUrl);
        } else {
            $record->rewriteUrl($urlrewrite_custom);
        }
        /* ] */

        $languages = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        if (0 < count($languages)) {
            foreach ($languages as $langId => $langName) {
                if (!Brand::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        }
        $this->set('msg', Labels::getLabel('MSG_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langSetup()
    {
        $post = FatApp::getPostedData();
        $recordId = FatUtility::int($post['epage_id']);

        $languages = Language::getAllNames();
		if(count($languages) > 1){
            $lang_id = FatUtility::int($post['lang_id']);
		} else  {
			$lang_id = array_key_first($languages); 
		}
       

        if ($recordId == 0 || $lang_id == 0) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieWithError(Message::getHtml());
        }
        $frm = $this->getLangForm($recordId, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJSONError(Message::getHtml());
        }

        unset($post['epage_id'], $post['lang_id']);
        $data = array(
            'epagelang_lang_id' => $lang_id,
            'epagelang_epage_id' => $recordId,
            'epage_label' => $post['epage_label'],
            'epage_content' => $post['epage_content'],
        );

        $epageObj = new Extrapage($recordId);
        if (!$epageObj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($epageObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(Extrapage::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = Extrapage::getAttributesByLangId($langId, $recordId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $universalImage = true;
            $lang_id = FatUtility::int($lang_id);
        } else {
            $universalImage = false;
            $lang_id = array_key_first($languages);
        }
    
        if ($recordId == Extrapage::SELLER_BANNER_SLOGAN) {
            $fileType = AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE;
        } elseif ($recordId == Extrapage::ADVERTISER_BANNER_SLOGAN) {
            $fileType = AttachedFile::FILETYPE_ADVERTISER_PAGE_SLOGAN_BG_IMAGE;
        } elseif ($recordId == Extrapage::AFFILIATE_BANNER_SLOGAN) {
            $fileType = AttachedFile::FILETYPE_AFFILIATE_PAGE_SLOGAN_BG_IMAGE;
        } else {
            $fileType = AttachedFile::FILETYPE_CPAGE_BACKGROUND_IMAGE;
        }
        $cbgImage = AttachedFile::getAttachment($fileType, $recordId, 0, $lang_id, $universalImage);
        $this->set('image', $cbgImage);
        $this->set('imageFunction', 'cblockBackgroundImage');
        $this->set('msg', Labels::getLabel('MSG_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('epageId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

     /**
     * Undocumented function
     *
     */
    public function images()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $fileType = FatApp::getPostedData('imageType', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $universalImage = true;
            $langId = FatUtility::int($langId);
        } else {
            $universalImage = false;
            $langId = array_key_first($languages);
        }
        $langId = $langId == 0 ?  $this->siteLangId : $langId;
        if ($recordId == Extrapage::SELLER_BANNER_SLOGAN) {
            $fileType = AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE;
        } elseif ($recordId == Extrapage::ADVERTISER_BANNER_SLOGAN) {
            $fileType = AttachedFile::FILETYPE_ADVERTISER_PAGE_SLOGAN_BG_IMAGE;
        } elseif ($recordId == Extrapage::AFFILIATE_BANNER_SLOGAN) {
            $fileType = AttachedFile::FILETYPE_AFFILIATE_PAGE_SLOGAN_BG_IMAGE;
        } else {
            $fileType = AttachedFile::FILETYPE_CPAGE_BACKGROUND_IMAGE;
        }
        $cbgImage = AttachedFile::getAttachment($fileType, $recordId, 0, $langId, $universalImage);
        $this->set('image', $cbgImage);
        $this->set('imageFunction', 'cblockBackgroundImage');
        $this->set('file_type', 'THUMB');
        $this->set('recordId', $recordId);
        $this->checkEditPrivilege(true);
        $this->_template->render(false, false);
    }


    public function toggleBulkStatuses()
    {
        $this->checkEditPrivilege();
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $epageIdsArr = FatUtility::int(FatApp::getPostedData('epage_ids'));
        if (empty($epageIdsArr) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($epageIdsArr as $epageId) {
            if (1 > $epageId) {
                continue;
            }

            $this->updateEPageStatus($epageId, $status);
        }
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updateEPageStatus(int $recordId, int $status)
    {
        if (1 > $recordId || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $EPageObj = new Extrapage($recordId);

        if (!$EPageObj->changeStatus($status)) {
            LibHelper::exitWithError($EPageObj->getError(),true);
        }
    }

    public function uploadMedia()
    {
        $fileType = FatApp::getPostedData('file_type', FatUtility::VAR_INT, 0);
        $recordId = FatApp::getPostedData('epage_id', FatUtility::VAR_INT, 0);
        $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        if (!$fileType || !$recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        
        $allowedFileTypeArr = array(
            AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE, 
            AttachedFile::FILETYPE_ADVERTISER_PAGE_SLOGAN_BG_IMAGE, 
            AttachedFile::FILETYPE_AFFILIATE_PAGE_SLOGAN_BG_IMAGE,
            AttachedFile::FILETYPE_CPAGE_BACKGROUND_IMAGE
        );

        if (!in_array($fileType, $allowedFileTypeArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $file = $_FILES['cropped_image'];
        if (!is_uploaded_file($file['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('MSG_PLEASE_SELECT_A_FILE', $this->siteLangId), true);
        }


        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->saveImage($file['tmp_name'], $fileType, $recordId, 0, $file['name'], -1, true, $lang_id, $file['type'])) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $universalImage = true;
            $lang_id = FatUtility::int($lang_id);
        } else {
            $universalImage = false;
            $lang_id = array_key_first($languages);
        }

        $cbgImage = AttachedFile::getAttachment($fileType, $recordId, 0, $lang_id, $universalImage);
        $this->set('image', $cbgImage);
        $this->set('imageFunction', 'cblockBackgroundImage');
        $this->set('file', $file['name']);
        $this->set('recordId', $recordId);
        $this->set('file_type', $fileType);
        $this->set('lang_id', $lang_id);
        $this->set('msg', $file['name'] . ' ' . Labels::getLabel('MSG_UPLOADED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    /**
     * Removing Background Media Image 
     *
     */
    public function removeMedia() 
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $afileId = FatApp::getPostedData('afileId', FatUtility::VAR_INT, 0);
        $fileType = FatApp::getPostedData('file_type', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);

        if (0 == $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if ($recordId == Extrapage::SELLER_BANNER_SLOGAN) {
            $fileType = AttachedFile::FILETYPE_SELLER_PAGE_SLOGAN_BG_IMAGE;
        } elseif ($recordId == Extrapage::ADVERTISER_BANNER_SLOGAN) {
            $fileType = AttachedFile::FILETYPE_ADVERTISER_PAGE_SLOGAN_BG_IMAGE;
        } elseif ($recordId == Extrapage::AFFILIATE_BANNER_SLOGAN) {
            $fileType = AttachedFile::FILETYPE_AFFILIATE_PAGE_SLOGAN_BG_IMAGE;
        } else {
            $fileType = AttachedFile::FILETYPE_CPAGE_BACKGROUND_IMAGE;
        }

        $fileHandlerObj = new AttachedFile();
        if($langId == $this->siteLangId){
            $fileHandlerObj->deleteFile($fileType, $recordId, 0, 0, 0);
        }
        if (!$fileHandlerObj->deleteFile($fileType, $recordId, $afileId, 0, $langId)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
  

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function getFormColumns(): array
    {
        $ContentBlokTblHeadingCols = CacheHelper::get('ContentBlokTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($ContentBlokTblHeadingCols) {
            return json_decode($ContentBlokTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'epage_id' => Labels::getLabel('LBL_ID', $this->siteLangId),
            'epage_label' => Labels::getLabel('LBL_TITLE', $this->siteLangId),
            'epage_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('ContentBlokTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
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
            'epage_label',
            'epage_active',
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
        return array_diff($fields, ['epage_id', 'epage_active'], Common::excludeKeysForSort());
    }

    
}
