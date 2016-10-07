<?php
function test($button)
{
  var_dump($button->get_font_name());
}

$window = new GtkWindow();
$window->connect_simple('destroy', array('Gtk', 'main_quit'));

$fButton = new GtkFontButton();
$fButton->set_use_font(true);
$fButton->set_use_size(true);

$window->add($fButton);

$fButton->connect('font-set', 'test');

$window->show_all();
Gtk::main();
?>