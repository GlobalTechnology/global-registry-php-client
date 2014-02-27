<?php namespace GlobalTechnology\GlobalRegistry\Model {
	use Guzzle\Service\Command\ResponseClassInterface;
	use Guzzle\Service\Command\OperationCommand;

	abstract class AbstractCollection implements ResponseClassInterface, \IteratorAggregate, \Countable {

		protected $collection = array();

		abstract public static function fromJSON( $json = null );

		public static function fromCommand( OperationCommand $command ) {
			$class = get_called_class();
			return $class::fromJSON( $command->getResponse()->json() );
		}

		public function getIterator() {
			return new \ArrayIterator( $this->collection );
		}

		protected function __construct( $collection = array() ) {
			$this->collection = $collection;
		}

		public function count() {
			return count( $this->collection );
		}
	}
}
