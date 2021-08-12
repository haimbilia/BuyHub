<?php

class DigitalDownloadPrivilages extends FatModel
{
    private $product = [];
    private $productRequest = [];
    private $sellerProduct = [];

    public function __construct($id = 0)
    {
        parent::__construct(DigitalDownload::DB_TBL);
    }

    public function canEdit($recordId, $recordType = 0, $sellerUserId = 0, $langId = 0, $validateAllowedWithInventory = true, $isAdmin = false)
    {
        $recordId = FatUtility::int($recordId);
        $sellerUserId = FatUtility::int($sellerUserId);
        $langId = FatUtility::int($langId);

        if (1 > $langId) {
            $langId = CommonHelper::getLangId();
        }
        
        if (Product::CATALOG_TYPE_REQUEST == $recordType) {
            /* Marketplace requested Product - by seller*/
            $this->getProductRequest($recordId);
            
            if (!is_array($this->productRequest) || 1 > count($this->productRequest)) {
                $this->error = Labels::getLabel('MSG_INVALID_REQUEST', $langId);
                return false;
            }
            
            if ($this->productRequest['preq_status'] == ProductRequest::STATUS_APPROVED || $this->productRequest['preq_deleted'] == applicationConstants::YES) {
                $this->error = Labels::getLabel('MSG_INVALID_REQUEST', $langId);
                return false;
            }

            $this->product = json_decode($this->productRequest['preq_content'], true);
            
            if (!is_array($this->product) || 1 > count($this->product)) {
                $this->error = Labels::getLabel('MSG_INVALID_REQUEST', $langId);
                return false;
            }
            if (!array_key_exists('product_attachements_with_inventory', $this->product)) {
                $this->product['product_attachements_with_inventory'] = applicationConstants::YES;
            }
        } else {
            if (Product::CATALOG_TYPE_INVENTORY == $recordType) {
                /* Seller Inventroy*/
                $this->getSellerProduct($recordId, false);

                if (!is_array($this->sellerProduct) || 1 > count($this->sellerProduct)) {
                    $this->error = Labels::getLabel('MSG_INVALID_REQUEST', $langId);
                    return false;
                }

                /* $inventoryId = $recordId; Can be used id required further. As of now no need*/
                $recordId = $this->sellerProduct['selprod_product_id'];
            }

            $this->getProduct($recordId);
            if (!is_array($this->product) || 1 > count($this->product)) {
                $this->error = Labels::getLabel('MSG_INVALID_REQUEST', $langId);
                return false;
            }
        }

        if (Product::PRODUCT_TYPE_DIGITAL != $this->product['product_type']) {
            $this->error = Labels::getLabel('LBL_Attachments_or_links_allowed_only_with_digital_products', $langId);
            return false;
        }

        if (true === $isAdmin) {
            switch ($recordType) {
                case Product::CATALOG_TYPE_INVENTORY:
                    $this->error = Labels::getLabel('LBL_Not_Authorised_to_upload_with_inventory', $langId);
                    return false;
                    break;
                case Product::CATALOG_TYPE_REQUEST:
                    return true;
                    break;
                case Product::CATALOG_TYPE_PRIMARY:
                    if (0 < $this->product['product_seller_id']) {
                        $this->error = Labels::getLabel('LBL_Not_Authorised_to_upload_with_seller_private_catalog', $langId);
                        return false;
                    }
                    return true;
                    break;
                default:
                    $this->error = Labels::getLabel('LBL_Invalid_Request', $langId);
                    return false;
                    break;
            }
        }
        /* To check whether product belogs to logged seller? */
        if (0 < $sellerUserId) {
            if (Product::CATALOG_TYPE_INVENTORY == $recordType) {
                /* Seller Inventory */
                $recordOwnerId = $this->sellerProduct['selprod_user_id'];
            } else { /* Catalog product */
                $recordOwnerId = $this->product['product_seller_id'];
            }

            if ($recordOwnerId != $sellerUserId) {
                $this->error = Labels::getLabel('MSG_INVALID_REQUEST', $langId);
                return false;
            }
        }
        if (true == $validateAllowedWithInventory) {
            if (applicationConstants::YES == $this->product['product_attachements_with_inventory']) {
                $this->error = Labels::getLabel('LBL_Attachments_or_links_allowed_with_inventory', $langId);
                return true;
            } else {
                $this->error = Labels::getLabel('LBL_Attachments_or_links_Not_allowed_with_inventory', $langId);
                return false;
            }
        }
        
        if (applicationConstants::YES == $this->product['product_attachements_with_inventory']) {
            $this->error = Labels::getLabel('LBL_Attachments_or_links_allowed_with_inventory', $langId);
            return false;
        } else {
            $this->error = Labels::getLabel('LBL_Attachments_or_links_allowed_with_Product', $langId);
            return true;
        }
    }

    public function allowedWithInventory($productId)
    {
        $productId = FatUtility::int($productId);

        $this->getProduct($productId);

        if (!is_array($this->product) || 1 > count($this->product)) {
            return false;
        }

        if (applicationConstants::YES == $this->product['product_attachements_with_inventory']) {
            return true;
        }
        
        return false;
    }

    public function getProduct($productId)
    {
        if (1 > $productId) {
            return [];
        }
        
        if (!empty($this->product)) {
            return $this->product;
        }

        $this->product = (array) Product::getAttributesById($productId);

        return $this->product;
    }

    public function getSellerProduct($sellerProdId, $includeProductDetail = true, $active = false, $deleted = false)
    {
        if (1 > $sellerProdId) {
            return [];
        }
        
        if (null != $this->sellerProduct) {
            return $this->sellerProduct;
        }

        $attrs = [
            'selprod_id',
            'selprod_user_id',
            'selprod_product_id',
            'selprod_code',
            'selprod_active',
            'selprod_deleted'
        ];

        if (true === $includeProductDetail) {
            $attrs = $attrs + ['product_id',
                'product_type',
                'product_added_by_admin_id',
                'product_seller_id',
                'product_attachements_with_inventory',
                'product_active',
                'product_approved',
                'product_deleted'
            ];
        }

        $srch = SellerProduct::getSearchObject();

        $srch->joinTable(Product::DB_TBL, 'LEFT JOIN', Product::DB_TBL_PREFIX . 'id = ' . SellerProduct::DB_TBL_PREFIX . 'product_id');

        $srch->addCondition('sp.selprod_id', '=', $sellerProdId);
        if (true === $active) {
            $srch->addCondition('sp.selprod_active', '=', applicationConstants::ACTIVE);
        }
        if (true === $deleted) {
            $srch->addCondition('sp.selprod_deleted', '=', applicationConstants::NO);
        }

        $srch->addMultipleFields($attrs);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        
        $rs = $srch->getResultSet();
        $this->sellerProduct = FatApp::getDb()->fetch($rs);

        if (false === $this->sellerProduct) {
            $this->sellerProduct = [];
        }

        return $this->sellerProduct;
    }

    public function canDownload($recordId, $recordType, $sellerUserId, $langId, $isPreview = 0, $isAdmin = false)
    {
        if (1 === $isPreview) {
            return true;
        }

        switch ($recordType) {
            case Product::CATALOG_TYPE_PRIMARY:
                $this->getProduct($recordId);
                if (1 > count($this->product)) {
                    $this->error = Labels::getLabel("LBL_Invalid_Request", $langId);
                    return false;
                }
                
                if ($this->product['product_seller_id'] !== $sellerUserId) {
                    $this->error = Labels::getLabel("MSG_INVALID_ACCESS", $langId);
                    return false;
                }
                return true;
                break;
            case Product::CATALOG_TYPE_REQUEST:
                if (true === $isAdmin) {
                    return true;
                }
                $this->getProductRequest($recordId);
                if (1 > count($this->productRequest)
                    || ProductRequest::STATUS_APPROVED == $this->productRequest['preq_status']
                    || applicationConstants::YES == $this->productRequest['preq_deleted']
                ) {
                    $this->error = Labels::getLabel("LBL_Invalid_Request", $langId);
                    return false;
                }

                if ($this->productRequest['preq_user_id'] !== $sellerUserId) {
                    $this->error = Labels::getLabel("MSG_INVALID_ACCESS", $langId);
                    return false;
                }
                return true;
                break;
            case Product::CATALOG_TYPE_INVENTORY:
                $this->getSellerProduct($recordId);

                if (1 > count($this->sellerProduct)) {
                    $this->error = Labels::getLabel("LBL_Invalid_Request", $langId);
                    return false;
                }

                if ($this->sellerProduct['selprod_user_id'] !== $sellerUserId) {
                    $this->error = Labels::getLabel("MSG_INVALID_ACCESS", $langId);
                    return false;
                }

                $this->getProduct($this->sellerProduct['selprod_product_id']);
                if (1 > count($this->product)) {
                    $this->error = Labels::getLabel("LBL_Invalid_Request", $langId);
                    return false;
                }
                
                if (applicationConstants::NO == $this->product['product_attachements_with_inventory']
                    && $this->product['product_seller_id'] !== $sellerUserId
                    && applicationConstants::NO == $isPreview
                ) {
                    $this->error = Labels::getLabel("LBL_Unauthorized_Access", $langId);
                    return false;
                }
                return true;
                break;
            default:
                $this->error = Labels::getLabel("LBL_Invalid_Request", $langId);
                return false;
                break;
        }
    }

    public function getProductRequest($customProdId)
    {
        if (1 > $customProdId) {
            return [];
        }
        
        if (null != $this->productRequest) {
            return $this->productRequest;
        }

        $attrs = [
            'preq_id',
            'preq_user_id',
            'preq_content',
            'preq_content',
            'preq_deleted',
            'preq_status',
        ];

        $this->productRequest = ProductRequest::getAttributesById($customProdId, $attrs);

        if (false === $this->productRequest) {
            $this->productRequest = null;
            return [];
        }

        return $this->productRequest;
    }
}
