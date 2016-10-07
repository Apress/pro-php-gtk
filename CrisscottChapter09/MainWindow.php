<?php
class Crisscott_MainWindow extends GtkWindow {

	private $productSummary;

	public function __construct()
	{
		parent::__construct();

		$this->set_size_request(500, 300);
		$this->set_position(Gtk::WIN_POS_CENTER);
		$this->set_title('Criscott PIMS');
		
		$this->_populate();

		$this->maximize();
		$this->set_icon_from_file('Crisscott/images/logo.png');

		$this->connect_simple('destroy', array('gtk', 'main_quit'));
	}

	private function _populate()
	{
		$table = new GtkTable(5, 3);
		
		$expandFill = GTK::EXPAND|GTK::FILL;

		$table->attach(new GtkFrame('MENU'),    0, 2, 0, 1, $expandFill, 0, 0, 0);
		$table->attach(new GtkFrame('TOOLBAR'), 0, 2, 1, 2, $expandFill, 0, 0, 0);

		require_once 'Crisscott/Tools/ProductTree.php';
		$productTree = Crisscott_Tools_ProductTree::singleton();
		$productTree->set_size_request(150, 150);

		$table->attach($productTree, 0, 1, 2, 3, 0, $expandFill, 0, 0);

		require_once 'Crisscott/Tools/NewsFeed.php';
		$feed = 'chapter9/news.rss';
		$news = Crisscott_Tools_NewsFeed::singleton();
		$news->setInput($feed);
		$news->showList();
		$news->set_size_request(150, -1);

		$table->attach($news, 0, 1, 3, 4, 0, $expandFill, 0, 0);

		$table2 = new GtkTable(2, 2);
		
		$productSummary = new GtkFrame('PRODUCT SUMMARY');
		$productSummary->set_size_request(-1, 150);

		// Add the product summary tool.
		require_once 'Crisscott/Tools/ProductSummary.php';
		$this->productSummary = Crisscott_Tools_ProductSummary::singleton();
		$productSummary->add($this->productSummary);

		$table2->attach($productSummary, 0, 1, 0, 1, $expandFill, 0, 1, 1);

		$inventorySummary = new GtkFrame('INVENTORY SUMMARY');
		$inventorySummary->set_size_request(-1, 150);

		$table2->attach($inventorySummary, 1, 2, 0, 1, $expandFill, 0, 1, 1);

		require_once 'Crisscott/MainNotebook.php';
		$this->mainNotebook = Crisscott_MainNotebook::singleton();
		$table2->attach($this->mainNotebook, 0, 2, 1, 2, $expandFill, $expandFill, 1, 1);

		$table->attach($table2, 1, 2, 2, 4, $expandFill, $expandFill, 0, 0);

		require_once 'Crisscott/Tools/StatusBar.php';
		$table->attach(Crisscott_Tools_StatusBar::singleton(),  0, 2, 4, 5, $expandFill, 0, 0, 0);

		$this->add($table);
	}

	public function connectToServer()
	{
		sleep(1);
	}

	public function connectToLocalDB()
	{
		sleep(1);
	}
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>