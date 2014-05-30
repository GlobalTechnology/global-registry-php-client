<?php namespace GlobalTechnology\GlobalRegistry\Model {

	class EntityCollection extends AbstractCollection {
		const JSON_ENTITIES = 'entities';

		public static function fromJSON( array $json = null ) {
			return new self( $json[ self::JSON_ENTITIES ], $json[ self::JSON_META ] );
		}

		public function __construct( $entities = array(), $meta = array() ) {
			parent::__construct( array(), $meta );
			foreach ( $entities as $entity ) {
				if ( $entity instanceof Entity )
					$this->data[ ] = $entity;
				else {
					$type          = array_keys( $entity )[ 0 ];
					$this->data[ ] = new Entity( $type, $entity[ $type ] );
				}
			}
		}
	}
}
