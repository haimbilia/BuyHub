<?php
class SellerRequestForQuotesController extends SellerBaseController
{
    use RequestForQuotesUtility;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->isSeller = true;
    }

    public function global()
    {
        $this->set('funcName', __FUNCTION__);
        $this->index();
    }

    public function assignToMe(int $rfqId)
    {
        $visibilityType = RequestForQuote::getAttributesById($rfqId, 'rfq_visibility_type');
        if (empty($visibilityType) || RequestForQuote::VISIBILITY_TYPE_CLOSED == $visibilityType) {
            LibHelper::exitWithError($this->str_invalid_Action, true);
        }
        $rfqToSeller = [
            'rfqts_rfq_id' => $rfqId,
            'rfqts_user_id' => $this->userParentId
        ];
        if (!FatApp::getDb()->insertFromArray(RequestForQuote::DB_RFQ_TO_SELLERS, $rfqToSeller, true, array(), $rfqToSeller)) {
            LibHelper::exitWithError(FatApp::getDb()->getError(), true);
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_SUCCESS'));
    }
}
