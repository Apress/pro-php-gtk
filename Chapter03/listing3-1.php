<?php
/**
 * A PHP implementation of GtkObject.
 */
class GtkObject {

	private $flags;
	private $refCounter;

	public function destroy()
	{
		unset($this);
	}

	public function flags()
	{
		return $this->flags;
	}

	public function set_flags($flags)
	{
		$this->flags = $this->flags | $flags;
	}

	public function sink()
	{
		if (--$this->refCounter < 1) {
			$this->destroy();
		}
	}

	public function unset_flags($flags)
	{
		$this->flags = $this->flags & ~$flags;
	}
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>