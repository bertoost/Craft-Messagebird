<?php

namespace bertoost\messagebird;

use bertoost\messagebird\models\Settings;
use bertoost\messagebird\traits\PluginComponentsTrait;
use Craft;
use craft\base\Model;
use craft\base\Plugin as BasePlugin;
use craft\i18n\PhpMessageSource;

class Plugin extends BasePlugin
{
    use PluginComponentsTrait;

    public bool $hasCpSettings = true;

    public function init(): void
    {
        Craft::setAlias('@bertoost\messagebird', $this->getBasePath());

        parent::init();

        $this->registerComponents();
        $this->registerTranslations();
    }

    /**
     * Registers translation definition
     */
    private function registerTranslations(): void
    {
        Craft::$app->i18n->translations['messagebird*'] = [
            'class'          => PhpMessageSource::class,
            'sourceLanguage' => 'en',
            'basePath'       => $this->getBasePath() . '/translations',
            'allowOverrides' => true,
            'fileMap'        => [
                'messagebird'     => 'site',
                'messagebird-app' => 'app',
            ],
        ];
    }

    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    protected function settingsHtml(): ?string
    {
        /** @var Settings $settings */
        $settings = $this->getSettings();

        if (empty($settings->smsOriginator)) {
            $systemName = Craft::$app->getSystemName();
            $systemName = preg_replace('/[^a-zA-Z0-9]+/', '', $systemName);

            $settings->smsOriginator = substr($systemName, 0, 11);
        }

        // triggers error immediately
        $settings->validate();

        return \Craft::$app->getView()->renderTemplate('messagebird/settings', [
            'settings' => $settings,
        ]);
    }
}