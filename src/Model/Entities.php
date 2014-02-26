<?php namespace GlobalTechnology\GlobalRegistry\Model {
	use Guzzle\Service\Command\ResponseClassInterface;
	use Guzzle\Service\Command\OperationCommand;

	class Entities implements ResponseClassInterface, \IteratorAggregate, \ArrayAccess, \Countable {
		const JSON_ENTITIES = 'entities';
		const JSON_META     = 'meta';

		public $entities;
		public $total;
		public $from;
		public $to;
		public $page;

		public static function fromCommand( OperationCommand $command ) {
			$json     = $command->getResponse()->json();
			$data     = $json[ self::JSON_ENTITIES ];
			$entities = array();
			foreach ( $data as $entity ) {
				$type        = array_keys( $entity )[ 0 ];
				$entities[ ] = new Entity( $type, $entity[ $type ] );
			}
			return new self( $entities, $json[ self::JSON_META ] );
		}

		public function getIterator() {
			return new \ArrayIterator( $this->entities );
		}

		public function __constructor( $entities = array(), $meta = array() ) {
			$this->entities = $entities;
			foreach ( $meta as $name => $value ) {
				$this->$name = $value;
			}
		}

		public function offsetSet( $offset, $value ) {
			if ( is_null( $offset ) )
				$this->entities[ ] = $value;
			else
				$this->entities[ $offset ] = $value;
		}

		public function offsetExists( $offset ) {
			return isset( $this->entities[ $offset ] );
		}

		public function offsetUnset( $offset ) {
			unset( $this->entities[ $offset ] );
		}

		public function offsetGet( $offset ) {
			return isset( $this->entities[ $offset ] ) ? $this->entities[ $offset ] : null;
		}

		public function count() {
			return count( $this->entities );
		}
	}
}
