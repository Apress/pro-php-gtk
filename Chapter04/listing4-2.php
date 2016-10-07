<?php
/**
 * Reacting to events.
 */
class ExtendedButton extends GtkButton {

	public function __construct($label)
	{
		parent::__construct($label);
		
		$this->connect('parent-set', array($this, 'printParentSet'));
	}

	public function printParentSet($widget)
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
}

// Start with three widgets.
$window = new GtkWindow();
$frame  = new GtkFrame('I am a frame');
$button = new ExtendedButton("I'm a button");

// Now set some parents.
$button->set_parent($window);
$button->unparent();
$frame->add($button);

$frame->connect('parent-set', array('ExtendedButton', 'printParentSet'));
$window->add($frame);
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>