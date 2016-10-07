<?php
$listStore = new GtkListStore(GTK::TYPE_STRING);
$iter = $listStore->append();
$listStore->set($iter, 0, 'Alabama');
$iter = $listStore->append();
$listStore->set($iter, 0, 'Alaska');
$iter = $listStore->append();
$listStore->set($iter, 0, 'Arizona');
$iter = $listStore->append();
$listStore->set($iter, 0, 'Arkansas');
$iter = $listStore->append();
$listStore->set($iter, 0, 'California');
$iter = $listStore->append();
$listStore->set($iter, 0, 'Colorodo');

$view   = new GtkTreeView();
$view->set_model($listStore);
$column = new GtkTreeViewColumn();
$column->set_title('Column 1');
$view->insert_column($column, 0);
$cell_renderer = new GtkCellRendererText();
$column->pack_start($cell_renderer, true);
$column->set_attributes($cell_renderer, 'text', 0);

$window = new GtkWindow();
$window->add($view);
$window->show_all();
Gtk::main();

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>