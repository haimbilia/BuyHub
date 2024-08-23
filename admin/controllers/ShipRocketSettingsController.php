<?php

class ShipRocketSettingsController extends ShippingServicesSettingsController
{
    private const KEY_NAME = 'ShipRocket';
    public static function form(int $langId)
    {
        $frm = new Form('frm' . self::KEY_NAME);

        $plugin = LibHelper::callPlugin(self::KEY_NAME, [$langId], $error, $langId, false);
        $labelsArr = $plugin->getFormFieldsArr();
        foreach ($labelsArr as $colName => $colLabel) {
            $fieldFn = ('password' == strtolower($colName)) ? 'addPasswordField' : 'addTextBox';
            $fld = $frm->$fieldFn($colLabel, $colName);
            $fld->requirement->setRequired(true);
        }

        return $frm;
    }
}
