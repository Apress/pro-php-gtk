<?php
// Create a menu bar.
$menuBar = new GtkMenuBar();

// Create a file menu item.
$file = new GtkMenuItem();
$file->add(new GtkLabel('File'));
// Prepend it to the menu bar.
$menuBar->prepend($file);

// Create an edit menu item.
$edit = new GtkMenuItem('Edit');
// Insert it into the menu bar.
$menuBar->append($edit);

// Create a help menu item.
$help = new GtkMenuItem('_Help');
// Append it to the menu bar.
$menuBar->append($help);

// Create a window and add the menu.
$window = new GtkWindow();
$window->connect_simple('destroy', array('Gtk', 'main_quit'));
$window->add($menuBar);
$window->show_all();
Gtk::main();
?>