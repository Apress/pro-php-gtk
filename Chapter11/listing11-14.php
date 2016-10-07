<?php
$window = new GtkWindow();
$window->connect_simple('destroy', array('Gtk', 'main_quit'));

// Create a new toolbar.
$toolbar = new GtkToolbar();

// Create an empty button.
$crisscott = new GtkToggleToolButton();

// Add an icon.
$crisscott->set_icon_widget(GtkImage::new_from_file('Crisscott/images/menuItemGrey.png'));

// Create a special label.
$crisscottLabel = new GtkLabel('Send data too Crisscott');
$crisscottLabel->set_ellipsize(Pango::ELLIPSIZE_START);

// Set the label widget.
$crisscott->set_label_widget($crisscottLabel);

// Add the tool button.
$toolbar->add($crisscott);

$window->add($toolbar);
$window->show_all();
Gtk::main();
?>