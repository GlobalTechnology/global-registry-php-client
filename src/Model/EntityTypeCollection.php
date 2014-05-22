<?php namespace GlobalTechnology\GlobalRegistry\Model {

	class EntityTypeCollection extends AbstractCollection {
		const JSON_ENTITY_TYPES = 'entity_types';
		const JSON_META         = 'meta';

		public $total;
		public $from;
		public $to;
		public $page;
		public $total_pages;

		public static function fromJSON( array $json = null ) {
			return new EntityTypeCollection( $json[ self::JSON_ENTITY_TYPES ], $json[ self::JSON_META ] );
		}

		public function __construct( $entityTypes = array(), $meta = array() ) {
			parent::__construct( array() );
			foreach ( $entityTypes as $entityType ) {
				// Add entityType to the collection if its already a Model
				if ( $entityType instanceof EntityType )
					$this->data[ ] = $entityType;
				else
					$this->data[ ] = new EntityType( $entityType );
			}
			foreach ( $meta as $name => $value ) {
				$this->$name = $value;
			}
		}

	}
}
