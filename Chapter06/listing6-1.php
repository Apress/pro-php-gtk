<?php
class Crisscott_MainWindow extends GtkWindow {

	public function __construct()
	{
		parent::__construct();

		$this->set_size_request(500, 300);
		$this->set_position(Gtk::WIN_POS_CENTER);
		$this->set_title('Criscott PIMS');
		
		$this->_populate();

		$this->maximize();
		
		$this->connect_object('destroy', array('Gtk', 'main_quit'));
	}

	private function _populate()
	{
		$vb1 = new GtkVBox();
		
		$vb1->pack_start(new GtkFrame('MENU'), false, false, 0);
		$vb1->pack_start(new GtkFrame('TOOLBAR'), false, false, 0);
		$vb1->pack_start(new GtkFrame('MAIN'), true, true, 0);
		$vb1->pack_start(new GtkFrame('STATUS'), false, false, 0);
		
		$this->add($vb1);
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