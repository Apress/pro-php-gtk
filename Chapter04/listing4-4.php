<?php
/**
 * Reacting to events.
 */
class ExtendedContainer extends GtkHBox {

	public $counter = 0;

	public function __construct()
	{
		parent::__construct();
	}

	public function incCounter()
	{
		echo ++$this->counter . "\n";
	}

	public function doubleCounter()
	{
		$this->counter *= 2;
		echo $this->counter . "\n";
	}

	public function checkLimit($child)
	{
		if ($this->counter > 1) {
			echo "Whoa! Too many children.\n";
			$this->remove($child);
			$this->counter--;
		}
		return;
	}
}

$container = new ExtendedContainer();
$button    = new GtkButton();

$container->connect_object('add', array($container, 'incCounter'));
$container->connect_object_after('add', array($container, 'checkLimit'));

$container->add($button);
$container->add(new GtkLabel('label'));
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>