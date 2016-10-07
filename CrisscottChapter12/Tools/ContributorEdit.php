<?php
/**
 * A set of widgets for modifying contributor data.
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
 * @subpackage Tools
 * @copyright  Copyright &copy; Scott Mattocks 2005
 * @version    @version@
 */
class Crisscott_Tools_ContributorEdit extends GtkTable {

	const ERROR_MARKUP_OPEN  = '<span foreground="#F00">';
	const ERROR_MARKUP_CLOSE = '</span>';

	/**
	 * The contributor currently being modified. 
	 *
	 * @access public
	 * @var    object
	 */
	public $contributor;

	/**
	 * A label for the contributor's first name.
	 * 
	 * @access private
	 * @var    object
	 */
	private $firstNameLabel;

	/**
	 * A label for the contributor's middle name.
	 * 
	 * @access private
	 * @var    object
	 */
	private $middleNameLabel;

	/**
	 * A label for the contributor's last name.
	 * 
	 * @access private
	 * @var    object
	 */
	private $lastNameLabel;

	/**
	 * A label for the contributor's web address.
	 * 
	 * @access private
	 * @var    object
	 */
	private $websiteLabel;

	/**
	 * A label for the contributor's email address.
	 * 
	 * @access private
	 * @var    object
	 */
	private $emailLabel;

	/**
	 * A label for the contributor's street address.
	 * 
	 * @access private
	 * @var    object
	 */
	private $street1Label;

	/**
	 * A label for the contributor's street address.
	 * 
	 * @access private
	 * @var    object
	 */
	private $street2Label;

	/**
	 * A label for the contributor's city.
	 * 
	 * @access private
	 * @var    object
	 */
	private $cityLabel;

	/**
	 * A label for the contributor's state.
	 * 
	 * @access private
	 * @var    object
	 */
	private $stateLabel;

 	/**
	 * A label for the contributor's country.
	 * 
	 * @access private
	 * @var    object
	 */
	private $countryLabel;

 	/**
	 * A label for the contributor's postal code.
	 * 
	 * @access private
	 * @var    object
	 */
	private $postalLabel;

	/**
	 * A entry for the contributor's first name.
	 * 
	 * @access private
	 * @var    object
	 */
	private $firstNameEntry;

	/**
	 * A entry for the contributor's middle name.
	 * 
	 * @access private
	 * @var    object
	 */
	private $middleNameEntry;

	/**
	 * A entry for the contributor's last name.
	 * 
	 * @access private
	 * @var    object
	 */
	private $lastNameEntry;

	/**
	 * A entry for the contributor's web address.
	 * 
	 * @access private
	 * @var    object
	 */
	private $websiteEntry;

	/**
	 * A entry for the contributor's email address.
	 * 
	 * @access private
	 * @var    object
	 */
	private $emailEntry;

	/**
	 * A entry for the contributor's street address.
	 * 
	 * @access private
	 * @var    object
	 */
	private $street1Entry;

	/**
	 * A entry for the contributor's street address.
	 * 
	 * @access private
	 * @var    object
	 */
	private $street2Entry;

	/**
	 * A entry for the contributor's city.
	 * 
	 * @access private
	 * @var    object
	 */
	private $cityEntry;

	/**
	 * A entry for the contributor's state.
	 * 
	 * @access private
	 * @var    object
	 */
	private $stateEntry;

 	/**
	 * A entry for the contributor's country.
	 * 
	 * @access private
	 * @var    object
	 */
	private $countryComboBox;

 	/**
	 * A entry for the contributor's postal code.
	 * 
	 * @access private
	 * @var    object
	 */
	private $postalEntry;

    /**
     * Constructor. Calls the methods to create the tool and
	 * sets up the needed callbacks.
     *
     * @access public
     * @param  object $contributor A Crisscott_Contributor instance. (Optional)
     * @return void
     */
    public function __construct($contributor = null)
    {
        // Call the parent constructor. 
        parent::__construct(7, 4);

		// Layout the tool.
		$this->_layoutTool();

		// Connect the needed callbacks.
		
		// Prepopulate the fields if a contributor is given.
		if (empty($contributor) || is_a($contributor, 'Crisscott_Contributor')) {
			require_once 'Crisscott/Contributor.php';
			$contributor = new Crisscott_Contributor();
		}
		$this->populateFields($contributor);
    }

	/**
	 * Laysout the labels, entries and buttons.
	 *
	 * This tool consists of several labels with corresponding entries
	 * and two buttons. One button resets the fields the other submits
	 * the information to change the contributors values.
	 * 
	 * @access private
	 * @return void
	 */
	private function _layoutTool()
	{
		// First create the labels that identify the fields.
		$this->firstNameLabel  = new GtkLabel('First Name');
		$this->middleNameLabel = new GtkLabel('Middle Name');
		$this->lastNameLabel   = new GtkLabel('Last Name');
		$this->emailLabel      = new GtkLabel('Email Address');
		$this->websiteLabel    = new GtkLabel('Website');
		$this->street1Label    = new GtkLabel('Street 1');
		$this->street2Label    = new GtkLabel('Street 2');
		$this->cityLabel       = new GtkLabel('City');
		$this->stateLabel      = new GtkLabel('State');
		$this->countryLabel    = new GtkLabel('Country');
		$this->postalLabel     = new GtkLabel('Postal Code');
		
		// Next add the labels to the table.
		// The labels will be added in two columns. 
		// First column.
		$this->attach($this->firstNameLabel,  0, 1, 0, 1, GTK::FILL, 0);
		$this->attach($this->middleNameLabel, 0, 1, 1, 2, GTK::FILL, 0);
		$this->attach($this->lastNameLabel,   0, 1, 2, 3, GTK::FILL, 0);
		$this->attach($this->emailLabel,      0, 1, 3, 4, GTK::FILL, 0);
		$this->attach($this->websiteLabel,    0, 1, 4, 5, GTK::FILL, 0);
		
		// Second column.
		$this->attach($this->street1Label, 2, 3, 0, 1, GTK::FILL, 0);
		$this->attach($this->street2Label, 2, 3, 1, 2, GTK::FILL, 0);
		$this->attach($this->cityLabel,    2, 3, 2, 3, GTK::FILL, 0);
		$this->attach($this->stateLabel,   2, 3, 3, 4, GTK::FILL, 0);
		$this->attach($this->countryLabel, 2, 3, 4, 5, GTK::FILL, 0);
		$this->attach($this->postalLabel,  2, 3, 5, 6, GTK::FILL, 0);

		// Right align all of the labels.
		$this->firstNameLabel->set_alignment(1, .5);
		$this->middleNameLabel->set_alignment(1, .5);
		$this->lastNameLabel->set_alignment(1, .5);
		$this->emailLabel->set_alignment(1, .5);
		$this->websiteLabel->set_alignment(1, .5);
		$this->street1Label->set_alignment(1, .5);
		$this->street2Label->set_alignment(1, .5);
		$this->cityLabel->set_alignment(1, .5);
		$this->stateLabel->set_alignment(1, .5);
		$this->countryLabel->set_alignment(1, .5);
		$this->postalLabel->set_alignment(1, .5);

		// Turn on markup
		$this->firstNameLabel->set_use_markup(true);
		$this->middleNameLabel->set_use_markup(true);
		$this->lastNameLabel->set_use_markup(true);
		$this->emailLabel->set_use_markup(true);
		$this->websiteLabel->set_use_markup(true);
		$this->street1Label->set_use_markup(true);
		$this->street2Label->set_use_markup(true);
		$this->cityLabel->set_use_markup(true);
		$this->stateLabel->set_use_markup(true);
		$this->countryLabel->set_use_markup(true);
		$this->postalLabel->set_use_markup(true);

		// Next create all of the data collection widgets.
		$this->firstNameEntry  = new GtkEntry();
		$this->middleNameEntry = new GtkEntry();
		$this->lastNameEntry   = new GtkEntry();
		$this->emailEntry      = new GtkEntry();
		$this->websiteEntry    = new GtkEntry();
		$this->street1Entry    = new GtkEntry();
		$this->street2Entry    = new GtkEntry();
		$this->cityEntry       = new GtkEntry();
		$this->stateEntry      = new GtkEntry();
		$this->postalEntry     = new GtkEntry();

		// The country should be a combobox.
		$this->countryComboBox = GtkComboBox::new_text();
		$this->countryComboBox->append_text('United States');
		$this->countryComboBox->prepend_text('Canada');
		$this->countryComboBox->insert_text(1, 'United Kingdom');
		$this->countryComboBox->set_active(0);

		// Next add the entrys to the table.
		// The entrys will be added in two columns. 
		// First column.
		$this->attach($this->firstNameEntry,  1, 2, 0, 1, 0, 0);
		$this->attach($this->middleNameEntry, 1, 2, 1, 2, 0, 0);
		$this->attach($this->lastNameEntry,   1, 2, 2, 3, 0, 0);
		$this->attach($this->emailEntry,      1, 2, 3, 4, 0, 0);
		$this->attach($this->websiteEntry,    1, 2, 4, 5, 0, 0);
		
		// Second column.
		$this->attach($this->street1Entry,    3, 4, 0, 1, 0, 0);
		$this->attach($this->street2Entry,    3, 4, 1, 2, 0, 0);
		$this->attach($this->cityEntry,       3, 4, 2, 3, 0, 0);
		$this->attach($this->stateEntry,      3, 4, 3, 4, 0, 0);
		$this->attach($this->countryComboBox, 3, 4, 4, 5, 0, 0);
		$this->attach($this->postalEntry,     3, 4, 5, 6, 0, 0);		

		// Help the user out with the state by using a GtkEntryCompletion.
		$stateCompletion = new GtkEntryCompletion();
		$stateCompletion->set_model(self::createStateList());
		$stateCompletion->set_text_column(0);
		$this->stateEntry->set_completion($stateCompletion);
		$stateCompletion->set_inline_completion(true);

		// Add the save and clear buttons.
		$save  = GtkButton::new_from_stock('gtk-save');
		$reset = GtkButton::new_from_stock('gtk-undo');
		$save->connect_simple('clicked', array($this, 'saveContributor'));
		$reset->connect_simple('clicked', array($this, 'resetContributor'));

		$this->attach($reset, 0, 1, 6, 7, 0, 0);
		$this->attach($save,  3, 4, 6, 7, 0, 0);
	}

	/**
	 * Creates a one column list store that contains the US states
	 * and Canadian provinces.
	 *
	 * This list can be used for combo boxes, tree, or entry 
	 * completions.
	 * 
	 * @static
	 * @access public
	 * @return object A GtkListStore
	 */
	public static function createStateList()
	{
		$listStore = new GtkListStore(GTK::TYPE_STRING);
		$iter = $listStore->append();
		$listStore->set($iter, 0, 'Alabama');
		$iter = $listStore->append();
		$listStore->set($iter, 0, 'Alaska');
		$iter = $listStore->append();
		$listStore->set($iter, 0, 'Arizona');
		$iter = $listStore->append();
		$listStore->set($iter, 0, 'Arkansas');
		$iter = $listStore->append();
		$listStore->set($iter, 0, 'California');
		$iter = $listStore->append();
		$listStore->set($iter, 0, 'Colorodo');

		return $listStore;
	}

	/*
	 *
	 * When a contributor is edited, it is stored in a member variable
	 * and then its values are used to populate the fields. 
	 *
	 * @access public
	 * @param  object $contributor A Crisscott_Contributor instance.
	 * @return void
	 */
	public function populateFields(Crisscott_Contributor $contributor)
	{
		// Populate the fields.
		$this->firstNameEntry->set_text($contributor->firstName);
		$this->middleNameEntry->set_text($contributor->middleName);
		$this->lastNameEntry->set_text($contributor->lastName);
		$this->emailEntry->set_text($contributor->email);
		$this->websiteEntry->set_text($contributor->website);

		$this->street1Entry->set_text($contributor->street1);
		$this->street2Entry->set_text($contributor->street2);
		$this->cityEntry->set_text($contributor->city);
		$this->stateEntry->set_text($contributor->state);
		$this->postalEntry->set_text($contributor->postal);

		// Set the active element for the country combo box.
		$model = $this->countryComboBox->get_model();
		$iter = $model->get_iter_first();
		for ($iter; $model->iter_is_valid($iter); $model->iter_next($iter)) {
			if ($this->contributor->country == $model->get_value($iter, 0)) {
				$this->countryComboBox->set_active_iter($iter);
			}
		}

		// Keep a hold of the contributor.
		$this->contributor = $contributor;
	}

	/**
	 * Resets the fields with the original contributor data.
	 *
	 * This method basically is an undo for all changes that
	 * have been made since the last save. It re-grabs the
	 * values from the contributor and populates them again.
	 *
	 * @uses populateFields
	 *
	 * @access public
	 * @return void
	 */
	public function resetContributor()
	{
		// Make sure we have a contributor already.
		if (!isset($this->contributor)) {
			require_once 'Crisscott/Contributor.php';
			$this->contributor = new Crisscott_Contributor();
			$this->contributor->country = 'United States';
		}

		// Reset the fields to the original value.
		$this->populateFields($this->contributor);
	}

	/**
	 * Grabs, validates, and saves the contributor information.
	 *
	 * First this method collects the data values from the widgets
	 * and then assigns them to the contributor object. Next the
	 * values are validated using the contributors validate method.
	 * If all is ok, the contributor is told to write the data to
	 * the database. 
	 *
	 * @access public
	 * @return boolean true on success.
	 */
	public function saveContributor()
	{
		// First grab all of the values.
		$this->contributor->firstName  = $this->firstNameEntry->get_text();
		$this->contributor->middleName = $this->firstNameEntry->get_text();
		$this->contributor->lastName   = $this->lastNameEntry->get_text();
		$this->contributor->website    = $this->websiteEntry->get_text();
		$this->contributor->email      = $this->emailEntry->get_text();
		$this->contributor->street1    = $this->street1Entry->get_text();
		$this->contributor->street1    = $this->street1Entry->get_text();
		$this->contributor->city       = $this->cityEntry->get_text();
		$this->contributor->state      = $this->stateEntry->get_text();
		//$this->contributor->country    = $this->countryComboBox->get_text();
		$this->contributor->postal     = $this->postalEntry->get_text();

		// Next validate the data.
		$valid = $this->contributor->validate();
		
		// Create a map of all the values and labels.
		$labelMap = array('firstName'  => $this->firstNameLabel,
						  'middleName' => $this->middleNameLabel,
						  'lastName'   => $this->lastNameLabel,
						  'website'    => $this->websiteLabel,
						  'email'      => $this->emailLabel,
						  'street1'    => $this->street1Label,
						  'street2'    => $this->street2Label,
						  'city'       => $this->cityLabel,
						  'state'      => $this->stateLabel,
						  'country'    => $this->countryLabel,
						  'postal'     => $this->postalLabel
						  );

		// Reset all of the labels.
		foreach ($labelMap as $label) {
			$this->clearError($label);
		}

		// If there are invalid values, markup the labels.
		if (is_array($valid)) {
			foreach ($valid as $labelKey) {
				$this->reportError($labelMap[$labelKey]);
			}
			
			// Saving the data was not successful.
			return false;
		}

		// Try to save the data.
		return $this->contributor->save();
	}

	/**
	 * Marks a label up as red text to indicate an error.
	 *
	 * @access public
	 * @param  object  $label   The GtkLabel to markup.
	 * @return void
	 */
	public function reportError(GtkLabel $label)
	{
		require_once 'Crisscott/Tools/StatusBar.php';
		$status = Crisscott_Tools_StatusBar::singleton();
		var_dump($status->push(rand(), 'Error: ' . $label->get_label()));

		$label->set_label(self::ERROR_MARKUP_OPEN . $label->get_label() . self::ERROR_MARKUP_CLOSE);
	}

	/**
	 * Clears the error markup from the given label.
	 *
	 * @access public
	 * @param  $label The GtkLabel to remove markup from.
	 * @return void
	 */
	public function clearError(GtkLabel $label)
	{
		require_once 'Crisscott/Tools/StatusBar.php';
		$status    = Crisscott_Tools_StatusBar::singleton();
		$contextId = $status->get_context_id('Error: ' . $label->get_label());
		$status->pop($contextId);
		
		$text = $label->get_label();
		$text = str_replace(self::ERROR_MARKUP_OPEN,  '', $text);
		$text = str_replace(self::ERROR_MARKUP_CLOSE, '', $text);
		
		$label->set_label($text);
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