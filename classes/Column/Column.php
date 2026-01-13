<?php

declare(strict_types=1);

namespace AcColumnTemplate\Column;

use AC;
use ACP;

class Column extends ACP\Column\AdvancedColumnFactory
{

    public function get_label(): string
    {
        return __('COLUMN_LABEL', 'ac-column-template');
    }

    public function get_column_type(): string
    {
        // Identifier, pick a unique name. Single word, no spaces. Underscores allowed.
        return 'ac-COLUMN_NAME';
    }

    protected function get_formatters(AC\Setting\Config $config): AC\Setting\FormatterCollection
    {
        // Example 1: Show the custom field value for the meta key 'my_custom_field_key'
        $formatters = [
            new AC\Value\Formatter\Meta(
                AC\MetaType::create_post_meta(), // post meta
                'my_custom_field_key' // meta key for the custom field
            ),
        ];

        // Example 2: Same as above but written in a custom Formatter class
        // require_once __DIR__ . '/../Formatter/ExampleFormatter.php';
        //
        // $formatters = [
        //      new ExampleFormatter(),
        // ];

        // Example 3: Shows the Title (of the post) and wraps it in an edit post link
        // $formatters = [
        //     new Formatter\Post\PostTitle(),
        //     new Formatter\Post\PostLink('edit_post'),
        // ];

        return new AC\Setting\FormatterCollection($formatters);
    }

    /**
     * Editing Service. Used by inline- and bulk-editing to update column values directly from within the list table.
     * @link https://docs.admincolumns.com/article/27-how-to-use-inline-editing
     * @link https://docs.admincolumns.com/article/67-how-to-use-bulk-editing
     */
    protected function get_editing(AC\Setting\Config $config): ?ACP\Editing\Service
    {
        /**
         * Example #1 - A custom editing service. Create your own input field and set how you want your data to be saved
         */
        return new Editing();

        /**
         * Example #2 - A `Text` input field for a custom field value
         * @see ACP\Editing\Service\Post\Meta This model stores the data as metadata
         * @see ACP\Editing\View\Text Type of input field
         */
        // return new ACP\Editing\Service\Post\Meta('my_custom_field_key', new ACP\Editing\View\Text());
    }

    /**
     * You will find all available search models in this plugin folder: `admin-columns-pro/classes/Search/Comparison`.
     */
    protected function get_search(AC\Setting\Config $config): ?ACP\Search\Comparison
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
     * You will find all available sorting models in this plugin folder: `admin-columns-pro/classes/Sorting/Model`.
     */
    protected function get_sorting(AC\Setting\Config $config): ?ACP\Sorting\Model\QueryBindings
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
    }

    /**
     * Omit if you want the default export which should be fine for most cases
     */
    protected function get_export(AC\Setting\Config $config): ?AC\Setting\FormatterCollection
    {
        /**
         * Example #1 - A custom export formatter
         */
        $formatters = [
            new Export(),
        ];

        /**
         * Example #2 - Export a custom field value
         * @see AC\Value\Formatter\Post\Meta
         * @see AC\Value\Formatter\User\Meta
         * @see AC\Value\Formatter\Term\Meta
         * @see AC\Value\Formatter\Comment\Meta
         */
        // $formatters[] = new AC\Value\Formatter\Post\Meta('my_custom_field_key');
        // $formatters[] = new AC\Value\Formatter\User\Meta('my_custom_field_key');
        // $formatters[] = new AC\Value\Formatter\Term\Meta('my_custom_field_key');
        // $formatters[] = new AC\Value\Formatter\Comment\Meta('my_custom_field_key');

        // Always place the formatter(s) into a FormatterCollection
        return new AC\Setting\FormatterCollection($formatters);
    }

}