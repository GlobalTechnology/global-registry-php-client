<?php namespace GlobalTechnology\GlobalRegistry\Model {

	class RelationshipCollection implements \IteratorAggregate, \ArrayAccess, \Countable, \JsonSerializable {

		/**
		 * @type string
		 */
		protected $type;

		/**
		 * @var array
		 */
		protected $data;

		public function __construct( array $data = array(), $type = null ) {
			$this->data = array();

			if ( ! empty( $data ) ) {

				// Wrap relationship in array if only single
				if ( ! $this->isArrayOfArrays( $data ) )
					$data = array( $data );

				foreach ( $data as $relationship ) {
					$this->data[] = new Relationship( $type, $relationship );
				}
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
			if ( is_null( $offset ) ) {
				$this->data[] = $value;
			}
			else {
				$this->data[ $offset ] = $value;
			}
		}

		public function offsetUnset( $offset ) {
			unset( $this->data[ $offset ] );
		}

		public function jsonSerialize() {
			return ( count( $this ) <= 0 ) ? array() : $this->data;
		}

		private function isArrayOfArrays( array $array ) {
			foreach ( array_values( $array ) as $value ) {
				if ( ! is_array( $value ) ) return false;
			}
			return true;
		}

	}
}
