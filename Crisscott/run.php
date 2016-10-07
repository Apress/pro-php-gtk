<?php
ini_set('include_path', '/home/scott/playground/:/usr/share/pear:.');

function exceptionHandler($e) {
  gtk::main_quit();
  echo $e->getMessage() . "\n";
}

set_exception_handler('exceptionHandler');

require_once 'Crisscott/SplashScreen.php';
$csSplash = new Crisscott_SplashScreen();
$csSplash->start();
?>