<?php namespace GlobalTechnology\GlobalRegistry\Model {

	class EntityCollection extends AbstractCollection {
		const JSON_ENTITIES = 'entities';
		const JSON_META     = 'meta';

		public $total;
		public $from;
		public $to;
		public $page;

		public static function fromJSON( $json = null ) {
			$data     = $json[ self::JSON_ENTITIES ];
			$entities = array();
			foreach ( $data as $entity ) {
				$type        = array_keys( $entity )[ 0 ];
				$entities[ ] = new Entity( $type, $entity[ $type ] );
			}
			return new self( $entities, $json[ self::JSON_META ] );
		}

		public function __constructor( $entities = array(), $meta = array() ) {
			parent::__construct( $entities );
			foreach ( $meta as $name => $value ) {
				$this->$name = $value;
			}
		}

	}
}
