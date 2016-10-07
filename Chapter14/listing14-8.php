<?php
function applyTag($fontButton, $text)
{
    // Create a new tag to modify the text.
    $tag = new GtkTextTag();
    // Set the tag font.
    $tag->set_property('font', $fontButton->get_font());
    
    // Get the buffer.
    $buffer = $text->get_buffer();
    
    // Get iters for the start and end of the selection.
    $selectionStart = $buffer->get_start_iter();
    $selectionEnd   = $buffer->get_start_iter();
    
    // Get the iters at the start and end of the selection.
    $buffer->get_iter_at_mark($selectionStart, $buffer->get_insert());
    $buffer->get_iter_at_mark($selectionEnd,   $buffer->get_selection_bound());
    
    // Add the tag to the buffer's tag table.
    $buffer->get_tag_table()->add($tag);
    
    // Apply the tag.
    $buffer->apply_tag($tag, $selectionStart, $selectionEnd);
}

// Create a window and set it to close cleanly.
$window = new GtkWindow();
$window->connect_simple('destroy', array('Gtk', 'main_quit'));

// Create a vBox to hold the window's contents.
$vBox = new GtkVBox();

// Create an hBox to hold the buttons.
$hBox = new GtkHBox();

// Create the color button and pack it into the hBox.
$color = new GtkColorButton();
$hBox->pack_start($color, false, false);

// Pack the hBox into the vBox.
$vBox->pack_start($hBox, false, false, 3);

// Create the text view.
$text = new GtkTextView();
$text->set_size_request(300, 300);

// Create a signal handler for the color button.
$color->connect('color-set', 'applyTag', $text);

// Add the text view to the vBox.
$vBox->pack_start($text);

// Add the vBox to the window and show everything.
$window->add($vBox);
$window->show_all();
Gtk::main();
?>