<?php

namespace AcColumnTemplate\Column;

use ACP\Query\Bindings;
use ACP\Sorting\AbstractModel;
use ACP\Sorting\Model\QueryBindings;
use ACP\Sorting\Model\SqlOrderByFactory;
use ACP\Sorting\Type\Order;

/**
 * Sorting model. Adds sorting functionality to the column.
 */
class Sorting extends AbstractModel implements QueryBindings
{

    /**
     * The created Query Bindings will be parsed into SQL by these services:
     * @see \ACP\Query\Post     This service injects the SQL bindings into `WP_Query`
     * @see \ACP\Query\User     This service injects the SQL bindings into `WP_User_Query`
     * @see \ACP\Query\Term     This service injects the SQL bindings into `WP_Term_Query`
     * @see \ACP\Query\Comment  This service injects the SQL bindings into `WP_Comment_Query`
     */
    public function create_query_bindings(Order $order): Bindings
    {
        global $wpdb;

        /**
         * @see Bindings This object holds the SQL statements e.g. 'join, where, order by, group by'
         */
        $bindings = new Bindings();

        // 1. You can 'JOIN' tables together like so:
        $bindings->join(
            "LEFT JOIN $wpdb->postmeta AS ac_sort ON $wpdb->posts.ID = ac_sort.post_id
                AND ac_sort.meta_key = 'my_custom_field_key'"
        );

        // 2. Set the 'ORDER BY' statement:
        $bindings->order_by(
            "ac_sort.meta_value " . $order
        );

        // 2. Optionally: if you want your empty results at the bottom, you can
        // use this factory which will create the correct 'ORDER BY' statement for you
        $bindings->order_by(
            SqlOrderByFactory::create("ac_sort.meta_value", $order)
        );

        // 3. Optionally: set the 'GROUP BY' to groups the results
        $bindings->group_by(
            "$wpdb->posts.ID"
        );

        return $bindings;
    }

}