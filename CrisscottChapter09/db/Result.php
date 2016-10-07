<?php
require_once 'Crisscott/Iterator.php';
class Crisscott_DB_Result extends Crisscott_Iterator {

	/**
	 * The result set.
	 *
	 * @access private
	 * @var    object  A PEAR::DB_Result instance.
	 */
	private $result = NULL;
	
	protected $rowCount = 0;

	protected $key = 0;
	
	protected $current;
	
	public function __construct($result)
	{
		if (!$result instanceof DB_Result) {
			throw new Exception('Invalid result set.');
		} else {
			$this->result   = $result;
			$this->key      = 0;
			$this->rowCount = $this->result->numRows();
		}
	}
	
	public function current()
	{
		return ($this->current = $this->result->fetchRow(DB_FETCHMODE_ASSOC,$this->key));
	}
	
	public function goToPrev()
	{
		if (--$this->key >= 0) {
			return ($this->current = $this->result->fetchRow(DB_FETCHMODE_ASSOC,$this->key));
		} else {
			return false;
		}
	}
	
	public function goToNext()
	{
		if (++$this->key < $this->rowCount) {
			return ($this->current = $this->result->fetchRow(DB_FETCHMODE_ASSOC,$this->key));
		} else {
			return false;
		}
	}
	
	public function valid()
	{
		return $this->key < $this->rowCount;
	}

	public function numRows()
	{
		return $this->rowCount;
	}
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>