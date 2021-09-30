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

    public static function getStatusHtml(int $status, string $msg): string
    {
        switch ($status) {
            case self::SUCCESS:
                return'<span class="badge badge-success">' . $msg . '</span>';
                break;
            case self::WARNING:
                return'<span class="badge badge-warning">' . $msg . '</span>';
                break;
            case self::DANGER:
                return'<span class="badge badge-danger">' . $msg . '</span>';
                break;
            case self::PRIMARY:
                return'<span class="badge badge-primary">' . $msg . '</span>';
                break;
            case self::INFO:
                return'<span class="badge badge-info">' . $msg . '</span>';
                break;
            default:
                return'<span class="badge badge-info">' . $msg . '</span>';
                break;
        }
    }
}
