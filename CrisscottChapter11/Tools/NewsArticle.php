<?php
/**
 * A tool for displaying the text of a news item.
 *
 * News items may be things such as application updates,
 * changes to corporate policies, or could possibly be
 * targeted to individual suppliers. Targeted articles
 * would be things such as sales reports.
 *
 * @author     Scott Mattocks
 * @package    Criscott PIMS
 * @subpackage Tools
 * @copyright  Copyright &copy; Scott Mattocks 2005
 * @version    @version@
 */
class Crisscott_Tools_NewsArticle extends GtkVBox {

	/**
	 * Singleton instance of this object.
	 *
	 * @access public
	 * @var    object
	 */
	public static $instance;

	/**
	 * The label for the headline.
	 *
	 * @access public
	 * @var    object
	 */
	public $headline;

	/**
	 * The view for the article.
	 * 
	 * @access public
	 * @var    object
	 */
	public $view;

	/**
	 * The buffer that holds the article text.
	 * 
	 * @access public
	 * @var    object
	 */
	public $buffer;

	/**
	 * Constructor. If there is text to display it is added
	 * to the buffer.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct($text = NULL)
	{
		// Call the parent constructor.
		parent::__construct();
		
		// Layout the tool.
		$this->_layout();
	}

	/**
	 * Lays out the tool. Creates the widgets used by the tool
	 * and adds them to the container. 
	 *
	 * @access private
	 * @return void
	 */
	private function _layout()
	{
		// Create a label for the headline.
		$this->headline = new GtkLabel();
		
		// Create a view for the article.
		$this->view = new GtkTextView();

		// Get the buffer from the view.
		$this->buffer = $this->view->get_buffer();

		// Get a tag for making text bold and dark blue.
		$this->tag = new GtkTextTag();
		// Set the tag properties
		
		// Make the tag part of the buffers tag table.
		$tagTable = $this->buffer->get_tag_table();
		$tagTable->add($this->tag);

		// The text in this view should not be editable.
		$this->view->set_editable(false);
		
		// Since the user can't edit the text there is not point in
		// letting them see the cursor.
		$this->view->set_cursor_visible(false);

		// Pack everything together.
		$this->pack_start($this->headline, false, false, 5);
		$this->pack_start($this->view);
	}

	/**
	 * Sets the headline and the article text.
	 *
	 * @uses setHeadline
	 * @uses setBody
	 *
	 * @access public
	 * @param  string $headline
	 * @param  string $text
	 * @return void
	 */
	public function setArticle($headline, $text)
	{
		// Set the headline.
		$this->setHeadline($headline);
		
		// Set the body.
		$this->setBody($text);
	}

	/**
	 * Sets the text of the headline and makes it look like a 
	 * headline.
	 * 
	 * @access public
	 * @param  string $headline
	 * @return void
	 */
	public function setHeadline($headline)
	{
		// Add some markup to make the headline appear like
		// a headline.
		$headline = '<span weight="' . Pango::WEIGHT_BOLD . '">' . $headline;
		$headline.= '</span>';
			
		// Set the text of the headline label.
		$this->headline->set_text($headline);
		
		// Make sure the headline is set to use the markup that was added.
		$this->headline->set_use_markup(true);
		
	}

	/**
	 * Sets the given text as the text of the buffer.
	 *
	 * Any time that "Crisscott" is found in the article body, it is
	 * formatted so that it appears bold and dark blue. This is done
	 * using tags. 
	 *
	 * @access public
	 * @param  string $body
	 * @return void
	 */
	public function setBody($body)
	{
		// Do some special formatting of any instances of 
		// Crisscott found in the article body.
		$lastCrisscott = 0;
		while ($pos = strpos($body, 'Crisscott', $lastCrisscott)) {
			$wordStart = $this->buffer->get_iter_at_offset($pos);
			$wordEnd   = $this->buffer->get_iter_at_offset($pos);
			$wordEnd->forward_word_end();
			
			// Apply the tag.
			$this->buffer->apply_tag($this->tag, $wordStart, $wordEnd);
			
			// Update the strpos offset.
			$lastCrisscott = $pos;
		}

		// Set the article text in the buffer.
		$this->buffer->set_text($body);
	}

	/**
	 * Creates or returns a singleton instance of this class.
	 *
	 * @static
	 * @access public
	 * @return object
	 */
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
 */
?>