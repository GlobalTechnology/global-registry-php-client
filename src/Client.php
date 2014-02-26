<?php namespace GlobalTechnology\GlobalRegistry {
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
			$command = $this->getCommand( 'CreateEntity', array(
				'entity_type' => $entity->type,
				'entity'      => array(
					$entity->type => $entity,
				),
			) );
			return $this->execute( $command );
		}

		/**
		 * Update an existing Entity by id
		 *
		 * @param \GlobalTechnology\GlobalRegistry\Model\Entity $entity
		 *
		 * @return \GlobalTechnology\GlobalRegistry\Model\Entity
		 */
		public function updateEntity( \GlobalTechnology\GlobalRegistry\Model\Entity $entity ) {
			$command = $this->getCommand( 'UpdateEntity', array(
				'entity_id'   => $entity->id,
				'entity_type' => $entity->type,
				'entity'      => array(
					$entity->type => $entity,
				)
			) );
			return $this->execute( $command );
		}

		/**
		 * Fetch an existing Entity by id
		 *
		 * @param int    $id
		 * @param string $type
		 *
		 * @return \GlobalTechnology\GlobalRegistry\Model\Entity
		 */
		public function getEntity( $id, $type ) {
			$command = $this->getCommand( 'GetEntity', array(
				'entity_id'   => $id,
				'entity_type' => $type,
			) );
			return $this->execute( $command );
		}

		/**
		 * Delete an existing Entity
		 *
		 * @param int    $id
		 * @param string $type
		 *
		 * @return array|\Guzzle\Http\Message\Response
		 */
		public function deleteEntity( $id, $type ) {
			$command = $this->getCommand( 'DeleteEntity', array(
				'entity_id'   => $id,
				'entity_type' => $type,
			) );
			return $this->execute( $command );
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
			$command = $this->getCommand( 'SearchEntities', array(
				'entity_type' => $type,
				'page'        => $page,
				'filters'     => $filters,
			) );
			return $this->execute( $command );
		}
	}
}
