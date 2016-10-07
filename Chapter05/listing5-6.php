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

		$this->_populate();

		$this->set_keep_above(true);

		$this->connect_object('destroy', array('Gtk', 'main_quit'));
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