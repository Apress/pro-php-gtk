<?php
/**
 * A class which manages data relating to products.
 *
 * @author     Scott Mattocks
 * @package    Crisscott PIMS
 * @copyright  Copyright &copy; Scott Mattocks 2005
 * @version    @version@
 */
class Crisscott_Product {
	
	/**
	 * Product name
	 *
	 * @access public
	 * @var    object
	 */
	public $name = '';

	/**
	 * Product type
	 *
	 * @access public
	 * @var    object
	 */
	public $type = '';

	/**
	 * The product category id.
	 *
	 * @access public
	 * @var    integer
	 */
	public $categoryId = 0;

	/**
	 * The product price.
	 *
	 * @access public
	 * @var    string
	 */
	public $price = 0;

	/**
	 * The product currency.
	 *
	 * @access public
	 * @var    string
	 */
	public $currency = 'USD';

	/**
	 * The product inventory.
	 *
	 * @access public
	 * @var    string
	 */
	public $inventory = 0;

	/**
	 * The product availability.
	 *
	 * @access public
	 * @var    string
	 */
	public $availability = true;

	/**
	 * The product width.
	 *
	 * @access public
	 * @var    string
	 */
	public $width = 0;

	/**
	 * The product height.
	 *
	 * @access public
	 * @var    string
	 */
	public $height = 0;

	/**
	 * The product depth.
	 *
	 * @access public
	 * @var    string
	 */
	public $depth = 0;
	/**
	 * The product weight.
	 *
	 * @access public
	 * @var    string
	 */
	public $weight = 0;

	/**
	 * The product description.
	 *
	 * @access public
	 * @var    string
	 */
	public $description = '';

	/**
	 * Product image path.
	 *
	 * @access public
	 * @var    string
	 */
	public $imagePath;

	public function __construct($productId = 0)
	{
		// Initialize the product.
		$this->init($productId);
	}
	
	protected function init($productId)
	{
		// Check the product id.
		if (!is_numeric($productId)) {
			throw new Exception('Cannot initialize product. Invalid productId: ' . $productId);
		} else {
			$this->productId = $productId;
		}
		
		require_once 'Crisscott/DB.php';
		$db = Crisscott_DB::singleton();

		$query = 'SELECT product_name, description, product_type, ';
		$query.= ' category_id, inventory, available, width, height, ';
		$query.= ' depth, weight, image_path, ';
		$query.= ' price ';
		$query.= 'FROM products ';
		$query.= ' LEFT JOIN product_price ';
		$query.= '  USING (product_id) ';
		$query.= 'WHERE product_id = ' . $this->productId . ' ';
		$query.= ' AND  (currency = \'USD\' OR currency IS NULL) ';

		$row = $db->query($query)->current();
		if (count($row)) {
			$this->name         = $row['product_name'];
			$this->description  = $row['description'];
			$this->type         = $row['product_type'];
			$this->categoryId   = $row['category_id'];
			$this->inventory    = $row['inventory'];
			$this->availability = $row['available'] == 't';
			$this->width        = $row['width'];
			$this->height       = $row['height'];
			$this->depth        = $row['depth'];
			$this->weight       = $row['weight'];
			$this->price        = $row['price'];
			$this->currency     = $row['currency'];
			$this->imagePath    = $row['image_path'];
		}
	}

	/**
	 * Checks to see if the values of the product are valid.
	 *
	 * @access public
	 * @return mixed  true or an array of the invalid fields.
	 */
	public function validate()
	{
		$invalidFields = array();

		// Check the easy fields first.
		// All of these fields must be numbers.
		$numbers = array('price',
						 'inventory',
						 'width',
						 'height',
						 'depth',
						 'weight'
						 );
		foreach ($numbers as $numField) {
			if (!is_numeric($this->$numField)) {
				$invalidFields[] = $numField;
			}
		}

		// Check the length of the product name.
		if (strlen($this->name) > 50 || strlen($this->name) < 1) {
			$invalidFields[] = 'name';
		}

		// Check that the availability is a boolean.
		if (!is_bool($this->availability)) {
			$invalidFields[] = 'availability';
		}

		// Check the product type.
		$validTypes = array('Shippable', 'Digital');
		if (!in_array($this->type, $validTypes)) {
			$invalidFields[] = 'type';
		}

		// Check the category.
		if (empty($this->categoryId) || !is_numeric($this->categoryId)) { 
			$invalidFields[] = 'category';
		}

		// Check the image path.
		if (!empty($this->imagePath) && !@is_readable($this->imagePath)) { 
			$invalidFields[] = 'image';
		}

		// The description can't really be invalid.
		if (count($invalidFields)) {
			return $invalidFields;
		} else {
			return true;
		}
	}
	
	public function save()
	{
		// Save the product information to the database.
		if (isset($this->productId) && $this->productId > 0) {
			return $this->updateProduct();
		} else {
			return $this->saveNewProduct();
		}
	}

	protected function updateProduct()
	{
		require_once 'Crisscott/DB.php';
		$db = Crisscott_DB::singleton();

		$query = 'UPDATE products ';
		$query.= 'SET ';
		$query.= ' product_name = ?, ';
		$query.= ' description  = ?, ';
		$query.= ' product_type = ?, ';
		$query.= ' category_id  = ?, ';
		$query.= ' inventory    = ?, ';
		$query.= ' available    = ?, ';
		$query.= ' width        = ?, ';
		$query.= ' height       = ?, ';
		$query.= ' depth        = ?, ';
		$query.= ' weight       = ?,  ';
		$query.= ' image_path   = ?  ';
		$query.= 'WHERE product_id = ? ';
		
		$stmt = $db->prepare($query);

		$prodArray = array(
						   $this->name,
						   $this->description,
						   $this->type,
						   $this->categoryId,
						   $this->inventory,
						   $this->availability,
						   $this->width,
						   $this->height,
						   $this->depth,
						   $this->weight,
						   $this->imagePath,
						   $this->productId
						   );

		$db->execute($stmt, $prodArray);

		return true;
	}

	protected function saveNewProduct()
	{
		require_once 'Crisscott/DB.php';
		$db = Crisscott_DB::singleton();

		$query = 'INSERT INTO products ';
		$query.= '(product_name, description, product_type, ';
		$query.= ' category_id, inventory, available, width, height, ';
		$query.= ' depth, weight, image_path) ';
		$query.= 'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ';

		$stmt = $db->prepare($query);

		$prodArray = array(
						   $this->name,
						   $this->description,
						   $this->type,
						   $this->categoryId,
						   $this->inventory,
						   $this->availability,
						   $this->width,
						   $this->height,
						   $this->depth,
						   $this->weight,
						   $this->imagePath
						   );


		$db->execute($stmt, $prodArray);

		// Get the new product id.
		$query = 'SELECT MAX(product_id) ';
		$query.= 'FROM products ';

		$this->productId = reset($db->query($query)->current());

		return true;
	}
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>