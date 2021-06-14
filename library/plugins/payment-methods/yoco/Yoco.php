
<?php

use Curl\Curl;

class Yoco extends PaymentMethodBase
{

    public const KEY_NAME = __CLASS__;

    private $publicKey;
    private $secretKey;
    private $resp;

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
     * getColsLabelArr - Used to display settings form
     *
     * @return array
     */
    public function getColsLabelArr(): array
    {
        return [
            'public_key' => Labels::getLabel('LBL_PUBLIC_KEY', $this->langId),
            'secret_key' => Labels::getLabel('LBL_SECRET_KEY', $this->langId),
        ];
    }

    /**
     * requiredKeys
     *
     * @return void
     */
    public function requiredKeys()
    {
        $environment = FatUtility::int($this->getKey('env'));
        $this->requiredKeys = array_keys($this->getColsLabelArr());
        if (0 < $environment) {
            $this->environment = preg_filter('/^/', 'live_', $this->requiredKeys);
        }
    }

    /**
     * init
     *
     * @param  int $userId
     * @param  bool $isSeller
     * @return bool
     */
    public function init()
    {
        if (false == $this->validateSettings()) {
            return false;
        }

        $liveKeyTxt = 0 < $this->settings['env'] ? 'live_' : '';
        $this->publicKey = $this->settings[$liveKeyTxt . 'public_key'];
        $this->secretKey = $this->settings[$liveKeyTxt . 'secret_key'];
        return true;
    }

    public function chargeCard($token, $amount, $currencyCode)
    {
        $data = [
            'token' => $token,
            'amountInCents' => $amount,
            'currency' => $currencyCode
        ];

        $secret_key = $this->getSecretKey();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://online.yoco.com/v1/charges/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_USERPWD, $secret_key . ":");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        curl_close($ch);
        if ($result === false) {
            $this->error = curl_error($ch);          
            return false;         
        }
        $result = json_decode($result);
        
        $this->response = ['status' => true,'id'=>$result->ch_awLYujNDMwzorIBO1iQkrikLq];

        die();
    }

    public function getPublicKey(): string
    {
        return (string) $this->publicKey;
    }

    public function getSecretKey(): string
    {
        return (string) $this->secretKey;
    }
    
    public function getResponse()
    {
        return $this->response;
    }

}
