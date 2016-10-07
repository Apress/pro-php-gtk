<?php
// Create two GtkTextViews.
$text  = new GtkTextView();
$text2 = new GtkTextView();

// Get the buffer from the view.
$buffer = $text->get_buffer();

// Set the buffer as the buffer for the second view.
$text2->set_buffer($buffer);

// Add some text.
$buffer->insert_at_cursor('Moving a mark is done with either move_mark or move_mark_by_name.', -1);

// Create a window and a box.
$window = new GtkWindow();
$vBox   = new GtkVBox();

// Add the text views.
$window->add($vBox);
$vBox->pack_start($text);
$vBox->pack_start($text2);

// Show the application.
$window->show_all();
gtk::main();

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>