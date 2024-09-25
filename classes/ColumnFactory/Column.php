<?php

declare(strict_types=1);

namespace AcColumnTemplate\ColumnFactory;

use AC;

class Column extends AC\Column\CustomColumnFactory
{

    public function get_label(): string
    {
        // Default column label.
        return __('COLUMN_LABEL', 'ac-column-template');
    }

    public function get_column_type(): string
    {
        // Identifier, pick a unique name. Single word, no spaces. Underscores allowed.
        return 'ac-COLUMN_NAME';
    }

    /**
     * Collection of formatters that will be processed when rendering the column value.
     * Have a look to the columns in our plugin to see how to use the different formatters.
     */
    protected function get_formatters(AC\Setting\Config $config): AC\Setting\FormatterCollection
    {
        // Example 1: Show Post Title and make it linkable to Edit Post
        return new AC\Setting\FormatterCollection([
            new AC\Value\Formatter\Post\PostTitle(),
            new AC\Value\Formatter\Post\PostLink('edit_post'),
        ]);

        // Example 2: Same as above but written in a custom Formatter class
        //        require_once __DIR__ . '/../Formatter/ExampleFormatter.php';
        //
        //        return new AC\Setting\FormatterCollection([
        //            new ExampleFormatter(),
        //        ]);

        // Example 3: Show Custom Field Value and wrap it in a color block
        //        return new AC\Setting\FormatterCollection([
        //            new AC\Value\Formatter\Meta(new AC\MetaType('post'), 'my_custom_field_key'),
        //            new AC\Value\Formatter\Color(),
        //        ]);
    }

}