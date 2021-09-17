<?php
class Common
{
    public static function setHeaderBreadCrumb($template)
    {
        $controllerName = FatApp::getController();
        $action = FatApp::getAction();

        $controller = new $controllerName('');
        $template->set('nodes', $controller->getBreadcrumbNodes($action));
        $template->set('adminLangId', CommonHelper::getlangId());
    }

    public static function getListingHeaderColumnHtml($key, $sortBy, $sortOrder)
    {
        if ($key == $sortBy) {
            if ($sortOrder == applicationConstants::SORT_ASC) {
                return [
                    'class' => 'sorting_asc',
                    'html' => '<i class="icn">
                    <svg class="svg" width="18" height="18">
                        <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#arrow-down">
                        </use>
                    </svg>
                </i>'
                ];
            }

            return [
                'class' => 'sorting_desc',
                'html' => '<i class="icn">
                <svg class="svg" width="18" height="18">
                    <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#arrow-up">
                    </use>
                </svg>
            </i>'
            ];
        }

        return [
            'class' => '',
            'html' => ''
        ];
    }

    public static function excludeKeysForSort()
    {
        return ['select_all', 'listSerial', 'action'];
    }
}
