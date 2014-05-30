<?php
/**
 * This file contains the Service Description for the Global Registry Entity Types endpoint.
 *
 * @see https://github.com/CruGlobal/global_registry/wiki/Entity-Types
 * @see https://guzzle3.readthedocs.org/webservice-client/guzzle-service-descriptions.html
 */
return array(
	'operations' => array(
		'GetEntityTypes'   => array(
			'uri'           => 'entity_types',
			'httpMethod'    => 'GET',
			'responseClass' => 'GlobalTechnology\\GlobalRegistry\\Model\\EntityTypeCollection',
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
			),
		),
		'GetEntityType'    => array(
			'uri'           => 'entity_types/{entity_type_id}',
			'httpMethod'    => 'GET',
			'responseClass' => 'GlobalTechnology\\GlobalRegistry\\Model\\EntityType',
			'parameters'    => array(
				'entity_type_id' => array(
					'type'     => 'string',
					'pattern'  => \GlobalTechnology\GlobalRegistry\Client::REGEX_UUID,
					'location' => 'uri',
					'required' => true,
				),
			),
		),
		'DeleteEntityType' => array(
			'extends'      => 'GetEntityType',
			'httpMethod'   => 'DELETE',
			'responseType' => 'primitive',
		),
		'CreateEntityType' => array(
			'uri'           => 'entity_types',
			'httpMethod'    => 'POST',
			'responseClass' => 'GlobalTechnology\\GlobalRegistry\\Model\\EntityType',
			'parameters'    => array(
				'entity_type' => array(
					'type'     => 'object',
					'location' => 'json',
					'required' => true,
				),
			),
		),
		'UpdateEntityType' => array(
			'extends'       => 'GetEntityType',
			'httpMethod'    => 'PUT',
			'responseClass' => 'GlobalTechnology\\GlobalRegistry\\Model\\EntityType',
			'parameters'    => array(
				'entity_type' => array(
					'type'     => 'object',
					'location' => 'json',
					'required' => true,
				),
			),
		),
	),
);
