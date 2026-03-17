# Admin Columns — Column Template

A starter-kit plugin for creating custom column types for **Admin Columns Pro**. Copy, customise, and activate — no build step required.

> **Requires**: Admin Columns Pro (not the free Admin Columns plugin)

---

## Quick Start

1. Copy this folder into `wp-content/plugins/`
2. Rename the folder, the main plugin file, and the function `acp_my_custom_column` in `ac-column-template.php` to something unique to avoid conflicts if two plugins based on this template are active at once (e.g. `my-score-column/`, `my-score-column.php`, `my_score_column`)
3. Find-and-replace both placeholders across **all files** (see [Placeholder Reference](#placeholder-reference))
4. Edit `ac-column-template.php` to target the right table screen (see [Targeting a Table Screen](#targeting-a-table-screen))
5. Edit `classes/Column/Column.php` — replace the meta key in `get_formatters()` with your own (see [Displaying a Value](#displaying-a-value))
6. Activate the plugin in WordPress and add your column in the Admin Columns settings

---

## Placeholder Reference

Two placeholders appear throughout the files — replace both everywhere before activating:

| Placeholder | What it becomes | Example |
|---|---|---|
| `COLUMN_NAME` | Machine identifier — lowercase, hyphens OK | `my-score` |
| `COLUMN_LABEL` | Human-readable label shown in the column picker | `My Score` |

Run a find-and-replace across **all files in the folder**, not just `Column.php`. Both placeholders appear in the main plugin file, `Column.php`, and the plugin header comment.

---

## Targeting a Table Screen

`ac-column-template.php` hooks into `ac/column/types`. The filter receives `$factories` (array of factory class names) and `$table_screen` (the current list table). Use `$table_screen` to decide when to register your column:

```php
// Any post type (posts, pages, custom post types)
if ($table_screen instanceof AC\PostType) {
    $factories[] = AcColumnTemplate\Column\Column::class;
}

// Specific post type only
if ('page' === (string)$table_screen->get_id()) {
    $factories[] = AcColumnTemplate\Column\Column::class;
}

// Multiple screen types at once
switch (true) {
    case $table_screen instanceof AC\TableScreen\Post:
    case $table_screen instanceof AC\TableScreen\User:
    case $table_screen instanceof AC\TableScreen\Media:
    case $table_screen instanceof ACP\TableScreen\Taxonomy:
        $factories[] = AcColumnTemplate\Column\Column::class;
        break;
}
```

Available table screen classes: `AC\TableScreen\Post`, `AC\TableScreen\User`, `AC\TableScreen\Media`, `ACP\TableScreen\Taxonomy`.

> **Note:** `AC\PostType` (used in example 1) is an interface satisfied by all post-type screens — posts, pages, and custom post types. `AC\TableScreen\Post` implements that interface and represents the same screens. Use the `switch` pattern when you need to combine post screens with non-post screens like `User` or `Taxonomy` in one condition.

---

## Displaying a Value

`get_formatters()` in `Column.php` is the **only method you must implement**. It returns an `AC\FormatterCollection` that reads and formats the cell value.

The simplest case — display a custom field:

```php
protected function get_formatters(AC\Setting\Config $config): AC\FormatterCollection
{
    return new AC\FormatterCollection([
        new AC\Formatter\Meta(
            AC\MetaType::create_post_meta(),
            'my_custom_field_key'
        ),
    ]);
}
```

For a custom formatter, copy `classes/Formatter/ExampleFormatter.php` and implement `format(Value $value): Value`. Return `$value->with_value($new_value)`, or throw `AC\Exception\ValueNotFoundException::from_id($value->get_id())` to render an empty cell. `ExampleFormatter` reads a meta key, resolves a related post title, and renders it as a link with a fallback — use it as a starting point when a built-in formatter can't produce the output you need.

The template **enables all optional features by default**. To disable a feature, either delete the method or change it to `return null`.

---

## Optional Features

Each feature is a separate class. All four are enabled by default — return `null` or remove the method to disable one.

| Feature | File | Enabled by default | Built-in shortcut available |
|---|---|---|---|
| Display value | `Column.php` → `get_formatters()` | Required | `AC\Formatter\Meta` |
| Inline/bulk editing | `Editing.php` → `get_editing()` | Yes | `ACP\Editing\Service\Post\Meta` |
| Smart filtering | `Search.php` → `get_search()` | Yes | `ACP\Search\Comparison\Meta\Text` etc. |
| Sorting | `Sorting.php` → `get_sorting()` | Yes | `ACP\Sorting\Model\Post\Meta` |
| CSV export | `Export.php` → `get_export()` | Yes | Omit method to reuse display formatter |

### Inline & Bulk Editing — `Editing.php`

Implements `ACP\Editing\Service`. Three methods:

- `get_value(int $id)` — current value to pre-fill the input
- `get_view(string $context): ?View` — input type (`'single'` = inline, `'bulk'` = bulk edit)
- `update(int $id, $data): void` — saves the submitted value

```php
// Editing.php (custom class)
return new Editing();

// Or use a built-in service — no custom class needed:
return new ACP\Editing\Service\Post\Meta('my_custom_field_key', new ACP\Editing\View\Text());
```

Available `View` types: `Text`, `TextArea`, `Number`, `Select`, `Image`, `Url`, `Email`, `Wysiwyg`, `Toggle`, `Media`, `Date`, `DateTime`, `Color`, `CheckboxList`, `AjaxSelect`.

### Smart Filtering — `Search.php`

Extends `ACP\Search\Comparison`. The constructor declares allowed operators and value type. `create_query_bindings()` builds the SQL via `$binding->meta_query([...])` (delegates to `WP_Meta_Query`) or raw `$binding->join()` + `$binding->where()`.

```php
// Search.php (custom class)
return new Search();

// Or use a built-in comparison — no custom class needed:
return new ACP\Search\Comparison\Meta\Text('my_custom_field_key');
return new ACP\Search\Comparison\Meta\Number('my_custom_field_key');
```

Other built-ins: `Meta\Image`, `Meta\Toggle`, `Meta\Date`, `Meta\DateTime\Timestamp`, `Meta\Select`, `Meta\Decimal`, `Meta\User`, `Meta\Post`.

### Sorting — `Sorting.php`

Implements `ACP\Sorting\Model\QueryBindings`. `create_query_bindings(Order $order)` adds a JOIN and ORDER BY to the query. Use `SqlOrderByFactory::create()` to push empty values to the bottom automatically.

```php
// Sorting.php (custom class)
return new Sorting();

// Or use a built-in model — no custom class needed:
return new ACP\Sorting\Model\Post\Meta('my_custom_field_key');
```

### CSV Export — `Export.php`

Implements `AC\Formatter`. Works like a display formatter but targets CSV output. If your display formatter already produces plain text, you can omit `get_export()` entirely — Admin Columns falls back to it automatically. To export raw meta without a custom class, reuse `AC\Formatter\Meta` directly:

```php
// Export.php (custom class)
return new AC\FormatterCollection([new Export()]);

// Or reuse the display formatter built-in — no custom class needed:
return new AC\FormatterCollection([
    new AC\Formatter\Meta(AC\MetaType::create_post_meta(), 'my_custom_field_key'),
]);
```

---

## Multiple Columns in One Plugin

1. Duplicate the `classes/Column/` folder and give it a new name (e.g. `classes/SecondColumn/`)
2. Update the `namespace` declaration in each copied file
3. Add `require_once` lines for the new files in `ac-column-template.php`
4. Register the new factory class in the same `ac/column/types` filter function

---

## Troubleshooting

**Column not appearing in the column picker**
- Check that the `$table_screen` condition in `ac-column-template.php` matches the list table you are viewing
- Confirm both placeholders (`COLUMN_NAME`, `COLUMN_LABEL`) have been replaced in all files
- Ensure the plugin is activated

**Column cell shows nothing**
- Verify the meta key in `get_formatters()` matches the actual key stored in the database
- Confirm the post (or user/term) actually has a value saved for that meta key

**Inline edit not saving**
- Check that `update()` in `Editing.php` uses the correct meta key and the right function (`update_post_meta`, `update_user_meta`, etc.) for your object type

---

## Further Reading

- [How to create a custom column](https://docs.admincolumns.com/article/21-how-to-create-my-own-column)
- [Inline editing docs](https://docs.admincolumns.com/article/27-how-to-use-inline-editing)
- [Bulk editing docs](https://docs.admincolumns.com/article/67-how-to-use-bulk-editing)
