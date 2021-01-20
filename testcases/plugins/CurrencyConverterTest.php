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
        $response = $this->execute(self::KEY_NAME, [CommonHelper::getLangId()], 'getRates', [$toCurrencies]);
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
            [Plugin::RETURN_TRUE, ['USD', 'INR']], // Correct Values. Return array . Expected status 1(TRUE)
            [Plugin::RETURN_FALSE, []], // No Value. Return array . Expected status 0(FALSE)
            [Plugin::RETURN_FALSE, 'test'],   // Invalid Value. Return array . Expected status 0(FALSE)
        ];
    }
}
