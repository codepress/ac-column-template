<?php

declare(strict_types=1);

namespace AcColumnTemplate\Column;

use ACP\Query;
use ACP\Query\Bindings;
use ACP\Search\Comparison;
use ACP\Search\Helper\Sql\ComparisonFactory;
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
            // Operators::EQ          equal
            // Operators::NEQ         not equal
            // Operators::CONTAINS    matches part of a string
            // Operators::NOT_CONTAINS
            // Operators::GT          greater than
            // Operators::LT          less than
            // Operators::IS_EMPTY
            // Operators::NOT_IS_EMPTY
            // Operators::BETWEEN
            Operators::EQ,
            Operators::GT,
            Operators::LT,
            Operators::BETWEEN,
            Operators::IS_EMPTY,
            Operators::NOT_IS_EMPTY,
        ]);

        // Value::STRING   string
        // Value::DATE     date
        // Value::INT      whole number e.g. 5
        // Value::DECIMAL  number with decimals e.g. 5.10
        parent::__construct($operators, Value::DECIMAL);
    }

    protected function create_query_bindings(string $operator, Value $value): Bindings
    {
        $binding = new Bindings();

        /**
         * Example #1 — filter via WP_Meta_Query (simplest approach)
         * @see WP_Meta_Query
         */
        $binding->meta_query([
            'key'     => 'price',
            'value'   => $value->get_value(),
            'compare' => $operator,
            'type'    => 'DECIMAL(10,2)',
        ]);

        /**
         * Example #2 — filter via raw SQL JOIN + WHERE (use when meta_query is not flexible enough)
         *
         * @see Query\Type\Post     Injects bindings into WP_Query
         * @see Query\Type\User     Injects bindings into WP_User_Query
         * @see Query\Type\Term     Injects bindings into WP_Term_Query
         * @see Query\Type\Comment  Injects bindings into WP_Comment_Query
         */
        // global $wpdb;
        //
        // $alias = $binding->get_unique_alias('filter');
        //
        // $binding->join(
        //     "INNER JOIN $wpdb->postmeta AS $alias ON $wpdb->posts.ID = $alias.post_id
        //         AND $alias.meta_key = 'price'"
        // );
        //
        // $binding->where(
        //     ComparisonFactory::create($alias . '.meta_value', $operator, $value)->prepare()
        // );

        return $binding;
    }

}
