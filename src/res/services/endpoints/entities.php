<?php
/**
 * This file contains the Service Description for the Global Registry Entity endpoint.
 *
 * @see https://github.com/CruGlobal/global_registry/wiki/Entities
 * @see http://guzzle.readthedocs.org/en/latest/webservice-client/guzzle-service-descriptions.html
 */
return array(
	'operations' => array(
		'Entities'       => array(
			'uri'        => '/entities',
			'parameters' => array(
				'entity_type' => array(
					'type'     => 'string',
					'location' => 'query',
					'required' => true,
				),
			),
		),
		'CreateEntity'   => array(
			'extends'       => 'Entities',
			'httpMethod'    => 'POST',
			'responseClass' => 'GlobalTechnology\\GlobalRegistry\\Model\\Entity',
			'parameters'    => array(
				'entity' => array(
					'type'     => 'object',
					'required' => true,
					'location' => 'json',
				),
			),
		),
		'UpdateEntity'   => array(
			'extends'       => 'CreateEntity',
			'httpMethod'    => 'PUT',
			'uri'           => '/entities/{entity_id}/',
			'responseClass' => 'GlobalTechnology\\GlobalRegistry\\Model\\Entity',
			'parameters'    => array(
				'entity_id' => array(
					'type'     => 'integer',
					'required' => true,
					'location' => 'uri',
				),
			),
		),
		'GetEntity'      => array(
			'extends'       => 'Entities',
			'httpMethod'    => 'GET',
			'uri'           => '/entities/{entity_id}/',
			'responseClass' => 'GlobalTechnology\\GlobalRegistry\\Model\\Entity',
			'parameters'    => array(
				'entity_id' => array(
					'type'     => 'integer',
					'required' => true,
					'location' => 'uri',
				),
			),
		),
		'DeleteEntity'   => array(
			'extends'    => 'GetEntity',
			'httpMethod' => 'DELETE',
		),
		'SearchEntities' => array(
			'extends'       => 'Entities',
			'httpMethod'    => 'GET',
			'responseClass' => 'GlobalTechnology\\GlobalRegistry\\Model\\EntityCollection',
			'parameters'    => array(
				'filters' => array(
					'type'     => 'array',
					'location' => 'query',
					'required' => false,
				),
				'page'    => array(
					'type'     => 'integer',
					'location' => 'query',
					'required' => false,
				),
			)
		),
	),
);
