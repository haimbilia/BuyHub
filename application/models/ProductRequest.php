<?php

class ProductRequest extends MyAppModel
{
    public const DB_TBL = 'tbl_product_requests';
    public const DB_TBL_LANG = 'tbl_product_requests_lang';
    public const DB_TBL_PREFIX = 'preq_';
    public const DB_TBL_LANG_PREFIX = 'preqlang_';
    public const STATUS_PENDING = 0;
    public const STATUS_APPROVED = 1;
    public const STATUS_CANCELLED = 2;

    private $db;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
    }

    public static function getStatusArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }
        return array(
            static::STATUS_PENDING => Labels::getLabel('LBL_PENDING', $langId),
            static::STATUS_APPROVED => Labels::getLabel('LBL_APPROVED', $langId),
            static::STATUS_CANCELLED => Labels::getLabel('LBL_CANCELLED', $langId),
        );
    }

    public static function getStatusClassArr()
    {
        return array(
            static::STATUS_PENDING => applicationConstants::CLASS_INFO,
            static::STATUS_APPROVED => applicationConstants::CLASS_SUCCESS,
            static::STATUS_CANCELLED => applicationConstants::CLASS_DANGER,
        );
    }

    public static function getSearchObject($langId = 0, $deleted = false, $submittedForApproval = false)
    {
        $langId = FatUtility::int($langId);
        $srch = new SearchBase(static::DB_TBL, 'preq');
        if ($langId) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'preq_l.' . static::DB_TBL_LANG_PREFIX . 'preq_id = preq.' . static::tblFld('id') . ' and
			preq_l.' . static::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                'preq_l'
            );
        }

        if ($deleted == false) {
            $srch->addCondition(static::tblFld('deleted'), '=', applicationConstants::NO);
        }

        if ($submittedForApproval == true) {
            $srch->addCondition(static::tblFld('submitted_for_approval'), '=', applicationConstants::YES);
        }

        return $srch;
    }

    public static function getDataArr($preqId, $attr)
    {
        $row_data = static::getAttributesById($preqId, $attr);
        $productData = json_decode($row_data['preq_content'], true);
        unset($row_data['preq_content']);
        $row_data = array_merge($row_data, $productData);
        return $row_data;
    }

    public function deleteProductImage($recordId, $image_id , $fileType = 0)
    {
        $recordId = FatUtility :: int($recordId);
        $image_id = FatUtility :: int($image_id);
        if ($recordId < 1 || $image_id < 1) {
            $this->error = 'Invalid Request!';
            return false;
        }

        if ($fileType == AttachedFile::FILETYPE_CUSTOM_PRODUCT_IMAGE_TEMP) {
            $fileHandlerObj = new AttachedFileTemp();
        } else {
            $fileHandlerObj = new AttachedFile();
            $fileType = AttachedFile::FILETYPE_CUSTOM_PRODUCT_IMAGE;
        }        
       
        if (!$fileHandlerObj->deleteFile($fileType, $recordId, $image_id)) {
            $this->error = $fileHandlerObj->getError();
            return false;
        }
        return true;
    }

    public function updateProdImagesOrder($preq_id, $fileType = AttachedFile::FILETYPE_CUSTOM_PRODUCT_IMAGE, $order)
    {
        $preq_id = FatUtility :: int($preq_id);
        if (is_array($order) && sizeof($order) > 0) {
            foreach ($order as $i => $id) {
                if (FatUtility::int($id) < 1) {
                    continue;
                }
                if ($fileType == AttachedFile::FILETYPE_CUSTOM_PRODUCT_IMAGE_TEMP) {
                    FatApp::getDb()->updateFromArray('tbl_attached_files_temp', array('afile_display_order' => $i), array('smt' => 'afile_type = ? AND afile_record_id = ? AND afile_id = ?', 'vals' => array($fileType, $preq_id, $id)));
                } else {
                    FatApp::getDb()->updateFromArray('tbl_attached_files', array('afile_display_order' => $i), array('smt' => 'afile_type = ? AND afile_record_id = ? AND afile_id = ?', 'vals' => array(AttachedFile::FILETYPE_CUSTOM_PRODUCT_IMAGE, $preq_id, $id)));
                }
            }
            return true;
        }
        return false;
    }

    public static function getProductReqOptions($preq_id, $lang_id, $includeOptionValues = false, $option_is_separate_images = 0)
    {
        $preq_id = FatUtility::convertToType($preq_id, FatUtility::VAR_INT);
        $lang_id = FatUtility::convertToType($lang_id, FatUtility::VAR_INT);
        if (!$preq_id || !$lang_id) {
            trigger_error(Labels::getLabel("ERR_ARGUMENTS_NOT_SPECIFIED.", CommonHelper::getLangId()), E_USER_ERROR);
            return false;
        }

        $data = array();
        $productReqRow = static::getAttributesById($preq_id);
        $productData = json_decode($productReqRow['preq_content'], true);
        if (!empty($productData['product_option'])) {
            $optionSrch = Option::getSearchObject($lang_id);
            $optionSrch->addMultipleFields(array('IFNULL(option_name,option_identifier) as option_name', 'option_id'));
            $optionSrch->doNotCalculateRecords();
            $optionSrch->doNotLimitRecords();
            $optionSrch->addCondition('option_id', 'in', $productData['product_option']);
            $rs = $optionSrch->getResultSet();
            $db = FatApp::getDb();
            //$option = FatApp::getDb()->fetchAll($rs);
            while ($row = $db->fetch($rs)) {
                if ($includeOptionValues) {
                    $row['optionValues'] = Product::getOptionValues($row['option_id'], $lang_id);
                }
                $data[] = $row;
            }
            return $data;
        } else {
            return [];
        }
    }

    public static function getProductShippingRates($preq_id, $lang_id, $country_id = 0, $sellerId = 0, $limit = 0)
    {
        $preq_id = FatUtility::convertToType($preq_id, FatUtility::VAR_INT);
        $lang_id = FatUtility::convertToType($lang_id, FatUtility::VAR_INT);
        $sellerId = FatUtility::convertToType($sellerId, FatUtility::VAR_INT);
        if (!$preq_id || !$lang_id) {
            return false;
        }

        $productReqRow = ProductRequest::getAttributesById($preq_id, array('preq_content', 'preq_user_id'));
        $productData = json_decode($productReqRow['preq_content'], true);
        $shippingRates = array();


        if ($sellerId > 0 && array_key_exists('product_seller_shipping', $productData)) {
            $shippingArr = $productData['product_seller_shipping'];
        } else {
            $shippingArr = array_key_exists('product_shipping', $productData) ? $productData['product_shipping'] : array();
        }
        /* CommonHelper::printArray($shippingArr); die; */
        if (!empty($shippingArr)) {
            $count = 0;

            foreach ($shippingArr as $val) {
                if (!array_key_exists('country_id', $val)) {
                    continue;
                }
                $shippingRates[$count] = $val;
                $shippingRates[$count]['pship_id'] = $count;
                $shippingRates[$count]['pship_country'] = $val['country_id'];
                $shippingRates[$count]['pship_user_id'] = $productReqRow['preq_user_id'];
                $shippingRates[$count]['pship_company'] = $val['company_id'];
                $shippingRates[$count]['pship_duration'] = $val['processing_time_id'];
                $shippingRates[$count]['pship_charges'] = $val['cost'];
                $shippingRates[$count]['pship_additional_charges'] = $val['additional_cost'];
                $shippingRates[$count]['country_name'] = $val['country_name'];

                $shipCompSrch = ShippingCompanies::getListingObj(
                    $lang_id,
                    array('ifNull(' . ShippingCompanies::DB_TBL_PREFIX . 'name', ShippingCompanies::DB_TBL_PREFIX . 'identifier) as ' . ShippingCompanies::DB_TBL_PREFIX . 'name',
                                    ShippingCompanies::DB_TBL_PREFIX . 'id',
                                    ShippingCompanies::DB_TBL_LANG_PREFIX . 'scompany_id')
                );
                $shipCompSrch->addCondition(ShippingCompanies::DB_TBL_PREFIX . 'id', '=', $val['company_id']);
                $shipCompSrch->doNotCalculateRecords();
                $rs = $shipCompSrch->getResultSet();
                $shippingCompData = FatApp::getDb()->fetch($rs);
                if (is_array($shippingCompData)) {
                    $shippingRates[$count] = array_merge($shippingRates[$count], $shippingCompData);
                }

                $shipDurationSrch = ShippingDurations::getListingObj(
                    $lang_id,
                    array(ShippingDurations::DB_TBL_PREFIX . 'name',
                                    ShippingDurations::DB_TBL_PREFIX . 'id',
                                    ShippingDurations::DB_TBL_PREFIX . 'from',
                                    ShippingDurations::DB_TBL_PREFIX . 'identifier ',
                                    ShippingDurations::DB_TBL_PREFIX . 'to',
                                    ShippingDurations::DB_TBL_PREFIX . 'days_or_weeks')
                );
                $shipDurationSrch->addCondition(ShippingDurations::DB_TBL_PREFIX . 'id', '=', $val['processing_time_id']);
                $shipDurationSrch->doNotCalculateRecords();
                $rs = $shipDurationSrch->getResultSet();
                $durationArr = FatApp::getDb()->fetch($rs);
                if (is_array($durationArr)) {
                    $shippingRates[$count] = array_merge($shippingRates[$count], $durationArr);
                }
                $count++;
            }
        }

        return $shippingRates;
    }

    public function saveProductRequestLangData($siteDefaultLangId, $autoUpdateOtherLangsData, $prodName, $prodDesc, $prodYouTubeUrl)
    {
        if ($this->mainTableRecordId < 1 || empty($prodName)) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', $this->commonLangId);
            return false;
        }
        $autoUpdateOtherLangsData = FatUtility::int($autoUpdateOtherLangsData);
        foreach ($prodName as $langId => $value) {
            if (empty($value) && $autoUpdateOtherLangsData > 0) {
                $data = array(
                    'product_name' => $prodName[$siteDefaultLangId],
                    'product_description' => $prodDesc[$siteDefaultLangId],
                );
                $product = new Product();
                $translatedData = $product->getTranslatedProductData($data, $langId);
                $langData = array(
                    'product_name' => $translatedData[$langId]['product_name'],
                    'product_description' => $translatedData[$langId]['product_description'],
                    'product_youtube_video' => $prodYouTubeUrl[$langId],
                );
            } elseif (!empty($value)) {
                $langData = array(
                    'product_name' => $value,
                    'product_description' => $prodDesc[$langId],
                    'product_youtube_video' => $prodYouTubeUrl[$langId],
                );
            }
            $dataForUpdate = array(
                'preqlang_preq_id' => $this->mainTableRecordId,
                'preqlang_lang_id' => $langId,
                'preq_lang_data' => FatUtility::convertToJson($langData),
            );
            if (!$this->updateLangData($langId, $dataForUpdate)) {
                $this->error = $this->getError();
                return false;
            }
        }
        return true;
    }

    public static function getPaymentStatusHtml(int $langId, int $status, string $extraInfo = ''): string
    {
        $arr = self::getStatusArr($langId);
        $msg = $arr[$status] ?? Labels::getLabel('LBL_N/A', $langId);
        $msg = $msg . ' ' . $extraInfo;
        switch ($status) {
            case Orders::ORDER_PAYMENT_PENDING:
                $status = HtmlHelper::INFO;
                break;
            case Orders::ORDER_PAYMENT_PAID:
                $status = HtmlHelper::SUCCESS;
                break;
            case Orders::ORDER_PAYMENT_CANCELLED:
                $status = HtmlHelper::DANGER;
                break;
            default:
                $status = HtmlHelper::PRIMARY;
                break;
        }
        return HtmlHelper::getStatusHtml($status, rtrim($msg));
    }

     /**
     * move images from temp to main table
     */
    public function moveTempFiles(int $tempRecordId)
    {
        if (!$this->mainTableRecordId) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', $this->commonLangId);
            return false;
        }

        $db = FatApp::getDb();
        $sql = "INSERT INTO tbl_attached_files(
            afile_type,
            afile_record_id,
            afile_record_subid,
            afile_lang_id,
            afile_screen,
            afile_physical_path,
            afile_name,
            afile_attribute_title,
            afile_attribute_alt,
            afile_aspect_ratio,
            afile_display_order,
            afile_updated_at
        )
        SELECT
            " . AttachedFile::FILETYPE_CUSTOM_PRODUCT_IMAGE . ",
            $this->mainTableRecordId,
            afile_record_subid,
            afile_lang_id,
            afile_screen,
            afile_physical_path,
            afile_name,
            afile_attribute_title,
            afile_attribute_alt,
            afile_aspect_ratio,
            afile_display_order,
            afile_updated_at
        FROM
            tbl_attached_files_temp
        WHERE
            afile_type = ".AttachedFile::FILETYPE_CUSTOM_PRODUCT_IMAGE_TEMP." AND afile_record_id = $tempRecordId";


        if (!$db->query($sql)) {
            $this->error = $db->getError();
            return false;
        }

        $sql = "delete from tbl_attached_files_temp where afile_type = ".AttachedFile::FILETYPE_CUSTOM_PRODUCT_IMAGE_TEMP." AND afile_record_id = $tempRecordId";
        if (!$db->query($sql)) {
            $this->error = $db->getError();
            return false;
        }

        $db->updateFromArray('tbl_products', array('product_img_updated_on' => date('Y-m-d H:i:s')), array('smt' => 'product_id = ?', 'vals' => array($this->mainTableRecordId)));
        if (!$db->query($sql)) {
            $this->error = $db->getError();
            return false;
        }
        return true;
    }

    public static function isValidProductIdentifier(string $identifier, int $recordId = 0): bool
    {
        $srch = static::getSearchObject();
        $srch->addCondition('preq.preq_product_identifier', '=', $identifier);
        if (0 < $recordId) {
            $srch->addCondition('preq.preq_id', '!=', $recordId);
        }
        $srch->doNotCalculateRecords();
        if (false != FatApp::getDb()->fetch($srch->getResultSet())) {
            return false;
        }

        $record = Product::getAttributesByIdentifier($identifier, 'product_id');
        if (!empty($record)) {
            return false;
        }
        return true;
    }
}
