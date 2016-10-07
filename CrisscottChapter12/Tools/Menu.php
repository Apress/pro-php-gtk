<?php
/**
 * A menu to initiate application actions.
 *
 * @author     Scott Mattocks
 * @package    Crisscott PIMS
 * @subpackage Tools
 * @copyright  Copyright &copy; Scott Mattocks 2005
 * @version    @version@
 */
class Crisscott_Tools_Menu extends GtkMenuBar {

    /**
     * The file menu item.
     *
     * @access public
     * @var    object
     */
    public $file;

    /**
     * The edit menu item.
     *
     * @access public
     * @var    object
     */
    public $edit;
    
    /**
     * The help menu item.
     *
     * @access public
     * @var    object
     */
    public $help;

    public function __construct()
    {
        // Call the parent constructor. 
        parent::__construct();

        // Add two menu items.
        $this->file = new GtkMenuItem('_File');
        $this->append($this->file);

        $this->edit = new GtkMenuItem('_Edit');
        $this->append($this->edit);

        $this->help = new GtkMenuItem('_Help');
        $this->append($this->help);

        // Create the sub menus.
        $this->createSubMenus();
    }

    protected function createSubMenus()
    {
        // Create the file menu and items.
        $fileMenu = new GtkMenu();
        $new      = new GtkImageMenuItem(Gtk::STOCK_NEW);
        $open     = new GtkImageMenuItem(Gtk::STOCK_OPEN);
        $send     = new GtkImageMenuItem('Send');
        $send->set_image(GtkImage::new_from_file('Crisscott/images/menuItemGrey.png'));
        $save     = new GtkMenuItem('Save');
        $quit     = new GtkMenuItem('Quit');
        
        // Add the four items to the file menu.
        $fileMenu->append($new);
        $fileMenu->append($open);
        $fileMenu->append($send);

        // Create a sub menu for the new item.
        $newMenu  = new GtkMenu();
        $product  = new GtkMenuItem('Product');
        $category = new GtkMenuItem('Category');
        $contrib  = new GtkMenuItem('Contributor');
        
        // Make the new menu detachable.
        $newMenu->append(new GtkTearoffMenuItem());
        $newMenu->append($product);
        $newMenu->append($category);
        $newMenu->append($contrib);

        $new->set_submenu($newMenu);
        
        // Add a separator.
        $fileMenu->append(new GtkSeparatorMenuItem());

        // Add some check items.
        $server   = new GtkCheckMenuItem('Connect to Server');
        $database = new GtkCheckMenuItem('Connect to Database');
        
        $fileMenu->append($server);
        $fileMenu->append($database);

        // Add a separator.
        $fileMenu->append(new GtkSeparatorMenuItem());

        // Add three noise levels.
        $quiet   = new GtkRadioMenuItem(null,   'Quiet');
        $normal  = new GtkRadioMenuItem($quiet, 'Normal');
        $verbose = new GtkRadioMenuItem($quiet, 'Verbose');

        $fileMenu->append($quiet);
        $fileMenu->append($normal);
        $fileMenu->append($verbose);

        // Add a separator.
        $fileMenu->append(new GtkSeparatorMenuItem());

        // Finish of the menu.
        $fileMenu->append($save);
        $fileMenu->append($quit);

        // Connect some signal handlers.
        $quit->connect_simple('activate', array('Crisscott_MainWindow', 'quit'));

        $editMenu = new GtkMenu();
        $product  = new GtkImageMenuItem('Current Product');
		
		$editMenu->append($product);

		// Make the product menu item do something.
		require_once 'Crisscott/Tools/ProductSummary.php';
		$summary = Crisscott_Tools_ProductSummary::singleton();

		$product->connect_simple('activate', array($summary, 'editProduct'));

        // Create the help menu and items.
        $helpMenu = new GtkMenu();
        $help     = new GtkMenuItem('Help');
        $about    = new GtkMenuItem('About');

        // Add both items to the help menu.
        $helpMenu->append($help);
        $helpMenu->append($about);

        // Make the two menus submenus for the menu items.
        $this->file->set_submenu($fileMenu);
        $this->edit->set_submenu($editMenu);
        $this->help->set_submenu($helpMenu);
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