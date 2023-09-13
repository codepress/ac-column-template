# Admin Columns - Column Template

Welcome to the Admin Columns Pro column template repository.
Here you will find a starter-kit for creating a new column for Admin Columns Pro. This starter-kit will work as a normal WP plugin.

For more information about creating a new column type, please read the following article:
https://docs.admincolumns.com/article/21-how-to-create-my-own-column

This template is for Admin Columns Pro only.

### Structure

* `ac-column-template.php`: Main plugin file that registers the column
* `/classes/Column/CustomColumn.php`: Column class with all column logic
* `/classes/Column/Editing.php`: Example of a Editing Model (used by inline- and bulk-editing)
* `/classes/Column/Export.php`: Example of a Export Model
* `/classes/Column/Search.php`: Example of a Smart Filtering Model
* `/classes/Column/Sorting.php`: Example of a Sorting Model
* `/css`: folder for .css files
* `/js`:  folder for .js files
* `/languages`: folder for .pot, .po and .mo files
* `readme.txt`: WordPress readme file to be used by the wordpress repository

### step 1.

This template uses two placeholders. Use the following list to do a 'find and replace' on them:

* `COLUMN_NAME`: Single-word, no spaces. Underscores allowed. eg. my-custom-column-name
* `COLUMN_LABEL`: Multiple words, can include spaces, visible when selecting a column

### step 2.

Edit the `ac-column-template.php` file to change to which list table the column belongs.

### step 3.

Edit the `Column.php` file and include your custom code in the appropriate functions.

### step 4 (optional).

The structure of this plugin is prepared so that it can contain multiple columns.
If you want to create multiple custom columns in this plugin, you can create a copy of the 'Column' folder and use a 
different folder name. Then make sure to `require` the copied files in the main plugin file.