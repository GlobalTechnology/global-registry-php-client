<?php namespace GTO\GlobalRegistry {
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

			$description = ServiceDescription::factory( dirname( __FILE__ ) . "/../client.json" );
			$client->setDescription( $description );

			$client->setDefaultOption( 'headers/Authorization', "Bearer {$config['access_token']}" );

			return $client;
		}


		public function getEntityTypes() {
			$command = $this->getCommand( 'GetEntityTypes' );
			return $this->execute( $command );
		}

		public function getEntities( $entityType, $filters = array() ) {
			$command   = $this->getCommand( 'GetEntities', array(
				'entity_type' => $entityType,
				'filters'     => $filters,
			) );
			$operation = $command->getOperation();
			echo "URI: {$operation->getUri()}\n";
			return $this->execute( $command );
		}
	}
}
