<?php namespace GlobalTechnology\GlobalRegistry\Model {
	use Guzzle\Http\Exception\ClientErrorResponseException;
	use Guzzle\Service\Command\OperationCommand;
	use Guzzle\Service\Command\ResponseClassInterface;

	class MeasurementType implements ResponseClassInterface, \JsonSerializable {
		const JSON_MEASUREMENT_TYPE = 'measurement_type';

		public $id;
		public $name;
		public $description;
		public $category;
		public $frequency;
		public $unit;
		public $related_entity_type_id;
		public $measurements = array();

		public static function fromCommand( OperationCommand $command ) {
			$json = $command->getResponse()->json();
			if ( $json == null || ! array_key_exists( self::JSON_MEASUREMENT_TYPE, $json ) ) {
				throw new ClientErrorResponseException();
			}
			return new self( $json[ self::JSON_MEASUREMENT_TYPE ] );
		}

		public function __construct( $data ) {
			foreach ( $data as $name => $value ) {
				switch ( $name ) {
					case "id":
					case "name":
					case "description":
					case "category":
					case "frequency":
					case "unit":
					case "related_entity_type_id":
						$this->$name = $value;
						break;
					case "measurements":
						$this->measurements = array();
						foreach ( $value as $measurement ) {
							$this->measurements[ ] = new Measurement( $this, $measurement );
						}
						break;
				}
			}
		}

		public function jsonSerialize() {
			$data = array(
				'id'                     => $this->id,
				'name'                   => $this->name,
				'category'               => $this->category,
				'frequency'              => $this->frequency,
				'unit'                   => $this->unit,
				'related_entity_type_id' => $this->related_entity_type_id,
			);
			if ( isset( $this->description ) )
				$data[ 'description' ] = $this->description;
			return $data;
		}
	}
}
