<?php

namespace AcColumnTemplate\Column;

use AC;
use ACP;

/**
 * Column instance. Here you can set its label, display value, and add extra functionality such as sorting, filtering, export and editing.
 * @link https://docs.admincolumns.com/article/21-how-to-create-my-own-column
 */
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
     * Display value. Returns the column value used for rendering within the list table.
     */
    public function get_value($id): string
    {
        // put all the column logic here to retrieve the value you need
        // For example:
        $value = get_post_meta($id, 'my_custom_field_key', true) ?: '-';

        // Optionally you can change the display of the value. In this example we added an edit post link.
        $value = "<a href='" . get_edit_post_link($id) . "'>$value</a>";

        return $value;
    }

    /**
     * Editing model. Used by inline- and bulk-editing to update column values directly from within the list table.
     * @link https://docs.admincolumns.com/article/27-how-to-use-inline-editing
     * @link https://docs.admincolumns.com/article/67-how-to-use-bulk-editing
     */
    public function editing()
    {
        /**
         * Example #1 - A custom editing model. Create your own input field and set how you want your data to be saved
         */
        return new Editing();

        /**
         * Example #2 - A `Text` input field for a custom field value
         * @see ACP\Editing\Service\Post\Meta This model stores the data as metadata
         * @see ACP\Editing\View\Text Type of input field
         */
        // return new ACP\Editing\Service\Post\Meta('my_custom_field_key', new ACP\Editing\View\Text());
        /**
         * Available input types:
         * @see ACP\Editing\View\Text
         * @see ACP\Editing\View\TextArea
         * @see ACP\Editing\View\Number
         * @see ACP\Editing\View\Image
         * @see ACP\Editing\View\Url
         * @see ACP\Editing\View\Wysiwyg
         * @see ACP\Editing\View\Select
         * @see ACP\Editing\View\Toggle
         * @see ACP\Editing\View\Media
         * @see ACP\Editing\View\Password
         * @see ACP\Editing\View\Taxonomy
         * @see ACP\Editing\View\Color
         * @see ACP\Editing\View\Email
         * @see ACP\Editing\View\Date
         * @see ACP\Editing\View\DateTime
         * @see ACP\Editing\View\CheckboxList
         * @see ACP\Editing\View\ComputedNumber
         * @see ACP\Editing\View\Video
         */
    }

    /**
     * Sorting model. Used to sort the list table when clicking the column header.
     * @link https://docs.admincolumns.com/article/34-how-to-enable-sorting
     */
    public function sorting()
    {
        /**
         * Example #1 - Write your own custom sorting query using this model
         */
        return new Sorting();

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
         */
        // return new ACP\Sorting\Model\Post\MetaFormat( new ACP\Sorting\FormatValue\PostTitle(), 'my_custom_field_key' );
        /**
         * You will find all available sorting models in this plugin folder: `admin-columns-pro/classes/Sorting/Model`.
         */
    }

    /**
     * Export model. Used for exporting column values to CSV.
     * @link https://docs.admincolumns.com/article/69-how-to-use-export
     */
    public function export()
    {
        /**
         * Example #1 - A custom export model
         */
        return new Export();

        /**
         * Example #2 - Export a custom field value
         * @see ACP\Export\Model\Post\Meta
         * @see ACP\Export\Model\User\Meta
         * @see ACP\Export\Model\Term\Meta
         * @see ACP\Export\Model\Comment\Meta
         */
        // return new ACP\Export\Model\Post\Meta('my_custom_field_key');
        // return new ACP\Export\Model\User\Meta('my_custom_field_key');
        // return new ACP\Export\Model\Meta\Meta('my_custom_field_key');
        // return new ACP\Export\Model\Comment\Meta('my_custom_field_key');
    }

    /**
     * Smart Filtering model (internally named: Search). Used to filter the list table when using our smart filters.
     * @link https://docs.admincolumns.com/article/61-how-to-use-smart-filtering
     */
    public function search()
    {
        /**
         * Example #1 - A custom filtering model
         */
        return new Search();

        /**
         * Example #2 - Filter by custom field values
         */
        // return new ACP\Search\Comparison\Meta\Text('my_custom_field_key');
        // return new ACP\Search\Comparison\Meta\Number('my_custom_field_key');
        /**
         * Available custom field filtering models:
         * @see ACP\Search\Comparison\Meta\Text
         * @see ACP\Search\Comparison\Meta\Number
         * @see ACP\Search\Comparison\Meta\Image
         * @see ACP\Search\Comparison\Meta\Toggle
         * @see ACP\Search\Comparison\Meta\Date
         * @see ACP\Search\Comparison\Meta\DateTime\ISO
         * @see ACP\Search\Comparison\Meta\DateTime\Timestamp
         * @see ACP\Search\Comparison\Meta\User
         * @see ACP\Search\Comparison\Meta\Post
         * @see ACP\Search\Comparison\Meta\Media
         * @see ACP\Search\Comparison\Meta\Decimal
         * @see ACP\Search\Comparison\Meta\Select
         * @see ACP\Search\Comparison\Meta\Checkmark
         * @see ACP\Search\Comparison\Meta\Serialized
         */
    }

    /**
     * (Optional) Create extra settings for you column. These are visible when editing a column. You can remove this function is you do not use it!
     * Write your own settings or use any of the standard available settings.
     */
    protected function register_settings(): void
    {
        // NOTE! When you use any of these settings, you should remove the get_value() method from this column, because the value will be rendered by the AC_Settings_Column_{$type} classes.

        // Display an image preview size settings screen
        // $this->add_setting( new AC\Settings\Column\Image( $this ) );

        // Display an excerpt length input field in words
        // $this->add_setting( new AC\Settings\Column\WordLimit( $this ) );

        // Display an excerpt length input field in characters
        // $this->add_setting( new AC\Settings\Column\CharacterLimit( $this ) );

        // Display a date format settings input field
        // $this->add_setting( new AC\Settings\Column\Date( $this ) );

        // Display before and after input fields
        // $this->add_setting( new AC\Settings\Column\BeforeAfter( $this ) );

        // Displays a dropdown menu with user display formats
        // $this->add_setting( new AC\Settings\Column\User( $this ) );

        // Displays a dropdown menu with post display formats
        // $this->add_setting( new AC\Settings\Column\Post( $this ) );
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

    /*
     * (Optional) Enqueue CSS + JavaScript on the admin listings screen. You can remove this function is you do not use it!
     *
     * This action is called in the admin_head action on the listings screen where your column values are displayed.
     * Use this action to add CSS + JavaScript
     */
    public function scripts(): void
    {
        // wp_enqueue_script('script-' . $this->get_name(), plugin_dir_url(AC_CT_FILE) . "js/column.js");
        // wp_enqueue_style('style-' . $this->get_name(), plugin_dir_url(AC_CT_FILE) . "css/column.css");
    }

}