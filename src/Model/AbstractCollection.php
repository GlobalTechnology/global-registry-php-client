<?php namespace GlobalTechnology\GlobalRegistry\Model {
	use Guzzle\Service\Command\ResponseClassInterface;
	use Guzzle\Service\Command\OperationCommand;

	abstract class AbstractCollection implements ResponseClassInterface, \IteratorAggregate, \ArrayAccess, \Countable {

		protected $collection = array();

		abstract public static function fromJSON( $json = null );

		public static function fromCommand( OperationCommand $command ) {
			self::fromJSON( $command->getResponse()->json() );
		}

		public function getIterator() {
			return new \ArrayIterator( $this->items );
		}

		protected function __construct( $collection = array() ) {
			$this->collection = $collection;
		}

		public function offsetSet( $offset, $value ) {
			if ( is_null( $offset ) )
				$this->collection[ ] = $value;
			else
				$this->collection[ $offset ] = $value;
		}

		public function offsetExists( $offset ) {
			return isset( $this->collection[ $offset ] );
		}

		public function offsetUnset( $offset ) {
			unset( $this->collection[ $offset ] );
		}

		public function offsetGet( $offset ) {
			return isset( $this->collection[ $offset ] ) ? $this->collection[ $offset ] : null;
		}

		public function count() {
			return count( $this->collection );
		}
	}
}
