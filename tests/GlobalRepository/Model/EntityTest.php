<?php namespace GlobalTechnology\GlobalRegistry\Tests\Model {

	use GlobalTechnology\GlobalRegistry\Model\Entity;

	class EntityTest extends \PHPUnit_Framework_TestCase {

		public function testEntityFromArray() {
			$type = 'entity';
			$data = array(
				'id'      => 1234567,
				'attr1'   => 'One',
				'attr2'   => 2,
				'subAttr' => array(
					'id'         => 1234568,
					'subAttr1'   => 'One',
					'subAttr2'   => 'Two',
					'subSubAttr' => array(
						'id'          => 1234569,
						'subSubAttr1' => 'One',
					),
				),
			);

			$entity = new Entity( $type, $data );

			$this->assertInstanceOf( '\GlobalTechnology\GlobalRegistry\Model\Entity', $entity );
			$this->assertEquals( $type, $entity->type );
			$this->assertEquals( 1234567, $entity->id );
			$this->assertEquals( 'One', $entity->attr1 );
			$this->assertEquals( 2, $entity->attr2 );
			$this->assertInstanceOf( '\GlobalTechnology\GlobalRegistry\Model\Entity', $entity->subAttr );
			$this->assertEquals( 'subAttr', $entity->subAttr->type );
			$this->assertEquals( 1234568, $entity->subAttr->id );
			$this->assertEquals( 'One', $entity->subAttr->subAttr1 );
			$this->assertEquals( 'Two', $entity->subAttr->subAttr2 );
			$this->assertInstanceOf( '\GlobalTechnology\GlobalRegistry\Model\Entity', $entity->subAttr->subSubAttr );
			$this->assertEquals( 'subSubAttr', $entity->subAttr->subSubAttr->type );
			$this->assertEquals( 1234569, $entity->subAttr->subSubAttr->id );
			$this->assertEquals( 'One', $entity->subAttr->subSubAttr->subSubAttr1 );
		}
	}
}
