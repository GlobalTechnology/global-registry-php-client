<?php
/**
 * This file contains the Service Description for the Global Registry.
 * Endpoints are included from separate description files.
 *
 * @see https://github.com/CruGlobal/global_registry/wiki/API-v1.0
 * @see http://guzzle.readthedocs.org/en/latest/webservice-client/guzzle-service-descriptions.html
 */
return array(
	'name'     => 'Global Registry',
	'includes' => array(
		'endpoints/entities.php',
		'endpoints/entity-types.php',
	),
);
