<?php
function checkInventory($model, $path, $iter, $userData)
{
	if ($model->get_value($iter, 1) < 15) {
		echo 'Reordering ' . $model->get_value($iter, 0) . "\n";
	}

	return false;
}

// Create a list store.
$listStore = new GtkListStore(Gtk::TYPE_STRING, Gtk::TYPE_LONG, Gtk::TYPE_DOUBLE);

// Add some product data.
$listStore->append(array('Crisscott T-Shirts',       10, 19.95));
$listStore->prepend(array('PHP-GTK Bumper Stickers', 37, 1.99));
$listStore->prepend(array('Pro PHP-GTK',             23, 44.95));

$pencils = array('Crisscott Pencils', 18, .99);
$listStore->insert(2, $pencils);

$listStore->foreach('checkInventory');

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>
