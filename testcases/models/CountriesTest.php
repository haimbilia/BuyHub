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
                'country_id'=>1, 'country_code'=>'DZ', 'country_code_alpha3'=>'DZA', 'country_active'=>1, 'country_zone_id'=>1, 'country_currency_id'=>0, 'country_language_id'=>0
            ]
        ];
        $this->InsertDbData(Countries::DB_TBL, $arr);
       
    }
    private function insertCountriesLangData()
    {
        $arr = [
            [
                'country_id'=>1, 'country_code'=>'AL', 'country_code_alpha3'=>'ALB', 'country_active'=>1, 'country_zone_id'=>2, 'country_currency_id'=>0, 'country_language_id'=>0
            ],
            [
                'country_id'=>1, 'country_code'=>'AF', 'country_code_alpha3'=>'AFG', 'country_active'=>1, 'country_zone_id'=>4, 'country_currency_id'=>0, 'country_language_id'=>0
            ],
            [
                'country_id'=>1, 'country_code'=>'DZ', 'country_code_alpha3'=>'DZA', 'country_active'=>1, 'country_zone_id'=>1, 'country_currency_id'=>0, 'country_language_id'=>0
            ]
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
            [0, 'test', 1, 1],   //Invalid type, valid recordId, valid langId,
            [0, 1, 'test', 1],   //Valid type, Invalid recordId, valid langId
            [0, 1, 1, 'test'],   //Valid type, valid recordId, Invalid langId
            [1, 1, 1, 1],   //Valid type, valid recordId, valid langId
        ];
    } 

    /**
     * @test
     *
     * @dataProvider feedGetData
     * @param  int $type
     * @param  int $recordId
     * @param  int $isDefault
     * @param  bool $joinTimeSlots
     * @return void
     */
    public function getData($type, $recordId, $isDefault, $joinTimeSlots)
    {
        $this->expectedReturnType(YkAppTest::TYPE_ARRAY);
        $result = $this->execute($this->class, [], 'getData', [$type, $recordId, $isDefault, $joinTimeSlots]);
        $this->assertIsArray($result);
    }    
    /**
     * feedGetData
     *
     * @return array
    */
    public function feedGetData()
    {  
        return [
            ['test', 1, 0, false],   //Invalid type, valid recordId, valid isDefault, valid joinTimeSlots
            [1, 'test', 1, false],   //Valid type, Invalid recordId, valid isDefault, valid joinTimeSlots
            [1, 1, 'test', false],   //Valid type, valid recordId, Invalid isDefault, valid joinTimeSlots
            [1, 1, 0, false],       //Valid type, valid recordId, valid isDefault, valid joinTimeSlots
        ];
    } 

    /**
     * @test
     *
     * @dataProvider feedDeleteByRecordId
     * @param  int $type
     * @param  int $recordId
     * @return void
     */
    public function deleteByRecordId($expected, $type, $recordId)
    {
        $this->expectedReturnType(YkAppTest::TYPE_BOOL);
        $result = $this->execute($this->class, [], 'deleteByRecordId', [$type, $recordId]);
        $this->assertEquals($expected, $result);
    }    
    /**
     * feedDeleteByRecordId
     *
     * @return array
    */
    public function feedDeleteByRecordId()
    {  
        return [
            [false, 'test', 1],   //Invalid type, valid recordId
            [false, 1, 'test'],   //Valid type, Invalid recordId
            [false, 'test', 'test'],   //Invalid type, Invalid recordId
            [true, 1, 1],       //Valid type, valid recordId
        ];
    }

    /**
     * @test
     *
     * @dataProvider feedGetGeoData
     * @param  mixed $lat
     * @param  mixed $long
     * @param  mixed $countryCode
     * @param  mixed $stateCode
     * @param  mixed $zipCode
     * @param  mixed $address
     * @return void
     */
    public function getGeoData($lat, $long, $countryCode, $stateCode, $zipCode, $address)
    {
        $this->expectedReturnType(YkAppTest::TYPE_ARRAY);
        $result = $this->execute($this->class, [], 'getGeoData', [$lat, $long, $countryCode, $stateCode, $zipCode, $address]);
        CommonHelper::printArray($result, 1);
        $this->assertIsArray($result);
    }    
    /**
     * feedGetGeoData
     *
     * @return array
    */
    public function feedGetGeoData()
    { 
        return [
            ['test', 'test', 0, 0, 0, ''],  //Return array, invalid lat, invalid long  
            ['test', '70.1', 0, 0, 0, ''],  //Return array, invalid lat, valid long        
            ['30.2', '70.1', 0, 0, 0, ''],  //Return array, valid lat, valid long       
        ];
    }

}