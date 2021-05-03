<?php
class ShippedProducts extends SearchBase
{
    public function __construct(int $selProd = 0)
    {
        if($selProd == applicationConstants::YES) {
            parent::__construct(SellerProduct::DB_TBL, 'sp');
        }else {
            parent::__construct(ShippingProfileProduct::DB_TBL, 'sppro');
        }
    }
    public function joinProduct(int $joinSellerProd = 0)
    {
        if($joinSellerProd == applicationConstants::YES) {
            $this->joinTable(Product::DB_TBL, 'LEFT OUTER JOIN', 'tp.product_id = sp.selprod_product_id', 'tp');
        }else {
            $this->joinTable(Product::DB_TBL, 'LEFT OUTER JOIN', 'tp.product_id = sppro.shippro_product_id', 'tp');
        }
    }

    public function joinProductLang(int $landId = 0)
    {
        $this->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN','productlang_product_id = tp.product_id	AND productlang_lang_id = ' . $landId, 'tp_l');
    }

    public function joinShippingProfile()
    {
        $this->joinTable(ShippingProfile::DB_TBL, 'LEFT OUTER JOIN', 'sppro.shippro_shipprofile_id = spprof.shipprofile_id and spprof.shipprofile_active = ' . applicationConstants::YES, 'spprof');
    }
    
    public function joinUserTable()
    {
        $this->joinTable('tbl_users', 'LEFT OUTER JOIN', 'u.user_id = sp.selprod_user_id', 'u');
    }

    public function joinShippedBySeller()
    {
        $this->joinTable(Product::DB_PRODUCT_SHIPPED_BY_SELLER, 'INNER JOIN', 'psbs.psbs_product_id = tp.product_id and psbs.psbs_user_id = sp.selprod_user_id', 'psbs');
    }

    public function addProductByAdminCondition()
    {
        $this->addCondition('product_added_by_admin_id', '=', applicationConstants::YES);
    }

    public function addProductDeletedCondition()
    {
        $this->addCondition('tp.product_deleted', '=', applicationConstants::NO);
    }

    public function addProductAdminShipCondition()
    {
        $this->addCondition('sppro.shippro_user_id', '=', '0');
    }

    public function addPhyProductCheckCondition()
    {
        $this->addCondition('tp.product_type', '=', Product::PRODUCT_TYPE_PHYSICAL);
    }
}