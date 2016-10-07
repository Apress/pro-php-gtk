<?php
class Crisscott_MainWindow extends GtkWindow {

	/**
	 * A constant that defines the path to the RC file.
	 * 
	 * @const string
	 */
	const RC_PATH = 'Crisscott/.crisscottrc';
    private $productSummary;

    static public $modified = false;
    static public $sent     = true;

    public function __construct()
    {
        parent::__construct();

        $this->set_size_request(500, 300);
        $this->set_position(Gtk::WIN_POS_CENTER);
        $this->set_title('Criscott PIMS');
        
        $this->_populate();

        $this->maximize();
        $this->set_icon_from_file('Crisscott/images/logo.png');

        $this->connect_simple('destroy', array('gtk', 'main_quit'));

		// Parse the RC file that will change the look and 
		// feel of the application.
		//Gtk::rc_parse(self::RC_PATH);
    }

    private function _populate()
    {
        $table = new GtkTable(5, 3);
        
        $expandFill = GTK::EXPAND|GTK::FILL;

        require_once 'Crisscott/Tools/Menu.php';
        $table->attach(new Crisscott_Tools_Menu(), 0, 2, 0, 1, $expandFill, 0, 0, 0);

        require_once 'Crisscott/Tools/Toolbar.php';
        $table->attach(new Crisscott_Tools_Toolbar(), 0, 2, 1, 2, $expandFill, 0, 0, 0);

        // Get a singleton instance of the product tree.
        require_once 'Crisscott/Tools/ProductTree.php';
        $productTree = Crisscott_Tools_ProductTree::singleton();

        // Create a scrolled window for the product tree.
        $scrolledWindow = new GtkScrolledWindow();

        // Set the size of the scrolled window.
        $scrolledWindow->set_size_request(150, 150);

        // Set the scrollbar policy.
        $scrolledWindow->set_policy(Gtk::POLICY_NEVER, Gtk::POLICY_AUTOMATIC);

        // Add the product tree to the scrolled window.
        $scrolledWindow->add($productTree);

        // Attach the scrolled window to the tree.
        $table->attach($scrolledWindow, 0, 1, 2, 3, 0, $expandFill, 0, 0);

        require_once 'Crisscott/Tools/NewsFeed.php';
        $feed = 'chapter9/news.rss';
        $news = Crisscott_Tools_NewsFeed::singleton();
        $news->setInput($feed);
        $news->showList();
        $news->set_size_request(150, -1);

        $table->attach($news, 0, 1, 3, 4, 0, $expandFill, 0, 0);

        $table2 = new GtkTable(2, 2);
        
        $productSummary = new GtkFrame('PRODUCT SUMMARY');
        $productSummary->set_size_request(-1, 150);

        // Add the product summary tool.
        require_once 'Crisscott/Tools/ProductSummary.php';
        $this->productSummary = Crisscott_Tools_ProductSummary::singleton();
        $productSummary->add($this->productSummary);

        $table2->attach($productSummary, 0, 1, 0, 1, $expandFill, 0, 1, 1);

        $inventorySummary = new GtkFrame('INVENTORY SUMMARY');
        $inventorySummary->set_size_request(-1, 150);

        $table2->attach($inventorySummary, 1, 2, 0, 1, $expandFill, 0, 1, 1);

        require_once 'Crisscott/MainNotebook.php';
        $this->mainNotebook = Crisscott_MainNotebook::singleton();
        $table2->attach($this->mainNotebook, 0, 2, 1, 2, $expandFill, $expandFill, 1, 1);

        $table->attach($table2, 1, 2, 2, 4, $expandFill, $expandFill, 0, 0);

        require_once 'Crisscott/Tools/StatusBar.php';
        $table->attach(Crisscott_Tools_StatusBar::singleton(),  0, 2, 4, 5, $expandFill, 0, 0, 0);

        $this->add($table);
    }

    public function connectToServer()
    {
        sleep(1);
    }

    public function connectToLocalDB()
    {
        sleep(1);
    }

    static public function quit()
    {
        // Check to see if the data has been modified
        // or sent. If it is modified or not sent, don't
        // exit.
        if (self::$modified || !self::$sent) {
            // Create a dialog to make sure the user wants to quit.
            // Set up the options for the dialog
            $dialogOptions = 0;
            // Make the dialog modal.
            $dialogOptions = $dialogOptions | Gtk::DIALOG_MODAL;
            // Destroy the dialog if the parent window is destroyed.
            $dialogOptions = $dialogOptions | Gtk::DIALOG_DESTROY_WITH_PARENT;
            // Don't show a horizontal separator between the two parts.
            $dialogOptions = $dialogOptions | Gtk::DIALOG_NO_SEPARATOR;
            
            // Set up the buttons.
            $dialogButtons = array();
            // Add a stock "No" button and make its respnse "No".
            $dialogButtons[] = Gtk::STOCK_NO;
            $dialogButtons[] = Gtk::RESPONSE_NO;
            // Add a stock "Yes" button and make its respnse "Yes".
            $dialogButtons[] = Gtk::STOCK_YES;
            $dialogButtons[] = Gtk::RESPONSE_YES;
            
            // Create the dialog.
            $dialog = new GtkDialog('Confirm Exit', $window, $dialogOptions);//, $dialogButtons);
            
            // Add the buttons to the action area.
            $noButton  = GtkButton::new_from_stock(Gtk::STOCK_NO);
            $yesButton = GtkButton::new_from_stock(Gtk::STOCK_YES);

            $dialog->add_action_widget($noButton,  Gtk::RESPONSE_NO);
            $dialog->add_action_widget($yesButton, Gtk::RESPONSE_YES);

            // Add an image and a question to the top part of the dialog.
            $hBox = new GtkHBox();
            $dialog->vbox->pack_start($hBox);

            // Pack a stock warning image.
            $warning = GtkImage::new_from_stock(Gtk::STOCK_DIALOG_WARNING, Gtk::ICON_SIZE_DIALOG);
            $hBox->pack_start($warning, false, false, 5);

            $message = "The current inventory has not been saved\n";
            $message.= "and transmitted to Crisscott. Are you sure\n";
            $message.= "you would like to quit?\n";

            $label   = new GtkLabel($message);
            $label->set_line_wrap();

            $hBox->pack_start($label);

            // Show the top part of the dialog (The bottom
            // will be shown automatically).
            $dialog->vbox->show_all();
            
            // Run the dialog and check the response.
            if ($dialog->run() !== Gtk::RESPONSE_YES) {
                $dialog->destroy();
                return false;
            }
        }
        // Exit the application.
        gtk::main_quit();
        return true;
    }

    public function open()
    {
        // Create the file selection dialog.
        $fileSelection = new GtkFileSelection('Open');
        
        // Make sure that only one file is selected.
        $fileSelection->set_select_multiple(false);

        // Filter the files for XML files.
        $fileSelection->complete('*.xml');
        
        // Show the dialog and run it.
        $fileSelection->show_all();
        if ($fileSelection->run() == Gtk::RESPONSE_OK) {
            // Make sure the file exists.
            if (@is_readable($fileSelection->get_filename())) {
                // Load the file.
                self::loadFile($fileSelection->get_filename());
            } else {
                // Pop up a dialog warning...
                // ...
                // Run this method again.
                self::open();
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
