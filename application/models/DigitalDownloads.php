<?php

class DigitalDownloads extends MyAppModel
{
    public const DB_TBL = 'tbl_product_digital_downloads';
    public const DB_TBL_PREFIX = 'pdd_';

    public function __construct($productId, $id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX, $id);
        $this->productId = $productId;
    }
    
    public function saveDownloadReferences($optionsCode, $links)
    {
        if ($this->productId < 1) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', $this->commonLangId);
            return false;
        }

        $dataToSave = array(
            'pdd_product_id' => $this->productId,
            'pdd_options_code' => $optionsCode,
            'pdd_ext_links' => $links
        );

        $onDuplicateDataToSave = [
            'pdd_ext_links' => $links
        ];

        if (!FatApp::getDb()->insertFromArray(static::DB_TBL, $dataToSave, false, array(), $onDuplicateDataToSave)) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        $this->setMainTableRecordId(FatApp::getDb()->getInsertId());
        return true;
    }

    public static function allowedWithCatalog($productId)
    {
        /* $product = Product::getAttributesById($productId, ['product_download_attachements_with_inventory']);
        return ($product['product_download_attachements_with_inventory'] == applicationConstants::NO ? applicationConstants::YES : applicationConstants::NO); */
    }
}
