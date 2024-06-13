<?php

trait ProductSetup
{
    public function getSellerProductForm($product_id, $type = 'SELLER_PRODUCT')
    {
        $frm = new Form('frmSellerProduct');
        $defaultProductCond = '';

        if ($type == 'REQUESTED_CATALOG_PRODUCT') {
            $productData = [];
            if (0 < FatApp::getConfig('CONF_WITHOUT_PROD_VARIANTS', FatUtility::VAR_INT, 0)) {
                $productData = FatApp::getPostedData();
            } else {
                $reqData = ProductRequest::getAttributesById($product_id, array('preq_content'));
                if (is_array($reqData)) {
                    $productData = array_merge($reqData, json_decode($reqData['preq_content'], true));
                    $optionArr = isset($productData['product_option']) ? $productData['product_option'] : array();
                    foreach ($optionArr as $val) {
                        $val = FatUtility::int($val);
                        $optionSrch = Option::getSearchObject($this->siteLangId);
                        $optionSrch->addMultipleFields(array('IFNULL(option_name,option_identifier) as option_name', 'option_id'));
                        $optionSrch->doNotCalculateRecords();
                        $optionSrch->setPageSize(1);
                        $optionSrch->addCondition('option_id', '=', 'mysql_func_' . $val, 'AND', true);
                        $rs = $optionSrch->getResultSet();
                        $option = FatApp::getDb()->fetch($rs);
                        if ($option == false) {
                            continue;
                        }
                        $optionValues = Product::getOptionValues($option['option_id'], $this->siteLangId);
                        $option_name = ($option['option_name'] != '') ? $option['option_name'] : $option['option_identifier'];
                        $fld = $frm->addSelectBox($option_name, 'selprodoption_optionvalue_id[' . $option['option_id'] . ']', $optionValues, '', array(), Labels::getLabel('FRM_SELECT', $this->siteLangId));
                        $fld->requirements()->setRequired();
                    }
                }
            }
            $productData['sellerProduct'] = 0;
        } else {
            $productData = Product::getAttributesById($product_id, array('product_type', 'product_min_selling_price', 'if(product_seller_id > 0, 1, 0) as sellerProduct', 'product_seller_id'));

            if ($productData['product_type'] == Product::PRODUCT_TYPE_DIGITAL) {
                $defaultProductCond = Product::CONDITION_NEW;
            }

            $productOptions = Product::getProductOptions($product_id, $this->siteLangId, true);
            if ($productOptions) {
                foreach ($productOptions as $option) {
                    $option_name = ($option['option_name'] != '') ? $option['option_name'] : $option['option_identifier'];
                    $fld = $frm->addSelectBox($option_name, 'selprodoption_optionvalue_id[' . $option['option_id'] . ']', $option['optionValues'], '', array(), Labels::getLabel('FRM_SELECT', $this->siteLangId));
                }
            }
            $frm->addTextBox(Labels::getLabel('FRM_USER', $this->siteLangId), 'selprod_user_shop_name', '', array(' ' => ' '))->requirements()->setRequired();
        }

        $frm->addRequiredField(Labels::getLabel('FRM_TITLE', $this->siteLangId), 'selprod_title');

        $isPickupEnabled = applicationConstants::NO;
        if ($productData['sellerProduct'] > 0) {
            $isPickupEnabled = Shop::getAttributesByUserId($productData['product_seller_id'], 'shop_fulfillment_type');
        } else {
            $isPickupEnabled = FatApp::getConfig('CONF_FULFILLMENT_TYPE', FatUtility::VAR_INT, -1);
        }

        $frm->addHiddenField('', 'selprod_user_id');
        $frm->addTextBox(Labels::getLabel('FRM_URL_KEYWORD', $this->siteLangId), 'selprod_url_keyword');

        $costPrice = $frm->addFloatField(Labels::getLabel('FRM_COST_PRICE', $this->siteLangId) . ' [' . CommonHelper::getCurrencySymbol(true) . ']', 'selprod_cost');
        $costPrice->requirements()->setPositive();

        $fld = $frm->addFloatField(Labels::getLabel('FRM_SELLING_PRICE', $this->siteLangId) . ' [' . CommonHelper::getCurrencySymbol(true) . ']', 'selprod_price');
        $fld->requirements()->setRange('0.01', '99999999.99');
        if (isset($productData['product_min_selling_price'])) {
            $fld->requirements()->setRange($productData['product_min_selling_price'], 99999999.99);
        }

        $fld = $frm->addIntegerField(Labels::getLabel('FRM_AVAILABLE_QUANTITY', $this->siteLangId), 'selprod_stock');
        $fld->requirements()->setPositive();
        $fld_sku = $frm->addTextBox(Labels::getLabel('FRM_PRODUCT_SKU', $this->siteLangId), 'selprod_sku');
        if (FatApp::getConfig("CONF_PRODUCT_SKU_MANDATORY", FatUtility::VAR_INT, 1)) {
            $fld_sku->requirements()->setRequired();
        }

        $fld = $frm->addIntegerField(Labels::getLabel('FRM_MINIMUM_PURCHASE_QUANTITY', $this->siteLangId), 'selprod_min_order_qty');
        $fld->requirements()->setPositive();

        if ($productData['product_type'] == Product::PRODUCT_TYPE_DIGITAL) {
            $fld = $frm->addIntegerField(Labels::getLabel('FRM_MAX_DOWNLOAD_TIMES', $this->siteLangId), 'selprod_max_download_times');
            $fld->htmlAfterField = '<small class="text--small">' . Labels::getLabel('FRM_-1_for_unlimited', $this->siteLangId) . '</small>';

            $fld1 = $frm->addIntegerField(Labels::getLabel('FRM_DOWNLOAD_VALIDITY_(days)', $this->siteLangId), 'selprod_download_validity_in_days');
            $fld1->htmlAfterField = '<small class="text--small">' . Labels::getLabel('FRM_-1_for_unlimited', $this->siteLangId) . '</small>';
            $frm->addHiddenField('', 'selprod_condition', $defaultProductCond);
        } else {
            $fld = $frm->addSelectBox(Labels::getLabel('FRM_PRODUCT_CONDITION', $this->siteLangId), 'selprod_condition', Product::getConditionArr($this->siteLangId), '', array(), Labels::getLabel('FRM_SELECT_CONDITION', $this->siteLangId));
            $fld->requirements()->setRequired();
        }

        if ($productData['product_type'] != Product::PRODUCT_TYPE_DIGITAL) {
            $codFld = $frm->addSelectBox(Labels::getLabel('FRM_AVAILABLE_FOR_COD', $this->siteLangId), 'selprod_cod_enabled', applicationConstants::getYesNoArr($this->siteLangId), '0', array(), '');
            $paymentMethod = new PaymentMethods();
            if (!$paymentMethod->cashOnDeliveryIsActive()) {
                $codFld->addFieldTagAttribute('disabled', 'disabled');
                $codFld->htmlAfterField = '<br/><small>' . Labels::getLabel('FRM_COD_OPTION_IS_DISABLED_IN_PAYMENT_GATEWAY_SETTINGS', $this->siteLangId) . '</small>';
            }

            $fulFillmentArr = Shipping::getFulFillmentArr($this->siteLangId, $isPickupEnabled);
            $fld = $frm->addSelectBox(Labels::getLabel('FRM_FULFILLMENT_METHOD', $this->siteLangId), 'selprod_fulfillment_type', $fulFillmentArr, applicationConstants::NO, array(), Labels::getLabel('FRM_SELECT', $this->siteLangId));
            $fld->requirement->setRequired(true);
        }

        $frm->addDateField(Labels::getLabel('FRM_DATE_AVAILABLE', $this->siteLangId), 'selprod_available_from', '', array('readonly' => 'readonly', 'class' => 'field--calender'))->requirements()->setRequired();

        $frm->addCheckBox(Labels::getLabel('FRM_SYSTEM_SHOULD_MAINTAIN_STOCK_LEVELS', $this->siteLangId), 'selprod_subtract_stock', applicationConstants::YES, array(), false, 0);
        $fld = $frm->addCheckBox(Labels::getLabel('FRM_SYSTEM_SHOULD_TRACK_PRODUCT_INVENTORY', $this->siteLangId), 'selprod_track_inventory', Product::INVENTORY_TRACK, ['class' => 'fieldsVisibilityJs'], false, 0);

        $stockLevelReqFld = new FormFieldRequirement('selprod_threshold_stock_level', Labels::getLabel('FRM_ALERT_STOCK_LEVEL', $this->siteLangId));
        $stockLevelReqFld->setRequired(true);

        $stockLevelUnReqFld = new FormFieldRequirement('selprod_threshold_stock_level', Labels::getLabel('FRM_ALERT_STOCK_LEVEL', $this->siteLangId));
        $stockLevelUnReqFld->setRequired(false);

        $fld->requirements()->addOnChangerequirementUpdate(1, 'eq', 'selprod_threshold_stock_level', $stockLevelReqFld);
        $fld->requirements()->addOnChangerequirementUpdate(1, 'ne', 'selprod_threshold_stock_level', $stockLevelUnReqFld);

        $fld = $frm->addTextBox(Labels::getLabel('FRM_ALERT_STOCK_LEVEL', $this->siteLangId), 'selprod_threshold_stock_level');
        $fld->requirements()->setInt();

        $useShopPolicy = $frm->addCheckBox(Labels::getLabel('FRM_USE_SHOP_RETURN_AND_CANCELLATION_AGE_POLICY', $this->siteLangId), 'use_shop_policy', 1, ['id' => 'use_shop_policy'], false, 0);

        $fld = $frm->addIntegerField(Labels::getLabel('FRM_PRODUCT_ORDER_RETURN_PERIOD_(Days)', $this->siteLangId), 'selprod_return_age');
        $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel('FRM_WARRANTY_IN_DAYS', $this->siteLangId) . ' </span>';

        $orderReturnAgeReqFld = new FormFieldRequirement('selprod_return_age', Labels::getLabel('FRM_PRODUCT_ORDER_RETURN_PERIOD_(Days)', $this->siteLangId));
        $orderReturnAgeReqFld->setRequired(true);
        $orderReturnAgeReqFld->setPositive();

        $orderReturnAgeUnReqFld = new FormFieldRequirement('selprod_return_age', Labels::getLabel('FRM_PRODUCT_ORDER_RETURN_PERIOD_(Days)', $this->siteLangId));
        $orderReturnAgeUnReqFld->setRequired(false);
        $orderReturnAgeUnReqFld->setPositive();

        $fld = $frm->addIntegerField(Labels::getLabel('FRM_PRODUCT_ORDER_CANCELLATION_PERIOD_(Days)', $this->siteLangId), 'selprod_cancellation_age');
        $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel('FRM_WARRANTY_IN_DAYS', $this->siteLangId) . ' </span>';

        $orderCancellationAgeReqFld = new FormFieldRequirement('selprod_cancellation_age', Labels::getLabel('FRM_PRODUCT_ORDER_CANCELLATION_PERIOD_(Days)', $this->siteLangId));
        $orderCancellationAgeReqFld->setRequired(true);
        $orderCancellationAgeReqFld->setPositive();

        $orderCancellationAgeUnReqFld = new FormFieldRequirement('selprod_cancellation_age', Labels::getLabel('FRM_PRODUCT_ORDER_CANCELLATION_PERIOD_(Days)', $this->siteLangId));
        $orderCancellationAgeUnReqFld->setRequired(false);
        $orderCancellationAgeUnReqFld->setPositive();

        $useShopPolicy->requirements()->addOnChangerequirementUpdate(Shop::USE_SHOP_POLICY, 'eq', 'selprod_return_age', $orderReturnAgeUnReqFld);
        $useShopPolicy->requirements()->addOnChangerequirementUpdate(Shop::USE_SHOP_POLICY, 'ne', 'selprod_return_age', $orderReturnAgeReqFld);

        $useShopPolicy->requirements()->addOnChangerequirementUpdate(Shop::USE_SHOP_POLICY, 'eq', 'selprod_cancellation_age', $orderCancellationAgeUnReqFld);
        $useShopPolicy->requirements()->addOnChangerequirementUpdate(Shop::USE_SHOP_POLICY, 'ne', 'selprod_cancellation_age', $orderCancellationAgeReqFld);

        $frm->addCheckBox(Labels::getLabel('FRM_PUBLISH_INVENTORY', $this->siteLangId), 'selprod_active', applicationConstants::ACTIVE, [], false, applicationConstants::INACTIVE);

        $frm->addTextArea(Labels::getLabel('FRM_ANY_EXTRA_COMMENT_FOR_BUYER', $this->siteLangId), 'selprod_comments');

        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        $frm->addHiddenField('', 'selprod_product_id', $product_id);
        $frm->addHiddenField('', 'selprod_id');
        return $frm;
    }

    public function setupInventory(int $prodId = 0, object $db = null, string $type = 'SELLER_PRODUCT')
    {
        $isDbObj = ($db instanceof Database);
        $return = ($type == 'REQUESTED_CATALOG_PRODUCT');
        $postedData = FatApp::getPostedData();
        $productId = FatApp::getPostedData('selprod_product_id', Fatutility::VAR_INT, $prodId);

        if (0 < $prodId || $return) {
            $productSellerId = $postedData['product_seller_id'] ?? $this->userParentId ?? 0;
            $postedData['selprod_user_shop_name'] = $productSellerId;
            $postedData['selprod_user_id'] = $productSellerId;
            $postedData['selprod_price'] = $postedData['product_min_selling_price'];
            $postedData['selprod_title'] = $postedData['product_name'];
            $postedData['selprod_cod_enabled'] = $postedData['product_cod_enabled'] ?? 0;
            $postedData['selprod_fulfillment_type'] = $postedData['product_fulfillment_type'];
        }

        $frm = $this->getSellerProductForm($productId, $type);
        $post = $frm->getFormDataFromArray($postedData);
        if (false === $post) {
            if ($isDbObj) {
                $db->rollbackTransaction();
            }
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        if (0 < $prodId) {
            $post['selprod_product_id'] = $productId = $prodId;
        }

        if (1 > $productId && false == $return) {
            if ($isDbObj) {
                $db->rollbackTransaction();
            }
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST_ID', $this->siteLangId), true);
        }

        $selProdId = Fatutility::int($post['selprod_id']);

        if (0 < $prodId || $return) {
            $productRow = $postedData;
        } else {
            $productRow = Product::getAttributesById($productId, array('product_type'));
        }

        if (empty($productRow)) {
            if ($isDbObj) {
                $db->rollbackTransaction();
            }
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST_ID', $this->siteLangId), true);
        }

        if ($productRow['product_type'] == Product::PRODUCT_TYPE_DIGITAL && $post['selprod_max_download_times'] == 0) {
            if ($isDbObj) {
                $db->rollbackTransaction();
            }
            LibHelper::exitWithError(Labels::getLabel('ERR_DOWNLOAD_TIMES_MUST_BE_-1_OR_GREATER_THAN_ZERO', $this->siteLangId), true);
        }

        if ($productRow['product_type'] == Product::PRODUCT_TYPE_DIGITAL && $post['selprod_download_validity_in_days'] == 0) {
            if ($isDbObj) {
                $db->rollbackTransaction();
            }
            LibHelper::exitWithError(Labels::getLabel('ERR_DOWNLOAD_VALIDITY_MUST_BE_-1_OR_GREATER_THAN_ZERO', $this->siteLangId), true);
        }

        $selprod_stock = Fatutility::int($post['selprod_stock']);
        $selprod_min_order_qty = Fatutility::int($post['selprod_min_order_qty']);
        $selprod_threshold_stock_level = Fatutility::int($post['selprod_threshold_stock_level']);
        $useShopPolicy = FatApp::getPostedData('use_shop_policy', FatUtility::VAR_INT, 0);
        $post['use_shop_policy'] = $useShopPolicy;

        $status = Fatutility::int($post['selprod_active']);
        if (0 < $selProdId) {
            $selprodTitle = SellerProduct::getAttributesByLangId($this->siteLangId, $selProdId, 'selprod_title');
            $oldSelprodData = SellerProduct::getAttributesById($selProdId, ['selprod_user_id', 'selprod_active']);
            if (
                $oldSelprodData['selprod_active'] != $status &&
                $status == applicationConstants::ACTIVE &&
                FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE', FatUtility::VAR_INT, 0) &&
                SellerProduct::getActiveCount($oldSelprodData['selprod_user_id']) >= SellerPackages::getAllowedLimit($oldSelprodData['selprod_user_id'], $this->siteLangId, 'ossubs_inventory_allowed')
            ) {
                $msg = Labels::getLabel('ERR_UNABLE_TO_CHANGE_STATUS_FOR_"{PRODUCT-NAME}"._AS_SELLER_SUBSCRIPTION_PACKAGE_LIMIT_CROSSED.', $this->siteLangId);
                $msg = CommonHelper::replaceStringData($msg, ['{PRODUCT-NAME}' => $selprodTitle]);
                if ($isDbObj) {
                    $db->rollbackTransaction();
                }
                LibHelper::exitWithError($msg, true);
            }
        }

        if (0 < $selProdId) {
            $srch = new SearchBase(SellerProductSpecialPrice::DB_TBL);
            $srch->addCondition('splprice_selprod_id', '=', $selProdId);
            $srch->addCondition('splprice_price', '>=', $post['selprod_price']);
            $srch->addCondition('splprice_end_date', '>=', date('Y-m-d H:i:s'));
            $srch->addFld('splprice_price');
            $srch->addOrder('splprice_price', 'DESC');
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $result = FatApp::getDb()->fetch($srch->getResultSet());
            if (is_array($result) && !empty($result)) {
                $price = CommonHelper::displayMoneyFormat($result['splprice_price']);
                $msg = Labels::getLabel('ERR_SELLING_PRICE_MUST_BE_GREATER_THAN_SPECIAL_PRICE_{SPECIAL-PRICE}', $this->siteLangId);
                $msg = CommonHelper::replaceStringData($msg, ['{SPECIAL-PRICE}' => $price]);
                if ($isDbObj) {
                    $db->rollbackTransaction();
                }
                LibHelper::exitWithError($msg, true);
            }
        }

        if (isset($post['selprod_track_inventory']) && $post['selprod_track_inventory'] == Product::INVENTORY_NOT_TRACK) {
            $post['selprod_threshold_stock_level'] = 0;
        }

        if ($post['selprod_threshold_stock_level'] == 1 && $selprod_threshold_stock_level >= $selprod_stock) {
            if ($isDbObj) {
                $db->rollbackTransaction();
            }
            LibHelper::exitWithError(Labels::getLabel('ERR_ALERT_STOCK_LEVEL_SHOULD_BE_LESS_THAN_STOCK_QUANTITY.', $this->siteLangId), true);
        }

        if ($post['selprod_threshold_stock_level'] == 1 && ($selprod_min_order_qty > $selprod_stock || 1 > $selprod_min_order_qty)) {
            if ($isDbObj) {
                $db->rollbackTransaction();
            }
            LibHelper::exitWithError(Labels::getLabel('ERR_MINIMUM_QUANTITY_SHOULD_BE_LESS_THAN_EQUAL_TO_STOCK_QUANTITY.', $this->siteLangId), true);
        }

        if (0 < $prodId) {
            $post['selprod_code'] = $prodId . '_';
        }

        if ($return) {
            return $post;
        }

        $selProdId = $this->saveInventoryRecord($post, $productId, $selProdId, $db);

        return $selProdId;
    }

    public function saveInventoryRecord(array $post, int $productId, int $selProdId = 0, object $db = null)
    {
        $isDbObj = ($db instanceof Database);
        $recordObj = new SellerProduct($selProdId);
        $recordObj->assignValues($post);
        if (!$recordObj->save()) {
            if ($isDbObj) {
                $db->rollbackTransaction();
            }
            LibHelper::exitWithError($recordObj->getError(), true);
        }

        $selProdId = $recordObj->getMainTableRecordId();

        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, CommonHelper::getDefaultFormLangId());
        if (!$recordObj->updateLangData($langId, ['selprod_title' => $post['selprod_title'], 'selprod_comments' => $post['selprod_comments']])) {
            LibHelper::exitWithError($recordObj->getError(), true);
        }
        $useShopPolicy = $post['use_shop_policy'];
        $selProdSpecificsObj = new SellerProductSpecifics($selProdId);
        if (0 < $useShopPolicy) {
            if (!$selProdSpecificsObj->deleteRecord()) {
                LibHelper::exitWithError($selProdSpecificsObj->getError(), true);
            }
        } else {
            $post['sps_selprod_id'] = $selProdId;
            $selProdSpecificsObj->assignValues($post);
            $data = $selProdSpecificsObj->getFlds();
            if (!$selProdSpecificsObj->addNew(array(), $data)) {
                LibHelper::exitWithError($selProdSpecificsObj->getError(), true);
            }
        }

        /* Add Url rewriting  [  ---- */
        $recordObj->rewriteUrlProduct($post['selprod_url_keyword']);
        $recordObj->rewriteUrlReviews($post['selprod_url_keyword']);
        $recordObj->rewriteUrlMoreSellers($post['selprod_url_keyword']);
        /* --------  ] */

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData($recordObj::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($selProdId, CommonHelper::getDefaultFormLangId())) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        CalculativeDataRecord::updateThresholdSelprodRequestCount();
        Product::updateMinPrices($productId);

        return $selProdId;
    }
}
