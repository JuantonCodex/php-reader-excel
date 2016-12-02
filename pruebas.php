<?php

  /** Include Mustache */
  require '/libs/Mustache/src/Mustache/Autoloader.php';
  Mustache_Autoloader::register();

  if (preg_match("/\bsocial/i", "SocialMedia")) {
      echo "Se encontró una coincidencia.";
  } else {
      echo "No se encontró ninguna coincidencia.";
  }

  //$m = new Mustache_Engine;
  //echo $m->render('Hello {{planet}}', array('planet' => 'World!'));

  /*$mustache = new Mustache_Engine(array(
    'template_class_prefix' => '__MyTemplates_',
    'cache' => dirname(__FILE__).'/tmp/cache/mustache',
    'cache_file_mode' => 0666, // Please, configure your umask instead of doing this :)
    'cache_lambda_templates' => true,
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views'),
    'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views/partials'),
    'helpers' => array('i18n' => function($text) {
        // do something translatey here...
    }),
    'escape' => function($value) {
        return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
    },
    'charset' => 'ISO-8859-1',
    'logger' => new Mustache_Logger_StreamLogger('php://stderr'),
    'strict_callables' => true,
    'pragmas' => [Mustache_Engine::PRAGMA_FILTERS],
  ));

  $tpl = $mustache->loadTemplate('presentacion'); // loads __DIR__.'/views/foo.mustache';
  echo $tpl->render(array('nombre' => 'Juan Cahuana'));*/

  $data = array (
    "soat" => array ("adwords" => 1,"si24" => 2,"directo" => 0,"email" => 0,"organico" => 0,"referencia" => 0,"social_media" => 0,"vacio" => 0,"otros" => 0),
    "vida" => array ("adwords" => 0,"si24" => 0,"directo" => 0,"email" => 0,"organico" => 0,"referencia" => 0,"social_media" => 0,"vacio" => 0,"otros" => 0)
  );
  echo array_sum($data['soat']);


  echo "<pre>".print_r($data, 1)."</pre>";
  // var_dump($data);
?>
