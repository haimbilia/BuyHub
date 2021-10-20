<?php
class HtmlHelper
{
    public const SUCCESS = 1;
    public const WARNING = 2;
    public const DANGER = 3;
    public const PRIMARY = 4;
    public const INFO = 5;

    public static function getLoader()
    {
        return '<div class="table-processing">
                    <div class="spinner spinner--sm spinner--brand"></div>
                </div>';
    }

    public static function getListingHeaderColumnHtml($key, $sortBy, $sortOrder)
    {
        if ($key == $sortBy) {
            $class = 'sorting_desc';
            $selectorId = '#arrow-up';

            if ($sortOrder == applicationConstants::SORT_ASC) {
                $class = 'sorting_asc';
                $selectorId = '#arrow-down';
            }

            return [
                'class' => $class,
                'html' => '<i class="icn sortingIconJs">
                                <svg class="svg" width="18" height="18">
                                    <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg' . $selectorId . '">
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

    public static function formatFormFields(Form &$frm)
    {
        $frm->setCustomRendererClass('FormRendererBS');
        /* For Each Row On Above Elements */
        $frm->developerTags['colWidthClassesDefault'] = [null, 'col-md-', null, null];
        $frm->developerTags['colWidthValuesDefault'] = [null, '12', null, null];
        /* For Each Row On Above Elements */

        /* For Input Fields */
        $frm->developerTags['fldWidthClassesDefault'] = ['', '', '', ''];
        $frm->developerTags['fldWidthValuesDefault'] = ['', '', '', ''];
        /* For Input Fields */

        /* For Labels Fields */
        $frm->developerTags['labelWidthClassesDefault'] = ['label', 'label', 'label', 'label'];
        $frm->developerTags['labelWidthValuesDefault'] = ['', '', '', ''];
        /* For Labels Fields */

        /* Group Label and Input field. */
        $frm->developerTags['fieldWrapperRowExtraClassDefault'] = 'form-group';
        /* Group Label and Input field. */
    }

    public static function getTheDay(string $date, int $langId)
    {
        $currDate = strtotime(date("Y-m-d H:i:s"));
        $theDate = strtotime($date);
        $diff = floor(($currDate - $theDate) / (60 * 60 * 24));
        switch ($diff) {
            case 0:
                return Labels::getLabel('LBL_TODAY', $langId);
                break;
            case 1:
                return Labels::getLabel('LBL_YESTERDAY', $langId);
                break;
            case 2:
            case 3:
            case 4:
                return CommonHelper::replaceStringData(Labels::getLabel('LBL_{COUNT}_DAYS_AGO', $langId), ['{COUNT}' => $diff]);
                break;    
            default:
                return date('d-m-Y', $theDate);
                break; 
        }
    }

    public static function getStatusHtml(int $status, string $msg): string
    {
        switch ($status) {
            case self::SUCCESS:
                return '<span class="badge badge-success">' . $msg . '</span>';
                break;
            case self::WARNING:
                return '<span class="badge badge-warning">' . $msg . '</span>';
                break;
            case self::DANGER:
                return '<span class="badge badge-danger">' . $msg . '</span>';
                break;
            case self::PRIMARY:
                return '<span class="badge badge-primary">' . $msg . '</span>';
                break;
            case self::INFO:
                return '<span class="badge badge-info">' . $msg . '</span>';
                break;
            default:
                return '<span class="badge badge-info">' . $msg . '</span>';
                break;
        }
    }

    public static function addButtonHtml(string $lbl, string $type = 'button', $name = '', $class = '', $onclick = ''): string
    {
        $name = (!empty($name) ? 'name="' . $name . '"' : '');
        $onclick = (!empty($onclick) ? 'onclick="' . $onclick . ';"' : '');
        $class = !empty($class) ? $class : 'btn btn-brand btn-wide ml-2 submitBtnJs';
        return '<button type="' . $type . '" ' . $name . ' class="' . $class . '" ' . $onclick . '>' . $lbl . '</button>';
    }

    public static function addSearchButton(Form &$frm, string $lbl = '')
    {
        $lbl = empty($lbl) ? Labels::getLabel('FRM_SEARCH', CommonHelper::getLangId()) : $lbl;
        $frm->addHtml('', 'btn_submit', self::addButtonHtml($lbl, 'submit', 'btn_submit'));
    }

    public static function addClearButton(Form &$frm, string $lbl = '')
    {
        $lbl = empty($lbl) ? Labels::getLabel('FRM_CLEAR', CommonHelper::getLangId()) : $lbl;
        $frm->addHtml('', 'btn_clear', self::addButtonHtml($lbl, 'button', 'btn_clear', 'btn btn-light', 'clearSearch()'));
    }

    public static function renderHiddenFields(Form $frmSearch)
    {
        foreach ($frmSearch->getAllFields() as $key => $frmFld) {
            if ('hidden' == $frmFld->fldType) {
                echo $frmSearch->getFieldHtml($frmFld->getName());
            }
        }
    }

    public static function getSuccessMessageHtml(string $message): string
    {
        return '<div class="alert alert-success" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">' . $message . '</div>
                </div>';
    }
   
    public static function getErrorMessageHtml(string $message): string
    {
        return '<div class="alert alert-danger" role="alert">
                    <div class="alert-icon"><i class="flaticon-questions-circular-button"></i></div>
                    <div class="alert-text">' . $message . '</div>
                </div>';
    }
    
    public static function getCssStyleHtml(array $files = [], string $location = 'css'): string
    {
        $htm = '';
        foreach ($files as $fl) {
            $file = $location . '/' . $fl;
            $time = filemtime(CONF_THEME_PATH . $file);
            $cssFileLink = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('JsCss', $location, array(), '', false) . '&f=' . rawurlencode($file) . '&min=0&sid=' . $time, CONF_DEF_CACHE_TIME, '.css');
            $htm .= '<link rel="stylesheet" href="' . $cssFileLink . '"/>' . "\n";
        }
        return $htm;
    }
    
    public static function getJsScriptHtml(array $files = [], string $location = 'js'): string
    {
        $htm = '';
        foreach ($files as $fl) {
            $file = $location . '/' . $fl;
            $time = filemtime(CONF_THEME_PATH . $file);
            $jsFileLink = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('JsCss', $location, array(), '', false) . '&f=' . rawurlencode($file) . '&min=0&sid=' . $time, CONF_DEF_CACHE_TIME, '.js');
            $htm .= '<script language="javascript" type="text/javascript" src="' . $jsFileLink . '"></script>' . "\n";
        }
        return $htm;
    }

    public static function getDropZoneHtml()
    {
        return '<form action="' . FatUtility::generateUrl('ImportExport', 'upload') . '" enctype="multipart/form-data" class="dropzone dropzone-default">
                    <div class="upload_cover">
                        <div clas="img--container  ">
                            <div class="file-upload">
                                <img src="' . CONF_WEBROOT_URL . 'images/upload/upload_img.png">
                            </div>
                        </div>
                    </div>
                </form>
                <script>$.initDropZone();</script>';
    }
}
