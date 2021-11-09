<?php

class ImageAttributesController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewImageAttributes();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('canEdit', $this->objPrivilege->canEditImageAttributes($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->set('pageTitle', Labels::getLabel('NAV_MANAGE_IMAGE_ATTRIBUTES', $this->siteLangId));
        $this->getListingData();

        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'image-attributes/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function getListingData()
    {
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
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $searchForm = $this->getSearchForm($fields);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = AttachedFile::getSearchObject();

        if (!empty($post['select_module'])) {
            $cnd = $srch->addCondition('afile_type', '=', $post['select_module']);
        } else {
            $cnd = $srch->addCondition('afile_type', '=', AttachedFile::FILETYPE_PRODUCT_IMAGE);
        }

        switch ($post['select_module']) {
            case AttachedFile::FILETYPE_PRODUCT_IMAGE:
                $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'product_id = afile_record_id', 'p');
                $srch->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $this->siteLangId, 'p_l');
                $srch->addMultipleFields(
                    array('product_id as record_id', 'IFNULL(product_name, product_identifier) as record_name', 'afile_type')
                );
                if (!empty($post['keyword'])) {
                    $cnd = $srch->addCondition('product_name', 'like', '%' . $post['keyword'] . '%');
                    $cnd->attachCondition('product_identifier', 'like', '%' . $post['keyword'] . '%');
                }
                break;
            case AttachedFile::FILETYPE_CATEGORY_BANNER:
                $srch->joinTable(ProductCategory::DB_TBL, 'LEFT OUTER JOIN', 'prodcat_id = afile_record_id', 'pc');
                $srch->joinTable(ProductCategory::DB_TBL_LANG, 'LEFT OUTER JOIN', 'pc.prodcat_id = pc_l.prodcatlang_prodcat_id AND pc_l.prodcatlang_lang_id = ' . $this->siteLangId, 'pc_l');
                $srch->addMultipleFields(
                    array('prodcat_id as record_id', 'IFNULL(prodcat_name, prodcat_identifier) as record_name', 'afile_type')
                );
                if (!empty($post['keyword'])) {
                    $cnd = $srch->addCondition('prodcat_name', 'like', '%' . $post['keyword'] . '%');
                    $cnd->attachCondition('prodcat_identifier', 'like', '%' . $post['keyword'] . '%');
                }
                break;
            case AttachedFile::FILETYPE_BLOG_POST_IMAGE:
                $srch->joinTable(BlogPost::DB_TBL, 'LEFT OUTER JOIN', 'post_id = afile_record_id', 'bp');
                $srch->joinTable(BlogPost::DB_TBL_LANG, 'LEFT OUTER JOIN', 'bp.post_id = bp_l.postlang_post_id AND bp_l.postlang_lang_id = ' . $this->siteLangId, 'bp_l');
                $srch->addMultipleFields(
                    array('post_id as record_id', 'IFNULL(post_title, post_identifier) as record_name', 'afile_type')
                );
                if (!empty($post['keyword'])) {
                    $cnd = $srch->addCondition('post_title', 'like', '%' . $post['keyword'] . '%');
                    $cnd->attachCondition('post_identifier', 'like', '%' . $post['keyword'] . '%');
                }
                break;
            default:
                $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'product_id = afile_record_id', 'p');
                $srch->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $this->siteLangId, 'p_l');
                $srch->addMultipleFields(
                    array('product_id as record_id', 'IFNULL(product_name, product_identifier) as record_name', 'afile_type')
                );
                if (!empty($post['keyword'])) {
                    $cnd = $srch->addCondition('product_name', 'like', '%' . $post['keyword'] . '%');
                    $cnd->attachCondition('product_identifier', 'like', '%' . $post['keyword'] . '%');
                }
                break;
        }

        $srch->addGroupBy('record_id');
        $srch->addOrder($sortBy, $sortOrder);
        $srch->addHaving('record_id', 'is not', 'mysql_func_NULL', 'AND', true);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set("arrListing", $records);
        $this->set('moduleType', (isset($post['select_module'])) ? $post['select_module'] : AttachedFile::FILETYPE_PRODUCT_IMAGE);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditImageAttributes($this->admin_id, true));
    }

    public function form($recordId, $moduleType, $langId = 0, $optionId = 0)
    {
        $recordId = FatUtility::int($recordId);
        $moduleType = FatUtility::int($moduleType);
        $langId = FatUtility::int($langId);
        $optionId = FatUtility::int($optionId);

        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request, false, false, true);
        }

        switch ($moduleType) {
            case AttachedFile::FILETYPE_PRODUCT_IMAGE:
                $data = Product::getProductDataById($this->siteLangId, $recordId, 'IFNULL(product_name, product_identifier) as title');
                $title = $data['title'];
                break;
            case AttachedFile::FILETYPE_CATEGORY_BANNER:
                $srch = ProductCategory::getSearchObject(false, $this->siteLangId);
                $srch->addOrder('m.prodcat_active', 'DESC');
                $srch->addCondition(ProductCategory::DB_TBL_PREFIX . 'deleted', '=', 0);
                $srch->addFld('IFNULL(prodcat_name, prodcat_identifier) AS prodcat_name');
                $srch->addCondition('prodcat_id', '=', $recordId);
                $srch->addOrder('prodcat_id', 'DESC');
                $srch->doNotCalculateRecords();
                $srch->setPageSize(1);
                $rs = $srch->getResultSet();
                $records = FatApp::getDb()->fetch($rs);
                $title = $records['prodcat_name'];
                break;
            case AttachedFile::FILETYPE_BLOG_POST_IMAGE:
                $srch = BlogPost::getSearchObject($this->siteLangId);
                $srch->addFld('IFNULL(post_title, post_identifier) as post_title');
                $srch->addCondition('post_id', '=', $recordId);
                $srch->addOrder('post_id', 'DESC');
                $srch->doNotCalculateRecords();
                $srch->setPageSize(1);
                $rs = $srch->getResultSet();
                $records = FatApp::getDb()->fetch($rs);

                $title = $records['post_title'];
                break;
            default:
                $srch = Brand::getListingObj($this->siteLangId, null, true);
                $srch->addCondition('brand_id', '=', $recordId);
                $srch->addOrder('brand_id', 'DESC');
                $srch->doNotCalculateRecords();
                $srch->setPageSize(1);
                $rs = $srch->getResultSet();
                $records = FatApp::getDb()->fetch($rs);
                $title = $records['brand_name'];
                break;
        }
        $images = AttachedFile::getMultipleAttachments($moduleType, $recordId, $optionId, $langId, false, 0, 0, true);
        $languages = Language::getAllNames();
        $frm = $this->getImgAttrForm($recordId, $moduleType, $langId, $images, $optionId);
        $this->set('recordId', $recordId);
        $this->set('moduleType', $moduleType);
        $this->set('langId', $langId);
        $this->set('languages', $languages);
        $this->set('title', $title);
        $this->set('images', $images);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    private function getImgAttrForm($recordId, $moduleType, $langId, $images, $optionId = 0)
    {
        $this->objPrivilege->canViewImageAttributes();
        $recordId = FatUtility::int($recordId);
        $moduleType = FatUtility::int($moduleType);
        $langId = FatUtility::int($langId);

        //$images = AttachedFile::getMultipleAttachments($moduleType, $recordId, 0, $langId, false, 0, 0, true);

        $frm = new Form('frmImgAttr');
        $frm->addHiddenField('', 'module_type', $moduleType);
        $frm->addHiddenField('', 'record_id', $recordId);

        if ($moduleType == AttachedFile::FILETYPE_PRODUCT_IMAGE) {
            $imgTypesArr = Product::getSeparateImageOptions($recordId, $this->siteLangId);
            $frm->addSelectBox(Labels::getLabel('LBL_Image_File_Type', $this->siteLangId), 'option_id', $imgTypesArr, $optionId, array(), '');
        }

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->siteLangId), 'lang_id', $languages, $langId, array(), '');
        } else {
            $lang_id = array_key_first($languages);
            $frm->addHiddenField('', 'lang_id', $lang_id);
        }

        foreach ($images as $afileId => $afileData) {
            $frm->addTextBox(Labels::getLabel('LBL_Image_Title', $this->siteLangId), 'image_title' . $afileId);
            $frm->addTextBox(Labels::getLabel('LBL_Image_Alt', $this->siteLangId), 'image_alt' . $afileId);
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save', $this->siteLangId));
        $frm->addButton('', 'btn_discard', Labels::getLabel('LBL_Discard', $this->siteLangId));
        return $frm;
    }

    /* public function images($recordId, $moduleType, $lang_id = 0)
      {
      $recordId = FatUtility::int($recordId);
      $moduleType = FatUtility::int($moduleType);
      if ($recordId < 1) {
      Message::addErrorMessage($this->str_invalid_request);
      FatUtility::dieWithError(Message::getHtml());
      }

      $images = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_PRODUCT_IMAGE, $recordId, 0, $lang_id, false, 0, 0, true);

      $this->set('images', $productImages);
      $this->set('languages', Language::getAllNames());
      $this->_template->render(false, false);
      } */

    public function setup()
    {
        $this->objPrivilege->canEditImageAttributes();

        $post = FatApp::getPostedData();
        $recordId = FatUtility::int($post['record_id']);
        $moduleType = FatUtility::int($post['module_type']);
        $langId = FatUtility::int($post['lang_id']);
        $optionId = FatApp::getPostedData('option_id', FatUtility::VAR_INT, 0);
        if (!$recordId || !$moduleType) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieJsonError(Message::getHtml());
        }

        $images = AttachedFile::getMultipleAttachments($moduleType, $recordId, $optionId, $langId, false, 0, 0, true);

        $frm = $this->getImgAttrForm($recordId, $moduleType, $langId, $images, $optionId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $db = FatApp::getDb();
        // $recordSaved = false;
        foreach ($images as $afileId => $afileData) {
            /* if(empty($post['image_title'.$afileId]) && empty($post['image_alt'.$afileId])) {
              continue;
              } */
            $where = array('smt' => 'afile_record_id = ? and afile_id = ?', 'vals' => array($recordId, $afileId));
            if (!$db->updateFromArray(AttachedFile::DB_TBL, array('afile_attribute_title' => $post['image_title' . $afileId], 'afile_attribute_alt' => $post['image_alt' . $afileId]), $where)) {
                Message::addErrorMessage($db->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
            // $recordSaved = true;
        }
        /* if (!$recordSaved) {
          Message::addErrorMessage(Labels::getLabel('MSG_Please_fill_any_one', $this->siteLangId));
          FatUtility::dieWithError(Message::getHtml());
          } */
        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditImageAttributes();

        $urlrewrite_id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if ($urlrewrite_id < 1) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        $res = UrlRewrite::getAttributesById($urlrewrite_id, array('urlrewrite_id'));
        if ($res == false) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieJsonError(Message::getHtml());
        }

        $this->markAsDeleted($urlrewrite_id);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditImageAttributes();
        $urlrewriteIdsArr = FatUtility::int(FatApp::getPostedData('urlrewrite_ids'));

        if (empty($urlrewriteIdsArr)) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }

        foreach ($urlrewriteIdsArr as $urlrewriteId) {
            if (1 > $urlrewriteId) {
                continue;
            }
            $this->markAsDeleted($urlrewriteId);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function markAsDeleted($urlrewriteId)
    {
        $urlrewriteId = FatUtility::int($urlrewriteId);
        if (1 > $urlrewriteId) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }
        $obj = new UrlRewrite($urlrewriteId);
        if (!$obj->deleteRecord(false)) {
            Message::addErrorMessage($obj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('LBL_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $attachedFile = new AttachedFile();
        $attachementArr = $attachedFile->getImgAttrTypeArray($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_SELECT_TYPE', $this->siteLangId), 'select_module', $attachementArr, AttachedFile::FILETYPE_PRODUCT_IMAGE);

        if (!empty($fields)) {
            $this->addSortingElements($frm, 'record_name');
        }

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    private function getForm($urlrewrite_id = 0)
    {
        $this->objPrivilege->canViewImageAttributes();
        $urlrewrite_id = FatUtility::int($urlrewrite_id);

        $frm = new Form('frmUrlRewrite');
        $frm->addHiddenField('', 'urlrewrite_id');
        $frm->addRequiredField(Labels::getLabel('LBL_Original_URL', $this->siteLangId), 'urlrewrite_original');
        $fld = $frm->addRequiredField(Labels::getLabel('LBL_Custom_URL', $this->siteLangId), 'urlrewrite_custom');
        $fld->htmlAfterField = '<small>' . Labels::getLabel('LBL_Example:_Custom_URL_Example', $this->siteLangId) . '</small>';
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->siteLangId));
        return $frm;
    }

    private function getFormColumns()
    {
        $imgAttrCacheVar = CacheHelper::get('imgAttrCacheVar' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($imgAttrCacheVar) {
            return json_decode($imgAttrCacheVar);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'record_name' => Labels::getLabel('LBL_NAME', $this->siteLangId),
            'action' => ''
        ];
        CacheHelper::create('imgAttrCacheVar' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'listSerial',
            'record_name',
            'action'
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
