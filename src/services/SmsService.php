<?php

namespace bertoost\messagebird\services;

use Craft;
use MessageBird\Common\ResponseError;
use MessageBird\Objects\Message;

/**
 * Class SmsService
 */
class SmsService extends AbstractService
{
    /**
     * @var Message
     */
    private $message;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $this->message = new Message();
        $this->message->originator = $this->settings->smsOriginator;
    }

    /**
     * @param string $to
     *
     * @return SmsService
     */
    public function addRecipient(string $to): SmsService
    {
        $this->message->recipients[] = $to;

        return $this;
    }

    /**
     * @param string $body
     *
     * @return SmsService
     */
    public function setBody(string $body): SmsService
    {
        $this->message->body = $body;

        return $this;
    }

    /**
     * @param string $reference
     *
     * @return SmsService
     */
    public function setReference(string $reference): SmsService
    {
        $this->message->reference = $reference;

        return $this;
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return SmsService
     */
    public function setSchedule(\DateTime $dateTime): SmsService
    {
        $this->message->scheduledDatetime = $dateTime->format(\DateTime::RFC3339);

        return $this;
    }

    /**
     * @return bool
     */
    public function send(): bool
    {
        if (!$this->enabled) {
            return false;
        }

        try {

            if (empty($this->message->recipients)) {
                throw new \Exception('No SMS Message recipients added. Use addRecipient() before send().');
            }

            if (empty($this->message->body)) {
                throw new \Exception('No SMS Message body added. Use setBody() before send().');
            }

            $result = $this->messagebird->messages->create($this->message);

            // when result is about an error and not throwing it...
            if (($result instanceof ResponseError) && $result->errors && !empty($result->errors)) {
                throw new \Exception($result->getErrorString());
            }

            return true;

        } catch (\Exception $e) {

            Craft::$app->getErrorHandler()->logException($e);
        }

        return false;
    }
}