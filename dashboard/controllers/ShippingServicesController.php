<?php

class ShippingServicesController extends SellerBaseController
{    
    use ShippingServices;

    /**
     * __construct
     *
     * @param  string $action
     * @return void
     */
    public function __construct($action)
    {
        parent::__construct($action);
        $this->langId = $this->siteLangId;        
    }

    public function shippingRatesForm(int $opId)
    {
        $frm = $this->getShippingRatesForm($opId);       
        $frm->fill(['op_id' => $opId]);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }
    
}
