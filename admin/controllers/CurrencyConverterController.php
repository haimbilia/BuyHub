<?php
/*
* Reference : https://www.currencyconverterapi.com
* Note : Too many pairs. Maximum of 2 is supported for this free version.
*/
class CurrencyConverterController extends CurrencyConverterBaseController
{
    public const KEY_NAME = 'CurrencyConverter';
    public function __construct($action)
    {
        parent::__construct($action);
        $error = '';
        $this->fixer = LibHelper::callPlugin(self::KEY_NAME, [$this->siteLangId], $error, $this->siteLangId);
        if (false === $this->fixer) {
            $this->setError($error);
        }
    }

    private function setError(string $msg = "")
    {
        $msg = !empty($msg) ? $msg : $this->fixer->getError();
        LibHelper::dieJsonError($msg);
    }

    public function getRates($toCurrencies = [])
    {
        return $this->fixer->getRates($toCurrencies);
    }
}
