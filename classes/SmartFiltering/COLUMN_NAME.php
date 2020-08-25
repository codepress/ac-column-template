<?php

namespace CUSTOM_NAMESPACE\SmartFiltering;

class COLUMN_NAME extends \ACP\Search\Comparison {

	public function __construct() {
		$operators = new \ACP\Search\Operators( [

			// Available operators:
			// Operators::EQ = equal
			// Operators::NEQ = not Equal
			// Operators::CONTAINS = Matches a part of a string
			// Operators::NOT_CONTAINS
			// Operators::GT = Greater than
			// Operators::LT = Less than
			// Operators::IS_EMPTY
			// Operators::NOT_IS_EMPTY
			// Operators::BETWEEN
			\ACP\Search\Operators::EQ,
		] );

		// Available value types:
		// Value::STRING = Value is a string
		// Value::DATE = Value is a date
		// Value::INT = Value is a whole number e.g. `5`
		// Value::DECIMAL = Value is a number with decimals e.g. `5.1`
		$value = \ACP\Search\Value::STRING;

		parent::__construct( $operators, $value );
	}

	protected function create_query_bindings( $operator, \ACP\Search\Value $value ) {
		$binding = new \ACP\Search\Query\Bindings\Post();

		// Examples:

		// Example #1 - altering the \WP_Meta_Query
		$binding->meta_query( [
			'key'     => 'custom_meta_key',
			'value'   => $value->get_value(),
			'compare' => $operator,
		] );

		// Example #2 - altering the query with custom SQL
		global $wpdb;
		$binding->join( " INNER JOIN {$wpdb->postmeta} AS my_postmeta ON {$wpdb->posts}.ID = my_postmeta.post_id" );
		$binding->where( $wpdb->prepare( " AND my_postmeta.meta_key = 'custom_meta_key' AND my_postmeta.meta_value = %s", $value->get_value() ) );

		return $binding;
	}

}