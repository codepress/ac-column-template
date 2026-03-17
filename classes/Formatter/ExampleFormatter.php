<?php

declare(strict_types=1);

namespace AcColumnTemplate\Formatter;

use AC;
use AC\Exception\ValueNotFoundException;
use AC\Type\Value;

class ExampleFormatter implements AC\Formatter
{

    public function format(Value $value): Value
    {
        $post_id = (int)$value->get_id();

        $price = get_post_meta($post_id, 'price', true);

        // Throw when there is nothing to display — the column renders an empty cell.
        if ('' === $price || false === $price) {
            throw ValueNotFoundException::from_id($value->get_id());
        }

        $formatted = '$' . number_format((float) $price, 2);

        $edit_link = get_edit_post_link($post_id);

        // get_edit_post_link() returns null when the current user lacks permission.
        if ($edit_link) {
            return $value->with_value(
                sprintf('<a href="%s">%s</a>', esc_url($edit_link), esc_html($formatted))
            );
        }

        return $value->with_value(esc_html($formatted));
    }

}
