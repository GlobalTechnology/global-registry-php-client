<?php namespace GlobalTechnology\GlobalRegistry\Model {
	use Guzzle\Service\Command\ResponseClassInterface;
	use Guzzle\Service\Command\OperationCommand;

	abstract class AbstractCollection implements ResponseClassInterface, \IteratorAggregate, \Countable {

		protected $data;
		/**
		 * @var OperationCommand
		 */
		protected $command = null;

		abstract public static function fromJSON( array $json = null );

		/**
		 * @param OperationCommand $command
		 *
		 * @return AbstractCollection
		 */
		public static function fromCommand( OperationCommand $command ) {
			$class  = get_called_class();
			$response = $class::fromJSON( $command->getResponse()->json() );
			$response->command = $command;
			return $response;
		}

		/**
		 * @return \ArrayIterator|\Traversable
		 */
		public function getIterator() {
			return new \ArrayIterator( $this->data );
		}

		protected function __construct( array $data = array() ) {
			$this->data = $data;
		}

		public function count() {
			return count( $this->data );
		}
	}
}
