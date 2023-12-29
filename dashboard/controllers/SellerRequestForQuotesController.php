<?php
class SellerRequestForQuotesController extends SellerBaseController
{
    use RequestForQuotesUtility;
    
    public function __construct($action)
    {
        parent::__construct($action);
        $this->isSeller = true;
    }
}
