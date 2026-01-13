<?php

namespace AcColumnTemplate\Column;

use AC\Setting\Formatter;
use AC\Type\Value;

/**
 * Export class. Adds export functionality to the column.
 */
class Export implements Formatter
{

    public function format(Value $value)
    {
        // Post ID
        $id = $value->get_id();

        // retrieve the value...
        $meta_value = get_post_meta($id, 'my_custom_field_key', true);

        // ...and format if necessary
        $meta_value = strip_tags($meta_value);

        // return the formatted value within the Value object
        return $value->with_value(
            $meta_value
        );
    }

}