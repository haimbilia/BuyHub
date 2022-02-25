<?php
class ImageDimension extends FatUtility
{
    public const TYPE_SLIDE = 1;
    public const TYPE_BANNER = 2;
    public const TYPE_PRODUCTS = 3;
    public const TYPE_USER = 4;
    public const TYPE_CUSTOM_PRODUCTS = 5;
    public const TYPE_SHOP_LOGO = 6;
    public const TYPE_SHOP_BANNER = 7;
    public const TYPE_PROMOTION_MEDIA = 8;
    public const TYPE_BRAND_LOGO = 9;
    public const TYPE_BRAND_IMAGE = 10;
    public const TYPE_EMAIL_LOGO = 11;
    public const TYPE_SOCIAL_FEED = 12;
    public const TYPE_WATERMARK = 13;
    public const TYPE_APPLE_TOUCH_ICON = 14;
    public const TYPE_MOBILE_LOGO = 15;
    public const TYPE_INVOICE_LOGO = 16;
    public const TYPE_CATEGORY_COLLECTION_BG = 17;
    public const TYPE_COUPON = 18;
    public const TYPE_META = 19;
    public const TYPE_FIRST_PURCHASE_COUPON = 20;
    public const TYPE_FEVICON = 21;
    public const TYPE_SOCIAL_PLATFORM = 22;
    public const TYPE_DISPLAY_COLLECTION_IMAGE = 23;
    public const TYPE_DISPLAY_COLLECTION_BG_IMAGE = 24;
    public const TYPE_BLOG_POST = 25;
    public const TYPE_BATCH_PRODUCT = 26;
    public const TYPE_TESTIMONIAL = 27;
    public const TYPE_CPAGE_BG = 28;
    public const TYPE_CBLOCK_BG = 29;
    public const TYPE_SHOP_COLLECTION_IMAGE = 30;
    public const TYPE_PLUGIN_IMAGE = 31;
    public const TYPE_REVIEW_IMAGE = 32;
    public const TYPE_BADGE_ICON = 33;
    public const TYPE_BADGE_REQUEST_IMAGE = 34;
    public const TYPE_USER_PROFILE_IMAGE = 35;
    public const TYPE_CATEGORY_IMAGE = 36;
    public const TYPE_CATEGORY_ICON = 37;
    public const TYPE_CATEGORY_THUMB = 38;
    public const TYPE_CATEGORY_SELLER_BANNER = 39;
    public const TYPE_CATEGORY_BANNER = 40;
    public const TYPE_ADMIN_BADGE_REQUEST = 41;


    public const VIEW_DESKTOP = 'DESKTOP';
    public const VIEW_MOBILE = 'MOBILE';
    public const VIEW_TABLET = 'TABLET';
    public const VIEW_THUMB = 'THUMB';
    public const VIEW_WIDE  = 'WIDE';
    public const VIEW_MINI_THUMB = 'MINITHUMB';
    public const VIEW_MINI = 'MINI';
    public const VIEW_EXTRA_SMALL = 'EXTRA-SMALL';
    public const VIEW_SMALL = 'SMALL';
    public const VIEW_MEDIUM = 'MEDIUM';
    public const VIEW_CLAYOUT3 = 'CLAYOUT3';
    public const VIEW_CLAYOUT2 = 'CLAYOUT2';
    public const VIEW_ORIGINAL = 'ORIGINAL';
    public const VIEW_FB_RECOMMEND = 'FB_RECOMMEND';
    public const VIEW_DEFAULT = 'DEFAULT';
    public const VIEW_PREVIEW = 'PREVIEW';
    public const VIEW_LISTING_PAGE = 'LISTING_PAGE';
    public const VIEW_COLLECTION_PAGE = 'COLLECTION_PAGE';
    public const VIEW_NORMAL = 'NORMAL';
    public const VIEW_HOME = 'HOME';
    public const VIEW_LAYOUT1 = 'LAYOUT1';
    public const VIEW_LAYOUT2 = 'LAYOUT2';
    public const VIEW_FEATURED = 'FEATURED';
    public const VIEW_SHOP = 'SHOP';
    public const VIEW_ICON = 'ICON';
    public const VIEW_LARGE = 'LARGE';
    public const VIEW_HOME_PAGE_BANNER_TOP_LAYOUT = "TOPLAYOUT";
    public const VIEW_HOME_PAGE_BANNER_MIDDLE_LAYOUT = "MIDDLELAYOUT";
    public const VIEW_HOME_PAGE_BANNER_BOTTOM_LAYOUT = "BOTTOMLAYOUT";
    public const VIEW_HOME_PAGE_BANNER_PRODUCT_LAYOUT = "PRODUCTLAYOUT";
    public const VIEW_CROPED = "CROPED";



    public static function getData(int $type, $sizeType = ''): array
    {

        $sizeType = strtoupper($sizeType);

        $imageDimensions = [];
        switch ($type) {
            case self::TYPE_SLIDE:
                $imageDimensions = self::getSlideData($sizeType);

                break;
            case self::TYPE_PRODUCTS:
                $imageDimensions = self::getProductImageData($sizeType);
                break;
            case self::TYPE_USER:
                $imageDimensions = self::getUserImageData($sizeType);
                break;
            case self::TYPE_CUSTOM_PRODUCTS:
                $imageDimensions = self::getCustomProductImageData($sizeType);
                break;
            case self::TYPE_SHOP_LOGO:
                $imageDimensions = self::getShopLogoImageData($sizeType);
                break;
            case self::TYPE_SHOP_BANNER:
                $imageDimensions = self::getShopBannerImageData($sizeType);
                break;
            case self::TYPE_PROMOTION_MEDIA:
                $imageDimensions = self::getPromotionMediaImageData($sizeType);
                break;
            case self::TYPE_BRAND_LOGO:
                $imageDimensions = self::getBrandLogoImageData($sizeType);
                break;
            case self::TYPE_BRAND_IMAGE:
                $imageDimensions = self::getBrandImageData($sizeType);
                break;
            case self::TYPE_EMAIL_LOGO:
                $imageDimensions = self::getEmailLogoImageData($sizeType);
                break;
            case self::TYPE_SOCIAL_FEED:
                $imageDimensions = self::getSocialFeedImageData($sizeType);
                break;
            case self::TYPE_WATERMARK:
                $imageDimensions = self::getWaterImageData($sizeType);
                break;
            case self::TYPE_APPLE_TOUCH_ICON:
                $imageDimensions = self::getAppleTouchIconImageData($sizeType);
                break;
            case self::TYPE_MOBILE_LOGO:
                $imageDimensions = self::getMobileLogoImageData($sizeType);
                break;
            case self::TYPE_INVOICE_LOGO:
                $imageDimensions = self::getInvoiceLogoImageData($sizeType);
                break;
            case self::TYPE_CATEGORY_COLLECTION_BG:
                $imageDimensions = self::getCategoryCollectionBGImageData($sizeType);
                break;
            case self::TYPE_COUPON:
                $imageDimensions = self::getCouponImageData($sizeType);
                break;
            case self::TYPE_META:
                $imageDimensions = self::getMetaImageData($sizeType);
                break;
            case self::TYPE_FIRST_PURCHASE_COUPON:
                $imageDimensions = self::getFirstPurchaseCouponImageData($sizeType);
                break;
            case self::TYPE_FEVICON:
                $imageDimensions = self::getFaviconImageData($sizeType);
                break;
            case self::TYPE_SOCIAL_PLATFORM:
                $imageDimensions = self::getSocialPlatformImageData($sizeType);
                break;
            case self::TYPE_DISPLAY_COLLECTION_IMAGE:
                $imageDimensions = self::getDisplayCollectionImageData($sizeType);
                break;
            case self::TYPE_DISPLAY_COLLECTION_BG_IMAGE:
                $imageDimensions = self::getDisplayCollectionBGImageData($sizeType);
                break;
            case self::TYPE_BLOG_POST:
                $imageDimensions = self::getBlogPostImageData($sizeType);
                break;
            case self::TYPE_BATCH_PRODUCT:
                $imageDimensions = self::getBatchProductImageData($sizeType);
                break;
            case self::TYPE_TESTIMONIAL:
                $imageDimensions = self::getTestimonialImageData($sizeType);
                break;
            case self::TYPE_CPAGE_BG:
                $imageDimensions = self::getCPageBackgroundImageData($sizeType);
                break;
            case self::TYPE_CBLOCK_BG:
                $imageDimensions = self::getCBlockBackgroundImageData($sizeType);
                break;
            case self::TYPE_SHOP_COLLECTION_IMAGE:
                $imageDimensions = self::getShopCollectionImageData($sizeType);
                break;
            case self::TYPE_PLUGIN_IMAGE:
                $imageDimensions = self::getPluginImageData($sizeType);
                break;
            case self::TYPE_REVIEW_IMAGE:
                $imageDimensions = self::getReviewImageData($sizeType);
                break;
            case self::TYPE_BADGE_ICON:
                $imageDimensions = self::getBadgeIconImageData($sizeType);
                break;
            case self::TYPE_BADGE_REQUEST_IMAGE:
                $imageDimensions = self::getBadgeRequestImageData($sizeType);
                break;
            case self::TYPE_USER_PROFILE_IMAGE:
                $imageDimensions = self::getUserProfileImageData($sizeType);
                break;
            case self::TYPE_BANNER:
                $imageDimensions = self::getBannerImageData($sizeType);
                break;
            case self::TYPE_CATEGORY_IMAGE:
                $imageDimensions = self::getCategoryImage($sizeType);
                break;
            case self::TYPE_CATEGORY_ICON:
                $imageDimensions = self::getCategoryIcon($sizeType);
                break;
            case self::TYPE_CATEGORY_THUMB:
                $imageDimensions = self::getCategoryThumb($sizeType);
                break;
            case self::TYPE_CATEGORY_SELLER_BANNER:
                $imageDimensions = self::getCategorySellerBanner($sizeType);
                break;
            case self::TYPE_CATEGORY_BANNER:
                $imageDimensions = self::getCategoryBanner($sizeType);
                break;
            case self::TYPE_ADMIN_BADGE_REQUEST:
                $imageDimensions = self::getAdminBadgeRequestImage($sizeType);
                break;
        }


        if (empty($sizeType)) {
            foreach ($imageDimensions as $key => $val) {
                $imageDimensions[$key]['aspectRatio'] = self::getAspectRatio($val['width'], $val['height']);
            }
        } else {

            $imageDimensions[$sizeType]['aspectRatio'] = self::getAspectRatio($imageDimensions['width'], $imageDimensions['height']);
        }



        return $imageDimensions;
    }


    public static function getSlideData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }


        $arr =  [
            self::VIEW_DESKTOP => ['width' => 2000, 'height' => 666],
            self::VIEW_MOBILE => ['width' => 640, 'height' => 360],
            self::VIEW_TABLET => ['width' => 1024, 'height' => 360],
            self::VIEW_THUMB => ['width' => 200, 'height' => 100],
        ];


        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DESKTOP];
            }
            return $arr[$sizeType];
        }


        return $arr;
    }


    public static function getProductImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [

            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_MINI => ['width' => 50, 'height' => 50],
            self::VIEW_EXTRA_SMALL => ['width' => 60, 'height' => 60],
            self::VIEW_SMALL => ['width' => 230, 'height' => 230],
            self::VIEW_MEDIUM => ['width' => 500, 'height' => 500],
            self::VIEW_CLAYOUT2 => ['width' => 398, 'height' => 398],
            self::VIEW_CLAYOUT3 => ['width' => 230, 'height' => 230],
            self::VIEW_ORIGINAL => ['width' => 1500, 'height' => 1500],
            self::VIEW_FB_RECOMMEND => ['width' => 1200, 'height' => 630],
            self::VIEW_DEFAULT => ['width' => 400, 'height' => 400],
        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getUserImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_MINI_THUMB => ['width' => 40, 'height' => 40],
            self::VIEW_THUMB => ['width' => 150, 'height' => 150],
            self::VIEW_MINI => ['width' => 70, 'height' => 70],
            self::VIEW_SMALL => ['width' => 200, 'height' => 200],
            self::VIEW_MEDIUM => ['width' => 500, 'height' => 500],
        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getCustomProductImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_SMALL => ['width' => 150, 'height' => 150],
            self::VIEW_MEDIUM => ['width' => 542, 'height' => 480],
            self::VIEW_DEFAULT => ['width' => 400, 'height' => 400],
        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getShopLogoImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_THUMB => ['width' => 200, 'height' => 100],

        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getShopBannerImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }


        $arr =  [
            self::VIEW_DESKTOP => ['width' => 2000, 'height' => 500],
            self::VIEW_MOBILE => ['width' => 640, 'height' => 360],
            self::VIEW_TABLET => ['width' => 1024, 'height' => 360],
            self::VIEW_THUMB => ['width' => 250, 'height' => 100],
            self::VIEW_WIDE => ['width' => 1320, 'height' => 320],


        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }


    public static function getPromotionMediaImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_PREVIEW => ['width' => 1298, 'height' => 600],
            self::VIEW_DEFAULT => ['width' => 1298, 'height' => 600],



        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getBrandLogoImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [


            self::VIEW_MINI_THUMB => ['width' => 42, 'height' => 52],
            self::VIEW_THUMB => ['width' => 61, 'height' => 61],
            self::VIEW_LISTING_PAGE => ['width' => 530, 'height' => 530],
            self::VIEW_DEFAULT => ['width' => 500, 'height' => 500],



        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getBrandImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [

            self::VIEW_THUMB => ['width' => 250, 'height' => 100],
            self::VIEW_MOBILE => ['width' => 640, 'height' => 360],
            self::VIEW_TABLET => ['width' => 1024, 'height' => 360],
            self::VIEW_DESKTOP => ['width' => 2000, 'height' => 500],
        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getEmailLogoImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }



        $arr =  [

            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_DEFAULT => ['width' => 100, 'height' => 100],
        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getSocialFeedImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }
        $arr =  [

            self::VIEW_THUMB => ['width' => 120, 'height' => 80],
            self::VIEW_DEFAULT => ['width' => 240, 'height' => 160],
        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getWaterImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getAppleTouchIconImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }


        $arr =  [
            self::VIEW_MINI => ['width' => 72, 'height' => 72],
            self::VIEW_SMALL => ['width' => 114, 'height' => 114],
        ];


        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {

                $arr_size = explode('-', $sizeType);
                if (count($arr_size) > 0) {
                    list($w, $h) = $arr_size;
                    $arr[$sizeType] = array('width' => $w, 'height' => $h);
                    return $arr[$sizeType];
                } else {
                    return $arr;
                }
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getMobileLogoImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_DEFAULT => ['width' => 82, 'height' => 268],
        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getInvoiceLogoImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_DEFAULT => ['width' => 37, 'height' => 168],
        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getCategoryCollectionBGImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }


        $arr =  [
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],

        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }


    public static function getCouponImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }


        $arr =  [
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_NORMAL => ['width' => 120, 'height' => 120],
            self::VIEW_DEFAULT => ['width' => 600, 'height' => 400],

        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }


    public static function getMetaImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }


        $arr =  [

            self::VIEW_DEFAULT => ['width' => 600, 'height' => 400],

        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getFirstPurchaseCouponImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }


        $arr =  [
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_NORMAL => ['width' => 120, 'height' => 150],
            self::VIEW_DEFAULT => ['width' => 600, 'height' => 400],

        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }




    public static function getFaviconImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }


        $arr =  [
            self::VIEW_MINI => ['width' => 72, 'height' => 72],
            self::VIEW_SMALL => ['width' => 114, 'height' => 114],
        ];


        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {

                $arr_size = explode('-', $sizeType);
                if (count($arr_size) > 0) {
                    list($w, $h) = $arr_size;
                    $arr[$sizeType] = array('width' => $w, 'height' => $h);
                    return $arr[$sizeType];
                } else {
                    return $arr;
                }
            }
            return $arr[$sizeType];
        }

        return $arr;
    }


    public static function getSocialPlatformImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_THUMB => ['width' => 200, 'height' => 100],
            self::VIEW_DEFAULT => ['width' => 30, 'height' => 30],

        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }


    public static function getDisplayCollectionImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_HOME => ['width' => 76, 'height' => 92],

        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getDisplayCollectionBGImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],

        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getBlogPostImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_SMALL => ['width' => 200, 'height' => 200],
            self::VIEW_LAYOUT1 => ['width' => 1350, 'height' => 759],
            self::VIEW_LAYOUT2 => ['width' => 645, 'height' => 363],
            self::VIEW_FEATURED => ['width' => 510, 'height' => 287],
            self::VIEW_DEFAULT => ['width' => 400, 'height' => 400],

        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getBatchProductImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_SMALL => ['width' => 200, 'height' => 200],
            self::VIEW_DEFAULT => ['width' => 400, 'height' => 400],

        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getTestimonialImageData(string $sizeType = ''): array
    {

        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_THUMB => ['width' => 61, 'height' => 61],
            self::VIEW_MINI_THUMB => ['width' => 42, 'height' => 52],
            self::VIEW_DEFAULT => ['width' => 118, 'height' => 276],

        ];


        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }

            return $arr[$sizeType];
        }


        return $arr;
    }

    public static function getCPageBackgroundImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }


        $arr =  [
            self::VIEW_THUMB => ['width' => 150, 'height' => 45],
            self::VIEW_COLLECTION_PAGE => ['width' => 45, 'height' => 41],
        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }


    public static function getCBlockBackgroundImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],

        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getShopCollectionImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_SHOP => ['width' => 610, 'height' => 343],

        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getPluginImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_ICON => ['width' => 30, 'height' => 30],
            self::VIEW_MINI_THUMB => ['width' => 61, 'height' => 61],
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_SMALL => ['width' => 200, 'height' => 200],
            self::VIEW_MEDIUM => ['width' => 250, 'height' => 250],
            self::VIEW_LARGE => ['width' => 350, 'height' => 350],

        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getReviewImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_ICON => ['width' => 30, 'height' => 30],
            self::VIEW_MINI_THUMB => ['width' => 61, 'height' => 61],
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_SMALL => ['width' => 200, 'height' => 200],
            self::VIEW_MEDIUM => ['width' => 250, 'height' => 250],
            self::VIEW_LARGE => ['width' => 500, 'height' => 500],

        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getBadgeIconImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [

            self::VIEW_THUMB => ['width' => 60, 'height' => 60],
            self::VIEW_MINI => ['width' => 35, 'height' => 35],

        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getUserProfileImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [

            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_CROPED => ['width' => 230, 'height' => 230],

        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }



    public static function getBadgeRequestImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [

            self::VIEW_THUMB => ['width' => 60, 'height' => 60],
            self::VIEW_MINI => ['width' => 35, 'height' => 35],

        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }


    public static function getCategoryImage(string $sizeType = ''): array
    {


        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [

            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_LARGE => ['width' => 400, 'height' => 400],
            self::VIEW_COLLECTION_PAGE => ['width' => 45, 'height' => 41],

        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }


    public static function getCategoryIcon(string $sizeType = ''): array
    {


        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [

            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
            self::VIEW_COLLECTION_PAGE => ['width' => 48, 'height' => 48],

        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getCategoryThumb(string $sizeType = ''): array
    {


        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [

            self::VIEW_THUMB => ['width' => 60, 'height' => 60],
            self::VIEW_ICON => ['width' => 300, 'height' => 300],

        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getCategorySellerBanner(string $sizeType = ''): array
    {


        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [

            self::VIEW_THUMB => ['width' => 250, 'height' => 100],
            self::VIEW_ICON => ['width' => 1320, 'height' => 320],

        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }


    public static function getCategoryBanner(string $sizeType = ''): array
    {


        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [

            self::VIEW_THUMB => ['width' => 250, 'height' => 100],
            self::VIEW_MEDIUM => ['width' => 600, 'height' => 150],
            self::VIEW_MOBILE => ['width' => 640, 'height' => 360],
            self::VIEW_TABLET => ['width' => 1024, 'height' => 360],
            self::VIEW_DESKTOP => ['width' => 2000, 'height' => 500],
        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getAdminBadgeRequestImage(string $sizeType = ''): array
    {


        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_THUMB => ['width' => 50, 'height' => 50],
        ];

        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }


    public static function getBannerImageData(string $sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }


        $arr =  [

            self::VIEW_HOME_PAGE_BANNER_TOP_LAYOUT => ['width' => 1350, 'height' => 405],
            self::VIEW_HOME_PAGE_BANNER_MIDDLE_LAYOUT => ['width' => 600, 'height' => 338],
            self::VIEW_HOME_PAGE_BANNER_BOTTOM_LAYOUT => ['width' => 600, 'height' => 198],
            self::VIEW_HOME_PAGE_BANNER_PRODUCT_LAYOUT => ['width' => 600, 'height' => 198],
            self::VIEW_THUMB => ['width' => 200, 'height' => 50],
            self::VIEW_MINI_THUMB => ['width' => 52, 'height' => 42],

        ];



        if (!empty($sizeType)) {
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getBannerData(string $sizeType = '', $layout): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }


        if ($layout == Collections::TYPE_BANNER_LAYOUT1) {
            $arr =  [
                self::VIEW_DESKTOP => ['width' => 2000, 'height' => 666],
                self::VIEW_MOBILE => ['width' => 640, 'height' => 360],
                self::VIEW_TABLET => ['width' => 1024, 'height' => 360],
                self::VIEW_THUMB => ['width' => 200, 'height' => 66],
            ];
        }

        if ($layout == Collections::TYPE_BANNER_LAYOUT2) {
            $arr =  [
                self::VIEW_DESKTOP => ['width' => 800, 'height' => 600],
                self::VIEW_MOBILE => ['width' => 800, 'height' => 600],
                self::VIEW_TABLET => ['width' => 800, 'height' => 600],
                self::VIEW_THUMB => ['width' => 200, 'height' => 150],
            ];
        }


        if (!empty($sizeType)) {
            $arr[$sizeType]['aspectRatio'] = self::getAspectRatio($arr[$sizeType]['width'], $arr[$sizeType]['height']);
            return $arr[$sizeType];
        }

        $arr['aspectRatio'] = self::getAspectRatio($arr[self::VIEW_DESKTOP]['width'], $arr[self::VIEW_DESKTOP]['height']);
        return $arr;
    }



    public static function getAspectRatio(int $width, int $height)
    {
        $greatestCommonDivisor = static function ($width, $height) use (&$greatestCommonDivisor) {
            return ($width % $height) ? $greatestCommonDivisor($height, $width % $height) : $height;
        };

        $divisor = $greatestCommonDivisor($width, $height);
        return $width / $divisor . ':' . $height / $divisor;
    }
}
