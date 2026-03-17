<?php

declare(strict_types=1);

namespace AcColumnTemplate\Column;

use ACP\Query\Bindings;
use ACP\Sorting\Model\QueryBindings;
use ACP\Sorting\Model\SqlOrderByFactory;
use ACP\Sorting\Type\Order;

/**
 * Sorting model. Adds sorting functionality to the column.
 */
class Sorting implements QueryBindings
{

    public function create_query_bindings(Order $order): Bindings
    {
        global $wpdb;

        $bindings = new Bindings();

        $bindings->join(
            "LEFT JOIN $wpdb->postmeta AS ac_sort ON $wpdb->posts.ID = ac_sort.post_id
                AND ac_sort.meta_key = 'price'"
        );

        // SqlOrderByFactory pushes empty values to the bottom regardless of sort direction.
        // Use a raw "$column $order" string instead if you want standard ASC/DESC behavior.
        $bindings->order_by(
            SqlOrderByFactory::create('ac_sort.meta_value', (string)$order)
        );

        // (Optional) GROUP BY to deduplicate rows when the JOIN can produce multiples.
        // $bindings->group_by("$wpdb->posts.ID");

        /**
         * The created Query Bindings will be parsed into SQL by one of these services:
         * @see ACP\Query\Type\Post     Injects bindings into WP_Query
         * @see ACP\Query\Type\User     Injects bindings into WP_User_Query
         * @see ACP\Query\Type\Term     Injects bindings into WP_Term_Query
         * @see ACP\Query\Type\Comment  Injects bindings into WP_Comment_Query
         */
        return $bindings;
    }

}
