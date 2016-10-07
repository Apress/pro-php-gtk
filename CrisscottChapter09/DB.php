<?php
/**
 * A wrapper for PEAR::DB that makes DB a singleton.
 */
require_once 'DB.php';
class Crisscott_DB {

	public $db;
	public static $instance;

	protected function __construct()
	{

	}

	public static function singleton($dsn = null)
	{
		if (!isset(self::$instance)) {
			$class = __CLASS__;
			self::$instance = new $class;
			if (!isset($dsn)) {
				$dsn = 'pgsql://scott@unix+/crisscott';
			}
			self::$instance->db = DB::connect($dsn);
			if (PEAR::isError(self::$instance->db)) {
				throw new Exception('Failed to connect to database: ' . self::$instance->db->getMessage() . "\n" . self::$instance->db->getUserInfo());
			}
		}
		return self::$instance;
	}

	public function query($sql)
	{
		// Execute the query.
		$result = $this->db->query($sql);

		// Check for errors.
		if (PEAR::isError($result)) {
			throw new Exception($result->getMessage());
		} elseif ($result == DB_OK) {
			return true;
		} else {
			require_once 'Crisscott/DB/Result.php';
			return new Crisscott_DB_Result($result);
		}
	}

	public function prepare($sql)
	{
		$result = $this->db->prepare($sql);
		
		// Check for errors.
		if (PEAR::isError($result)) {
			throw new Exception($result->getMessage());
		} else {
			return $result;
		}
	}

	public function execute($handle, $values)
	{
		$result = $this->db->execute($handle, $values);

		// Check for errors.
		if (PEAR::isError($result)) {
			var_dump($result);
			throw new Exception($result->getMessage());
		} elseif ($result == DB_OK) {
			return true;
		} else {
			return new Crisscott_DB_Result($result);
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