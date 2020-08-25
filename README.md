# Admin Columns - Column Template

Welcome to the Admin Columns column template repository.
Here you will find a starter-kit for creating a new column for Admin Columns. This start-kit will work as a normal WP plugin.

For more information about creating a new field type, please read the following article:
https://docs.admincolumns.com/article/21-how-to-create-my-own-column

This template is for Admin Columns ánd Admin Columns Pro.
It can also be used to create multiple columns in this plugin since the directory structur is prepared to contains multiple column classes.

### Structure

* `/css`: folder for .css files
* `/js`:  folder for .js files
* `/languages`: folder for .pot, .po and .mo files
* `ac-COLUMN_NAME.php`: Main plugin file that registers the column
* `/classes`: folder containing the separate logic classes
* `/classes/Column/Free/COLUMN_NAME.php`: Column class with all column logic for the free version
* `/classes/Column/Pro/COLUMN_NAME.php`: Column class with all column logic for the pro version
* `/classes/Editing/COLUMN_NAME.php`: Editing Model with all editing related logic
* `/classes/Export/COLUMN_NAME.php`: Simple Export Model loaded through the Pro column
* `/classes/Filtering/COLUMN_NAME.php`: Example Filtering Model loaded through Pro column
* `/classes/SmartFiltering/COLUMN_NAME.php`: Example Smart Filtering Comparison (Model) loaded through Pro column
* `/classes/Sorting/COLUMN_NAME.php`: Simple Sorting Model loaded through Pro column
* `readme.txt`: WordPress readme file to be used by the wordpress repository

### step 1.

This template uses `PLACEHOLDERS` such as `COLUMN_NAME` throughout the file names and code. Use the following list of placeholders to do a 'find and replace':

* `PLUGIN_NAME`: Single word, no spaced. Underscrores allowed. This is used for text domain statements and the namespace declaration
* `CUSTOM_NAMESPACE`: Single word, no spaced. Underscrores allowed. This is used for text domain statements and the namespace declaration
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