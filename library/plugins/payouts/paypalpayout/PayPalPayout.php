<?php

class PayPalPayout extends PayoutBase
{
    public const KEY_NAME = __CLASS__;

    public $requiredKeys = ['client_id', 'client_secret'];

    /**
     * __construct
     *
     * @param int $langId
     * @return void
     */
    public function __construct(int $langId)
    {
        $this->langId = $langId;
    }
    
    /**
     * formFields
     *
     * @return array
     */
    public static function formFields(): array
    {
        return [
            'email' => [
                'type' => PluginSetting::TYPE_STRING,
                'required' => false,
                'label' => "Email Id",
            ],
            'paypal_id' => [
                'type' => PluginSetting::TYPE_STRING,
                'required' => false,
                'label' => "PayPal Id",
            ],
        ];
    }
}
