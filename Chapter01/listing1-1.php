<?php
/**
 * A simple Object Oriented example.
 */
class Ralph {
	
	public    $name   = 'Ralph';
	protected $suffix = 'Sr';

	public function __construct()
	{
		echo 'My name is ' . $this->name . ' ' . $this->suffix . ".\n";
	}

	public function giveBirth()
	{
		echo "It's a boy!\n";
		return new Ralph_Jr();
	}
}

class Ralph_Jr extends Ralph {

	protected $suffix = 'Jr';

	public function giveBirth()
	{
		throw new Exception('Ralph Jr. can\'t have kids!');
	}
}

$senior = new Ralph();
$junior = $senior->giveBirth();

try {
	$junior->giveBirth();
} catch (Exception $e) {
	echo $e->getMessage() . "\n";
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>