<?php
class Editor {

    public $window;
    public $button;
    public $saved = false;

    public function __construct()
    {
        // Create a new window.
        $this->window = new GtkWindow();
        // Create a button with the label 'Save'.
        $this->button = new GtkButton('Save');

        // Add the button to the window.
        $this->window->add($this->button);

        // Set up the window to close cleanly after the other signal
        // handlers have been called.
        $this->window->connect_simple_after('destroy', array('Gtk', 'main_quit'));

        // Create a signal handler to check if the user has saved their
        // work before allowing the application to be closed.
        $this->window->connect_simple('delete-event', array($this, 'checkSaved'));

        // Create a signal handler that calls the saveFile method when the 
        // user clicks the Save button.
        $this->button->connect_simple('clicked', array($this, 'saveFile'));
    }

    public function start()
    {
        // Show the window and its contents.
        $this->window->show_all();

        // Start the main loop.
        Gtk::main();
    }

    public function saveFile()
    {
        // For now, just set the saved flag to true.
        $this->saved = true;
    }

    public function checkSaved()
    {
        // Check the value of the saved flag.
        if (!$this->saved) {
            // Echo a message saying the file wasn't saved.
            echo "File not saved.\n";
            // Return true to prevent the app from closing.
            return true;
        }
    }
}

// Create a new editor.
$editor = new Editor();

// Start the application and catch any exceptions.
try {
    $editor->start();
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
?>
