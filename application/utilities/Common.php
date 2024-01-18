<?php

class Common
{
    public static function test($template)
    {
        die('dsdsdsdsdsd');
    }
    public static function cartSummary($template)
    {
        $cartObj = new Cart();
        $cartObj->invalidateCheckoutType();
        $siteLangId = CommonHelper::getLangId();
        
        if (FatApp::getConfig("CONF_PRODUCT_INCLUSIVE_TAX", FatUtility::VAR_INT, 0)) {
            $cartObj->excludeTax();
        }
        $cartObj->excludeOfferCheckoutItems();
        $productsArr = $cartObj->getProducts($siteLangId);
        $cartSummary = $cartObj->getCartFinancialSummary($siteLangId);

        $saveForLaterProducts = [];
        if (UserAuthentication::isUserLogged()) {
            $saveForLaterProducts = UserWishList::savedForLaterItems(UserAuthentication::getLoggedUserId(), $siteLangId);
        }
        $template->set('saveForLaterProducts', $saveForLaterProducts);
        $template->set('siteLangId', $siteLangId);
        $template->set('products', $productsArr);
        $template->set('cartSummary', $cartSummary);
        $template->set('totalCartItems', $cartObj->countProducts());
    }

    public static function countWishList()
    {
        $loggedUserId = 0;
        if (UserAuthentication::isUserLogged()) {
            $loggedUserId = UserAuthentication::getLoggedUserId();
        }

        $wislistPSrchObj = new UserWishListProductSearch();
        $wislistPSrchObj->joinSellerProducts();
        $wislistPSrchObj->joinProducts();
        $wislistPSrchObj->joinSellers();
        $wislistPSrchObj->joinShops();
        $wislistPSrchObj->joinProductToCategory();
        $wislistPSrchObj->joinSellerSubscription();
        $wislistPSrchObj->addSubscriptionValidCondition();
        $wislistPSrchObj->joinWishLists();
        $wislistPSrchObj->doNotLimitRecords();
        $wislistPSrchObj->addCondition('uwlist_user_id', '=', 'mysql_func_' . $loggedUserId, 'AND', true);
        $wislistPSrchObj->addCondition('selprod_deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        $wislistPSrchObj->addCondition('selprod_active', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
        $wislistPSrchObj->addGroupBy('uwlp_selprod_id');
        $wislistPSrchObj->addMultipleFields(array('uwlp_uwlist_id'));
        $rs = $wislistPSrchObj->getResultSet();
        $totalWishListItems = $wislistPSrchObj->recordCount();

        return $totalWishListItems;
    }

    public static function setHeaderBreadCrumb($template)
    {
        $cname = FatApp::getController();
        $action = FatApp::getAction();

        $controller = new $cname('');
        $template->set('siteLangId', CommonHelper::getLangId());
        $template->set('nodes', $controller->getBreadcrumbNodes($action));
    }

    public static function headerUserArea($template)
    {
        $template->set('siteLangId', CommonHelper::getLangId());
        if (UserAuthentication::isUserLogged() || UserAuthentication::isGuestUserLogged()) {
            $userId = UserAuthentication::getLoggedUserId();
            $userImgUpdatedOn = User::getAttributesById($userId, 'user_updated_on');
            $uploadedTime = AttachedFile::setTimeParam($userImgUpdatedOn);
            $profileImage = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Account', 'userProfileImage', array($userId, ImageDimension::VIEW_THUMB, true), CONF_WEBROOT_DASHBOARD, null, false, false, false) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            $template->set('userName', ucfirst(CommonHelper::getUserFirstName(UserAuthentication::getLoggedUserAttribute('user_name'))));
            $template->set('userEmail', UserAuthentication::getLoggedUserAttribute('user_email'));
            $template->set('profilePicUrl', $profileImage);
            $template->set('userPhone', UserAuthentication::getLoggedUserAttribute('user_phone'));

            if (CONF_WEBROOT_URL === CONF_WEBROOT_DASHBOARD) {

                $shopDetails = Shop::getAttributesByUserId($userId, array('shop_id'), false);
                $shop_id = 0;
                if (!false == $shopDetails) {
                    $shop_id = $shopDetails['shop_id'];
                }

                $controller = str_replace('Controller', '', FatApp::getController());
                $activeTab = 'B';
                $sellerActiveTabControllers = array('Seller');
                $buyerActiveTabControllers = array('Buyer');

                if (in_array($controller, $sellerActiveTabControllers)) {
                    $activeTab = 'S';
                } elseif (in_array($controller, $buyerActiveTabControllers)) {
                    $activeTab = 'B';
                } elseif (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'])) {
                    $activeTab = $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'];
                }

                $shop = new Shop(0, $userId);
                $isShopActive = $shop->isActive();
                $template->set('shop_id', $shop_id);
                $template->set('activeTab', $activeTab);
                $template->set('isShopActive', $isShopActive);
            }
        }
    }

    public static function headerSearchFormArea($template)
    {
        $siteLangId = CommonHelper::getLangId();
        $headerSrchFrm = static::getSiteSearchForm();
        $headerSrchFrm->setFormTagAttribute('onSubmit', 'submitSiteSearch(this, ' . FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 10) . '); return(false);');

        /* to fill the posted data to form[ */
        $paramsArr = FatApp::getParameters();
        $paramsAssocArr = CommonHelper::arrayToAssocArray($paramsArr);
        $headerSrchFrm->fill($paramsAssocArr);
        /* ] */

        $template->set('headerSrchFrm', $headerSrchFrm);
        $template->set('siteLangId', $siteLangId);
    }

    public static function getSiteSearchForm()
    {
        $siteLangId = CommonHelper::getLangId();
        $frm = new Form('frmSiteSearch');
        $frm->setFormTagAttribute('class', 'main-search-form');
        $frm->setFormTagAttribute('autocomplete', 'off');
        /* $frm->addSelectBox('', 'category', $categoriesArr, '', array(), Labels::getLabel('LBL_All', CommonHelper::getLangId()) ); */
        $frm->addTextBox('', 'keyword');
        $frm->addHiddenField('', 'category');
        /*  $frm->addSubmitButton('', 'btnSiteSrchSubmit', Labels::getLabel('LBL_Search', CommonHelper::getLangId())); */
        return $frm;
    }

    public static function headerLanguageArea($template)
    {
        $template->set('siteLangId', CommonHelper::getLangId());
        $template->set('languages', Language::getAllNames(false));
        $template->set('currencies', Currency::getCurrencyAssoc(CommonHelper::getLangId()));
    }

    public static function footerNewsLetterForm($template)
    {
        $siteLangId = CommonHelper::getLangId();
        $frm = static::getNewsLetterForm($siteLangId);
        $template->set('frm', $frm);
        $template->set('siteLangId', $siteLangId);
    }

    public static function footerTopBrands($template)
    {
        $siteLangId = CommonHelper::getLangId();

        $brandSrch = Brand::getSearchObject($siteLangId);
        $brandSrch->joinTable(Product::DB_TBL, 'INNER JOIN', 'brand_id = p.product_brand_id', 'p');
        $brandSrch->joinTable(SellerProduct::DB_TBL, 'INNER JOIN', 'sp.selprod_product_id = p.product_id', 'sp');
        $brandSrch->doNotCalculateRecords();
        $brandSrch->addMultipleFields(array('brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name', 'SUM(IFNULL(selprod_sold_count, 0)) as totSoldQty'));
        $brandSrch->addCondition('brand_status', '=', 'mysql_func_' . Brand::BRAND_REQUEST_APPROVED, 'AND', true);
        $brandSrch->addCondition('brand_active', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
        $brandSrch->addGroupBy('brand_id');
        $brandSrch->addHaving('totSoldQty', '>', 'mysql_func_0', 'AND', true);
        $brandSrch->addOrder('totSoldQty', 'DESC');
        $brandSrch->addOrder('brand_name');
        $brandSrch->setPageSize(25);

        $brandRs = $brandSrch->getResultSet();
        $topBrands = FatApp::getDb()->fetchAll($brandRs);
        $template->set('topBrands', $topBrands);
        $template->set('siteLangId', $siteLangId);
    }

    public static function footerTopCategories($template)
    {
        $siteLangId = CommonHelper::getLangId();

        $catSrch = new ProductCategorySearch($siteLangId, true, true, false, false);
        $catSrch->joinTable(Product::DB_TBL_PRODUCT_TO_CATEGORY, 'LEFT OUTER JOIN', 'c.prodcat_id = ptc.ptc_prodcat_id', 'ptc');
        $catSrch->joinTable(SellerProduct::DB_TBL, 'LEFT OUTER JOIN', 'sp.selprod_product_id = ptc.ptc_product_id', 'sp');
        $catSrch->doNotCalculateRecords();
        $catSrch->addMultipleFields(array('c.prodcat_id', 'IFNULL(c_l.prodcat_name, c.prodcat_identifier) as prodcat_name', 'SUM(IFNULL(selprod_sold_count, 0)) as totSoldQty'));
        $catSrch->addCondition('prodcat_active', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
        $catSrch->addCondition('prodcat_deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        $catSrch->addGroupBy('prodcat_id');
        $catSrch->addHaving('totSoldQty', '>', 'mysql_func_0', 'AND', true);
        $catSrch->addOrder('totSoldQty', 'DESC');
        $catSrch->addOrder('prodcat_name');
        $catSrch->setPageSize(25);

        $catRs = $catSrch->getResultSet();
        $topCategories = FatApp::getDb()->fetchAll($catRs);
        $template->set('topCategories', $topCategories);
        $template->set('siteLangId', $siteLangId);
    }

    public static function footerTrustBanners($template)
    {
        $siteLangId = CommonHelper::getLangId();

        $cacheData = CacheHelper::get('FOOTER_TRUST_BANNERS' . $siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($cacheData) {
            $template->set('trustBannerData', json_decode($cacheData, true));
            return;
        }
        $obj = new Extrapage();
        $trustBannerData = $obj->getContentByPageType(Extrapage::FOOTER_TRUST_BANNERS, $siteLangId);
        CacheHelper::create('FOOTER_TRUST_BANNERS' . $siteLangId, json_encode($trustBannerData), CacheHelper::TYPE_BLOCK_CONTENT);
        $template->set('trustBannerData', $trustBannerData);
    }

    public static function footerMetaContent($template)
    {
        $siteLangId = CommonHelper::getLangId();

        $cacheData = CacheHelper::get('FOOTER_META_CONTENT' . $siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($cacheData) {
            $template->set('footerData', json_decode($cacheData, true));
            return;
        }
        $obj = new Extrapage();
        $footerData = $obj->getContentByPageType(Extrapage::FOOTER_META_CONTENT, $siteLangId);
        CacheHelper::create('FOOTER_META_CONTENT' . $siteLangId, json_encode($footerData), CacheHelper::TYPE_BLOCK_CONTENT);
        $template->set('footerData', $footerData);
    }

    public static function getNewsLetterForm($langId)
    {
        $frm = new Form('frmNewsLetter');
        $frm->setRequiredStarWith('');
        $fld1 = $frm->addEmailField('', 'email');
        //$fld2 = $frm->addSubmitButton('', 'btnSubmit', Labels::getLabel('LBL_Subscribe', $langId));
        //$fld1->attachField($fld2);
        $frm->setJsErrorDisplay('afterfield');
        return $frm;
    }

    /* public static function brandFilters($template)
    {
        $brandSrch = clone $prodSrchObj;
        $brandSrch->addGroupBy('brand_id');
        $brandSrch->addOrder('brand_name');
        $brandSrch->addMultipleFields(array('brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name'));
        /* if needs to show product counts under brands[ */
    //$brandSrch->addFld('count(selprod_id) as totalProducts');
    /* ] *//*
        //echo $brandSrch->getQuery(); die();
        $brandRs = $brandSrch->getResultSet();
        $brandsArr = FatApp::getDb()->fetchAll($brandRs);
        $template->set('brandsArr', $brandsArr);
    } */

    public static function userMessages($template)
    {
        $userId = UserAuthentication::getLoggedUserId();
        $srch = new MessageSearch();
        $srch->joinThreadMessage();
        $srch->joinMessagePostedFromUser();
        $srch->joinMessagePostedToUser();
        $srch->addMultipleFields(array('tth.*', 'ttm.message_id', 'ttm.message_text', 'ttm.message_date', 'ttm.message_is_unread'));
        $srch->addCondition('ttm.message_deleted', '=', 'mysql_func_0', 'AND', true);
        //$cnd = $srch->addCondition('ttm.message_from','=',$userId);
        $srch->addCondition('ttm.message_to', '=', $userId);
        $srch->addOrder('message_id', 'DESC');
        $srch->setPageSize(3);
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $messages = FatApp::getDb()->fetchAll($rs);
        $template->set('messages', $messages);
        $template->set('siteLangId', CommonHelper::getLangId());
    }

    public static function footerSocialMedia($template)
    {
        $siteLangId = CommonHelper::getLangId();
        $footerSocialMedia = CacheHelper::get('footerSocialMedia' . $siteLangId, CONF_HOME_PAGE_CACHE_TIME, '.txt');
        if ($footerSocialMedia) {
            $rows = unserialize($footerSocialMedia);
        } else {
            $srch = SocialPlatform::getSearchObject($siteLangId);
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $srch->addCondition('splatform_user_id', '=', 'mysql_func_0', 'AND', true);
            $srch->addMultipleFields(['splatform_id', 'splatform_title', 'splatform_identifier', 'splatform_url', 'splatform_icon_class']);
            $rs = $srch->getResultSet();
            $rows = FatApp::getDb()->fetchAll($rs);
            CacheHelper::create('footerSocialMedia' . $siteLangId, serialize($rows), CacheHelper::TYPE_NAVIGATION);
        }
        $template->set('rows', $rows);
        $template->set('siteLangId', $siteLangId);
    }

    public static function homePageBelowSlider($template)
    {
        $siteLangId = CommonHelper::getLangId();
    }

    public static function productDetailPageBanner($template)
    {
        $siteLangId = CommonHelper::getLangId();
    }

    public static function blogSidePanelArea($template)
    {
        $siteLangId = CommonHelper::getLangId();
        $blogSrchFrm = static::getBlogSearchForm();
        $blogSrchFrm->setFormTagAttribute('action', UrlHelper::generateUrl('Blog'));

        /* to fill the posted data into form[ */
        $postedData = FatApp::getPostedData();
        $blogSrchFrm->fill($postedData);
        /* ] */

        /* Right Side Categories Data[ */
        $categoriesArr = BlogPostCategory::getBlogPostCatParentChildWiseArr($siteLangId);
        $template->set('categoriesArr', $categoriesArr);
        /* ] */

        $template->set('blogSrchFrm', $blogSrchFrm);
        $template->set('siteLangId', $siteLangId);
    }

    public static function blogTopFeaturedCategories($template)
    {
        $siteLangId = CommonHelper::getLangId();

        $bpCatObj = new BlogPostCategory();
        $arrCategories = $bpCatObj->getFeaturedCategories($siteLangId);
        $categories = $bpCatObj->makeAssociativeArray($arrCategories);
        $template->set('featuredBlogCategories', $categories);
        $template->set('siteLangId', $siteLangId);
    }

    public static function getBlogSearchForm()
    {
        $frm = new Form('frmBlogSearch');
        $frm->setFormTagAttribute('autocomplete', 'off');
        $frm->addTextBox('', 'keyword', '');
        $frm->addHiddenField('', 'page', 1);
        $frm->addSubmitButton('', 'btn_submit', '');
        return $frm;
    }

    public static function getPollForm($pollId, $langId)
    {
        $frm = new Form('frmPoll');
        $frm->addHiddenField('', 'pollfeedback_polling_id', $pollId);
        $frm->addRadioButtons('', 'pollfeedback_response_type', Polling::getPollingResponseTypeArr($langId), '1', array('class' => 'listing--vertical listing--vertical-chcek'), array());
        $submitBtn = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_VOTE', $langId), array('class' => 'btn btn-brand poll--link-js'));
        /* $viewResultsFld = $frm->addHTML('View Results', 'btn_view_results','<a href="javascript:void(0)" class="link--underline view--link-js" >'.Labels::getLabel('Lbl_View_Results',$langId).'</a>');
        $submitBtn->attachField($viewResultsFld); */
        return $frm;
    }

    public static function pollForm($template)
    {
        $action = FatApp::getAction();
        $controller = FatApp::getController();
        $params = FatApp::getParameters();

        if ($controller == 'ProductsController' && $action == 'view' && !empty($params)) {
            $productId = FatUtility::int($params[0]);
            $selProd = SellerProduct::getAttributesById($productId, array('selprod_product_id'), false);
            $pollQuest = Polling::getProductPoll($selProd['selprod_product_id'], CommonHelper::getLangId());
        } elseif ($controller == 'CategoryController' && $action == 'view' && !empty($params)) {
            $categoryId = FatUtility::int($params[0]);
            $pollQuest = Polling::getCategoryPoll($categoryId, CommonHelper::getLangId());
        }

        if (empty($pollQuest)) {
            $pollQuest = Polling::getGeneraicPoll(CommonHelper::getLangId());
        }

        $template->set('pollQuest', $pollQuest);
        $pollForm = static::getPollForm($pollQuest['polling_id'], CommonHelper::getLangId());
        $template->set('pollForm', $pollForm);
        $template->set('siteLangId', CommonHelper::getLangId());
    }
}
