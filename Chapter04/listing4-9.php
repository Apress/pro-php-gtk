<?php
class EchoEntry extends GtkEntry {

    public function __construct()
    {
        // Call the parent constructor.
        parent::__construct();
    }

    public function addKeyPress()
    {
        // Loop through the signal the GtkEntry listens for.
        foreach (GObject::signal_list_names('GtkEntry') as $signal) {
            if ($signal == 'key-press-event') {
                // If key-press-event is found, echo the name of the signal 
                // and return false.
                echo $signal . "\r\n";
                return false;
            }
        }
        // Make the entry listen for a key press.
        $this->add_events(Gdk::KEY_PRESS_MASK);

        // Create a signal handler for the key-press-event signal.
        $this->connect_simple('key-press-event', array($this, 'echoText'));

        return true;
    }

    public function echoText()
    {
        // Echo the current text of the entry.
        echo $this->get_text() . "\r\n";
    }
}

// Build some widgets
$window = new GtkWindow();
$vBox   = new GtkVBox();
$label  = new GtkLabel('Type something in the entry field');
$entry  = new EchoEntry();

// Pack them all together.
$window->add($vBox);
$vBox->add($label);
$vBox->add($entry);

// Set up the window to close cleanly.
$window->connect_simple('destroy', array('Gtk', 'main_quit'));

// Show the window and its contents.
$window->show_all();

// Add the key-press-event signal to the signals that the EchoEntry listens
// for.
$entry->addKeyPress();

// Start the main loop.
Gtk::main();
?>
