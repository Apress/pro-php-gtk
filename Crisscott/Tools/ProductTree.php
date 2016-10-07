<?php
/**
 * A widget designed to show a tree of product information.
 * 
 * This tool creates a model of the product data where the
 * categories are the top level rows and the products are
 * children for those rows. When a product is selected it
 * is passed to the ProductSummary tool. 
 *
 * @author     Scott Mattocks
 * @copyright  Copyright &copy; Scott Mattocks
 * @package    Criscott_PIMS
 * @subpackage Tools
 * @version    @version@
 */
class Crisscott_Tools_ProductTree extends GtkTreeView {

	/**
	 * Singleton instance of this object.
	 *
	 * @access public
	 * @var    object
	 */
	public static $instance;

	public function __construct()
	{
		// Call the parent constructor.
		parent::__construct();

		// Add/update the model.
		$this->updateModel();
	}		

	public function updateModel()
	{
		// Create and set the model.
		$this->set_model($this->_createModel());

		// Next set up the view column and cell renderer.
		$this->_setupColumn();

		// Finally, set up the selection.
		$this->_setupSelection();
	}

	private function _createModel()
	{
		// Set up the model.
		// Each row should have the row name and the prouct_id.
		// If the row is a category the product_id should be zero.
		$model = new GtkTreeStore(Gtk::TYPE_STRING, Gtk::TYPE_LONG);

		// Get a singleton of the Inventory object.
		require_once 'Crisscott/Inventory.php';
		$inventory = Crisscott_Inventory::singleton();

		// Add all of the categories.
        foreach ($inventory->categories as $category) {
			$catIter = $model->append(null, array($category->name, 0));
			// Add all of the products for the category.
			foreach ($category->getProducts() as $product) {
				$model->append($catIter, array($product['product_name'], $product['product_id']));
			}
		}

		return $model;
	}

	private function _setupColumn()
	{
		// Add the name column.
		$column = new GtkTreeViewColumn();
		$column->set_title('Products');

		// Create a renderer for the column.
		$cellRenderer = new GtkCellRendererText();
		$column->pack_start($cellRenderer, true);
		$column->add_attribute($cellRenderer, 'text', 0);

		// Make the text ellipsize.
		$cellRenderer->set_property('ellipsize', Pango::ELLIPSIZE_END);

		// Make the column sort on the product name.
		$column->set_sort_column_id(0);

		// Insert the column.
		$this->insert_column($column, 0);
	}
	
	private function _setupSelection()
	{
		// Get the selection object.
		$selection = $this->get_selection();
		
		// Set the selection to browse mode.
		$selection->set_mode(Gtk::SELECTION_BROWSE);

		// Create a signal handler to process the selection.
		$selection->connect('changed', array($this, 'sendToSummary'));
	}
	
	public function sendToSummary($selection)
	{
		// Get the selected row.
		list($model, $iter) = $selection->get_selected();
		
		// Create a product.
		require_once 'Crisscott/Product.php';
		$product = new Crisscott_Product($model->get_value($iter, 1));

		// Get the singleton product summary.
		require_once 'Crisscott/Tools/ProductSummary.php';
		$productSummary = Crisscott_Tools_ProductSummary::singleton();
		$productSummary->displaySummary($product);
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