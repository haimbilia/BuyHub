<?php

class ShopifySettingsController extends DataMigrationSettingsController
{
       
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addRequiredField(Labels::getLabel('LBL_SHOP_URL', $langId), 'shop_url');
        $frm->addRequiredField(Labels::getLabel('LBL_PASSWORD', $langId), 'password'); 
        $frm->addHtml('info', 'info', '<span class="form-txt text-muted">'.Labels::getLabel('MSG_NOTE:_NEED_PRODUCT_READ_ACCESS_TO_FETCH_PRODUCTS', $langId).'</span><br>');       
        $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $langId));
        return $frm;
    }

}
