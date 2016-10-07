<?php
function echoValue($spinButton)
{
    echo $spinButton->get_value() . "\n";
}

$window = new GtkWindow();
$window->set_size_request(100, 100);

$spin = new GtkSpinButton(new GtkAdjustment(4, 0, 10, 1, 2), 1, 0);
$spin->connect('changed', 'echoValue');

$vBox = new GtkVBox();

$window->add($vBox);
$vBox->pack_start(new GtkLabel('GtkSpinButton'), false, false);
$vBox->pack_start($spin, false, false);

$window->connect_object('destroy', array('Gtk', 'main_quit'));
$window->show_all();
Gtk::main();
?>