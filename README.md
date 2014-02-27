Global Registry PHP Client Library
==================================

This is a PHP client library for the [Global Registry](https://github.com/CruGlobal/global_registry)

This repository uses the [git-flow](http://nvie.com/posts/a-successful-git-branching-model/) branching model. Please do development on the develop branch.

# Installing via Composer

Use of the Global Registry PHP Client is through [Composer](http://getcomposer.org).

Create or edit composer.json and add the following
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
From the command line, install composer and required packages.
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
require 'vendor/autoload.php';

$client = \GlobalTechnology\GlobalRegistry\Client::factory( array(
	'base_url' => '__GLOBAL_REGISTRY_URL__',
	'access_token' => '__ACCESS_TOKEN__',
) );

// Create Entity
$entity = $client->createEntity( new \GlobalTechnology\GlobalRegistry\Model\Entity( 'person', array(
	'first_name'            => 'John',
	'last_name'             => 'Doe',
	'address'               => array( 'country' => 'US' ),
	'client_integration_id' => '1',
) ) );

// Get an Entity
$entity = $client->getEntity( 7178632 );

// Update an Entity
$entity->last_name = 'TestUser';
$entity = $client->updateEntity( $entity );

// Delete an Entity
$client->deleteEntity( $entity->id );

// Search for Entities
$entities = $client->getEntities( 'person', /*page*/ 1, array( 'first_name' => 'john', 'address' => array( 'country' => 'UK' ) ) );
// $entities instanceof \GlobalTechnology\GlobalRegistry\Model\EntityCollection
foreach( $entities as $entity ) {
	echo "{$entity->first_name} {$entity->last_name}";
}
// This will get simplified in the future
if( $entities->total > $entities->to )
	$entities = $client->getEntities( 'person', $entities->page + 1, array( ... ) );
```
