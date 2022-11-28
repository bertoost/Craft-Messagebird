<?php

namespace bertoost\messagebird\traits;

use bertoost\messagebird\services\SmsService;

trait PluginComponentsTrait
{
    /**
     * Registers components for the Plugin
     */
    public function registerComponents(): void
    {
        $this->setComponents([
            'sms' => SmsService::class,
        ]);
    }

    /**
     * Returns the SMS Service
     */
    public function getSms(): SmsService
    {
        return $this->get('sms');
    }
}