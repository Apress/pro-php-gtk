<?php
// Create a list store.
$listStore = new GtkListStore(Gtk::TYPE_STRING, Gtk::TYPE_LONG, Gtk::TYPE_DOUBLE);

// Add some product data.
$iter = $listStore->append();
$listStore->set($iter, 0, 'Crisscott T-Shirts', 1, 10, 2, 19.95);
$iter = $listStore->prepend();
$listStore->set($iter, 0, 'PHP-GTK Bumper Stickers', 1, 37, 2, 1.99);
$iter = $listStore->prepend();
$listStore->set($iter, 0, 'Pro PHP-GTK', 1, 23, 2, 44.95);
$iter = $listStore->insert(2);
$listStore->set($iter, 0, 'Crisscott Pencils', 2, .99, 1, 18);

// Create a veiw to show the list.
$view   = new GtkTreeView();
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
$window->connect_simple('destroy', array('Gtk', 'main_quit'));
Gtk::main();

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>