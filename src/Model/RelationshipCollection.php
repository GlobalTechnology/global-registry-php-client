<?php namespace GlobalTechnology\GlobalRegistry\Model {

	class RelationshipCollection implements \IteratorAggregate, \ArrayAccess, \Countable, \JsonSerializable {

		/**
		 * @var array
		 */
		protected $data;

		public function __construct( array $data = array() ) {
			$this->data = array();

			// Wrap relationship in array if only single
			if ( array_key_exists( Relationship::RELATIONSHIP_ENTITY_ID, $data ) )
				$data = array( $data );

			foreach ( $data as $relationship ) {
				$this->data[ ] = new Relationship( $relationship );
			}
		}

		public function count() {
			return count( $this->data );
		}

		public function getIterator() {
			return new \ArrayIterator( $this->data );
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

		public function jsonSerialize() {
			return ( count( $this ) <= 0 ) ? array() : $this->data;
		}

	}
}
