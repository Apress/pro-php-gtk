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
		$vb2 = new GtkVBox();
		$vb3 = new GtkVBox();
		$hb1 = new GtkHBox();
		$hb2 = new GtkHBox();
		
		$vb1->pack_start(new GtkFrame('MENU'), false, false, 0);
		$vb1->pack_start(new GtkFrame('TOOLBAR'), false, false, 0);
		$vb1->pack_start($hb1);
		$vb1->pack_start(new GtkFrame('STATUS'), false, false, 0);

		$hb1->pack_start($vb2, false, false, 0);
		$hb1->pack_start($vb3);

		$vb2->pack_start(new GtkFrame('PRODUCT TREE'));
		$vb2->pack_start(new GtkFrame('NEWS'));
		
		$vb2->set_size_request(150, -1);

		$vb3->pack_start($hb2, false, false, 0);
		$vb3->pack_start(new GtkFrame('EDITING PRODUCTS'));
		
		$hb2->pack_start(new GtkFrame('PRODUCT SUMMARY'));
		$hb2->pack_start(new GtkFrame('INVENTORY SUMMARY'));
		
		$hb2->set_size_request(-1, 150);

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