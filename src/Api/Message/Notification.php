<?php

/*
 * This file is part of the Pushover package.
 *
 * (c) Serhiy Lunak <https://github.com/slunak>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Serhiy\Pushover\Api\Message;

use Serhiy\Pushover\Client\Curl\Curl;
use Serhiy\Pushover\Client\MessageClient;
use Serhiy\Pushover\Client\Request\Request;
use Serhiy\Pushover\Client\Response\MessageResponse;
use Serhiy\Pushover\Application;
use Serhiy\Pushover\Recipient;

/**
 * Notification.
 *
 * Notification consists of Application, Recipient and Message.
 *
 * @author Serhiy Lunak
 */
class Notification
{
    /**
     * @var Application
     */
    private $application;

    /**
     * @var Recipient
     */
    private $recipient;

    /**
     * @var Message
     */
    private $message;

    /**
     * @var Sound|null
     */
    private $sound;

    /**
     * @var Attachment|null
     */
    private $attachment;

    public function __construct(Application $application, Recipient $recipient, Message $message)
    {
        $this->application = $application;
        $this->recipient = $recipient;
        $this->message = $message;
    }

    /**
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->application;
    }

    /**
     * @param Application $application
     */
    public function setApplication(Application $application): void
    {
        $this->application = $application;
    }

    /**
     * @return Recipient
     */
    public function getRecipient(): Recipient
    {
        return $this->recipient;
    }

    /**
     * @param Recipient $recipient
     */
    public function setRecipient(Recipient $recipient): void
    {
        $this->recipient = $recipient;
    }

    /**
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
    }

    /**
     * @param Message $message
     */
    public function setMessage(Message $message): void
    {
        $this->message = $message;
    }

    /**
     * @return Sound|null
     */
    public function getSound(): ?Sound
    {
        return $this->sound;
    }

    /**
     * @param Sound|null $sound
     */
    public function setSound(?Sound $sound): void
    {
        $this->sound = $sound;
    }

    /**
     * @return Attachment|null
     */
    public function getAttachment(): ?Attachment
    {
        return $this->attachment;
    }

    /**
     * @param Attachment|null $attachment
     */
    public function setAttachment(?Attachment $attachment): void
    {
        $this->attachment = $attachment;
    }

    /**
     * @return MessageResponse
     */
    public function push(): MessageResponse
    {
        $client = new MessageClient();
        $request = new Request($client->buildApiUrl(), Request::POST, $client->buildCurlPostFields($this));

        $curlResponse = Curl::do($request);

        $response = new MessageResponse($curlResponse);
        $response->setRequest($request);

        return $response;
    }
}
