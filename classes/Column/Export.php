<?php

namespace AcColumnTemplate\Column;

use ACP\Export\Service;

/**
 * Export class. Adds export functionality to the column.
 */
class Export implements Service
{

    public function get_value($id)
    {
        // Return the value you would like to be exported
        // For example:
        $value = get_post_meta($id, 'my_custom_field_key', true);

        return $value;
    }

}