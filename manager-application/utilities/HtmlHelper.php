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
            default:
                return CommonHelper::replaceStringData(Labels::getLabel('LBL_{COUNT}_DAYS_AGO', $langId), ['{COUNT}' => $diff]);
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

    public static function addSearchButton(Form &$frm)
    {
        $frm->addHtml('', 'btn_submit', '<button type="submit" name="btn_submit" class="btn btn-brand btn-wide ml-2 submitBtnJs">' . Labels::getLabel('LBL_SEARCH', CommonHelper::getLangId()) . '</button>');
    }

    public static function addClearButton(Form &$frm)
    {
        $frm->addHtml('', 'btn_clear', '<button type="button" name="btn_clear" class="btn link" onclick="clearSearch();">' . Labels::getLabel('LBL_CLEAR', CommonHelper::getLangId()) . '</button>');
    }

    /* public static function createButton(string $label, array $attr = [])
    {
        $attr = empty($attr) ? ['type' => 'button', 'class' => 'btn btn-brand'] : $attr;
        $button = new HtmlElement("button", $attr, $label);
        return $button->getHtml();
    } */

    public static function renderHiddenFields(Form $frmSearch)
    {
        foreach ($frmSearch->getAllFields() as $key => $frmFld) {
            if ('hidden' == $frmFld->fldType) {
                echo $frmSearch->getFieldHtml($frmFld->getName());
            }
        }
    }
}
