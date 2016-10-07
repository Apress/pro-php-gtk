<?php
/**
 * A matrix table that allows the user to see a summary
 * of the inventory grouping products by category.
 *
 * @author     Scott Mattocks
 * @package    Crisscott PIMS
 * @subpackage Tools
 * @copyright  Copyright &copy; Scott Mattocks 2005
 * @version    @version@
 */
class Crisscott_Tools_CategorySummary extends GtkTable {

    /**
     * Keep track of the last row.
     * 
     * @access private
     * @var    integer
     */
    private $lastRow = 0;

    /**
     * Constructor. Sets up the table.
     *
     * @access public
     * @param  object $inventory An optional Crisscott_Inventory object.
     * @return void
     */
    public function __construct($inventory = null)
    {
        // Call the parent constructor. 
        // Don't pass any rows or columns because we want the
        // table to grow as we add data.
        parent::__construct();

        // Attach the column headers.
        $this->attachColHeaders();

        // If an inventory was passed, add the data to the table.
        if (!empty($inventory)) {
            $this->summarizeInventory($inventory);
        }
    }

    /**
     * Summarizes all the categories in the inventory.
     *
     * First clears out the table. Next re-attches the column
     * headers. Finally each category is added as its own row.
     * 
     * @access public
     * @param  object $inventory A Crisscott_Inventory instance.
     * @return void
     */
    public function summarizeInventory(Crisscott_Inventory $inventory)
    {
        // Clear out the table.
        $this->clear();
        
        // Re-attach the headers.
        $this->attachColHeaders();

        // Add a row for each category.
        foreach ($inventory->categories as $category) {
            $this->summarizeCategory($category);
        }
    }

    /**
     * Attaches column headers to the table.
     *
     * @access protected
     * @return void
     */
    protected function attachColHeaders()
    {
        require_once 'Crisscott/Category.php';
        foreach (Crisscott_Category::getCategorySpecs() as $key => $spec) {
            $label = new GtkLabel($spec);
            $label->set_angle(90);
            $label->set_alignment(.5, 1);

            // Leave the first cell empty.
            $this->attach($label, $key + 1, $key + 2, 0, 1, 0, GTK::FILL, 10, 10);
        }
        
        // Increment the last row.
        $this->lastRow++;
        
    }

    /**
     * Adds a row of data for the given category.
     *
     * @access public
     * @param  object $category A Crisscott_Category instance.
     * @return void
     */
    public function summarizeCategory(Crisscott_Category $category)
    {
        // First attach the category name.
        $nameLabel = new GtkLabel($category->name);
        $nameLabel->set_alignment(0, .5);
        $this->attach($nameLabel, 0, 1, $this->lastRow, $this->lastRow + 1, GTK::FILL, 0, 10, 10);
        
        // Next attach the spec values.
        foreach (Crisscott_Category::getCategorySpecs() as $key => $spec) {
            $value = $category->getSpecValueByName($spec);
            $this->attach(new GtkLabel($value), $key + 1, $key + 2, $this->lastRow, $this->lastRow + 1, 0, 0, 1, 1);
        }

        // Increment the last row.
        $this->lastRow++;
    }

    /**
     * Clears all cells of the table.
     *
     * @access protected
     * @return void
     */
    protected function clear()
    {
        foreach ($this->get_children() as $child) {
            $this->remove($child);
        }
        
        // Reset the last row.
        $this->lastRow = 0;
    }
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim: et tw=78
 * vi: ts=1 sw=1
 */
?>