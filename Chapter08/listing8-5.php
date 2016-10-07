<?php
function checkForBold($tag)
{
    global $bold;
  
    if ($tag->weight == Pango::WEIGHT_BOLD) {
        $bold[] = $tag;
    }
}

// Create an array to hold the bold tags.
$bold = array();

// Create a GtkTextView.
$text = new GtkTextView();

// Get the buffer from the view.
$buffer = $text->get_buffer();

// Add some text.
$buffer->set_text('Moving a mark is done with either move_mark or ' .
                  'move_mark_by_name.');

// Get the buffer's tag table.
$table = $buffer->get_tag_table();

// Create a new tag and set some properties.
$tag = new GtkTextTag();
$tag->set_property('foreground', 'red');
$tag->set_property('background', 'gray');

// Add the tag to the table.
$table->add($tag);

// Create a new tag and set some properties.
$tag = new GtkTextTag();
$tag->set_property('weight', Pango::WEIGHT_BOLD);

// Add the tag to the table.
$table->add($tag);

// Create a new tag and set some properties.
$tag = new GtkTextTag();
$tag->set_property('foreground', 'blue');
$tag->set_property('weight', Pango::WEIGHT_NORMAL);

// Add the tag to the table.
$table->add($tag);

// Create a new tag and set some properties.
$tag = new GtkTextTag();
$tag->set_property('font', 'Arial Bold 10');

// Add the tag to the table.
$table->add($tag);

// Call checkForBold on all tags in the table.
$table->foreach('checkForBold');

var_dump($bold);
?>