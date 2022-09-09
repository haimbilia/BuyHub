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
    
    public static function setNotificationDetail($template)
    {
        $notifyObject = Notification::getSearchObject();
        $notifyObject->addCondition('n.' . Notification::DB_TBL_PREFIX . 'deleted', '=', applicationConstants::NO);
        $notifyObject->addCondition('n.' . Notification::DB_TBL_PREFIX . 'marked_read', '=', applicationConstants::NO);
        $notifyObject->doNotLimitRecords();
        $notifyObject->getResultSet();
        $template->set('notificationCount', $notifyObject->recordCount());
    }
}
    