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
        // Retrieve the value for editing
        // For example:
        return get_post_meta($id, 'my_custom_field_key', true);
    }

    public function get_view(string $context): ?View
    {
        /**
         * Available views:
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

        // (Optional) use View specific modifiers
        //$view->set_clear_button( true );
        //$view->set_placeholder( 'Custom placeholder' );
        //$view->set_required( true );

        // (Optional) return a different view or disable editing based on context: bulk or single (index)
        // $context === Service::CONTEXT_BULK

        return $view;
    }

    /**
     * Saves the value after using inline-edit
     *
     * @param int   $id   Object ID
     * @param mixed $data Value to be saved
     */
    public function update(int $id, $data): void
    {
        // Store the value that has been entered with inline-edit
        // For example:
        update_post_meta($id, 'my_custom_field_key', $data);
    }

}