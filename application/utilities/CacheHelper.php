<?php

class CacheHelper extends FatCache
{

    const TYPE_LABELS = 1;
    const TYPE_ZONE = 2; // zone,country,state
    const TYPE_SHIPING_API = 3;
    const TYPE_NAVIGATION = 4; // footer navigation
    const TYPE_CURRENCY = 5;
    const TYPE_TAX_API = 6;
    const TYPE_PRODUCT_CATEGORIES = 7;
    const TYPE_LANGUAGE = 8;
    const TYPE_GOOGLE_ANALYTICS = 9;
    const TYPE_COLLECTIONS = 10;

    public static function clear(int $type)
    {
        $keys = self::getKeysByType($type);
        foreach ($keys as $key) {
            FatCache::delete($key);
        }
    }

    public static function create(string $key, string $val, int $type = 0, string $extension = '.txt')
    {
        FatCache::set($key, $val, $extension);
        if (1 > $type) {
            return;
        }

        $file = CONF_UPLOADS_PATH . '/cache_keys.txt';
        $data = [];
        if (file_exists($file)) {
            $data = (array) json_decode(file_get_contents($file), true);
            if (isset($data[$type]) && in_array($key, $data[$type])) {
                return;
            }
        }

        $data[$type][] = $key;
        file_put_contents($file, json_encode($data));
    }

    public static function getKeysByType(int $type = 0): array
    {
        $file = CONF_UPLOADS_PATH . '/cache_keys.txt';
        if (file_exists($file)) {
            $data = (array) json_decode(file_get_contents($file), true);
            if (isset($data[$type])) {
                return $data[$type];
            }
        }
        return [];
    }

    public static function get($key, $expiry = null, $extension = '.txt')
    {
        return FatCache::get($key, $expiry, $extension);
    }

}
