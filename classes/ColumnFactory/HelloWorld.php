<?php

declare(strict_types=1);

namespace AcColumnTemplate\ColumnFactory;

use AC\Column\BaseColumnFactory;
use AC\Setting\Config;
use AC\Setting\FormatterCollection;
use AC\Value\Formatter\Post\PostTitle;

class HelloWorld extends BaseColumnFactory
{

    public function get_label(): string
    {
        return 'Hello World';
    }

    public function get_column_type(): string
    {
        return 'column-hello_world';
    }

    protected function add_formatters(FormatterCollection $formatters, Config $config): void
    {
        $formatters->add(
            new PostTitle()
        );
    }

}