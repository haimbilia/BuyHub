<?php

class HomeController extends FatController
{
    public function index()
    {
        FatApp::redirectUser(UrlHelper::generateUrl('account'));
    }
}
