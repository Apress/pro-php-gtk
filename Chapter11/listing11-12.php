<?php
$window = new GtkWindow();
$window->connect_simple('destroy', array('Gtk', 'main_quit'));

// Create a horizontal toolbar. 
$hToolBar = new GtkToolbar();

// Add a new item.
$new = GtkToolButton::new_from_stock(Gtk::STOCK_NEW);
$hToolBar->add($new);

// An an open item.
$open = GtkToolButton::new_from_stock(Gtk::STOCK_OPEN);
$hToolBar->add($open);

// Add a save item.
$save = GtkToolButton::new_from_stock(Gtk::STOCK_SAVE);
$hToolBar->add($save);

// Add a copy item.
$copy = GtkToolButton::new_from_stock(Gtk::STOCK_COPY);
$hToolBar->add($copy);

// Add tool tips.
$tooltips = new GtkTooltips();

// Create a tool tip for each item.
$new->set_tooltip($tooltips,  'New',  'Creates a new product.');
$open->set_tooltip($tooltips, 'Open', 'Open an existing inventory file.');
$save->set_tooltip($tooltips, 'Save', 'Saves the current inventory.');
$copy->set_tooltip($tooltips, 'Copy', 'Copies a product.');

// Make sure the toolbar is set to display tooltips.
$hToolBar->set_tooltips(true);

$hToolBar->set_style(Gtk::TOOLBAR_ICONS);

// Pack the toolbar into a box.
$vBox = new GtkVBox();
$vBox->pack_start($hToolBar, false, false);

// Show everything.
$window->add($vBox);
$window->set_title('listing11-11.php');
$window->show_all();
Gtk::main();
?>