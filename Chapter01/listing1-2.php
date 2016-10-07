<?php
$window = new GtkWindow();
$window->connect_object('destroy', array('Gtk', 'main_quit'));

$dateTime = new GtkLabel(date('Y-m-d H:i:s'));

$window->add($dateTime);
$window->show_all();
Gtk::main();
?>