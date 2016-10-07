<?php
/**
 * Getting, setting and changing a widgets parent.
 */
function testForParent($widget)
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

testForParent($button);

$button->set_parent($frame);
testForParent($button);

// What if we want the button to be added directly to
// the window?
$button->unparent();
$button->set_parent($window);
testForParent($button);
$button->unparent();
testForParent($button);
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>