<?php
/**
 * An example to what happens when you try to add a widget to two containers.
 */
$window = new GtkWindow();
$frame  = new GtkFrame();
$button = new GtkButton("I'm a button");

$window->add($button);
$frame->add($button); 

/*
Spits out this message:
(listing-3.php:1870): Gtk-WARNING **: Attempting to add a widget with type GtkButton to a container of type GtkFrame, but the widget is already inside a container of type GtkWindow, the GTK+ FAQ at http://www.gtk.org/faq/ explains how to reparent a widget.
*/

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>