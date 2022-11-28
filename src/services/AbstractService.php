<?php

namespace bertoost\messagebird\services;

use bertoost\messagebird\models\Settings;
use bertoost\messagebird\Plugin;
use Craft;
use craft\base\Component;
use craft\helpers\App;
use MessageBird\Client;

class AbstractService extends Component
{
    public Settings $settings;

    public Client $messagebird;

    public bool $enabled = true;

    public function init(): void
    {
        parent::init();

        $this->settings = Plugin::getInstance()->getSettings();
        if (!$this->settings->validate()) {

            // set failure notice
            if (!Craft::$app->getRequest()->getIsAjax()) {
                Craft::$app->getSession()->setNotice(Craft::t('messagebird', 'Please configure the Messagebird settings.'));
            }

            // log an error
            Craft::error('Messagebird settings are incomplete. Please go to the settings page and correct it!');

            // mark service as disabled
            $this->enabled = false;
        }

        // start new Messagebird Client
        $this->messagebird = new Client(App::parseEnv($this->settings->apiKey));
    }
}