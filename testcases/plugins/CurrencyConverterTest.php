<?php

class CurrencyConverterTest extends YkPluginTest
{
    public const KEY_NAME = 'CurrencyConverter';

    /**
     * settings - Plugin setting need to configure first to test plugin method.
     *
     * @return void
     */
    public static function settings()
    {
        return [
            'api_key' => 'c22be3bbee2ffc600da0'
        ];
    }

    /**
     * @test
     *
     * @dataProvider feedGetRates
     * @param  mixed $toCurrencies
     * @return void
     */
    public function getRates($expected, $toCurrencies)
    {
        $this->expectedReturnType(static::TYPE_ARRAY);
        $response = $this->execute(self::KEY_NAME, [SYSTEM_LANG_ID], 'getRates', [$toCurrencies]);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('msg', $response);
        $this->assertArrayHasKey('data', $response);       
        $this->assertEquals($expected, $response['status']);
    }

    /**
     * feedGetRates
     *
     * @return array
     */
    public function feedGetRates(): array
    {
        return [
            [1, ['USD', 'INR']], // Correct Values. Return array . Expected status 1(TRUE)
            [0, []], // No Value. Return array . Expected status 0(FALSE)
            [0, 'test'],   // Invalid Value. Return array . Expected status 0(FALSE)
        ];
    }
}
