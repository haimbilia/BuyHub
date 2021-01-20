<?php

class FixerCurrencyConverterTest extends YkPluginTest
{
    public const KEY_NAME = 'FixerCurrencyConverter';

    /**
     * settings - Plugin setting need to configure first to test plugin method.
     *
     * @return void
     */
    public static function settings()
    {
        return [
            'access_key' => 'a95a5e7415cb80554448f926ca7f68d8'
        ];
    }

    /**
     * @test 
     *
     * @dataProvider feedGetRates
     * @param  mixed $toCurrencies
     * @return void
     */
    public function getRates($toCurrencies)
    {
        $this->expectedReturnType(static::TYPE_ARRAY);
        $response = $this->execute(self::KEY_NAME, [SYSTEM_LANG_ID], 'getRates', [$toCurrencies]);
        $this->assertIsArray($response);
        $status = empty($response) ? Plugin::RETURN_FALSE : $response['status'];
        $this->assertEquals($expected, $status);
    }
        
    /**
     * feedGetRates
     *
     * @return array
     */
    public function feedGetRates(): array
    {
        return [
            [['USD', 'INR']], // Return Passed Currencies Conversion Rates. Expected TRUE
            [[]], // It is required to pass currencies to convert. Expected TRUE
            ['test'],   // Return error, Invalid request param,
        ];
    }
}
