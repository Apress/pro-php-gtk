<?php
// Create a window to display the image.
$window = new GtkWindow();
// Close the application cleanly.
$window->connect_simple('destroy', array('Gtk', 'main_quit'));

// Load a pixbuf from a file.
$pb = GdkPixbuf::new_from_file('Crisscott/images/logo.png');

// Create the image from the pixbuf.
$image = GtkImage::new_from_pixbuf($pb);

// Add the image to the window.
$window->add($image);
// Show the image and the window.
$window->show_all();
// Start the main loop.
Gtk::main();
?>