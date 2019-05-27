<?php
namespace AC\COLUMN_NAME;

class SmartFiltering extends \ACP\Search\Comparison {

	public function __construct() {
		$operators = new \ACP\Search\Operators( array(
			\ACP\Search\Operators::EQ, // EQ = equal, NEW = not Equal, CONTAINS, NOT_CONTAINS, GT = Greater than, LT = Less than, IS_EMPTY, NOT_IS_EMPTY, BETWEEN
		) );

		$value = \ACP\Search\Value::STRING; // DATE, INT, DECIMAL

		parent::__construct( $operators, $value );
	}

	protected function create_query_bindings( $operator, \ACP\Search\Value $value ) {
		$binding = new \ACP\Search\Query\Bindings\Post();

		// Example altering the meta_query
		$binding->meta_query( array(
			'key'     => 'text',
			'value'   => $value->get_value(),
			'compare' => $operator,
		) );

		// Example for altering the where clause
		$binding->where( '1=1' );

		return $binding;
	}

}