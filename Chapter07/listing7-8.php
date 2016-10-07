<?php
function echoValue($spinButton)
{
    echo $spinButton->get_value() . "\n";
}

$window = new GtkWindow();
$window->set_size_request(150, 150);

$hScale = new GtkHScale(new GtkAdjustment(4, 0, 10, 1, 2));
$hScale->connect('value-changed', 'echoValue');

$vScale = new GtkVScale(new GtkAdjustment(4, 0, 10, 1, 2));
$vScale->connect('value-changed', 'echoValue');
$vScale->set_value_pos(GTK::POS_LEFT);

$hBox  = new GtkHBox();
$vBox1 = new GtkVBox();
$vBox2 = new GtkVBox();

$window->add($hBox);
$hBox->pack_start($vBox1);
$hBox->pack_start($vBox2);

$vBox1->pack_start(new GtkLabel('GtkHScale'), false, false);
$vBox1->pack_start($hScale, false, false);

$vBox2->pack_start(new GtkLabel('GtkVScale'), false, false);
$vBox2->pack_start($vScale);

$window->connect_object('destroy', array('Gtk', 'main_quit'));
$window->show_all();
Gtk::main();
?>