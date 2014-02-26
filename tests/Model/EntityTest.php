<?php namespace GlobalTechnology\GlobalRegistry\Tests\Model {

	use GlobalTechnology\GlobalRegistry\Model\Entity;

	class EntityTest extends \PHPUnit_Framework_TestCase {

		/**
		 * @param $type
		 * @param $data
		 *
		 * @dataProvider provideEntityParams
		 */
		public function testEntity( $type, $data ) {
			$entity = new Entity( $type, $data );

			$this->assertEquals( $type, $entity->type );
			foreach ( $data as $name => $value ) {
				$this->assertEquals( $value, $entity->$name );
			}
		}

		public function provideEntityParams() {
			return array(
				array( 'type', array( array( 'name' => 'value' ) ) ),
			);
		}
	}
}
