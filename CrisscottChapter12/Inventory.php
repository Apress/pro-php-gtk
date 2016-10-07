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
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>