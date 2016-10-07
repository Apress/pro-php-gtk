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
		
		$this->set_size_request(300, 100);
		$this->set_position(Gtk::WIN_POS_CENTER);
		
		$this->set_keep_above(true);

		$this->_populate();

		$this->connect_object_after('show', array($this, 'startMainWindow'));
	}

	private function _populate()
	{
		$vBox      = new GtkVBox();
		$logoBox   = new GtkHBox();
		$statusBox = new GtkHBox();
		
		$logo = new GtkLabel('Crisscott Product Information Management System');
		$this->status = new GtkLabel('Loading...');
		
		$vBox->add($logoBox);
		$vBox->add($statusBox);
		
		$logoBox->add($logo);
		$statusBox->add($this->status);
		
		$this->add($vBox);
	}
	

	public function start()
	{
		$this->show_all();
		Gtk::main();
	}

	public function startMainWindow()
	{
		$main = new Crisscott_MainWindow();

		$this->status->set_text('Connecting to server...');
		while (Gtk::events_pending()) Gtk::main_iteration();

		if ($main->connectToServer()) {
			$this->status->set_text('Connecting to server... OK');
		}
		while (Gtk::events_pending()) Gtk::main_iteration();
		sleep(1);

		$this->status->set_text('Connecting to local database...');
		while (Gtk::events_pending()) Gtk::main_iteration();

		if ($main->connectToLocalDB()) {
			$this->status->set_text('Connecting to local database... OK');	
		}
		while (Gtk::events_pending()) Gtk::main_iteration();

		$main->show_all();
		while (Gtk::events_pending()) Gtk::main_iteration();
		sleep(1);
		
		$this->hide();
	}
}

class Crisscott_MainWindow extends GtkWindow {

	public function __construct()
	{
		parent::__construct();

		$this->set_size_request(500, 300);
		$this->set_position(Gtk::WIN_POS_CENTER);
		$this->set_title('Criscott PIMS');
		$this->maximize();
		
		$this->connect_object('destroy', array('gtk', 'main_quit'));
	}

	public function connectToServer()
	{
		sleep(1);
		return true;
	}

	public function connectToLocalDB()
	{
		sleep(1);
		return true;
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