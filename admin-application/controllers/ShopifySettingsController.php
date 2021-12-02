<?php

class ShopifySettingsController extends DataMigrationSettingsController
{

    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addHtml('info', 'info', '<p class="text-muted">'.Labels::getLabel('LBL_SHOPIFY_MULTIVENDOR_PLUGIN_INFO', $langId).'</br><a href="https://apps.shopify.com/multi-vendor-marketplace">https://apps.shopify.com/multi-vendor-marketplace</a></p></br>');
        $frm->addRequiredField(Labels::getLabel('LBL_SHOP_URL', $langId), 'shop_url');
        $frm->addRequiredField(Labels::getLabel('LBL_PASSWORD', $langId), 'password');
        $frm->addRequiredField(Labels::getLabel('LBL_MULTIVENDOR_ACCESS_TOKEN', $langId), 'multivendor_access_token');
        $frm->addHtml('info', 'info', '<span class="form-txt text-muted">' . Labels::getLabel('MSG_NOTE:_NEED_USER,_SELLER,_PRODUCT,_ORDER_READ_ACCESS', $langId) . '</span><br><br>');
        $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $langId));
        return $frm;
    }

}
