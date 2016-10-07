<?php
class Crisscott_MainNotebook extends GtkNotebook {

	public $pages = array();

	public function __construct()
	{
		// Call the parent constructor.
		parent::__construct();

		// Create an array of tab labels.
		$titles = array(
						'Product Summary',
						'Product Details',
						'Author Summary',
						'Author Details',
						'Supplier',
						'Preview',
						'Transmit',
						'Inventory Summary',
						'News Story'
						);

		// Add a page for each element in the array and
		// put it in the pages array for easier access
		// later.
		foreach ($titles as $title) {
			$pageNum = $this->append_page(new GtkVBox(), new GtkLabel($title));
			$this->pages[$title] = $this->get_nth_page($pageNum);
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