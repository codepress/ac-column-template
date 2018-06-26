# Admin Columns - Column Template

Welcome to the Admin Columns column template repository.
Here you will find a starter-kit for creating a new column for Admin Columns. This start-kit will work as a normal WP plugin.

For more information about creating a new field type, please read the following article:
https://www.admincolumns.com/documentation/how-to/register-column/

This template is written for Admin Columns 4.0. The documentation for 3.0 can be found here: https://github.com/codepress/ac-column-template/tree/v3.<br>

( credits to Elliot for the readme structure )

### Important

To use this tookit for Admin Columns Pro < 4.3 please use the no-namespace branch instead!

### Structure

* `/css`: folder for .css files
* `/js`:  folder for .js files
* `/languages`: folder for .pot, .po and .mo files
* `ac-COLUMN_NAME.php`: Main plugin file that registers the column
* `ac-column-COLUMN_NAME.php`: Column class with all column logic for the free version
* `acp-column-COLUMN_NAME.php`: Column class with all column logic for the pro version
* `readme.txt`: WordPress readme file to be used by the wordpress repository

### step 1.

This template uses `PLACEHOLDERS` such as `COLUMN_NAME` throughout the file names and code. Use the following list of placeholders to do a 'find and replace':

* `COLUMN_NAME`: Single word, no spaces. Underscores allowed. eg. donate_button
* `COLUMN_LABEL`: Multiple words, can include spaces, visible when selecting a column
* `PLUGIN_URL`: Url to the github or WordPress repository
* `PLUGIN_TAGS`: Comma seperated list of relevant tags
* `DESCRIPTION`: Brief description of the field type, no longer than 2 lines
* `EXTENDED_DESCRIPTION`: Extended description of the field type
* `AUTHOR_NAME`: Name of field type author
* `AUTHOR_URL`: URL to author's website

### step 2.

Edit the `ac-COLUMN_NAME.php` file (now renamed using your column name) and change the column type if necessary.

### step 3.

Edit the `ac-column-COLUMN_NAME.php` file (now renamed using your column name) and include your custom code in the appropriate functions.

### step 4.

Edit this `README.md` file with the appropriate information and delete all content above and including the following line.

-----------------------

# Admin Columns COLUMN_LABEL Column

DESCRIPTION

-----------------------

### Description

EXTENDED_DESCRIPTION

### Installation

1. Copy the `ac-column-COLUMN_NAME` folder into your `wp-content/plugins` folder
2. Activate the COLUMN_LABEL plugin via the plugins admin page
3. Create a new column via Admin Columns and select the COLUMN_LABEL column
4. Please refer to the description for more info regarding the field type settings

### Changelog
Please see `readme.txt` for changelog