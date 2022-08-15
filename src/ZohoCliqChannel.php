<?php

namespace NotificationChannels\ZohoCliq;

use Illuminate\Notifications\Notification;

class ZohoCliqChannel
{
    /**
     * @var ZohoCliq
     */
    protected $zohoCliq;

    /**
     * Channel constructor.
     *
     * @param  ZohoCliq  $zohoCliq
     */
    public function __construct(ZohoCliq $zohoCliq)
    {
        $this->zohoCliq = $zohoCliq;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toZohoCliq($notifiable);

        // if the recipient is not defined get it from the notifiable object
        if ($message->toNotGiven()) {
            $to = $notifiable->routeNotificationFor('zohoCliq', $notification);
            $message->to($to);
        }

        return $this->zohoCliq->send($message->getWebhookUrl(), $message->toArray());
    }
}
