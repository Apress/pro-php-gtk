<?php
/**
 * A toolbar to initiate application actions.
 *
 * @author     Scott Mattocks
 * @package    Crisscott PIMS
 * @subpackage Tools
 * @copyright  Copyright &copy; Scott Mattocks 2005
 * @version    @version@
 */
class Crisscott_Tools_Toolbar extends GtkToolbar {

    public function __construct()
    {
        // Call the parent constructor. 
        parent::__construct();

        // Create the sub menus.
        $this->createButtons();
    }

    protected function createButtons()
    {
        // Create a button to make new products, categories and 
        // contributors.
        $new = new GtkMenuToolButton(GtkImage::new_from_stock(Gtk::STOCK_NEW, Gtk::ICON_SIZE_SMALL_TOOLBAR), 'New');
        $newMenu = new GtkMenu();

        // Create the menu items.
        $product = new GtkMenuItem('Product');
        $newMenu->append($product);
        $category = new GtkMenuItem('Category');
        $newMenu->append($category);
        $contrib = new GtkMenuItem('Contributor');
        $newMenu->append($contrib);

        // Set the menu as the menu for the new button.
        $newMenu->show_all();
        $new->set_menu($newMenu);
        
        // Add the button to the toolbar.
        $this->add($new);

        // Create the signal handlers for the new menu.
        require_once 'Crisscott/MainWindow.php';
        //$application = Crisscott_MainWindow::singleton();
        
        $new->connect_simple('clicked', array($application, 'newProduct'));
        $product->connect_simple('activate', array($application, 'newProduct'));
        $category->connect_simple('activate', array($application, 'newCategory'));
        $contrib->connect_simple('activate', array($application, 'newContrib'));

        // Create a toggle button that will connect to the database.
        //$database = GtkToggleToolButton::new_from_stock(Gtk::STOCK_CONNECT);
        //$database->set_label('Connect to Database');

        // Add the button to the toolbar.
        //$this->add($database);

        // Create a button that will transmit the inventory.
        $send = new GtkToggleToolButton();
        // Identify the button with a Crisscott logo.
        $send->set_icon_widget(GtkImage::new_from_file('Crisscott/images/menuItem.png'));
        // Label the button "Send".
        $send->set_label('Send');

        // Add the button to the toolbar.
        $this->add($send);

        // Connect a method to start and stop sending the data.
        $send->connect_simple('toggled', array($this, 'toggleTransmit'), $send);

        // Create two buttons for sorting the product list.
        $sortA = new GtkRadioToolButton(null, 'Ascending');
        $sortA->set_icon_widget(GtkImage::new_from_stock(Gtk::STOCK_SORT_ASCENDING, Gtk::ICON_SIZE_LARGE_TOOLBAR));
        $sortA->set_label('Sort Asc');

        $sortD = new GtkRadioToolButton($sortA, 'Descending');
        $sortD->set_icon_widget(GtkImage::new_from_stock(Gtk::STOCK_SORT_DESCENDING, Gtk::ICON_SIZE_LARGE_TOOLBAR));
        $sortD->set_label('Sort Desc');

        // Add the two buttons.
        $this->add($sortA);
        $this->add($sortD);
    }

    /**
     * Turns the inventory transmission on or off.
     *
     * @access public
     * @param  object $button A GtkToolButton.
     */
    public function toggleTransmit(GtkToolButton $button)
    {
        // Check to see if data is currently being transmitted.
        require_once 'Crisscott/Inventory.php';
        if (isset(Crisscott_Inventory::$transmitId)) {
            // Remove the idle.
            //Gtk::idle_remove(Crisscott_Inventory::$transmitId);
            Gtk::timeout_remove(Crisscott_Inventory::$transmitId);

            // Remove the handler id.
            Crisscott_Inventory::$transmitId = null;

            // Hide the dialog.
            require_once 'Crisscott/Tools/ProgressDialog.php';
            $dialog = Crisscott_Tools_ProgressDialog::singleton();
            $dialog->hide_all();
            
            // Turn of the button.
            $button->set_active(false);
        } else {
            // Create a new idle and capture the handler id.
            //Crisscott_Inventory::$transmitId = Gtk::idle_add(500, array('Crisscott_Inventory', 'transmitInventory'), $button);
            Crisscott_Inventory::$transmitId = Gtk::timeout_add(500, array('Crisscott_Inventory', 'transmitInventory'), $button);

            // Make sure the button is active.
            $button->set_active(true);
        }
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