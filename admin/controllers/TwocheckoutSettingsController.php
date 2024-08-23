<?php

class TwocheckoutSettingsController extends PaymentMethodSettingsController
{
    public const KEY_NAME = 'Twocheckout';
    public static function form($langId)
    {
        $frm = new Form('frmPaymentMethods');

        $envoirment = Plugin::getEnvArr($langId);
        $envFld = $frm->addSelectBox(Labels::getLabel('FRM_ENVOIRMENT', $langId), 'env', $envoirment, '', [], Labels::getLabel('FRM_SELECT', $langId));
        $envFld->requirement->setRequired(true);

        /* $paymentTypesArr = array(
            'HOSTED' => 'Hosted Checkout',
            'API' => 'Payment API'
        );
        $frm->addRadioButtons(Labels::getLabel('FRM_PAYMENT_TYPE', $langId), 'payment_type', $paymentTypesArr, 'HOSTED', array('class' => 'list-inline')); */
        $frm->addRequiredField(Labels::getLabel('FRM_MERCHANT_CODE', $langId), 'sellerId');
        $frm->addRequiredField(Labels::getLabel('FRM_PUBLISHABLE_KEY', $langId), 'publishableKey');
        $frm->addRequiredField(Labels::getLabel('FRM_PRIVATE_KEY', $langId), 'privateKey');
        $frm->addRequiredField(Labels::getLabel('FRM_SECRET_WORD', $langId), 'hashSecretWord');

        $frm->addHTML(
            'Remember',
            '',
            '<span class="form-text text-muted">
                In case of <strong>Hosted Checkout</strong>, Admin must set <strong>Redirect URL</strong> in which :<br>
                <strong>Return method : Header Redirect</strong><br>  
                <strong>Approved URL : ' . UrlHelper::generateFullUrl(self::KEY_NAME . 'Pay', 'callback', [], CONF_WEBROOT_FRONT_URL)  . '</strong><br>
                Under <strong><a href="https://secure.2checkout.com/cpanel/webhooks_api.php" target="_blank">Integration > Webhooks & API</a></strong> tab find "Redirect URL" section.<br/><br/>
            </span>'
        );

        return $frm;
    }
}