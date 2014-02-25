<?php namespace GlobalTechnology\GlobalRegistry {
	use Guzzle\Common\Collection;
	use Guzzle\Common\Exception\InvalidArgumentException;
	use Guzzle\Service\Description\ServiceDescription;

	class Client extends \Guzzle\Service\Client {
		/**
		 * Required Options
		 * @var array
		 */
		private static $required = array(
			'base_url',
			'access_token',
		);

		public static function factory( $config = array() ) {
			foreach ( self::$required as $property ) {
				if ( empty( $config[ $property ] ) ) {
					throw new InvalidArgumentException( "Argument '{$property}' must not be blank" );
				}
			}

			$config = Collection::fromConfig( $config, array(), self::$required );

			$client = new self( $config->get( 'base_url' ), $config );
			$client->setDefaultOption( 'headers/Authorization', "Bearer {$config['access_token']}" );
			$client->setDescription( ServiceDescription::factory( dirname( __FILE__ ) . '/Resources/global-registry.php' ) );

			return $client;
		}

		public function createEntity( $entity_type, $entity = array() ) {
			$command = $this->getCommand( 'CreateEntity', array(
				'entity_type' => $entity_type,
				'entity'      => array(
					$entity_type => $entity,
				)
			) );
			return $this->execute( $command );
		}

		public function updateEntity( $entity_id, $entity_type, $entity = array() ) {
			$command = $this->getCommand( 'UpdateEntity', array(
				'entity_id'   => $entity_id,
				'entity_type' => $entity_type,
				'entity'      => array(
					$entity_type => $entity,
				)
			) );
			return $this->execute( $command );
		}
	}
}
