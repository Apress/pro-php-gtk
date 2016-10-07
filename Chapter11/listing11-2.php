<?php
// Create a menu bar.
$hMenuBar = new GtkMenuBar();

// Set the packing direction.
$hMenuBar->set_pack_direction(Gtk::PACK_DIRECTION_RTL);

// Create a help menu item.
$help = new GtkMenuItem('Help');
// Append it to the menu bar.
$hMenuBar->append($help);

// Create a file menu item.
$file = new GtkMenuItem('File');
// Prepend it to the menu bar.
$hMenuBar->prepend($file);

// Create an edit menu item.
$edit = new GtkMenuItem('Edit');
// Insert it into the menu bar.
$hMenuBar->insert($edit, 1);

// Create a menu bar.
$vMenuBar = new GtkMenuBar();

// Set the packing direction.
$vMenuBar->set_pack_direction(Gtk::PACK_DIRECTION_BTT);

// Create a help menu item.
$help = new GtkMenuItem('Help');
// Append it to the menu bar.
$vMenuBar->append($help);

// Create a file menu item.
$file = new GtkMenuItem('File');
// Prepend it to the menu bar.
$vMenuBar->prepend($file);

// Create an edit menu item.
$edit = new GtkMenuItem('Edit');
// Insert it into the menu bar.
$vMenuBar->insert($edit, 1);
?>