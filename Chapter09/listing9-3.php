<?php
// Create a list store.
$listStore = new GtkListStore(Gtk::TYPE_STRING, Gtk::TYPE_LONG, Gtk::TYPE_DOUBLE);

// Add some product data.
$listStore->append(array('Crisscott T-Shirts',       10, 19.95));
$listStore->prepend(array('PHP-GTK Bumper Stickers', 37, 1.99));
$listStore->prepend(array('Pro PHP-GTK',             23, 44.95));

$pencils = array('Crisscott Pencils', 18, .99);
$listStore->insert(2, array('Crisscott Pencils', 18, .99));//$pencils);

// Create a veiw to show the list.
$view = new GtkTreeView();
$view->set_model($listStore);

// Create columns for each type of data.
$column = new GtkTreeViewColumn();
$column->set_title('Product Name');
$view->insert_column($column, 0);
// Create a renderer for the column.
$cell_renderer = new GtkCellRendererText();
$column->pack_start($cell_renderer, true);
$column->set_attributes($cell_renderer, 'text', 0);

// Create columns for each type of data.
$column = new GtkTreeViewColumn();
$column->set_title('Inventory');
$view->insert_column($column, 1);
// Create a renderer for the column.
$cell_renderer = new GtkCellRendererText();
$column->pack_start($cell_renderer, true);
$column->set_attributes($cell_renderer, 'text', 1);

// Create columns for each type of data.
$column = new GtkTreeViewColumn();
$column->set_title('Price');
$view->insert_column($column, 2);
// Create a renderer for the column.
$cell_renderer = new GtkCellRendererText();
$column->pack_start($cell_renderer, true);
$column->set_attributes($cell_renderer, 'text', 2);

// Create a window and show everything.
$window = new GtkWindow();
$window->add($view);
$window->show_all();
$window->connect_object('destroy', array('Gtk', 'main_quit'));
Gtk::main();

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>
