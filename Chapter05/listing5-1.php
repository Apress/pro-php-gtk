<?php
function toggle($button, $window) 
{
	// Toggle the borders and title bar.
	$window->set_decorated(!$window->get_decorated());

	// Update the button.
	if ($window->get_decorated()) {
		$button->child->set_text('Off');
	} else {
		$button->child->set_text('On');
	}

	// Hide and show the window.
	$window->hide_all();
	$window->show_all();
}

$window = new GtkWindow();
$vBox   = new GtkVBox();
$label  = new GtkLabel('Press the button to toggle the borders.');
$button = new GtkButton('Off');

$window->add($vBox);
$vBox->add($label);
$vBox->add($button);

$button->connect('clicked', 'toggle', $window);

$window->connect_object('destroy', array('Gtk', 'main_quit'));
$window->show_all();

Gtk::main();
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>