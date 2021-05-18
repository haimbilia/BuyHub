<?php
$pluginId = $this->getKey('plugin_id');
$this->settings = [
    'plugin_active' => 1,
    'env' => 0,
    'plugin_id' => $pluginId,
    'plugin_identifier' => self::KEY_NAME,
    'plugin_type' => Plugin::TYPE_SHIPPING_SERVICES,
    'plugin_code' => self::KEY_NAME,
    'plugin_display_order' => 3,
    'pluginlang_plugin_id' => $pluginId,
    'pluginlang_lang_id' => $this->langId,
    'plugin_name' => $this->getKey('plugin_name'),
    'plugin_description' => $this->getKey('plugin_description'),
];

switch ($this->serviceRequest) {
    case self::REQUEST_SHIPPING:
    case self::REQUEST_TRACKING:
    case self::REQUEST_RATE:
        $this->settings += [
            'AccountCountryCode' => 'KW',
            'AccountEntity' => 'KWI',
            'AccountNumber' => '203615',
            'AccountPin' => '664165',
            'UserName' => 'aramex@dummyid.com',
            'Password' => 'a62vf#hcLfMLa8y'
        ];
        break;
    case self::REQUEST_VALIDATE_ADDRESS:
        $this->settings += [
            'AccountCountryCode' => 'JO',
            'AccountEntity' => 'AMM',
            'AccountNumber' => '20016',
            'AccountPin' => '331421',
            'UserName' => 'testingapi@aramex.com',
            'Password' => 'R123456789$r',
            'Source' => NULL
        ];
        break;

    default:
        CommonHelper::dieWithError(Labels::getLabel('LBL_INVALID_SERVICE_REQUEST', $this->langId));
        break;
}
