<?php namespace GlobalTechnology\GlobalRegistry\Model {

	use GlobalTechnology\GlobalRegistry\Client;

	class Relationship implements \JsonSerializable {

		const RELATIONSHIP_ENTITY_ID = 'relationship_entity_id';
		const CLIENT_INTEGRATION_ID  = 'client_integration_id';

		public $entity_type;
		public $entity_id;
		public $relationship_id;
		public $client_integration_id;

		public function __construct( array $relationship = array() ) {
			foreach ( $relationship as $name => $id ) {
				switch ( $name ) {
					// SBR passes these through from GR, we ignore them.
					case 'created_by':
					case 'updated_at':
					case 'user_entered':
						break;
					// Relationship Entity ID
					case self::RELATIONSHIP_ENTITY_ID:
						$this->relationship_id = $id;
						break;
					// Client Integration ID - this can be an array when SBR passes through filters[owned_by]=all
					case self::CLIENT_INTEGRATION_ID:
						if ( is_array( $id ) )
							$this->client_integration_id = array_key_exists( 'value', $id ) ? $id[ 'value' ] : null;
						else
							$this->client_integration_id = $id;
						break;
					// Entity Type and ID
					default:
						$this->entity_type = $name;
						$this->entity_id   = $id;
						break;
				}
			}
		}

		public function jsonSerialize() {
			$data = array(
				$this->entity_type => $this->entity_id,
			);
			if ( isset( $this->client_integration_id ) )
				$data[ self::CLIENT_INTEGRATION_ID ] = $this->client_integration_id;
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
	}
}
