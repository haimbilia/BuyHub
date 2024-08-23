<?php

class SmsNotificationController extends PluginBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function callback($keyName)
    {
        $error = '';
        $smsNotification = LibHelper::callPlugin($keyName, [$this->siteLangId], $error, $this->siteLangId);
        if (false === $smsNotification) {
            FatUtility::dieJsonError($error);
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_SUCCESS', $this->siteLangId));
    }
}
