<?php
/**
 * Making widget listen for more!
 */
class ChangingLabel extends GtkEventBox {

	public $mouseOverLabel;
	public $mouseOutLabel;

	public function __construct($mouseOverText, $mouseOutText)
	{
		// Set up the labels.
		$this->mouseOverLabel = new GtkLabel($mouseOverText);
		$this->mouseOutLabel  = new GtkLabel($mouseOutText);
		
		// Call the parent constructor.
		parent::__construct();

		// Add the mouse out label to start.
		$this->add($this->mouseOutLabel);

		// Connect the mouse over and out events.
		$this->connect_object('enter-notify-event', array($this, 'switchLabels'));
		$this->connect_object('leave-notify-event', array($this, 'switchLabels'));
	}

	public function switchLabels()
	{
		if ($this->child === $this->mouseOverLabel) {
			$this->remove($this->mouseOverLabel);
			$this->add($this->mouseOutLabel);
			$this->show_all();
		} else {
			$this->remove($this->mouseOutLabel);
			$this->add($this->mouseOverLabel);
			$this->show_all();
		}
	}
}

// Create a window and add our new class to it.
$window = new GtkWindow();
$window->add(new ChangingLabel('Whoo Hoo!', 'Move the mouse here.'));

$window->connect_object('destroy', array('Gtk', 'main_quit'));
$window->show_all();
Gtk::main();
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>