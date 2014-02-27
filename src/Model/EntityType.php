<?php namespace GlobalTechnology\GlobalRegistry\Model {
	use Guzzle\Service\Command\ResponseClassInterface;
	use Guzzle\Service\Command\OperationCommand;

	class EntityType implements ResponseClassInterface, \JsonSerializable {
		const JSON_ENTITY_TYPE = 'entity_type';

		public $id;
		public $name;
		public $description;
		public $field_type;
		public $fields;

		public static function fromCommand( OperationCommand $command ) {
			$json = $command->getResponse()->json();
			if ( $json == null || ! array_key_exists( self::JSON_ENTITY_TYPE, $json ) ) {
				throw new ClientErrorResponseException();
			}
			return new self( $json[ self::JSON_ENTITY_TYPE ] );
		}

		public function __construct( $data ) {
			foreach ( $data as $name => $value ) {
				switch ( $name ) {
					case "id":
					case "name":
					case "description":
					case "field_type":
						$this->$name = $value;
						break;
					case "fields":
						$this->fields = array();
						foreach ( $value as $entityType ) {
							$this->fields[ ] = new EntityType( $entityType );
						}
						break;
				}
			}
		}

		public function jsonSerialize() {
			$data = array(
				'id'   => $this->id,
				'name' => $this->name,
			);
			if ( isset( $this->description ) )
				$data[ 'description' ] = $this->description;
			if ( isset( $this->field_type ) )
				$data[ 'field_type' ] = $this->field_type;
			if ( ! empty( $this->fields ) )
				$data[ 'fields' ] = $this->fields;
			return $data;
		}

	}
}
