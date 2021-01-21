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
        FatApp::getDb()->query("TRUNCATE TABLE ".Promotion::DB_TBL);
        FatApp::getDb()->query("TRUNCATE TABLE ".Promotion::DB_TBL_LANG);
    }
    
    private function inserPromotionData()
    {
        $arr = [
            [
            'promotion_id' => 1, 'promotion_identifier' => 'vivek', 'promotion_user_id' => 'vivek.kumar@fatbit.in', 'promotion_type' => 'Welcome@123', 'promotion_record_id' => 1, 'promotion_budget'=>1, 'promotion_cpc' => 1, 'promotion_duration' => '', 'promotion_start_date' => '', 'promotion_end_date' => '', 'promotion_start_time' => '', 'promotion_end_time' => '', 'promotion_active' => '', 'promotion_added_on' => '', 'promotion_approved' => '', 'promotion_deleted' => ''
            ]
        ];
        $this->InsertDbData(Promotion::DB_TBL, $arr);
    }
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
     * @dataProvider feedGetDefaultByRecordId
     * @param  int $type
     * @param  int $recordId
     * @param  int $langId
     * @return void
     */
    public function getDefaultByRecordId($expected, $type, $recordId, $langId)
    {
        $this->expectedReturnType(YkAppTest::TYPE_ARRAY);
        $result = $this->execute($this->class, [], 'getDefaultByRecordId', [$type, $recordId, $langId]);
        $this->assertIsArray($result);
        $this->assertEquals($expected, $result['addr_id']);
    }    
    /**
     * feedGetDefaultByRecordId
     *
     * @return array
    */
    public function feedGetDefaultByRecordId()
    {  
        return [
            [0, 'test', 1, 1],   //Invalid type, valid recordId, valid langId,
            [0, 1, 'test', 1],   //Valid type, Invalid recordId, valid langId
            [0, 1, 1, 'test'],   //Valid type, valid recordId, Invalid langId
            [1, 1, 1, 1],   //Valid type, valid recordId, valid langId
        ];
    } 
}