<?php

declare(strict_types=1);

namespace AcColumnTemplate\ColumnFactory;

use AC;
use AC\Setting\ComponentCollection;
use AC\Setting\Config;
use AC\Setting\FormatterCollection;

class Column extends AC\Column\BaseColumnFactory
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
    protected function get_formatters(Config $config, ComponentCollection $components): FormatterCollection
    {
        // Example 1: Show Post Title and make it linkable to Edit Post
        $formatters = new AC\Setting\FormatterCollection([
            new AC\Value\Formatter\Post\PostTitle(),
            new AC\Value\Formatter\Post\PostLink('edit_post'),
        ]);

        // Merge any formatters provided by settings
        $formatters->merge(parent::get_formatters($config, $components));

        // Example 2: Same as above but written in a custom Formatter class
        //        require_once __DIR__ . '/../Formatter/ExampleFormatter.php';
        //        $formatters = new FormatterCollection([
        //            new ExampleFormatter(),
        //        ]);

        // Example 3: Show Custom Field Value and wrap it in a color block
        //        $formatters = new AC\Setting\FormatterCollection([
        //            new AC\Value\Formatter\Meta(new AC\MetaType('post'), 'my_custom_field_key'),
        //            new AC\Value\Formatter\Color(),
        //        ]);

        return $formatters;
    }

}