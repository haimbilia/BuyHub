<?php
class ShopifySettingsController extends DataMigrationSettingsController
{
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');
        $frm->addHtml('info', 'info', '<p class="form-text text-muted">'.Labels::getLabel('MSG_SHOPIFY_MULTIVENDOR_PLUGIN_INFO', $langId).' <a href="https://apps.shopify.com/multi-vendor-marketplace">https://apps.shopify.com/multi-vendor-marketplace</a></p>');
        $frm->addRequiredField(Labels::getLabel('FRM_SHOP_URL', $langId), 'shop_url');
        $frm->addRequiredField(Labels::getLabel('FRM_PASSWORD', $langId), 'password');
        $frm->addRequiredField(Labels::getLabel('FRM_MULTIVENDOR_ACCESS_TOKEN', $langId), 'multivendor_access_token');
        $frm->addHtml('info', 'info', '<span class="form-text text-muted">' . Labels::getLabel('MSG_NOTE:_NEED_USER,_SELLER,_PRODUCT,_ORDER_READ_ACCESS', $langId) . '</span>');
        return $frm;
    }
}
