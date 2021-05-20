<?php

class Qnb extends PaymentMethodBase
{

    public const KEY_NAME = __CLASS__;

    public $requiredKeys = [];

    /**
     * __construct
     *
     * @param  int $langId
     * @return void
     */
    public function __construct(int $langId)
    {
        $this->langId = 0 < $langId ? $langId : CommonHelper::getLangId();
        $this->requiredKeys();
    }

    /**
     * requiredKeys
     *
     * @return void
     */
    public function requiredKeys()
    {
        $this->requiredKeys = ['env', 'merchant_id', 'merchant_password', 'user_code', 'user_password'];
    }

    /**
     * init
     *
     * @return bool
     */
    public function init(): bool
    {
        if (false == $this->validateSettings()) {
            return false;
        }

        if (false === $this->loadBaseCurrencyCode()) {
            return false;
        }

        return true;
    }

}
