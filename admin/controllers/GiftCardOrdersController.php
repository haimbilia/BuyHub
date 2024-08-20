<?php

class GiftCardOrdersController extends ListingBaseController
{
    protected string $pageKey = 'MANAGE_GIFT_CARDS_ORDER';
    use OrdersPackage;

    private int $ordersType = Orders::GIFT_CARD_TYPE;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewOrders();
    }

    private function orderData(int $orderId)
    {
        $srch = new OrderSearch($this->siteLangId);
        $srch->joinOrderPaymentMethod();
        $srch->doNotCalculateRecords();
        $srch->joinTable(GiftCards::DB_TBL, 'INNER JOIN', 'ogcards.ogcards_order_id = order_id', 'ogcards');
        $srch->setPageSize(1);
        $srch->joinOrderBuyerUser();
        $srch->addMultipleFields(
            array(
                'order_number', 'order_id', 'order_user_id', 'order_date_added', 'order_payment_status', 'order_tax_charged', 'order_site_commission',
                'order_reward_point_value', 'order_volume_discount_total', 'buyer.user_name as buyer_user_name', 'buyer_cred.credential_email as buyer_email', 'buyer.user_phone_dcode as buyer_phone_dcode', 'buyer.user_phone as buyer_phone', 'order_net_amount', 'order_shippingapi_name', 'order_pmethod_id', 'ifnull(plugin_name,plugin_identifier)as plugin_name', 'order_discount_total', 'plugin_code', 'order_is_wallet_selected', 'order_reward_point_used', 'order_deleted', 'order_rounding_off', 'ogcards.ogcards_receiver_name', 'ogcards.ogcards_receiver_email', 'ogcards.ogcards_status'
            )
        );
        $srch->addCondition('order_id', '=', $orderId);
        $srch->addCondition('order_type', '=', $this->ordersType);
        $rs = $srch->getResultSet();
        $this->order = (array) FatApp::getDb()->fetch($rs);
        if (empty($this->order)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_ORDER_DATA_NOT_FOUND', $this->siteLangId), false, true);
            CommonHelper::redirectUserReferer();
        }
        $this->order['products'] = [];
        $orderObj = new Orders($this->order['order_id']);
        $this->order['comments'] = $orderObj->getOrderComments($this->siteLangId, array("order_id" => $this->order['order_id']));
        $this->order['payments'] = $orderObj->getOrderPayments(array("order_id" => $this->order['order_id']));
        $this->set('order', $this->order);

        $paymentMethodName = !empty($this->order['plugin_name']) ?  $this->order['plugin_name'] : '';
        if (!empty($paymentMethodName) && $this->order['order_pmethod_id'] > 0 && $this->order['order_is_wallet_selected'] > 0) {
            $paymentMethodName  .= ' + ';
        }
        if ($this->order['order_is_wallet_selected'] > 0) {
            $paymentMethodName .= Labels::getLabel("LBL_Wallet", $this->siteLangId);
        }

        $this->set("paymentMethodName", $paymentMethodName);

        $this->set("canEdit", $this->objPrivilege->canEditOrders($this->admin_id, true));
        $this->set("canEditSellerOrders", $this->objPrivilege->canEditSellerOrders($this->admin_id, true));
    }


    protected function getSearchForm($fields = [])
    {
        $currency_id = FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1);
        $currencyData = Currency::getAttributesById($currency_id, array('currency_code', 'currency_symbol_left', 'currency_symbol_right'));
        $currencySymbol = ($currencyData['currency_symbol_left'] != '') ? $currencyData['currency_symbol_left'] : $currencyData['currency_symbol_right'];

        $frm = new Form('frmRecordSearch');

        $frm->addHiddenField('', 'page');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'order_date_added', applicationConstants::SORT_DESC);
        }
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $frm->addSelectBox(Labels::getLabel('FRM_BUYER', $this->siteLangId), 'user_id', []);

        $frm->addSelectBox(Labels::getLabel('FRM_DELETED_ORDERS', $this->siteLangId), 'order_deleted', applicationConstants::getYesNoArr($this->siteLangId));

        $frm->addSelectBox(Labels::getLabel('FRM_PAYMENT_STATUS', $this->siteLangId), 'order_payment_status', Orders::getOrderPaymentStatusArr($this->siteLangId));

        $frm->addDateField(Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'date_from', '', array('placeholder' => Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addDateField(Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'date_to', '', array('placeholder' => Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'field--calender'));

        $str = Labels::getLabel('FRM_ORDER_FROM_[{CURRENCY-SYMBOL}]', $this->siteLangId);
        $str = CommonHelper::replaceStringData($str, ['{CURRENCY-SYMBOL}' => $currencySymbol]);
        $frm->addTextBox(Labels::getLabel('FRM_ORDER_FROM', $this->siteLangId), 'price_from', '', array('placeholder' => $str));

        $str = Labels::getLabel('FRM_ORDER_TO[{CURRENCY-SYMBOL}]', $this->siteLangId);
        $str = CommonHelper::replaceStringData($str, ['{CURRENCY-SYMBOL}' => $currencySymbol]);
        $frm->addTextBox(Labels::getLabel('FRM_ORDER_TO', $this->siteLangId), 'price_to', '', array('placeholder' => $str));


        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);/*clearBtn*/
        return $frm;
    }



    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'view':
                $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? Labels::getLabel('LBL_ORDER_GIFT_CARDS', $this->siteLangId);
                $this->nodes = [
                    ['title' => $pageTitle, 'href' => UrlHelper::generateUrl('GiftCardOrders')],
                ];

                $url = FatApp::getQueryStringData('url');
                $urlParts = explode('/', $url);
                $title = Labels::getLabel('LBL_VIEW', $this->siteLangId);
                if (isset($urlParts[2])) {
                    $referenceNo = OrderReturnRequest::getAttributesById($urlParts[2], 'orrequest_reference');
                    if (!empty($referenceNo)) {
                        $this->nodes[] = ['title' => $referenceNo];
                    }
                }
                $this->nodes[] = ['title' => $title];
                break;
            default:
                parent::getBreadcrumbNodes($action);
                break;
        }
        return $this->nodes;
    }
}
