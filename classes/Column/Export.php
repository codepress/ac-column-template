<?php

declare(strict_types=1);

namespace AcColumnTemplate\Column;

use AC\Exception\ValueNotFoundException;
use AC\Formatter;
use AC\Type\Value;

/**
 * Export formatter. Returns a plain-text value suitable for CSV export.
 * For display formatting (with HTML), see ExampleFormatter.
 */
class Export implements Formatter
{

    public function format(Value $value): Value
    {
        $post_id = (int)$value->get_id();

        $price = get_post_meta($post_id, 'price', true);

        // Throw when there is nothing to export — the cell is left empty.
        if ('' === $price || false === $price) {
            throw ValueNotFoundException::from_id($value->get_id());
        }

        // Plain text — no HTML, no links. Export targets CSV, not the browser.
        return $value->with_value('$' . number_format((float)$price, 2));
    }

}
