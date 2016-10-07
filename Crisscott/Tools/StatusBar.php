<?php
/**
 * A widget that displays status messages such as process progress
 * and errors.
 *
 * @author     Scott Mattocks
 * @package    Crisscott PIMS
 * @subpackage Tools
 * @copyright  Copyright &copy; Scott Mattocks 2005
 * @version    @version@
 */
class Crisscott_Tools_StatusBar extends GtkStatusBar {

	public static $instance;

	public function __construct()
	{
		parent::__construct();
	}

	public static function singleton()
	{
		if (!isset(self::$instance)) {
			$class = __CLASS__;
			self::$instance = new $class;
		}
		return self::$instance;
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