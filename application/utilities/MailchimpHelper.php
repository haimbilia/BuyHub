<?php

class MailchimpHelper
{
    static function subscribe($data, $siteLangId)
    {

        $data['status'] = 'subscribed';
        $apiKey = FatApp::getConfig("CONF_MAILCHIMP_KEY");
        $listId = FatApp::getConfig("CONF_MAILCHIMP_LIST_ID");

        if ($apiKey == '' || $listId == '') {
            return false;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['msg' => Labels::getLabel('MSG_Email_is_not_a_valid_email_address', $siteLangId)];
        }

        $memberId = md5(strtolower($data['email']));
        $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

        $json = json_encode([
            'email_address' => $data['email'],
            'status'        => $data['status'], // "subscribed","unsubscribed","cleaned","pending"
        ]);
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (empty($result)) {
            return ['msg' => Labels::getLabel('LBL_Invalid_Credentials', $siteLangId)];
        }

        $response  = json_decode($result, true);
        if ($httpCode != 200) {
            return ['msg' => $response['detail']];
        }
        return $response;
    }
}
