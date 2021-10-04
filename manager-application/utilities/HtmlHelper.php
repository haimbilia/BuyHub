<?php
class HtmlHelper
{
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

    public static function formatFormFields(Form &$form)
    {
        $form->setCustomRendererClass('FormRendererBS');

        /* For Each Row On Above Elements */
        $form->developerTags['colWidthClassesDefault'] = ['col-md-', null, null];
        $form->developerTags['colWidthValuesDefault'] = [($form->developerTags['fld_default_col'] ?? 12), null, null];
        /* For Each Row On Above Elements */

        /* For Input Fields */
        $form->developerTags['fldWidthClassesDefault'] = ['', '', '', ''];
        $form->developerTags['fldWidthValuesDefault'] = ['', '', '', ''];
        /* For Input Fields */

        /* For Labels Fields */
        $form->developerTags['labelWidthClassesDefault'] = ['label', 'label', 'label', 'label'];
        $form->developerTags['labelWidthValuesDefault'] = ['', '', '', ''];
        /* For Labels Fields */

        /* Group Label and Input field. */
        $form->developerTags['fieldWrapperRowExtraClassDefault'] = 'form-group';
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
}
