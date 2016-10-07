<?php
// Create a window and set it up to shutdown
// cleanly.
$window = new GtkWindow();
$window->connect_simple('destroy', array('Gtk', 'main_quit'));

// Create a new style object.
$style = new GtkStyle();

// Create a pixbuf.
$file   = 'Crisscott/images/insensitiveCheckered.png';
$pixbuf = GdkPixbuf::new_from_file($file);

// Get a pixmap from the pixbuf.
list($pixmap) = $pixbuf->render_pixmap_and_mask();

// Assign the pixmap to the normal bg_pixmap.
$style->bg_pixmap[Gtk::STATE_INSENSITIVE] = $pixmap;

// Create two buttons.
$button1 = new GtkButton('Active');
$button2 = new GtkButton('Inactive');

// Set the style for both buttons.
$button1->set_style($style);
$button2->set_style($style);

// Make button two inactive.
$button2->set_sensitive(false);

// Add a button box to the window.
$buttonBox = new GtkHButtonBox();
$window->add($buttonBox);

// Add the buttons to the box.
$buttonBox->pack_start($button1);
$buttonBox->pack_start($button2);

// Show the window and start the main loop.
$window->show_all();
Gtk::main();
?>