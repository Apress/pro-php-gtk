<?php
// Create a window for the application.
$window = new GtkWindow();

// Set up the options for the dialog
$dialogOptions = 0;
// Make the dialog modal.
$dialogOptions = $dialogOptions | Gtk::DIALOG_MODAL;
// Destroy the dialog if the parent window is destroyed.
$dialogOptions = $dialogOptions | Gtk::DIALOG_DESTROY_WITH_PARENT;
// Don't show a horizontal separator between the two parts.
$dialogOptions = $dialogOptions | Gtk::DIALOG_NO_SEPARATOR;

// Set up the buttons.
$dialogButtons = array();
// Add a stock "No" button and make its respnse "No".
$dialogButtons[] = Gtk::STOCK_NO;
$dialogButtons[] = Gtk::RESPONSE_NO;
// Add a stock "Yes" button and make its respnse "Yes".
$dialogButtons[] = Gtk::STOCK_YES;
$dialogButtons[] = Gtk::RESPONSE_YES;

// Create the dialog.
$dialog = new GtkDialog('Confirm Exit', $window, $dialogOptions, $dialogButtons);

// Add a question to the top part of the dialog.
$dialog->vbox->pack_start(new GtkLabel('Exit without saving?'));

?>