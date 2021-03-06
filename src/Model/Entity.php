<?php namespace GlobalTechnology\GlobalRegistry\Model {

	use Guzzle\Http\Exception\ClientErrorResponseException;
	use Guzzle\Service\Command\ResponseClassInterface;
	use Guzzle\Service\Command\OperationCommand;

	class Entity implements ResponseClassInterface, \JsonSerializable {

		const JSON_ENTITY        = 'entity';
		const FIELD_ID           = 'id';
		const FIELD_CLIENT_ID    = 'client_integration_id';
		const FIELD_RELATIONSHIP = ':relationship';

		public  $type;
		public  $id;
		public  $client_integration_id;
		private $data;

		public static function fromCommand( OperationCommand $command ) {
			$json = $command->getResponse()->json();
			if ( $json == null || ! array_key_exists( self::JSON_ENTITY, $json ) ) {
				throw new ClientErrorResponseException();
			}
			// Response should always contain root of 'entity'
			$entity      = $json[ self::JSON_ENTITY ];
			$entity_type = array_keys( $entity )[ 0 ];
			return new self( $entity_type, $entity[ $entity_type ] );
		}

		public function __construct( $type, $data = array() ) {
			$this->data = array();
			$this->type = $type;
			foreach ( $data as $name => $value ) {
				switch ( $name ) {
					case self::FIELD_ID:
					case self::FIELD_CLIENT_ID:
						$this->$name = $value;
						break;
					default:
						if ( $this->isRelationship( $name ) ) {
							$this->data[ $name ] = new RelationshipCollection( $value, $this->relationshipType( $name ) );
						}
						else {
							if ( is_array( $value ) ) {
								// Single Entity
								if ( $this->isAssociativeArray( $value ) )
									$this->data[ $name ] = new Entity( $name, $value );
								// Array of Entities or primitives
								else {
									$this->data[ $name ] = array();
									foreach ( $value as $index => $item ) {
										// Entity
										if ( is_array( $item ) )
											$this->data[ $name ][] = new Entity( $name, $item );
										// Primitive (string, number)
										else
											$this->data[ $name ][] = $item;
									}
								}
							}
							else
								$this->data[ $name ] = $value;
						}
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

		public function addEntity( Entity $entity ) {
			$name = $entity->type;
			if ( isset( $this->data[ $name ] ) ) {
				if ( is_array( $this->data[ $name ] ) )
					$this->data[ $name ][] = $entity;
				else {
					$array               = array();
					$array[]             = $this->data[ $name ];
					$array[]             = $entity;
					$this->data[ $name ] = $array;
				}
			}
			else {
				$this->data[ $name ] = $entity;
			}
			return $entity;
		}

		public function jsonSerialize() {
			$data = array();
			if ( isset( $this->id ) )
				$data[ self::FIELD_ID ] = $this->id;
			if ( isset( $this->client_integration_id ) )
				$data[ self::FIELD_CLIENT_ID ] = $this->client_integration_id;
			foreach ( $this->data as $name => $value ) {
				// An array of one item should be returned as the entity/primitive, not an array
				if ( is_array( $value ) && 1 === count( $value ) )
					$data[ $name ] = $value[ 0 ];
				else
					$data[ $name ] = $value;
			}
			return $data;
		}

		/**
		 * @param $name
		 *
		 * @return bool
		 */
		public function hasRelationship( $name ) {
			$key = $this->isRelationship( $name ) ? $name : $name . self::FIELD_RELATIONSHIP;
			return isset( $this->$key ) && $this->$key instanceof RelationshipCollection;
		}

		/**
		 * @param $name
		 *
		 * @return null|RelationshipCollection
		 */
		public function getRelationship( $name ) {
			$key = $this->isRelationship( $name ) ? $name : $name . self::FIELD_RELATIONSHIP;
			if ( $this->hasRelationship( $key ) )
				return $this->$key;
			return null;
		}

		public function addRelationship( Relationship $relationship ) {
			$key = $relationship->entity_type . self::FIELD_RELATIONSHIP;
			if ( ! $this->hasRelationship( $key ) ) {
				$this->$key = new RelationshipCollection( array(), $relationship->entity_type );
			}
			$collection   = $this->getRelationship( $key );
			$collection[] = $relationship;
		}

		private function isRelationship( $key ) {
			$length = strlen( self::FIELD_RELATIONSHIP );
			return ( substr( $key, - $length ) === self::FIELD_RELATIONSHIP );
		}

		private function relationshipType( $key ) {
			$length = strlen( self::FIELD_RELATIONSHIP );
			return substr( $key, 0, - $length );
		}

		private function isAssociativeArray( array $array ) {
			return array_keys( $array ) !== range( 0, count( $array ) - 1 );
		}
	}
}
