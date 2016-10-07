<?php
class OnOff extends GtkButton {

    // The id of the signal handler.
    public $handlerId;
    // A counter to show how many times the button has been pressed.
    public $counter = 0;

    public function __construct($label)
    {
        // Call the parent constructor
        parent::__construct($label);
    }

    public function setUp($otherButton)
    {
        // Set up the signal handler.
        $this->handlerId = $this->connect_simple('clicked',
                                                 array($this, 'turnOff'),
                                                 $otherButton
                                                 );
    }

    public function turnOff($otherButton)
    {
        // Turn this button off.
        $this->block($this->handlerId);

        // Change the text to process and add the number of times the 
        // button has been pressed.
        $this->child->set_text('Processing (' . ++$this->counter . ')');

        // Turn the other button on.
        $otherButton->unblock($otherButton->handlerId);

        // Change the text to press me and add the number of times the
        // button has been pressed.
        $otherButton->child->set_text('Press Me (' . 
                                      $otherButton->counter . ')'
                                      );
    }
}

// Create a new Window.
$window  = new GtkWindow();

// Create two new OnOff buttons.
$button1 = new OnOff('Press Me');
$button2 = new OnOff('Press Me');

// Create a new box to hold the buttons.
$box     = new GtkHBox();

// Set up the connections.
$button1->setUp($button2);
$button2->setUp($button1);

// Add both buttons to the box.
$box->add($button1);
$box->add($button2);

// Add the box to the window.
$window->add($box);

// Show the window and its contents.
$window->show_all();

// Set up the window to close cleanly.
$window->connect_simple('destroy', array('Gtk', 'main_quit'));

// Start the main loop.
Gtk::main();
?>