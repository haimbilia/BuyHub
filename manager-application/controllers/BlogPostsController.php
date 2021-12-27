<?php

class BlogPostsController extends ListingBaseController
{
    protected string $modelClass = 'BlogPost';
    protected $pageKey = 'BLOG_POSTS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewBlogPosts();
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->objPrivilege->canEditBlogPosts();
        $this->setModel($constructorArgs);
        //$this->modelObj = (new ReflectionClass('BlogPost'))->newInstanceArgs($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('title'), $this->modelObj::tblFld('author_name'), $this->modelObj::tblFld('description')];
        $this->set('formTitle', Labels::getLabel('LBL_BLOG_POST_SETUP', $this->siteLangId));
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['newRecordBtnAttrs'] = [
            'attr' => [
                'onclick' => 'addNew(false, "modal-dialog-vertical-md")',
            ],
        ];
        $actionItemsData['deleteButton'] = true;
        $actionItemsData['formAction'] = 'deleteSelected';
        $actionItemsData['performBulkAction'] = true;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_POST_TITLE', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(['js/cropper.js', 'js/cropper-main.js', 'js/tagify.min.js', 'js/tagify.polyfills.min.js', 'blog-posts/page-js/index.js']);
        $this->_template->addCss(['css/cropper.css', 'css/tagify.min.css']);
        $this->set('includeEditor', true);
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'blog-posts/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

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

        $searchForm = $this->getSearchForm($fields);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());

        $srch = BlogPost::getSearchObject($this->siteLangId, true, false, false, false);

        if (!empty($post['keyword'])) {
            $keywordCond = $srch->addCondition('bp.post_identifier', 'like', '%' . $post['keyword'] . '%');
            $keywordCond->attachCondition('bp_l.post_title', 'like', '%' . $post['keyword'] . '%');
        }

        if (isset($post['post_published']) && $post['post_published'] != '') {
            $srch->addCondition('bp.post_published', '=', $post['post_published']);
        }
        $srch->addMultipleFields(array('*', 'COALESCE(post_title,post_identifier) post_title', 'group_concat(COALESCE(bpcategory_name ,bpcategory_identifier)) categories'));
        $srch->addGroupby('post_id');

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

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
        $this->set('canEdit', $this->objPrivilege->canEditEmptyCartItems($this->admin_id, true));
    }

    public function form()
    {
        $this->objPrivilege->canEditBlogPosts();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        $frm = $this->getForm($recordId);
        if (0 < $recordId) {
            $data = BlogPost::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $recordId, null, true);
            if ($data === false) {
                LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId), true);
            }
            /* url data[ */
            $urlSrch = UrlRewrite::getSearchObject();
            $urlSrch->doNotCalculateRecords();
            $urlSrch->setPageSize(1);
            $urlSrch->addFld('urlrewrite_custom');
            $urlSrch->addCondition('urlrewrite_original', '=', 'blog/post-detail/' . $recordId);
            $rs = $urlSrch->getResultSet();
            $urlRow = FatApp::getDb()->fetch($rs);
            if ($urlRow) {
                $data['urlrewrite_custom'] = $urlRow['urlrewrite_custom'];
            }
            /* ] */

            /* link blog post to blog post categories[ */
            $postObj = new BlogPost();
            $categories = $postObj->getPostCategories($recordId, $this->siteLangId);
            $bpCats = [];
            foreach ($categories as $cat) {
                $bpCats[] = [
                    'id' => $cat['bpcategory_id'],
                    'value' => $cat['bpcategory_name'],
                ];
            }
            $data['categories'] = json_encode($bpCats);
            /* ] */

            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_BLOG_POST_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditBlogPosts();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = FatUtility::int($post['post_id']);
        unset($post['post_id']);

        if ($recordId == 0) {
            $post['post_added_on'] = date('Y-m-d H:i:s');
        }
        if ($post['post_published']) {
            $post['post_published_on'] = date('Y-m-d H:i:s');
        } else {
            $post['post_published_on'] = '';
        }
        $post['post_updated_on'] = date('Y-m-d H:i:s');

        $categories = '';
        if (isset($post['categories'])) {
            $categories = $post['categories'];
            unset($post['categories']);
        }
        $post['post_identifier'] = $post['post_title'];

        $record = new BlogPost($recordId);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }
        $recordId = $record->getMainTableRecordId();

        $langData = [
            'post_title' => $post['post_title'],
            'post_author_name' => $post['post_author_name'],
            'post_description' => $post['post_description'],
        ];
        if (!$record->updateLangData(CommonHelper::getDefaultFormLangId(), $langData)) {
            LibHelper::exitWithError($record->getError(), true);
        }
        /* link blog post to blog post categories[ */
        if (!empty($categories) && true === LibHelper::isJson($categories)) {
            $categories = array_column(json_decode($categories, true), 'id');
            if (!$record->addUpdateCategories($recordId, $categories)) {
                LibHelper::exitWithError($record->getError(), true);
            }
        }
        /* ] */

        /* url data[ */
        $blogOriginalUrl = BlogPost::REWRITE_URL_PREFIX . $recordId;
        if ($post['urlrewrite_custom'] == '') {
            FatApp::getDb()->deleteRecords(UrlRewrite::DB_TBL, array('smt' => 'urlrewrite_original = ?', 'vals' => array($blogOriginalUrl)));
        } else {
            $record->rewriteUrl($post['urlrewrite_custom']);
        }
        /* ] */

        $newTabLangId = 0;
        if ($recordId > 0) {
            $recordId = $recordId;
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = BlogPost::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $recordId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        $this->set('msg', Labels::getLabel('MSG_BLOG_POST_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditBlogPosts();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $this->markAsDeleted($recordId);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditBlogPosts();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('post_ids'));

        if (empty($recordIdsArr)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId), true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }
            $this->markAsDeleted($recordId);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId), true);
        }
        $obj = new BlogPost($recordId);
        if (!$obj->canMarkRecordDelete()) {
            LibHelper::exitWithError(Labels::getLabel('ERR_UNAUTHORIZED_ACCESS', $this->siteLangId), true);
        }
        $obj->assignValues(array(BlogPost::tblFld('deleted') => 1));

        if (!$obj->save()) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    public function imagesForm($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (!$recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id);
        }

        if (!BlogPost::getAttributesById($recordId)) {
            LibHelper::exitWithError($this->str_invalid_request_id);
        }
        $frm = $this->getImagesFrm($recordId);
        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('displayFooterButtons', false);
        $this->set('activeGentab', false);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function images($recordId, $langId = 0)
    {
        $languages = Language::getAllNames();
        if (count($languages) <= 1) {
            $langId =  array_key_first($languages);
        }
        $recordId = FatUtility::int($recordId);
        if (!$recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id);
        }

        if (!$row = BlogPost::getAttributesById($recordId)) {
            LibHelper::exitWithError($this->str_invalid_request_id);
        }
        $post_images = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BLOG_POST_IMAGE, $recordId, 0, $langId, (1 == count($languages)), 0, 1);
        $this->set('languages', Language::getAllNames());
        $this->set('images', $post_images);
        $this->set('recordId', $recordId);
        $this->set('canEdit', $this->objPrivilege->canEditBlogPosts($this->admin_id, true));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setImageOrder()
    {
        $this->objPrivilege->canEditBlogPosts();
        $postObj = new BlogPost();
        $post = FatApp::getPostedData();
        $recordId = FatUtility::int($post['post_id']);
        $imageIds = explode('-', $post['ids']);
        $count = 1;
        foreach ($imageIds as $row) {
            $order[$count] = $row;
            $count++;
        }
        if (!$postObj->updateImagesOrder($recordId, $order)) {
            LibHelper::exitWithError($postObj->getError(), true);
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_ORDERED_SUCCESSFULLY', $this->siteLangId));
    }

    public function uploadMedia()
    {
        $this->objPrivilege->canEditBlogPosts();
        $recordId = FatApp::getPostedData('record_id', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $languages = Language::getAllNames();
        if (count($languages) <= 1) {
            $langId = array_key_first($languages);
        }

        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $post = FatApp::getPostedData();
        if (empty($post)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST_OR_FILE_NOT_SUPPORTED', $this->siteLangId), true);
        }

        $fileType = $post['file_type'];
        if ($fileType != AttachedFile::FILETYPE_BLOG_POST_IMAGE) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_SELECT_A_FILE', $this->siteLangId), true);
        }

        $fileHandlerObj = new AttachedFile();
        if (false === $fileHandlerObj->deleteFile($fileType, $recordId, 0, 0, $langId)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        if (!$res = $fileHandlerObj->saveAttachment(
            $_FILES['cropped_image']['tmp_name'],
            $fileType,
            $recordId,
            0,
            $_FILES['cropped_image']['name'],
            -1,
            false,
            $langId
        )) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }
        $this->set('msg', Labels::getLabel('MSG_IMAGE_UPLOADED_SUCCESSFULLY', $this->siteLangId));
        $this->set('recordId', $recordId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteImage($recordId = 0, $afile_id = 0, $langId = 0)
    {
        $this->objPrivilege->canEditBlogPosts();
        $recordId = FatUtility::int($recordId);
        $afile_id = FatUtility::int($afile_id);
        $langId = FatUtility::int($langId);
        if (!$recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $languages = Language::getAllNames();
        if (1 == count($languages)) {
            $afile_id = 0;
            $langId = -1;
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile(AttachedFile::FILETYPE_BLOG_POST_IMAGE, $recordId, $afile_id, 0, $langId)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }
        $this->set('msg', Labels::getLabel('MSG_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getImagesFrm($recordId = 0)
    {
        $bannerTypeArr = applicationConstants::getAllLanguages();

        $frm = new Form('frmRecordImage', array('id' => 'imageFrm'));
        $frm->addHiddenField('', 'record_id', $recordId);
        $frm->addHiddenField('', 'file_type', AttachedFile::FILETYPE_BLOG_POST_IMAGE);
        $frm->addHiddenField('', 'min_width');
        $frm->addHiddenField('', 'min_height');

        if (count($bannerTypeArr) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', $bannerTypeArr, '', array(), '');
        } else {
            $langId = array_key_first($bannerTypeArr);
            $frm->addHiddenField('', 'lang_id', $langId);
        }
        $frm->addHtml('', 'post_image', '');
        return $frm;
    }

    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);
        $frm = new Form('frmBlogPost');
        $frm->addHiddenField('', 'post_id', 0);
        $frm->addRequiredField(Labels::getLabel('FRM_POST_TITLE', $this->siteLangId), 'post_title');
        $frm->addRequiredField(Labels::getLabel('FRM_POST_AUTHOR_NAME', $this->siteLangId), 'post_author_name');
        $frm->addHtmlEditor(Labels::getLabel('FRM_DESCRIPTION', $this->siteLangId), 'post_description')->requirements()->setRequired(true);
        $fld = $frm->addTextBox(Labels::getLabel('FRM_SEO_FRIENDLY_URL', $this->siteLangId), 'urlrewrite_custom');
        $fld->requirements()->setRequired();
        $postStatusArr = BlogPost::getBlogPostStatusArr($this->siteLangId);

        $frm->addTextBox(Labels::getLabel('FRM_CATEGORY', $this->siteLangId), 'categories');
        $frm->addCheckBox(Labels::getLabel('FRM_ALLOW_COMMENTS', $this->siteLangId), 'post_comment_opened', 1, array(), false, 0);
        
        $frm->addCheckBox(Labels::getLabel('FRM_FEATURED', $this->siteLangId), 'post_featured', 1, array(), false, 0);
        $frm->addSelectBox(Labels::getLabel('FRM_POST_STATUS', $this->siteLangId), 'post_published', $postStatusArr, '', array(), '');
        return $frm;
    }

    protected function getLangForm($recordId = 0, $langId = 0)
    {
        $langId = 1 > $langId ? $this->siteLangId : $langId;
        $recordId = FatUtility::int($recordId);
        $frm = new Form('frmBlogPostCatLang', array('id' => 'frmBlogPostCatLang'));
        $frm->addHiddenField('', 'post_id', $recordId);

        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');

        $frm->addRequiredField(Labels::getLabel('FRM_TITLE', $langId), 'post_title');
        $frm->addRequiredField(Labels::getLabel('FRM_POST_AUTHOR_NAME', $langId), 'post_author_name');
        $frm->addHtmlEditor(Labels::getLabel('FRM_DESCRIPTION', $langId), 'post_description')->requirements()->setRequired(true);

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $langId == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $langId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');

        if (!empty($fields)) {
            $this->addSortingElements($frm, 'post_title');
        }

        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $postStatusArr = BlogPost::getBlogPostStatusArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_POST_STATUS', $this->siteLangId), 'post_published', $postStatusArr, '', array('class' => 'form-control'), Labels::getLabel('FRM_POST_STATUS', $this->siteLangId));

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    public function getCategories()
    {
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        $prodCatObj = new BlogPostCategory();
        $data = $prodCatObj->getBlogPostCatTreeStructure(0, $keyword);
        $json = array();
        foreach ($data as $id => $value) {
            $json[] = array(
                'id' => $id,
                'value' => $value,
            );
        }
        die(json_encode($json));
    }

    public function autoComplete()
    {
        $pagesize = FatApp::getConfig('CONF_PAGE_SIZE');
        $post = FatApp::getPostedData();

        $postObj = new BlogPost();
        $srch = $postObj->getSearchObject($this->siteLangId, false, true);

        $srch->addMultipleFields(array('post_id, IFNULL(post_title, post_identifier) as post_title'));

        if (!empty($post['keyword'])) {
            $cond = $srch->addCondition('post_title', 'LIKE', '%' . $post['keyword'] . '%');
            $cond->attachCondition('post_identifier', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
        }

        $excludeRecords = FatApp::getPostedData('excludeRecords', FatUtility::VAR_INT);
        if (!empty($excludeRecords) && is_array($excludeRecords)) {
            $srch->addCondition('post_id', 'NOT IN', $excludeRecords);
        }

        $collectionId = FatApp::getPostedData('collection_id', FatUtility::VAR_INT, 0);
        $alreadyAdded = Collections::getRecords($collectionId);
        if (!empty($alreadyAdded) && 0 < count($alreadyAdded)) {
            $srch->addCondition('post_id', 'NOT IN', array_keys($alreadyAdded));
        }

        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();
        $posts = $db->fetchAll($rs, 'post_id');
        $json = array();
        foreach ($posts as $key => $post) {
            $json['results'][] = array(
                'id' => $key,
                'text' => strip_tags(html_entity_decode($post['post_title'], ENT_QUOTES, 'UTF-8'))
            );
        }
        die(json_encode($json));
    }

    protected function getFormColumns(): array
    {
        $blogPostsItemsTblHeadingCols = CacheHelper::get('blogPostsItemsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($blogPostsItemsTblHeadingCols) {
            return json_decode($blogPostsItemsTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'post_title' => Labels::getLabel('LBL_POST_TITLE', $this->siteLangId),
            'categories' => Labels::getLabel('LBL_POST_CATEGORY', $this->siteLangId),
            'post_published_on' => Labels::getLabel('LBL_PUBLISHED_DATE', $this->siteLangId),
            'post_published' => Labels::getLabel('LBL_POST_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('blogPostsItemsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'post_title',
            'categories',
            'post_published_on',
            'post_published',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
