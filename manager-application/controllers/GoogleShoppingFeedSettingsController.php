<?php

class GoogleShoppingFeedSettingsController extends AdvertisementFeedSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmGoogleFeed');
        $frm->addRequiredField(Labels::getLabel('FRM_API_KEY', $langId), 'developer_key');
        $frm->addRequiredField(Labels::getLabel('FRM_CLIENT_ID', $langId), 'client_id');
        $frm->addRequiredField(Labels::getLabel('FRM_CLIENT_SECRET', $langId), 'client_secret');
        /* 
        $channel = [
            'local' => Labels::getLabel('LBL_LOCAL', $langId),
            'online' => Labels::getLabel('LBL_ONLINE', $langId),
        ];
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_CHANNEL', $langId), 'channel', $channel, '', [], Labels::getLabel('FRM_SELECT', $langId));
        $fld->requirement->setRequired(true);
        */
        return $frm;
    }
}
