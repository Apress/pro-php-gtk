<?php
class Crisscott_MainNotebook extends GtkNotebook {

	/**
	 * Singleton instance of this object.
	 *
	 * @access public
	 * @var    object
	 */
	public static $instance;

	public $pages = array();

	public function __construct()
	{
		// Call the parent constructor.
		parent::__construct();

		// Create an array of tab labels.
		$titles = array(
						'_Category Summary',
						'Contributor Edit',
						'Product _Edit',
						'Product _Details',
						'Supplier',
						'Preview',
						'Transmit',
						'News Story'
						);

		// Add a page for each element in the array and
		// put it in the pages array for easier access
		// later.
		$this->pages = array();
		foreach ($titles as $title) {
			$pageNum = $this->append_page(new GtkVBox(), new GtkLabel($title, true));
			$page    = $this->get_nth_page($pageNum);
			$this->pages[$title] = $page;
		}
		
		$this->set_show_tabs(false);

		// Add a productediting instance to the notebook.
		require_once 'Crisscott/Tools/ProductEdit.php';
		$this->pages['Product _Edit']->add(Crisscott_Tools_ProductEdit::singleton());

		// Add an category summary instance.
		require_once 'Crisscott/Tools/CategorySummary.php';
		require_once 'Crisscott/Inventory.php';
		$this->pages['_Category Summary']->add(new Crisscott_Tools_CategorySummary(Crisscott_Inventory::singleton()));
		
		// Add a contributoredit instance.
		require_once 'Crisscott/Tools/ContributorEdit.php';
		$this->pages['Contributor Edit']->add(new Crisscott_Tools_ContributorEdit());

		// Add the news article tool.
		require_once 'Crisscott/Tools/NewsArticle.php';
		$news = Crisscott_Tools_NewsArticle::singleton();
		$this->pages['News Story']->add($news);
	}

	/**
	 * Creates or returns a singleton instance of this class.
	 *
	 * @static
	 * @access public
	 * @return object
	 */
	public static function singleton()
	{
		if (!isset(self::$instance)) {
			$class = __CLASS__;
			self::$instance = new $class;
		}
		return self::$instance;
	}
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>