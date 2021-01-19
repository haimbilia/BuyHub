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
                'bpcategory_parent'         => 2,
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
        $this->expectedReturnType(YkAppTest::TYPE_INT);
        $result = $this->execute($this->class, [], 'getMaxOrder', [$parentId]);
        $this->assertIsInt($result);
    }    
    /**
     * provideGetMaxOrder
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

    /**
     * testGetCategoryStructure
     *
     * @dataProvider providerGetCategoryStructure
     * @param  mixed $bpcategory_id
     * @param  mixed $category_tree_array
     * @return void
     */
    public function testGetCategoryStructure($bpcategory_id, $category_tree_array)
    {
        $this->expectedReturnType(YkAppTest::TYPE_ARRAY);
        $result = $this->execute($this->class, [], 'getCategoryStructure', [$bpcategory_id, $category_tree_array]);
        $this->assertIsArray($result);
    }
    
    /**
     * providerGetCategoryStructure
     *
     * @return array
     */
    public function providerGetCategoryStructure()
    {  
        return [            
            ['test', array()],  // Invalid bpcategory_id  
            [9, array()],  // Valid bpcategory_id
        ];
    }

    /**
     * testIsExistBlogPostCatLang
     *
     * @dataProvider providerIsExistBlogPostCatLang
     * @param  mixed $lang_id
     * @param  mixed $bpcategory_id
     * @return void
     */
    public function testIsExistBlogPostCatLang($expected, $lang_id, $bpcategory_id)
    {
        $this->expectedReturnType(YkAppTest::TYPE_BOOL);
        $result = $this->execute($this->class, [], 'isExistBlogPostCatLang', [$lang_id, $bpcategory_id]);
        $this->assertEquals($expected, $result);
    }
    
    /**
     * providerIsExistBlogPostCatLang
     *
     * @return array
     */
    public function providerIsExistBlogPostCatLang()
    {  
        return [            
            [false, 'test', 'test'],  // Invalid lang_id, Invalid bpcategory_id
            [false, 'test', 1],  // Invalid lang_id, Valid bpcategory_id
            [false, 1, 'test'],  // Valid lang_id, Invalid bpcategory_id
            [true, 1, 1],  // Valid lang_id, Valid bpcategory_id
        ];
    }

    /**
     * testGetParentTreeStructure
     *
     * @dataProvider providerGetParentTreeStructure
     * @param  mixed $bpcategory_id
     * @param  mixed $level
     * @param  mixed $name_suffix
     * @return void
     */
    public function testGetParentTreeStructure($expected, $bpcategory_id, $level, $name_suffix)
    {
        $this->expectedReturnType(YkAppTest::TYPE_STRING);
        $result = $this->execute($this->class, [], 'getParentTreeStructure', [$bpcategory_id, $level, $name_suffix]);
        $this->assertEquals($expected, $result);
    }
    
    /**
     * providerGetParentTreeStructure
     *
     * @return array
     */
    public function providerGetParentTreeStructure()
    {  
        return [            
            ['', 'test', 0, ''],  // Invalid bpcategory_id, Valid level, Blank suffix   
            ['Blog Category 2 &nbsp;&nbsp;&raquo;&raquo;&nbsp;&nbsp;Blog Sub Category 1', 9, 0, ''],  // Valid bpcategory_id, Valid level, Blank suffix   
        ];
    }

    /**
     * testGetBlogPostCatAutoSuggest
     *
     * @dataProvider providerGetBlogPostCatAutoSuggest
     * @param  mixed $keyword
     * @param  mixed $limit
     * @return void
     */
    public function testGetBlogPostCatAutoSuggest($keyword, $limit)
    {
        $this->expectedReturnType(YkAppTest::TYPE_ARRAY);
        $result = $this->execute($this->class, [], 'getBlogPostCatAutoSuggest', [$keyword, $limit]);
        $this->assertIsArray($result);
    }
    
    /**
     * providerGetBlogPostCatAutoSuggest
     *
     * @return array
     */
    public function providerGetBlogPostCatAutoSuggest()
    {  
        return [      
            ['test', 10],  // Valid keyword   
        ];
    }

    /**
     * testGetNestedArray
     *
     * @dataProvider providerGetNestedArray
     * @param  mixed $langId
     * @return void
     */
    public function testGetNestedArray($langId)
    {
        $this->expectedReturnType(YkAppTest::TYPE_ARRAY);
        $result = $this->execute($this->class, [], 'getNestedArray', [$langId]);
        $this->assertIsArray($result);
    }
    
    /**
     * providerGetNestedArray
     *
     * @return array
     */
    public function providerGetNestedArray()
    {  
        return [      
            ['test'],  // Invalid langId   
            [1],  // Valid langId
        ];
    }

    /**
     * testGetBlogPostCatParentChildWiseArr
     *
     * @dataProvider providerGetBlogPostCatParentChildWiseArr
     * @param  mixed $langId
     * @return void
     */
    public function testGetBlogPostCatParentChildWiseArr($langId, $parentId, $includeChildCat, $forSelectBox)
    {
        $this->expectedReturnType(YkAppTest::TYPE_ARRAY);
        $result = $this->execute($this->class, [], 'getBlogPostCatParentChildWiseArr', [$langId, $parentId, $includeChildCat, $forSelectBox]);
        $this->assertIsArray($result);
    }
    
    /**
     * providerGetBlogPostCatParentChildWiseArr
     *
     * @return array
     */
    public function providerGetBlogPostCatParentChildWiseArr()
    {  
        return [      
            ['test', 0, false, false],  // Return blank array, Invalid langId   
            [1, 0, 'test', 'test'],  // Return blank array, Valid langId, valid parentId,  Invalid includeChildCat, invalid forSelectBox
            [1, 0, false, 'test'],  // Return blank array, Valid langId, valid parentId,  Invalid includeChildCat, invalid forSelectBox
            [1, 0, 'test', false],  // Return array, Valid langId  
            [1, 0, true, false],  // Return array, Valid langId 
            [1, 0, false, true],  // Return array, Valid langId 
            [1, 0, false, false],  // Return array, Valid langId   
            [1, 0, true, true],  // Return array, Valid langId   
            [1, 2, true, true],  // Return array, Valid langId
        ];
    }

    /**
     * testGetRootBlogPostCatArr
     *
     * @dataProvider providerGetRootBlogPostCatArr
     * @param  mixed $langId
     * @return void
     */
    public function testGetRootBlogPostCatArr($langId)
    {
        $this->expectedReturnType(YkAppTest::TYPE_ARRAY);
        $result = $this->execute($this->class, [], 'getRootBlogPostCatArr', [$langId]);
        $this->assertIsArray($result);
    }
    
    /**
     * providerGetRootBlogPostCatArr
     *
     * @return array
     */
    public function providerGetRootBlogPostCatArr()
    {  
        return [      
            ['test'],  // Invalid langId   
            [1],  // Valid langId
        ];
    }

    /**
     * testGetCategoriesForSelectBox
     *
     * @dataProvider providerGetCategoriesForSelectBox
     * @param  mixed $langId
     * @param  mixed $ignoreCategoryId
     * @return void
     */
    public function testGetCategoriesForSelectBox($langId, $ignoreCategoryId)
    {
        $this->expectedReturnType(YkAppTest::TYPE_ARRAY);
        $result = $this->execute($this->class, [], 'getCategoriesForSelectBox', [$langId, $ignoreCategoryId]);
        $this->assertIsArray($result);
    }
    
    /**
     * providerGetCategoriesForSelectBox
     *
     * @return array
     */
    public function providerGetCategoriesForSelectBox()
    {  
        return [      
            ['test', 0],  //Return blank array, Invalid langId   
            [1, 1],  // Return array, Valid langId
        ];
    }

    /**
     * testGetFeaturedCategories
     *
     * @dataProvider providerGetFeaturedCategories
     * @param  mixed $langId
     * @return void
     */
    public function testGetFeaturedCategories($langId)
    {
        $this->expectedReturnType(YkAppTest::TYPE_ARRAY);
        $result = $this->execute($this->class, [], 'getFeaturedCategories', [$langId]);
        $this->assertIsArray($result);
    }
    
    /**
     * providerGetFeaturedCategories
     *
     * @return array
     */
    public function providerGetFeaturedCategories()
    {  
        return [      
            ['test'],  //Return blank array, Invalid langId   
            [1],  // Return array, Valid langId
        ];
    }       
}
