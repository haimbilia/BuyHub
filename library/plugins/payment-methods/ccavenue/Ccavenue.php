<?php
/**
 * CCAvenue Requirements:
 * php mcrypt extension need to be install on server level
 * Different Paymentgateway production and sanbox url based on country for which it is used.
 * API credentials
 *  - Create account according to your country (India, UAE etc.)
 *  - Connect with CCAvenue team to complete merchant account.
 *  - Copy keys from  > Settings > API Keys.
 * NOTE: You need to connect with CC Avenue team over phone call or email to MerchantUnderwriting@ccavenue.com to add another test URL if required. 
 */

class Ccavenue extends PaymentMethodBase
{
    public const KEY_NAME = __CLASS__;

    public $requiredKeys = [
        'merchant_id',
        'access_code',
        'working_key',
    ];

    /**
     * __construct
     *
     * @param  int $langId
     * @return void
     */
    public function __construct(int $langId)
    {
        $this->langId = 0 < $langId ? $langId : CommonHelper::getLangId();
    }
}
