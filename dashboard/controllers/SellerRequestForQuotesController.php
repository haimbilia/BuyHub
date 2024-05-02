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
}
