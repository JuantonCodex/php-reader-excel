<?php
  /** Include Mustache */
  require dirname(__FILE__) . '/libs/Mustache/src/Mustache/Autoloader.php';
  Mustache_Autoloader::register();
  require_once dirname(__FILE__) . '/mustache_config.php';


  $tpl = $mustache->loadTemplate('/partials/modal'); // loads __DIR__.'/views/foo.mustache';
  echo $tpl->render();
?>
