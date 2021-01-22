<?php
class CountriesTest extends YkModelTest
{
    private $class = 'Countries';

    /**
     * setUpBeforeClass
     *
     * @return void
     */
    public static function setUpBeforeClass() :void
    { 
        self::truncateDbData();
        $obj = new self();
        $obj->insertCountriesData();
        $obj->insertCountriesLangData();
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
        FatApp::getDb()->query("TRUNCATE TABLE ".Countries::DB_TBL);
    }
    
    private function insertCountriesData()
    {
        $arr = [
            [
                'country_id'=>1, 'country_code'=>'AL', 'country_code_alpha3'=>'ALB', 'country_active'=>1, 'country_zone_id'=>2, 'country_currency_id'=>0, 'country_language_id'=>0
            ],
            [
                'country_id'=>1, 'country_code'=>'AF', 'country_code_alpha3'=>'AFG', 'country_active'=>1, 'country_zone_id'=>4, 'country_currency_id'=>0, 'country_language_id'=>0
            ],
            [
                'country_id'=>1, 'country_code'=>'DZ', 'country_code_alpha3'=>'DZA', 'country_active'=>0, 'country_zone_id'=>1, 'country_currency_id'=>0, 'country_language_id'=>0
            ]
        ];
        $this->InsertDbData(Countries::DB_TBL, $arr);
       
    }
    private function insertCountriesLangData()
    {
        $arr = [
            [
                'countrylang_country_id'=>1, 'countrylang_lang_id'=>'AL', 'country_name'=>'ALB'
            ],
            [
                'countrylang_country_id'=>2, 'countrylang_lang_id'=>'AF', 'country_name'=>'AFG'
            ],
            [
                'countrylang_country_id'=>3, 'countrylang_lang_id'=>'DZ', 'country_name'=>'DZA'
            ],
        ];
        $this->InsertDbData(Countries::DB_TBL_LANG, $arr);
       
    }

    /**
     * @test
     *
     * @dataProvider feedGetCountriesArr
     * @param  int $langId
     * @param  int $isActive
     * @param  string $idCol
     * @return void
     */
    public function getCountriesArr($expected, $langId, $isActive, $idCol)
    {
        $this->expectedReturnType(YkAppTest::TYPE_ARRAY);
        $result = $this->execute($this->class, [], 'getCountriesArr', [$langId, $isActive, $idCol]);
        $this->assertIsArray($result);
        $this->assertEquals($expected, count($result));
    }    
    /**
     * feedGetCountriesArr
     *
     * @return array
    */
    public function feedGetCountriesArr()
    {  
        return [
            [0, 'test', 0, ''],   //Invalid langId, valid recordId, expected 0 country
            [0, 1, 'test', ''],   //Valid langId, Invalid isActive, expected 0 country
            [2, 1, true, ''],   //Valid type, valid recordId, Invalid langId, expected 2 countries
            [1, 1, false, ''],   //Valid type, valid recordId, valid langId, expected 1 country
        ];
    } 

}