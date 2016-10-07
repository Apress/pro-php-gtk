<?php
function popupContext($widget, $event, $menu)
{
  // Make sure the event was a button press.
  if ($event->type == Gdk::BUTTON_PRESS) {
    // See if button three was pressed.
    if ($event->button == 3) {
      // Pop up the menu.
      $menu->popup(null, null, null, $event->button, $event->time);
      return true;
    }
  }
  return false;
}

$window = new GtkWindow();
$window->connect_simple('destroy', array('Gtk', 'main_quit'));

$contextMenu = new GtkMenu();
$contextMenu->append(new GtkMenuItem('Copy'));
$contextMenu->append(new GtkMenuItem('Cut'));
$contextMenu->append(new GtkMenuItem('Paste'));

$contextMenu->show_all();

$contextArea = new GtkTextView();
$contextArea->connect('button-press-event', 'popupContext', $contextMenu);

$box = new GtkVBox();
$box->pack_start($contextArea, false, false);
$window->add($box);
$window->set_title('listing 11-9.php');
$window->show_all();
Gtk::main();
?>