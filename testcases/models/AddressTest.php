<?php
class AddressTest extends YkModelTest
{
    private $class = 'Address';

    /**
     * setUpBeforeClass
     *
     * @return void
     */
    public static function setUpBeforeClass() :void
    { 
        self::truncateDbData();
        $obj = new self();
        $obj->insertAddressData();
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
        FatApp::getDb()->query("TRUNCATE TABLE ".Address::DB_TBL);
    }
    
    private function insertAddressData()
    {
        $arr = [
            [
                'addr_id'           => 1,
                'addr_type'         => 1,
                'addr_record_id'    => 1,
                'addr_added_by'     => 0,  
                'addr_lang_id'      => 1, 
                'addr_title'        => 'AblySoft', 
                'addr_name'         => 'Vivek', 
                'addr_address1'     => 'Plot no 268, JLPL industrial area, Sector 82', 
                'addr_address2'     => 'Mohali', 
                'addr_city'         => 'Mohali', 
                'addr_state_id'     => '1294',
                'addr_country_id'   => '99', 
                'addr_phone'        => '9843000000', 
                'addr_zip'          => '160055',
                'addr_lat'          => '', 
                'addr_lng'          => '', 
                'addr_is_default'   => 1, 
                'addr_deleted'      => 0, 

            ],
        ];            
        $this->InsertDbData(Address::DB_TBL, $arr);
    }

    /**
     * testGetDefaultByRecordId
     *
     * @dataProvider provideGetDefaultByRecordId
     * @param  mixed $type
     * @param  mixed $recordId
     * @param  mixed $langId
     * @return void
     */
    public function testGetDefaultByRecordId($type, $recordId, $langId)
    {
        $this->expectedReturnType(YkAppTest::TYPE_ARRAY);
        $result = $this->execute($this->class, [], 'getDefaultByRecordId', [$type, $recordId, $langId]);
        $this->assertIsArray($result);
    }    
    /**
     * provideGetDefaultByRecordId
     *
     * @return array
    */
    public function provideGetDefaultByRecordId()
    {  
        return [
            ['test', 1, 1],   //Invalid type, valid recordId, valid langId,
            [1, 'test', 1],   //Valid type, Invalid recordId, valid langId
            [1, 1, 'test'],   //Valid type, valid recordId, Invalid langId
            [1, 1, 1],   //Valid type, valid recordId, valid langId
        ];
    } 

    /**
     * testGetData
     *
     * @dataProvider provideGetData
     * @param  mixed $type
     * @param  mixed $recordId
     * @param  mixed $isDefault
     * @param  mixed $joinTimeSlots
     * @return void
     */
    public function testGetData($type, $recordId, $isDefault, $joinTimeSlots)
    {
        $this->expectedReturnType(YkAppTest::TYPE_ARRAY);
        $result = $this->execute($this->class, [], 'getData', [$type, $recordId, $isDefault, $joinTimeSlots]);
        $this->assertIsArray($result);
    }    
    /**
     * provideGetData
     *
     * @return array
    */
    public function provideGetData()
    {  
        return [
            ['test', 1, 0, false],   //Invalid type, valid recordId, valid isDefault, valid joinTimeSlots
            [1, 'test', 1, false],   //Valid type, Invalid recordId, valid isDefault, valid joinTimeSlots
            [1, 1, 'test', false],   //Valid type, valid recordId, Invalid isDefault, valid joinTimeSlots
            [1, 1, 0, false],       //Valid type, valid recordId, valid isDefault, valid joinTimeSlots
        ];
    } 

    /**
     * testDeleteByRecordId
     *
     * @dataProvider provideDeleteByRecordId
     * @param  mixed $type
     * @param  mixed $recordId
     * @param  mixed $isDefault
     * @param  mixed $joinTimeSlots
     * @return void
     */
    public function testDeleteByRecordId($expected, $type, $recordId)
    {
        $this->expectedReturnType(YkAppTest::TYPE_BOOL);
        $result = $this->execute($this->class, [], 'deleteByRecordId', [$type, $recordId]);
        $this->assertEquals($expected, $result);
    }    
    /**
     * provideDeleteByRecordId
     *
     * @return array
    */
    public function provideDeleteByRecordId()
    {  
        return [
            [false, 'test', 1],   //Invalid type, valid recordId
            [false, 1, 'test'],   //Valid type, Invalid recordId
            [false, 'test', 'test'],   //Invalid type, Invalid recordId
            [true, 1, 1],       //Valid type, valid recordId
        ];
    }

    /**
     * testGetGeoData
     *
     * @dataProvider provideGetGeoData
     * @param  mixed $lat
     * @param  mixed $long
     * @param  mixed $countryCode
     * @param  mixed $stateCode
     * @return void
     */
    public function testGetGeoData($lat, $long, $countryCode, $stateCode, $zipCode, $address)
    {
        $this->expectedReturnType(YkAppTest::TYPE_ARRAY);
        $result = $this->execute($this->class, [], 'getGeoData', [$lat, $long, $countryCode, $stateCode, $zipCode, $address]);
        $this->assertIsArray($result);
    }    
    /**
     * provideGetGeoData
     *
     * @return array
    */
    public function provideGetGeoData()
    {  
        return [
            ['test', 'test', 0, 0, 0, ''],  //Return array, invalid lat, invalid long  
            ['test', '70.1', 0, 0, 0, ''],  //Return array, invalid lat, valid long        
            ['30.2', '70.1', 0, 0, 0, ''],  //Return array, valid lat, valid long       
        ];
    }

}