<?php
/**
 * This file contains the Service Description for the Global Registry Entity endpoint.
 *
 * @see https://github.com/CruGlobal/global_registry/wiki/Entities
 * @see https://guzzle3.readthedocs.org/webservice-client/guzzle-service-descriptions.html
 */
return array(
	'operations' => array(
		'__Abstract_GetEntities' => array(
			'uri'           => 'entities',
			'httpMethod'    => 'GET',
			'responseClass' => 'GlobalTechnology\\GlobalRegistry\\Model\\EntityCollection',
			'parameters'    => array(
				'filters'  => array(
					'type'     => 'array',
					'location' => 'query',
					'required' => false,
				),
				'page'     => array(
					'type'     => 'integer',
					'location' => 'query',
					'required' => false,
				),
				'per_page' => array(
					'type'     => 'integer',
					'location' => 'query',
					'required' => false,
				),
				'levels'   => array(
					'type'     => 'integer',
					'location' => 'query',
					'required' => false,
				),
				'fields'   => array(
					'type'     => 'string',
					'location' => 'query',
					'required' => false,
				),
			),
		),
		'GetEntities'            => array(
			'extends'    => '__Abstract_GetEntities',
			'parameters' => array(
				'entity_type' => array(
					'type'     => 'string',
					'location' => 'query',
					'required' => true,
				),
			),
		),
		'GetEntitiesWithRuleSet' => array(
			'extends'    => '__Abstract_GetEntities',
			'parameters' => array(
				'ruleset'     => array(
					'type'     => array( 'string', 'integer' ),
					'location' => 'query',
					'required' => true,
				),
				'entity_type' => array(
					'type'     => 'string',
					'location' => 'query',
					'required' => false,
				),
			),
		),
		'GetEntity'              => array(
			'httpMethod'    => 'GET',
			'uri'           => 'entities/{entity_id}',
			'responseClass' => 'GlobalTechnology\\GlobalRegistry\\Model\\Entity',
			'parameters'    => array(
				'entity_id' => array(
					'type'     => 'string',
					'pattern'  => \GlobalTechnology\GlobalRegistry\Client::REGEX_UUID,
					'required' => true,
					'location' => 'uri',
				),
			),
		),
		'DeleteEntity'           => array(
			'extends'      => 'GetEntity',
			'httpMethod'   => 'DELETE',
			'responseType' => 'primitive',
		),
		'CreateEntity'           => array(
			'uri'           => 'entities',
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
		'UpdateEntity'           => array(
			'extends'       => 'CreateEntity',
			'httpMethod'    => 'PUT',
			'uri'           => 'entities/{entity_id}/',
			'responseClass' => 'GlobalTechnology\\GlobalRegistry\\Model\\Entity',
			'parameters'    => array(
				'entity_id' => array(
					'type'     => 'string',
					'pattern'  => \GlobalTechnology\GlobalRegistry\Client::REGEX_UUID,
					'required' => true,
					'location' => 'uri',
				),
			),
		),
	),
);
