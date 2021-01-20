<?php

class GoogleLoginTest extends YkPluginTest
{
    public const KEY_NAME = 'GoogleLogin';

    /**
     * init
     *
     * @return void
     */
    public function init()
    {
        if (false === $this->classObj->init()) {
            $this->error = $this->classObj->getError();
            return false;
        }
        return true;
    }

    /**
     * settings - Plugin setting need to configure first to test plugin method.
     *
     * @return void
     */
    public static function settings()
    {
        return [
            'client_id' => '293307261869-g6ns17slnsutjf8smv6v0210mbqnajl2.apps.googleusercontent.com',
            'client_secret' => 'Q7RN2uPn0jY7QPzsK2WB1iUL',
            'developer_key' => 'AIzaSyAYRPS5jwNbMHoowNhNvna5b_bdYffcwdE',
        ];
    }

    /**
     * @test
     *
     * @dataProvider feedAuthenticate
     * @param  bool $expected
     * @param  mixed $code
     * @return void
     */
    public function authenticate($expected, $code)
    {
        $response = $this->execute(self::KEY_NAME, [CommonHelper::getLangId()], 'authenticate', [$code]);
        $this->assertEquals($expected, $response);
    }
        
    /**
     * feedAuthenticate
     *
     * @return array
     */
    public function feedAuthenticate(): array
    {
        // Returned false in case of invalid or missing Plugin Keys. Fail in case of opposite expectation.
        return [
            [false, ''], // Return False in case of empty input.
            [false, 'abc'], // Return False in case of wrong input.
            [false, '4/1AGMhN5-Wob96JggkuwJhSCEW9tXH8ngw4G4JilTT4YWeAHaV0C4noApoBcjyclkanShIw5MoPeBrppRhBP5jME'], // Return false in case of expired $code
        ];
    }

    /**
     * @test
     *
     * @dataProvider feedAccessToken
     * @param  bool $expected
     * @param  mixed $accessToken
     * @return void
     */
    public function setAccessToken($expected, $accessToken)
    {
        $response = $this->execute(self::KEY_NAME, [CommonHelper::getLangId()], 'setAccessToken', [$accessToken]);
        $this->assertEquals($expected, $response);
    }
        
    /**
     * feedAccessToken
     *
     * @return array
     */
    public function feedAccessToken()
    {
        // Returned false in case of invalid or missing Plugin Keys. Fail in case of opposite expectation.
        return [
            [false, ''], // Return False in case of empty input.
            [true, 'abc'], // Return true either access_Token is wrong.
            [true, 'ya29.a0AfH6SMCnHrEFgUqi2G4P1GG5q1p-cXlIh7AwNyHODTDTtJu47hnl_IXdJIiKrut9hV5MYUZQQSzqTNyWItZUOejLYLSJEkhqgcyOfptidJCnz6Lcg0ufCfDrBoCTHIPKMXlaAz9AkRIIkLlipbS9gyoM_RkOR2xjbhk'], // Return True in case valid accessToken
        ];
    }
}
