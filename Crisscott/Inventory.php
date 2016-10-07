<?php
/**
 * A class which manages the product inventory.
 *
 * @author     Scott Mattocks
 * @package    Crisscott PIMS
 * @subpackage Tools
 * @copyright  Copyright &copy; Scott Mattocks 2005
 * @version    @version@
 */
class Crisscott_Inventory {

    /**
     * Singleton instance of this object.
     *
     * @access public
     * @var    object
     */
    public static $instance;

    /**
     * An iterator of product categories.
     * 
     * @access public
     * @var    object
     */
    public $categories = array();

    /**
     * A static array of products.
     *
     * @static
     * @access public
     * @var    array
     */
    public static $products;

    /**
     * The last product transmitted.
     *
     * @static
     * @access public
     * @var    integer
     */
    public static $currentProduct = 0;

	/**
	 * The idle handler id for sending the data.
	 *
	 * @static
	 * @access public
	 * @var    integer
	 */
	public static $transmitId;

	/**
	 * A flag to indicate if produt information is being
	 * sent to the server.
	 *
	 * @static
	 * @access public
	 * @var    boolean
	 */
	public static $transmitting = false;

    /**
     * Constructor. 
     *
     * @access public
     * @return void
     */
    protected function __construct()
    {
        $this->refreshInventory();
    }

    public function refreshInventory()
    {
        // Get the categories.
        require_once 'Crisscott/DB.php';
        $db = Crisscott_DB::singleton();

        $query = 'SELECT category_id ';
        $query.= 'FROM categories ';

        require_once 'Crisscott/Category.php';
        foreach ($db->query($query) as $row) {
            $this->categories[] = new Crisscott_Category($row['category_id']);
        }
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

    /**
     * Returns the category with the given name.
     *
     * @access public
     * @param  string $category
     * @return object
     */
    public function getCategoryByName($category)
    {
        foreach ($this->categories as $cat) {
            if ($cat->name == $category) {
                return $cat;
            }
        }

        return null;
    }

    /**
     * Returns the category with the given id.
     *
     * @access public
     * @param  integer $category
     * @return object
     */
    public function getCategoryById($category)
    {
        foreach ($this->categories as $cat) {
            if ($cat->categoryId == $category) {
                return $cat;
            }
        }

        return null;
    }

    /**
     * Sends data to the Crisscott server on product at a time.
     *
     * @static
     * @access public
     * @return boolean true if there are more products to send.
     */
    public static function transmitInventory()
    {
        // Make sure the singleton instance has been instantiated.
        if (!isset(self::$instance)) {
            self::singleton();
        }

        // Create a SOAP client.
        require_once 'Crisscott/SOAPClient.php';
        $soap = new Crisscott_SOAPClient();
        
        // Collect all of the products.
        if (empty(self::$products)) {
            self::getAllProducts();
        }

        // Create a progress dialog for showing the progress.
        require_once 'Crisscott/Tools/ProgressDialog.php';
        $dialog = Crisscott_Tools_ProgressDialog::singleton('Sending Inventory');

		// Set the transmitting flag.
		self::$transmitting = true;

        // Show the progress dialog.
        $dialog->show_all();

        // We need to know the total to know the percentage complete.
        $total = count(self::$products);

        // Transmit the current product.
        $soap->sendProduct(self::$products[self::$currentProduct]);
        
        // Update the progress bar.
        $percentComplete = (self::$currentProduct + 1) / $total;
        $dialog->progress->set_fraction($percentComplete);
        
        // Display the percentage as a string over the bar.
        $percentComplete = round($percentComplete * 100, 0);
        $dialog->progress->set_text($percentComplete . '%');

		// Return true if there are more products to send.
		if (self::$products[self::$currentProduct] == end(self::$products)) {
			$dialog->destroy();

			// Set the transmitting flag.
			self::$transmitting = false;

			// Clean up the data.
			self::$products       = null;
			self::$currentProduct = 0;

			// Stop the callback from being called again. (timeout only)
			return false;
		} else {
			// Increment the currentProduct.
			++self::$currentProduct;

			return true;
		}
    }
    
    public static function getAllProducts()
    {
        self::$products = array();
        // Loop through categories in the inventory.
        foreach (self::$instance->categories as $category) {
            // Loop through the products in each category.
            foreach ($category->products as $product) {
                self::$products[] = $product;
            }
        }
    }
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>