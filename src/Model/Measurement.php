<?php namespace GlobalTechnology\GlobalRegistry\Model {
	class Measurement {
		public $id;
		public $period;
		public $value;
		public $related_entity_id;

		public function __construct( $data ) {
			foreach ( $data as $name => $value ) {
				switch ( $name ) {
					case "id":
					case "period":
					case "value":
					case "related_entity_id":
						$this->$name = $value;
						break;
				}
			}
		}
	}
}
