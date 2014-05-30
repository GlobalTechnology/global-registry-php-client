<?php namespace GlobalTechnology\GlobalRegistry\Model {
	use Guzzle\Service\Command\ResponseClassInterface;
	use Guzzle\Service\Command\OperationCommand;

	abstract class AbstractCollection implements ResponseClassInterface, \IteratorAggregate, \Countable {
		const JSON_META         = 'meta';

		protected $data;
		/**
		 * @var OperationCommand
		 */
		protected $command = null;

		public $total;
		public $from;
		public $to;
		public $page;
		public $total_pages;

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

		protected function __construct( array $data = array(), array $meta = array() ) {
			$this->data = $data;
			foreach ( $meta as $name => $value ) {
				$this->$name = $value;
			}
		}

		public function count() {
			return count( $this->data );
		}
	}
}
