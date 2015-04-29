<?php namespace GlobalTechnology\GlobalRegistry\Model {
	class Measurement {
		public $id;
		public $period;
		public $value;
		public $related_entity_id;
		public $dimension;

		public function __construct( $data ) {
			foreach ( $data as $name => $value ) {
				switch ( $name ) {
					case "id":
					case "period":
					case "value":
					case "related_entity_id":
					case "dimension":
						$this->$name = $value;
						break;
				}
			}
		}
	}
}
