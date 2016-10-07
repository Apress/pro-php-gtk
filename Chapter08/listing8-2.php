<?php
// Create a GtkTextView.
$text = new GtkTextView();
// Get the buffer from the view.
$buffer = $text->get_buffer();

// Add some text.
$buffer->set_text('Moving a mark is done with either move_mark or move_mark_by_name.');

// Get the fifth word from the buffer.
$iter = $buffer->get_start_iter();
$iter->forward_word_ends(5);
$iter2 = $buffer->get_iter_at_offset($iter->get_offset());
$iter->backward_word_start();
echo $buffer->get_text($iter, $iter2) . "\n";

// Get the second to last word.
$iter = $buffer->get_end_iter();
$iter->backward_word_starts(2);
$iter2 = $buffer->get_iter_at_offset($iter->get_offset());
$iter2->forward_word_end();
echo $buffer->get_text($iter, $iter2) . "\n";

// Figure out how many characters are between the third and sixth words.
$iter = $buffer->get_start_iter();
$iter->forward_word_ends(3);
$endThird = $iter->get_offset();
$iter->forward_word_ends(3);
echo 'There are ' . ($iter->get_offset() - $endThird) . ' ';
echo "characters between the third and sixth words.\n";

// Check to see if the end of the first sentence is the end of the buffer.
$iter = $buffer->get_start_iter();
$iter->forward_sentence_end();
if ($iter == $buffer->get_end_iter()) {
	echo "The buffer only contains one sentence.\n";
} else {
	echo "The buffer contains more than one sentence.\n";
}

// Count the words in the buffer.
$iter  = $buffer->get_start_iter();
$count = 0;
while($iter->forward_word_end()) $count++;
echo 'There are ' . $count . " words in the buffer.\n";
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>