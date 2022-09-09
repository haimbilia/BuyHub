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
        $notify = Notification::getSearchObject();
        $notify->addCondition('n.' . Notification::DB_TBL_PREFIX . 'deleted', '=', applicationConstants::NO);
        $notify->addCondition('n.' . Notification::DB_TBL_PREFIX . 'marked_read', '=', applicationConstants::NO);
        $notify->doNotCalculateRecords();
        $notify->addFld('COUNT(1) as recordCount');
        $result = (array)FatApp::getDb()->fetch($notify->getResultSet());
        $template->set('notificationCount', $result['recordCount']);
    }
}
