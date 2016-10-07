<?php
$box = new GtkVBox();

$pb = GdkPixbuf::new_from_file('Crisscott/images/inverse.png');

list($pixmap, $mask) = $pb->render_pixmap_and_mask();

$image = GtkImage::new_from_file('Crisscott/images/logo.png');

$text = new GtkTextView();
$text->shape_combine_mask($mask, 0, 0);
$text->get_buffer()->set_text('This is a test. There is a whole in the middle of this text view widget.');

$text->set_wrap_mode(Gtk::WRAP_WORD);

$window = new GtkWindow();
$window->shape_combine_mask($mask, 0, 0);
$window->connect_simple('destroy', array('Gtk', 'main_quit'));
$window->add($text);
$window->show_all();
Gtk::main();
?>