<p align="center"><img src="./docs/logo.svg" width="300" alt="Messagebird for Craft CMS icon"></p>

<h1 align="center">Messagebird for Craft CMS 3</h1>

This plugin provides a [Messagebird](https://www.messagebird.com/) integration for [Craft CMS](https://craftcms.com/).

## Supports

- SMS features

> The next services are in progress

- Voice features

## Requirements

This plugin requires Craft CMS 3.1.5 or later.

## Installation

You can install this plugin from the Plugin Store or with Composer.

#### From the Plugin Store

Go to the Plugin Store in your project’s Control Panel and search for “Messagebird”. Then click on the “Install” 
button in its modal window.

#### With Composer

Open your terminal and run the following commands:

```bash
# go to the project directory
cd /path/to/my-project.test

# tell Composer to load the plugin
composer require bertoost/craft-messagebird

# tell Craft to install the plugin
./craft install/plugin messagebird
```

## Setup

Once Messagebird is installed, go to Settings → Messagebird, and enter your API key and SMS Originator name (max. 11 characters). 
Enter your Messagebird API Key (which you can get from 
[dashboard.messagebird.com/en-us/developers/access](https://dashboard.messagebird.com/en-us/developers/access)), then click Save.

> **Tip:** The API Key setting can be set to an environment variables. See [Environmental Configuration](https://docs.craftcms.com/v3/config/environments.html) in the Craft docs to learn more about that.

## Usage

It's simple, so let's put in an example;

```php
// Use the plugin
use bertoost\messagebird\Plugin;

// Send a SMS
Plugin::getInstance()->getSms()
    // required: add at least one recipient & body
    ->addRecipient('+31600000000')
    ->setBody('This is a test')
    
    // optional: reference
    ->setReference('Testing SMS')
    
    // optional: schedule time
    ->setSchedule((new \DateTime())->modify('+5 minutes'))
    
    // send it
    ->send();
```