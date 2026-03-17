<?php

declare(strict_types=1);

namespace AcColumnTemplate\Column;

use ACP;
use ACP\Editing\View;

/**
 * Editing class. Adds inline and bulk editing to the column.
 */
class Editing implements ACP\Editing\Service
{

    public function get_value(int $id)
    {
        return get_post_meta($id, 'price', true);
    }

    /**
     * @param string $context 'single' (inline edit) or 'bulk' (bulk edit)
     */
    public function get_view(string $context): ?View
    {
        /**
         * Available input types:
         * @see View\Text
         * @see View\TextArea
         * @see View\Number
         * @see View\Image
         * @see View\Url
         * @see View\Email
         * @see View\Wysiwyg
         * @see View\Select
         * @see View\Toggle
         * @see View\Media
         * @see View\Password
         * @see View\Taxonomy
         * @see View\Color
         * @see View\Date
         * @see View\DateTime
         * @see View\CheckboxList
         * @see View\ComputedNumber
         * @see View\AjaxSelect
         * @see View\Audio
         * @see View\Video
         */
        return new View\Number();

        // Example of a dropdown select:
        // return new View\Select([1 => 'Option #1', 2 => 'Option #2']);

        // (Optional) return a different view or disable editing based on context:
        // return $context === 'bulk' ? new View\Number() : null;
    }

    public function update(int $id, $data): void
    {
        $price = filter_var($data, FILTER_VALIDATE_FLOAT);

        if (false === $price) {
            delete_post_meta($id, 'price');

            return;
        }

        update_post_meta($id, 'price', $price);
    }

}
