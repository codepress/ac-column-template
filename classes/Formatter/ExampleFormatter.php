<?php

declare(strict_types=1);

namespace AcColumnTemplate\Formatter;

use AC;
use AC\Type\Value;

class ExampleFormatter implements AC\Setting\Formatter
{

    public function format(Value $value)
    {
        $post_id = $value->get_id();
        $meta_value = get_post_meta($post_id, 'my_custom_field_key', true);

        return $value->with_value("<a href='" . get_edit_post_link($value->get_id()) . "'>$meta_value</a>");
    }

}