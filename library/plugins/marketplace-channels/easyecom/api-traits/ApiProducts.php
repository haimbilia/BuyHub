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
        $srch->joinTable(Product::DB_TBL_LANG, 'LEFT JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $this->langId, 'p_l');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields([
            'selprod_id',
            'COALESCE(selprod_title, product_identifier) as selprod_title',
            'selprod_price',
            'selprod_sku',
            'selprod_user_id',
            'selprod_stock',
            'selprod_fulfillment_type'
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
            $srch->joinTable(OptionValue::DB_TBL . '_lang', 'LEFT JOIN', 'ov_lang.optionvaluelang_optionvalue_id = ov.optionvalue_id AND ov_lang.optionvaluelang_lang_id = ' . $this->langId, 'ov_lang');
            $srch->joinTable(Option::DB_TBL, 'INNER JOIN', 'o.option_id = ov.optionvalue_option_id', 'o');
            $srch->joinTable(Option::DB_TBL . '_lang', 'LEFT JOIN', 'o.option_id = o_lang.optionlang_option_id AND o_lang.optionlang_lang_id = ' . $this->langId, 'o_lang');
            $srch->addMultipleFields([
                'COALESCE(option_name, option_identifier) as name',
                'COALESCE(optionvalue_name, optionvalue_identifier) as value',
                'selprodoption_optionvalue_id as value_id'
            ]);
            $srch->addCondition('selprodoption_selprod_id', '=', $row['selprod_id']);
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
        $productGroupImages = array();
        $productImagesArr = [];
        foreach ($options as &$optionRow) {
            $images = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_PRODUCT_IMAGE, $productId, $optionRow['value_id'], $this->langId, true, '', $count);
            if ($images) {
                $productImagesArr += $images;
            }
        }

        if (count($productImagesArr) > 0) {
            foreach ($productImagesArr as $image) {
                $afileId = $image['afile_id'];
                if (!array_key_exists($afileId, $productGroupImages)) {
                    $productGroupImages[$afileId] = array();
                }
                $productGroupImages[$afileId] = $image;
            }
        }

        if (isset($count) && $count > 0) {
            $universal_allowed_images_count = $count - count($productImagesArr);
        }

        $productUniversalImagesArr = array();
        if (empty($productGroupImages) || isset($universal_allowed_images_count)) {
            $universalImages = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_PRODUCT_IMAGE, $productId, -1, $this->langId, true, '');

            if ($universalImages) {
                $productUniversalImagesArr = $universalImages;
                if (isset($universal_allowed_images_count)) {
                    $images = array_slice($universalImages, 0, $universal_allowed_images_count);
                    $productUniversalImagesArr = $images;
                    $universal_allowed_images_count = $universal_allowed_images_count - count($productUniversalImagesArr);
                }
            }
        }

        if ($productUniversalImagesArr) {
            foreach ($productUniversalImagesArr as $image) {
                $afileId = $image['afile_id'];
                if (!array_key_exists($afileId, $productGroupImages)) {
                    $productGroupImages[$afileId] = array();
                }
                $productGroupImages[$afileId] = $image;
            }
        }

        $imageArr = [];
        foreach ($productGroupImages as $recordId => $row) {
            $imageArr[] = [
                'id' => $row['afile_id'],
                'src' => UrlHelper::generateFullFileUrl('Image', 'product', [$recordId, ImageDimension::VIEW_ORIGINAL, 0, $row['afile_id']]),
                'thumb_src' => UrlHelper::generateFullFileUrl('Image', 'product', [$recordId, ImageDimension::VIEW_THUMB, 0, $row['afile_id']]),
            ];
        }

        return $imageArr;
    }

    /**
     * getProducts
     * 
     * @return array
     */
    public function getProducts(array $post): array
    {
        $this->db = FatApp::getDb();
        $page = !isset($post['page']) || 1 > $post['page'] ? 1 : $post['page'];

        $pagesize = FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 50);
        $pagesize = isset($post['pagesize']) ? $post['pagesize'] : $pagesize;

        $srch = Product::getSearchObject($this->langId);
        $srch->joinTable(Product::DB_PRODUCT_SHIPPED_BY_SELLER, 'LEFT JOIN', 'psbs.psbs_product_id = tp.product_id', 'psbs');
        $srch->joinTable(SellerProduct::DB_TBL, 'INNER JOIN', 'tp.product_id = sp.selprod_product_id', 'sp');
        $srch->joinTable(Product::DB_TBL_PRODUCT_TO_CATEGORY, 'LEFT JOIN', 'tp.product_id = ptc_product_id', 'ptc');
        $srch->joinTable(ProductCategory::DB_TBL, 'LEFT JOIN', 'ptc.ptc_prodcat_id = pc.prodcat_id', 'pc');
        $srch->joinTable(ProductCategory::DB_TBL_LANG, 'LEFT JOIN', 'pc.prodcat_id = pc_l.prodcatlang_prodcat_id AND pc_l.prodcatlang_lang_id = ' . $this->langId, 'pc_l');
        $srch->joinTable(Brand::DB_TBL, 'LEFT JOIN', 'tp.product_brand_id = brand.brand_id', 'brand');
        $srch->joinTable(Brand::DB_TBL_LANG, 'LEFT JOIN', 'brand.brand_id = tb_l.brandlang_brand_id AND brandlang_lang_id = ' . $this->langId, 'tb_l');
        $srch->addCondition('product_active', '=', applicationConstants::ACTIVE);
        $srch->addCondition('product_approved', '=', applicationConstants::YES);
        $srch->addCondition('selprod_user_id', '=', $this->userId);

        $cnd = $srch->addCondition('psbs_user_id', '=', $this->userId);
        $cnd->attachCondition('product_seller_id', '=', $this->userId);

        $srch->addMultipleFields([
            'product_id',
            'COALESCE(product_name, product_identifier) as product_name',
            'brand_id',
            'COALESCE(brand_name, brand_identifier) as brand_name',
            'product_description',
            'product_added_on',
            'product_updated_on',
            'COALESCE(pc_l.prodcat_name, pc.prodcat_identifier) as prodcat_name'
        ]);

        $srch->addOrder('product_added_on', 'DESC');
        $srch->addGroupBy('product_id');
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $products = $this->db->fetchAll($rs);

        foreach ($products as &$row) {
            $productId = FatUtility::int($row['product_id']);
            $sellerProducts = $this->getSellerProducts($productId);

            $this->addOptionsArr($sellerProducts);
            foreach ($sellerProducts as &$selprodRow) {
                $count = -1;
                if (FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE', FatUtility::VAR_INT, 0)) {
                    $currentPlanData = OrderSubscription::getUserCurrentActivePlanDetails($this->langId, $selprodRow['selprod_user_id'], ['ossubs_images_allowed']);
                    $count = $currentPlanData['ossubs_images_allowed'];
                }
                unset($selprodRow['selprod_user_id']);
                $selprodRow['images'] = $this->getImagesArr($selprodRow['options'], $productId, $count);
            }

            $row['product_description'] = strip_tags($row['product_description']);
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
        return $this->formatOutput(Plugin::RETURN_TRUE, $msg, $data);
    }

    /**
     * updateProductStockQty
     * 
     * @param int $selProdId 
     * @param int $balanceQty
     * @return array
     */
    public function updateProductStockQty(int $selProdId, int $balanceQty): array
    {
        $selProdId = FatUtility::int($selProdId);
        $balanceQty = FatUtility::int($balanceQty);

        if (1 > $selProdId || 0 > $balanceQty) {
            $msg = Labels::getLabel("MSG_INVALID_REQUEST", $this->langId);
            return $this->formatOutput(Plugin::RETURN_FALSE, $msg);
        }

        $db = FatApp::getDb();
        $db->query("UPDATE " . SellerProduct::DB_TBL . " 
            SET selprod_sold_count = 
                CASE 
                    WHEN selprod_stock = " . $balanceQty . " 
                    THEN selprod_sold_count
                    ELSE (selprod_sold_count + (selprod_stock - " . $balanceQty . "))
                END,
            selprod_stock = " . $balanceQty . ",
            selprod_track_inventory = 1,
            selprod_subtract_stock = 1 
            WHERE selprod_id = '" . $selProdId . "'
            AND selprod_user_id = " . $this->userId);
        $msg = Labels::getLabel("MSG_SUCCESS", $this->langId);
        return $this->formatOutput(Plugin::RETURN_TRUE, $msg);
    }
}
