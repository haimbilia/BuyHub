<?php

class Mollie extends PaymentMethodBase
{
    public const KEY_NAME = __CLASS__;
    private $privateKey = '';
    private $publishableKey = '';
    private $actionUrl = '';
	private $requestBody = [];
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
		$this->requiredKeys = [
			'privateKey',
			'publishableKey',
		];
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

        $this->privateKey = $this->settings['privateKey'];
        $this->publishableKey = $this->settings['publishableKey'];
        return true;
    }

}