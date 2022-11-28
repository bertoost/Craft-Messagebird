<?php

namespace bertoost\messagebird\models;

use craft\base\Model;

class Settings extends Model
{
    public string $apiKey = '';

    public string $smsOriginator = '';

    public function rules(): array
    {
        return [
            [['apiKey', 'smsOriginator'], 'required'],
        ];
    }
}