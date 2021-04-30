<?php

class DigitalDownloads extends MyAppModel
{
    public const DB_TBL = 'tbl_product_digital_data_relation';
    public const DB_TBL_PREFIX = 'pddr_';
    
    public const DB_TBL_LINKS = 'tbl_product_digital_links';
    public const DB_TBL_LINKS_PREFIX = 'pdl_';

    public function __construct($productId, $productOption, $id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX, $id);
        $this->productId = $productId;
        $this->productOption = $productOption;
    }

    public function getReferenceId()
    {
        $srch = new DigitalDownloadsSearch();
        $srch->addCondition(static::DB_TBL_PREFIX . 'product_id', '=', $this->productId);
        $srch->addCondition(static::DB_TBL_PREFIX . 'options_code', '=', $this->productOption);

        $srch->setPageSize(1);
        $srch->doNotCalculateRecords();

        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        $ddRefId = 0;
        if (is_array($row)) {
            $ddRefId = $row['pddr_id'];
        }

        return $ddRefId;
    }
    
    public function saveDownloadReferences($optionsCode)
    {
        if ($this->productId < 1) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', $this->commonLangId);
            return false;
        }

        $dataToSave = array(
            static::DB_TBL_PREFIX . 'product_id' => $this->productId,
            static::DB_TBL_PREFIX . 'options_code' => $optionsCode,
        );

        $this->assignValues($dataToSave);
        if (!$this->save()) {
            return false;
        }
        return true;
    }

    public function saveDownloadLinks($refId, $langId, $downloadLink, $previewLink, $id = 0)
    {
        if ($refId < 1) {
            $this->error = Labels::getLabel('ERR_Invalid_Request', $this->commonLangId) . __LINE__ . 'saveDownloadLinks';
            return false;
        }

        $dataToSave = array(
            static::DB_TBL_LINKS_PREFIX . 'record_id' => $refId,
            static::DB_TBL_LINKS_PREFIX . 'lang_id' => $langId,
            static::DB_TBL_LINKS_PREFIX . 'download_link' => $downloadLink,
            static::DB_TBL_LINKS_PREFIX . 'preview_link' => $previewLink,
        );

        if (1 > $id) {
            if (!FatApp::getDb()->insertFromArray(static::DB_TBL_LINKS, $dataToSave)) {
                $this->error = FatApp::getDb()->getError();
                return false;
            }
        } else {
            $whr = ['smt' => static::DB_TBL_LINKS_PREFIX . 'id = ?',
                'vals' => [$id],
            ];
            if (!FatApp::getDb()->updateFromArray(static::DB_TBL_LINKS, $dataToSave, $whr)) {
                $this->error = FatApp::getDb()->getError();
                return false;
            }
        }
        return true;
    }

    public static function allowedWithCatalog($productId)
    {
        /* $product = Product::getAttributesById($productId, ['product_download_attachements_with_inventory']);
        return ($product['product_download_attachements_with_inventory'] == applicationConstants::NO ? applicationConstants::YES : applicationConstants::NO); */
    }
}
