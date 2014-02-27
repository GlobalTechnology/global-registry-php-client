<?php namespace GlobalTechnology\GlobalRegistry\Tests\Endpoint {
	use Guzzle\Tests\GuzzleTestCase;

	class EntitiesTest extends GuzzleTestCase {

		/**
		 * @var \GlobalTechnology\GlobalRegistry\Client
		 */
		protected static $client;

		public static function setUpBeforeClass() {
			self::$client = self::getServiceBuilder()->get( 'globalregistry' );
		}

		public static function tearDownAfterClass() {
			self::$client = null;
		}

		/**
		 * @expectedException \Guzzle\Service\Exception\ValidationException
		 * @dataProvider getEntityInvalidParameterDataProvider
		 */
		public function testGetEntityInvalidParameter( $id ) {
			self::$client->getEntity( $id );
		}

		/**
		 * @dataProvider getEntityOKDataProvider
		 */
		public function testGetEntityOK( $id, $type, $mock ) {
			$this->setMockResponse( self::$client, $mock );
			$entity = self::$client->getEntity( $id );

			$this->assertInstanceOf( '\GlobalTechnology\GlobalRegistry\Model\Entity', $entity );
			$this->assertEquals( $id, $entity->id );
			$this->assertEquals( $type, $entity->type );
		}

		/**
		 * @expectedException \Guzzle\Http\Exception\ClientErrorResponseException
		 * @dataProvider getEntityBadRequestDataProvider
		 */
		public function testGetEntityBadRequest( $id, $mock ) {
			$this->setMockResponse( self::$client, $mock );
			self::$client->getEntity( $id );
		}

		public function getEntityInvalidParameterDataProvider() {
			/* array( $id, $type ) */
			return array(
				array( null ),
				array( 'abc' ),
				array( array() ),
			);
		}

		public function getEntityOKDataProvider() {
			/* array( $id, $type, $mock ) */
			return array(
				array( 1234567, 'person', 'entities/200-getEntity-1234567-person.http' ),
				array( 1324354, 'team', 'entities/200-getEntity-1324354-team.http' ),
			);
		}

		public function getEntityBadRequestDataProvider() {
			/* array( $id, $mock ) */
			return array(
				array( 11111111, 'entities/400-getEntity.http' ),
				array( 22222222, 'entities/200-getEntity-null.http' ),
			);
		}
	}
}
