<?php

namespace Laraketai\Mobizon;

use Illuminate\Notifications\Notification;
use Laraketai\Mobizon\Exceptions\CouldNotSendNotification;

class MobizonChannel
{
    /** @var \Laraketai\Mobizon\MobizonApi */
    protected $mobizonsms;

    public function __construct(MobizonApi $mobizonsms)
    {
        $this->mobizonsms = $mobizonsms;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     *
     * @throws  \NotificationChannels\SmscRu\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $to = $notifiable->routeNotificationFor('mobizon');

        if (empty($to)) {
            throw CouldNotSendNotification::missingRecipient();
        }

        $message = $notification->toMobizon($notifiable);

        if (is_string($message)) {
            $message = new MobizonMessage($message);
        }

        $this->sendMessage($to, $message);
    }

    protected function sendMessage($recipient, MobizonMessage $message)
    {
        if (mb_strlen($message->content) > 800) {
            throw CouldNotSendNotification::contentLengthLimitExceeded();
        }

        $params = [
            'recipient' => $recipient,
            'message'   => $message->content,
            'from'      => $message->alphaname,
        ];

        if ($message->sendAt instanceof \DateTimeInterface) {
            $params['time'] = '0'.$message->sendAt->getTimestamp();
        }

        $this->mobizonsms->send($params);
    }
}
