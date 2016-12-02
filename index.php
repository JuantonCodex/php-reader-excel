<?php
  /** Error reporting */
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);

  ini_set('max_execution_time', 300); //300 seconds = 5 minutes
  date_default_timezone_set('America/Lima');

  /** Include Mustache */
  require dirname(__FILE__) . '/libs/Mustache/src/Mustache/Autoloader.php';
  Mustache_Autoloader::register();
  require_once dirname(__FILE__) . '/mustache_config.php';



  $tpl = $mustache->loadTemplate('home'); // loads __DIR__.'/views/foo.mustache';

  echo $tpl->render(array(
    "absolute_path" => dirname(__FILE__)
  ));

?>
