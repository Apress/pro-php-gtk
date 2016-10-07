<?php
// Create a menu bar.
$menuBar = new GtkMenuBar();

// Create a help menu item.
$help = new GtkMenuItem('Help');
// Append it to the menu bar.
$menuBar->append($help);

// Create a file menu item.
$file = new GtkMenuItem('File');
// Prepend it to the menu bar.
$menuBar->prepend($file);

// Create a menu.
$fileMenu = new GtkMenu();
// Create four menu items to be added to the file menu.
$new      = new GtkMenuItem('New');
$open     = new GtkMenuItem('Open');
$save     = new GtkMenuItem('Save');
$edit     = new GtkMenuItem('Edit');

// Attach the four items to the menu.
$fileMenu->attach($new,  0, 1, 0, 1);
$fileMenu->attach($open, 1, 2, 0, 1);
$fileMenu->attach($save, 0, 1, 1, 2);
$fileMenu->attach($edit, 1, 2, 1, 2);

// Add the file menu to the file item.
$file->set_submenu($fileMenu);

// Create an edit menu item.
$edit = new GtkMenuItem('Edit');
// Insert it into the menu bar.
$menuBar->insert($edit, 1);

// Create a window and add the menu.
$window = new GtkWindow();
$window->connect_simple('destroy', array('Gtk', 'main_quit'));
$window->add($menuBar);
$window->show_all();
Gtk::main();
?>