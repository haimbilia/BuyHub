<?php
class RequestForQuotesController extends BuyerBaseController
{
    use RequestForQuotesUtility;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->isBuyer = true;
    }
}
