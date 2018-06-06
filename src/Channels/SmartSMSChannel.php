<?php

namespace AbdulmatinSanni\APIx\Channels;

use Illuminate\Notifications\Notification;

use AbdulmatinSanni\APIx\APIx;
use AbdulmatinSanni\APIx\Exceptions\InvalidConfiguration;
use AbdulmatinSanni\APIx\Exceptions\CouldNotSendNotification;

class SmartSMSChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \AbdulmatinSanni\APIx\Exceptions\InvalidConfiguration
     * @throws \AbdulmatinSanni\APIx\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! config('api-x.api_token')) {
            throw InvalidConfiguration::configurationNotSet();
        }

        $recipient = $notifiable->routeNotificationFor('SmartSMS');
        $notification = $notification->toSmartSMS($notifiable);

        if (! $recipient || ! $notification) {
            return;
        }

        $response = APIx::to($recipient)
            ->from($notification->from)
            ->message($notification->message)
            ->send();

        if ($response->getStatusCode() !== 200) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }
    }
}
