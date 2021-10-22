<?php

class RelatedProductsController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSellerProducts();
    }
}
