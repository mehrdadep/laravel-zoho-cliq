<?php

namespace NotificationChannels\ZohoCliq;

use Exception;
use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ClientException;
use NotificationChannels\ZohoCliq\Exceptions\CouldNotSendNotification;

class ZohoCliq
{
    /**
     * API HTTP client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * @param  \GuzzleHttp\Client  $http
     */
    public function __construct(HttpClient $http)
    {
        $this->httpClient = $http;
    }

    /**
     * Send a message to a ZohoCliq channel.
     *
     * @param  string  $url
     * @param  array  $data
     *
     * @return ResponseInterface|null
     * @throws CouldNotSendNotification|\GuzzleHttp\Exception\GuzzleException
     *
     */
    public function send(string $url, array $data): ?ResponseInterface
    {
        if (!$url) {
            throw CouldNotSendNotification::zohoCliqWebhookUrlMissing();
        }

        try {
            $response = $this->httpClient->post($url, ["json" => $data]);
        } catch (ClientException $exception) {
            throw CouldNotSendNotification::zohoCliqRespondedWithAnError($exception);
        } catch (Exception $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithZohoCliq($exception);
        }

        return $response;
    }
}
