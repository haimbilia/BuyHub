<?php

class BannerController extends MyAppController
{
    public function index()
    {
    }

    public function track(int $bannerId)
    {
        $srch = new BannerSearch($this->siteLangId, true);
        $srch->joinLocations($this->siteLangId, true);
        $srch->joinPromotions();
        $srch->addSkipExpiredPromotionAndBannerCondition();
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition('banner_id', '=', $bannerId);
        $srch->addMultipleFields(array('banner_id', 'banner_url', 'banner_type', 'banner_blocation_id', 'banner_record_id', 'blocation_promotion_cost', 'promotion_cpc'));
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if ($row == false) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId), false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('home'));
        }

        $url = str_replace('{SITEURL}', UrlHelper::generateFullUrl(), $row['banner_url']);

        $userId = 0;
        if (UserAuthentication::isUserLogged()) {
            $userId = UserAuthentication::getLoggedUserId();
        }
        if (Promotion::isUserClickCountable($userId, $row['banner_record_id'], $_SERVER['REMOTE_ADDR'], session_id())) {
            switch ($row['banner_type']) {
                case Banner::TYPE_BANNER:
                    break;

                case Banner::TYPE_PPC:
                    $promotionClickData = array(
                        'pclick_promotion_id' => $row['banner_record_id'],
                        'pclick_user_id' => $userId,
                        'pclick_datetime' => date('Y-m-d H:i:s'),
                        'pclick_ip' => $_SERVER['REMOTE_ADDR'],
                        /* 'pclick_cost' => $row['blocation_promotion_cost'], */
                        'pclick_cost' => $row['promotion_cpc'],
                        'pclick_session_id' => session_id(),
                    );
                    FatApp::getDb()->insertFromArray(Promotion::DB_TBL_CLICKS, $promotionClickData, false, [], $promotionClickData);

                    $clickId = FatApp::getDb()->getInsertId();

                    $promotionClickChargesData = array(

                        'picharge_pclick_id' => $clickId,
                        'picharge_datetime' => date('Y-m-d H:i:s'),
                        /* 'picharge_cost'  => $row['blocation_promotion_cost'], */
                        'picharge_cost' => $row['promotion_cpc'],

                    );

                    FatApp::getDb()->insertFromArray(Promotion::DB_TBL_ITEM_CHARGES, $promotionClickChargesData, false);


                    $promotionLogData = array(
                        'plog_promotion_id' => $row['banner_record_id'],
                        'plog_date' => date('Y-m-d'),
                        'plog_clicks' => 1,
                    );

                    $onDuplicatePromotionLogData = array_merge($promotionLogData, array('plog_clicks' => 'mysql_func_plog_clicks+1'));
                    FatApp::getDb()->insertFromArray(Promotion::DB_TBL_LOGS, $promotionLogData, true, array(), $onDuplicatePromotionLogData);
                    break;
            }
        }

        if (MOBILE_APP_API_CALL) {
            FatUtility::dieJsonSuccess(Labels::getLabel('LBL_SUCCESS'));
        }

        if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
            FatApp::redirectUser($url);
        }

        FatApp::redirectUser(UrlHelper::generateUrl(''));
    }

    public function BannerImage($bannerId, $langId = 0, $screen = 1, $sizeType = '')
    {
        $bannerId = FatUtility::int($bannerId);

        $fileRow = AttachedFile::getAttachment(AttachedFile::FILETYPE_BANNER, $bannerId, 0, $langId, true, $screen);
        $image_name = isset($fileRow['afile_physical_path']) ? $fileRow['afile_physical_path'] : '';
        $image_name = AttachedFile::setNamePrefix($image_name, $sizeType);

        $imageDimensions = ImageDimension::getData(ImageDimension::TYPE_BANNER, $sizeType);

        if ($sizeType != ImageDimension::VIEW_MINI_THUMB && $sizeType != ImageDimension::VIEW_THUMB) {
            $blocationId = Banner::getAttributesById($bannerId, 'banner_blocation_id');
            $bannerDimensions = BannerLocation::getDimensions($blocationId, $screen);
            if (array_key_exists('blocation_banner_width', $bannerDimensions)) {
                $imageDimensions['width'] = $bannerDimensions['blocation_banner_width'];
            }
            if (array_key_exists('blocation_banner_height', $bannerDimensions)) {
                $imageDimensions['height'] = $bannerDimensions['blocation_banner_height'];
            }
        }

        if ($sizeType) {
            AttachedFile::displayImage($image_name, $imageDimensions['width'], $imageDimensions['height'], 'banner-default-image.png', '', ImageResize::IMG_RESIZE_EXTRA_ADDSPACE, false, true, false);
        } else {
            AttachedFile::displayOriginalImage($image_name, 'banner-default-image.png');
        }
    }




    /*  public function showOriginalBanner($bannerId, $langId, $screen = 0, $sizeType = '')
    {
        $bannerId = FatUtility::int($bannerId);
        $langId = FatUtility::int($langId);

        $fileRow = AttachedFile::getAttachment(AttachedFile::FILETYPE_BANNER, $bannerId, 0, $langId, true, $screen);
        $image_name = isset($fileRow['afile_physical_path']) ? $fileRow['afile_physical_path'] : '';
        $image_name = AttachedFile::setNamePrefix($image_name, $sizeType);
        AttachedFile::displayOriginalImage($image_name, '', '', true);
    } */

    public function categories()
    {
        $bannerListing = $this->getBanners('Category_Page_Left', $this->siteLangId);
        $this->set('bannerListing', $bannerListing);
        $this->_template->render(false, false);
    }

    public function Products()
    {
        $bannerListing = $this->getBanners('Product_Page_Right', $this->siteLangId);
        $this->set('bannerListing', $bannerListing);
        $this->_template->render(false, false);
    }

    public function allProducts()
    {
        $bannerListing = $this->getBanners('All_Products_Left', $this->siteLangId);
        $this->set('bannerListing', $bannerListing);
        $this->_template->render(false, false);
    }

    public function blogPage()
    {
        $bannerListing = $this->getBanners('Blog_Section_Right', $this->siteLangId);
        $this->set('bannerListing', $bannerListing);
        $this->_template->render(false, false);
    }

    public function Brands()
    {
        $bannerListing = $this->getBanners('Brand_Page_Left', $this->siteLangId);
        $this->set('bannerListing', $bannerListing);
        $this->_template->render(false, false);
    }

    public function searchListing()
    {
        $bannerListing = $this->getBanners('Search_Page_Left', $this->siteLangId);

        $this->set('bannerListing', $bannerListing);
        $this->_template->render(false, false);
    }

    private function getBanners($type, $langId)
    {
        if ($type == '') {
            return;
        }

        $bannerDataCache = CacheHelper::get('bannersCache' . $type . '_' . $langId, CONF_IMG_CACHE_TIME, '.txt');
        if ($bannerDataCache) {
            return unserialize($bannerDataCache);
        }

        $db = FatApp::getDb();
        $bannerSrch = Banner::getBannerLocationSrchObj(true);
        /* $bannerSrch->addCondition('blocation_key', '=', $type); */
        $bannerSrch->doNotCalculateRecords();
        $bannerSrch->setPageSize(1);
        $rs = $bannerSrch->getResultSet();
        $bannerLocation = $db->fetch($rs);

        if (empty($bannerLocation)) {
            return;
        }

        $srch = Banner::getSearchObject($langId, true);
        $srch->doNotCalculateRecords();

        if ($bannerLocation['blocation_banner_count'] > 0) {
            $srch->setPageSize($bannerLocation['blocation_banner_count']);
        }

        $srch->addCondition('banner_blocation_id', '=', $bannerLocation['blocation_id']);
        $rs = $srch->getResultSet();

        $bannerListing = $db->fetchAll($rs, 'banner_id');
        CacheHelper::create('bannersCache' . $type . '_' . $langId, serialize($bannerListing));
        return $bannerListing;
    }

    public function locationFrames($frameId, $sizeType = '')
    {
        $frameId = FatUtility::int($frameId);
        if (1 > $frameId) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }
        $this->set('frameId', $frameId);
        $this->_template->render(false, false);
    }
}
