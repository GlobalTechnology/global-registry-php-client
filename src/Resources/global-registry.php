<?php
return array(
	'name'       => 'Global Registry',
	'operations' => array(
		'Entities' => array(
			'uri' => '/entities',
			'parameters' => array(
				'entity_type' => array(
					'type'     => 'string',
					'location' => 'query',
					'required' => true,
				),
			),
		),
		'CreateEntity' => array(
			'extends' => 'Entities',
			'httpMethod'   => 'POST',
			'parameters'   => array(
				'entity'      => array(
					'type'     => 'object',
					'required' => true,
					'location' => 'json',
				),
			),
		),
		'UpdateEntity' => array(
			'extends' => 'CreateEntity',
			'httpMethod' => 'PUT',
			'uri' => '/entities/{entity_id}/',
			'parameters'   => array(
				'entity_id'    => array(
					'type'     => 'string',
					'required' => true,
					'location' => 'uri',
				),
			),
		),
	),
);
