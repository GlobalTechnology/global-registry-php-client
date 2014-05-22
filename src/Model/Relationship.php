<?php namespace GlobalTechnology\GlobalRegistry\Model {

	use GlobalTechnology\GlobalRegistry\Client;

	class Relationship {

		const RELATIONSHIP_ENTITY_ID = 'relationship_entity_id';

		public $entity_type;
		public $entity_id;
		public $relationship_id;

		public function __construct( array $relationship = array() ) {
			foreach ( $relationship as $name => $id ) {
				if ( $name === self::RELATIONSHIP_ENTITY_ID )
					$this->relationship_id = $id;
				else {
					$this->entity_type = $name;
					$this->entity_id   = $id;
				}
			}
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
