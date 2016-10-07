<?php
/**
 * A tool for displaying a news feed.
 *
 * This tool extends GtkTreeView and wraps XML_RSS.
 *
 * @author     Scott Mattocks
 * @package    Criscott PIMS
 * @subpackage Tools
 * @copyright  Copyright &copy; Scott Mattocks 2005
 * @version    @version@
 */
class Crisscott_Tools_NewsFeed extends GtkTreeView {

	/**
	 * Singleton instance of this object.
	 *
	 * @access public
	 * @var    object
	 */
	public static $instance;

	/**
	 * The RSS parser.
	 *
	 * @access public
	 * @var    object
	 */
	public $rss;

	/**
	 * Constructor. Creates the parser.
	 *
	 * @access public
	 * @param  mixed  $handle Optional feed handle. See XML_RSS.
	 * @return void
	 */
	public function __construct($handle = null)
	{
		// Call the parent constructor.
		parent::__construct();
		
		// Create the parser.
		require_once 'XML/RSS.php';
		$this->rss = new XML_RSS();

		// Set the input if given.
		if (isset($handle)) {
			$this->setInput($handle);
		}

		// Add the tree column.
		$this->addColumn();

		// Set up the selection to load a selected item.
		$selection = $this->get_selection();
		$selection->connect('changed', array($this, 'loadArticle'));
	}

	/**
	 * Sets the input that will be parsed.
	 * 
	 * @access public
	 * @param  mixed  $handle Feed handle. See XML_RSS.
	 * @return void
	 */
	public function setInput($handle)
	{
		$this->rss->setInput($handle);
	}

	/**
	 * Parses the feed and turns it into a list.
	 *
	 * @access public
	 * @return object
	 */
	public function createList()
	{
		// Parse the feed.
		$this->rss->parse();

		// Create a list store with four columns.
		$listStore = new GtkListStore(Gtk::TYPE_STRING,
									  Gtk::TYPE_STRING,
									  Gtk::TYPE_STRING,
									  Gtk::TYPE_LONG
									  );
		
		// Add a row for each item in the feed.
		foreach ($this->rss->getItems() as $item) {
			$rowData = array($item['title'], 
							 $item['dc:date'],
							 $item['description'],
							 Pango::WEIGHT_BOLD
							 );
			$listStore->append($rowData);
		}

		return $listStore;
	}
	
	/**
	 * Adds the list to the view to show the feed.
	 *
	 * @access public 
	 * @return void
	 */
	public function showList()
	{
		// Add the list to the view.
		$this->set_model($this->createList());
	}

	/**
	 * Adds the column to the view and sets the display
	 * properties.
	 *
	 * @access protected
	 * @return void
	 */
	protected function addColumn()
	{
		// Create the column.
		$column = new GtkTreeViewColumn();
		$column->set_title('News');

		// Create a cell renderer.
		$cellRenderer = new GtkCellRendererText();

		// Make the text ellipsize.
		$cellRenderer->set_property('ellipsize', Pango::ELLIPSIZE_END);

		// Pack the cell renderer.
		$column->pack_start($cellRenderer, true);
		$column->add_attribute($cellRenderer, 'text', 0);
		$column->add_attribute($cellRenderer, 'weight', 3);
		
		// Sort the column by date.
		$column->set_sort_column_id(1);
		
		// Add the column to the tree.
		$this->append_column($column);
	}

	/**
	 * Loads a selected news item.
	 *
	 * @access public
	 * @param  object $selection The selected row of the list.
	 * @return void
	 */
	public function loadArticle($selection)
	{
		// Unbold the selected item.
		list($model, $iter) = $selection->get_selected();
		$model->set($iter, 3, Pango::WEIGHT_NORMAL);
	
		// Get a singleton news article tool.
		require_once 'Crisscott/Tools/NewsArticle.php';
		$newsArticle = Crisscott_Tools_NewsArticle::singleton();
	
		// Set the article.
		$headline = $model->get_value($iter, 0);
		$body     = $model->get_value($iter, 2);
		$newsArticle->setArticle($headline, $body);

		// Bring the news story tab to the front.
		require_once 'Crisscott/MainNotebook.php';
		$notebook = Crisscott_MainNotebook::singleton();

		// Get the page index.
		$index = array_search('News Story', array_keys($notebook->pages));
		$notebook->set_current_page($index);
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