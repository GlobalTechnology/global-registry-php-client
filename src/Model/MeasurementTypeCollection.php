<?php namespace GlobalTechnology\GlobalRegistry\Model {

	class MeasurementTypeCollection extends AbstractCollection {
		const JSON_MEASUREMENT_TYPES = 'measurement_types';

		public static function fromJSON( array $json = null ) {
			return new MeasurementTypeCollection( $json[ self::JSON_MEASUREMENT_TYPES ], $json[ self::JSON_META ] );
		}

		public function __construct( $measurementTypes = array(), $meta = array() ) {
			parent::__construct( array(), $meta );
			foreach ( $measurementTypes as $measurementType ) {
				// Add measurementType to the collection if its already a Model
				if ( $measurementType instanceof MeasurementType ) {
					$this->data[ ] = $measurementType;
				}
				else {
					$this->data[ ] = new MeasurementType( $measurementType );
				}
			}
		}
	}
}
