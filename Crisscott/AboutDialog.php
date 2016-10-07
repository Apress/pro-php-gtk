<?php
class Crisscott_AboutDialog extends GtkAboutDialog {

    public function __construct()
    {
        // Call the parent constructor.
        parent::__construct();

	// Set the elements of the dialog.
	$this->init();
    }
  
    public function init()
    {
        // Set the logo image.
        $this->set_logo(GdkPixbuf::new_from_file('Crisscott/images/logo.png'));
	// Set the application name.
	$this->set_name('Crisscott PIMS');
	// Set the copyright notice.
	$this->set_copyright('2005 Crisscott, Inc.');
	// Set the license.
	$this->set_license(file_get_contents('Crisscott/license.txt'));
	// Set the URL to the Crisscott website.
	$this->set_website('http://www.crisscott.com/');
	// Set the version number.
	$this->set_version('1.0.0');
	// Set the description of the application.
	$this->set_comments('An application to manage product information ' . 
			    'for distribution through Crisscott.com');
    }
}
?>