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
        $fixed = new GtkFixed();

        $menu = new GtkFrame('MENU');
        $menu->set_size_request(GDK::screen_width() - 10, -1);
        $fixed->put($menu, 0, 0);

        $toolbar = new GtkFrame('TOOLBAR');
        $toolbar->set_size_request(GDK::screen_width() - 10, -1);
        $fixed->put($toolbar, 0, 18);

        $pTree = new GtkFrame('PRODUCT TREE');
        $pTree->set_size_request(150, GDK::screen_height() / 2 - 54);
        $fixed->put($pTree, 0, 36);

        $news = new GtkFrame('NEWS');
        $news->set_size_request(150, GDK::screen_height() / 2 - 54);
        $fixed->put($news, 0, GDK::screen_height() / 2 - 18);

        $status = new GtkFrame('STATUS');
        $status->set_size_request(GDK::screen_width() - 10, -1);
        $fixed->put($status, 0, GDK::screen_height() - 72);

        $pSummary = new GtkFrame('PRODUCT SUMMARY');
        $pSummary->set_size_request(GDK::screen_width() / 2 - 90, 150);
        $fixed->put($pSummary, 152, 36);

        $iSummary = new GtkFrame('INVENTORY SUMMARY');
        $iSummary->set_size_request(GDK::screen_width() / 2 - 75, 150);
        $fixed->put($iSummary, GDK::screen_width() / 2 - 90 + 154, 36);

        $edit = new GtkFrame('EDIT PRODUCTS');
        $edit->set_size_request(GDK::screen_width() - 150, GDK::screen_height() - 262);
        $fixed->put($edit, 152, 190);
        
        $this->add($fixed);
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