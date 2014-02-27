<?php namespace GlobalTechnology\GlobalRegistry {
	use GlobalTechnology\GlobalRegistry\Model\EntityType;
	use Guzzle\Common\Collection;
	use Guzzle\Common\Exception\InvalidArgumentException;
	use Guzzle\Service\Description\ServiceDescription;

	class Client extends \Guzzle\Service\Client {
		/**
		 * Required Client Factory Options
		 * @var array
		 */
		private static $required = array(
			'base_url',
			'access_token',
		);

		/**
		 * Creates a Client for the Global Registry
		 *
		 * @param array $config
		 *
		 * @return Client|\Guzzle\Service\Client
		 * @throws \Guzzle\Common\Exception\InvalidArgumentException
		 */
		public static function factory( $config = array() ) {
			// Make sure required options are set
			foreach ( self::$required as $property ) {
				if ( empty( $config[ $property ] ) ) {
					throw new InvalidArgumentException( "Argument '{$property}' must not be blank" );
				}
			}

			$config = Collection::fromConfig( $config, array(), self::$required );

			$client = new self( $config->get( 'base_url' ), $config );
			$client->setDefaultOption( 'headers/Authorization', "Bearer {$config['access_token']}" );
			$client->setDefaultOption( 'headers/Accept', 'application/json' );
			$client->setDescription( ServiceDescription::factory( dirname( __FILE__ ) . '/res/services/global-registry.php' ) );

			return $client;
		}


		/*****************************************************
		 *                    Entities
		 ****************************************************/

		/**
		 * Create a new Entity on the Global Registry.
		 * @see https://github.com/CruGlobal/global_registry/wiki/Add-Entity
		 *
		 * @param \GlobalTechnology\GlobalRegistry\Model\Entity $entity
		 *
		 * @return \GlobalTechnology\GlobalRegistry\Model\Entity
		 */
		public function createEntity( \GlobalTechnology\GlobalRegistry\Model\Entity $entity ) {
			return $this->getCommand( 'CreateEntity', array(
				'entity' => array(
					$entity->type => $entity,
				),
			) )->execute();
		}

		/**
		 * Update an existing Entity by id
		 *
		 * @param \GlobalTechnology\GlobalRegistry\Model\Entity $entity
		 *
		 * @return \GlobalTechnology\GlobalRegistry\Model\Entity
		 */
		public function updateEntity( \GlobalTechnology\GlobalRegistry\Model\Entity $entity ) {
			return $this->getCommand( 'UpdateEntity', array(
				'entity_id' => $entity->id,
				'entity'    => array(
					$entity->type => $entity,
				)
			) )->execute();
		}

		/**
		 * Fetch an existing Entity by id
		 *
		 * @param int $id
		 *
		 * @return \GlobalTechnology\GlobalRegistry\Model\Entity
		 */
		public function getEntity( $id ) {
			return $this->getCommand( 'GetEntity', array(
				'entity_id' => $id,
			) )->execute();
		}

		/**
		 * Delete an existing Entity
		 *
		 * @param int    $id
		 *
		 * @return array|\Guzzle\Http\Message\Response
		 */
		public function deleteEntity( $id ) {
			return $this->getCommand( 'DeleteEntity', array(
				'entity_id'   => $id,
			) )->execute();
		}

		/**
		 * Search for Entities
		 *
		 * @param string $type
		 * @param int    $page
		 * @param array  $filters
		 *
		 * @return \GlobalTechnology\GlobalRegistry\Model\EntityCollection
		 */
		public function getEntities( $type, $page = 1, $filters = array() ) {
			return $this->getCommand( 'GetEntities', array(
				'entity_type' => $type,
				'page'        => $page,
				'filters'     => $filters,
			) )->execute();
		}

		/*****************************************************
		 *                 Entity Types
		 ****************************************************/

		public function getEntityTypes( $filters = array() ) {
			return $this->getCommand( 'GetEntityTypes', array(
				'filters' => $filters,
			) )->execute();
		}

		public function getEntityType( $id ) {
			return $this->getCommand( 'GetEntityType', array(
				'entity_type_id' => $id,
			) )->execute();
		}

		public function deleteEntityType( $id ) {
			return $this->getCommand( 'DeleteEntityType', array(
				'entity_type_id' => $id,
			) )->execute();
		}

		public function createEntityType( EntityType $entityType ) {
			return $this->getCommand( 'CreateEntityType', array(
				'entity_type' => $entityType,
			) )->execute();
		}

		public function updateEntityType( EntityType $entityType ) {
			return $this->getCommand( 'UpdateEntityType', array(
				'entity_type_id' => $entityType->id,
				'entity_type'    => $entityType,
			) )->execute();
		}

	}
}
