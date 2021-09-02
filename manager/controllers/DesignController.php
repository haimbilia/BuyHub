<?php

class DesignController extends FatController
{
    public function __construct($action)
    {
        parent::__construct($action);  
        $this->adminLangId =1;
        // $this->_template->addCss('css/main-ltr.css');     
    }

    public function index($page = '')
    {
        $this->_template->render(false,false,'design/'.$page);
    }
    public function email($page = '')
    {
        $this->_template->render(false,false,'design/email/'.$page);
    }
    public function custom($page = '')
    {
        $this->_template->render(false,false,'design/custom/'.$page);
    }
}