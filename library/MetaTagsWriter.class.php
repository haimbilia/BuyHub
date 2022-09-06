<?php
class MetaTagsWriter
{
    public static function getMetaTags($controller, $action, $arrParameters, $returnArr = false)
    {
        $langId = CommonHelper::getLangId();
        if (!$langId) {
            $langId = FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1);
        }

        $websiteName = FatApp::getConfig('CONF_WEBSITE_NAME_' . $langId, FatUtility::VAR_STRING, '');

        $controller = explode('-', FatUtility::camel2dashed($controller));
        array_pop($controller);
        $controllerName = implode('-', $controller);
        $controllerName = ucfirst(FatUtility::dashed2Camel($controllerName));

        $srch = new MetaTagSearch($langId);
        $cond = $srch->addCondition('meta_controller', '=', $controllerName);
        $cond->attachCondition('meta_controller', '=', '', 'OR');

        $cond1 = $srch->addCondition('meta_action', '=', $action);
        $cond1->attachCondition('meta_action', '=', '', 'OR');

        $srch->addOrder('meta_default', 'asc');

        if (!empty($arrParameters)) {
            if (isset($arrParameters[0]) && FatUtility::int($arrParameters[0]) > 0) {
                $cond = $srch->addCondition('meta_record_id', '=', FatUtility::int($arrParameters[0]));
                $cond->attachCondition('meta_record_id', '=', 0, 'OR');
                $srch->addOrder('meta_record_id', 'DESC');
            }
            if (isset($arrParameters[1]) && FatUtility::int($arrParameters[1]) > 0) {
                $cond = $srch->addCondition('meta_subrecord_id', '=', FatUtility::int($arrParameters[1]));
                $cond->attachCondition('meta_subrecord_id', '=', 0, 'OR');
                $srch->addOrder('meta_subrecord_id', 'DESC');
            }
        }

        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addMultipleFields(array(
            'meta_title',
            'meta_keywords', 'meta_description', 'meta_other_meta_tags'
        ));

        $rs = $srch->getResultSet();
        $title = $websiteName;
        $metas = FatApp::getDb()->fetch($rs);

        if (true == $returnArr) {
            $metas = (!empty($metas)) ? $metas : [];
            return $metas;
        }

        if ($metas) {
            $title = $metas['meta_title'] . ' | ' . $title;
            echo '<title>' . $title . '</title>' . "\n";
            echo '<meta name="application-name" content="' . $title . '">' . "\n";
            echo '<meta name="apple-mobile-web-app-title" content="' . $title . '">' . "\n";
            if (isset($metas['meta_description'])) {
                echo '<meta name="description" content="' . $metas['meta_description'] . '" />';
            }
            if (isset($metas['meta_keywords'])) {
                echo '<meta name="keywords" content="' . $metas['meta_keywords'] . '" />';
            }
            if (isset($metas['meta_other_meta_tags'])) {
                echo CommonHelper::renderHtml($metas['meta_other_meta_tags'], ENT_QUOTES, 'UTF-8');
            }
        } else {
            return "<title>" . $websiteName . "</title>\n<meta name='application-name' content='" . $title . "'>\n
			<meta name='apple-mobile-web-app-title' content='" . $title . "'>";
        }
    }
}
