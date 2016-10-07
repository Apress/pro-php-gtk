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

// Create an edit menu item.
$edit = new GtkMenuItem('Edit');
// Insert it into the menu bar.
$menuBar->insert($edit, 1);
?>