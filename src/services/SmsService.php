<?php

namespace bertoost\messagebird\services;

use Craft;
use DateTime;
use Exception;
use MessageBird\Common\ResponseError;
use MessageBird\Objects\Message;
use RuntimeException;

class SmsService extends AbstractService
{
    private Message $message;

    public function init(): void
    {
        parent::init();

        $this->message = new Message();
        $this->message->originator = $this->settings->smsOriginator;
    }

    public function addRecipient(string $to): SmsService
    {
        $this->message->recipients[] = $to;

        return $this;
    }

    public function setBody(string $body): SmsService
    {
        $this->message->body = $body;

        return $this;
    }

    public function setReference(string $reference): SmsService
    {
        $this->message->reference = $reference;

        return $this;
    }

    public function setSchedule(DateTime $dateTime): SmsService
    {
        $this->message->scheduledDatetime = $dateTime->format(DateTime::RFC3339);

        return $this;
    }

    public function send(): bool
    {
        if (!$this->enabled) {
            return false;
        }

        try {

            if (empty($this->message->recipients)) {
                throw new RuntimeException('No SMS Message recipients added. Use addRecipient() before send().');
            }

            if (empty($this->message->body)) {
                throw new RuntimeException('No SMS Message body added. Use setBody() before send().');
            }

            $result = $this->messagebird->messages->create($this->message);

            // when result is about an error and not throwing it...
            if (($result instanceof ResponseError) && $result->errors && !empty($result->errors)) {
                throw new RuntimeException($result->getErrorString());
            }

            return true;
        } catch (Exception $e) {
            Craft::$app->getErrorHandler()->logException($e);
        }

        return false;
    }
}