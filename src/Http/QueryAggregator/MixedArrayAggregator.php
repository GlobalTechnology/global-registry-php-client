<?php namespace GlobalTechnology\GlobalRegistry\Http\QueryAggregator {

	use Guzzle\Http\QueryAggregator\QueryAggregatorInterface;
	use Guzzle\Http\QueryString;

	/**
	 * Class MixedArrayAggregator
	 *
	 * Encodes associative arrays as field[key]=value and
	 * numeric arrays as field[]=value
	 *
	 * @package GlobalTechnology\GlobalRegistry\Http\QueryAggregator
	 */
	class MixedArrayAggregator implements QueryAggregatorInterface {
		public function aggregate( $key, $value, QueryString $query ) {
			$ret = array();
			foreach ( $value as $k => $v ) {
				if ( is_array( $v ) && array_values( $v ) === $v ) {
					$ret[ $query->encodeValue( "{$key}[{$k}][]" ) ] = array_map(array($query, 'encodeValue'), $v);
				}
				elseif ( is_array( $v ) ) {
					$ret = array_merge( $ret, self::aggregate( "{$key}[{$k}]", $v, $query ) );
				}
				else {
					$ret[ $query->encodeValue( "{$key}[{$k}]" ) ] = $query->encodeValue( $v );
				}
			}

			return $ret;
		}
	}
}
