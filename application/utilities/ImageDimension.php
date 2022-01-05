<?php
class ImageDimension extends FatUtility
{
    public const TYPE_SLIDE = 1;
    public const TYPE_BANNER = 2;


    public const VIEW_DESKTOP = 'DESKTOP';
    public const VIEW_MOBILE = 'MOBILE';
    public const VIEW_TABLET = 'TABLET';
    public const VIEW_THUMB = 'THUMB';

    public static function getData(int $type): array
    {
      
        $imageDimensions = [];
        switch ($type) {
            case self::TYPE_SLIDE:
                $imageDimensions = self::getSlideData($type);
                break;
        }
        
        $imageDimensions['aspectRatio'] = self::getAspectRatio($imageDimensions['width'], $imageDimensions['height']);
        return $imageDimensions;
    }


    public static function getSlideData($type = ''): array
    {
        if (substr($type, 0, 4) == 'webp') {
            $type = substr($type, 4);
        }

        $arr =  [
            self::VIEW_DESKTOP => ['width' => 2000, 'height' => 666],
            self::VIEW_MOBILE => ['width' => 640, 'height' => 360],
            self::VIEW_TABLET => ['width' => 1024, 'height' => 360],
            self::VIEW_THUMB => ['width' => 200, 'height' => 100],
        ];

        if (!empty($type)) {
            if (!array_key_exists($type, $arr)) {
                return $arr[self::VIEW_DESKTOP];
            }
            return $arr[$type];
        }

        return $arr;
    }

    public static function getBannerData($type = '', $layout): array
    {
        if (substr($type, 0, 4) == 'webp') {
            $type = substr($type, 4);
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


        if (!empty($type)) {
            if (!array_key_exists($type, $arr)) {
              
                $arr['aspectRatio'] = self::getAspectRatio($arr[self::VIEW_DESKTOP]['width'], $arr[self::VIEW_DESKTOP]['height']);
                return $arr[self::VIEW_DESKTOP];
            }
            $arr['aspectRatio'] = self::getAspectRatio($arr[$type]['width'], $arr[$type]['height']);
            return $arr[$type];
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
