<?php
/**
 * An example to show the various states of a widget.
 */
$widget = new GtkWindow();

// If you try to grab the window before realizing 
// the object you will get nothing.
var_dump($widget->window);
var_dump($widget->flags());

$widget->realize();

// Now that the widget is realized, we can grab
// the window property.
var_dump($widget->window);
var_dump($widget->flags());

$widget->show();

// Showing and hiding a widget changes the value
// of its flags.
var_dump($widget->flags());

$widget->hide();

var_dump($widget->flags());

$widget->unrealize();

// Now that the widget is realized, we can grab
// the window property.
var_dump($widget->window);
var_dump($widget->flags());
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>