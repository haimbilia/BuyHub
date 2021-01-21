<?php
class FaqTest extends YkModelTest
{
    private $class = 'Faq';

    /**
     * setUpBeforeClass
     *
     * @return void
     */
    public static function setUpBeforeClass() :void
    { 
        self::truncateDbData();
        $obj = new self();
        $obj->insertFaqData();
        $obj->insertFaqLangData();
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
        FatApp::getDb()->query("TRUNCATE TABLE ".Faq::DB_TBL);
        FatApp::getDb()->query("TRUNCATE TABLE ".Faq::DB_TBL_LANG);
    }
    /**
    * insertFaqData
    *
    * @return void
    */
    private function insertFaqData()
    {
        $arr = [
            [
            'faq_id'=>1, 'faq_faqcat_id' => 1, 'faq_identifier' => 'TestFaq1', 'faq_active' => 1,'faq_deleted'=>0, 'faq_display_order' => 1,
            'faq_featured' => 1
            ]
        ];
        $this->InsertDbData(Faq::DB_TBL, $arr);       
    }
    /**
    * insertFaqLangData
    *
    * @return void
    */
    private function insertFaqLangData()
    {
        $arr = [
            [
                'faqlang_faq_id' => 1, 'faqlang_lang_id' => 1, 'faq_title'=> 'Test', 'faq_content'=> 'Test'
            ],
        ];            
        $this->InsertDbData(Faq::DB_TBL_LANG, $arr);
    }

    /**
     * @test
     *
     * @dataProvider feedGetMaxOrder
     * @return void
     */
    public function getMaxOrder($expected)
    {
        $this->expectedReturnType(YkAppTest::TYPE_INT);
        $result = $this->execute($this->class, [], 'getMaxOrder');
        $this->assertEquals($expected, $result);
    }
    /**
     * feedGetMaxOrder
     *
     * @return array
     */
    public function feedGetMaxOrder()
    {
        return [
            [2]
        ];
    } 
}