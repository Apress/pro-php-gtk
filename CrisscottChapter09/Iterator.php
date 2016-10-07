<?php
abstract class Crisscott_Iterator implements Iterator
{
	protected $key;
	protected $current;

	public function rewind() {
		$this->key = 0;
	}

	public function current() {
		return $this->current;
	}

	public function key() {
		return $this->key;
	}
	
	public function next() {
      return $this->goToNext();
	}


	abstract protected function goToPrev();

	abstract protected function goToNext();

	public function valid() {
		return isset($this->current);
	}
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>