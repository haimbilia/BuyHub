<?php
class OrderController extends LoggedUserController
{
    public function __construct($action)
    {
        parent::__construct($action);
        if(!User::isBuyer() &&  !User::isSeller()){
            FatApp::redirectUser(UrlHelper::generateUrl('', '', [], CONF_WEBROOT_DASHBOARD));
        }        
    }

    public function index()
    {
        FatApp::redirectUser(UrlHelper::generateUrl('', '', [], CONF_WEBROOT_DASHBOARD));
    }

    private function getOrderProducts($orderId, $opId = 0): array
    {
        $opSrch = new OrderProductSearch($this->siteLangId, false, true, true);
        $opSrch->joinShippingCharges();
        $opSrch->joinSellerProducts();
        $opSrch->joinAddress();
        $opSrch->joinOrderProductShipment();
        $opSrch->addCountsOfOrderedProducts();
        $opSrch->addOrderProductCharges();
        $opSrch->joinOrderProductSpecifics();
        $opSrch->doNotCalculateRecords();
        $opSrch->doNotLimitRecords();
        $opSrch->addCondition('op.op_order_id', '=', $orderId);

        if(0 < $opId){
            $opSrch->addCondition('op.op_id', '=', $opId);
        }
        $opSrch->addMultipleFields(
            [
                'op_id', 'op.op_order_id', 'op_selprod_user_id', 'op_invoice_number', 'op_selprod_title', 'op_product_name',
                'op_qty', 'op_brand_name', 'op_selprod_options', 'op_selprod_sku', 'op_product_model',
                'op_shop_name', 'op_shop_owner_name', 'op_shop_owner_email', 'op_shop_owner_phone', 'op_unit_price',
                'totCombinedOrders as totOrders', 'op_shipping_duration_name', 'op_shipping_durations', 'IFNULL(orderstatus_name, orderstatus_identifier) as orderstatus_name', 'op_other_charges', 'op_product_tax_options', 'ops.*', 'opship.*', 'opr_response', 'addr.*', 'ts.state_code', 'tc.country_code', 'op_rounding_off',
                'op_shop_owner_phone_dcode', 'op_selprod_price', 'op_special_price', 'opshipping_by_seller_user_id', 'op_is_batch', 'op_selprod_id', 'selprod_product_id'
            ]
        );
        return (array) FatApp::getDb()->fetchAll($opSrch->getResultSet());
    }

    public function orderProductsCharges($orderId, int $chargeType = 0, int $opId = 0)
    {        
        $opsShippingDetail = $this->getOrderProducts($orderId, $opId);

        $oObj = new Orders();
        foreach ($opsShippingDetail as &$op) {
            $charges = $oObj->getOrderProductChargesArr($op['op_id']);
            $op['charges'] = $charges;
            if($chargeType == OrderProduct::CHARGE_TYPE_TAX){
                $opChargesLog = new OrderProductChargeLog($op['op_id']);
                $taxOptions = $opChargesLog->getData($this->siteLangId);
                $op['taxOptions'] = $taxOptions;
            }            
        }

        $this->set('opsShippingDetail', $opsShippingDetail);
        switch ($chargeType) {
            case OrderProduct::CHARGE_TYPE_SHIPPING:
                $this->_template->render(false, false, 'order/order-products-shipping.php');
                break;
            case OrderProduct::CHARGE_TYPE_TAX:
                $this->_template->render(false, false, 'order/order-products-tax.php');
                break;

            default:
                Message::addErrorMessage(Labels::getLabel('ERR_INVALID_CHARGE_TYPE', $this->siteLangId));
                FatUtility::dieWithError(Message::getHtml());
                break;
        }
    }
}
