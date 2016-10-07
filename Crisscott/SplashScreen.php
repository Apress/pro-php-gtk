<?php
/**
 * Class to display messages during startup.
 */
class Crisscott_SplashScreen extends GtkWindow {

    /**
     * A label to display the status message.
     *
     * @access public
     * @var    object A GtkLabel
     */
    public $status;

    /**
     * Constructor.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        // Call the parent constructor.
        parent::__construct();

        // Turn off the window borders and title bar.
        $this->set_decorated(false);
        
        // Center the wiindow/
        //$this->set_position(Gtk::WIN_POS_CENTER);
		$this->set_uposition(Gdk::screen_width() / 2, Gdk::screen_height() / 2);
        /*
        // Set the background using a style.
        $style = $this->style->copy();
        // Make the background white.
        $style->bg[Gtk::STATE_NORMAL] = $style->white;
        // Set the style.
        $this->set_style($style);
        */
        // Set the name for rules in the RC file.
        $this->set_name('splash');

        // Fill the window with the needed pieces.
        $this->_populate();

        // Make the window stay above other windows.
        $this->set_keep_above(true);

        // Call a method when the class is shown.
        $this->connect_simple_after('show', array($this, 'startMainWindow'));

        // Parse the application's RC file.
        require_once 'Crisscott/MainWindow.php';
		Gtk::rc_parse(Crisscott_MainWindow::RC_PATH);
    }

    private function _populate()
    {
        // Create the needed peices.
        $frame     = new GtkFrame();
        $hBox      = new GtkHBox();
        $vBox      = new GtkVBox();
        $logoBox   = new GtkHBox();
        $statusBox = new GtkHBox();
        
        // Set the shadow type for the splash screen.
        $frame->set_shadow_type(Gtk::SHADOW_ETCHED_OUT);

        // Create a label for the title.
        $title = new GtkLabel('Crisscott Product Information Management System');
        // Mark up the text to change its color to dark blue.
        //$title = new GtkLabel('<span foreground="#0A0A6A"><b>Crisscott Product Information Management System</b></span>');
        // Tell the label widget that the text contains Pango markup.
        //$title->set_use_markup(true);

        // Create a label to display a status message.
        $this->status = new GtkLabel('Initializing Main Window');
        
        // Pack the logo and status boxes. Allow them to grow and
        // expand. Also give them some padding.
        $vBox->pack_start($logoBox,   true, true, 10);
        $vBox->pack_start($statusBox, true, true, 10);

        // Add the elements to the sub boxes.
        $logoBox->pack_start($title);
        $statusBox->pack_start($this->status);

        // Add a logo image.
        $logoImg = GtkImage::new_from_file('Crisscott/images/logo.png');

        // Finish packing everything.
        $hBox->pack_start($logoImg, false, false, 10);
        $hBox->pack_start($vBox,    false, false, 10);        
        $frame->add($hBox);

        $this->add($frame);
    }
    

    public function start()
    {
        // Show the splash screen.
        $this->show_all();
        // Start the main loop.
        gtk::main();
    }

    public function startMainWindow()
    {
        // Update the GUI.
        while (gtk::events_pending()) gtk::main_iteration();
        // Give the user enough time to at least see the message.
        require_once 'Crisscott/MainWindow.php';
        $main = new Crisscott_MainWindow();

        $this->status->set_text('Connecting to server...');
        while (gtk::events_pending()) gtk::main_iteration();

        if ($main->connectToServer()) {
            $this->status->set_text('Connecting to server... OK');
        }
        while (gtk::events_pending()) gtk::main_iteration();

        $this->status->set_text('Connecting to local database...');
        while (gtk::events_pending()) gtk::main_iteration();

        if ($main->connectToLocalDB()) {
            $this->status->set_text('Connecting to local database... OK');    
        }
        while (gtk::events_pending()) gtk::main_iteration();

        $main->show_all();

        $this->set_keep_above(false);
        $this->hide();
    }
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>