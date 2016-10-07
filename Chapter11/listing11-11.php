<?php
$window = new GtkWindow();
$window->connect_simple('destroy', array('Gtk', 'main_quit'));

// Create a vertical toolbar.
$vToolBar = new GtkToolbar();
$vToolBar->set_orientation(Gtk::ORIENTATION_VERTICAL);

// Turn off the overflow.
$vToolBar->set_show_arrow(false);

// Add a new item.
$new = GtkToolButton::new_from_stock(Gtk::STOCK_NEW);
$vToolBar->add($new);

// Add an open item.
$open = GtkToolButton::new_from_stock(Gtk::STOCK_OPEN);
$vToolBar->add($open);

// Add a save item.
$save = GtkToolButton::new_from_stock(Gtk::STOCK_SAVE);
$vToolBar->add($save);

// Add a copy item.
$copy = GtkToolButton::new_from_stock(Gtk::STOCK_COPY);
$vToolBar->add($copy);

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

// Pack both toolbars into a few boxes.
$vBox = new GtkVBox();
$hBox = new GtkHBox();
$vBox->pack_start($hToolBar, false, false);
$hBox->pack_start($vToolBar, false, false);
$vBox->pack_start($hBox, false, false);

// Show everything.
$window->add($vBox);
$window->set_title('listing 11-10.php');
$window->show_all();
Gtk::main();
?>