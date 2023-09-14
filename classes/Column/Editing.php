<?php

namespace AcColumnTemplate\Column;

use ACP;
use ACP\Editing\View;

/**
 * Editing class. Adds editing functionality to the column.
 */
class Editing implements ACP\Editing\Service
{

    public function get_value(int $id)
    {
        // Retrieve the value for editing. This value will be displayed in the input field.
        // For example:
        return get_post_meta($id, 'my_custom_field_key', true);
    }

    /**
     * Set the type of input field you want to use e.g. 'text', 'number', 'select' etc.
     *
     * @param string $context 'single' (for inline edit) or 'bulk' (for bulk editing)
     *
     * @return View|null
     */
    public function get_view(string $context): ?View
    {
        /**
         * Available input fields:
         * @see View\Text
         * @see View\TextArea
         * @see View\Media
         * @see View\Email
         * @see View\Number
         * @see View\Image
         * @see View\Date
         * @see View\DateTime
         * @see View\Select
         * @see View\Color
         * @see View\AjaxSelect
         * @see View\Taxonomy
         * @see View\Url
         * @see View\Toggle
         * @see View\Wysiwyg
         * @see View\Video
         * @see View\Audio
         */
        $view = new View\Text();

        // Example of a dropdown select:
        // $view = new View\Select([1 => 'Option #1', 2 => 'Option #2']);

        // (Optional) use View specific modifiers
        //$view->set_clear_button( true );
        //$view->set_placeholder( 'Custom placeholder' );
        //$view->set_required( true );

        // (Optional) return a different view or disable editing based on context: 'bulk' or 'single' (index)
        // return $context === 'bulk' ? $view : null;

        return $view;
    }

    /**
     * Saves the value after using inline or bulk-edit
     *
     * @param int   $id   Object ID
     * @param mixed $data Value to be saved
     */
    public function update(int $id, $data): void
    {
        // Store the value that has been entered with inline or bulk-edit
        // For example:
        update_post_meta($id, 'my_custom_field_key', $data);
    }

}