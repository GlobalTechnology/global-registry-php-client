<?php
/**
 * This file contains the Service Description for the Global Registry Measurement Types endpoint.
 *
 * @see https://guzzle3.readthedocs.org/webservice-client/guzzle-service-descriptions.html
 */
return array(
	'operations' => array(
		'GetMeasurementTypes' => array(
			'uri'           => 'measurement_types',
			'httpMethod'    => 'GET',
			'responseClass' => 'GlobalTechnology\\GlobalRegistry\\Model\\MeasurementTypeCollection',
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
		'GetMeasurementType' => array(
			'uri'           => 'measurement_types/{measurement_type_id}',
			'httpMethod'    => 'GET',
			'responseClass' => 'GlobalTechnology\\GlobalRegistry\\Model\\MeasurementType',
			'parameters'    => array(
				'measurement_type_id' => array(
					'type'     => 'string',
					'pattern'  => \GlobalTechnology\GlobalRegistry\Client::REGEX_UUID,
					'location' => 'uri',
					'required' => true,
				),
				'filters'             => array(
					'type'     => 'array',
					'location' => 'query',
					'required' => false,
				),
			),
		),
	),
);
