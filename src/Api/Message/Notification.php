<?php

/**
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
     * @var null|Sound
     */
    private $sound;

    /**
     * @var null|CustomSound
     */
    private $customSound;

    /**
     * @var null|Attachment
     */
    private $attachment;

    public function __construct(Application $application, Recipient $recipient, Message $message)
    {
        $this->application = $application;
        $this->recipient = $recipient;
        $this->message = $message;
    }

    public function getApplication(): Application
    {
        return $this->application;
    }

    public function setApplication(Application $application): void
    {
        $this->application = $application;
    }

    public function getRecipient(): Recipient
    {
        return $this->recipient;
    }

    public function setRecipient(Recipient $recipient): void
    {
        $this->recipient = $recipient;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function setMessage(Message $message): void
    {
        $this->message = $message;
    }

    public function getSound(): ?Sound
    {
        return $this->sound;
    }

    public function setSound(?Sound $sound): void
    {
        $this->sound = $sound;
    }

    public function getCustomSound(): ?CustomSound
    {
        return $this->customSound;
    }

    public function setCustomSound(?CustomSound $customSound): void
    {
        $this->customSound = $customSound;
    }

    public function getAttachment(): ?Attachment
    {
        return $this->attachment;
    }

    public function setAttachment(?Attachment $attachment): void
    {
        $this->attachment = $attachment;
    }

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
