<?php
// Create a tree store.
$treeStore = new GtkTreeStore(Gtk::TYPE_STRING, Gtk::TYPE_LONG, 
                              Gtk::TYPE_DOUBLE, Gtk::TYPE_BOOLEAN);

// Add some product data.
$csMerch     = $treeStore->append(null, array('Crisscott', null, null, true));
$phpGtkMerch = $treeStore->append(null, array('PHP-GTK',   null, null, false));

$tShirts = $treeStore->append($csMerch, array('T-Shirts', 10, 19.95, false));
$treeStore->append($tShirts, array('Small',  3, 19.95, true));
$treeStore->append($tShirts, array('Medium', 5, 19.95, true));
$treeStore->append($tShirts, array('Large',  2, 19.95, true));

$pencils = $treeStore->append($csMerch, array(' Pencils', 18, .99, true));
$treeStore->append($pencils, array('Blue', 9, .99, true));
$treeStore->append($pencils, array('White', 9, .99, true));

$treeStore->append($phpGtkMerch, array('PHP-GTK Bumper Stickers', 37, 1.99, true));
$treeStore->append($phpGtkMerch, array('Pro PHP-GTK',             23, 44.95, true));

// Get a filtered model.
$filtered = $treeStore->filter_new();

// Only show rows that have column three set to true.
$filtered->set_visible_column(3);

// Create a veiw to show the tree.
$view = new GtkTreeView();
$view->set_model($filtered);

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
