<?php
$window = new GtkWindow();
$window->connect_simple('destroy', array('Gtk', 'main_quit'));

// Create a new toolbar.
$toolbar = new GtkToolbar();

// Add a stock quit item.
$quit = GtkToolButton::new_from_stock(Gtk::STOCK_QUIT);
$toolbar->add($quit);

// Create a signal handler.
$quit->connect_simple('clicked', array('gtk', 'main_quit'));

$window->add($toolbar);
$window->show_all();
Gtk::main();
?>