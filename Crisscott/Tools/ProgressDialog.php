<?php
/**
 * A dialog window that show a progress bar.
 *
 * @author     Scott Mattocks
 * @package    Crisscott PIMS
 * @subpackage Tools
 * @copyright  Copyright &copy; Scott Mattocks 2005
 * @version    @version@
 */
class Crisscott_Tools_ProgressDialog extends GtkDialog {

    /**
     * Singleton instance of this object.
     *
     * @access public
     * @var    object
     */
    public static $instance;

    /**
     * The progress bar.
     *
     * @access public
     * @var    object
     */
    public $progress;

    /**
     * Constructor. 
     *
     * @access public
     * @param  string $title  The dialog window's title.
     * @param  object $parent The parent window.
     * @return void
     */
    public function __construct($title = 'Progress', $parent = null)
    {
        // Set up the flags for the dialog.
        $flags = Gtk::DIALOG_NO_SEPARATOR;

        // Set up the buttons for the action area.
        // We only want one button, close.
        $buttons = array(Gtk::STOCK_CLOSE, Gtk::RESPONSE_CLOSE);

        // Call the parent constructor.
        parent::__construct($title, $parent, $flags, $buttons);

        // Any response should close the dialog.
        $this->connect_simple('response', array($this, 'destroy'));
		// The static properties must also be unset.
		$this->connect_simple('destroy', array($this, 'cleanUp'));

        // Add a progress bar.
        $this->progress = new GtkProgressBar();
        $this->vbox->pack_start($this->progress);
    }

    /**
     * Creates or returns a singleton instance of this class.
     *
     * @static
     * @access public
     * @param  string $title  The dialog window's title.
     * @param  object $parent The parent window.
     * @return object
     */
    public static function singleton($title = 'Progress', $parent = null)
    {
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class($title, $parent);
        }
        return self::$instance;
    }

	public function cleanUp()
	{
		// Unset the static instance variable.
		self::$instance = null;
	}
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>