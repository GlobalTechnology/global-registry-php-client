<?php namespace GlobalTechnology\GlobalRegistry\Model {

	use GlobalTechnology\GlobalRegistry\Client;

	class Relationship implements \JsonSerializable {

		const RELATIONSHIP_ENTITY_ID = 'relationship_entity_id';
		const CLIENT_INTEGRATION_ID  = 'client_integration_id';

		public $entity_type;
		public $entity_id;
		public $relationship_id;
		public $client_integration_id;

		protected $data;

		public function __construct( $type = null, array $relationship = array() ) {
			$this->entity_type = $type;
			$this->data        = array();

			$first_uuid_value = false;
			$first_uuid_type  = false;

			foreach ( $relationship as $name => $value ) {
				switch ( $name ) {
					// SBR passes these through from GR, we ignore them.
					case 'created_by':
					case 'updated_at':
					case 'user_entered':
						break;
					// Relationship Entity ID
					case self::RELATIONSHIP_ENTITY_ID:
						$this->relationship_id = $value;
						break;
					// Client Integration ID - this can be an array when SBR passes through filters[owned_by]=all
					case self::CLIENT_INTEGRATION_ID:
						if ( is_array( $value ) )
							$this->client_integration_id = array_key_exists( 'value', $value ) ? $value[ 'value' ] : null;
						else
							$this->client_integration_id = $value;
						break;
					// Attempt to use $type as entity_type
					case $type:
						if ( $this->isUuid( $value ) ) {
							$this->entity_type = $name;
							$this->entity_id   = $value;
						}
						break;
					// Entity Type and ID
					default:
						// Remember first encountered uuid.
						if ( $first_uuid_type === false && $this->isUuid( $value ) ) {
							$first_uuid_type  = $name;
							$first_uuid_value = $value;
						}
						$this->data[ $name ] = $value;
						break;
				}
			}
			// If entity_id is missing, use the first found uuid type/value
			if ( $this->entity_id === null && $first_uuid_value ) {
				$this->entity_type = $first_uuid_type;
				$this->entity_id   = $first_uuid_value;
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
			$data = array(
				$this->entity_type => $this->entity_id,
			);
			if ( isset( $this->client_integration_id ) )
				$data[ self::CLIENT_INTEGRATION_ID ] = $this->client_integration_id;
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
		 * @param Client $client
		 *
		 * @return Entity|null
		 */
		public function getEntity( Client $client ) {
			return ( ! empty( $this->entity_id ) ) ?
				$client->getEntity( $this->entity_id ) : null;
		}

		/**
		 * @param Client $client
		 *
		 * @return Entity|null
		 */
		public function getRelationshipEntity( Client $client ) {
			return ( ! empty( $this->relationship_id ) ) ?
				$client->getEntity( $this->relationship_id ) : null;
		}

		/**
		 * @param string $value
		 *
		 * @return bool
		 */
		private function isUuid( $value ) {
			return preg_match( '/([a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12})/', $value ) === 1;
		}
	}
}
