<?php

namespace NotificationChannels\ZohoCliq\Exceptions;

use Exception;
use GuzzleHttp\Exception\ClientException;

class CouldNotSendNotification extends Exception
{
    /**
     * Thrown when there's a bad request and an error is responded.
     *
     * @param ClientException $exception
     *
     * @return static
     */
    public static function zohoCliqRespondedWithAnError(ClientException $exception)
    {
        if (! $exception->hasResponse()) {
            return new static('Zoho Cliq responded with an error but no response body found');
        }

        $statusCode = $exception->getResponse()->getStatusCode();
        $description = $exception->getMessage();

        return new static("Zoho Cliq responded with an error `{$statusCode} - {$description}`");
    }

    /**
     * Thrown when we're unable to communicate with Zoho Cliq.
     *
     * @param Exception $exception
     *
     * @return static
     */
    public static function couldNotCommunicateWithZohoCliq(Exception $exception)
    {
        return new static("The communication with Zoho Cliq failed. `{$exception->getMessage()}`");
    }

    /**
     * Thrown when there is no webhook url provided.
     *
     * @return static
     */
    public static function zohoCliqWebhookUrlMissing()
    {
        return new static('Zoho Cliq webhook url is missing. Please add it as param over the ZohoCliqMessage::to($url) method or return it in the notifiable model by providing the method Model::routeNotificationForZohoCliq().');
    }

    /**
     * Thrown when the payload is empty
     *
     * @return static
     */
    public static function zohoCliqPayloadIsEmpty()
    {
        return new static('Zoho Cliq payload is empty. Please add it as param over the ZohoCliqMessage::payload($payload) method');
    }
}
