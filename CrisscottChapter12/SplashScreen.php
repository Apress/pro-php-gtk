<?php
/**
 * Script to run our application.
 */
class Crisscott_SplashScreen extends GtkWindow {

	public $status;

	public function __construct()
	{
		parent::__construct();

		$this->set_decorated(false);
		
		//$this->set_size_request(300, 100);
		$this->set_position(Gtk::WIN_POS_CENTER);

		// Set the background.
		$style = $this->style->copy();
		$style->bg[Gtk::STATE_NORMAL] = $style->white;
		$this->set_style($style);

		$this->_populate();

		$this->set_keep_above(true);

		$this->connect_simple_after('show', array($this, 'startMainWindow'));
	}

	private function _populate()
	{
		$frame     = new GtkFrame();
		$hBox      = new GtkHBox();
		$vBox      = new GtkVBox();
		$logoBox   = new GtkHBox();
		$statusBox = new GtkHBox();
		
		$frame->set_shadow_type(Gtk::SHADOW_ETCHED_OUT);

		$logo = new GtkLabel('<span foreground="#000060"><b>Crisscott Product Information Management System</b></span>');
		$logo->set_use_markup(true);

		$this->status = new GtkLabel('Initializing Main Window');
		
		$vBox->pack_start($logoBox,   true, true, 10);
		$vBox->pack_start($statusBox, true, true, 10);

		$logoBox->pack_start($logo);
		$statusBox->pack_start($this->status);

		// Add a logo image.
		$logoImg = GtkImage::new_from_file('Crisscott/images/logo.png');

		$hBox->pack_start($logoImg, false, false, 10);
		$hBox->pack_start($vBox,    false, false, 10);		
		$frame->add($hBox);

		$this->add($frame);
	}
	

	public function start()
	{
		$this->show_all();
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