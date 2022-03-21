<?php

class FormFieldDatePicker
{
    /**
     *
     * @param FormField   $fld
     * @param HtmlElement $htmlElement
     */
    public static function addJs($fld, $htmlElement)
    {

        /* Note: Date format for datepicker should be 'Y-m-d'. */

        $dateformat = FatDate::convertDateFormatFromPhp(
            FatApp::getConfig('CONF_DATEPICKER_FORMAT', FatUtility::VAR_STRING, 'Y-m-d'),
            FatDate::FORMAT_JQUERY_UI
        );

        $layoutConf = 'isRTL: false,';
        if ('rtl' == mb_strtolower(CommonHelper::getLayoutDirection())) {
            $layoutConf = 'isRTL: true,';
        }

        if ($fld->fldType == 'datetime') {
            $calhtml = '<script type="text/javascript">//<![CDATA[
       $( "#' . $htmlElement->getAttribute('id') . '" ).addClass("fld-date-time").datetimepicker({' . $layoutConf . ' dateFormat:"' . $dateformat . '", changeYear: true, changeMonth: true, showButtonPanel: true, yearRange: "-60:+5",onSelect: function () { this.focus(); },onClose: function (){this.focus();}';
        } else {
            $calhtml = '<script type="text/javascript">//<![CDATA[
       $( "#' . $htmlElement->getAttribute('id') . '" ).addClass("fld-date").datepicker({' . $layoutConf . ' dateFormat:"' . $dateformat . '", changeYear: true, changeMonth: true, showButtonPanel: true, yearRange: "-60:+5",onSelect: function () { this.focus(); },onClose: function (){this.focus(); }';
        }

        if (isset($fld->developerTags['date_extra_js'])) {
            $calhtml .= ', ' . ltrim($fld->developerTags['date_extra_js'], ',');
        }

        $calhtml .= ' });
		   //]]></script>';

        $fld->htmlAfterField = $calhtml . $fld->htmlAfterField;

        $htmlElement->setAttribute('data-fatdateformat', $dateformat);
    }
}
