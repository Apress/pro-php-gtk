<?php
/**
 * A class which manages data relating to product categories.
 *
 * @author     Scott Mattocks
 * @package    Crisscott PIMS
 * @copyright  Copyright &copy; Scott Mattocks 2005
 * @version    @version@
 */
class Crisscott_Category {
	
	public $categoryId;
	public $name     = '';
	public $specs    = array();
	public $products;

	/**
	 * Constructor. 
	 *
	 * @access public
	 * @return void
	 */
	public function __construct($categoryId)
	{
		// Assign the category id if possible.
		if (is_numeric($categoryId)) {
			$this->categoryId = $categoryId;
		} else {
			throw new Exception('Cannot instantiate category. Invalid categoryId: ' . $categoryId);
		}

		// Get the category name.
		require_once 'Crisscott/DB.php';
		$db = Crisscott_DB::singleton();
		
		$query = 'SELECT category_name ';
		$query.= 'FROM categories ';
		$query.= 'WHERE category_id = ' . $this->categoryId;

		$row = $db->query($query)->current();
		$this->name = $row['category_name'];

		// Get all of the products for this category.
		$this->_getProducts();

		// Set the specs for the category.
		$this->_setSpecs();
	}
	
	private function _getProducts()
	{
		require_once 'Crisscott/DB.php';
		$db = Crisscott_DB::singleton();

		$query = 'SELECT product_id, product_name, description, ';
		$query.= ' product_type, category_id, inventory, available, ';
		$query.= ' width, height, depth, weight, ';
		$query.= ' price ';
		$query.= 'FROM products ';
		$query.= ' LEFT JOIN product_price ';
		$query.= '  USING (product_id) ';
		$query.= 'WHERE category_id = ' . $this->categoryId;
		$query.= ' AND  (currency = \'USD\' OR currency IS NULL) ';
		
		$this->products = $db->query($query);
	}

	private function _setSpecs()
	{
		$this->specs = array();
		
		if (!$this->products->numRows()) {
			return;
		}

		$this->specs['Total Products'] = $this->products->numRows();
		
		$totalPrice = 0;
		foreach ($this->products as $product) {
			$totalPrice += $product['price'];
		}
		$this->specs['Avg. Price (USD)'] = number_format($totalPrice / $this->products->numRows(), 2);

		$totalWeight = 0;
		foreach ($this->products as $product) {
			$totalWeight += $product['weight'];
		}
		$this->specs['Avg. Weight (Ounces)'] = number_format($totalWeight / $this->products->numRows(), 2);
	}
	/**
	 * Returns a list of category specs.
	 * 
	 * @static
	 * @access public
	 * @return object An iterator of specs.
	 */
	public static function getCategorySpecs()
	{
		return array('Total Products', 'Avg. Price (USD)', 'Avg. Weight (Ounces)');
	}

	public function getSpecValueByName($spec)
	{
		return $this->specs[$spec];
	}

	public function getProducts()
	{
		return $this->products;
	}
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>