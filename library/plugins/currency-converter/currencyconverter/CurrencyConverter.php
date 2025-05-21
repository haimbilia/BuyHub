<?php

use Curl\Curl;

class CurrencyConverter extends CurrencyConverterBase
{
    // Used by Yo!Kart to identify this plugin internally
    public const KEY_NAME = __CLASS__;

    // Frankfurter API endpoint (free and does not require a key)
    private const API_URL = 'https://api.frankfurter.app/latest';

    // Required for compatibility with Yo!Kart's plugin settings UI
    public $requiredKeys = ['api_key'];

    // Holds the API response
    private $response = '';

    // Currencies to convert into
    private $toCurrencies = [];

    /**
     * Constructor
     * Sets the language ID for internal plugin use
     */
    public function __construct(int $langId)
    {
        $this->langId = FatUtility::int($langId);
        if ($this->langId < 1) {
            $this->langId = CommonHelper::getLangId();
        }
    }

    /**
     * Initializes the plugin by validating settings and base currency
     * @return bool
     */
    public function init(): bool
    {
        if (!$this->validateSettings($this->langId)) {
            return false;
        }

        if (!$this->loadBaseCurrency()) {
            return false;
        }

        return true;
    }

    /**
     * Main method to fetch exchange rates
     * Called by the admin controller during the sync/update process
     *
     * @param array $toCurrencies - list of currency codes to convert to (e.g., ['EUR', 'ILS'])
     * @return array ['status' => true|false, 'data' => rates, 'msg' => errorMessage]
     */
    public function getRates($toCurrencies = [])
    {
        // Store target currencies
        $this->toCurrencies = $toCurrencies;

        // Validate plugin setup and base currency
        if (!$this->init()) {
            return ['status' => false, 'msg' => $this->getError()];
        }

        // Base currency (e.g., USD)
        $from = $this->getBaseCurrencyCode();

        // Target currencies (e.g., EUR, ILS)
        $to = implode(',', $this->toCurrencies);

        // Build API request URL
        $url = self::API_URL . "?amount=1&from={$from}&to={$to}";

        // Send request to Frankfurter API
        $curl = new Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, true);
        $curl->get($url);

        // Handle API error
        if ($curl->error) {
            return [
                'status' => false,
                'msg' => $curl->errorCode . ': ' . $curl->errorMessage
            ];
        }

        // Parse API response
        $response = $curl->getResponse();

        if (empty($response->rates)) {
            return ['status' => false, 'msg' => 'Invalid API response.'];
        }

        // Convert response to array
        $rates = (array) $response->rates;

        return ['status' => true, 'data' => $rates];
    }
}
