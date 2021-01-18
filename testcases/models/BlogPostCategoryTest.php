<?php
class BlogPostCategoryTest extends YkModelTest
{
    private $class = 'BlogPostCategory';

    /**
     * setUpBeforeClass
     *
     * @return void
     */
    public static function setUpBeforeClass() :void
    { 
        self::truncateDbData();
        $obj = new self();
        $obj->insertBlogPostCategoryData();
        $obj->insertBlogPostCategoryLangData();
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
        FatApp::getDb()->query("TRUNCATE TABLE ".BlogPostCategory::DB_TBL);
        FatApp::getDb()->query("TRUNCATE TABLE ".BlogPostCategory::DB_TBL_LANG);
    }    
    /**
    * insertBlogPostCategoryData
    *
    * @return void
    */
    private function insertBlogPostCategoryData()
    {
        $arr = [
            [
                'bpcategory_id'             => 1,
                'bpcategory_identifier'     => 'Blog Category 1',
                'bpcategory_parent'         => 0,
                'bpcategory_display_order'  => 1,  
                'bpcategory_featured'       => 0, 
                'bpcategory_active'         => 0, 
                'bpcategory_deleted'        => 0, 
            ],
            [
                'bpcategory_id'             => 2,
                'bpcategory_identifier'     => 'Blog Category 2',
                'bpcategory_parent'         => 0,
                'bpcategory_display_order'  => 2,  
                'bpcategory_featured'       => 0, 
                'bpcategory_active'         => 1, 
                'bpcategory_deleted'        => 0, 
            ],
            [
                'bpcategory_id'             => 3,
                'bpcategory_identifier'     => 'Blog Category 3',
                'bpcategory_parent'         => 0,
                'bpcategory_display_order'  => 3,  
                'bpcategory_featured'       => 0, 
                'bpcategory_active'         => 0, 
                'bpcategory_deleted'        => 1, 
            ],
            [
                'bpcategory_id'             => 4,
                'bpcategory_identifier'     => 'Blog Category 4',
                'bpcategory_parent'         => 0,
                'bpcategory_display_order'  => 4,  
                'bpcategory_featured'       => 1, 
                'bpcategory_active'         => 0, 
                'bpcategory_deleted'        => 0, 
            ],
            [
                'bpcategory_id'             => 5,
                'bpcategory_identifier'     => 'Blog Category 5',
                'bpcategory_parent'         => 0,
                'bpcategory_display_order'  => 5,  
                'bpcategory_featured'       => 1, 
                'bpcategory_active'         => 1, 
                'bpcategory_deleted'        => 0, 
            ],
            [
                'bpcategory_id'             => 6,
                'bpcategory_identifier'     => 'Blog Category 6',
                'bpcategory_parent'         => 0,
                'bpcategory_display_order'  => 6,  
                'bpcategory_featured'       => 1, 
                'bpcategory_active'         => 0, 
                'bpcategory_deleted'        => 1, 
            ],
            [
                'bpcategory_id'             => 7,
                'bpcategory_identifier'     => 'Blog Category 7',
                'bpcategory_parent'         => 0,
                'bpcategory_display_order'  => 7,  
                'bpcategory_featured'       => 1, 
                'bpcategory_active'         => 1, 
                'bpcategory_deleted'        => 1, 
            ],
            [
                'bpcategory_id'             => 8,
                'bpcategory_identifier'     => 'Blog Category 8',
                'bpcategory_parent'         => 0,
                'bpcategory_display_order'  => 8,  
                'bpcategory_featured'       => 0, 
                'bpcategory_active'         => 1, 
                'bpcategory_deleted'        => 1, 
            ],
            [
                'bpcategory_id'             => 9,
                'bpcategory_identifier'     => 'Blog Sub Category 1',
                'bpcategory_parent'         => 1,
                'bpcategory_display_order'  => 9,  
                'bpcategory_featured'       => 0, 
                'bpcategory_active'         => 1, 
                'bpcategory_deleted'        => 0, 
            ],
        ];            
        $this->InsertDbData(BlogPostCategory::DB_TBL, $arr);
    }

    /**
    * insertBlogPostCategoryData
    *
    * @return void
    */
    private function insertBlogPostCategoryLangData()
    {
        $arr = [
            [
                'bpcategorylang_bpcategory_id'  => 1,
                'bpcategorylang_lang_id'        => 1,
                'bpcategory_name'               => 'Blog Category 1', 
            ],
            [
                'bpcategorylang_bpcategory_id'  => 2,
                'bpcategorylang_lang_id'        => 1,
                'bpcategory_name'               => 'Blog Category 2',
                
            ],
            [
                'bpcategorylang_bpcategory_id'  => 3,
                'bpcategorylang_lang_id'        => 1,
                'bpcategory_name'               => 'Blog Category 3', 
            ],
            [
                'bpcategorylang_bpcategory_id'  => 4,
                'bpcategorylang_lang_id'        => 1,
                'bpcategory_name'               => 'Blog Category 4',
                
            ],
            [
                'bpcategorylang_bpcategory_id'  => 5,
                'bpcategorylang_lang_id'        => 1,
                'bpcategory_name'               => 'Blog Category 5', 
            ],
            [
                'bpcategorylang_bpcategory_id'  => 6,
                'bpcategorylang_lang_id'        => 1,
                'bpcategory_name'               => 'Blog Category 6',
                
            ],
            [
                'bpcategorylang_bpcategory_id'  => 7,
                'bpcategorylang_lang_id'        => 1,
                'bpcategory_name'               => 'Blog Category 7', 
            ],
            [
                'bpcategorylang_bpcategory_id'  => 8,
                'bpcategorylang_lang_id'        => 1,
                'bpcategory_name'               => 'Blog Category 8',
                
            ],
            [
                'bpcategorylang_bpcategory_id'  => 9,
                'bpcategorylang_lang_id'        => 1,
                'bpcategory_name'               => 'Blog Sub Category 1', 
            ]   
        ];            
        $this->InsertDbData(BlogPostCategory::DB_TBL_LANG, $arr);
    } 
    /**
     * testGetMaxOrder
     *
     * @dataProvider provideGetMaxOrder
     * @param  mixed $parentId
     * @return void
     */
    public function testGetMaxOrder($parentId)
    {
        $result = $this->execute($this->class, [], 'getMaxOrder', [$parentId]);
        $this->assertIsInt($result);
    }    
    /**
     * providerGetBrandName
     *
     * @return array
    */
    public function provideGetMaxOrder()
    {  
        return [
            [100], // Invalid parentId
            [1], // Valid parentId
            [0], // Valid blank parentId      
        ];
    }
}
