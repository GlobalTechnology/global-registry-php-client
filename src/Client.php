<?php namespace GlobalTechnology\GlobalRegistry {
	use GlobalTechnology\GlobalRegistry\Http\Plugin\QueryAggregatorPlugin;
	use GlobalTechnology\GlobalRegistry\Http\QueryAggregator\MixedArrayAggregator;
	use GlobalTechnology\GlobalRegistry\Model\EntityType;
	use Guzzle\Common\Collection;
	use Guzzle\Common\Exception\InvalidArgumentException;
	use Guzzle\Service\Description\ServiceDescription;

	class Client extends \Guzzle\Service\Client {
		const REGEX_UUID = '/^[0-9a-f]{8}-(?:[0-9a-f]{4}-){3}[0-9a-f]{12}$/i';

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
			$client->addSubscriber( new QueryAggregatorPlugin( new MixedArrayAggregator() ) );

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
		 * @param string $uuid
		 *
		 * @return \GlobalTechnology\GlobalRegistry\Model\Entity
		 */
		public function getEntity( $uuid ) {
			return $this->getCommand( 'GetEntity', array(
				'entity_id' => $uuid,
			) )->execute();
		}

		/**
		 * Delete an existing Entity
		 *
		 * @param string $uuid
		 *
		 * @return array|\Guzzle\Http\Message\Response
		 */
		public function deleteEntity( $uuid ) {
			return $this->getCommand( 'DeleteEntity', array(
				'entity_id' => $uuid,
			) )->execute();
		}

		/**
		 * Search for Entities
		 *
		 * @param string $type
		 * @param array  $filters
		 * @param int    $page
		 * @param int    $perPage
		 * @param int    $levels
		 * @param array  $fields
		 *
		 * @return Model\EntityCollection
		 */
		public function getEntities( $type, array $filters = array(), $page = null, $perPage = null, $levels = null, array $fields = null ) {
			$parameters = array(
				'entity_type' => $type,
				'filters'     => $filters,
			);

			if ( null !== $page ) $parameters[ 'page' ] = (int)$page;
			if ( null !== $perPage ) $parameters[ 'perPage' ] = (int)$perPage;
			if ( null !== $levels ) $parameters[ 'levels' ] = (int)$levels;
			if ( null !== $fields && ! empty( $fields ) ) $parameters[ 'fields' ] = implode( ',', $fields );

			return $this->getCommand( 'GetEntities', $parameters )->execute();
		}

		/**
		 * Search for Entities using a SBR RuleSet
		 *
		 * @param string|int $ruleset
		 * @param array      $filters
		 * @param string     $type
		 * @param int        $page
		 * @param int        $perPage
		 * @param int        $levels
		 * @param array      $fields
		 *
		 * @return Model\EntityCollection
		 */
		public function getEntitiesUsingRuleSet( $ruleset, array $filters = array(), $type = null, $page = null, $perPage = null, $levels = null, array $fields = null ) {
			$parameters = array(
				'ruleset' => $ruleset,
				'filters' => $filters,
			);
			if ( $type !== null ) $parameters[ 'entity_type' ] = $type;
			if ( $page !== null ) $parameters[ 'page' ] = $page;
			if ( $perPage !== null ) $parameters[ 'per_page' ] = $perPage;
			if ( null !== $levels ) $parameters[ 'levels' ] = (int)$levels;
			if ( null !== $fields && ! empty( $fields ) ) $parameters[ 'fields' ] = implode( ',', $fields );

			return $this->getCommand( 'GetEntitiesWithRuleSet', $parameters )->execute();
		}

		/*****************************************************
		 *                 Entity Types
		 ****************************************************/

		/**
		 * Get Entity Types
		 *
		 * @param array $filters
		 * @param int   $page
		 * @param int   $perPage
		 *
		 * @return \GlobalTechnology\GlobalRegistry\Model\EntityTypeCollection
		 */
		public function getEntityTypes( array $filters = array(), $page = 1, $perPage = 100 ) {
			return $this->getCommand( 'GetEntityTypes', array(
				'page'     => $page,
				'filters'  => $filters,
				'per_page' => $perPage,
			) )->execute();
		}

		/**
		 * Get and Entity Type by id
		 *
		 * @param string $uuid
		 *
		 * @return \GlobalTechnology\GlobalRegistry\Model\EntityType
		 */
		public function getEntityType( $uuid ) {
			return $this->getCommand( 'GetEntityType', array(
				'entity_type_id' => $uuid,
			) )->execute();
		}

		/**
		 * Delete an Entity Type
		 *
		 * @param string $uuid
		 *
		 * @return mixed
		 */
		public function deleteEntityType( $uuid ) {
			return $this->getCommand( 'DeleteEntityType', array(
				'entity_type_id' => $uuid,
			) )->execute();
		}

		/**
		 * Create an Entity Type
		 *
		 * @param EntityType $entityType
		 *
		 * @return \GlobalTechnology\GlobalRegistry\Model\EntityType
		 */
		public function createEntityType( EntityType $entityType ) {
			return $this->getCommand( 'CreateEntityType', array(
				'entity_type' => $entityType,
			) )->execute();
		}

		/**
		 * Update and Entity Type
		 *
		 * @param EntityType $entityType
		 *
		 * @return \GlobalTechnology\GlobalRegistry\Model\EntityType
		 */
		public function updateEntityType( EntityType $entityType ) {
			return $this->getCommand( 'UpdateEntityType', array(
				'entity_type_id' => $entityType->id,
				'entity_type'    => $entityType,
			) )->execute();
		}

		/**
		 * @param string $uuid
		 * @param array  $filters
		 *
		 * @return \GlobalTechnology\GlobalRegistry\Model\MeasurementType
		 */
		public function getMeasurementType( $uuid, array $filters = array() ) {
			return $this->getCommand( 'GetMeasurementType', array(
				'measurement_type_id' => $uuid,
				'filters'             => $filters,
			) )->execute();
		}

		public function getMeasurementTypes( array $filters = array(), $page = 1, $perPage = 25 ) {
			return $this->getCommand( 'GetMeasurementTypes', array(
				'filters'  => $filters,
				'page'     => $page,
				'per_page' => $perPage,
			) )->execute();
		}
	}
}
