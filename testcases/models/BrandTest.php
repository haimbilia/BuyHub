<?php
class BrandTest extends YkModelTest
{
    private $class = 'Brand';

    /**
     * setUpBeforeClass
     *
     * @return void
     */
    public static function setUpBeforeClass() :void
    { 
        self::truncateDbData();
        $obj = new self();
        $obj->insertBrandData();
        $obj->insertBrandLangData(); 
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
        FatApp::getDb()->query("TRUNCATE TABLE ".Brand::DB_TBL);
        FatApp::getDb()->query("TRUNCATE TABLE ".Brand::DB_TBL_LANG);
    }
    
    /**
    * insertBrandData
    *
    * @return void
    */
    private function insertBrandData()
    {
        $arr = [
            [
                'brand_id' => 1,
                'brand_identifier' => 'Samsung',
                'brand_seller_id' => 0,
                'brand_active' => 1,  
            ],
            [
                'brand_id' => 2,
                'brand_identifier' => 'Apple',
                'brand_seller_id' => 0,
                'brand_active' => 0,  
            ]
        ];            
        $this->InsertDbData(Brand::DB_TBL, $arr);
    }
    
    /**
    * insertBrandLangData
    *
    * @return void
    */
    private function insertBrandLangData()
    {
        $arr = [
            [
                'brandlang_brand_id' => 1,
                'brandlang_lang_id' => 1,
                'brand_name' => 'Samsung',
                'brand_short_description' => 'Samsung',
                         
            ],
            [
                'brandlang_brand_id' => 2,
                'brandlang_lang_id' => 1,
                'brand_name' => 'Apple',
                'brand_short_description' => 'Apple',
            ],
        ];            
        $this->InsertDbData(Brand::DB_TBL_LANG, $arr);
    } 
    
    /**
     * testGetAllIdentifierAssoc
     *
     * @dataProvider providerGetAllIdentifierAssoc
     * @param  mixed $langId
     * @param  mixed $isDeleted
     * @param  mixed $isActive
     * @return void
     */
    public function testGetAllIdentifierAssoc($langId, $isDeleted, $isActive)
    {
        $result = $this->execute($this->class, [], 'getAllIdentifierAssoc', [$langId, $isDeleted, $isActive]);
        $this->assertIsArray($result);
    }
    
    /**
     * providerGetAllIdentifierAssoc
     *
     * @return array
     */
    public function providerGetAllIdentifierAssoc()
    {  
        return [
            [1, false, true],  // Valid langId , valid isDeleted, valid isActive   
        ];
    }

    /**
     * testGetBrandName
     *
     * @dataProvider providerGetBrandName
     * @param  mixed $expected
     * @param  mixed $brandId
     * @param  mixed $langId
     * @param  mixed $isActive
     * @return void
     */
    public function testGetBrandName($expected, $brandId, $langId, $isActive)
    {
        $result = $this->execute($this->class, [], 'getBrandName', [$brandId, $langId, $isActive]);
        $this->assertEquals($expected, $result);
    }
    
    /**
     * providerGetBrandName
     *
     * @return array
     */
    public function providerGetBrandName()
    {  
       return [
            [false, 'test', 'test', true], // Invalid brandId and Invalid langId
            [false, 'test', 1, true], // Invalid brandId and Valid langId
            [false, 1, 'test', true], // Valid brandId and Invalid langId      
            ['Samsung', 1, 1, true],  // Valid brandId and Valid langId
            ['Apple', 2, 1, false],  // Valid brandId and Valid langId        
        ];
    }
    
}
