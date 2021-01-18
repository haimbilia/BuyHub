<?php

class CurrencyConverterTest extends YkPluginTest
{
    public const KEY_NAME = 'CurrencyConverter';

    /**
     * testGetRates
     *
     * @dataProvider setInput
     * @param  mixed $toCurrencies
     * @return void
     */
    public function testGetRates($toCurrencies)
    {
        $this->expectedReturnType(static::TYPE_ARRAY);
        $response = $this->execute(self::KEY_NAME, [CommonHelper::getLangId()], 'getRates', [$toCurrencies]);
        $this->assertIsArray($response);
    }
        
    /**
     * setInput
     *
     * @return array
     */
    public function setInput(): array
    {
        return [
            [['USD', 'INR']], // Return Passed Currencies Conversion Rates. Expected TRUE
            [[]], // It is required to pass currencies to convert. Expected TRUE
            ['test'],   // Return error, Invalid request param,
        ];
    }
}
