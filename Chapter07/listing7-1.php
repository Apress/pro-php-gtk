<?php
function change($label)
{
	$label->set_use_markup(!$label->get_use_markup());
}

$window = new GtkWindow();
$window->connect_object('destroy', array('Gtk', 'main_quit'));

$box = new GtkVBox();
$window->add($box);

$label = new GtkLabel('Test Label Test Label Test Label Test Label Test Label TestLabel Test Label Test Label Test <span foreground="#FF0">Label</span> Test Label Test Label');
//$label->set_ellipsize(Pango::ELLIPSIZE_END);

//$label->set_size_request(100, 100);
//$label->set_max_width_chars(10);
//var_dump($label->get_max_width_chars());
$label->set_justify(GTK::JUSTIFY_FILL);
$label->set_line_wrap(true);

$button = new GtkButton('Change');
$button->connect_object('clicked', 'change', $label);

$box->pack_start($label, false, false);
$box->pack_start($button);


$window->show_all();
Gtk::main();

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>