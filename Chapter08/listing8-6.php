<?php
// Create a GtkTextView.
$text = new GtkTextView();
// Get the buffer from the view.
$buffer = $text->get_buffer();

// Add some text.
$buffer->insert_at_cursor('Moving a mark is done with either ', -1);

// Create some tags.
$tag = new GtkTextTag();
$tag->set_property('foreground', 'red');
$tag2 = new GtkTextTag();
$tag2->set_property('weight', Pango::WEIGHT_BOLD);;

// Add them to the tag table.
$table = $buffer->get_tag_table();
$table->add($tag);
$table->add($tag2);

// Insert some text as red and bold.
$buffer->insert($buffer->get_end_iter(), 'move_mark or move_mark_by_name.');//, -1, $tag, $tag2);

$start = $buffer->get_iter_at_offset(strpos($buffer->get_text($buffer->get_start_iter(), $buffer->get_end_iter()),'move_mark'));

$buffer->apply_tag($tag, $start, $buffer->get_end_iter());
$buffer->apply_tag($tag2, $start, $buffer->get_end_iter());

// Get an iter for the end of the first word.
$firstWord = $buffer->get_start_iter();
$firstWord->forward_word_end();

// Remove the first word.
$buffer->delete($buffer->get_start_iter(), $firstWord);

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