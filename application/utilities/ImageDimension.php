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
    public const TYPE_APPLE_TOUCH_ICON =14; 
    public const TYPE_MOBILE_LOGO = 15;
    public const TYPE_INVOICE_LOGO = 16;
    public const TYPE_CATEGORY_COLLECTION_BG = 17;
    public const TYPE_COUPON = 18;
    public const TYPE_META = 19;
    public const TYPE_FIRST_PURCHASE_COUPON = 20;
    public const TYPE_FEVICON= 21;
    public const TYPE_SOCIAL_PLATFORM= 22;
    



    public const VIEW_DESKTOP = 'DESKTOP';
    public const VIEW_MOBILE = 'MOBILE';
    public const VIEW_TABLET = 'TABLET';
    public const VIEW_THUMB = 'THUMB';

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
    



    public static function getData(int $type, $sizeType = ''): array
    {


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
                 
        }

        if (isset($imageDimensions['width'])) {
            $imageDimensions['aspectRatio'] = self::getAspectRatio($imageDimensions['width'], $imageDimensions['height']);
        } else {
            $firstKey = array_key_first($imageDimensions);
        
            $imageDimensions[$firstKey]['aspectRatio'] = self::getAspectRatio($imageDimensions[$firstKey]['width'], $imageDimensions[$firstKey]['height']);
            return $imageDimensions[$firstKey];
        }

        return $imageDimensions;
    }


    public static function getSlideData($sizeType = ''): array
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


    public static function getProductImageData($sizeType = ''): array
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

    public static function getUserImageData($sizeType = ''): array
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

    public static function getCustomProductImageData($sizeType = ''): array
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

    public static function getShopLogoImageData($sizeType = ''): array
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

    public static function getShopBannerImageData($sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        /* 
        switch (strtoupper($sizeType)) {
            case 'TEMP1':
                $w = 2000;
                $h = 500;
                AttachedFile::displayImage($image_name, $w, $h, $default_image);
                break;
           
        } */


        $arr =  [
            self::VIEW_DESKTOP => ['width' => 2000, 'height' => 500],
            self::VIEW_MOBILE => ['width' => 640, 'height' => 360],
            self::VIEW_TABLET => ['width' => 1024, 'height' => 360],


        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }


    public static function getPromotionMediaImageData($sizeType = ''): array
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

    public static function getBrandLogoImageData($sizeType = ''): array
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

    public static function getBrandImageData($sizeType = ''): array
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
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[self::VIEW_DEFAULT];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getEmailLogoImageData($sizeType = ''): array
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

    public static function getSocialFeedImageData($sizeType = ''): array
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

    public static function getWaterImageData($sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

        $arr =  [
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[$sizeType];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getAppleTouchIconImageData($sizeType = ''): array
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

    public static function getMobileLogoImageData($sizeType = ''): array
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
                return $arr[$sizeType];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getInvoiceLogoImageData($sizeType = ''): array
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
                return $arr[$sizeType];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getCategoryCollectionBGImageData($sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

      
        $arr =  [
            self::VIEW_THUMB => ['width' => 100, 'height' => 100],
           
        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[$sizeType];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }


    public static function getCouponImageData($sizeType = ''): array
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
                return $arr[$sizeType];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }


    public static function getMetaImageData($sizeType = ''): array
    {
        if (substr($sizeType, 0, 4) == 'webp') {
            $sizeType = substr($sizeType, 4);
        }

      
        $arr =  [
          
            self::VIEW_DEFAULT => ['width' => 600, 'height' => 400],
           
        ];

        if (!empty($sizeType)) {
            if (!array_key_exists($sizeType, $arr)) {
                return $arr[$sizeType];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    public static function getFirstPurchaseCouponImageData($sizeType = ''): array
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
                return $arr[$sizeType];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }

    


    public static function getFaviconImageData($sizeType = ''): array
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

    
    public static function getSocialPlatformImageData($sizeType = ''): array
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
                return $arr[$sizeType];
            }
            return $arr[$sizeType];
        }

        return $arr;
    }
    

    public static function getBannerData($sizeType = '', $layout): array
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
            if (array_key_exists($sizeType, $arr)) {
                $arr[$sizeType]['aspectRatio'] = self::getAspectRatio($arr[$sizeType]['width'], $arr[$sizeType]['height']);
                return $arr[$sizeType];
            }
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
