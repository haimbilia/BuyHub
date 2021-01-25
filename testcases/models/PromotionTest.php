<?php
class PromotionTest extends YkModelTest
{
    private $class = 'Promotion';

    /**
     * setUpBeforeClass
     *
     * @return void
     */
    public static function setUpBeforeClass() :void
    { 
        self::truncateDbData();
        $obj = new self();
        $obj->insertUserData();
        $obj->insertShopData();
        $obj->insertShopLangData(); 
        $obj->insertShopRewriteUrl();
        $obj->inserPromotionData();
        $obj->inserPromotionLangData();
    }

    /**
     * tearDownAfterClass
     *
     * @return void
     */
    public static function tearDownAfterClass() :void
    {   
        self::truncateDbData();
    }
    
    /**
     * truncateDbData
     *
     * @return void
     */
    public static function truncateDbData()
    {
        FatApp::getDb()->query("TRUNCATE TABLE ".User::DB_TBL);
        FatApp::getDb()->query("TRUNCATE TABLE ".Shop::DB_TBL);
        FatApp::getDb()->query("TRUNCATE TABLE ".Shop::DB_TBL_LANG);
        FatApp::getDb()->query("TRUNCATE TABLE ".UrlRewrite::DB_TBL); 
        FatApp::getDb()->query("TRUNCATE TABLE ".Shop::DB_TBL_SHOP_FAVORITE); 
        FatApp::getDb()->query("TRUNCATE TABLE ".Promotion::DB_TBL);
        FatApp::getDb()->query("TRUNCATE TABLE ".Promotion::DB_TBL_LANG);
    }
    
    /**
    * insertUserData
    *
    * @return void
    */
    private function insertUserData()
    {
        $arr = [
            [
                'user_id' => 1,
                'user_name' => 'Sammy',
                'user_zip' => 85281,
                'user_country_id' => 223,
                'user_state_id' => 2996,
                'user_is_buyer' => 1,               
                'user_is_supplier' => 1,
            ],
            [
                'user_id' => 2,
                'user_name' => 'Samar',
                'user_zip' => 85281,
                'user_country_id' => 223,
                'user_state_id' => 2996,
                'user_is_buyer' => 1,               
                'user_is_supplier' => 1,
            ]
        ];            
        $this->InsertDbData(User::DB_TBL, $arr);
    }
    
    /**
    * insertShopData
    *
    * @return void
    */
    private function insertShopData()
    {
        $arr = [
            [
                'shop_id' => 1,
                'shop_user_id' => 1,
                'shop_identifier' => 'Sammy',
                'shop_postalcode' => 85281,
                'shop_country_id' => 223,
                'shop_state_id' => 2996,
                'shop_active' => 1,               
            ],
            [
                'shop_id' => 2,
                'shop_user_id' => 2,
                'shop_identifier' => 'Samar',
                'shop_postalcode' => 85281,
                'shop_country_id' => 223,
                'shop_state_id' => 2996,
                'shop_active' => 0,               
            ],
        ];            
        $this->InsertDbData(Shop::DB_TBL, $arr);
    }
    
    /**
    * insertShopLangData
    *
    * @return void
    */
    private function insertShopLangData()
    {
        $arr = [
            [
                'shoplang_shop_id' => 1,
                'shoplang_lang_id' => 1,
                'shop_name' => 'Sammy',              
            ],
            [
                'shoplang_shop_id' => 2,
                'shoplang_lang_id' => 1,
                'shop_name' => 'Samar',            
            ],
        ];            
        $this->InsertDbData(Shop::DB_TBL_LANG, $arr);
    }
    
    /**
    * insertShopRewriteUrl
    *
    * @return void
    */
    private function insertShopRewriteUrl()
    {
        $arr = [
            [
                'urlrewrite_id' => 1,
                'urlrewrite_original' => 'shops/view/1',
                'urlrewrite_custom' => 'sammy',
                'urlrewrite_lang_id' => 1,              
            ],
            [
                'urlrewrite_id' => 2,
                'urlrewrite_original' => 'shops/view/2',
                'urlrewrite_custom' => 'samar',
                'urlrewrite_lang_id' => 1,                  
            ],
        ];            
        $this->InsertDbData(UrlRewrite::DB_TBL, $arr);
    }

    /**
    * inserPromotionData
    *
    * @return void
    */     
    private function inserPromotionData()
    {
        $arr = [
            [
            'promotion_id' => 1, 'promotion_identifier' => 'vivek', 'promotion_user_id' => 1, 'promotion_type' => 1, 'promotion_record_id' => 1, 'promotion_budget'=>1, 'promotion_cpc' => 1, 'promotion_duration' => 0, 'promotion_start_date' => '2021-01-25', 'promotion_end_date' => '2021-01-29', 'promotion_start_time' => '00:00:00', 'promotion_end_time' => '00:00:00', 'promotion_active' => 1, 'promotion_added_on' => '2021-01-29 00:00:00', 'promotion_approved' => 1, 'promotion_deleted' => 0
            ]
        ];
        $this->InsertDbData(Promotion::DB_TBL, $arr);
    }

    /**
    * inserPromotionLangData
    *
    * @return void
    */ 
    private function inserPromotionLangData()
    {
        $arr = [
            [
                'promotionlang_promotion_id' => 1, 'promotionlang_lang_id' => 1, 'promotion_name' => 'Test'
            ],
        ];            
        $this->InsertDbData(Promotion::DB_TBL_LANG, $arr);
    }

    /**
     * @test
     *
     * @dataProvider feedGetPromotionCostPerClick
     * @param  int $promotionType
     * @param  int $blocation_id
     * @return void
     */
    public function getPromotionCostPerClick($expected, $promotionType, $blocation_id)
    {
        $result = $this->execute($this->class, [], 'getPromotionCostPerClick', [$promotionType, $blocation_id]);
        $this->assertIsArray($result);
        CommonHelper::printArray($result, 1);
        $this->assertEquals($expected, $result['addr_id']);
    }    
    /**
     * feedGetPromotionCostPerClick
     *
     * @return array
    */
    public function feedGetPromotionCostPerClick()
    {  
        return [
            [0, 'test', 0],   //Invalid promotionType
            [0, 1, 0],   //Valid promotionType     
        ];
    } 
}