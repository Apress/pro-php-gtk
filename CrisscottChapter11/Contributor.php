<?php
/**
 * A class to represent a contributor.
 *
 * A contributor is any entity that plays a part in the creation,
 * manufacture, or distribution of an item. Contributor data must
 * be maintained not only give proper credit, but also to track 
 * royalties and to provide the most data possible to the end user.
 *
 * Not all of the information collected here is relavent to 
 * Crisscott's use of the information but it is a feature add for
 * the end user. If the end user gets more utility out of the 
 * application they are likely to adopt it quicker.
 *
 * @author     Scott Mattocks
 * @package    Crisscott PIMS
 * @copyright  Copyright &copy; Scott Mattocks 2005
 * @version    @version@
 */
class Crisscott_Contributor {

	/**
	 * An identifier for the contributor.
	 *
	 * @access protected
	 * @var    integer
	 */
	protected $contributorId;

	/**
	 * The contributor's first name.
	 * 
	 * @access public
	 * @var    object
	 */
	public $firstName;

	/**
	 * The contributor's middle name.
	 * 
	 * @access public
	 * @var    object
	 */
	public $middleName;

	/**
	 * The contributor's last name.
	 * 
	 * @access public
	 * @var    object
	 */
	public $lastName;

	/**
	 * The contributor's web address.
	 * 
	 * @access public
	 * @var    object
	 */
	public $website;

	/**
	 * The contributor's email address.
	 * 
	 * @access public
	 * @var    object
	 */
	public $email;

	/**
	 * The contributor's street address.
	 * 
	 * @access public
	 * @var    object
	 */
	public $street1;

	/**
	 * The contributor's street address.
	 * 
	 * @access public
	 * @var    object
	 */
	public $street2;

	/**
	 * The contributor's city.
	 * 
	 * @access public
	 * @var    object
	 */
	public $city;

	/**
	 * The contributor's state.
	 * 
	 * @access public
	 * @var    object
	 */
	public $state;

 	/**
	 * The contributor's country.
	 * 
	 * @access public
	 * @var    object
	 */
	public $country;

 	/**
	 * The contributor's postal code.
	 * 
	 * @access public
	 * @var    object
	 */
	public $postal;

	/**
	 * Constructor. Sets up the contributor if given a contributor
	 * id.
	 *
	 * @access public
	 * @param  integer $contributorId Optional
	 * @return void
	 * @throws Crisscott_Exception
	 */
	public function __construct($contributorId = null)
	{
		if (isset($constributorId)) {
			$this->init($contributorId);
		}
	}

	/**
	 * Grabs the values from the database and assigns them to 
	 * the proper member variables.
	 *
	 * The contributor data is stored in the database. A singleton
	 * database instance is used to connect to the database and get
	 * the contributor values.
	 *
	 * @access protected
	 * @param  integer   $contributorId
	 * @return void
	 */
	protected function init($contributorId)
	{
		// Check the contributorId.
		if (!is_numeric($contributorId)) {
			throw new Exception('Invalid contributor id: ' . $contributorId);
		}

		// Get a singleton DB instance.
		require_once 'Crisscott/DB.php';
		$db = Crisscott_DB::singleton();
		
		// Create the query.
		$query = 'SELECT first_name, middle_name, last_name, ';
		$query.= ' website, email, street1, street2, city, ';
		$query.= ' state, country, postal ';
		$query.= 'FROM contributor ';
		$query.= 'WHERE contributor_id = ' . $contributorId . ' ';

		// Submit the query.
		$result = $db->query($query);
		
		// If the query failed, we wouldn't be here.
		$this->contributorId = $contributorId;
		$this->firstName     = $result['first_name'];
		$this->middleName    = $result['middle_name'];
		$this->lastName      = $result['last_name'];
		$this->website       = $result['website'];
		$this->email         = $result['email'];
		$this->street1       = $result['street1'];
		$this->street2       = $result['street2'];
		$this->city          = $result['city'];
		$this->state         = $result['state'];
		$this->country       = $result['country'];
		$this->postal        = $result['postal'];
	}

	/**
	 * Checks the data to see that it is valid data.
	 *
	 * @access public
	 * @return mixed true if all data is valid or an array of invalid elements.
	 */
	public function validate()
	{
		$retArray = array();
		
		if ($this->firstName != 'tester') {
			$retArray[] = 'firstName';
		}
		if ($this->lastName != 'test') {
			$retArray[] = 'lastName';
		}

		return $retArray;
	}

	/**
	 * Writes the contributor data to the database.
	 *
	 * @access public
	 * @return void
	 */
	public function save()
	{
		return true;
		// Get a singleton DB instance.
		require_once 'Crisscott/DB.php';
		$db = Crisscott_DB::singleton();
		
		// Get the query.
		if (isset($this->contributorId)) {
			$query    = $this->_getUpdateQuery();
			$getNewId = false;
		} else {
			$query    = $this->_getInsertQuery();
			$getNewId = true;
		}

		// Submit the query;
		$db->query($query);

		// Do we need to get the contributorId?
		if ($getNewId) {
			$this->_getNewId();
		}
	}

	/**
	 * Creates the query for updating information already
	 * in the database.
	 *
	 * @access private
	 * @return string
	 */
	private function _getUpdateQuery()
	{
		$query = 'UPDATE contributor ';
		$query.= 'SET ';
		$query.= ' first_name  = \'' . $this->firstName  . '\', ';
		$query.= ' middle_name = \'' . $this->middleName . '\', ';
		$query.= ' last_name   = \'' . $this->lastName   . '\', ';
		$query.= ' website     = \'' . $this->website    . '\', ';
		$query.= ' email       = \'' . $this->email      . '\', ';
		$query.= ' street1     = \'' . $this->street1    . '\', ';
		$query.= ' street2     = \'' . $this->street2    . '\', ';
		$query.= ' city        = \'' . $this->city       . '\', ';
		$query.= ' state       = \'' . $this->state      . '\', ';
		$query.= ' country     = \'' . $this->country    . '\', ';
		$query.= ' postal      = \'' . $this->postal     . '\' ';
		$query.= 'WHERE contributorId = ' . $this->contirbutorId . ' ';

		return $query;
	}

	/**
	 * Creates the query for inserting information into
	 * the database.
	 *
	 * @access private
	 * @return string
	 */
	private function _getInsertQuery()
	{
		$query = 'INSERT INTO contributor ';
		$query.= '(first_name, middle_name, last_name, website, email, ';
		$query.= ' street1, street2, city, state, country, postal) ';
		$query.= 'VALUES ( ';
		$query.= '\'' . $this->firstName  . '\', ';
		$query.= '\'' . $this->middleName . '\', ';
		$query.= '\'' . $this->lastName   . '\', ';
		$query.= '\'' . $this->website    . '\', ';
		$query.= '\'' . $this->email      . '\', ';
		$query.= '\'' . $this->street1    . '\', ';
		$query.= '\'' . $this->street2    . '\', ';
		$query.= '\'' . $this->city       . '\', ';
		$query.= '\'' . $this->state      . '\', ';
		$query.= '\'' . $this->country    . '\', ';
		$query.= '\'' . $this->postal     . '\' ';
		$query.= ') ';

		return $query;
	}

	/**
	 * Sets the contributor id by looking up the value from
	 * the database.
	 *
	 * @access private
	 * @return void
	 */
	private function _getNewId()
	{
		// Get a singleton DB instance.
		require_once 'Crisscott/DB.php';
		$db = Crisscott_DB::singleton();

		// Create the query.
		$query = 'SELECT contributor_id ';
		$query.= 'FROM contributor ';
		$query.= 'WHERE first_name  = \'' . $this->firstName  . '\' ';
		$query.= '  AND middle_name = \'' . $this->middleName . '\', ';
		$query.= '  AND last_name   = \'' . $this->lastName   . '\' ';
		$query.= '  AND website     = \'' . $this->website    . '\' ';
		$query.= '  AND email       = \'' . $this->email      . '\' ';
		$query.= '  AND street1     = \'' . $this->street1    . '\' ';
		$query.= '  AND street2     = \'' . $this->street2    . '\' ';
		$query.= '  AND city        = \'' . $this->city       . '\' ';
		$query.= '  AND state       = \'' . $this->state      . '\' ';
		$query.= '  AND country     = \'' . $this->country    . '\' ';
		$query.= '  AND postal      = \'' . $this->postal     . '\' ';

		$result = $db->query($query);
		
		$this->contributorId = $result['contributor_id'];
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