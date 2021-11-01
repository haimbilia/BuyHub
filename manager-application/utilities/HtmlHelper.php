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

    public static function formatFormFields(Form &$frm, $col = 12)
    {
        $frm->setCustomRendererClass('FormRendererBS');
        /* For Each Row On Above Elements */
        $frm->developerTags['colWidthClassesDefault'] = [null, 'col-md-', null, null];
        $frm->developerTags['colWidthValuesDefault'] = [null, $col, null, null];
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

    public static function getDropZoneHtml($url, $headerClass = '', $callbackfn = '')
    {
        $str =  '<div class="dropzone ' . $headerClass . '">
                    <div class="upload_cover">
                        <div clas="img--container  ">
                            <div class="file-upload">
                                <img src="' . CONF_WEBROOT_URL . 'images/upload/upload_img.png">
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                $.initDropZone("' . $url . '").on("sending", function(file, xhr, formData){';
        if (!empty($callbackfn)) {
            $str .= $callbackfn . '(file, xhr, formData)';;
        }
        $str .= '});                
                </script>';
        return $str;
    }

    public static function configureSwitchForCheckbox($fld, $msg = '')
    {
        $fld->developerTags['fldWidthValues'] = ['setting-block', null, null, null];
        $fld->developerTags['cbLabelAttributes'] = ['class' => 'switch switch-sm switch-icon'];
        $fld->developerTags['cbHtmlAfterCheckbox'] = '<span class="input-helper"></span>';
        if (!empty($msg)) {
            $fld->htmlAfterField = '<span class="form-text text-muted">' . $msg . '</span>';
        }
    }

    public static function configureSwitchForRadio($fld, $msg = '')
    {
        $fld->developerTags['rdLabelAttributes'] = ['class' => 'radio'];
        if (!empty($msg)) {
            $fld->htmlAfterField = '<span class="form-text text-muted">' . $msg . '</span>';
        }
    }

    public static function configureRadioAsButton(&$frm, $fldName)
    {
        $fld = $frm->getField($fldName);
        $str = '<label class="label">' . $fld->getCaption() . '</label>
                    <div class="radio-button-group">';
        $opCount = 1;
        foreach ($fld->options as $opValue => $opName) {
            $opId = $fldName . "__" . $opCount;
            $str .= '<div class="item">
                    <input type="radio" name="' . $fldName . '" class="radio-button ' . $fld->getFieldTagAttribute('class') . '" id="' . $opId . '"  value="' . $opValue . '"  ' . ($opValue . '" ' . $opValue == $fld->value ? 'checked' : '') . ' >
                    <label for="' . $opId . '">' . $opName . '</label>
                </div>';
            $opCount++;
        }
        $str .= '</div>';

        $oldFldPostion = $fld->getFormIndex();

        $frm->removeField($fld);
        $htmlFld = $frm->addHTML('', $fldName . '_html', $str);
        $htmlFld->setFormIndex($oldFldPostion);
        $htmlFld->developerTags = $fld->developerTags;
        return $htmlFld;
    }

    /**
     * options array ex. [1 => 'optionName'];
     */
    public static function getRadioAsButtonHtml(string $fldName, string $caption, array $options, $selectedVal = '', $fldClass = '')
    {
        $str = '<label class="label">' . $caption . '</label>
                    <div class="radio-button-group">';
        $opCount = 1;
        foreach ($options as $opValue => $opName) {
            $opId = $fldName . "__" . $opCount;
            $str .= '<div class="item">
                    <input type="radio" name="' . $fldName . '" class="radio-button ' . $fldClass . '" id="' . $opId . '"  value="' . $opValue . '"  ' . ($opValue . '" ' . $selectedVal ? 'checked' : '') . ' >
                    <label for="' . $opId . '">' . $opName . '</label>
                </div>';
            $opCount++;
        }
        return $str .= '</div>';
    }

    /**
     * $imageArr ex. ['name' => 'fav.png','url'=>'imageurl']
     */

    public static function getfileInputHtml(array $fileInputAttributes,int $langid, string $removeFn, string $editFn = '', $imageArr = [], $headerClass = '')
    {
        $str =  '<div class="dropzone ' . $headerClass . '">
                    <div class="upload_cover">';
                        if (1 > count($imageArr)) {
                        $str .= 
                        '<div clas="img--container ' . (count($imageArr) ? "d-none" : "") . '" >
                            <div class="file-upload">
                                <img src="' . CONF_WEBROOT_URL . 'images/upload/upload_img.png">                                
                            </div>
                            <div class="needsclick">
                                <h3 class="dropzone-msg-title">' . Labels::getLabel("LBL_CLICK_HERE_TO_UPLOAD", $langid) . '</h3>
                                <input type="file"';        
                                foreach ($fileInputAttributes as $attrName => $attrVal) {
                                    $str .= ' ' . $attrName . '="' . $attrVal . '"';
                                }
                                $str .= '>
                            </div>                                        
                        </div>';
                        } else {
                        $str .= 
                            '<div class="img--container uploded__img">
                                <img  src="' . $imageArr['url'] . '" title="" >    
                                <div class="upload__action">
                                <button type="button" onclick="' . $removeFn . '">
                                    <svg>
                                        <use
                                            xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.svg#delete-icon">
                                        </use>
                                    </svg>
                                </button>';
                                if(!empty($editFn)){
                                    $str .='
                                    <button type="button" onclick="' . $editFn . '(this)">
                                        <svg>
                                            <use
                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.svg#edit-icon">
                                            </use>
                                        </svg>
                                    </button>'; 
                                }                                
                                $str .='
                                </div>
                            </div>';
                    }
                $str .= '
                    </div>
                </div>';
        return   $str;
    }
    
}
