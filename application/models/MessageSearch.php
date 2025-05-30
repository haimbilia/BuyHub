<?php

class MessageSearch extends SearchBase
{
    private $langId;
    private $joinThreadMessage = false;
    private $joinOrderProducts = false;
    private $commonLangId;
    public function __construct()
    {
        parent::__construct(Thread::DB_TBL, 'tth');
        $this->commonLangId = CommonHelper::getLangId();
    }

    public function joinThreadStartedByUser()
    {
        $this->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'tth.thread_started_by = tu.user_id', 'tu');
        $this->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'tu_c.credential_user_id = tu.user_id', 'tu_c');
        $this->addMultipleFields(array('tu.user_name as thread_started_by_name', 'tu_c.credential_email as thread_started_by_email', 'tu_c.credential_username as thread_started_by_username'));
    }

    public function joinThreadMessage()
    {
        $this->joinThreadMessage = true;
        $this->joinTable(Thread::DB_TBL_THREAD_MESSAGES, 'LEFT OUTER JOIN', 'tth.thread_id = ttm.message_thread_id', 'ttm');
    }
    public function joinThreadLastMessage()
    {
        $this->joinThreadMessage = true;
        $srch = new SearchBase(Thread::DB_TBL_THREAD_MESSAGES);
        $srch->addGroupBy(Thread::DB_TBL_THREAD_MESSAGES_PREFIX . 'id');
        $srch->addOrder(Thread::DB_TBL_THREAD_MESSAGES_PREFIX . 'id', 'desc');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'tth.thread_id = ttm.message_thread_id', 'ttm');
        /* $this->joinTable(Thread::DB_TBL_THREAD_MESSAGES, 'LEFT OUTER JOIN', 'tth.thread_id = ttm.message_thread_id', 'ttm'); */
    }

    public function joinMessagePostedFromUser($joinShop = false, $langId = 0)
    {
        if (!$this->joinThreadMessage) {
            trigger_error(Labels::getLabel('ERR_YOU_HAVE_NOT_JOINED_JOINTHREADMESSAGE.', $this->commonLangId), E_USER_ERROR);
        }

        $fields = array('tfr.user_id as message_from_user_id', 'tfr.user_name as message_from_name', 'tfr_c.credential_email as message_from_email', 'tfr_c.credential_username as message_from_username');
        $this->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'ttm.message_from = tfr.user_id', 'tfr');
        $this->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'tfr_c.credential_user_id = tfr.user_id', 'tfr_c');
        if (true == $joinShop && $langId > 0) {
            $this->joinTable(Shop::DB_TBL, 'LEFT OUTER JOIN', 'tfrs.shop_user_id = if(tfr.user_parent > 0, tfr.user_parent, tfr.user_id)', 'tfrs');
            $this->joinTable(Shop::DB_TBL_LANG, 'LEFT OUTER JOIN', 'tfrs_l.shoplang_shop_id = tfrs.shop_id and tfrs_l.shoplang_lang_id = ' . $langId, 'tfrs_l');
            $fields = $fields + array('IFNULL(tfrs_l.shop_name, tfrs.shop_identifier) as message_from_shop_name', 'tfrs.shop_id as message_from_shop_id');
        }
        $this->addMultipleFields($fields);
    }

    public function joinMessagePostedToUser($joinShop = false, $langId = 0)
    {
        if (!$this->joinThreadMessage) {
            trigger_error(Labels::getLabel('ERR_YOU_HAVE_NOT_JOINED_JOINTHREADMESSAGE.', $this->commonLangId), E_USER_ERROR);
        }

        $fields = array('tfto.user_id as message_to_user_id', 'tfto.user_name as message_to_name', 'tfto_c.credential_email as message_to_email', 'tfto_c.credential_username as message_to_username');
        $this->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'ttm.message_to = tfto.user_id', 'tfto');
        $this->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'tfto_c.credential_user_id = tfto.user_id', 'tfto_c');
        if (true == $joinShop && $langId > 0) {
            $this->joinTable(Shop::DB_TBL, 'LEFT OUTER JOIN', 'tftos.shop_user_id = if(tfto.user_parent > 0, tfto.user_parent, tfto.user_id)', 'tftos');
            $this->joinTable(Shop::DB_TBL_LANG, 'LEFT OUTER JOIN', 'tftos_l.shoplang_shop_id = tftos.shop_id and tftos_l.shoplang_lang_id = ' . $langId, 'tftos_l');
            $fields = $fields + array('IFNULL(tftos_l.shop_name, tftos.shop_identifier) as message_to_shop_name', 'tftos.shop_id as message_to_shop_id');
        }
        $this->addMultipleFields($fields);
    }

    public function joinShops($langId = 0)
    {
        $this->joinTable(Shop::DB_TBL, 'LEFT OUTER JOIN', 'ts.shop_id = tth.thread_record_id and tth.thread_type = ' . Thread::THREAD_TYPE_SHOP, 'ts');
        if ($langId > 0) {
            $this->joinTable(Shop::DB_TBL_LANG, 'LEFT OUTER JOIN', 'ts_l.shoplang_shop_id = ts.shop_id and ts_l.shoplang_lang_id = ' . $langId, 'ts_l');
            $this->addMultipleFields(array('IFNULL(ts_l.shop_name,ts.shop_identifier) as shop_name'));
        } else {
            $this->addMultipleFields(array('ts.shop_identifier as shop_name'));
        }
    }

    public function joinProducts($langId = 0)
    {
        $this->joinTable(SellerProduct::DB_TBL, 'LEFT OUTER JOIN', 'tsp.selprod_id = tth.thread_record_id and tth.thread_type = ' . Thread::THREAD_TYPE_PRODUCT, 'tsp');
        $this->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = tsp.selprod_product_id', 'p');
        if ($langId > 0) {
            $this->joinTable(SellerProduct::DB_TBL_LANG, 'LEFT OUTER JOIN', 'tsp.selprod_id = tsp_l.selprodlang_selprod_id AND tsp_l.selprodlang_lang_id = ' . $langId, 'tsp_l');
            $this->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $langId, 'p_l');
            $this->addMultipleFields(array('IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title, selprod_price'));
        } else {
            $this->addMultipleFields(array('IFNULL(selprod_title, product_identifier) as selprod_title', 'selprod_price'));
        }
    }

    public function joinOrderProducts($langId = 0)
    {
        $this->joinOrderProducts = true;

        $this->joinTable(Orders::DB_TBL_ORDER_PRODUCTS, 'LEFT OUTER JOIN', 'tth.thread_record_id = top.op_id and tth.thread_type = ' . Thread::THREAD_TYPE_ORDER_PRODUCT, 'top');
        if ($langId > 0) {
            $this->joinTable(Orders::DB_TBL_ORDER_PRODUCTS_LANG, 'LEFT OUTER JOIN', 'top_l.oplang_op_id = top.op_id and  top_l.oplang_lang_id = ' . $langId, 'top_l');
        }
    }

    public function joinOrderProductStatus($langId = 0)
    {
        if (!$this->joinOrderProducts) {
            trigger_error(Labels::getLabel('ERR_YOU_HAVE_NOT_JOINED_JOINORDERPRODUCTS.', $this->commonLangId), E_USER_ERROR);
        }

        $this->joinTable(Orders::DB_TBL_ORDERS_STATUS, 'LEFT OUTER JOIN', 'top.op_status_id = tops.orderstatus_id', 'tops');
        if ($langId > 0) {
            $this->joinTable(Orders::DB_TBL_ORDERS_STATUS_LANG, 'LEFT OUTER JOIN', 'tops_l.orderstatuslang_orderstatus_id = top.op_status_id and  tops_l.orderstatuslang_lang_id = ' . $langId, 'tops_l');
            $this->addMultipleFields(array('IFNULL(tops_l.orderstatus_name,tops.orderstatus_identifier) as orderstatus_name'));
        } else {
            $this->addMultipleFields(array('tops.orderstatus_identifier as orderstatus_name'));
        }
    }
   
}
