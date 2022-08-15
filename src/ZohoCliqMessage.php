<?php

namespace NotificationChannels\ZohoCliq;

use Illuminate\Support\Arr;
use NotificationChannels\ZohoCliq\Exceptions\CouldNotSendNotification;

class ZohoCliqMessage
{
    /** @var array Params payload. */
    protected $payload = [];

    /** @var string webhook url of recipient. */
    protected $webhookUrl = null;

    /**
     * Message constructor.
     *
     * @param  array  $payload
     */
    public function __construct(array $payload = [])
    {
        $this->payload = $payload;
    }

    /**
     * Set the payload.
     *
     * @param  array  $payload
     * @return ZohoCliqMessage $this
     */
    public function payload(array $payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Recipient's webhook url.
     *
     * @param $webhookUrl  - url of webhook
     *
     * @return ZohoCliqMessage $this
     * @throws CouldNotSendNotification
     *
     */
    public function to(?string $webhookUrl): self
    {
        if (!$webhookUrl) {
            throw CouldNotSendNotification::zohoCliqWebhookUrlMissing();
        }

        $this->webhookUrl = $webhookUrl;

        return $this;
    }

    /**
     * Get webhook url.
     *
     * @return string $webhookUrl
     */
    public function getWebhookUrl(): string
    {
        return $this->webhookUrl;
    }

    /**
     * Determine if webhook url is not given.
     *
     * @return bool
     */
    public function toNotGiven(): bool
    {
        return !$this->webhookUrl;
    }

    /**
     * Returns params payload.
     *
     * @return array
     * @throws CouldNotSendNotification
     */
    public function toArray(): array
    {
        if (count($this->payload) === 0) {
            throw CouldNotSendNotification::zohoCliqPayloadIsEmpty();
        }

        return $this->payload;
    }
}
