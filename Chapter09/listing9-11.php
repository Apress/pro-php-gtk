<?php
function unbold($selection)
{
    list($model, $paths) = $selection->get_selected_rows();
    foreach ($paths as $path) {
        $iter = $model->get_iter($path);
        $model->set($iter, 3, Pango::WEIGHT_NORMAL);
    }
}

function columnsAutosize($view)
{
    $view->columns_autosize();
}

function hideColumn($column)
{
    $column->set_visible(!$column->get_visible());
}

// Create a tree store.
$treeStore = new GtkTreeStore(Gtk::TYPE_STRING, Gtk::TYPE_LONG, Gtk::TYPE_DOUBLE, Gtk::TYPE_LONG);

// Add some product data.
$csMerch     = $treeStore->append(null, array('Crisscott', null, null, Pango::WEIGHT_BOLD));
$phpGtkMerch = $treeStore->append(null, array('PHP-GTK',   null, null, Pango::WEIGHT_BOLD));

$tShirts = $treeStore->append($csMerch, array('T-Shirts', 10, 19.95, Pango::WEIGHT_BOLD));
$treeStore->append($tShirts, array('Small',  3, 19.95, Pango::WEIGHT_BOLD));
$treeStore->append($tShirts, array('Medium', 5, 19.95, Pango::WEIGHT_BOLD));
$iter = $treeStore->append($tShirts, array('Large',  2, 19.95, Pango::WEIGHT_BOLD));

$pencils = $treeStore->append($csMerch, array('Pencils', 18, .99, Pango::WEIGHT_BOLD));
$treeStore->append($pencils, array('Blue', 9, .99, Pango::WEIGHT_BOLD));
$treeStore->append($pencils, array('White', 9, .99, Pango::WEIGHT_BOLD));

$treeStore->append($phpGtkMerch, array('PHP-GTK Bumper Stickers', 37, 1.99, Pango::WEIGHT_BOLD));
$treeStore->append($phpGtkMerch, array('Pro PHP-GTK',             23, 44.95, Pango::WEIGHT_BOLD));

// Create a veiw to show the tree.
$view = new GtkTreeView($treeStore);
$view->connect('row-expanded', 'columnsAutosize');

// Create columns for each type of data.
$column = new GtkTreeViewColumn();
$column->set_title('Product Name');
$view->insert_column($column, 0);
// Create a renderer for the column.
$cell_renderer = new GtkCellRendererText();
$column->pack_start($cell_renderer, true);
$column->add_attribute($cell_renderer, 'text', 0);
$column->add_attribute($cell_renderer, 'weight', 3);

// Make the column resizeable by the user. 
$column->set_resizable(true);
$column->set_sort_column_id(0);

// Create column2s for each type of data.
$column2 = new GtkTreeViewColumn();
$column2->set_title('Inventory');
$view->insert_column($column2, 1);
// Create a renderer for the column2.
$cell_renderer = new GtkCellRendererProgress();
$column2->pack_start($cell_renderer, true);
$column2->set_attributes($cell_renderer, 'value', 2);

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

//$view->expand_all();
$view->set_cursor(array(0,0,1), $column);
$view->get_selection()->set_mode(Gtk::SELECTION_MULTIPLE);

$selection = $view->get_selection();
$selection->connect('changed', 'unbold');

// Create a window and show everything.
$window = new GtkWindow();
$window->add($view);
$window->show_all();
$window->set_size_request(200, 200);
$window->connect_simple('destroy', array('Gtk', 'main_quit'));
Gtk::main();

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>
