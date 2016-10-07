<?php
function hideColumn($column)
{
	// Toggle the visibility of the column.
	$column->set_visible(!$column->get_visible());
}

// Create a tree store.
$treeStore = new GtkTreeStore(Gtk::TYPE_STRING, Gtk::TYPE_LONG, Gtk::TYPE_DOUBLE);

// Add some product data.
$csMerch     = $treeStore->append(null, array('Crisscott', null, null));
$phpGtkMerch = $treeStore->append(null, array('PHP-GTK',   null, null));

$tShirts = $treeStore->append($csMerch, array('T-Shirts', 10, 19.95));
$treeStore->append($tShirts, array('Small',  3, 19.95));
$treeStore->append($tShirts, array('Medium', 5, 19.95));
$treeStore->append($tShirts, array('Large',  2, 19.95));

$pencils = $treeStore->append($csMerch, array('Pencils', 18, .99));
$treeStore->append($pencils, array('Blue', 9, .99));
$treeStore->append($pencils, array('White', 9, .99));

$treeStore->append($phpGtkMerch, array('PHP-GTK Bumper Stickers', 37, 1.99));
$treeStore->append($phpGtkMerch, array('Pro PHP-GTK',             23, 44.95));

// Create a veiw to show the tree.
$view = new GtkTreeView();
$view->set_model($treeStore);

// Create columns for each type of data.
$column = new GtkTreeViewColumn();
$column->set_title('Product Name');
$view->insert_column($column, 0);
// Create a renderer for the column.
$cell_renderer = new GtkCellRendererText();
$column->pack_start($cell_renderer, true);
$column->set_attributes($cell_renderer, 'text', 0);

// Make the column resizeable by the user. 
$column->set_resizable(true);
$column->set_sort_column_id(0);

// Create column2s for each type of data.
$column2 = new GtkTreeViewColumn();
$column2->set_title('Inventory');
$view->insert_column($column2, 1);
// Create a renderer for the column2.
$cell_renderer = new GtkCellRendererText();
$column2->pack_start($cell_renderer, true);
$column2->set_attributes($cell_renderer, 'text', 1);

// Make the column2 resizeable by the user. 
$column2->set_resizable(true);
$column2->set_reorderable(true);

// Make the inventory column2 hide-able.
$column2->set_clickable(true);
$column2->connect('clicked', 'hideColumn');
$column->set_sort_column_id(0);

// Create columns for each type of data.
$column3 = new GtkTreeViewColumn();
$column3->set_title('Price');
$view->insert_column($column3, 2);
// Create a renderer for the column3.
$cell_renderer = new GtkCellRendererText();
$column3->pack_start($cell_renderer, true);
$column3->set_attributes($cell_renderer, 'text', 2);

// Make the column3 resizeable by the user. 
$column3->set_resizable(true);
$column3->set_reorderable(true);
$column3->set_sort_column_id(2);

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
