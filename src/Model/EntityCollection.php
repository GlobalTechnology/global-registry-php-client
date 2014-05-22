<?php namespace GlobalTechnology\GlobalRegistry\Model {

	class EntityCollection extends AbstractCollection {
		const JSON_ENTITIES = 'entities';
		const JSON_META     = 'meta';

		public $total;
		public $from;
		public $to;
		public $page;
		public $total_pages;

		public static function fromJSON( array $json = null ) {
			return new self( $json[ self::JSON_ENTITIES ], $json[ self::JSON_META ] );
		}

		public function __construct( $entities = array(), $meta = array() ) {
			parent::__construct( array() );
			foreach ( $entities as $entity ) {
				if ( $entity instanceof Entity )
					$this->data[ ] = $entity;
				else {
					$type                = array_keys( $entity )[ 0 ];
					$this->data[ ] = new Entity( $type, $entity[ $type ] );
				}
			}
			foreach ( $meta as $name => $value ) {
				$this->$name = $value;
			}
		}

		public function hasMore() {
			return ( $this->page && $this->total_pages && $this->page < $this->total_pages );
		}

		/**
		 * @return \GlobalTechnology\GlobalRegistry\Model\EntityCollection|null
		 */
		public function nextPage() {
			return $this->hasMore() ?
				$this->command->getClient()->getEntities(
					$this->command->get( 'entity_type' ),
					$this->command->get( 'filters' ),
					$this->page + 1,
					$this->command->get( 'per_page' )
				) : null;
		}
	}
}
