<?php namespace GlobalTechnology\GlobalRegistry\Tests {
	use GlobalTechnology\GlobalRegistry\Client;

	class ClientFactoryTest extends \PHPUnit_Framework_TestCase {

		public function testFactoryReturnsClient() {
			$config = array(
				'base_url'     => 'http://example.com/',
				'access_token' => 'abcdefghijklmnopqrstuvwxyz0123456789',
			);

			$client = Client::factory( $config );

			$this->assertInstanceOf( '\GlobalTechnology\GlobalRegistry\Client', $client );
			$this->assertEquals( $config[ 'base_url' ], $client->getBaseUrl() );
			$this->assertEquals( "Bearer {$config['access_token']}", $client->getDefaultOption( 'headers/Authorization' ) );
		}

		/**
		 * @expectedException \Guzzle\Common\Exception\InvalidArgumentException
		 */
		public function testFactoryThrowsExceptionOnNullArgument() {
			$config = null;
			$client = Client::factory( $config );
		}

		/**
		 * @expectedException \Guzzle\Common\Exception\InvalidArgumentException
		 */
		public function testFactoryThrowsExceptionOnEmptyConfig() {
			$config = array();
			$client = Client::factory( $config );
		}

		/**
		 * @expectedException \Guzzle\Common\Exception\InvalidArgumentException
		 */
		public function testFactoryThrowsExceptionOnBlankArguments() {
			$config = array(
				'base_url'     => '',
				'access_token' => '',
			);
			$client = Client::factory( $config );
		}
	}
}
