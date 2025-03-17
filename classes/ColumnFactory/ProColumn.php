<?php

declare(strict_types=1);

namespace AcColumnTemplate\ColumnFactory;

use AC;
use AC\Setting\Config;
use AC\Setting\FormatterCollection;
use ACP;

class ProColumn extends ACP\Column\BaseFactory
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

    // Example 1: Show Post Title and make it linkable to Edit Post
    protected function get_formatters(Config $config): FormatterCollection
    {
        return new FormatterCollection([
            new AC\Value\Formatter\Post\PostTitle(),
            new AC\Value\Formatter\Post\PostLink('edit_post'),
        ]);

        // Example 2: Same as above but written in a custom Formatter class
        //                require_once __DIR__ . '/../Formatter/ExampleFormatter.php';
        //
        //                return new AC\Setting\FormatterCollection([
        //                    new ExampleFormatter(),
        //                ]);

        // Example 3: Show Custom Field Value and wrap it in a color block
        //        return new AC\Setting\FormatterCollection([
        //            new AC\Value\Formatter\Meta(new AC\MetaType('post'), 'my_custom_field_key'),
        //            new AC\Value\Formatter\Color(),
        //        ]);

    }

}