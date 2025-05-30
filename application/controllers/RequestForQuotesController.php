<?php
class RequestForQuotesController extends MyAppController
{
    private int $loggedUserId = 0;
    public function __construct($action)
    {
        parent::__construct($action);
        $this->loggedUserId = UserAuthentication::getLoggedUserId(true);
        if (1 > FatApp::getConfig('CONF_RFQ_MODULE', FatUtility::VAR_INT, 0)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_RFQ_MODULE_IS_NOT_ENABLED', $this->siteLangId), true);
        }

        if (UserAuthentication::isUserLogged() && !User::isBuyer(true)) {
            $errMsg = Labels::getLabel('ERR_PLEASE_LOGIN_WITH_BUYER_ACCOUNT_TO_ADD_PRODUCTS_TO_CART', $this->siteLangId);
            LibHelper::exitWithError($errMsg, true, true);
            FatApp::redirectUser(UrlHelper::generateUrl());
        }
    }

    private function getForm(int $selprodId = 0): Form
    {
        $isUserLogged = ($this->loggedUserId > 0) ? applicationConstants::YES : applicationConstants::NO;
        $frm = RequestForQuote::getForm($isUserLogged);
        if (1 > $selprodId) {
            $productTypeArr = Product::getProductTypes($this->siteLangId);
            $fld = $frm->addSelectBox(Labels::getLabel('FRM_PRODUCT_TYPE', $this->siteLangId), 'rfq_product_type', $productTypeArr, Product::PRODUCT_TYPE_PHYSICAL, [], '');
            $fld->requirements()->setRequired();

            $sellerLinkingTypeArr = RequestForQuote::getSellerLinkingTypeArr($this->siteLangId);
            if (false == UserAuthentication::isUserLogged() && false == UserAuthentication::isGuestUserLogged()) {
                unset($sellerLinkingTypeArr[RequestForQuote::SELLER_LINKING_FAVOURITE]);
            }

            $frm->addRadioButtons(
                Labels::getLabel("FRM_TARGETED_SUPPLIERS", $this->siteLangId),
                'rfq_seller_linking_type',
                $sellerLinkingTypeArr,
                RequestForQuote::SELLER_LINKING_OPEN,
                array('class' => 'list-radio'),
                array('class' => '')
            );

            $frm->addSelectBox(Labels::getLabel('LBL_PRODUCT/SERVICE_CATEGORY', $this->siteLangId), 'rfq_prodcat_id', []);
            $frm->addRequiredField(Labels::getLabel('LBL_LOOKING_FOR', $this->siteLangId), 'rfq_title');
            $frm->addSelectBox(Labels::getLabel('LBL_SUPPLIER`S', $this->siteLangId), 'rfqts_user_id[]', [], '', [], '');
        }
        $frm->addHiddenField('', 'rfq_selprod_id');
        return $frm;
    }

    /* 
    * Used for API only
    */
    public function getAddresses()
    {
        $address = new Address();
        $addresses = $address->getData(Address::TYPE_USER, UserAuthentication::getLoggedUserId(true), sessionId: session_id());
        $defaultAddress = current($addresses);

        $data = [
            'addresses' => $addresses,
            'defaultAddress' => !empty($defaultAddress) ? $defaultAddress : (object) []
        ];

        $this->set('data', $data);
        $this->_template->render();
    }

    public function form()
    {
        $selprodId = FatApp::getPostedData('selprodId', FatUtility::VAR_INT, 0);
        $post = FatApp::getPostedData();
        $rfqQuat = FatUtility::int(($post['rfqQuat'] ?? 1));
        if (0 < $selprodId) {
            $selprodData = $this->getProductDetail($selprodId);
            if (!$selprodData) {
                LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId), true);
            }

            $shopRfqEnabled = Shop::getAttributesByUserId($selprodData['selprod_user_id'], 'shop_rfq_enabled');
            if (!RequestForQuote::isEnabled($shopRfqEnabled, $selprodData['selprod_cart_type'])) {
                LibHelper::exitWithError(Labels::getLabel('ERR_RFQ_NOT_ENABLED_FOR_THIS_SHOP_OR_PRODUCT.'));
            }

            $selprodData['options'] = SellerProduct::getSellerProductOptions($selprodId, true, $this->siteLangId);
            $optionSrchObj = new ProductSearch($this->siteLangId);
            $optionSrchObj->setDefinedCriteria(0, 0, array('product_id' => $selprodData['selprod_product_id']));
            $optionSrchObj->doNotCalculateRecords();
            $optionSrchObj->doNotLimitRecords();
            $optionSrchObj->joinTable(SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, 'LEFT OUTER JOIN', 'selprod_id = tspo.selprodoption_selprod_id', 'tspo');
            $optionSrchObj->joinTable(OptionValue::DB_TBL, 'LEFT OUTER JOIN', 'tspo.selprodoption_optionvalue_id = opval.optionvalue_id', 'opval');
            $optionSrchObj->joinTable(Option::DB_TBL, 'LEFT OUTER JOIN', 'opval.optionvalue_option_id = op.option_id', 'op');
            if (FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE', FatUtility::VAR_INT, 0)) {
                $validDateCondition = " and oss.ossubs_till_date >= '" . date('Y-m-d') . "'";
                $optionSrchObj->joinTable(Orders::DB_TBL, 'INNER JOIN', 'o.order_user_id=seller_user.user_id AND o.order_type=' . ORDERS::ORDER_SUBSCRIPTION . ' AND o.order_payment_status =1', 'o');
                $optionSrchObj->joinTable(OrderSubscription::DB_TBL, 'INNER JOIN', 'o.order_id = oss.ossubs_order_id and oss.ossubs_status_id=' . FatApp::getConfig('CONF_DEFAULT_SUBSCRIPTION_PAID_ORDER_STATUS') . $validDateCondition, 'oss');
            }
            $optionSrchObj->addCondition('product_id', '=', $selprodData['selprod_product_id']);

            $optionSrch = clone $optionSrchObj;
            $optionSrch->joinTable(Option::DB_TBL . '_lang', 'LEFT OUTER JOIN', 'op.option_id = op_l.optionlang_option_id AND op_l.optionlang_lang_id = ' . $this->siteLangId, 'op_l');
            $optionSrch->addMultipleFields(array('option_id', 'option_is_color', 'COALESCE(option_name,option_identifier) as option_name'));
            $optionSrch->addCondition('option_id', '!=', 'NULL');
            $optionSrch->addCondition('selprodoption_selprod_id', '=', $selprodId);
            $optionSrch->addGroupBy('option_id');

            $optionRs = $optionSrch->getResultSet();
            if (true === MOBILE_APP_API_CALL) {
                $optionRows = FatApp::getDb()->fetchAll($optionRs);
            } else {
                $optionRows = FatApp::getDb()->fetchAll($optionRs, 'option_id');
            }

            if (count($optionRows) > 0) {
                foreach ($optionRows as &$option) {
                    $optionValueSrch = clone $optionSrchObj;
                    $optionValueSrch->joinTable(OptionValue::DB_TBL . '_lang', 'LEFT OUTER JOIN', 'opval.optionvalue_id = opval_l.optionvaluelang_optionvalue_id AND opval_l.optionvaluelang_lang_id = ' . $this->siteLangId, 'opval_l');
                    $optionValueSrch->addCondition('product_id', '=', $selprodData['selprod_product_id']);
                    $optionValueSrch->addCondition('option_id', '=', $option['option_id']);
                    $optionValueSrch->addMultipleFields(array('COALESCE(product_name, product_identifier) as product_name', 'selprod_id', 'selprod_user_id', 'selprod_code', 'option_id', 'COALESCE(optionvalue_name,optionvalue_identifier) as optionvalue_name ', 'theprice', 'optionvalue_id', 'optionvalue_color_code', 'selprod_cart_type', 'selprod_hide_price', 'shop_rfq_enabled'));
                    $optionValueSrch->addGroupBy('optionvalue_id');
                    $optionValueSrch->addOrder('optionvalue_display_order');
                    $optionValueSrch->addCondition('selprod_cart_type', '!=', SellerProduct::CART_TYPE_CART_ONLY);  

                    if (1 > FatApp::getConfig('CONF_HIDE_PRICES', FatUtility::VAR_INT, 0) && RequestForQuote::TYPE_INDIVIDUAL == FatApp::getConfig('CONF_RFQ_MODULE_TYPE', FatUtility::VAR_INT, 0)) {
                        $optionValueSrch->addCondition('shop_rfq_enabled', '=', applicationConstants::YES);
                        $optionValueSrch->addCondition('selprod_cart_type', '!=', SellerProduct::CART_TYPE_CART_ONLY);
                    }

                    $optionValueRs = $optionValueSrch->getResultSet();
                    if (true === MOBILE_APP_API_CALL) {
                        $optionValueRows = FatApp::getDb()->fetchAll($optionValueRs);
                    } else {
                        $optionValueRows = FatApp::getDb()->fetchAll($optionValueRs, 'optionvalue_id');
                    }
                    $option['values'] = $optionValueRows;
                }
            }

            $selectedOptions = array_column($selprodData['options'], 'optionvalue_id');

            $this->set('optionRows', $optionRows);
            $this->set('selectedOptions', $selectedOptions);

            $selProdReviewObj = SelProdRating::getAvgShopReviewsRatingObj($selprodData['shop_user_id'], $this->siteLangId);
            $selProdReviewObj->joinProducts($this->siteLangId);
            $selProdReviewObj->joinSellerProducts($this->siteLangId);
            $selProdReviewObj->addGroupBy('spr.spreview_seller_user_id');
            $selProdReviewObj->addMultipleFields(array('spr.spreview_seller_user_id', 'count(distinct(spreview_id)) as totReviews'));
            $selProdReviewObj->doNotCalculateRecords();
            $selProdReviewObj->setPageSize(1);

            $reviews = FatApp::getDb()->fetch($selProdReviewObj->getResultSet());
        }

        $address = new Address();
        $addresses = $address->getData(Address::TYPE_USER, UserAuthentication::getLoggedUserId(true), sessionId: session_id());
        $defaultAddress = current($addresses);

        $this->set('addresses', $addresses);
        $this->set('defaultAddress', $defaultAddress);

        $frm = $this->getForm($selprodId);
        $frm->fill([
            'rfq_selprod_id' => $selprodId,
            'rfq_product_id' => $selprodData['selprod_product_id'] ?? 0,
            'rfq_addr_id' => $defaultAddress['addr_id'] ?? 0,
            'rfq_quantity' => (1 > $rfqQuat ? 1 : $rfqQuat)
        ]);
        $this->set('frm', $frm);
        $shop_rating = 0;
        if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0) && !empty($selprodData)) {
            $shop_rating = SelProdRating::getSellerRating($selprodData['shop_user_id'], true);
        }

        // $product = new Product();
        //$productCategories = $product->getProductCategories($selprodData['selprod_product_id'], $this->siteLangId, true);

        $this->set('selprodData', $selprodData ?? []);
        $this->set('shopRating', $shop_rating);
        $this->set('totReviews', $reviews['totReviews'] ?? 0);
        $this->set('selprodId', $selprodId);
        $this->set('isUserLogged', ($this->loggedUserId > 0) ? applicationConstants::YES : applicationConstants::NO);
        // $this->set('productCategories', $productCategories);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getProductDetail(int $selprod_id)
    {
        $prodSrch = new ProductSearch($this->siteLangId);
        $productId = SellerProduct::getAttributesById($selprod_id, 'selprod_product_id');
        $prodSrch->setDefinedCriteria(0, 0, array('product_id' => $productId), false);
        $prodSrch->addCondition('selprod_id', '=', $selprod_id);
        $prodSrch->addCondition('selprod_deleted', '=', applicationConstants::NO);
        $prodSrch->doNotLimitRecords();
        $prodSrch->doNotCalculateRecords();

        $prodSrch->addMultipleFields(
            ['COALESCE(selprod_title, product_name, product_identifier) as selprod_title', 'selprod_product_id', 'selprod_updated_on', 'selprod_price', 'theprice', 'COALESCE(shop_name, shop_identifier) as shop_name', 'user_name as shop_user_name', 'shop_user_id', 'COALESCE(brand_name, brand_identifier) as brand_name', 'selprod_cart_type', 'selprod_user_id', 'selprod_hide_price', 'shop_rfq_enabled']
        );
        $productRs = $prodSrch->getResultSet();
        return (array) FatApp::getDb()->fetch($productRs);
    }


    public function save()
    {
        $selprodId = FatApp::getPostedData('rfq_selprod_id', FatUtility::VAR_INT, 0);
        $email = "";
        $isGuest = false;
        $frm = $this->getForm($selprodId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $productType = FatApp::getPostedData('rfq_product_type', FatUtility::VAR_INT, Product::PRODUCT_TYPE_PHYSICAL);
        // if (empty($post['rfq_addr_id']) && Product::PRODUCT_TYPE_DIGITAL != $productType) {
		//     LibHelper::exitWithError(Labels::getLabel('ERR_DELIVERY_ADDRESS_IS_MANDATORY'), true);
		// } 

		$existingAddressUserId = 0;
		if (!empty($post['rfq_addr_id'])) {
			$existingAddressUserId = Address::getAttributesById($post['rfq_addr_id'], 'addr_record_id');
		}
        $this->loggedUserId = UserAuthentication::getLoggedUserId(true);
		if (0 < $existingAddressUserId) {
			if (
				(0 == $this->loggedUserId) ||
				(0 < $this->loggedUserId && $this->loggedUserId != $existingAddressUserId)
			) {
				LibHelper::exitWithError(Labels::getLabel('ERR_DELIVERY_ADDRESS_SHOULD_BELONGS_TO_CURRENT_USER'), true);
			}
		}

        $linkingType = FatApp::getPostedData('rfq_seller_linking_type', FatUtility::VAR_INT, RequestForQuote::SELLER_LINKING_OPEN);

        $sellerIdArr = $selprodData = [];
        if (0 < $selprodId) {
            $selprodData = SellerProduct::getAttributesByLangId($this->siteLangId, $selprodId, ['selprod_id', 'selprod_title', 'selprod_user_id', 'selprod_product_id', 'selprod_updated_on', 'selprod_code', 'selprod_min_order_qty', 'selprod_cart_type'], 1, applicationConstants::JOIN_LEFT);
            if(!empty($selprodData) && empty($selprodData['selprod_title'])){
                $selprodData['selprod_title'] = Product::getAttributesById($selprodData['selprod_product_id'],'product_identifier');
            }

            $shopRfqEnabled = Shop::getAttributesByUserId($selprodData['selprod_user_id'], 'shop_rfq_enabled');
            if (!RequestForQuote::isEnabled($shopRfqEnabled, $selprodData['selprod_cart_type'])) {
                LibHelper::exitWithError(Labels::getLabel('ERR_RFQ_NOT_ENABLED_FOR_THIS_SHOP_OR_PRODUCT.'), true);
            }

            $post['rfq_product_type'] = Product::getAttributesById($selprodData['selprod_product_id'], 'product_type');
        } else {
            $sellerIdArr = FatApp::getPostedData('rfqts_user_id', FatUtility::VAR_INT, 0);

            if (empty($sellerIdArr)) {
                if (RequestForQuote::SELLER_LINKING_FAVOURITE == $linkingType) {
                    $sellersArr = Shop::getSellersAutocomplete($this->siteLangId, true, $this->loggedUserId, true);
                    $sellersArr = $sellersArr['results'] ?? [];
                    if (empty($sellersArr)) {
                        LibHelper::exitWithError(Labels::getLabel('ERR_NO_FAVOURITE_SELLERS_FOUND.', $this->siteLangId), true);
                    }
                    $sellerIdArr = array_column($sellersArr, 'id');
                } else if (RequestForQuote::SELLER_LINKING_ANY == $linkingType) {
                    LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_SELECT_SUPPLIERS.', $this->siteLangId), true);
                } else {
                    $sellerIdArr = [];
                }
            }
        }

        $sessionId = session_id();
        if ($this->loggedUserId == 0) {
            $authentication = new UserAuthentication();
            if (!$authentication->guestLogin(FatApp::getPostedData('user_email'), FatApp::getPostedData('user_name'), $_SERVER['REMOTE_ADDR'], FatApp::getPostedData('user_phone'), FatApp::getPostedData('user_phone_dcode'))) {
                LibHelper::exitWithError($authentication->getError(), true);
            }
            $this->loggedUserId = UserAuthentication::getLoggedUserId();

            $email =  FatApp::getPostedData('user_email');
            $isGuest = true;
        }

        $data_to_be_save['addr_record_id'] = $this->loggedUserId;
        $data_to_be_save['addr_session_id'] = '';
        $addressObj = new TableRecord(Address::DB_TBL);
        $addressObj->assignValues($data_to_be_save, true);
        if (!$addressObj->update(['smt' => 'addr_session_id=?', 'vals' => [$sessionId]])) {
            if (true === MOBILE_APP_API_CALL) {
                LibHelper::dieJsonError($addressObj->getError());
            }
            Message::addErrorMessage($addressObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }

        $recordId = FatApp::getPostedData('rfq_id', FatUtility::VAR_INT, 0);

        $db = FatApp::getDb();
        $db->startTransaction();

        if (0 < $selprodId) {
            $options = SellerProduct::getSellerProductOptions($selprodId, true, $this->siteLangId);
            if (!empty($options)) {
                $options = implode(' | ', array_column($options, 'optionvalue_name'));
            }

            $post['rfq_title'] = ($selprodData['selprod_title'] . (!empty($options) ? ' | ' . $options : ''));
            $post['rfq_selprod_code'] = $selprodData['selprod_code'];
        }

        if (empty($sellerIdArr) && 1 > $selprodId) {
            $post['rfq_visibility_type'] = RequestForQuote::VISIBILITY_TYPE_OPEN;
        }

        $adminApproval = FatApp::getConfig('CONF_ENABLE_ADMIN_APPROVAL_ON_NEW_RFQ', FatUtility::VAR_INT, applicationConstants::YES);
        $post['rfq_user_id'] = $this->loggedUserId;
        $post['rfq_lang_id'] = $this->siteLangId;
        $post['rfq_added_on'] = date('Y-m-d H:i:s');
        $post['rfq_approved'] = (0 < $adminApproval ? applicationConstants::NO : applicationConstants::YES);
        $post['rfq_prodcat_id'] = FatApp::getPostedData('rfq_prodcat_id', FatUtility::VAR_INT, 0);
        $rfq = new RequestForQuote($recordId);
        if (false == $rfq->add($post)) {
            $db->rollbackTransaction();
            LibHelper::exitWithError($rfq->getError(), true);
        }
        CalculativeDataRecord::updateRfqCount();

        /* When buyer wants to bind with specific seller. */
        if (0 < $sellerIdArr && RequestForQuote::SELLER_LINKING_OPEN != $linkingType) {
            foreach ($sellerIdArr as $sellerId) {
                $rfqToSeller = [
                    'rfqts_rfq_id' => $rfq->getMainTableRecordId(),
                    'rfqts_user_id' => $sellerId
                ];
                if (!FatApp::getDb()->insertFromArray(RequestForQuote::DB_RFQ_TO_SELLERS, $rfqToSeller, true, array(), $rfqToSeller)) {
                    $db->rollbackTransaction();
                    LibHelper::exitWithError(FatApp::getDb()->getError(), true);
                }
            }

            if (!$adminApproval) {
                $requestForQuote = new RequestForQuote($recordId);
                $attr = [
                    'rfq_title',
                    'rfq_number',
                    'rfq_approved',
                    'rfq_user_id',
                    'rfq_quantity',
                    'rfq_quantity_unit',
                    'rfq_delivery_date',
                    'rfq_description',
                    'rfq_added_on',
                    'ba.*',
                    'selprod_id',
                    'selprod_title',
                    'selprod_user_id',
                    'selprod_product_id',
                    'selprod_updated_on',
                    'shop_name',
                    'bu.user_name',
                    'buc.credential_username',
                    'buc.credential_email',
                    'bu.user_phone_dcode',
                    'bu.user_phone',
                    'rfqts_user_id as seller_id',
                    'IFNULL(country_name, country_code) as country_name',
                    'IFNULL(state_name, state_identifier) as state_name'
                ];
                $rfqData = $requestForQuote->get($this->siteLangId, $attr, 'LEFT');
                $emailHandler = new EmailHandler();
                if (!empty($rfqData)) {
                    $sellers = RequestForQuote::getSellersByRecordId($recordId, true);
                    if (is_array($sellers) && !empty($sellers)) {
                        foreach ($sellers as $sellerData) {
                            $sellerData += $rfqData;
                            if (false === $emailHandler->sendNewRfqAssignedNotification($this->siteLangId, $sellerData)) {
                                $msg = Labels::getLabel('ERR_UNABLE_TO_NOTIFY_SELLERS_FOR_NEW_RFQ_REQUEST.');
                                LibHelper::exitWithError($msg, true);
                            }
                        }
                    }
                }
            }
        }

        if (0 < $selprodId) {
            if (false == $rfq->bindRfqToSeller($selprodData['selprod_id'], $selprodData['selprod_code'], $selprodData['selprod_user_id'])) {
                $db->rollbackTransaction();
                LibHelper::exitWithError($rfq->getError(), true);
            }
        }

        $fileAttached  = false;
        if (isset($_FILES['document']['tmp_name']) && is_uploaded_file($_FILES['document']['tmp_name'])) {
            $fileAttached = true;
            $fileHandlerObj = new AttachedFile();
            if (false == $fileHandlerObj->saveAttachment(
                $_FILES['document']['tmp_name'],
                AttachedFile::FILETYPE_RFQ,
                $rfq->getMainTableRecordId(),
                0,
                $_FILES['document']['name'],
                -1,
                true,
                $this->siteLangId
            )) {
                $fileAttached = false;
                $db->rollbackTransaction();
                LibHelper::exitWithError($fileHandlerObj->getError(), true);
            }
        }

        $user = new User(UserAuthentication::getLoggedUserId());
        $userInfo = $user->getUserInfo(['user_id', 'user_name', 'credential_username', 'credential_email', 'user_phone', 'user_phone_dcode'], false, false, true);

        $address = new Address($post['rfq_addr_id'], $this->siteLangId);
        $address = $address->getData(Address::TYPE_USER, UserAuthentication::getLoggedUserId());

        $shopData = [];
        $product_option_info  = "";
        if (0 < $selprodId) {
            $shopData = Shop::getAttributesByUserId($selprodData['selprod_user_id'], ['shop_name', 'shop_user_id'], langId: $this->siteLangId);
            $shopData['seller_id'] = $shopData['shop_user_id'];

            $selprodOption = SellerProduct::getSellerProductOptionsBySelProdCode($selprodData['selprod_code'], $this->siteLangId);
            foreach ($selprodOption  as $options) {
                $product_option_info .= $options['option_name'] . " : " . $options['optionvalue_name'] . " | ";
            }
        }

        $post['rfq_number'] = $rfq->getRfqNo();
        $catId = $post['rfq_prodcat_id'] ?? 0;
        $catName = '';
        if (0 < $catId) {
            $catData = ProductCategory::getAttributesByLangId($this->siteLangId, $post['rfq_prodcat_id'], ['COALESCE(prodcat_name, prodcat_identifier) as prodcat_name'],true, applicationConstants::JOIN_LEFT);
            $catName = $catData['prodcat_name'];
        }
        $emailData = array_merge($selprodData, $shopData, $userInfo, $address, $post, ['rfq_id' => $rfq->getMainTableRecordId(), 'rfq_added_on' => date("d-m-Y"), 'prodcat_name' => $catName]);
        $weightUnits =  applicationConstants::getWeightUnitsArr($this->siteLangId);


        if (!empty(FatApp::getConfig('CONF_HUBSPOT_TOKEN_KEY', FatUtility::VAR_STRING, ''))) {
            $rfqItemData[$selprodId] = array(
                'buyer_comment' => $emailData['rfq_description'], // multiple
                'description' => rtrim($product_option_info, " | "), // multiple
                'leadRfqNumber' => $emailData['rfq_number'], // multiple
                'product_name' => $emailData['selprod_title'] ?? '', // multiple
                'unit_type' => $weightUnits[$emailData['rfq_quantity_unit']], // multiple
                'product_quantity' => $emailData['rfq_quantity'], // multiple
                'product_price' => 0, // multiple
                'attached_file_url' => ($fileAttached) ? UrlHelper::generateFullUrl('RequestForQuotes', 'downloadFile', array($emailData['rfq_id'])) : "", // multiple
                'product_option_info' => rtrim($product_option_info, " | "), // multiple

            );
            $rfqPostedData = array(
                'email' => $emailData['credential_email'],
                'name' => $emailData['user_name'],
                'phone' =>  ValidateElement::formatDialCode($emailData['user_phone_dcode']) . '' . $emailData['user_phone'],
                'requestForQuote' => true,
                'delivery_address' => $emailData['addr_title'] . ', ' . $emailData['addr_name'] . ', ' . $emailData['addr_address1'] . ', ' . $emailData['addr_address2'] . ', ' . $emailData['addr_city'] . ', ' . $emailData['state_name'] . ', ' . $emailData['country_name'] . ', ' . $emailData['addr_zip'] . ', ' . $emailData['addr_phone_dcode'] . ' ' . $emailData['addr_phone'],
                'deal_amount' => 0,
                'delivery_date' =>  $emailData['rfq_delivery_date'],
                'rfqItemData' => $rfqItemData
            );
            $HubSpotApi = new HubSpotApi($rfqPostedData);
            $HubSpotApi->run();
        }

        $emailHandler = new EmailHandler();
        if (false === $emailHandler->sendNewRfqNotification($this->siteLangId, $emailData)) {
            $msg = $emailHandler->getError();
            $msg = empty($msg) ? Labels::getLabel('ERR_UNABLE_TO_NOTIFY_SITE_ADMIN._NOTIFICATION_LOGGED_TO_SYSTEM.') : $msg;
            LibHelper::exitWithError($msg, true);
        }

        if (RequestForQuote::APPROVED == $post['rfq_approved']) {
            if (false === $emailHandler->sendApprovalStatusRfqNotification($this->siteLangId, $emailData)) {
                $msg = $emailHandler->getError();
                $msg = empty($msg) ? Labels::getLabel('ERR_UNABLE_TO_NOTIFY_SITE_ADMIN._NOTIFICATION_LOGGED_TO_SYSTEM.') : $msg;
                LibHelper::exitWithError($msg, true);
            }

            $sellers = RequestForQuote::getSellersByRecordId($rfq->getMainTableRecordId(), true);
            if (is_array($sellers) && !empty($sellers)) {
                foreach ($sellers as $sellerData) {
                    $sellerData += $emailData;
                    if (false === $emailHandler->sendNewRfqAssignedNotification($this->siteLangId, $sellerData)) {
                        // $msg = $emailHandler->getError();
                        $msg = Labels::getLabel('ERR_UNABLE_TO_NOTIFY_SELLERS_FOR_NEW_RFQ_REQUEST.');
                        LibHelper::exitWithError($msg, true);
                    }
                }
            }
        }
        $db->commitTransaction();
        $this->set('isGuest', $isGuest);
        $this->set('verificationRequired', FatApp::getConfig('CONF_EMAIL_VERIFICATION_REGISTRATION', FatUtility::VAR_INT, 1));
        $this->set('email', $email);
        $this->set('record_id', $rfq->getMainTableRecordId());
        $this->set('msg', Labels::getLabel('MGS_REQUESTED_SUCCESSFULLY', $this->siteLangId));

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        $this->set('redirectUrl', UrlHelper::generateUrl('Custom', 'rfqSuccess', [], CONF_WEBROOT_FRONTEND) . '?rfq_id=' . $rfq->getMainTableRecordId());
        $this->_template->render(false, false, 'json-success.php', false, false);
    }

    public function downloadFile(int $recordId)
    {

        $res = AttachedFile::getAttachment(AttachedFile::FILETYPE_RFQ, $recordId);
        if ($res == false || 1 > $res['afile_id']) {
            LibHelper::exitWithError(Labels::getLabel('ERR_NOT_AVAILABLE_TO_DOWNLOAD', $this->siteLangId), false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('RequestForQuotes'));
        }
        if (!file_exists(CONF_UPLOADS_PATH . $res['afile_physical_path'])) {
            LibHelper::exitWithError(Labels::getLabel('ERR_FILE_NOT_FOUND', $this->siteLangId), false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('RequestForQuotes'));
        }

        AttachedFile::downloadAttachment($res['afile_physical_path'], $res['afile_name']);
    }

    public function addAddress()
    {
        $selprodId = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);
        $addressFrm = $this->getUserAddressForm($this->siteLangId, true);
        $this->set('selprodId', $selprodId);
        $this->set('isUserLogged', ($this->loggedUserId > 0) ? applicationConstants::YES : applicationConstants::NO);
        $this->set('addressFrm', $addressFrm);
        $this->_template->render(false, false);
    }

    public function setUpAddress()
    {
        $frm = $this->getUserAddressForm($this->siteLangId);
        $post = FatApp::getPostedData();
        if (empty($post)) {
            $message = Labels::getLabel('MSG_Invalid_Access', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            Message::addErrorMessage($message);
            FatUtility::dieWithError(Message::getHtml());
        }
        $addr_state_id = FatApp::getPostedData('addr_state_id', FatUtility::VAR_INT, 0);
        $post = $frm->getFormDataFromArray($post);
        if (false === $post) {
            if (true === MOBILE_APP_API_CALL) {
                LibHelper::dieJsonError(current($frm->getValidationErrors()));
            }
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieWithError(Message::getHtml());
        }
        $post['addr_state_id'] = $addr_state_id;
        $addr_id = FatApp::getPostedData('addr_id', FatUtility::VAR_INT, 0);
        unset($post['addr_id']);
        $post['addr_phone_dcode'] = FatApp::getPostedData('addr_phone_dcode', FatUtility::VAR_STRING, '');
        $addressObj = new Address($addr_id);
        $data_to_be_save = $post;
        $data_to_be_save['addr_record_id'] = 0;
        $data_to_be_save['addr_session_id'] = session_id();
        $data_to_be_save['addr_type'] = Address::TYPE_USER;
        $data_to_be_save['addr_lang_id'] = $this->siteLangId;
        $addressObj->assignValues($data_to_be_save, true);
        if (!$addressObj->save()) {
            if (true === MOBILE_APP_API_CALL) {
                LibHelper::dieJsonError($addressObj->getError());
            }
            Message::addErrorMessage($addressObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
        if (0 <= $addr_id) {
            $addr_id = $addressObj->getMainTableRecordId();
        }
        $getHtml = FatApp::getPostedData('getHtml', FatUtility::VAR_INT, 0);
        if (0 < $getHtml && false === MOBILE_APP_API_CALL) {
            $address = new Address();
            $addresses = $address->getData(Address::TYPE_USER, 0, 0, false, session_id());
            $this->set('addresses', $addresses);
            $defaultAddress = current($addresses);
            $this->set('defaultAddress', $defaultAddress);
            $this->set('html', $this->_template->render(false, false, 'addresses/address-element.php', true));
        }
        $this->set('msg', Labels::getLabel('MSG_UPDATED_SUCCESSFULLY', $this->siteLangId));
        if (true === MOBILE_APP_API_CALL) {
            $this->set('data', array('addr_id' => $addr_id));
            $this->_template->render();
        }
        $this->set('addr_id', $addr_id);
        $this->_template->render(false, false, 'json-success.php', false, false);
    }

    public function searchItemAutoComplete()
    {
        $pagesize = 20;
        $post = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }

        $excludeDuplicateNames = FatApp::getPostedData('excludeDuplicateNames', FatUtility::VAR_INT, 0);

        $srch = SellerProduct::getSearchObject($this->siteLangId);
        $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
        $srch->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $this->siteLangId, 'p_l');
        $srch->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'tuc.credential_user_id = sp.selprod_user_id', 'tuc');

        if (FatApp::getConfig("CONF_PRODUCT_BRAND_MANDATORY", FatUtility::VAR_INT, 1)) {
            $srch->joinTable(Brand::DB_TBL, 'INNER JOIN', 'tb.brand_id = product_brand_id and tb.brand_active = ' . applicationConstants::YES . ' and tb.brand_deleted = ' . applicationConstants::NO, 'tb');
        } else {
            $srch->joinTable(Brand::DB_TBL, 'LEFT OUTER JOIN', 'tb.brand_id = product_brand_id', 'tb');
            $srch->addDirectCondition("(case WHEN brand_id > 0 THEN (tb.brand_active = " . applicationConstants::YES . " AND tb.brand_deleted = " . applicationConstants::NO . ") else TRUE end)");
        }

        $srch->addOrder('product_name');
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cnd = $srch->addCondition('product_name', 'LIKE', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('selprod_title', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
            $cnd->attachCondition('product_identifier', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
        }

        $rfqProductType = FatApp::getPostedData('rfq_product_type', FatUtility::VAR_INT, 0);
        if (0 < $rfqProductType) {
            $srch->addCondition('product_type', '=', $rfqProductType);
        }
        $srch->addCondition('selprod_cart_type', '!=', SellerProduct::CART_TYPE_CART_ONLY);

        $srch->addMultipleFields(array('selprod_id as id', 'COALESCE(selprod_title ,product_name, product_identifier) as name', 'credential_username'));
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $products = FatApp::getDb()->fetchAll($srch->getResultSet());
        $searchedItems = [];
        $json = array();
        foreach ($products as $selprod) {
            $options = SellerProduct::getSellerProductOptions($selprod['id'], true, $this->siteLangId);
            $variantsStr = '';
            array_walk($options, function ($item, $key) use (&$variantsStr) {
                $variantsStr .= ' | ' . $item['option_name'] . ' : ' . $item['optionvalue_name'];
            });
            $productName = strip_tags(html_entity_decode($selprod['name'], ENT_QUOTES, 'UTF-8')) . $variantsStr;
            if (1 > $excludeDuplicateNames) {
                $productName .= isset($selprod["credential_username"]) ? " | " . $selprod["credential_username"] : '';
            }

            if (0 < $excludeDuplicateNames && in_array($productName, $searchedItems)) {
                continue;
            }
            $searchedItems[] = $productName;
            $json[] = array(
                'id' => $selprod['id'],
                'text' => $productName,
            );
        }
        if (MOBILE_APP_API_CALL) {
            $this->set('data', ['autocomplete' => $json]);
            $this->_template->render();
        }
        die(json_encode(['results' => $json]));
    }

    public function getSellers()
    {
        $isFavourite = FatApp::getPostedData('rfq_seller_linking_type', FatUtility::VAR_INT, RequestForQuote::SELLER_LINKING_OPEN);
        $isFavourite = (RequestForQuote::SELLER_LINKING_FAVOURITE == $isFavourite);
        Shop::setSellerListingForRfq(true);
        $json = Shop::getSellersAutocomplete($this->siteLangId, $isFavourite, $this->loggedUserId);
        if (MOBILE_APP_API_CALL) {
            $this->set('data', ['pageCount' => $json['pageCount'], 'sellers' => $json['results'] ?? []]);
            $this->_template->render();
        }
        die(FatUtility::convertToJson($json));
    }
	
public function listing()
{

$page = FatApp::getQueryStringData('page', FatUtility::VAR_INT, 1);
$page = max($page, 1);
$pageSize = 10;

    $srch = new SearchBase('tbl_rfq', 'rfq');
    $srch->addCondition('rfq_deleted', '=', 0);
    $srch->addOrder('rfq_added_on', 'DESC');


$srch->setPageNumber($page);
$srch->setPageSize($pageSize);


    $rs = $srch->getResultSet();
    $rfqList = FatApp::getDb()->fetchAll($rs, 'rfq_id');


    // Attach image path
    foreach ($rfqList as $id => $rfq) {
        $userRow = User::getAttributesById($rfq['rfq_user_id'], ['user_name']);
        $rfqList[$id]['user_name'] = $userRow ? $userRow['user_name'] : '';

        $imgSrch = new SearchBase('tbl_attached_files', 'af');
        $imgSrch->addCondition('afile_type', '=', 67);
        $imgSrch->addCondition('afile_record_id', '=', $rfq['rfq_id']);
        $imgSrch->addCondition('afile_lang_id', '=', 1); // assuming Hebrew images

        $imgSrch->addOrder('afile_id', 'DESC');
        $imgSrch->setPageSize(1);
        $imgSrch->doNotCalculateRecords(true);
        $imgSrch->doNotLimitRecords(false);

        $imgRs = $imgSrch->getResultSet();
        $imgRow = FatApp::getDb()->fetch($imgRs);
			// --- BuyHub: Use ImageController::rfq to serve image dynamically ---
			if ($imgRow && !empty($imgRow['afile_id'])) {
				$rfqList[$id]['afile_id'] = $imgRow['afile_id'];
				$rfqList[$id]['image_url'] = CommonHelper::generateUrl('image', 'rfq', [$rfq['rfq_id'], 1, 'DEFAULT']) . '?t=' . $imgRow['afile_id'];

			} else {
				$rfqList[$id]['afile_id'] = 0;
				$rfqList[$id]['image_url'] = CommonHelper::generateUrl('image', 'rfq', [$rfq['rfq_id'], 1, 'DEFAULT']) . '?t=0';

			}
    }

    $this->set('rfqList', $rfqList);
    $this->set('siteLangId', $this->siteLangId);

if ($page > 1) {
    $this->_template->render(false, false, 'request-for-quotes/list-rows.php');
    return;
}

    $this->_template->render(true, true, 'request-for-quotes/listing.php');
}



public function ajaxListing()
{
    $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
    $page = max(1, $page);
    $pageSize = 10;

    $srch = new SearchBase('tbl_rfq', 'rfq');
    $srch->addCondition('rfq_deleted', '=', 0);
    $srch->addOrder('rfq_added_on', 'DESC');
    $srch->setPageNumber($page);
    $srch->setPageSize($pageSize);

    $rs = $srch->getResultSet();
    $rfqList = FatApp::getDb()->fetchAll($rs, 'rfq_id');

    foreach ($rfqList as $id => $rfq) {
        $userRow = User::getAttributesById($rfq['rfq_user_id'], ['user_name']);
        $rfqList[$id]['user_name'] = $userRow ? $userRow['user_name'] : '';

        $imgSrch = new SearchBase('tbl_attached_files', 'af');
        $imgSrch->addCondition('afile_type', '=', 67);
        $imgSrch->addCondition('afile_record_id', '=', $rfq['rfq_id']);
        $imgSrch->addCondition('afile_lang_id', '=', 1);
        $imgSrch->addOrder('afile_id', 'DESC');
        $imgSrch->setPageSize(1);
        $imgSrch->doNotCalculateRecords(true);
        $imgSrch->doNotLimitRecords(false);

        $imgRs = $imgSrch->getResultSet();
        $imgRow = FatApp::getDb()->fetch($imgRs);

        if ($imgRow && !empty($imgRow['afile_id'])) {
            $rfqList[$id]['afile_id'] = $imgRow['afile_id'];
            $rfqList[$id]['image_url'] = CommonHelper::generateUrl('image', 'rfq', [$rfq['rfq_id'], 1, 'DEFAULT']) . '?t=' . $imgRow['afile_id'];
        } else {
            $rfqList[$id]['afile_id'] = 0;
            $rfqList[$id]['image_url'] = CommonHelper::generateUrl('image', 'rfq', [$rfq['rfq_id'], 1, 'DEFAULT']) . '?t=0';
        }
    }

    $this->set('rfqList', $rfqList);
    $this->set('siteLangId', $this->siteLangId);
    $this->_template->render(false, false, 'request-for-quotes/list-rows.php');
}

	
}
