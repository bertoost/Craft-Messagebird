<?php

namespace bertoost\messagebird\models;

use craft\base\Model;

/**
 * Class Settings
 */
class Settings extends Model
{
    /**
     * @var string
     */
    public $apiKey;

    /**
     * @var string
     */
    public $smsOriginator;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apiKey', 'smsOriginator'], 'required'],
        ];
    }
}