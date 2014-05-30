<?php namespace GlobalTechnology\GlobalRegistry\Tests\Model {
	use GlobalTechnology\GlobalRegistry\Model\MeasurementType;

	class MeasurementTypeTest extends \PHPUnit_Framework_TestCase {
		public function testMeasurementTypeConstructor() {
			$data = array(
				'id'                     => '594567f8-d55a-11e3-98ea-12725f8f377c',
				'name'                   => 'Media Exposures',
				'description'            => '',
				'category'               => 'LMI',
				'frequency'              => 'monthly',
				'unit'                   => 'people',
				'related_entity_type_id' => 'a5499c9a-d556-11e3-af5a-12725f8f377c',
				'measurements'           => array(),
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
		}
	}
}
