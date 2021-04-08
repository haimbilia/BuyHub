<?php

class OrderProductShipment extends MyAppModel
{
    public const DB_TBL = 'tbl_order_product_shipment';
    public const DB_TBL_PREFIX = 'opship_';

    private $langId;
        
    /**
     * __construct
     *
     * @param  int $id
     * @param  int $langId
     * @return void
     */
    public function __construct(int $id = 0, int $langId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'op_id', $id);
        $this->langId = (0 < $langId ? $langId : $this->commonLangId);
    }
    
    /**
     * getAttributesById
     *
     * @param  int $recordId
     * @param  mixed $attr
     * @return void
     */
    public static function getAttributesById($recordId, $attr = null, $joinOrderProduct = false)
    {
        $recordId = FatUtility::convertToType($recordId, FatUtility::VAR_INT);
        $db = FatApp::getDb();

        $srch = new SearchBase(static::DB_TBL);
        if (true === $joinOrderProduct) {
            $srch->joinTable(Orders::DB_TBL_ORDER_PRODUCTS, 'LEFT OUTER JOIN', 'op.op_id = opship_op_id', 'op');
        }
        $srch->joinTable(OrderProduct::DB_TBL_RESPONSE, 'LEFT JOIN', 'opr_op_id = opship_op_id AND opr_type = ' . OrderProduct::RESPONSE_TYPE_SHIPMENT, 'opr');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition(static::DB_TBL_PREFIX . 'op_id', '=', $recordId);

        if (null != $attr) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } elseif (is_string($attr)) {
                $srch->addFld($attr);
            }
        }

        $rs = $srch->getResultSet();
        $row = $db->fetch($rs);

        if (!is_array($row)) {
            return false;
        }

        if (is_string($attr)) {
            return $row[$attr];
        }

        return $row;
    }
}
