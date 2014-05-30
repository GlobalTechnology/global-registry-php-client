<?php namespace GlobalTechnology\GlobalRegistry\Model {
	use Guzzle\Service\Command\OperationCommand;
	use Guzzle\Service\Command\ResponseClassInterface;

	abstract class AbstractCollection implements ResponseClassInterface, \IteratorAggregate, \ArrayAccess, \Countable {
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

		public function hasMore() {
			return ( $this->page && $this->total_pages && $this->page < $this->total_pages );
		}

		/**
		 * @return \GlobalTechnology\GlobalRegistry\Model\AbstractCollection|null
		 */
		public function nextPage() {
			if ( ! is_null( $this->command ) && $this->hasMore() ) {
				// build & execute a new command
				$args           = $this->command->getAll();
				$args[ 'page' ] = $this->page + 1;
				return $this->command->getClient()->getCommand( $this->command->getName(), $args )->execute();
			}

			return null;
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

		public function offsetExists( $offset ) {
			return isset( $this->data[ $offset ] );
		}

		public function offsetGet( $offset ) {
			return isset( $this->data[ $offset ] ) ? $this->data[ $offset ] : null;
		}

		public function offsetSet( $offset, $value ) {
			$this->data[ $offset ] = $value;
		}

		public function offsetUnset( $offset ) {
			unset( $this->data[ $offset ] );
		}
	}
}
