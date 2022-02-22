<?php

class ShopifySettingsController extends DataMigrationSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addHtml('info', 'info', '<p class="text-muted">'.Labels::getLabel('FRM_SHOPIFY_SINGLE_VENDOR_PLUGIN_INFO', $langId).'</br>'. strtr(Labels::getLabel('FRM_PLEASE_VISIT_{link}_TO_CREATE_APP', $langId),['{link}'=>'https://{storename}.myshopify.com/admin/apps/private']).'</p></br>');
        $frm->addRequiredField(Labels::getLabel('FRM_SHOP_URL', $langId), 'shop_url');
        $frm->addRequiredField(Labels::getLabel('FRM_PASSWORD', $langId), 'password'); 
        $frm->addHtml('info', 'info', '<span class="form-txt text-muted">'.Labels::getLabel('MSG_NOTE:_NEED_PRODUCT_READ_ACCESS_TO_FETCH_PRODUCTS', $langId).'</span><br>');              
        return $frm;
    }

}
