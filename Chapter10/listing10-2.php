<?php
// Create and set up a window.
$window = new GtkWindow();
$window->connect_simple('destroy', array('Gtk', 'main_quit'));

// Add a table to the window.
$table = new GtkTable(2, 2);
$window->add($table);

// Create four scrolled windows.
$sw1 = new GtkScrolledWindow();
$sw2 = new GtkScrolledWindow();
$sw3 = new GtkScrolledWindow();
$sw4 = new GtkScrolledWindow();

// Set each window to a different position.
$sw1->set_placement(Gtk::CORNER_TOP_LEFT);
$sw2->set_placement(Gtk::CORNER_TOP_RIGHT);
$sw3->set_placement(Gtk::CORNER_BOTTOM_LEFT);
$sw4->set_placement(Gtk::CORNER_BOTTOM_RIGHT);

// Create four frames.
$frame1 = new GtkFrame('TOP_LEFT');
$frame2 = new GtkFrame('TOP_RIGHT');
$frame3 = new GtkFrame('BOTTOM_LEFT');
$frame4 = new GtkFrame('BOTTOM_RIGHT');

// Add the scrolled windows to the frames.
$frame1->add($sw1);
$frame2->add($sw2);
$frame3->add($sw3);
$frame4->add($sw4);

// Attach the frames to the table.
$table->attach($frame1, 0, 1, 0, 1);
$table->attach($frame2, 1, 2, 0, 1);
$table->attach($frame3, 0, 1, 1, 2);
$table->attach($frame4, 1, 2, 1, 2);

// Show everything.
$window->show_all();
Gtk::main();
?>