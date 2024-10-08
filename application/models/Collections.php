<?php

class Collections extends MyAppModel
{
    public const DB_TBL = 'tbl_collections';
    public const DB_TBL_PREFIX = 'collection_';

    public const DB_TBL_LANG = 'tbl_collections_lang';
    public const DB_TBL_LANG_PREFIX = 'collectionlang_';

    public const DB_TBL_COLLECTION_TO_RECORDS = 'tbl_collection_to_records';
    public const DB_TBL_COLLECTION_TO_RECORDS_PREFIX = 'ctr_';

    public const HOMEPAGE_COLLECTION_LIMIT = 5;

    //public const TYPE_PRODUCT = 1;
    public const COLLECTION_TYPE_PRODUCT = 1;
    public const COLLECTION_TYPE_CATEGORY = 2;
    public const COLLECTION_TYPE_SHOP = 3;
    public const COLLECTION_TYPE_BRAND = 4;
    public const COLLECTION_TYPE_BLOG = 5;
    public const COLLECTION_TYPE_SPONSORED_PRODUCTS = 6;
    public const COLLECTION_TYPE_SPONSORED_SHOPS = 7;
    public const COLLECTION_TYPE_BANNER = 8;
    public const COLLECTION_TYPE_FAQ = 9;
    public const COLLECTION_TYPE_TESTIMONIAL = 10;
    public const COLLECTION_TYPE_CONTENT_BLOCK = 11;
    public const COLLECTION_TYPE_REVIEWS = 12;
    public const COLLECTION_TYPE_FAQ_CATEGORY = 13;
    public const COLLECTION_TYPE_HERO_SLIDES = 14;

    //public const SUBTYPE_PRODUCT_LAYOUT1 = 1;
    public const TYPE_PRODUCT_LAYOUT1 = 1;
    public const TYPE_PRODUCT_LAYOUT2 = 2;
    public const TYPE_PRODUCT_LAYOUT3 = 3;
    public const TYPE_PRODUCT_LAYOUT4 = 24;
    public const TYPE_PRODUCT_LAYOUT5 = 29; /* Applicable For Apps only. */
    public const TYPE_PRODUCT_LAYOUT6 = 33;

    public const TYPE_CATEGORY_LAYOUT1 = 4;
    public const TYPE_CATEGORY_LAYOUT2 = 5;
    public const TYPE_CATEGORY_LAYOUT3 = 20;
    public const TYPE_CATEGORY_LAYOUT4 = 23;
    public const TYPE_CATEGORY_LAYOUT5 = 26; /* Applicable For Apps only. */
    public const TYPE_CATEGORY_LAYOUT6 = 27; /* Applicable For Apps only. */
    public const TYPE_CATEGORY_LAYOUT7 = 32;
    public const TYPE_CATEGORY_LAYOUT8 = 34;

    public const TYPE_SHOP_LAYOUT1 = 6;
    public const TYPE_SHOP_LAYOUT2 = 22;

    public const TYPE_BRAND_LAYOUT1 = 7;
    public const TYPE_BRAND_LAYOUT2 = 21;
    public const TYPE_BRAND_LAYOUT3 = 28; /* Applicable For Apps only. */

    public const TYPE_BLOG_LAYOUT1 = 8;
    public const TYPE_SPONSORED_PRODUCT_LAYOUT = 9;
    public const TYPE_SPONSORED_SHOP_LAYOUT = 10;

    public const TYPE_BANNER_LAYOUT1 = 11;
    public const TYPE_BANNER_LAYOUT2 = 12;
    // public const TYPE_BANNER_LAYOUT3 = 13; /* Applicable For Apps only. */

    public const TYPE_FAQ_LAYOUT1 = 14;
    public const TYPE_TESTIMONIAL_LAYOUT1 = 15;
    public const TYPE_TESTIMONIAL_LAYOUT2 = 30;
    public const TYPE_CONTENT_BLOCK_LAYOUT1 = 16;
    public const TYPE_CONTENT_BLOCK_LAYOUT2 = 31;
    public const TYPE_PENDING_REVIEWS1 = 17; /* Applicable For Apps only. */
    // public const TYPE_FAQ_CATEGORY_LAYOUT1 = 18; /* Applicable For Apps only. */
    public const TYPE_HERO_SLIDES_LAYOUT1 = 25;

    public const LIMIT_PRODUCT_LAYOUT1 = 12;
    public const LIMIT_PRODUCT_LAYOUT2 = 6;
    public const LIMIT_PRODUCT_LAYOUT3 = 3;
    public const LIMIT_PRODUCT_LAYOUT4 = 8;
    public const LIMIT_PRODUCT_LAYOUT6 = 10;
    public const LIMIT_CATEGORY_LAYOUT1 = 8;
    public const LIMIT_CATEGORY_LAYOUT1_PRODUCT = 3;
    public const LIMIT_CATEGORY_LAYOUT2 = 4;
    public const LIMIT_CATEGORY_LAYOUT3 = 4;
    public const LIMIT_CATEGORY_LAYOUT4 = 4;
    public const LIMIT_CATEGORY_LAYOUT5 = 5;
    public const LIMIT_CATEGORY_LAYOUT6 = 4;
    public const LIMIT_CATEGORY_LAYOUT7 = 20;
    public const LIMIT_SHOP_LAYOUT1 = 4;
    public const LIMIT_SHOP_LAYOUT2 = 3;
    public const LIMIT_BRAND_LAYOUT1 = 5;
    public const LIMIT_BRAND_LAYOUT2 = 5;
    public const LIMIT_BRAND_LAYOUT3 = 4;
    public const LIMIT_BLOG_LAYOUT1 = 3;
    public const LIMIT_FAQ_LAYOUT1 = 3;
    public const LIMIT_TESTIMONIAL_LAYOUT1 = 10;
    public const LIMIT_CONTENT_BLOCK_LAYOUT1 = 1;
    public const LIMIT_COLLECTION_RECORDS = 20;
    public const COLLECTION_CRITERIA_PRICE_LOW_TO_HIGH = 1;
    public const COLLECTION_CRITERIA_PRICE_HIGH_TO_LOW = 2;

    /*[ layout applicable types */
    public const FOR_WEB = 1;
    public const FOR_APP = 2;
    /*   layout applicable types ]*/

    public const COLLECTION_WITHOUT_MEDIA = [
        self::COLLECTION_TYPE_HERO_SLIDES,
        self::COLLECTION_TYPE_SHOP,
        self::COLLECTION_TYPE_BRAND,
        self::COLLECTION_TYPE_BLOG,
        self::COLLECTION_TYPE_SPONSORED_PRODUCTS,
        self::COLLECTION_TYPE_SPONSORED_SHOPS,
        self::COLLECTION_TYPE_BANNER,
        self::COLLECTION_TYPE_FAQ,
        self::COLLECTION_TYPE_FAQ_CATEGORY,
        self::COLLECTION_TYPE_TESTIMONIAL,
        self::COLLECTION_TYPE_CONTENT_BLOCK,
        self::COLLECTION_TYPE_REVIEWS,
    ];

    public const COLLECTION_WITHOUT_RECORDS = [
        self::COLLECTION_TYPE_HERO_SLIDES,
        self::COLLECTION_TYPE_SPONSORED_PRODUCTS,
        self::COLLECTION_TYPE_SPONSORED_SHOPS,
        self::COLLECTION_TYPE_BANNER,
        self::COLLECTION_TYPE_CONTENT_BLOCK,
        self::COLLECTION_TYPE_REVIEWS,
    ];

    public const COLLECTIONS_FOR_APP_ONLY = [
        // self::TYPE_BANNER_LAYOUT3,
        self::TYPE_PENDING_REVIEWS1,
        self::TYPE_CATEGORY_LAYOUT5,
        self::TYPE_CATEGORY_LAYOUT6,
        self::TYPE_BRAND_LAYOUT3,
        self::TYPE_PRODUCT_LAYOUT5,
    ];

    public const COLLECTIONS_NOT_FOR_APP = [
        self::TYPE_CATEGORY_LAYOUT2,
        self::TYPE_CATEGORY_LAYOUT3,
        self::TYPE_CATEGORY_LAYOUT4,
        self::TYPE_CATEGORY_LAYOUT7,
        self::TYPE_CATEGORY_LAYOUT8,
        self::TYPE_BRAND_LAYOUT2,
        self::TYPE_SHOP_LAYOUT2,
        self::TYPE_PRODUCT_LAYOUT3,
        self::TYPE_PRODUCT_LAYOUT6,
        self::TYPE_FAQ_LAYOUT1,
        self::TYPE_TESTIMONIAL_LAYOUT1,
        self::TYPE_TESTIMONIAL_LAYOUT2,
        self::TYPE_BLOG_LAYOUT1,
        self::TYPE_CONTENT_BLOCK_LAYOUT1,
        self::TYPE_CONTENT_BLOCK_LAYOUT2,
    ];

    public const COLLECTIONS_FULL_WIDTH = [
        self::TYPE_HERO_SLIDES_LAYOUT1,
        self::TYPE_BANNER_LAYOUT1,
    ];

    public const COLLECTIONS_FOR_DISPLAY_COUNT = [
        self::TYPE_CATEGORY_LAYOUT7,
        self::TYPE_CATEGORY_LAYOUT8,
        self::TYPE_SHOP_LAYOUT1,
        self::TYPE_PRODUCT_LAYOUT1,
        self::TYPE_TESTIMONIAL_LAYOUT2,
        self::TYPE_BRAND_LAYOUT1,
        self::TYPE_BANNER_LAYOUT2,
    ];

    /**
     * __construct
     *
     * @param  int $id
     * @return void
     */
    public function __construct(int $id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->objMainTableRecord->setSensitiveFields([static::DB_TBL_PREFIX . 'id']);
    }

    /**
     * getSearchObject
     *
     * @param  bool $isActive
     * @param  int $langId
     * @return object
     */
    public static function getSearchObject(bool $isActive = true, int $langId = 0): object
    {
        $srch = new SearchBase(static::DB_TBL, 'c');

        $srch->addCondition('c.' . static::DB_TBL_PREFIX . 'deleted', '=', applicationConstants::NO);
        if ($isActive == true) {
            $srch->addCondition('c.' . static::DB_TBL_PREFIX . 'active', '=', applicationConstants::ACTIVE);
        }

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'c_l.' . static::DB_TBL_LANG_PREFIX . 'collection_id = c.' . static::tblFld('id') . ' and
			    c_l.' . static::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                'c_l'
            );
        }

        return $srch;
    }

    /**
     * getTypeArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getTypeArr(int $langId): array
    {
        if (1 > $langId) {
            trigger_error(Labels::getLabel('ERR_LANGUAGE_ID_NOT_SPECIFIED.', $langId), E_USER_ERROR);
        }
        return [
            self::COLLECTION_TYPE_HERO_SLIDES => Labels::getLabel('LBL_HERO_SLIDES', $langId),
            self::COLLECTION_TYPE_PRODUCT => Labels::getLabel('LBL_PRODUCT', $langId),
            self::COLLECTION_TYPE_CATEGORY => Labels::getLabel('LBL_CATEGORY', $langId),
            self::COLLECTION_TYPE_SHOP => Labels::getLabel('LBL_SHOP', $langId),
            self::COLLECTION_TYPE_BRAND => Labels::getLabel('LBL_BRAND', $langId),
            self::COLLECTION_TYPE_BLOG => Labels::getLabel('LBL_BLOG', $langId),
            self::COLLECTION_TYPE_SPONSORED_PRODUCTS => Labels::getLabel('LBL_SPONSORED_PRODUCTS', $langId),
            self::COLLECTION_TYPE_SPONSORED_SHOPS => Labels::getLabel('LBL_SPONSORED_SHOPS', $langId),
            self::COLLECTION_TYPE_BANNER => Labels::getLabel('LBL_BANNER', $langId),
            self::COLLECTION_TYPE_FAQ => Labels::getLabel('LBL_FAQ', $langId),
            self::COLLECTION_TYPE_FAQ_CATEGORY => Labels::getLabel('LBL_FAQ_CATEGORY', $langId),
            self::COLLECTION_TYPE_TESTIMONIAL => Labels::getLabel('LBL_TESTIMONIAL', $langId),
            self::COLLECTION_TYPE_CONTENT_BLOCK => Labels::getLabel('LBL_CONTENT_BLOCKS', $langId),
            self::COLLECTION_TYPE_REVIEWS => Labels::getLabel('LBL_REVIEWS', $langId),
        ];
    }

    public static function getLayoutApplicableTypes(int $langId): array
    {
        if (1 > $langId) {
            trigger_error(Labels::getLabel('ERR_LANGUAGE_ID_NOT_SPECIFIED.', $langId), E_USER_ERROR);
        }
        return [
            self::FOR_WEB => Labels::getLabel('LBL_WEB', $langId),
            self::FOR_APP => Labels::getLabel('LBL_APP', $langId),
        ];
    }
    /**
     * getLayoutTypeArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getLayoutTypeArr(int $langId): array
    {
        if (1 > $langId) {
            trigger_error(Labels::getLabel('ERR_LANGUAGE_ID_NOT_SPECIFIED.', $langId), E_USER_ERROR);
        }

        return [
            self::TYPE_HERO_SLIDES_LAYOUT1 => Labels::getLabel('LBL_HERO_SLIDES_LAYOUT1', $langId),
            self::TYPE_PRODUCT_LAYOUT1 => Labels::getLabel('LBL_PRODUCT_LAYOUT1', $langId),
            self::TYPE_PRODUCT_LAYOUT2 => Labels::getLabel('LBL_PRODUCT_LAYOUT2', $langId),
            self::TYPE_PRODUCT_LAYOUT3 => Labels::getLabel('LBL_PRODUCT_LAYOUT3', $langId),
            self::TYPE_PRODUCT_LAYOUT4 => Labels::getLabel('LBL_PRODUCT_LAYOUT4', $langId),
            self::TYPE_PRODUCT_LAYOUT5 => Labels::getLabel('LBL_MOBILE_PRODUCT_LAYOUT5', $langId),
            self::TYPE_PRODUCT_LAYOUT6 => Labels::getLabel('LBL_PRODUCT_LAYOUT6', $langId),
            self::TYPE_CATEGORY_LAYOUT1 => Labels::getLabel('LBL_CATEGORY_LAYOUT1', $langId),
            self::TYPE_CATEGORY_LAYOUT2 => Labels::getLabel('LBL_CATEGORY_LAYOUT2', $langId),
            self::TYPE_CATEGORY_LAYOUT3 => Labels::getLabel('LBL_CATEGORY_LAYOUT3', $langId),
            self::TYPE_CATEGORY_LAYOUT4 => Labels::getLabel('LBL_CATEGORY_LAYOUT4', $langId),
            self::TYPE_CATEGORY_LAYOUT7 => Labels::getLabel('LBL_CATEGORY_LAYOUT7', $langId),
            self::TYPE_CATEGORY_LAYOUT5 => Labels::getLabel('LBL_MOBILE_CATEGORY_LAYOUT5', $langId),
            self::TYPE_CATEGORY_LAYOUT6 => Labels::getLabel('LBL_MOBILE_CATEGORY_LAYOUT6', $langId),
            self::TYPE_CATEGORY_LAYOUT8 => Labels::getLabel('LBL_CATEGORY_LAYOUT8', $langId),
            self::TYPE_SHOP_LAYOUT1 => Labels::getLabel('LBL_SHOP_LAYOUT1', $langId),
            self::TYPE_SHOP_LAYOUT2 => Labels::getLabel('LBL_SHOP_LAYOUT2', $langId),
            self::TYPE_BRAND_LAYOUT1 => Labels::getLabel('LBL_BRAND_LAYOUT1', $langId),
            self::TYPE_BRAND_LAYOUT2 => Labels::getLabel('LBL_BRAND_LAYOUT2', $langId),
            self::TYPE_BRAND_LAYOUT3 => Labels::getLabel('LBL_MOBILE_BRAND_LAYOUT3', $langId),
            self::TYPE_BLOG_LAYOUT1 => Labels::getLabel('LBL_BLOG_LAYOUT1', $langId),
            self::TYPE_SPONSORED_PRODUCT_LAYOUT => Labels::getLabel('LBL_SPONSORED_PRODUCTS', $langId),
            self::TYPE_SPONSORED_SHOP_LAYOUT => Labels::getLabel('LBL_SPONSORED_SHOPS', $langId),
            self::TYPE_BANNER_LAYOUT1 => Labels::getLabel('LBL_BANNER_LAYOUT1', $langId),
            self::TYPE_BANNER_LAYOUT2 => Labels::getLabel('LBL_BANNER_LAYOUT2', $langId),
            // self::TYPE_BANNER_LAYOUT3 => Labels::getLabel('LBL_MOBILE_BANNER_LAYOUT', $langId),
            self::TYPE_FAQ_LAYOUT1 => Labels::getLabel('LBL_FAQ_LAYOUT1', $langId),
            self::TYPE_TESTIMONIAL_LAYOUT1 => Labels::getLabel('LBL_TESTIMONIAL_LAYOUT1', $langId),
            self::TYPE_TESTIMONIAL_LAYOUT2 => Labels::getLabel('LBL_TESTIMONIAL_LAYOUT2', $langId),
            self::TYPE_CONTENT_BLOCK_LAYOUT1 => Labels::getLabel('LBL_CONTENT_BLOCK_LAYOUT1', $langId),
            self::TYPE_CONTENT_BLOCK_LAYOUT2 => Labels::getLabel('LBL_CONTENT_BLOCK_LAYOUT2', $langId),
            self::TYPE_PENDING_REVIEWS1 => Labels::getLabel('LBL_PENDING_REVIEWS1', $langId),
            // self::TYPE_FAQ_CATEGORY_LAYOUT1 => Labels::getLabel('LBL_FAQ_CATEGORIES', $langId),
        ];
    }

    /**
     * getTypeSpecificLayouts
     *
     * @param  int $langId
     * @return array
     */
    public static function getTypeSpecificLayouts(int $langId): array
    {
        return [
            self::COLLECTION_TYPE_HERO_SLIDES => [
                self::TYPE_HERO_SLIDES_LAYOUT1 => Labels::getLabel('LBL_HERO_SLIDES_LAYOUT1', $langId),
            ],
            self::COLLECTION_TYPE_BANNER => [
                self::TYPE_BANNER_LAYOUT1 => Labels::getLabel('LBL_BANNER_LAYOUT1', $langId),
                self::TYPE_BANNER_LAYOUT2 => Labels::getLabel('LBL_BANNER_LAYOUT2', $langId),
                // self::TYPE_BANNER_LAYOUT3 => Labels::getLabel('LBL_MOBILE_BANNER_LAYOUT', $langId),
            ],
            self::COLLECTION_TYPE_BRAND => [
                self::TYPE_BRAND_LAYOUT1 => Labels::getLabel('LBL_BRAND_LAYOUT1', $langId),
                self::TYPE_BRAND_LAYOUT2 => Labels::getLabel('LBL_BRAND_LAYOUT2', $langId),
                self::TYPE_BRAND_LAYOUT3 => Labels::getLabel('LBL_MOBILE_BRAND_LAYOUT3', $langId),
            ],
            self::COLLECTION_TYPE_BLOG => [
                self::TYPE_BLOG_LAYOUT1 => Labels::getLabel('LBL_BLOG_LAYOUT1', $langId),
            ],
            self::COLLECTION_TYPE_CATEGORY => [
                self::TYPE_CATEGORY_LAYOUT1 => Labels::getLabel('LBL_CATEGORY_LAYOUT1', $langId),
                self::TYPE_CATEGORY_LAYOUT2 => Labels::getLabel('LBL_CATEGORY_LAYOUT2', $langId),
                self::TYPE_CATEGORY_LAYOUT3 => Labels::getLabel('LBL_CATEGORY_LAYOUT3', $langId),
                self::TYPE_CATEGORY_LAYOUT4 => Labels::getLabel('LBL_CATEGORY_LAYOUT4', $langId),
                self::TYPE_CATEGORY_LAYOUT5 => Labels::getLabel('LBL_MOBILE_CATEGORY_LAYOUT5', $langId),
                self::TYPE_CATEGORY_LAYOUT6 => Labels::getLabel('LBL_MOBILE_CATEGORY_LAYOUT6', $langId),
                self::TYPE_CATEGORY_LAYOUT7 => Labels::getLabel('LBL_CATEGORY_LAYOUT7', $langId),
                self::TYPE_CATEGORY_LAYOUT8 => Labels::getLabel('LBL_CATEGORY_LAYOUT8', $langId),
            ],
            self::COLLECTION_TYPE_PRODUCT => [
                self::TYPE_PRODUCT_LAYOUT1 => Labels::getLabel('LBL_PRODUCT_LAYOUT1', $langId),
                self::TYPE_PRODUCT_LAYOUT2 => Labels::getLabel('LBL_PRODUCT_LAYOUT2', $langId),
                self::TYPE_PRODUCT_LAYOUT3 => Labels::getLabel('LBL_PRODUCT_LAYOUT3', $langId),
                self::TYPE_PRODUCT_LAYOUT4 => Labels::getLabel('LBL_PRODUCT_LAYOUT4', $langId),
                self::TYPE_PRODUCT_LAYOUT5 => Labels::getLabel('LBL_MOBILE_PRODUCT_LAYOUT5', $langId),
                self::TYPE_PRODUCT_LAYOUT6 => Labels::getLabel('LBL_PRODUCT_LAYOUT6', $langId),
            ],
            self::COLLECTION_TYPE_SHOP => [
                self::TYPE_SHOP_LAYOUT1 => Labels::getLabel('LBL_SHOP_LAYOUT1', $langId),
                self::TYPE_SHOP_LAYOUT2 => Labels::getLabel('LBL_SHOP_LAYOUT2', $langId),
            ],
            self::COLLECTION_TYPE_SPONSORED_PRODUCTS => [
                self::TYPE_SPONSORED_PRODUCT_LAYOUT => Labels::getLabel('LBL_SPONSORED_PRODUCTS', $langId),
            ],
            self::COLLECTION_TYPE_SPONSORED_SHOPS => [
                self::TYPE_SPONSORED_SHOP_LAYOUT => Labels::getLabel('LBL_SPONSORED_SHOPS', $langId),
            ],
            self::COLLECTION_TYPE_TESTIMONIAL => [
                self::TYPE_TESTIMONIAL_LAYOUT1 => Labels::getLabel('LBL_TESTIMONIAL_LAYOUT1', $langId),
                self::TYPE_TESTIMONIAL_LAYOUT2 => Labels::getLabel('LBL_TESTIMONIAL_LAYOUT2', $langId),
            ],
            self::COLLECTION_TYPE_FAQ => [
                self::TYPE_FAQ_LAYOUT1 => Labels::getLabel('LBL_FAQ', $langId),
            ],
            /* self::COLLECTION_TYPE_FAQ_CATEGORY => [
                self::TYPE_FAQ_CATEGORY_LAYOUT1 => Labels::getLabel('LBL_FAQ_CATEGORY', $langId),
            ], 
            self::COLLECTION_TYPE_REVIEWS => [
                self::TYPE_PENDING_REVIEWS1 => Labels::getLabel('LBL_PENDING_REVIEWS1', $langId),
            ]*/
            self::COLLECTION_TYPE_CONTENT_BLOCK => [
                self::TYPE_CONTENT_BLOCK_LAYOUT1 => Labels::getLabel('LBL_Content_Block1', $langId),
                self::TYPE_CONTENT_BLOCK_LAYOUT2 => Labels::getLabel('LBL_Content_Block2', $langId)
            ]
        ];
    }

    /**
     * getBannersCount
     *
     * @return array
     */
    public static function getBannersCount(): array
    {
        return [
            self::TYPE_BANNER_LAYOUT1 => 1,
            self::TYPE_BANNER_LAYOUT2 => 2,
            // self::TYPE_BANNER_LAYOUT3 => 1
        ];
    }

    /**
     * getBannersDimensions
     *
     * @return array
     */
    public static function getBannersDimensions(): array
    {
        return [
            self::TYPE_BANNER_LAYOUT1 => [
                applicationConstants::SCREEN_DESKTOP => [
                    'width' => 1350,
                    'height' => 405
                ],
                applicationConstants::SCREEN_IPAD => [
                    'width' => 1024,
                    'height' => 307
                ],
                applicationConstants::SCREEN_MOBILE => [
                    'width' => 640,
                    'height' => 360
                ],
            ],
            self::TYPE_BANNER_LAYOUT2 => [
                applicationConstants::SCREEN_DESKTOP => [
                    'width' => 920,
                    'height' => 690
                ],

                applicationConstants::SCREEN_IPAD => [
                    'width' => 660,
                    'height' => 198
                ],
                applicationConstants::SCREEN_MOBILE => [
                    'width' => 640,
                    'height' => 360
                ],

            ],
            /* self::TYPE_BANNER_LAYOUT3 => [
                applicationConstants::SCREEN_DESKTOP => [
                    'width' => 600,
                    'height' => 338
                ],
                applicationConstants::SCREEN_IPAD => [
                    'width' => 660,
                    'height' => 198
                ],
                applicationConstants::SCREEN_MOBILE => [
                    'width' => 640,
                    'height' => 360
                ],
            ] */
        ];
    }

    /**
     * getLayoutImagesArr
     *
     * @return array
     */
    public static function getLayoutImagesArr(): array
    {
        return [
            self::TYPE_HERO_SLIDES_LAYOUT1 => 'Hero-Slides-Layout-1.png',
            self::TYPE_PRODUCT_LAYOUT1 => 'Product-Layout-1.png',
            self::TYPE_PRODUCT_LAYOUT2 => 'Product-Layout-2.png',
            self::TYPE_PRODUCT_LAYOUT3 => 'Product-Layout-3.png',
            self::TYPE_PRODUCT_LAYOUT4 => 'Product-Layout-4.png',
            self::TYPE_PRODUCT_LAYOUT5 => 'Product-Layout-5.png',
            self::TYPE_PRODUCT_LAYOUT6 => 'Product-Layout-6.png',
            self::TYPE_CATEGORY_LAYOUT1 => 'Category-Layout-1.png',
            self::TYPE_CATEGORY_LAYOUT2 => 'Category-Layout-2.png',
            self::TYPE_CATEGORY_LAYOUT5 => 'Category-Layout-5.png',
            self::TYPE_CATEGORY_LAYOUT6 => 'Category-Layout-6.png',
            self::TYPE_CATEGORY_LAYOUT7 => 'Category-Layout-7.png',
            self::TYPE_SHOP_LAYOUT1 => 'Shop-Layout-1.png',
            self::TYPE_BRAND_LAYOUT1 => 'Brand-Layout-1.png',
            self::TYPE_BLOG_LAYOUT1 => 'Blog-Layout-1.png',
            self::TYPE_SPONSORED_PRODUCT_LAYOUT => 'Sponsored-Products.png',
            self::TYPE_SPONSORED_SHOP_LAYOUT => 'Sponsored-Shops.png',
            self::TYPE_BANNER_LAYOUT1 => 'Banner-Layout-1.png',
            self::TYPE_BANNER_LAYOUT2 => 'Banner-Layout-2.png',
            // self::TYPE_BANNER_LAYOUT3 => 'Banner-Layout-2.png',
            self::TYPE_FAQ_LAYOUT1 => 'Faq-Layout-1.png',
            // self::TYPE_FAQ_CATEGORY_LAYOUT1 => 'Faq-Layout-1.png',
            self::TYPE_TESTIMONIAL_LAYOUT1 => 'Testimonial-layout-1.png',
            self::TYPE_TESTIMONIAL_LAYOUT2 => 'Testimonial-layout-2.png',
            self::TYPE_CONTENT_BLOCK_LAYOUT1 => 'Content-Block-layout-1.png',
            self::TYPE_CONTENT_BLOCK_LAYOUT2 => 'Content-Block-layout-2.png',
            self::TYPE_PENDING_REVIEWS1 => 'Pending-Reviews-1.png',
        ];
    }

    /**
     * getCriteria
     *
     * @return array
     */
    public static function getCriteria()
    {
        return [
            static::COLLECTION_CRITERIA_PRICE_LOW_TO_HIGH => "Price Low to High",
            static::COLLECTION_CRITERIA_PRICE_HIGH_TO_LOW => "Price High to Low",
        ];
    }

    /**
     * addUpdateCollectionRecord
     *
     * @param  int $recordId
     * @return bool
     */
    public function addUpdateCollectionRecord(int $recordId): bool
    {
        if (1 > $this->mainTableRecordId || 1 > $recordId) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', $this->commonLangId);
            return false;
        }

        $srch = new SearchBase(static::DB_TBL_COLLECTION_TO_RECORDS);
        $srch->doNotLimitRecords();
        $srch->addCondition(static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'collection_id', '=', $this->mainTableRecordId);
        $srch->getResultSet();
        if (self::LIMIT_COLLECTION_RECORDS <= $srch->recordCount()) {
            $str = Labels::getLabel('ERR_YOU_CANNOT_BIND_MORE_THAN_ALLOWED_LIMIT_{LIMIT}', $this->commonLangId);
            $this->error = CommonHelper::replaceStringData($str, ['{LIMIT}' => self::LIMIT_COLLECTION_RECORDS]);
            return false;
        }

        $dataToSave = [
            static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'collection_id' => $this->mainTableRecordId,
            static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'record_id' => $recordId
        ];

        $record = new TableRecord(static::DB_TBL_COLLECTION_TO_RECORDS);

        $record->assignValues($dataToSave);
        if (!$record->addNew(array(), $dataToSave)) {
            $this->error = $record->getError();
            return false;
        }
        return true;
    }

    /**
     * updateRecordOrder
     *
     * @param  int $recordId
     * @return bool
     */
    public function updateRecordDisplayOrder(int $recordId): bool
    {
        if (1 > $this->mainTableRecordId || 1 > $recordId) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', $this->commonLangId);
            return false;
        }
        $db = FatApp::getDb();

        $srch = new SearchBase(static::DB_TBL_COLLECTION_TO_RECORDS);
        $srch->doNotLimitRecords();
        $srch->doNotCalculateRecords();
        $srch->addFld('MAX(ctr_display_order) as ctr_display_order');
        $srch->setPageSize(1);
        $displayOrder = $db->fetch($srch->getResultSet());

        if (false === $db->updateFromArray(
            static::DB_TBL_COLLECTION_TO_RECORDS,
            [static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'display_order' => ((int)current($displayOrder)) + 1],
            [
                'smt' => static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'collection_id = ? AND ' . static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'record_id = ?',
                'vals' => [$this->mainTableRecordId, $recordId]
            ],
            true
        )) {
            $this->error = $db->getError();
            return false;
        }
        return true;
    }

    /**
     * updateCollectionRecordOrder
     *
     * @param  int $collectionId
     * @param  array $order
     * @return bool
     */

    /* public function updateCollectionRecordOrder(int $collectionId, array $order): bool
    {
        if (!$collectionId) {
            return false;
        }
        if (is_array($order) && sizeof($order) > 0) {
            foreach ($order as $i => $id) {
                if (FatUtility::int($id) < 1) {
                    continue;
                }
                FatApp::getDb()->updateFromArray(
                    static::DB_TBL_COLLECTION_TO_RECORDS,
                    [static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'display_order' => $i],
                    [
                        'smt' => static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'collection_id = ? AND ' . static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'record_id = ?',
                        'vals' => [$collectionId, $id]
                    ]
                );
            }
            return true;
        }
        return false;
    } */

    /**
     * addUpdateData
     *
     * @param  array $data
     * @return bool
     */
    public function addUpdateData(array $data): bool
    {
        unset($data['collection_id']);
        $assignValues = $data;
        $assignValues['collection_deleted'] = 0;
        if ($this->mainTableRecordId > 0) {
            $assignValues['collection_id'] = $this->mainTableRecordId;
        }

        $this->assignValues($assignValues);
        if (!$this->save()) {
            $this->error = $this->getError();
            return false;
        }

        return true;
    }

    /**
     * removeCollectionRecord
     *
     * @param  int $collectionId
     * @param  int $recordId
     * @return bool
     */
    public function removeCollectionRecord(int $collectionId, int $recordId): bool
    {
        $db = FatApp::getDb();
        if (!$collectionId || !$recordId) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', $this->commonLangId);
            return false;
        }
        if (!$db->deleteRecords(static::DB_TBL_COLLECTION_TO_RECORDS, array('smt' => static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'collection_id = ? AND ' . static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'record_id = ?', 'vals' => array($collectionId, $recordId)))) {
            $this->error = $db->getError();
            return false;
        }
        return true;
    }

    /**
     * canRecordMarkDelete
     *
     * @param  int $collection_id
     * @return bool
     */
    public function canRecordMarkDelete(int $collection_id): bool
    {
        $srch = static::getSearchObject(false);
        $srch->addCondition('collection_deleted', '=', applicationConstants::NO);
        $srch->addCondition('collection_id', '=', $collection_id);
        $srch->addFld('collection_id');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (!empty($row) && $row['collection_id'] == $collection_id) {
            return true;
        }
        return false;
    }

    /**
     * getSellProds
     *
     * @param  int $collection_id
     * @param  int $lang_id
     * @return array
     */
    public static function getSellProds(int $collection_id, int $lang_id): array
    {
        if (!$collection_id || !$lang_id) {
            trigger_error(Labels::getLabel('ERR_ARGUMENTS_NOT_SPECIFIED.', $lang_id), E_USER_ERROR);
            return false;
        }

        $srch = new SearchBase(static::DB_TBL_COLLECTION_TO_RECORDS);
        $srch->addCondition(static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'collection_id', '=', $collection_id);
        $srch->joinTable(SellerProduct::DB_TBL, 'INNER JOIN', SellerProduct::DB_TBL_PREFIX . 'id = ' . static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'record_id', 'sp');
        $srch->joinTable(Product::DB_TBL, 'INNER JOIN', SellerProduct::DB_TBL_PREFIX . 'product_id = ' . Product::DB_TBL_PREFIX . 'id');
        $srch->joinTable(Product::DB_TBL_LANG, 'LEFT JOIN', SellerProduct::DB_TBL_PREFIX . 'product_id = ' . Product::DB_TBL_LANG_PREFIX . 'product_id');

        $srch->joinTable(SellerProduct::DB_TBL . '_lang', 'LEFT JOIN', 'lang.selprodlang_selprod_id = ' . SellerProduct::DB_TBL_PREFIX . 'id AND selprodlang_lang_id = ' . $lang_id, 'lang');
        $srch->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'tuc.credential_user_id = sp.selprod_user_id', 'tuc');
        $srch->addMultipleFields(array('selprod_id', 'COALESCE(selprod_title, product_name, product_identifier) as product_name', 'credential_username'));
        $srch->addOrder('ctr_display_order', 'ASC');
        $srch->doNotLimitRecords();
        $srch->doNotCalculateRecords();
        $products = (array) FatApp::getDb()->fetchAll($srch->getResultSet());
        $data = [];
        if (!empty($products)) {
            foreach ($products as $product) {
                $options = SellerProduct::getSellerProductOptions($product['selprod_id'], true, CommonHelper::getLangId());
                $variantsStr = '';
                $userName = isset($product["credential_username"]) ? " | " . $product["credential_username"] : '';
                array_walk($options, function ($item, $key) use (&$variantsStr) {
                    $variantsStr .= ' | ' . $item['option_name'] . ' : ' . $item['optionvalue_name'];
                });
                $data[$product['selprod_id']] = strip_tags(html_entity_decode($product['product_name'], ENT_QUOTES, 'UTF-8')) . $variantsStr . $userName;
            }
        }
        return $data;
    }


    /**
     * getBanners
     *
     * @param  int $collection_id
     * @param  int $lang_id
     * @return array
     */
    public static function getBanners(int $collection_id, int $lang_id): array
    {
        if (!$collection_id || !$lang_id) {
            trigger_error(Labels::getLabel('ERR_ARGUMENTS_NOT_SPECIFIED.', $lang_id), E_USER_ERROR);
            return false;
        }

        $srch = new BannerSearch($lang_id, false);
        $srch->joinCollectionToRecords();
        $srch->joinLocations();
        $srch->joinPromotions($lang_id, true);
        $srch->addPromotionTypeCondition();
        $srch->doNotLimitRecords();
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(array('COALESCE(promotion_name,promotion_identifier) as promotion_name', 'banner_id', 'banner_type', 'banner_url', 'banner_target', 'banner_active', 'banner_blocation_id', 'banner_title', 'banner_updated_on'));
        $srch->addCondition(static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'collection_id', '=', $collection_id);

        $srch->addOrder('banner_active', 'DESC');
        $rs = $srch->getResultSet();
        return FatApp::getDb()->fetchAll($rs);
    }

    /**
     * getCategories
     *
     * @param  int $collection_id
     * @param  int $lang_id
     * @return array
     */
    public static function getCategories(int $collection_id, int $lang_id): array
    {
        if (!$collection_id || !$lang_id) {
            trigger_error(Labels::getLabel("ERR_ARGUMENTS_NOT_SPECIFIED.", $lang_id), E_USER_ERROR);
            return false;
        }

        $srch = new SearchBase(static::DB_TBL_COLLECTION_TO_RECORDS);
        $srch->doNotLimitRecords();
        $srch->doNotCalculateRecords();
        $srch->addCondition(static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'collection_id', '=', $collection_id);

        $srch->joinTable(ProductCategory::DB_TBL, 'INNER JOIN', ProductCategory::DB_TBL_PREFIX . 'id = ' . static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'record_id');

        $srch->joinTable(ProductCategory::DB_TBL_LANG, 'LEFT JOIN', 'lang.prodcatlang_prodcat_id = ' . ProductCategory::DB_TBL_PREFIX . 'id AND prodcatlang_lang_id = ' . $lang_id, 'lang');
        $srch->addCondition('prodcat_active', '=', applicationConstants::YES);
        $srch->addCondition('prodcat_deleted', '=', applicationConstants::NO);
        $srch->addMultipleFields(['prodcat_id as id', 'IFNULL(prodcat_name, prodcat_identifier) as text']);
        $srch->addOrder('ctr_display_order', 'ASC');
        $data = (array) FatApp::getDb()->fetchAllAssoc($srch->getResultSet());
        array_walk($data, function (&$catTitle, $catId) use ($lang_id) {
            $prodCateObj = new ProductCategory();
            $catTitle = html_entity_decode($prodCateObj->getParentTreeStructure($catId, 0, '', $lang_id), ENT_QUOTES);
        });
        return $data;
    }

    /**
     * getShops
     *
     * @param  int $collection_id
     * @param  int $lang_id
     * @return array
     */
    public static function getShops(int $collection_id, int $lang_id): array
    {
        if (!$collection_id || !$lang_id) {
            trigger_error(Labels::getLabel("ERR_ARGUMENTS_NOT_SPECIFIED.", $lang_id), E_USER_ERROR);
            return false;
        }

        $srch = new SearchBase(static::DB_TBL_COLLECTION_TO_RECORDS);
        $srch->doNotLimitRecords();
        $srch->doNotCalculateRecords();
        $srch->addCondition(static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'collection_id', '=', $collection_id);

        $srch->joinTable(Shop::DB_TBL, 'INNER JOIN', Shop::DB_TBL_PREFIX . 'id = ' . static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'record_id');

        $srch->joinTable(Shop::DB_TBL_LANG, 'LEFT JOIN', 'lang.shoplang_shop_id = ' . Shop::DB_TBL_PREFIX . 'id AND shoplang_lang_id = ' . $lang_id, 'lang');
        $srch->addMultipleFields(array('shop_id as id', 'IFNULL(shop_name, shop_identifier) as text'));
        $srch->addOrder('ctr_display_order', 'ASC');
        $rs = $srch->getResultSet();
        return (array) FatApp::getDb()->fetchAllAssoc($rs);
    }

    /**
     * getBrands
     *
     * @param  int $collectionId
     * @param  int $langId
     * @return array
     */
    public static function getBrands(int $collectionId, int $langId): array
    {
        if (!$collectionId || !$langId) {
            trigger_error(Labels::getLabel("ERR_ARGUMENTS_NOT_SPECIFIED.", $langId), E_USER_ERROR);
            return false;
        }

        $srch = new SearchBase(static::DB_TBL_COLLECTION_TO_RECORDS);
        $srch->doNotLimitRecords();
        $srch->doNotCalculateRecords();
        $srch->addCondition(static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'collection_id', '=', $collectionId);
        $srch->joinTable(Brand::DB_TBL, 'INNER JOIN', Brand::DB_TBL_PREFIX . 'id = ' . static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'record_id');
        $srch->joinTable(Brand::DB_TBL_LANG, 'LEFT JOIN', 'lang.brandlang_brand_id = ' . Brand::DB_TBL_PREFIX . 'id AND brandlang_lang_id = ' . $langId, 'lang');
        $srch->addMultipleFields(array('brand_id as id', 'IFNULL(brand_name, brand_identifier) as text'));
        $srch->addOrder('ctr_display_order', 'ASC');
        $rs = $srch->getResultSet();
        return (array) FatApp::getDb()->fetchAllAssoc($rs);
    }

    /**
     * getBlogs
     *
     * @param  int $collectionId
     * @param  int $langId
     * @return array
     */
    public static function getBlogs(int $collectionId, int $langId): array
    {
        if (!$collectionId || !$langId) {
            trigger_error(Labels::getLabel("ERR_ARGUMENTS_NOT_SPECIFIED.", $langId), E_USER_ERROR);
            return false;
        }

        $srch = new SearchBase(static::DB_TBL_COLLECTION_TO_RECORDS);
        $srch->doNotLimitRecords();
        $srch->doNotCalculateRecords();
        $srch->addCondition(static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'collection_id', '=', $collectionId);

        $srch->joinTable(BlogPost::DB_TBL, 'INNER JOIN', BlogPost::DB_TBL_PREFIX . 'id = ' . static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'record_id');

        $srch->joinTable(BlogPost::DB_TBL_LANG, 'LEFT JOIN', 'lang.postlang_post_id = ' . BlogPost::DB_TBL_PREFIX . 'id AND postlang_lang_id = ' . $langId, 'lang');
        $srch->addMultipleFields(array('post_id as id', 'IFNULL(post_title, post_identifier) as text'));
        $rs = $srch->getResultSet();
        return (array) FatApp::getDb()->fetchAllAssoc($rs);
    }

    /**
     * getFaqs
     *
     * @param  int $collectionId
     * @param  int $langId
     * @return array
     */
    public static function getFaqs(int $collectionId, int $langId): array
    {
        if (!$collectionId || !$langId) {
            trigger_error(Labels::getLabel("ERR_ARGUMENTS_NOT_SPECIFIED.", $langId), E_USER_ERROR);
            return false;
        }

        $srch = new SearchBase(static::DB_TBL_COLLECTION_TO_RECORDS);
        $srch->doNotLimitRecords();
        $srch->doNotCalculateRecords();
        $srch->addCondition(static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'collection_id', '=', $collectionId);

        $srch->joinTable(Faq::DB_TBL, 'INNER JOIN', Faq::DB_TBL_PREFIX . 'id = ' . static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'record_id');
        $srch->joinTable(Faq::DB_TBL_LANG, 'LEFT JOIN', 'lang.faqlang_faq_id = ' . Faq::DB_TBL_PREFIX . 'id AND faqlang_lang_id = ' . $langId, 'lang');
        $srch->joinTable(
            FaqCategory::DB_TBL,
            'INNER JOIN',
            'faq_faqcat_id = faqcat_id',
            'fc'
        );
        $srch->joinTable(FaqCategory::DB_TBL_LANG, 'LEFT OUTER JOIN', 'fc_l.' . FaqCategory::DB_TBL_LANG_PREFIX . 'faqcat_id = fc.' . FaqCategory::tblFld('id') . ' and fc_l.' . FaqCategory::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId, 'fc_l');
        $srch->addMultipleFields(array('faq_id as id', 'CONCAT(IFNULL(faq_title, faq_identifier), " | ", IFNULL (faqcat_name, faqcat_identifier)) as text'));
        $srch->addOrder('ctr_display_order', 'ASC');
        $rs = $srch->getResultSet();
        return (array) FatApp::getDb()->fetchAllAssoc($rs);
    }

    /**
     * getFaqCategory
     *
     * @param  int $collectionId
     * @param  int $langId
     * @return array
     */
    public static function getFaqCategories(int $collectionId, int $langId): array
    {
        if (!$collectionId || !$langId) {
            trigger_error(Labels::getLabel("ERR_ARGUMENTS_NOT_SPECIFIED.", $langId), E_USER_ERROR);
            return false;
        }

        $srch = new SearchBase(static::DB_TBL_COLLECTION_TO_RECORDS);
        $srch->doNotLimitRecords();
        $srch->doNotCalculateRecords();
        $srch->addCondition(static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'collection_id', '=', $collectionId);

        $srch->joinTable(FaqCategory::DB_TBL, 'INNER JOIN', FaqCategory::DB_TBL_PREFIX . 'id = ' . static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'record_id');
        $srch->joinTable(FaqCategory::DB_TBL_LANG, 'LEFT JOIN', 'lang.faqcatlang_faqcat_id = ' . FaqCategory::DB_TBL_PREFIX . 'id AND faqcatlang_lang_id = ' . $langId, 'lang');

        $srch->addMultipleFields(array('faqcat_id as id', 'IFNULL (faqcat_name, faqcat_identifier) as text'));
        $srch->addOrder('ctr_display_order', 'ASC');
        $rs = $srch->getResultSet();
        return (array) FatApp::getDb()->fetchAllAssoc($rs);
    }

    /**
     * getTestimonials
     *
     * @param  int $collectionId
     * @param  int $langId
     * @return array
     */
    public static function getTestimonials(int $collectionId, int $langId): array
    {
        if (!$collectionId || !$langId) {
            trigger_error(Labels::getLabel("ERR_ARGUMENTS_NOT_SPECIFIED.", $langId), E_USER_ERROR);
            return false;
        }

        $srch = new SearchBase(static::DB_TBL_COLLECTION_TO_RECORDS);
        $srch->doNotLimitRecords();
        $srch->doNotCalculateRecords();
        $srch->addCondition(static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'collection_id', '=', $collectionId);

        $srch->joinTable(Testimonial::DB_TBL, 'INNER JOIN', Testimonial::DB_TBL_PREFIX . 'id = ' . static::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'record_id');

        $srch->joinTable(Testimonial::DB_TBL_LANG, 'LEFT JOIN', 'lang.testimoniallang_testimonial_id = ' . Testimonial::DB_TBL_PREFIX . 'id AND testimoniallang_lang_id = ' . $langId, 'lang');
        $srch->addMultipleFields(array('testimonial_id as id', 'IFNULL(testimonial_title, testimonial_identifier) as text'));
        $srch->addOrder('ctr_display_order', 'ASC');
        $rs = $srch->getResultSet();
        return (array) FatApp::getDb()->fetchAllAssoc($rs);
    }

    /**
     * saveLangData
     *
     * @param  int $langId
     * @param  string $collectionName
     * @return bool
     */
    public function saveLangData(int $langId, string $collectionName): bool
    {
        $langId = FatUtility::int($langId);
        if ($this->mainTableRecordId < 1 || $langId < 1) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', $this->commonLangId);
            return false;
        }

        $data = array(
            'collectionlang_collection_id' => $this->mainTableRecordId,
            'collectionlang_lang_id' => $langId,
            'collection_name' => $collectionName,
        );

        if (!$this->updateLangData($langId, $data)) {
            $this->error = $this->getError();
            return false;
        }
        return true;
    }

    /**
     * saveTranslatedLangData
     *
     * @param  int $langId
     * @return bool
     */
    public function saveTranslatedLangData(int $langId): bool
    {
        $langId = FatUtility::int($langId);
        if ($this->mainTableRecordId < 1 || $langId < 1) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', $this->commonLangId);
            return false;
        }

        $translateLangobj = new TranslateLangData(static::DB_TBL_LANG);
        if (false === $translateLangobj->updateTranslatedData($this->mainTableRecordId, 0, $langId)) {
            $this->error = $translateLangobj->getError();
            return false;
        }
        return true;
    }

    /**
     * getRecords
     *
     * @param  int $collectionId
     * @return array
     */
    public static function getRecords(int $collectionId): array
    {
        if (1 > $collectionId) {
            return [];
        }

        $srch = new SearchBase(self::DB_TBL_COLLECTION_TO_RECORDS);
        $srch->addCondition(Collections::DB_TBL_COLLECTION_TO_RECORDS_PREFIX . 'collection_id', '=', $collectionId);
        $srch->addMultipleFields(array('ctr_record_id', 'ctr_collection_id'));
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $res = $srch->getResultSet();
        return (array) FatApp::getDb()->fetchAllAssoc($res);
    }

    /**
     * getMaxDisplayOrder
     * 
     * @return integer
     */
    public static function getMaxDisplayOrder(): int
    {
        $srch = static::getSearchObject(false);
        $srch->addFld('MAX(collection_display_order) AS max_display_order');
        $row = (array) FatApp::getDb()->fetch($srch->getResultSet());
        return (int) current($row);
    }

    public static function layoutIconClass(int $layoutId): string
    {
        $classArr = [
            self::TYPE_HERO_SLIDES_LAYOUT1 => 'hero-slides-layout-1',
            self::TYPE_PRODUCT_LAYOUT1 => 'product-layout-1',
            self::TYPE_PRODUCT_LAYOUT2 => 'product-layout-2',
            self::TYPE_PRODUCT_LAYOUT3 => 'product-layout-3',
            self::TYPE_PRODUCT_LAYOUT4 => 'product-layout-4',
            self::TYPE_PRODUCT_LAYOUT5 => 'product-layout-5',
            self::TYPE_PRODUCT_LAYOUT6 => 'product-layout-6',
            self::TYPE_CATEGORY_LAYOUT1 => 'category-layout-1',
            self::TYPE_CATEGORY_LAYOUT2 => 'category-layout-2',
            self::TYPE_CATEGORY_LAYOUT3 => 'category-layout-3',
            self::TYPE_CATEGORY_LAYOUT4 => 'category-layout-4',
            self::TYPE_CATEGORY_LAYOUT5 => 'category-layout-5',
            self::TYPE_CATEGORY_LAYOUT6 => 'category-layout-6',
            self::TYPE_CATEGORY_LAYOUT7 => 'category-layout-7',
            self::TYPE_CATEGORY_LAYOUT8 => 'category-layout-8',
            self::TYPE_SHOP_LAYOUT1 => 'shop-layout-1',
            self::TYPE_SHOP_LAYOUT2 => 'shop-layout-2',
            self::TYPE_BRAND_LAYOUT1 => 'brand-layout-1',
            self::TYPE_BRAND_LAYOUT2 => 'brand-layout-2',
            self::TYPE_BRAND_LAYOUT3 => 'brand-layout-3',
            self::TYPE_BLOG_LAYOUT1 => 'blog-layout-1',
            self::TYPE_SPONSORED_PRODUCT_LAYOUT => 'sponsored-product-layout',
            self::TYPE_SPONSORED_SHOP_LAYOUT => 'sponsored-shop-layout',
            self::TYPE_BANNER_LAYOUT1 => 'banner-layout-1',
            self::TYPE_BANNER_LAYOUT2 => 'banner-layout-2',
            // self::TYPE_BANNER_LAYOUT3 => 'banner-layout-3',
            self::TYPE_FAQ_LAYOUT1 => 'faq-layout-1',
            self::TYPE_TESTIMONIAL_LAYOUT1 => 'testimonial-layout-1',
            self::TYPE_TESTIMONIAL_LAYOUT2 => 'testimonial-layout-2',
            self::TYPE_CONTENT_BLOCK_LAYOUT1 => 'content-block-layout-1',
            self::TYPE_CONTENT_BLOCK_LAYOUT2 => 'content-block-layout-2',
            self::TYPE_PENDING_REVIEWS1 => 'pending-reviews-1',
            // self::TYPE_FAQ_CATEGORY_LAYOUT1 => 'faq-category-layout-1',
        ];
        return $classArr[$layoutId] ?? '';
    }

    public static function sponsoredItemsHomePageCount(): array
    {
        return [
            4 => 4,
            8 => 8,
            12 => 12,
        ];
    }

    public static function displayRecordsCount(int $layoutType): array
    {
        switch ($layoutType) {
            case self::TYPE_CATEGORY_LAYOUT7:
                $range = range(6, 8);
                break;
            case self::TYPE_CATEGORY_LAYOUT8:
                $range = range(4, 6);
                break;
            case self::TYPE_SHOP_LAYOUT1:
                $range = range(4, 8);
                break;
            case self::TYPE_PRODUCT_LAYOUT1:
                $range = range(4, 6);
                break;
            case self::TYPE_TESTIMONIAL_LAYOUT2:
                $range = range(4, 6);
                break;
            case self::TYPE_BRAND_LAYOUT1:
                $range = range(5, 8);
                break;
            case self::TYPE_BANNER_LAYOUT2:
                $range = range(1, 3);
                break;
            default:
                $range = range(3, 8);
                break;
        }
        return $range;
    }
}
