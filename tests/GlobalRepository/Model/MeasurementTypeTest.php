<?php namespace GlobalTechnology\GlobalRegistry\Tests\Model {
	use GlobalTechnology\GlobalRegistry\Model\MeasurementType;

	class MeasurementTypeTest extends \PHPUnit_Framework_TestCase {
		public function testMeasurementTypeConstructor() {
			$data = array(
				'id'                     => '672fbfc0-e0e6-11e3-8f08-12725f8f377c',
				'name'                   => 'ActualReportingNodes',
				'description'            => null,
				'category'               => 'LMI',
				'frequency'              => 'monthly',
				'unit'                   => 'people',
				'related_entity_type_id' => '896e2bae-e0d6-11e3-920e-12725f8f377c',
				'measurements'           => array(
					array(
						'id'                => '143af4f2-e761-11e3-95c6-12725f8f377c',
						'period'            => '2014-01',
						'value'             => '1.0',
						'related_entity_id' => '69993e48-e75e-11e3-80cc-12725f8f377c',
					),
					array(
						'id'                => '143d75c4-e761-11e3-b248-12725f8f377c',
						'period'            => '2014-01',
						'value'             => '2.0',
						'related_entity_id' => '8689d4a4-e75e-11e3-b85b-12725f8f377c',
					),
					array(
						'id'                => '143eb628-e761-11e3-8e22-12725f8f377c',
						'period'            => '2014-01',
						'value'             => '1.0',
						'related_entity_id' => '888531ea-e75e-11e3-8baf-12725f8f377c',
					),
				),
			);

			$measurementType = new MeasurementType( $data );

			$this->assertInstanceOf( '\GlobalTechnology\GlobalRegistry\Model\MeasurementType', $measurementType );
			$this->assertEquals( $data[ 'id' ], $measurementType->id );
			$this->assertEquals( $data[ 'name' ], $measurementType->name );
			$this->assertEquals( $data[ 'description' ], $measurementType->description );
			$this->assertEquals( $data[ 'category' ], $measurementType->category );
			$this->assertEquals( $data[ 'frequency' ], $measurementType->frequency );
			$this->assertEquals( $data[ 'unit' ], $measurementType->unit );
			$this->assertEquals( $data[ 'related_entity_type_id' ], $measurementType->related_entity_type_id );

			// test measurements
			$this->assertEquals( 3, count( $measurementType->measurements ) );
			foreach ( $measurementType->measurements as $measurement ) {
				$this->assertEquals( $measurementType, $measurement->type );
				$this->assertEquals( '2014-01', $measurement->period );
			}
			$this->assertEquals( '143af4f2-e761-11e3-95c6-12725f8f377c', $measurementType->measurements[ 0 ]->id );
			$this->assertEquals( '143d75c4-e761-11e3-b248-12725f8f377c', $measurementType->measurements[ 1 ]->id );
			$this->assertEquals( '143eb628-e761-11e3-8e22-12725f8f377c', $measurementType->measurements[ 2 ]->id );
			$this->assertEquals( 1, $measurementType->measurements[ 0 ]->value );
			$this->assertEquals( 2, $measurementType->measurements[ 1 ]->value );
			$this->assertEquals( 1, $measurementType->measurements[ 2 ]->value );
			$this->assertEquals( '69993e48-e75e-11e3-80cc-12725f8f377c', $measurementType->measurements[ 0 ]->related_entity_id );
			$this->assertEquals( '8689d4a4-e75e-11e3-b85b-12725f8f377c', $measurementType->measurements[ 1 ]->related_entity_id );
			$this->assertEquals( '888531ea-e75e-11e3-8baf-12725f8f377c', $measurementType->measurements[ 2 ]->related_entity_id );
		}
	}
}
