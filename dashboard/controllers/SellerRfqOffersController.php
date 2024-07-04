<?php
class SellerRfqOffersController extends SellerBaseController
{
    use RfqOffersUtility;
    public function __construct($action)
    {
        parent::__construct($action);
        $this->userPrivilege->canViewRfqOffers($this->userId);
        $this->isSeller = true;
        $this->set('canEdit', $this->userPrivilege->canEditRfqOffers($this->userId, true));
    }

    public function deleteRecord()
    {
        $this->userPrivilege->canEditRfqOffers($this->userId);

        $rfqId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $offerId = FatApp::getPostedData('subRecordId', FatUtility::VAR_INT, 0);
        if ($rfqId < 1 || $offerId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        if (!RfqOffers::canModify($rfqId, $offerId)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_ACTION_RESTRICTED!_THIS_OFFER_HAS_BEEN_ACCEPTED/REJECTED.'), true);
        }

        $this->markAsDeleted($offerId);

        $updateArray = array('rlo_deleted' => applicationConstants::YES);
        $whr = array('smt' => 'rlo_seller_offer_id = ?', 'vals' => [$offerId]);

        $db = FatApp::getDb();
        if (!$db->updateFromArray(RfqOffers::DB_RFQ_LATEST_OFFER, $updateArray, $whr)) {
            LibHelper::exitWithError($db->getError(), true);
        }
        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    protected function markAsDeleted(int $recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $rfqOffer = new RfqOffers($recordId);
        $rfqOffer->setFldValue('offer_quantity', 'mysql_func_null', true);
        $rfqOffer->assignValues(
            [
                $rfqOffer::tblFld('deleted') => 1
            ],
            false,
            '',
            '',
            true
        );
        if (!$rfqOffer->save()) {
            LibHelper::exitWithError($rfqOffer->getError(), true);
        }
    }

    public function getInventoryListing(int $rfqId)
    {
        $pagesize = 20;
        $post = FatApp::getPostedData();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }

        $rfqData = RequestForQuote::getAttributesById($rfqId, ['rfq_selprod_code', 'rfq_selprod_id', 'rfq_product_id', 'rfq_visibility_type']);
        $selprodCode = $rfqData['rfq_selprod_code'];

        $srch = SellerProduct::getSearchObject($this->siteLangId);

        if ($rfqData['rfq_selprod_id'] > 0 && $rfqData['rfq_product_id'] > 0) {
            $srch->joinTable(RequestForQuote::DB_TBL, 'INNER JOIN', 'rfq.rfq_product_id = sp.selprod_product_id AND rfq.rfq_id = ' . $rfqId, 'rfq');
        }
        $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
        $srch->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $this->siteLangId, 'p_l');
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cnd = $srch->addCondition('selprod_title', 'LIKE', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('product_name', 'LIKE', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('product_identifier', 'LIKE', '%' . $post['keyword'] . '%');
        }

        $srch->addCondition('selprod_user_id', '=', $this->userId);
        $srch->addOrder('selprod_active', 'DESC');
        $srch->addCondition('selprod_deleted', '=', applicationConstants::NO);
        $srch->addCondition('selprod_active', '=', applicationConstants::ACTIVE);
        if ($rfqData['rfq_selprod_id'] > 0 && $rfqData['rfq_product_id'] > 0) {
            $srch->addCondition('selprod_code', 'LIKE', $selprodCode);
        }
        $srch->addOrder('product_name');
        $srch->addMultipleFields(array('selprod_id as id', 'COALESCE(selprod_title ,product_name, product_identifier) as product_name'));

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $products = FatApp::getDb()->fetchAll($srch->getResultSet(), 'id');
        $pageCount = $srch->pages();
        $json = array();
        foreach ($products as $key => $option) {
            $options = SellerProduct::getSellerProductOptions($key, true, $this->siteLangId);
            $variantsStr = '';
            array_walk($options, function ($item, $key) use (&$variantsStr) {
                $variantsStr .= ' | ' . $item['option_name'] . ' : ' . $item['optionvalue_name'];
            });
            $userName = isset($option["credential_username"]) ? " | " . $option["credential_username"] : '';
            $json[] = array(
                'id' => $key,
                'text' => strip_tags(html_entity_decode($option['product_name'], ENT_QUOTES, 'UTF-8')) . $variantsStr . $userName,
            );
        }
        die(json_encode(['pageCount' => $pageCount, 'results' => $json]));
    }

    public function linkInventoryForm(int $rfqId)
    {
        if (1 > $rfqId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $productId = RequestForQuote::getAttributesById($rfqId, 'rfq_product_id');
        $frm = $this->getLinkInventoryForm();
        $frm->fill(['rfqts_rfq_id' => $rfqId]);
        $this->set('productId', $productId);
        $this->set('includeTabs', false);
        $this->set('rfqId', $rfqId);
        $this->set('frm', $frm);
        $this->set('html', $this->_template->render(false, false, 'rfq-offers/link-inventory-form.php', true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function getLinkInventoryForm()
    {
        $frm = new Form('frmLinkInventory');
        $frm->addHiddenField('', 'rfqts_rfq_id');
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_SELECT_INVENTORY', $this->siteLangId), 'rfqts_selprod_id', []);
        $fld->requirements()->setRequired(true);
        return $frm;
    }

    public function linkInventory()
    {
        $frm = $this->getLinkInventoryForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $rfqId = FatApp::getPostedData('rfqts_rfq_id', FatUtility::VAR_INT, 0);
        $selProdId = FatApp::getPostedData('rfqts_selprod_id', FatUtility::VAR_INT, 0);
        if (1 > $rfqId || 1 > $selProdId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $rfqData = RequestForQuote::getAttributesById($rfqId, ['rfq_approved']);

        if (false == $rfqData || $rfqData['rfq_approved'] != RequestForQuote::APPROVED) {
            LibHelper::exitWithError(Labels::getLabel('ERR_RFQ_STATUS_IS_NOT_APPROVED'), true);
        }

        $selprodUserId = SellerProduct::getAttributesById($selProdId, 'selprod_user_id');
        if ($selprodUserId != $this->userId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $db = FatApp::getDb();
        $db->startTransaction();
        $rfq = new RequestForQuote($rfqId);
        $data = [
            'rfqts_user_id' => $this->userId,
            'rfqts_selprod_id' => $selProdId,
        ];
        if (false == $rfq->linkToSeller($data)) {
            $db->rollbackTransaction();
            LibHelper::exitWithError($rfq->getError(), true);
        }
        $db->commitTransaction();
        $this->set('selProdId', $selProdId);
        $this->set('msg', Labels::getLabel('MGS_LINKED_SUCCESSFULLY.', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
}
