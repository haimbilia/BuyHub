<?php

class CategoryController extends MyAppController
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function index()
    {
        $headerCategories = ProductCategory::getArray($this->siteLangId, 0, false, true, false, CONF_USE_FAT_CACHE);
        $this->_template->addJs('js/imagesloaded.pkgd.min.js');
        $this->set('categoriesArr', $headerCategories);
        $this->_template->render();
    }

    public function view($categoryId)
    {
        $categoryId = FatUtility::int($categoryId);

        ProductCategory::recordCategoryWeightage($categoryId);

        $db = FatApp::getDb();
        $frm = $this->getProductSearchForm();
        if (true === MOBILE_APP_API_CALL) {
            $get = FatApp::getPostedData();
        } else {
            $get = Product::convertArrToSrchFiltersAssocArr(FatApp::getParameters());
        }

        $get['category'] = $categoryId;
        $get['join_price'] = 1;
        $get['vtype']  = $get['vtype'] ?? 'grid';
        if (!FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, '')) && $get['vtype'] == 'map') {
            $get['vtype'] = 'grid';
        }
        // $frm->fill($get);

        $productCategorySearch = new ProductCategorySearch($this->siteLangId, true, true, false, false);
        $productCategorySearch->addCondition('prodcat_id', '=', $categoryId);

        /* to show searched category data[ */
        $productCategorySearch->addMultipleFields(array('prodcat_id', 'IFNULL(prodcat_name, prodcat_identifier) as prodcat_name', 'prodcat_description', 'prodcat_code'));
        $productCategorySearch->setPageSize(1);
        $productCategorySearch->doNotCalculateRecords();
        $productCategorySearchRs = $productCategorySearch->getResultSet();
        $category = $db->fetch($productCategorySearchRs);

        if (false == $category) {
            if (true === MOBILE_APP_API_CALL) {
                $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
                FatUtility::dieJsonError($message);
            }
            FatUtility::exitWithErrorCode(404);
        }

        if (false === MOBILE_APP_API_CALL) {
            $bannerDetail = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_BANNER, $categoryId);
            $category['banner'] = empty($bannerDetail) ? (object) array() : $bannerDetail;
        } else {
            $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_CATEGORY_BANNER, $categoryId, 0, 0, applicationConstants::SCREEN_MOBILE);
            $uploadedTime = AttachedFile::setTimeParam($fileRow['afile_updated_at']);
            $category['banner']['mobile'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Category', 'Banner', array($categoryId, $this->siteLangId, ImageDimension::VIEW_MOBILE, $fileRow['afile_id'], applicationConstants::SCREEN_MOBILE)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

            $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_CATEGORY_BANNER, $categoryId, 0, 0, applicationConstants::SCREEN_IPAD);
            $uploadedTime = AttachedFile::setTimeParam($fileRow['afile_updated_at']);
            $category['banner']['ipad'] = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('Category', 'Banner', array($categoryId, $this->siteLangId, ImageDimension::VIEW_TABLET, $fileRow['afile_id'], applicationConstants::SCREEN_IPAD)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
        }
        /* ] */

        $userId = 0;
        if (UserAuthentication::isUserLogged()) {
            $userId = UserAuthentication::getLoggedUserId();
        }

        $page = 1;
        if (array_key_exists('page', $get)) {
            $page = FatUtility::int($get['page']);
            if ($page < 2) {
                $page = 1;
            }
        }

        $pageSize = 1;
        if (array_key_exists('pageSize', $get)) {
            $pageSize = FatUtility::int($get['pageSize']);
            if (0 >= $pageSize) {
                $pageSize = FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 10);
            }
        }

        if (!in_array($pageSize, FilterHelper::getPageSizeValues())) {
            $pageSize = FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 10);
        }

        $get['page'] = $page;
        $get['pageSize'] = $pageSize;

        $srch = Product::getListingObj($get, $this->siteLangId, $userId);
        $flds = array(
            'prodcat_code', 'product_id', 'prodcat_id', 'COALESCE(product_name, product_identifier) as product_name', 'product_model',  'product_updated_on', 'COALESCE(prodcat_name, prodcat_identifier) as prodcat_name',
            'selprod_id', 'selprod_user_id',  'selprod_code', 'selprod_stock', 'selprod_condition', 'selprod_price', 'COALESCE(selprod_title  ,COALESCE(product_name, product_identifier)) as selprod_title',
            'splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type', 'splprice_start_date', 'splprice_end_date',
            'brand_id', 'COALESCE(brand_name, brand_identifier) as brand_name', 'user_name', 'IF(selprod_stock > 0, 1, 0) AS in_stock',
            'selprod_sold_count', 'selprod_return_policy', /*'maxprice', 'ifnull(sq_sprating.totReviews,0) totReviews','IF(ufp_id > 0, 1, 0) as isfavorite', */ 'selprod_min_order_qty',
            'shop.shop_id', 'shop.shop_lat', 'shop.shop_lng', 'COALESCE(shop_name, shop_identifier) as shop_name'
        );
        $this->setRecordCount(clone $srch, $get['pageSize'], $get['page'], $get, true, $flds);
        Product::setOrderOnListingObj($srch, $get);
        $srch->setPageNumber($page);
        if ($pageSize) {
            $srch->setPageSize($pageSize);
        }

        $products = FatApp::getDb()->fetchAll($srch->getResultSet());

        $selProdIdsArr = array_column($products, 'selprod_id');
        $tRightRibbons = Badge::getRibbons($this->siteLangId, Badge::RIBB_POS_TRIGHT, $selProdIdsArr);

        $frm->fill($get);
        $data = array(
            'frmProductSearch' => $frm,
            'category' => $category,
            'products' => $products,
            'tRightRibbons' => $tRightRibbons,
            /* 'moreSellersProductsArr' => $moreSellersArr,*/
            'page' => $this->pageData['page'],
            'pageSize' => $this->pageData['pageSize'],
            'pageCount' => $this->pageData['pageCount'],
            'recordCount' => $this->pageData['recordCount'],
            'categoryId' => $categoryId,
            'postedData' => $get,
            'pageTitle' => $category['prodcat_name'],
            'canonicalUrl' => UrlHelper::generateFullUrl('Category', 'view', array($categoryId)),
            'productSearchPageType' => SavedSearchProduct::PAGE_CATEGORY,
            'recordId' => $categoryId,
            'bannerListigUrl' => UrlHelper::generateFullUrl('Banner', 'categories'),
            'siteLangId' => $this->siteLangId,
            'showBreadcrumb' => true,
            'pageSizeArr' => FilterHelper::getPageSizeArr($this->siteLangId)
        );

        if (FatUtility::isAjaxCall()) {
            $this->set('products', $products);
            /* $this->set('page', $page);           
            $this->set('pageCount', $srch->pages());
            $this->set('recordCount', $srch->recordCount());
            $this->set('pageSize', $data['pageSize']); */
            $this->set('postedData', $get);
            $this->set('siteLangId', $this->siteLangId);
            $this->set('pageSizeArr', $data['pageSizeArr']);
            $this->set('tRightRibbons', $tRightRibbons);
            echo $this->_template->render(false, false, 'products/products-list.php', true);
            exit;
        }

        $this->set('data', $data);
        if (false === MOBILE_APP_API_CALL) {
            $this->includeProductPageJsCss();
            $this->_template->addJs('js/slick.min.js');
        }
        $this->_template->render();
    }

    public function image($catId, $langId = 0, $sizeType = '', $afileId = 0)
    {
        $catId = FatUtility::int($catId);
        $langId = FatUtility::int($langId);
        if ($afileId > 0) {
            $res = AttachedFile::getAttributesById($afileId);
            if (!false == $res && $res['afile_type'] == AttachedFile::FILETYPE_CATEGORY_IMAGE) {
                $file_row = $res;
            }
        } else {
            $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_IMAGE, $catId, 0, $langId);
        }

        $image_name = isset($file_row['afile_physical_path']) ? $file_row['afile_physical_path'] : '';
        $image_name = AttachedFile::setNamePrefix($image_name, $sizeType);


        $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_CATEGORY_IMAGE, $sizeType);
        $default_image = 'logo_default.svg';

        if ($sizeType) {
            AttachedFile::displayImage($image_name, $imageDimensions['width'], $imageDimensions['height'], $default_image);
        } else {
            AttachedFile::displayOriginalImage($image_name, $default_image);
        }
    }

    public function icon($catId, $langId = 0, $sizeType = '')
    {
        $default_image = 'logo_default.svg';
        $catId = FatUtility::int($catId);
        $langId = FatUtility::int($langId);
        $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_ICON, $catId, 0, $langId);
        $image_name = isset($file_row['afile_physical_path']) ? $file_row['afile_physical_path'] : '';
        $aspectRatioType = $file_row['afile_aspect_ratio'];
        $aspectRatioType = ($aspectRatioType > 0) ? $aspectRatioType : 1;
        $image_name = AttachedFile::setNamePrefix($image_name, $sizeType, $aspectRatioType);
        $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_CATEGORY_ICON, $sizeType);

        if ($sizeType) {
            AttachedFile::displayImage($image_name, $imageDimensions['width'], $imageDimensions['height'], $default_image);
        } else {
            AttachedFile::displayOriginalImage($image_name, $default_image);
        }
    }


    public function thumb($catId, $langId = 0, $sizeType = '')
    {
        $catId = FatUtility::int($catId);
        $langId = FatUtility::int($langId);
        $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_THUMB, $catId, 0, $langId);
        $image_name = isset($file_row['afile_physical_path']) ? $file_row['afile_physical_path'] : '';
        $image_name = AttachedFile::setNamePrefix($image_name, $sizeType);
        $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_CATEGORY_THUMB, $sizeType);
        $default_image = 'no_image.jpg';

        if ($sizeType) {
            AttachedFile::displayImage($image_name, $imageDimensions['width'], $imageDimensions['height'], $default_image);
        } else {
            AttachedFile::displayOriginalImage($image_name, $default_image);
        }
    }


    public function sellerBanner($shopId, $prodCatId, $langId = 0, $sizeType = '')
    {
        $shopId = FatUtility::int($shopId);
        $prodCatId = FatUtility::int($prodCatId);
        $langId = FatUtility::int($langId);

        $default_image = 'banner-default-image.png';
        $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_BANNER_SELLER, $shopId, $prodCatId, $langId);
        $image_name = isset($file_row['afile_physical_path']) ? $file_row['afile_physical_path'] : '';
        $image_name = AttachedFile::setNamePrefix($image_name, $sizeType);

        $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_CATEGORY_SELLER_BANNER, $sizeType);

        if ($sizeType) {
            AttachedFile::displayImage($image_name, $imageDimensions['width'], $imageDimensions['height'], $default_image);
        } else {
            AttachedFile::displayOriginalImage($image_name, $default_image);
        }
    }

    public function banner($prodCatId, $langId = 0, $sizeType = '', $afileId = 0, $screen = 0, $displayUniversalImage = true)
    {
        $default_image = 'banner-default-image.png';
        $prodCatId = FatUtility::int($prodCatId);
        $langId = FatUtility::int($langId);

        if ($afileId > 0) {
            $res = AttachedFile::getAttributesById($afileId);
            if (!false == $res && $res['afile_type'] == AttachedFile::FILETYPE_CATEGORY_BANNER) {
                $file_row = $res;
            }
        } else {
            $file_row = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_BANNER, $prodCatId, 0, $langId, $displayUniversalImage, $screen);
        }


        $image_name = isset($file_row['afile_physical_path']) ? $file_row['afile_physical_path'] : '';
        $image_name = AttachedFile::setNamePrefix($image_name, $sizeType);


        $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_CATEGORY_BANNER, $sizeType);

        if ($sizeType) {
            AttachedFile::displayImage($image_name, $imageDimensions['width'], $imageDimensions['height'], $default_image);
        } else {
            AttachedFile::displayOriginalImage($image_name, $default_image);
        }
    }

    public function getBreadcrumbNodes($action)
    {
        $nodes = array();
        $parameters = FatApp::getParameters();
        switch ($action) {
            case 'view':
                if (isset($parameters[0]) && $parameters[0] > 0) {
                    $parent = FatUtility::int($parameters[0]);
                    if ($parent > 0) {
                        $cntInc = 1;
                        $prodCateObj = new ProductCategory();
                        $category_structure = $prodCateObj->getCategoryStructure($parent, '', $this->siteLangId);
                        $category_structure = array_reverse($category_structure);
                        foreach ($category_structure as $catKey => $catVal) {
                            if ($cntInc < count($category_structure)) {
                                $nodes[] = array('title' => $catVal["prodcat_name"], 'href' => Urlhelper::generateUrl('category', 'view', array($catVal['prodcat_id'])));
                            } else {
                                $nodes[] = array('title' => $catVal["prodcat_name"]);
                            }
                            $cntInc++;
                        }
                    }
                }
                break;

            case 'form':
                break;
        }
        return $nodes;
    }

    private function resetKeyValues($arr, $langId)
    {
        $langId = FatUtility::int($langId);
        $result = array();
        foreach ($arr as $key => $val) {
            if (!array_key_exists('prodcat_id', $val)) {
                continue;
            }
            $uploadedTime = AttachedFile::setTimeParam($val['prodcat_updated_on']);

            $result[$key] = $val;
            $isLastChildCategory = ProductCategory::isLastChildCategory($val['prodcat_id']);
            $result[$key]['isLastChildCategory'] = $isLastChildCategory ? 1 : 0;
            $result[$key]['icon'] = UrlHelper::generateFullUrl('Category', 'icon', array($val['prodcat_id'], $langId, 'COLLECTION_PAGE')) . $uploadedTime;
            $result[$key]['image'] = UrlHelper::generateFullUrl('Category', 'banner', array($val['prodcat_id'], $langId, 'MOBILE', applicationConstants::SCREEN_MOBILE)) . $uploadedTime;
            $childernArr = array();
            if (!empty($val['children'])) {
                $array = array_values($val['children']);
                $childernArr = $this->resetKeyValues($array, $langId);
            }
            $result[$key]['children'] = $childernArr;
        }
        return array_values($result);
    }

    /**
     * (For API only)
     */
    public function structure()
    {
        $parentId = FatApp::getPostedData('parentId', FatUtility::VAR_INT, 0);
        $categoriesArr = ProductCategory::getProdCatParentChildWiseArr($this->siteLangId, $parentId, true, false, false, false, true);

        $categoriesArr = $this->resetKeyValues(array_values($categoriesArr), $this->siteLangId);
        $this->set('categoriesData', (array)$categoriesArr);
        $this->_template->render();
    }

    public function checkUniqueCategoryName()
    {
        $post = FatApp::getPostedData();

        $langId = FatUtility::int($post['langId']);

        $categoryName = $post['categoryName'];
        $categoryId = FatUtility::int($post['categoryId']);
        if (1 > $langId) {
            trigger_error(Labels::getLabel('ERR_LANG_ID_NOT_SPECIFIED', CommonHelper::getLangId()), E_USER_ERROR);
        }
        if (1 > $categoryId) {
            trigger_error(Labels::getLabel('ERR_BRAND_ID_NOT_SPECIFIED', CommonHelper::getLangId()), E_USER_ERROR);
        }
        $srch = productCategory::getSearchObject($langId);
        $srch->addOrder('m.prodcat_active', 'DESC');
        $srch->addCondition('prodcat_name', '=', $categoryName);
        if ($categoryId) {
            $srch->addCondition('prodcat_id', '!=', $categoryId);
        }
        $rs = $srch->getResultSet();
        $records = $srch->recordCount();
        if ($records > 0) {
            FatUtility::dieJsonError(sprintf(Labels::getLabel('ERR_%S_NOT_AVAILABLE', $this->siteLangId), $categoryName));
        }
        FatUtility::dieJsonSuccess(array());
    }
}
