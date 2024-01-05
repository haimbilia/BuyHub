<?php
class RfqOffersController extends BuyerBaseController
{
    use RfqOffersUtility;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->isBuyer = true;
        $this->set('isBuyer', true);
    }
}
