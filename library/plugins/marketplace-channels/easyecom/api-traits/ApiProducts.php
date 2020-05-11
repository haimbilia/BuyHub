<?php

trait ApiProducts
{
    /**
     * getSellerProducts
     * 
     * @param int $productId 
     * @return array
     */
    private function getSellerProducts(int $productId): array
    {
        $srch = SellerProduct::getSearchObject($this->langId);
        $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
        $srch->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $this->langId, 'p_l');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields([
            'selprod_id as variant_id',
            'COALESCE(selprod_title, product_identifier) as title',
            'selprod_price as price',
            'selprod_sku as sku',
            'selprod_user_id',
            'selprod_stock as stock'
        ]);
        $srch->addCondition('selprod_deleted', '=', 0);
        $srch->addCondition('selprod_active', '=', applicationConstants::ACTIVE);
        $srch->addCondition('sp.selprod_product_id', '=', $productId);
        $rs = $srch->getResultSet();
        return $this->db->fetchAll($rs);
    }

    /**
     * addOptionsArr
     * 
     * @param array &$sellerProducts 
     * @return bool
     */
    private function addOptionsArr(array &$sellerProducts): bool
    {
        foreach ($sellerProducts as &$row) {
            $srch = new SearchBase(SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, 'spo');
            $srch->joinTable(OptionValue::DB_TBL, 'INNER JOIN', 'spo.selprodoption_optionvalue_id = ov.optionvalue_id', 'ov');
            $srch->joinTable(OptionValue::DB_TBL . '_lang', 'LEFT OUTER JOIN', 'ov_lang.optionvaluelang_optionvalue_id = ov.optionvalue_id AND ov_lang.optionvaluelang_lang_id = ' . $this->langId, 'ov_lang');
            $srch->joinTable(Option::DB_TBL, 'INNER JOIN', 'o.option_id = ov.optionvalue_option_id', 'o');
            $srch->joinTable(Option::DB_TBL . '_lang', 'LEFT OUTER JOIN', 'o.option_id = o_lang.optionlang_option_id AND o_lang.optionlang_lang_id = ' . $this->langId, 'o_lang');
            $srch->addMultipleFields([
                'COALESCE(option_name, option_identifier) as name',
                'COALESCE(optionvalue_name, optionvalue_identifier) as value',
                'selprodoption_optionvalue_id as value_id'
            ]);
            $srch->addCondition('selprodoption_selprod_id', '=', $row['variant_id']);
            $rs = $srch->getResultSet();
            $row['options'] = $this->db->fetchAll($rs);
        }
        return true;
    }

    /**
     * getImagesArr
     * 
     * @param array $options 
     * @param int $productId 
     * @param int $count 
     * @return array
     */
    private function getImagesArr(array $options, int $productId, int $count): array
    {
        $productImagesArr = [];
        foreach ($options as &$optionRow) {
            $images = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_PRODUCT_IMAGE, $productId, $optionRow['value_id'], $this->langId, true, '', $count);
            foreach ($images as $recordId => $row) {
                $productImagesArr[] = [
                    'id' => $row['afile_id'],
                    'src' => CommonHelper::generateFullUrl('Image', 'product', [$recordId, 'ORIGINAL', 0, $row['afile_id']]),
                    'thumb_src' => CommonHelper::generateFullUrl('Image', 'product', [$recordId, 'THUMB', 0, $row['afile_id']]),
                ];
            }
        }
        return $productImagesArr;
    }

    /**
     * getProducts
     * 
     * @return array
     */
    public function getProducts(): array
    {
        $this->db = FatApp::getDb();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        
        $pagesize = FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 50);
        $pagesize = FatApp::getPostedData('pagesize', FatUtility::VAR_INT, $pagesize);

        $srch = Product::getSearchObject($this->langId);
        $srch->joinTable(SellerProduct::DB_TBL, 'INNER JOIN', 'tp.product_id = sp.selprod_product_id', 'sp');
        $srch->joinTable(Product::DB_TBL_PRODUCT_TO_CATEGORY, 'LEFT OUTER JOIN', 'tp.product_id = ptc_product_id', 'ptc');
        $srch->joinTable(ProductCategory::DB_TBL, 'LEFT OUTER JOIN', 'ptc.ptc_prodcat_id = pc.prodcat_id', 'pc' );
        $srch->joinTable(ProductCategory::DB_TBL_LANG, 'LEFT OUTER JOIN', 'pc.prodcat_id = pc_l.prodcatlang_prodcat_id AND pc_l.prodcatlang_lang_id = '. $this->langId, 'pc_l' );

        $srch->addCondition('product_active', '=', applicationConstants::ACTIVE);
        $srch->addCondition('product_approved', '=', applicationConstants::YES);

        $srch->addMultipleFields([
            'product_id as id',
            'COALESCE(product_name, product_identifier) as title',
            'product_description as description',
            'product_added_on as created_date',
            'product_updated_on as updated_date',
            'COALESCE(pc_l.prodcat_name, pc.prodcat_identifier) as category'
        ]);

        $srch->addOrder('product_added_on', 'DESC');
        $srch->addGroupBy('product_id');
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $rs = $srch->getResultSet();
        $products = $this->db->fetchAll($rs);

        foreach ($products as &$row) {
            $productId = FatUtility::int($row['id']);
            $sellerProducts = $this->getSellerProducts($productId);
            $this->addOptionsArr($sellerProducts);
            $selprodRow['images'] = [];
            foreach ($sellerProducts as &$selprodRow) {
                $count = -1;
                if (FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE')) {
                    $currentPlanData = OrderSubscription::getUserCurrentActivePlanDetails($this->langId, $selprodRow['selprod_user_id'], ['ossubs_images_allowed']);
                    $count = $currentPlanData['ossubs_images_allowed'];
                }
                unset($selprodRow['selprod_user_id']);

                $selprodRow['images'] = $this->getImagesArr($selprodRow['options'], $productId, $count);
            }

            $row['description'] = strip_tags($row['description']);
            $row['variants'] = $sellerProducts;
        }

        $data = [
            'status' => (0 < count($products)) ?  1 : 0,
            'pagination' => [
                'total_pages' => $srch->pages(),
                'page_size' => $pagesize,
                'current_page' => $page,
                'record_count' => $srch->recordCount()
            ],
            'products' => $products
        ];

        $msg = Labels::getLabel("MSG_SUCCESS", $this->langId);
        return $this->formatOutput(true, $msg, $data);
    }
}
