<?php
class Crisscott_MainWindow extends GtkWindow {

	public function __construct()
	{
		parent::__construct();

		$this->set_size_request(500, 300);
		$this->set_position(Gtk::WIN_POS_CENTER);
		$this->set_title('Criscott PIMS');
		$this->maximize();
		
		$this->connect_object('destroy', array('Gtk', 'main_quit'));
	}
}

$main = new Crisscott_MainWindow();
$main->show_all();
Gtk::main();
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>