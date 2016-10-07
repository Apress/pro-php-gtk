<?php
/**
 * Script to run our application.
 */
class Crisscott_SplashScreen extends GtkWindow {

	// A widget to show a status message.
	public $status;

	public function __construct()
	{
		// Call the parent constructor.
		parent::__construct();

		// Turn off the window borders.
		$this->set_decorated(false);

		// Set the background color to white.
		$style = $this->style->copy();
		$style->bg[Gtk::STATE_NORMAL] = $style->white;
		$this->set_style($style);

		// Call a helper method to create the pieces of the splash screen.
		$this->_populate();

		// Set up the application to shutdown cleanly.
		$this->connect_object('destroy', array('Gtk', 'main_quit'));
	}

	private function _populate()
	{
		// Create the containers. 
		$frame     = new GtkFrame();
		$hBox      = new GtkHBox();
		$vBox      = new GtkVBox();
		
		// Set the shadow type.
		$frame->set_shadow_type(Gtk::SHADOW_ETCHED_OUT);

		// Create title label.
		$titleText = '<span foreground="#000060"><b>Crisscott ' . 
			'Product Information Management System</b></span>';
		$title = new GtkLabel($titleText);
		// Use markup to make the label blue and bold.
		$title->set_use_markup(true);

		// Create an initial status message. 
		$this->status = new GtkLabel('Initializing Main Window');
		
		// Stack the labels vertically.
		$vBox->pack_start($title,        true, true, 10);
		$vBox->pack_start($this->status, true, true, 10);

		// Add a logo image.
		$logoImg = GtkImage::new_from_file('Crisscott/images/logo.png');

		// Put the image and the first box next to each other.
		$hBox->pack_start($logoImg, false, false, 10);
		$hBox->pack_start($vBox,    false, false, 10);

		// Put everything inside a frame.
		$frame->add($hBox);

		// Put the frame inside the window.
		$this->add($frame);
	}
	

	public function start()
	{
		$this->show_all();
		Gtk::main();
	}
}

$splash = new Crisscott_SplashScreen();
$splash->start();
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>