<?php

namespace AcColumnTemplate\Column;

use ACP;

/**
 * Editing class. Adds editing functionality to the column.
 */
class Export implements ACP\Export\Service
{

    public function get_value($id): string
    {
        // retrieve the value manually and format if necessary
        return strip_tags(get_post_meta($id, 'my_custom_field_key', true));
    }

}