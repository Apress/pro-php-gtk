<?php
class Uninstall extends GtkDialog {
    
    public function __construct()
    {
        // Set up the flags for the dialog.
        $flags = Gtk::DIALOG_NO_SEPARATOR;
        
        // Set up the buttons for the action area.
        // We only want one button, close.
        $buttons = array(Gtk::STOCK_NO, Gtk::RESPONSE_NO,
                         Gtk::STOCK_YES, Gtk::RESPONSE_YES);
        
        // Call the parent constructor.
        parent::__construct('Uninstall Crisscott PIMS', null, $flags, $buttons);
        
        // Any response should close the dialog.
        $this->connect_simple('response', array($this, 'destroy'));
        // The static properties must also be unset.
        $this->connect_simple('destroy', array($this, 'destroy'));
        
        // Add an image and a question to the top part of the dialog.
        $hBox = new GtkHBox();
        $dialog->vbox->pack_start($hBox);
        
        // Pack a stock warning image.
        $warning = GtkImage::new_from_stock(Gtk::STOCK_DIALOG_WARNING,
                                            Gtk::ICON_SIZE_DIALOG);
        $hBox->pack_start($warning, false, false, 5);
        
        // Add a message
        $message = new GtkLabel('Are you sure you want to remove the ' . 
                    'Crisscott PIMS application?');
        $message->set_line_wrap();
        $hBox->pack_start($message);
    }

    public function run()
    {
        // Show the dialog.
        $this->show_all();

        // Run the dialog and wait for the response.
        if (parent::run() === Gtk::RESPONSE_YES) {
            // Uninstall the application.
            $this->_doUninstall();
        }
    }

    private function _doUninstall()
    {
        // Create a config object.
        require_once 'PEAR/Config.php';
        $config = new PEAR_Config();
        
        // Create a command object.
        require_once 'PEAR/Command.php';
        $uninstall = PEAR_Command::factory('uninstall', $config);

        // Uninstall the application.
        $result = $uninstall->doInstall('uninstall', array(),
                                        array('crisscott/Crisscott_PIMS'));
        
        // Report any errors.
        if (PEAR::isError($result)) {
            echo $result->getMessage() . "\n";
        }
    }
}

// Create an uninstall instance
$unInst = new UnInstall();

// Run the dialog.
$unInst->run();
?>