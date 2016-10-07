<?php
/**
 * A collection of widgets that provides the tools 
 * necessary to display and collect information about
 * a product.
 *
 * All attributes of a product must be managable
 * through this set of widgets. 
 */
class Crisscott_Tools_ProductEdit extends GtkTable {

    const ERROR_MARKUP_OPEN  = '<span foreground="#F00">';
    const ERROR_MARKUP_CLOSE = '</span>';

    /**
     * Singleton instance of this object.
     *
     * @access public
     * @var    object
     */
    public static $instance;

    /**
     * The current/last product being edited.
     *
     * @access public
     * @var    object
     */
    public $product;

    /**
     * A label for the Name entry.
     *
     * @access public
     * @var    object
     */
    public $nameLabel;

    /**
     * A label for the Type entry.
     *
     * @access public
     * @var    object
     */
    public $typeLabel;

    /**
     * A label for the Category entry.
     *
     * @access public
     * @var    object
     */
    public $categoryLabel;

    /**
     * A label for the Price entry.
     *
     * @access public
     * @var    object
     */
    public $priceLabel;

    /**
     * A label for the Description entry.
     *
     * @access public
     * @var    object
     */
    public $descLabel;

    /**
     * A label for the Inventory entry.
     *
     * @access public
     * @var    object
     */
    public $inventoryLabel;

    /**
     * A label for the Availability entry.
     *
     * @access public
     * @var    object
     */
    public $availLabel;

    /**
     * A label for the Width entry.
     *
     * @access public
     * @var    object
     */
    public $widthLabel;

    /**
     * A label for the Height entry.
     *
     * @access public
     * @var    object
     */
    public $heigthLabel;

    /**
     * A label for the Depth entry.
     *
     * @access public
     * @var    object
     */
    public $depthLabel;

    /**
     * A label for the Weight entry.
     *
     * @access public
     * @var    object
     */
    public $weightLabel;

    /**
     * A label for the image.
     *
     * @access public
     * @var    object
     */
    public $imageLabel;

    /**
     * A entry for the Name.
     *
     * @access public
     * @var    object
     */
    public $nameEntry;

    /**
     * A entry for the Type.
     *
     * @access public
     * @var    object
     */
    public $typeEntry;

    /**
     * A entry for the Category.
     *
     * @access public
     * @var    object
     */
    public $categoryEntry;

    /**
     * A entry for the Price.
     *
     * @access public
     * @var    object
     */
    public $priceEntry;

    /**
     * A entry for the Description.
     *
     * @access public
     * @var    object
     */
    public $descEntry;

    /**
     * A entry for the Inventory.
     *
     * @access public
     * @var    object
     */
    public $inventoryEntry;

    /**
     * A entry for the Availability.
     *
     * @access public
     * @var    object
     */
    public $availEntry;

    /**
     * A entry for the Width.
     *
     * @access public
     * @var    object
     */
    public $widthSpin;

    /**
     * A entry for the Height.
     *
     * @access public
     * @var    object
     */
    public $heightSpin;

    /**
     * A entry for the Depth.
     *
     * @access public
     * @var    object
     */
    public $depthEntry;

    /**
     * A entry for the Weight.
     *
     * @access public
     * @var    object
     */
    public $weightEntry;

    /**
     * A container to hold the product image.
     *
     * @access public
     * @var    object
     */
    public $imageContainer;

    /**
     * A entry for the image path.
     *
     * @access public
     * @var    object
     */
    public $imagePathEntry;

    /**
     * Constructor. Sets up the tool.
     *
     * @access public
     * @param  object $product An optional product to edit.
     * @return void
     */
    public function __construct($product = null)
    {
        // Set up the rows and columns.
        parent::__construct(6, 4);

        // Layout the tools.
        $this->_layout();

        // Add product if one was passed in.
        if (isset($product)) {
            $this->loadProduct($product);
        } else {
            $this->resetProduct();
        }
    }

    private function _layout()
    {
        // Set up the data entry widgets.
        $this->nameEntry      = new GtkEntry();
        $this->typeCombo      = GtkComboBox::new_text();
        $this->categoryCombo  = GtkComboBox::new_text();
        $this->priceSpin      = new GtkSpinButton(new GtkAdjustment(1, 1, 1000, .01, 10), .5);
        $this->inventorySpin  = new GtkSpinButton(new GtkAdjustment(1, 0, 100, 1, 10), .5);
        $this->availCombo     = GtkComboBox::new_text();
        $this->widthSpin      = new GtkSpinButton(new GtkAdjustment(1, 1, 50, .1, 5), .5);
        $this->heightSpin     = new GtkSpinButton(new GtkAdjustment(1, 1, 50, .1, 5), .5);
        $this->depthSpin      = new GtkSpinButton(new GtkAdjustment(1, 1, 50, .1, 5), .5);
        $this->weightSpin     = new GtkSpinButton(new GtkAdjustment(1, 1, 50, .1, 5), .5);
        $this->imageContainer = new GtkFrame();
        $this->imagePathEntry = new GtkEntry();

        // Add two options for the type.
        $this->typeCombo->append_text('Digital');
        $this->typeCombo->append_text('Shippable');
        // Make the first category the default.
        $this->typeCombo->set_active(0);

        // Add an entry for each category in the inventory.
        require_once 'Crisscott/Inventory.php';
        $inventory = Crisscott_Inventory::singleton();
        foreach ($inventory->categories as $cat) {
            $this->categoryCombo->append_text($cat->name);
        }
        // Make the first category the default.
        $this->categoryCombo->set_active(0);

        // Add yes/no options for the avialability.
        $this->availCombo->append_text('NO');
        $this->availCombo->append_text('YES');
        // Make yes the default.
        $this->availCombo->set_active(0);

        // Set the number of decimal places in the spin buttons.
        $this->priceSpin->set_digits(2);
        $this->inventorySpin->set_digits(0);
        $this->widthSpin->set_digits(1);
        $this->heightSpin->set_digits(1);
        $this->depthSpin->set_digits(1);
        $this->weightSpin->set_digits(1);

        // Create the description text view.
        $this->descView       = new GtkTextView();

        // We need save and cancel buttons.
        $save  = GtkButton::new_from_stock('gtk-save');
        $reset = GtkButton::new_from_stock('gtk-undo');

        // Connect the buttons to useful methods.
        $save->connect_simple('clicked', array($this, 'saveProduct'));
        $reset->connect_simple('clicked', array($this, 'resetProduct'));

        // Set up the labels.
        $this->nameLabel      = new GtkLabel('_Name', true);
        $this->typeLabel      = new GtkLabel('Type');
        $this->categoryLabel  = new GtkLabel('Category');
        $this->priceLabel     = new GtkLabel('Price');
        $this->inventoryLabel = new GtkLabel('Inventory');
        $this->availLabel     = new GtkLabel('Availability');
        $this->widthLabel     = new GtkLabel('Width');
        $this->heightLabel    = new GtkLabel('Height');
        $this->depthLabel     = new GtkLabel('Depth');
        $this->weightLabel    = new GtkLabel('Weight');
        $this->descLabel      = new GtkLabel('Description');
        $this->imageLabel     = new GtkLabel('Image');

        // Set the labels' size.
        $this->nameLabel->set_size_request(100, -1);
        $this->typeLabel->set_size_request(100, -1);
        $this->categoryLabel->set_size_request(100, -1);
        $this->priceLabel->set_size_request(100, -1);
        $this->inventoryLabel->set_size_request(100, -1);
        $this->availLabel->set_size_request(100, -1);
        $this->widthLabel->set_size_request(100, -1);
        $this->heightLabel->set_size_request(100, -1);
        $this->depthLabel->set_size_request(100, -1);
        $this->weightLabel->set_size_request(100, -1);
        $this->descLabel->set_size_request(100, -1);
        $this->imageLabel->set_size_request(100, -1);

        // Set the size of the text view also.
        $this->descView->set_size_request(300, 150);
        // Force the text to wrap.
        $this->descView->set_wrap_mode(Gtk::WRAP_WORD);

        // Next align each label within the parent container.
        $this->nameLabel->set_alignment(0, .5);
        $this->typeLabel->set_alignment(0, .5);
        $this->categoryLabel->set_alignment(0, .5);
        $this->priceLabel->set_alignment(0, .5);
        $this->inventoryLabel->set_alignment(0, .5);
        $this->availLabel->set_alignment(0, .5);
        $this->widthLabel->set_alignment(0, .5);
        $this->heightLabel->set_alignment(0, .5);
        $this->depthLabel->set_alignment(0, .5);
        $this->weightLabel->set_alignment(0, .5);
        $this->descLabel->set_alignment(0, .5);
        $this->imageLabel->set_alignment(0, .5);

        // Make all of the labels use markup.
        $this->nameLabel->set_use_markup(true);
        $this->typeLabel->set_use_markup(true);
        $this->categoryLabel->set_use_markup(true);
        $this->priceLabel->set_use_markup(true);
        $this->inventoryLabel->set_use_markup(true);
        $this->availLabel->set_use_markup(true);
        $this->widthLabel->set_use_markup(true);
        $this->heightLabel->set_use_markup(true);
        $this->depthLabel->set_use_markup(true);
        $this->weightLabel->set_use_markup(true);
        $this->descLabel->set_use_markup(true);
        $this->imageLabel->set_use_markup(true);

        // Attach them to the table.
        $expandFill = GTK::EXPAND|GTK::FILL;
        $this->attach($this->nameLabel,      0, 1, 0, 1,  0, 0);
        $this->attach($this->typeLabel,      0, 1, 1, 2,  0, 0);
        $this->attach($this->categoryLabel,  0, 1, 2, 3,  0, 0);
        $this->attach($this->priceLabel,     0, 1, 3, 4,  0, 0);
        $this->attach($this->inventoryLabel, 0, 1, 5, 6,  0, 0);
        $this->attach($this->availLabel,     0, 1, 6, 7,  0, 0);
        $this->attach($this->widthLabel,     0, 1, 7, 8,  0, 0);
        $this->attach($this->heightLabel,    0, 1, 8, 9,  0, 0);
        $this->attach($this->depthLabel,     0, 1, 9, 10,  0, 0);
        $this->attach($this->weightLabel,    0, 1, 10, 11, 0, 0);

        // Attach the entries too.
        $this->attachWithAlign($this->nameEntry,      1, 2, 0, 1,  Gtk::FILL, 0);
        $this->attachWithAlign($this->typeCombo,      1, 2, 1, 2,  GTK::FILL, 0);
        //$this->attach($this->typeCombo,      1, 2, 1, 2,  0, 0);
        $this->attachWithAlign($this->categoryCombo,  1, 2, 2, 3,  Gtk::FILL, 0);
        $this->attachWithAlign($this->priceSpin,      1, 2, 3, 4,  Gtk::FILL, 0);
        $this->attachWithAlign($this->inventorySpin,  1, 2, 5, 6,  Gtk::FILL, 0);
        $this->attachWithAlign($this->availCombo,     1, 2, 6, 7,  Gtk::FILL, 0);
        $this->attachWithAlign($this->widthSpin,      1, 2, 7, 8,  Gtk::FILL, 0);
        $this->attachWithAlign($this->heightSpin,     1, 2, 8, 9,  Gtk::FILL, 0);
        $this->attachWithAlign($this->depthSpin,      1, 2, 9, 10, Gtk::FILL, 0);
        $this->attachWithAlign($this->weightSpin,     1, 2, 10, 11, Gtk::FILL, 0);

        // Attach the image widgets.
        $this->attachWithAlign($this->imageContainer, 2, 4, 0, 4,  Gtk::FILL, 0);
        $this->attachWithAlign($this->imageLabel,     2, 4, 4, 5,  Gtk::FILL, 0);
        $this->attachWithAlign($this->imagePathEntry, 3, 4, 4, 5,  Gtk::FILL, 0);

        // Attach the description widgets.
        $this->attachWithAlign($this->descLabel,      2, 3, 5, 6,  Gtk::FILL, 0);
        $this->attachWithAlign($this->descView,       2, 4, 6, 11, Gtk::FILL, 0);

        // Attache the buttons.
        $this->attachWithAlign($reset, 0, 1, 11, 12, Gtk::FILL, 0);
        $this->attachWithAlign($save,  3, 4, 11, 12, Gtk::FILL, 0);

        // Associate the mnemonics.
        $this->nameLabel->set_mnemonic_widget($this->nameEntry);
        $this->nameEntry->connect_simple('mnemonic_activate', array($this, 'reportError'), $this->nameLabel);
    }

    /**
     * Attaches a widget to the table inside of a GtkAlignment.
     *
     * This method makes it easy to left align items within a table.
     * Simply call this method like you would attach.
     *
     * @access public
     * @see    attach
     * @return void
     */
    public function attachWithAlign($widget, $row1, $row2, $col1, $col2, $xEF, $yEF)
    {
        $align = new GtkAlignment(0,0,0,.5);
        $align->add($widget);
        $this->attach($align, $row1, $row2, $col1, $col2, $xEF, $yEF);
    }

    /**
     * Marks a label up as red text to indicate an error.
     *
     * @access public
     * @param  boolean $unknown Seriously, no idea what it means.
     * @param  object  $label   The GtkLabel to markup.
     * @return void
     */
    public function reportError(GtkLabel $label)
    {
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
        $text = $label->get_label();
        $text = str_replace(self::ERROR_MARKUP_OPEN,  '', $text);
        $text = str_replace(self::ERROR_MARKUP_CLOSE, '', $text);
        
        $label->set_label($text);
    }

    /**
     * Load the given product into the tool.
     *
     * @access public
     * @param  object $product A Crisscott_Product instance.
     * @return void
     */
    public function loadProduct(Crisscott_Product $product)
    {
        // First set the product as the current product.
        $this->product = $product;

        // Next reset the tool.
        $this->resetProduct();

        // Finally make the notebook page active.
        require_once 'Crisscott/MainNotebook.php';
        $notebook = Crisscott_MainNotebook::singleton();
        $notebook->set_current_page($notebook->page_num($notebook->pages['Product Edit']));
    }

    /**
     * Sets the values of the tool to the values of the current
     * product.
     *
     * @access public
     * @return void
     */
    public function resetProduct()
    {
        // Make sure that there is a product.
        if (!isset($this->product)) {
            require_once 'Crisscott/Product.php';
            $this->product = new Crisscott_Product();
        }

        // Update the tools in the widget.
        $this->nameEntry->set_text($this->product->name);
        $this->_setComboActive($this->typeCombo, $this->product->type);
        
        $inv = Crisscott_Inventory::singleton();
        $cat = $inv->getCategoryById($this->product->categoryId);
        $this->_setComboActive($this->categoryCombo, $cat->name);

        $this->priceSpin->set_value($this->product->price);
        $this->inventorySpin->set_value($this->product->inventory);
        $this->availCombo->set_active($this->product->availability);
        $this->widthSpin->set_value($this->product->width);
        $this->heightSpin->set_value($this->product->height);
        $this->depthSpin->set_value($this->product->depth);
        $this->weightSpin->set_value($this->product->weight);
        $this->imagePathEntry->set_text($this->product->imagePath);

        $this->imageContainer->remove($this->imageContainer->get_child());
        try {
            $pixbuf = GdkPixbuf::new_from_file($this->product->imagePath);
            $this->imageContainer->add(GtkImage::new_from_pixbuf($pixbuf));
            $this->imageContainer->show_all();
        } catch (Exception $e) {
            // Don't do anything special
        }

        $buffer = $this->descView->get_buffer();
        $buffer->set_text($this->product->description);
    }

    /**
     * Sets the active item in a combo box.
     *
     * The combo box will be searched for the value given and 
     * the matching item will be made active. The method returns
     * after the first match.
     *
     * This works for combos created with or without new_text().
     *
     * @access private
     * @param  object  $combo
     * @param  mixed   $value
     * @return void
     */
    private function _setComboActive(GtkComboBox $combo, $value)
    {
        // Get the underlying model.
        $model = $combo->get_model();
        // Get the first iter. 
        $iter = $model->get_iter_first();
        // Loop through the items.
        for ($iter; $model->iter_is_valid($iter); $model->iter_next($iter)) {
            // Check for a match.
            if ($value == $model->get_value($iter, 0)) {
                // A match! Set the active item and get out.
                $combo->set_active_iter($iter);
                return;
            }
        }
    }

    /**
     * Copies the data from the tool to the product. Then asks
     * the product to save the data.
     *
     * @access public
     * @return void
     */
    public function saveProduct()
    {
        // Set the product properties.
        $this->product->name         = $this->nameEntry->get_text();
        $this->product->type         = $this->typeCombo->get_active_text();

        $inv = Crisscott_Inventory::singleton();
        $cat = $inv->getCategoryByName($this->categoryCombo->get_active_text());
        $this->product->categoryId   = $cat->categoryId;

        $this->product->price        = $this->priceSpin->get_value();
        $this->product->inventory    = $this->inventorySpin->get_value();
        $this->product->availability = (boolean)$this->availCombo->get_active();
        $this->product->width        = $this->widthSpin->get_value();
        $this->product->height       = $this->heightSpin->get_value();
        $this->product->depth        = $this->depthSpin->get_value();
        $this->product->weight       = $this->weightSpin->get_value();
        $this->product->imagePath    = $this->imagePathEntry->get_value();

        $buffer = $this->descView->get_buffer();
        $this->product->description  = $buffer->get_text($buffer->get_start_iter(), $buffer->get_end_iter());

        // Validate the new values.
        $valid = $this->product->validate();

        // Create a map of all the values and labels.
        $labelMap = array(
                          'name'      => $this->nameLabel,
                          'type'      => $this->typeLabel,
                          'category'  => $this->categoryLabel,
                          'price'     => $this->priceLabel,
                          'inventory' => $this->inventoryLabel,
                          'avail'     => $this->availLabel,
                          'width'     => $this->widthLabel,
                          'height'    => $this->heightLabel,
                          'depth'     => $this->depthLabel,
                          'weight'    => $this->weightLabel,
                          'desc'      => $this->descLabel,
                          'image'     => $this->imageLabel
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
            
            // Validatig the data was not successful.
            return false;
        }

        try {
            // Try to save the data.
            $this->product->save();

            // Mark the buffer as saved.
            $this->descView->get_buffer()->set_modified(false);

            // Update the inventory instance.
            $inv = Crisscott_Inventory::singleton();
            $inv->refreshInventory();
            
            // Also update the product tree.
            $pt = Crisscott_Tools_ProductTree::singleton();
            $pt->updateModel();

        } catch (Exception $e) {
            throw $e;
            return false;
        }
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