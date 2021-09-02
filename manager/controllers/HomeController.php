<?php

class HomeController extends FatController
{
    public function __construct($action)
    {
        parent::__construct($action);  
        $this->adminLangId =1;
        $this->_template->addCss('css/main-ltr.css');     
    }

    public function index()
    {
        $this->_template->render();
    }
}