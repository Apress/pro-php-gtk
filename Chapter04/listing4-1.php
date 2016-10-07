<?php
/**
 * Reacting to events.
 */
function setParentFunction($widget)
{
	$parent = $widget->get_parent();

	echo 'The ' . get_class($widget) . ' has ';
	if (isset($parent)) {
		echo 'a ' . get_class($parent);
	} else {
		echo 'no';
	}
	echo " parent.\n";		
}

// Start with three widgets.
$window = new GtkWindow();
$frame  = new GtkFrame('I am a frame');
$button = new GtkButton("I'm a button");

// Connect the event to our test function
$button->connect('parent-set', 'setParentFunction');

// Now set some parents.
$button->set_parent($window);
$button->unparent();
$frame->add($button);

$button->reparent($window);
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>