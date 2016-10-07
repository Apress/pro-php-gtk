<?php
function traverseTree($tree, $iter, $parent, $childNum)
{
	$dashes = '';
	for($i = 0; $i < $tree->iter_depth($iter); ++$i) {
		$dashes.= '--';
	}

	echo $dashes . ' ' . $tree->get_value($iter, 0) . "\n";

	if ($tree->iter_has_child($iter)) {
		$newParent = $iter->copy();
		$tree->iter_nth_child($iter, $newParent, 0);
		traverseTree($tree, $iter, $newParent, 0);
	} elseif ($childNum < $tree->iter_n_children($parent) - 1) {
		if ($tree->iter_nth_child($iter, $parent, $childNum + 1)) {
			traverseTree($tree, $iter, $parent, $childNum + 1);
		}
	} elseif ($tree->iter_next($parent)) {
		traverseTree($tree, $parent, $iter, $childNum + 1);
	} else {
		if ($tree->iter_parent($iter, $parent)) {
			$tree->iter_next($iter);
			$tree->iter_parent($parent, $iter);
			if ($tree->iter_is_valid($iter)) {
				traverseTree($tree, $iter, $parent, $childNum);
			}
		}
	}
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

$pencils = $treeStore->append($csMerch, array(' Pencils', 18, .99));
$treeStore->append($pencils, array('Blue', 9, .99));
$treeStore->append($pencils, array('White', 9, .99));

$treeStore->append($phpGtkMerch, array('PHP-GTK Bumper Stickers', 37, 1.99));
$treeStore->append($phpGtkMerch, array('Pro PHP-GTK',             23, 44.95));

traverseTree($treeStore, $treeStore->get_iter_first(), NULL, 0);

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
