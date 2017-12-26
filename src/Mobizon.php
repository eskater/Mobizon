<?php

namespace Laraketai\Mobizon;


use Laraketai\Mobizon\Exceptions\CouldNotSendNotification;

use Mobizon\MobizonApi as SmsApi;

class Mobizon
{
    /**
     * @var SmsApi $api
     */
    protected $api;

    /**
     * Mobizon constructor.
     *
     * @param null $key
     */
    public function __construct($key = null)
    {
        $this->api = new SmsApi($key);
    }

    /**
     * Send sms to recipient
     *
     * @param $recipient
     * @param $text
     * @param $alphaname
     * @return bool
     * @throws CouldNotSendNotification
     * @throws \Mobizon\Mobizon_Http_Error
     * @throws \Mobizon\Mobizon_Param_Required
     */
    public function sendSmsTo($recipient, $text, $alphaname)
    {

        if (empty($recipient)) {
            throw CouldNotSendNotification::missingRecipient();
        }

        if (mb_strlen($text) > 800) {
            throw CouldNotSendNotification::contentLengthLimitExceeded();
        }

        $params = [
            'recipient' => $recipient,
            'text' => $text,
            'from' => $alphaname,
        ];

        if (!$this->api->call('message', 'sendSMSMessage', $params)) {
            throw new \Exception($this->api->getMessage(), $this->api->getCode());
        }
        return true;
    }

    /**
     * Get user balance
     *
     * @return string
     * @throws CouldNotSendNotification
     * @throws \Mobizon\Mobizon_Http_Error
     * @throws \Mobizon\Mobizon_Param_Required
     */
    public function getBalance()
    {
        $api = $this->api;
        if ($api->call('User', 'GetOwnBalance') && $api->hasData('balance')) {
            return $api->getData('balance') . ' ' .  $api->getData('currency');
        } else {
            throw CouldNotSendNotification::mobizonRespondedWithAnError($api->getCode(), $api->getMessage(), $api->getData());
        }
    }

    /**
     * @return SmsApi
     */
    public function getApi()
    {
        return $this->api;
    }
}
