<?php namespace GlobalTechnology\GlobalRegistry\Model {

	class EntityCollection extends AbstractCollection {
		const JSON_ENTITIES = 'entities';
		const JSON_META     = 'meta';

		public $total;
		public $from;
		public $to;
		public $page;

		public static function fromJSON( $json = null ) {
			return new self( $json[ self::JSON_ENTITIES ], $json[ self::JSON_META ] );
		}

		public function __constructor( $entities = array(), $meta = array() ) {
			parent::__construct( array() );
			foreach ( $entities as $entity ) {
				if ( $entity instanceof Entity )
					$this->collection[ ] = $entity;
				else {
					$type                = array_keys( $entity )[ 0 ];
					$this->collection[ ] = new Entity( $type, $entity[ $type ] );
				}
			}
			foreach ( $meta as $name => $value ) {
				$this->$name = $value;
			}
		}

	}
}
