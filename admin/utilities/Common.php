<?php
class Common
{
    public static function setHeaderBreadCrumb($template)
    {
        $controllerName = FatApp::getController();
        $action = FatApp::getAction();

        $controller = new $controllerName('');
        $template->set('nodes', $controller->getBreadcrumbNodes($action));
        $template->set('siteLangId', CommonHelper::getlangId());
    }
    
    public static function excludeKeysForSort()
    {
        return ['select_all', 'listSerial', 'action'];
    }
}
