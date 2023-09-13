<?php

namespace AcColumnTemplate\Column;

use ACP\Query;
use ACP\Query\Bindings;
use ACP\Search\Comparison;
use ACP\Search\Operators;
use ACP\Search\Value;

/**
 * Search class. Adds smart filtering functionality to the column.
 */
class Search extends Comparison
{

    public function __construct()
    {
        $operators = new Operators([

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
            Operators::EQ,
        ]);

        // Available value types:
        // Value::STRING = Value is a string
        // Value::DATE = Value is a date
        // Value::INT = Value is a whole number e.g. `5`
        // Value::DECIMAL = Value is a number with decimals e.g. `5.1`
        $value = Value::STRING;

        parent::__construct($operators, $value);
    }

    /**
     * The created Query Bindings will be parsed into SQL by these services:
     * @see \ACP\Query\Post     This service injects the SQL bindings into `WP_Query`
     * @see \ACP\Query\User     This service injects the SQL bindings into `WP_User_Query`
     * @see \ACP\Query\Term     This service injects the SQL bindings into `WP_Term_Query`
     * @see \ACP\Query\Comment  This service injects the SQL bindings into `WP_Comment_Query`
     */
    protected function create_query_bindings(string $operator, Value $value): Bindings
    {
        /**
         * @see Bindings This object holds the SQL statements e.g. 'join, where, order by, group by' and the 'meta_query'
         */
        $binding = new Bindings();

        /**
         * Example #1 - altering the WP_Meta_Query
         * @see WP_Meta_Query
         */
        $binding->meta_query([
            'key'     => 'my_custom_field_key',
            'value'   => $value->get_value(),
            'compare' => $operator,
        ]);

        /**
         * Example #2 - altering the query with custom SQL
         * @see Query\Post This service handler parses the SQL bindings into `WP_Query`
         * @see WP_Query::get_posts This object runs the SQL query
         */
        global $wpdb;

        // 1. You can 'JOIN' tables together like so:
        $binding->join(
            "INNER JOIN $wpdb->postmeta AS ac_filter ON $wpdb->posts.ID = ac_filter.post_id 
                AND ac_filter.meta_key = 'my_custom_field_key'"
        );

        // 2. Set the 'WHERE' statement
        $binding->where(
            $wpdb->prepare(
                "ac_filter.meta_value = %s",
                $value->get_value()
            )
        );

        return $binding;
    }

}