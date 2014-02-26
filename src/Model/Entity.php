<?php namespace GlobalTechnology\GlobalRegistry\Model {
	use Guzzle\Service\Command\ResponseClassInterface;
	use Guzzle\Service\Command\OperationCommand;

	class Entity implements ResponseClassInterface, \JsonSerializable {

		const JSON_ENTITY = 'entity';

		public $type;
		public $id;
		public $client_integration_id;
		private $data;

		public static function fromCommand( OperationCommand $command ) {
			$json = $command->getResponse()->json();
			if ( $json == null || ! array_key_exists( self::JSON_ENTITY, $json ) ) {
				//TODO throw Exception
				return null;
			}
			// Response should always contains root of 'entity'
			$entity      = $json[ self::JSON_ENTITY ];
			$entity_type = array_keys( $entity )[ 0 ];
			return new self( $entity_type, $entity[ $entity_type ] );
		}

		public function __construct( $type, $data = array() ) {
			$this->data = array();
			$this->type = $type;
			foreach ( $data as $name => $value ) {
				switch ( $name ) {
					case "id":
					case "client_integration_id":
						$this->$name = $value;
						break;
					default:
						if ( is_array( $value ) )
							$this->data[ $name ] = new Entity( $name, $value );
						else
							$this->data[ $name ] = $value;
				}
			}
		}

		public function __get( $name ) {
			return isset( $this->data[ $name ] ) ? $this->data[ $name ] : null;
		}

		public function __set( $name, $value = null ) {
			if ( $value === null ) {
				$this->__unset( $name );
			}
			else {
				$this->data[ $name ] = $value;
			}
		}

		public function __isset( $name ) {
			return isset( $this->data[ $name ] );
		}

		public function __unset( $name ) {
			unset( $this->data[ $name ] );
		}

		public function jsonSerialize() {
			$data = array();
			if ( isset( $this->id ) )
				$data[ 'id' ] = $this->id;
			if ( isset( $this->client_integration_id ) )
				$data[ 'client_integration_id' ] = $this->client_integration_id;
			foreach ( $this->data as $name => $value ) {
				$data[ $name ] = $value;
			}
			return $data;
		}
	}
}
