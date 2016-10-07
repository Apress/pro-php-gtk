<?php
ini_set('include_path', '/home/scott/authoring/Apress:/usr/share/pear:.');

function exceptionHandler($e) {
  gtk::main_quit();
  echo $e->getMessage() . "\n";
}

set_exception_handler('exceptionHandler');

require_once 'Crisscott/SplashScreen.php';
$csSplash = new Crisscott_SplashScreen();
$csSplash->start();
?>