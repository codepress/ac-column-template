<?php

namespace AcColumnTemplate\Column;

use AC;
use ACP;

// In this example we extend the free version, but if you only want a pro version, there is no need to write a separate free column
class Column extends AC\Column
    implements ACP\Editing\Editable, ACP\Sorting\Sortable, ACP\Export\Exportable, ACP\Search\Searchable
{

    public function __construct()
    {
        // Identifier, pick a unique name. Single word, no spaces. Underscores allowed.
        $this->set_type('ac-COLUMN_NAME');

        // Default column label.
        $this->set_label(__('COLUMN_LABEL', 'ac-column-template'));
    }

    /**
     * Returns the display value for the column.
     */
    public function get_value($id): string
    {
        // put all the column logic here to retrieve the value you need
        // For example:
        $value = get_post_meta($id, 'my_custom_field_key', true) ?: '-';

        // Optionally you can change the display of the value. In this example we added an edit post link.
        $value = sprintf(
            '<a href="%s">%s</a>',
            esc_url(get_edit_post_link($id)),
            $value
        );

        return $value;
    }

    /*
     * (Optional) Enqueue CSS + JavaScript on the admin listings screen. You can remove this function is you do not use it!
     *
     * This action is called in the admin_head action on the listings screen where your column values are displayed.
     * Use this action to add CSS + JavaScript
     */
    public function editing()
    {
        return new Editing();
    }

    public function sorting()
    {
        // Example #1 - Write your own sorting query
        return new Sorting();

        // The following examples are pre-configured and are shipped with Admin Columns Pro

        /**
         * Example #2 - Sorting by custom field values on the posts table
         * @see ACP\Sorting\Model\Post\Meta
         */
        // return new ACP\Sorting\Model\Post\Meta('my_custom_field_key');

        /**
         * Example #3 - Sorting by numeric custom field values on the users table
         * @see ACP\Sorting\Model\User\Meta
         */
        // return new ACP\Sorting\Model\User\Meta( 'my_custom_field_key', new ACP\Sorting\Type\DataType( 'numeric' ) );

        /**
         * Example #4 - Sorting by custom field values on the posts table with custom formatting applied.
         * In this example we want to sort by the Post `Title`, not the Post `ID` that is stored within the custom field.
         * We will convert each Post `ID` to a Post `Title` before we apply sorting.
         * @see ACP\Sorting\Model\Post\MetaFormat
         * @see ACP\Sorting\FormatValue\PostTitle
         */
        // return new ACP\Sorting\Model\Post\MetaFormat( new ACP\Sorting\FormatValue\PostTitle(), 'my_custom_field_key' );

        // Within this directory you will find all available sorting models: `admin-columns-pro/classes/Sorting/Model`.
    }

    public function export()
    {
        return new Export();
    }

    public function search()
    {
        // Smart Filtering (internally named: Search)
        return new Search();
    }

    /**
     * (Optional) Create extra settings for you column. These are visible when editing a column. You can remove this function is you do not use it!
     * Write your own settings or use any of the standard available settings.
     */
    protected function register_settings(): void
    {
        // NOTE! When you use any of these settings, you should remove the get_value() method from this column, because the value will be rendered by the AC_Settings_Column_{$type} classes.

        // Display an image preview size settings screen
        // $this->add_setting( new \AC\Settings\Column\Image( $this ) );

        // Display an excerpt length input field in words
        // $this->add_setting( new \AC\Settings\Column\WordLimit( $this ) );

        // Display an excerpt length input field in characters
        // $this->add_setting( new \AC\Settings\Column\CharacterLimit( $this ) );

        // Display a date format settings input field
        // $this->add_setting( new \AC\Settings\Column\Date( $this ) );

        // Display before and after input fields
        // $this->add_setting( new \AC\Settings\Column\BeforeAfter( $this ) );

        // Displays a dropdown menu with user display formats
        // $this->add_setting( new \AC\Settings\Column\User( $this ) );

        // Displays a dropdown menu with post display formats
        // $this->add_setting( new \AC\Settings\Column\Post( $this ) );
    }

    /**
     * (Optional) Is valid. You can remove this function if you do not use it!
     * This determines whether the column should be available. If you want to disable this column
     * for a particular post type you can set this to false.
     * @return bool True/False Default should be 'true'.
     */
    public function is_valid(): bool
    {
        // Example: if the post type does not support thumbnails then return false
        // if ( ! post_type_supports( $this->get_post_type(), 'thumbnail' ) ) {
        //    return false;
        // }

        return true;
    }

    public function scripts(): void
    {
        wp_enqueue_script('script-' . $this->get_name(), plugin_dir_url(AC_CT_FILE) . "/js/column.js");
        wp_enqueue_style('style-' . $this->get_name(), plugin_dir_url(AC_CT_FILE) . "/css/column.css");
    }

}