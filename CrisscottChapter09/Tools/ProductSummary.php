<?php
/**
 * A set of widgets designed to display a summary of 
 * information for a given product. 
 *
 * The product summary is used to display information
 * about a product which has been selected frm the product 
 * tree. It gives a small amount of detail which should be
 * enough to allow the user to make a decision about 
 * whether or not to edit the product.
 *
 * The information shown is the product name, type, categorying,
 * price, and if available a small image.
 *
 * @author     Scott Mattocks
 * @copyright  Copyright &copy; Scott Mattocks
 * @package    Criscott_PIMS
 * @subpackage Tools
 * @version    @version@
 */
class Crisscott_Tools_ProductSummary extends GtkTable {

	/**
	 * Singleton instance of this object.
	 *
	 * @access public
	 * @var    object
	 */
	public static $instance;

	/**
	 * Product name label
	 *
	 * @access public
	 * @var    object
	 */
	public $productName;

	/**
	 * Product type label
	 *
	 * @access public
	 * @var    object
	 */
	public $productType;

	/**
	 * Product category label
	 *
	 * @access public
	 * @var    object
	 */
	public $productCategory;

	/**
	 * Product price label
	 *
	 * @access public
	 * @var    object
	 */
	public $productPrice;

	/**
	 * Product image widget
	 *
	 * @access public
	 * @var    object
	 */
	public $productImage;
	
	/**
	 * Constructor. Sets up container and product attribute label
	 * labels. If a product is passed in, the attribute labels 
	 * will be populated.
	 *
	 * @access public
	 * @param  object $product A Criscott_Product instance (optional).
	 * @return void
	 * @throws Criscott_Exception
	 */
	public function __construct($product = NULL)
	{
		// First call the parent constructor.
		// Create four rows and three columns.
		parent::__construct(4, 3);

		// Create labels for the attributes.
		$name  = new GtkLabel('Name');
		$type  = new GtkLabel('Type');
		$category = new GtkLabel('Category');
		$price = new GtkLabel('Price');
		
		// Set the width of each label to create a uniform appearance.
		$name->set_size_request(60, -1);
		$type->set_size_request(60, -1);
		$category->set_size_request(60, -1);
		$price->set_size_request(60, -1);

		// Next align each label within the parent container.
		$name->set_alignment(0, .5);
		$type->set_alignment(0, .5);
		$category->set_alignment(0, .5);
		$price->set_alignment(0, .5);

		// Attach them to the table.
		$expandFill = GTK::EXPAND|GTK::FILL;
		$this->attach($name,  0, 1, 0, 1, 0, $expandFill);
		$this->attach($type,  0, 1, 1, 2, 0, $expandFill);
		$this->attach($category, 0, 1, 2, 3, 0, $expandFill);
		$this->attach($price, 0, 1, 3, 4, 0, $expandFill);
		
		// Create the labels for the attributes.
		$this->productName  = new GtkLabel();
		$this->productType  = new GtkLabel();
		$this->productCategory = new GtkLabel();
		$this->productPrice = new GtkLabel();

		// Allow the labels to wrap.
		$this->productName->set_line_wrap(true);		
		$this->productType->set_line_wrap(true);		
		$this->productCategory->set_line_wrap(true);		
		$this->productPrice->set_line_wrap(true);		

		// Left align them.
		$this->productName->set_alignment(0, .5);
		$this->productType->set_alignment(0, .5);
		$this->productCategory->set_alignment(0, .5);
		$this->productPrice->set_alignment(0, .5);

		// Attach them to the table.
		$this->attach($this->productName,  1, 2, 0, 1);
		$this->attach($this->productType,  1, 2, 1, 2);
		$this->attach($this->productCategory, 1, 2, 2, 3);
		$this->attach($this->productPrice, 1, 2, 3, 4);

		// Attach a place holder for the image.
		$this->productImage = new GtkFrame('Image');
		// The image's size can be fixed.
		$this->productImage->set_size_request(100, 100);
		$this->attach($this->productImage, 2, 3, 0, 4, 0, $expandFill);

		// Now that everything is set up, summarize the product.
		require_once 'Crisscott/Product.php';
		$product = new Crisscott_Product();
		if (!empty($product)) {
			$this->displaySummary($product);
		}
	}

	/**
	 * Displays a summary of the given product.
	 *
	 * When given a valid product object, this method updates the 
	 * labels and image to match the values of the given product.
	 *
	 * @access public
	 * @param  object $product A Crisscott_Product instance.
	 * @return void
	 */
	public function displaySummary(Crisscott_Product $product)
	{
		// Set the attribute labels to the values of the
		// product.
		$this->productName->set_text($product->name);
		$this->productType->set_text($product->type);

		$inv = Crisscott_Inventory::singleton();
		$cat = $inv->getCategoryById($product->categoryId);
		$this->productCategory->set_text($cat->name);

		$this->productPrice->set_text($product->price);
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