<?php
// Create and set up a window.
$window = new GtkWindow();
$window->connect_simple('destroy', array('Gtk', 'main_quit'));

// Add a table to the window.
$table = new GtkTable(1, 1);

// Add some stuff to the table that will make it large.
$label = new GtkLabel('This is a rather long label. Hopefully ' . 
		      'the table will scroll now.');

// Attach the label.
$table->attach($label, 0, 1, 0, 1);

// Create the view port.
$viewPort = new GtkViewPort();

// Create the scrolled window.
$sWindow = new GtkScrolledWindow();

// Add the table to the view port.
$viewPort->add($table);

// Add the view port to the scrolled window.
$sWindow->add($viewPort);

// Add the scrolled window to the main window.
$window->add($sWindow);

// Show everything.
$window->show_all();
Gtk::main();
?>