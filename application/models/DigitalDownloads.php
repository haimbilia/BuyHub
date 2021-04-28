<?php

class DigitalDownloads extends FatModel
{
    public const DB_TBL = 'tbl_product_digital_downloads';

    public function __construct($productId, $id = 0)
    {
        parent::__construct();
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

        if (!FatApp::getDb()->insertFromArray(static::DB_TBL, $dataToSave, false, array(), ['pdd_ext_links' => $links])) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return true;
    }
}
