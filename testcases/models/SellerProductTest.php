<?php
class SellerProductTest extends YkModelTest
{
    private $class = 'SellerProduct';

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
        $obj->insertSellerProductData();
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
        FatApp::getDb()->query("TRUNCATE TABLE ".SellerProduct::DB_TBL);
    }
    
    private function insertUserData()
    {
        $arr = [
            [
            'credential_user_id'=>1, 'credential_username'=>'vivek', 'credential_email'=>'vivek.kumar@fatbit.in', 'credential_password'=>'Welcome@123', 'credential_active'=>1, 'credential_verified'=>1
            ]
        ];
        $this->InsertDbData(User::DB_TBL_CRED, $arr);

        $arr = [
            [
            'user_id'=>1, 'user_name'=>'vivek_seller', 'user_dial_code'=>'+91', 'user_phone'=>'9501496955', 'user_deleted'=>0,'user_id_seller'=>1
            ]
        ];
        $this->InsertDbData(User::DB_TBL, $arr);
    }

    private function insertSellerProductData()
    {
        $arr = [
            [
                'product_id' => 0, 'product_identifier' => 'test unit product', 'product_type' => 1, 'product_brand_id' => 111, 'product_min_selling_price' => 280, 'product_approved' => 1, 'product_active' => 1, 'product_added_by_admin_id' => 0, 'product_model' => 'test prod', 'product_featured' => 1, 'product_cod_enabled' => 0, 'product_dimension_unit' => 2, 'product_length' => 20, 'product_width' => 30, 'product_height' => 40, 'product_weight_unit' => 2, 'product_weight' => 10
            ]
        ];
        $this->InsertDbData(User::DB_TBL_CRED, $arr);
        
    }
}