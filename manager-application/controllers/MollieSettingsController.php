<?php

class MollieSettingsController extends PaymentMethodSettingsController
{
	public static function form(int $langId)
    {
		$frm = new Form('frmMollie');
        $frm->addRequiredField(Labels::getLabel('FRM_SECRET_KEY', $langId), 'privateKey');
        //$frm->addRequiredField(Labels::getLabel('FRM_PUBLISHABLE_KEY', $langId), 'publishableKey');
        return $frm;
	}
    
}