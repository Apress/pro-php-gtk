<?php
// Create a GtkTextView.
$text = new GtkTextView();
// Get the buffer from the view.
$buffer = $text->get_buffer();

// Add some text.
$buffer->set_text('Moving a mark is done with either move_mark or move_mark_by_name.');

$tag = $buffer->create_tag();
//$table = $buffer->get_tag_table();
$tag = new GtkTextTag();
$tag->foreground = 'red';

$table->add($tag);

$buffer->apply_tag($tag, $buffer->get_start_iter(), $buffer->get_end_iter());

$window = new GtkWindow();
$window->add($text);
$window->show_all();
Gtk::main();

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>