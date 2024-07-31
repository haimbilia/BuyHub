<?php
class SellerRequestForQuotesController extends SellerBaseController
{
    use RequestForQuotesUtility;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->isSeller = true;

        $this->userPrivilege->canViewRfqOffers($this->userId);
    }

    public function global()
    {
        $this->set('funcName', __FUNCTION__);
        $this->index();
    }

    public function assignToMe(int $rfqId)
    {
        $this->userPrivilege->canEditRequestForQuote($this->userId);

        if (!UserPrivilege::isUserHasValidSubsription($this->userParentId)) {
            LibHelper::exitWithError(Labels::getLabel("MSG_PLEASE_BUY_SUBSCRIPTION", $this->siteLangId));
        }

        $rfqInfo = RequestForQuote::getAttributesById($rfqId, ['rfq_visibility_type', 'rfq_added_on']);
        if (empty($rfqInfo['rfq_visibility_type']) || RequestForQuote::VISIBILITY_TYPE_CLOSED == $rfqInfo['rfq_visibility_type'] || strtotime($rfqInfo['rfq_added_on']) < strtotime($this->userInfo['user_regdate'])) {
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
