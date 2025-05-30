<?php

/*
    Reference : https://data.fixer.io
*/

class FixerCurrencyConverterController extends CurrencyConverterBaseController
{
    public const KEY_NAME = 'FixerCurrencyConverter';

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
