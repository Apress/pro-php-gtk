<?php
// Create the feed parser.
require_once 'XML/RSS.php';
$rss = new XML_RSS('http://gtk.php.net/news.rss');

// Parse the RSS feed.
$rss->parse();

// Create a model to store the items.
$listStore = new GtkListStore(Gtk::TYPE_STRING, Gtk::TYPE_STRING, Gtk::TYPE_STRING, Gtk::TYPE_LONG );

// Add a row for each item in the feed.
foreach ($rss->getItems() as $item) {
  $rowData = array($item['title'], $item['date'], $item['description'], Pango::WEIGHT_BOLD);
  $listStore->append($rowData);
}

// Create the view responsible for showing the feed.
$view = new GtkTreeView($listStore);
$view->set_headers_visible(false);

// The view only has one column.
$column = new GtkTreeViewColumn();
$view->insert_column($column, 0);

// Create a renderer for the column.
$cell_renderer = new GtkCellRendererText();
$column->pack_start($cell_renderer, true);
$column->add_attribute($cell_renderer, 'text', 0);
$column->add_attribute($cell_renderer, 'weight', 3);

// Sort the column by date.
$column->set_sort_column_id(1);

$window = new GtkWindow();
$window->connect_simple('destroy', array('Gtk', 'main_quit'));

// Add the view, show everything and start the loop.
$window->add($view);
$window->show_all();
Gtk::main();
?>