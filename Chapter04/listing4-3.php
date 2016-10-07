<?php
class ExtendedButton extends GtkButton {

    // Text for one state of the button.
    var $label1 = 'Click Me';
    // Text for the other state of the button.
    var $label2 = 'Thank You';

    public function __construct()
    {
        // Call the parent constructor with the first label.
        parent::__construct($this->label1);
    }

    public function changeLabel($button1, $button2)
    {
        // Change the label of the button that was pressed.
        $button1->child->set_text($this->label2);
        // Change the label of the other button.
        $button2->child->set_text($this->label1);
    }
}

// Start with four widgets.
$window    = new GtkWindow();
$buttonBox = new GtkHButtonBox();
$buttonA   = new ExtendedButton();
$buttonB   = new ExtendedButton();

// Create a signal handler for buttonA's clicked signal.
// Pass buttonB as the second argument for changeLabel.
$buttonA->connect('clicked', array($buttonA, 'changeLabel'), $buttonB);

// Create a signal handler for buttonB's clicked signal.
// Pass buttonA as the second argument for changeLabel.
$buttonB->connect('clicked', array($buttonB, 'changeLabel'), $buttonA);

// Set up the window to close cleanly.
$window->connect_simple('destroy', array('Gtk', 'main_quit'));

// Add the button box to the window.
$window->add($buttonBox);

// Add the buttons to the button box.
$buttonBox->add($buttonA);
$buttonBox->add($buttonB);

// Show the window and all of it children and grandchildren.
$window->show_all();
// Start the main loop.
Gtk::main();
?>
