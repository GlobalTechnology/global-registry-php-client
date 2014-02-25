Global Registry PHP Client Library
==================================

This is a PHP client library for the [Global Registry](https://github.com/CruGlobal/global_registry)

This repository uses the [git-flow](http://nvie.com/posts/a-successful-git-branching-model/) branching model. Please do development on the develop branch.

### Installing via Composer

Use of the Global Registry PHP Client is through [Composer](http://getcomposer.org).

# Edit composer.json

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/GlobalTechnology/global-registry-php-client"
        }
    ],
    "require": {
        "globaltechnology/global-registry-php-client": "dev-develop"
    }
}
```

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php

# Install Packages
php composer.phar install
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

Basic Usage
-----------

```php
<?php

$client = \GlobalTechnology\GlobalRegistry\Client::factory( array(
	'base_url' => '__GLOBAL_REGISTRY_URL__',
	'access_token' => '__ACCESS_TOKEN__',
) );

$entity = $client->createEntity( 'person', array(
	'first_name'            => 'John',
	'last_name'             => 'Doe',
	'address'               => array( 'country' => 'US' ),
	'client_integration_id' => '1',
) );

// $entity = array (
//   'person' => array (
//     'id' => 9947529,
//     'parent_id' => NULL,
//     'first_name' => 'John',
//     'last_name' => 'Doe',
//     'address' => array (
//       'id' => 9947532,
//       'country' => 'US',
//     ),
//     'client_integration_id' => 1,
//   ),
// );

// This may fail if 'id' attributes exist in child entities
$entity = $client->updateEntity( 9947529, 'person', $entity['person'] );
```
