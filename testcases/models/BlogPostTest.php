<?php
class BlogPostTest extends YkModelTest
{
    private $class = 'BlogPost';

    /**
     * setUpBeforeClass
     *
     * @return void
     */
    public static function setUpBeforeClass() :void
    { 
        self::truncateDbData();
        $obj = new self();
        $obj->insertBlogPostData();
        $obj->insertBlogPostLangData(); 
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
        FatApp::getDb()->query("TRUNCATE TABLE ".BlogPost::DB_TBL);
        FatApp::getDb()->query("TRUNCATE TABLE ".BlogPost::DB_TBL_LANG);
    }    
    
    /**
    * insertBlogPostData
    *
    * @return void
    */
    private function insertBlogPostData()
    {
        $arr = [
            [
                'post_id' => 1,
                'post_identifier' => 'Test Blog 1',
                'post_published' => 1,
                'post_comment_opened' => 1,  
                'post_featured' => 0, 
                'post_view_count' => 0, 
                'post_deleted' => 0, 
            ],
            [
                'post_id' => 2,
                'post_identifier' => 'Test Blog 2',
                'post_published' => 1,
                'post_comment_opened' => 1,  
                'post_featured' => 1, 
                'post_view_count' => 0, 
                'post_deleted' => 0, 
                
            ],
            [
                'post_id' => 2,
                'post_identifier' => 'Test Blog 3',
                'post_published' => 1,
                'post_comment_opened' => 1,  
                'post_featured' => 1, 
                'post_view_count' => 0, 
                'post_deleted' => 1, 
                
            ]
        ];            
        $this->InsertDbData(BlogPost::DB_TBL, $arr);
    }
    
    /**
    * insertBlogPostLangData
    *
    * @return void
    */
    private function insertBlogPostLangData()
    {
        $arr = [
            [
                'postlang_post_id' => 1,
                'postlang_lang_id' => 1,
                'post_author_name' => 'Test User 1',
                'post_title' => 'Test Blog 1',
                'post_short_description' => 'Test Blog 1 Short Description',
                'post_description' => 'Test Blog 1 Long Description',                         
            ],
            [
                'postlang_post_id' => 2,
                'postlang_lang_id' => 1,
                'post_author_name' => 'Test User 2',
                'post_title' => 'Test Blog 2',
                'post_short_description' => 'Test Blog 2 Short Description',
                'post_description' => 'Test Blog 2 Long Description', 
            ],
        ];            
        $this->InsertDbData(BlogPost::DB_TBL_LANG, $arr);
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
    
}
