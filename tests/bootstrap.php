<?php
error_reporting( E_ALL | E_STRICT );

//require_once 'PHPUnit/TextUI/TestRunner.php';
require dirname( __DIR__ ) . '/vendor/autoload.php';

// Add the services file to the default service builder
$servicesFile = __DIR__ . '/res/services.json';
Guzzle\Tests\GuzzleTestCase::setServiceBuilder( Guzzle\Service\Builder\ServiceBuilder::factory( $servicesFile ) );
Guzzle\Tests\GuzzleTestCase::setMockBasePath( __DIR__ . '/res/mock' );
