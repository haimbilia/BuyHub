<?php

class BlogPostCategoriesController extends ListingBaseController
{
    protected string $modelClass = 'BlogPostCategory';
    protected $pageKey = 'BLOG_CATEGORIES';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewBlogPostCategories();
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
            $this->set("canEdit", $this->objPrivilege->canEditBlogPostCategories($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditBlogPostCategories();
        }
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
        $this->setModel($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('name')];
        $this->set('formTitle', Labels::getLabel('LBL_BLOG_POST_CATEGORIES_SETUP', $this->siteLangId));
    }

    public function index()
    {
        $this->checkEditPrivilege(true);
        $this->_template->addJs(array('js/jquery-sortable-lists.js'));
        $this->_template->render();
    }

    public function search()
    {
        $this->checkEditPrivilege(true);
        $records = BlogPostCategory::getBlogPostCatParentChildWiseArr($this->siteLangId, 0, true, false, false);

        $this->set("arrListing", $records);
        $this->_template->render(false, false);
    }

    public function getSubCategories()
    {
        $this->checkEditPrivilege(true);
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        $childCategories = BlogPostCategory::getBlogPostCatParentChildWiseArr($this->siteLangId, $recordId, true, false, false);
        $this->set("childCategories", $childCategories);
        $this->_template->render(false, false);
    }

    public function form()
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);

        if (0 < $recordId) {
            $data = BlogPostCategory::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $recordId, null, true);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            /* url data[ */
            $urlSrch = UrlRewrite::getSearchObject();
            $urlSrch->doNotCalculateRecords();
            $urlSrch->setPageSize(1);
            $urlSrch->addFld('urlrewrite_custom');
            $urlSrch->addCondition('urlrewrite_original', '=', 'blog/category/' . $recordId);
            $urlRow = FatApp::getDb()->fetch($urlSrch->getResultSet());
            if ($urlRow) {
                $data['urlrewrite_custom'] = $urlRow['urlrewrite_custom'];
            }
            /* ] */
            $frm->fill($data);
        }


        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->checkEditPrivilege();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $data = $post;

        $recordId = FatUtility::int($post['bpcategory_id']);
        $parentCatId = FatUtility::int($post['bpcategory_parent']);

        $record = new BlogPostCategory($recordId);
        if ($recordId == 0) {
            $display_order = $record->getMaxOrder($parentCatId);
            $data['bpcategory_display_order'] = $display_order;
        }
        $record->assignValues($data);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }
        $recordId = $record->getMainTableRecordId();
        /* url data[ */
        $blogOriginalUrl = BlogPostCategory::REWRITE_URL_PREFIX . $recordId;
        if ($data['urlrewrite_custom'] == '') {
            FatApp::getDb()->deleteRecords(UrlRewrite::DB_TBL, array('smt' => 'urlrewrite_original = ?', 'vals' => array($blogOriginalUrl)));
        } else {
            $record->rewriteUrl($data['urlrewrite_custom'], true, $parentCatId);
        }
        /* ] */

        if (!$record->updateLangData(CommonHelper::getDefaultFormLangId(), ['bpcategory_name' => $data['bpcategory_name']])) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(BlogPostCategory::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        if (0 < count($languages)) {
            foreach ($languages as $langId => $langName) {
                if (!Brand::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateOrder()
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('catId', FatUtility::VAR_INT, 0);
        $parentCatId = FatApp::getPostedData('parentCatId', FatUtility::VAR_INT, 0);
        $catOrderArr = json_decode(FatApp::getPostedData('catOrder'));
        if ($recordId < 1 || count($catOrderArr) < 1) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $catObj = new BlogPostCategory($recordId);
        $catObj->updateCatParent($parentCatId);
        if (!$catObj->updateOrder($catOrderArr)) {
            LibHelper::exitWithError($catObj->getError(), true);
        }

        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_BLOG_POST_CATEGORIES', $this->siteLangId)]
                ];
                break;
            default:
                parent::getBreadcrumbNodes($action);
                break;
        }
        return $this->nodes;
    }

    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);
        $bpCatObj = new BlogPostCategory();
        $arrCategories = $bpCatObj->getCategoriesForSelectBox($this->siteLangId, $recordId);
        $categories = $bpCatObj->makeAssociativeArray($arrCategories);

        $frm = new Form('frmBlogPostCategory');
        $frm->addHiddenField('', 'bpcategory_id', $recordId);
        $frm->addRequiredField(Labels::getLabel('FRM_CATEGORY_IDENTIFIER', $this->siteLangId), 'bpcategory_identifier');
        $frm->addRequiredField(Labels::getLabel('FRM_CATEGORY_NAME', $this->siteLangId), 'bpcategory_name');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_SEO_FRIENDLY_URL', $this->siteLangId), 'urlrewrite_custom');
        $fld->requirements()->setRequired();
        $frm->addSelectBox(Labels::getLabel('FRM_CATEGORY_PARENT', $this->siteLangId), 'bpcategory_parent', array(0 => Labels::getLabel('LBL_ROOT_CATEGORY', $this->siteLangId)) + $categories, '', array(), '');
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_CATEGORY_STATUS', $this->siteLangId), 'bpcategory_active', $activeInactiveArr, '', array(), '');
        $frm->addCheckBox(Labels::getLabel('FRM_FEATURED', $this->siteLangId), 'bpcategory_featured', 1, array(), false, 0);

        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }

    protected function getLangForm($recordId = 0, $langId = 0)
    {
        $langId = 1 > $langId ? $this->siteLangId : $langId;
        $frm = new Form('frmBlogPostCatLang', array('id' => 'frmBlogPostCatLang'));
        $frm->addHiddenField('', 'bpcategory_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_Category_Name', $langId), 'bpcategory_name');
        return $frm;
    }
}
