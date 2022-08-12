<?php
class ReviewsController extends MyAppController
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function product($selprod_id = 0, $reviewId = 0)
    {
        $selprod_id = FatUtility::int($selprod_id);
        $loggedUserId = UserAuthentication::getLoggedUserId(true);
        $prodSrch = new ProductSearch($this->siteLangId);
        $prodSrch->setDefinedCriteria();
        // $prodSrch->joinSellerSubscription();
        // $prodSrch->addSubscriptionValidCondition();
        $prodSrch->joinProductToCategory();
        $prodSrch->doNotCalculateRecords();
        $prodSrch->setPageSize(1);
        $prodSrch->addCondition('selprod_id', '=', $selprod_id);
        $productRs = $prodSrch->getResultSet();
        $product = FatApp::getDb()->fetch($productRs);
        if (!$product) {
            FatUtility::exitWithErrorCode(404);
        }

        $selProdReviewObj = new SelProdReviewSearch();
        $selProdReviewObj->joinProducts($this->siteLangId);
        $selProdReviewObj->joinSellerProducts($this->siteLangId);
        $selProdReviewObj->joinSelProdRating();
        $selProdReviewObj->addCondition('ratingtype_type', 'IN', [RatingType::TYPE_PRODUCT, RatingType::TYPE_OTHER]);
        $selProdReviewObj->doNotCalculateRecords();
        $selProdReviewObj->setPageSize(1);
        $selProdReviewObj->addGroupBy('spr.spreview_product_id');
        $selProdReviewObj->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
        $selProdReviewObj->addCondition('spreview_product_id', '=', $product['product_id']);
        $selProdReviewObj->addMultipleFields(array('spr.spreview_selprod_id', "ROUND(AVG(sprating_rating),2) as prod_rating"));
        $selProdReviewObj->addMultipleFields(array('count(distinct(spreview_id)) totReviews', 'sum(if(sprating_rating=1,1,0)) rated_1', 'sum(if(sprating_rating=2,1,0)) rated_2', 'sum(if(sprating_rating=3,1,0)) rated_3', 'sum(if(sprating_rating=4,1,0)) rated_4', 'sum(if(sprating_rating=5,1,0)) rated_5', 'count(distinct(ratingtype_id)) as totalType'));
        $reviews = FatApp::getDb()->fetch($selProdReviewObj->getResultSet());
        $this->set('reviews', $reviews);

        $canSubmitFeedback = true;
        if ($loggedUserId) {
            $orderProduct = SelProdReview::getProductOrderId($product['product_id'], $loggedUserId);
            $op_order_id = (!empty($orderProduct) && array_key_exists('op_order_id', $orderProduct)) ? $orderProduct['op_order_id'] : 0;
            if (empty($orderProduct) || (isset($orderProduct['op_order_id']) && !Orders::canSubmitFeedback($loggedUserId, $op_order_id, $selprod_id))) {
                $canSubmitFeedback = false;
            }
        }
        $this->set('canSubmitFeedback', $canSubmitFeedback);
        $frmReviewSearch = $this->getProductReviewSearchForm(FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 10));
        $frmReviewSearch->fill(array('selprod_id' => $selprod_id, 'review_id' => $reviewId));
        $this->set('frmReviewSearch', $frmReviewSearch);

        $ratingAspects = SelProdRating::getProdRatingAspects($product['product_id'], $this->siteLangId);
        $this->set('ratingAspects', $ratingAspects);

        $this->includeFeatherLight();
        $this->set('product', $product);
        $this->_template->render(true, true, 'reviews/product.php');
    }

    public function searchForProduct()
    {
        $selprod_id = FatApp::getPostedData('selprod_id');
        $productView = FatApp::getPostedData('productView', FatUtility::VAR_INT, 0);
        $productId = SellerProduct::getAttributesById($selprod_id, 'selprod_product_id', false);
        $reviewId = FatApp::getPostedData('review_id', FatUtility::VAR_INT, 0);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $orderBy = FatApp::getPostedData('orderBy', FatUtility::VAR_STRING, 'most_recent');
        $page = ($page) ? $page : 1;
        $pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_INT, FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 10));

        $srch = new SelProdReviewSearch();
        $srch->joinProducts($this->siteLangId);
        $srch->joinSellerProducts($this->siteLangId);
        $srch->joinUser();
        $srch->joinSelProdReviewHelpful();
        $srch->addCondition('spr.spreview_product_id', '=', $productId);
        $srch->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
        $srch->addMultipleFields(array('spreview_id', 'spreview_selprod_id', 'spreview_title', 'spreview_description', 'spreview_posted_on', 'spreview_postedby_user_id', 'user_name', 'group_concat(case when sprh_helpful = 1 then concat(sprh_user_id,"~",1) else concat(sprh_user_id,"~",0) end ) usersMarked', 'sum(if(sprh_helpful = 1 , 1 ,0)) as helpful', 'sum(if(sprh_helpful = 0 , 1 ,0)) as notHelpful', 'count(sprh_spreview_id) as countUsersMarked', 'user_updated_on'));
        $srch->addGroupBy('spr.spreview_id');
        if (0 < $reviewId) {
            $srch->addCondition('spr.spreview_id', '=', $reviewId);
        }
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        switch ($orderBy) {
            case 'most_helpful':
                $srch->addOrder('helpful', 'desc');
                break;
            default:
                $srch->addOrder('spr.spreview_posted_on', 'desc');
                break;
        }
        $records = (array) FatApp::getDb()->fetchAll($srch->getResultSet(), 'spreview_id');

        $recordRatings = [];
        if (0 < count($records)) {
            $ratings = SelProdRating::getSearchObj();
            $ratings->joinTable(
                RatingType::DB_TBL,
                'INNER JOIN',
                'rt.ratingtype_id = sprating_ratingtype_id AND rt.ratingtype_active = ' . applicationConstants::ACTIVE,
                'rt'
            );
            $ratings->joinTable(
                RatingType::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'rt_l.ratingtypelang_ratingtype_id = rt.ratingtype_id AND rt_l.ratingtypelang_lang_id = ' . $this->siteLangId,
                'rt_l'
            );

            $ratings->addMultipleFields(['sprating_spreview_id', 'ratingtype_id', 'COALESCE(ratingtype_name, ratingtype_identifier) as ratingtype_name', 'sprating_rating']);

            $ratings->addCondition('sprating_spreview_id', 'IN', array_keys($records));
            $ratings->addCondition('ratingtype_type', 'IN', [RatingType::TYPE_PRODUCT, RatingType::TYPE_OTHER]);
            $ratings->doNotLimitRecords();
            $ratings->doNotCalculateRecords();
            $recordRatings = (array) FatApp::getDb()->fetchAll($ratings->getResultSet());
        }

        $prodSrch = new ProductSearch($this->siteLangId);
        $prodSrch->setDefinedCriteria();
        $prodSrch->joinSellerSubscription();
        $prodSrch->addSubscriptionValidCondition();
        $prodSrch->joinProductToCategory();
        $prodSrch->doNotCalculateRecords();
        $prodSrch->setPageSize(1);
        $prodSrch->addCondition('selprod_id', '=', $selprod_id);
        $productRs = $prodSrch->getResultSet();
        $product = FatApp::getDb()->fetch($productRs);

        $this->set('product', $product);
        $this->set('productView', $productView);
        $this->set('recordRatings', $recordRatings);
        $this->set('reviewsList', $records);
        $this->set('page', $page);
        $this->set('pageCount', $srch->pages());
        $this->set('postedData', FatApp::getPostedData());
        $this->set('selprod_id', $selprod_id);
        $json['startRecord'] = !empty($records) ? ($page - 1) * $pageSize + 1 : 0;

        $json['recordsToDisplay'] = count($records);
        $totalRecords = $srch->recordCount();
        $json['totalRecords'] = $totalRecords;

        if (true === MOBILE_APP_API_CALL) {
            $this->set('totalRecords', $totalRecords);
            $this->_template->render();
        }
        $this->set('reviewId', $reviewId);

        $json['html'] = $this->_template->render(false, false, 'reviews/search-for-product.php', true, false);
        $json['loadMoreBtnHtml'] = $this->_template->render(false, false, 'reviews/load-more-product-reviews-btn.php', true, false);
        FatUtility::dieJsonSuccess($json);
    }

    public function shop($shop_id = 0, $reviewId = 0)
    {
        $shop_id = FatUtility::int($shop_id);

        if (1 > $shop_id) {
            FatApp::redirectUser(UrlHelper::generateUrl('Seller', 'Shop'));
        }

        $srch = new ShopSearch($this->siteLangId);
        $srch->setDefinedCriteria($this->siteLangId);
        $srch->joinSellerSubscription();
        $srch->doNotCalculateRecords();

        $loggedUserId = 0;
        if (UserAuthentication::isUserLogged()) {
            $loggedUserId = UserAuthentication::getLoggedUserId();
            $userParent = User::getAttributesById($loggedUserId, 'user_parent');
            $userParentId = (0 < $userParent) ? $userParent : $loggedUserId;
            $this->set('userParentId', $userParentId);
        }

        /* sub query to find out that logged user have marked current shop as favorite or not[ */
        $favSrchObj = new UserFavoriteShopSearch();
        $favSrchObj->doNotCalculateRecords();
        $favSrchObj->setPageSize(1);
        $favSrchObj->addMultipleFields(array('ufs_shop_id', 'ufs_id'));
        $favSrchObj->addCondition('ufs_user_id', '=', $loggedUserId);
        $favSrchObj->addCondition('ufs_shop_id', '=', $shop_id);
        $srch->joinTable('(' . $favSrchObj->getQuery() . ')', 'LEFT OUTER JOIN', 'ufs_shop_id = shop_id', 'ufs');
        /* ] */

        $srch->addMultipleFields(
            array(
                'shop_id', 'shop_user_id', 'shop_ltemplate_id', 'shop_created_on', 'shop_name', 'shop_description',
                'shop_country_l.country_name as shop_country_name', 'shop_state_l.state_name as shop_state_name', 'shop_city', 'user_regdate', 'IFNULL(ufs.ufs_id, 0) as is_favorite'
            )
        );
        $srch->addCondition('shop_id', '=', $shop_id);
        $shopRs = $srch->getResultSet();
        $shop = FatApp::getDb()->fetch($shopRs);
        if (!$shop) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Home'));
        }

        $selProdReviewObj = SelProdRating::getAvgShopReviewsRatingObj($shop['shop_user_id'], $this->siteLangId);
        $selProdReviewObj->joinProducts($this->siteLangId);
        $selProdReviewObj->joinSellerProducts($this->siteLangId);
        $selProdReviewObj->addGroupBy('spr.spreview_seller_user_id');
        $selProdReviewObj->addMultipleFields(array('spr.spreview_seller_user_id', 'count(distinct(spreview_id)) as totReviews', "ROUND(AVG(sprating_rating),2) as avg_seller_rating", 'sum(if(round(sprating_rating)=1,1,0)) rated_1', 'sum(if(round(sprating_rating)=2,1,0)) rated_2', 'sum(if(round(sprating_rating)=3,1,0)) rated_3', 'sum(if(round(sprating_rating)=4,1,0)) rated_4', 'sum(if(round(sprating_rating)=5,1,0)) rated_5', 'count(distinct(ratingtype_id)) as totalType'));
        $selProdReviewObj->doNotCalculateRecords();
        $selProdReviewObj->setPageSize(1);

        $reviews = FatApp::getDb()->fetch($selProdReviewObj->getResultSet());
        $this->set('reviews', $reviews);

        $frmReviewSearch = $this->getProductReviewSearchForm(FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 10));
        $frmReviewSearch->fill(array('shop_id' => $shop_id, 'review_id' => $reviewId));
        $this->set('frmReviewSearch', $frmReviewSearch);

        $ratingobj = SelProdRating::getAvgShopReviewsRatingObj($shop['shop_user_id'], $this->siteLangId);
        $ratingobj->addGroupBy('sprating_ratingtype_id');
        $ratingobj->addMultipleFields([
            'sprating_ratingtype_id',
            'COALESCE(ratingtype_name, ratingtype_identifier) as ratingtype_name',
            'IFNULL(ROUND(AVG(sprating_rating),2),0) as prod_rating'
        ]);
        $ratingobj->doNotCalculateRecords();
        $ratingobj->doNotLimitRecords();
        $ratingAspects = FatApp::getDb()->fetchAll($ratingobj->getResultSet());

        $this->set('ratingAspects', $ratingAspects);

        $srchSplat = SocialPlatform::getSearchObject($this->siteLangId);
        $srchSplat->doNotCalculateRecords();
        $srchSplat->doNotLimitRecords();
        $srchSplat->addCondition('splatform_user_id', '=', $shop['shop_user_id']);
        $socialPlatforms = FatApp::getDb()->fetchAll($srchSplat->getResultSet());
        $this->set('socialPlatforms', $socialPlatforms);

        $shop_rating = 0;
        if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) {
            $shop_rating = SelProdRating::getSellerRating($shop['shop_user_id']);
        }
        $this->set('shopRating', $shop_rating);
        $this->set('shopTotalReviews', $reviews['totReviews'] ?? 0);
        $this->set('collectionData', ShopCollection::getShopCollectionsDetail($shop_id, $this->siteLangId));
        $this->set('template_id', SHOP::TEMPLATE_ONE);
        $this->set('shop', $shop);
        if (UserAuthentication::isUserLogged()) {
            $userParent = User::getAttributesById(UserAuthentication::getLoggedUserId(), 'user_parent');
            $userParentId = (0 < $userParent) ? $userParent : UserAuthentication::getLoggedUserId();
            $this->set('userParentId', $userParentId);
        }

        $this->includeFeatherLight();
        if (1 > $reviewId) {
            $this->_template->render();
        }
    }

    public function searchForShop()
    {
        $shop_id = FatApp::getPostedData('shop_id', FatUtility::VAR_INT, 0);
        $sellerId = Shop::getAttributesById($shop_id, 'shop_user_id', false);
        $reviewId = FatApp::getPostedData('review_id', FatUtility::VAR_INT, 0);

        if ($shop_id <= 0 || false === $sellerId) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $orderBy = FatApp::getPostedData('orderBy', FatUtility::VAR_STRING, 'most_recent');
        $page = ($page) ? $page : 1;
        $pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_INT, FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 10));

        $srch = SelProdRating::getAvgShopReviewsRatingObj($sellerId, $this->siteLangId);
        $srch->joinProducts($this->siteLangId);
        $srch->joinSellerProducts($this->siteLangId);
        $srch->joinUser();
        $srch->joinSelProdReviewHelpful();
        $srch->addMultipleFields(array('selprod_id', 'IFNULL(product_name, product_identifier) as product_name', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title', 'spreview_id', 'spreview_seller_user_id', "ROUND(AVG(sprating_rating),2) as shop_rating", 'spreview_title', 'spreview_description', 'spreview_posted_on', 'spreview_postedby_user_id', 'user_name', 'group_concat(case when sprh_helpful = 1 then concat(sprh_user_id,"~",1) else concat(sprh_user_id,"~",0) end ) usersMarked', 'sum(if(sprh_helpful && ratingtype_type = ' . RatingType::TYPE_SHOP . ' , 1 ,0)) as helpful', 'sum(if(sprh_helpful = 0 && ratingtype_type = ' . RatingType::TYPE_SHOP . ' , 1 ,0)) as notHelpful', 'count(sprh_spreview_id) as countUsersMarked', 'user_updated_on'));
        $srch->addGroupBy('spr.spreview_id');
        if (0 < $reviewId) {
            $srch->addCondition('spr.spreview_id', '=', $reviewId);
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        switch ($orderBy) {
            case 'most_helpful':
                $srch->addOrder('helpful', 'desc');
                break;
            default:
                $srch->addOrder('spr.spreview_posted_on', 'desc');
                break;
        }
        $records = (array) FatApp::getDb()->fetchAll($srch->getResultSet(), 'spreview_id');
        $recordRatings = (array) SelProdRating::getReviewsAndRatings($sellerId, $this->siteLangId, true, [RatingType::TYPE_SHOP, RatingType::TYPE_DELIVERY]);
        $this->set('recordRatings', $recordRatings);
        $this->set('reviewsList', $records);
        $this->set('page', $page);
        $this->set('pageCount', $srch->pages());
        $this->set('postedData', FatApp::getPostedData());
        $this->set('reviewId', $reviewId);

        $srch = new ShopSearch($this->siteLangId);
        $srch->setDefinedCriteria($this->siteLangId);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(
            array(
                'shop_id', 'shop_created_on', 'shop_name',
                'shop_country_l.country_name as shop_country_name', 'shop_state_l.state_name as shop_state_name', 'shop_city'
            )
        );
        $srch->addCondition('shop_id', '=', $shop_id);
        $shop = FatApp::getDb()->fetch($srch->getResultSet());
        if (!$shop) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Home'));
        }

        $this->set('shop', $shop);
        $startRecord = !empty($records) ? ($page - 1) * $pageSize + 1 : 0;

        $recordCount = $srch->recordCount();
        if (true === MOBILE_APP_API_CALL) {
            $this->set('startRecord', $startRecord);
            $this->set('totalRecords', $recordCount);
            $this->_template->render();
        }

        $json['startRecord'] = $startRecord;
        $json['recordsToDisplay'] = count($records);
        $json['totalRecords'] = $recordCount;

        $json['html'] = $this->_template->render(false, false, 'reviews/search-for-shop.php', true, false);
        $json['loadMoreBtnHtml'] = $this->_template->render(false, false, 'reviews/load-more-shop-reviews-btn.php', true, false);
        FatUtility::dieJsonSuccess($json);
    }

    public function shopPermalink($sellerId, $reviewId)
    {
        $sellerId = FatUtility::int($sellerId);
        $reviewId = FatUtility::int($reviewId);

        if ($sellerId <= 0) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            CommonHelper::redirectUserReferer();
        }

        $db = FatApp::getDb();

        $srch = new ShopSearch($this->siteLangId);
        $srch->joinSellerSubscription();
        $srch->setDefinedCriteria($this->siteLangId);
        $srch->doNotCalculateRecords();
        $srch->addFld('shop_id');
        $srch->addCondition('shop_user_id', '=', $sellerId);
        $srch->setPageSize(1);
        $shopRs = $srch->getResultSet();
        $shop = $db->fetch($shopRs);

        if (!$shop) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Home'));
        }

        $shopId = $shop['shop_id'];
        $this->_template->addJs(array('reviews/page-js/shop.js'));
        $this->shop($shopId, $reviewId);
        $this->_template->render();
    }

    public function markHelpful()
    {
        $reviewId = FatApp::getPostedData('reviewId', FatUtility::VAR_INT, 0);
        $isHelpful = FatApp::getPostedData('isHelpful', FatUtility::VAR_INT, 0);
        if ($reviewId <= 0) {
            $message = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }
        $userId = UserAuthentication::getLoggedUserId();
        $tblRecObj = new SelProdReviewHelpful();
        $tblRecObj->assignValues(array('sprh_spreview_id' => $reviewId, 'sprh_user_id' => $userId, 'sprh_helpful' => $isHelpful));
        if (!$tblRecObj->addNew(array(), array('sprh_helpful' => $isHelpful))) {
            if (true === MOBILE_APP_API_CALL) {
                LibHelper::dieJsonError($tblRecObj->getError());
            }
            Message::addErrorMessage($tblRecObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
        $tblRecObj = new SelProdReviewHelpful($reviewId);
        $success['msg'] = Labels::getLabel('MSG_SUCCESSFULLY_UPDATED', $this->siteLangId);
        $success['data'] = $tblRecObj->getData();

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        FatUtility::dieJsonSuccess($success);
    }

    public function write($product_id)
    {
        $product_id = FatUtility::int($product_id);
        if (!$product_id) {
            FatUtility::exitWithErrorCode(404);
        }
        $loggedUserId = 0;
        if (UserAuthentication::isUserLogged()) {
            $loggedUserId = UserAuthentication::getLoggedUserId();
        }
        $orderProduct = SelProdReview::getProductOrderId($product_id, $loggedUserId);
        if (empty($orderProduct)) {
            Message::addErrorMessage(Labels::getLabel('ERR_REVIEW_CAN_BE_POSTED_ON_BOUGHT_PRODUCT', $this->siteLangId));
            CommonHelper::redirectUserReferer();
        }
        $opId = $orderProduct['op_id'];
        FatApp::redirectUser(UrlHelper::generateUrl('Buyer', 'orderFeedback', array($opId), CONF_WEBROOT_DASHBOARD));
    }

    public function reviewAbuse($reviewId)
    {
        $this->set('frm', $this->getReviewAbuseForm($reviewId));
        $this->_template->render(false, false);
    }

    public function setupReviewAbuse()
    {
        $post = FatApp::getPostedData();
        $reviewId = FatUtility::int($post['spra_spreview_id']);
        if ($reviewId <= 0) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId));
        }
        $frm = $this->getReviewAbuseForm($reviewId);
        $post = $frm->getFormDataFromArray($post);

        $data = array(
            'spra_comments' => $post['spra_comments'],
            'spra_spreview_id' => $post['spra_spreview_id'],
            'spra_user_id' => UserAuthentication::getLoggedUserId(),
        );
        $obj = new SelProdReview();
        if (!$obj->addSelProdReviewAbuse($data, $data)) {
            FatUtility::dieJsonError($obj->getError());
        }
        $this->set('reviewId', $reviewId);
        $this->set('msg', Labels::getLabel('MSG_SETUP_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getProductReviewSearchForm($pageSize = 10)
    {
        $frm = new Form('frmReviewSearch');
        $frm->addHiddenField('', 'selprod_id');
        $frm->addHiddenField('', 'review_id');
        $frm->addHiddenField('', 'shop_id');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'pageSize', $pageSize);
        $frm->addHiddenField('', 'orderBy', 'most_recent');
        return $frm;
    }

    private function getReviewAbuseForm($reviewId)
    {
        $frm = new Form('frmReviewAbuse');
        $frm->addHiddenField('', 'spra_spreview_id', $reviewId);
        $frm->addTextarea(Labels::getLabel('FRM_COMMENTS', $this->siteLangId), 'spra_comments');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_REPORT_ABUSE', $this->siteLangId));
        return $frm;
    }
}
