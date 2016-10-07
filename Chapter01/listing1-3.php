<?php
/**
 * A really simple PHP-GTK application.
 */
$window = new GtkWindow();
$window->connect_object('destroy', array('Gtk', 'main_quit'));
$window->show();
Gtk::main();
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>