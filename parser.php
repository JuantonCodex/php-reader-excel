<?php
  /** Error reporting */
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);

  ini_set('max_execution_time', 300); //300 seconds = 5 minutes
  date_default_timezone_set('America/Lima');

  require dirname(__FILE__) . '/vendor/autoload.php';

  use Akeneo\Component\SpreadsheetParser\SpreadsheetParser;

  /** Include Mustache */
  require dirname(__FILE__) . '/libs/Mustache/src/Mustache/Autoloader.php';
  Mustache_Autoloader::register();
  require_once dirname(__FILE__) . '/mustache_config.php';

  /** Clase Producto*/
  require dirname(__FILE__) . '/classes/Producto.php';

  // Hora de incio del proceso de lectura del archivo excel
  $callStartTime = microtime(true);

  $workbook = SpreadsheetParser::open('./excel/export-referidos-octubre-2016.xlsx');

  // Hora en que se terminó de leer el archivo excel
  $callEndTime = microtime(true);
  // Tiempo que se demoró en leer el archivo excel
  $callTime = $callEndTime - $callStartTime;

  $myWorksheetIndex = $workbook->getWorksheetIndex('Referidos');

  // $data = array (
  //   "soat" => array ("adwords" => 0,"si24" => 0,"directo" => 0,"email" => 0,"organico" => 0,"referencia" => 0,"social_media" => 0,"vacio" => 0,"otros" => 0),
  //   "vida" => array ("adwords" => 0,"si24" => 0,"directo" => 0,"email" => 0,"organico" => 0,"referencia" => 0,"social_media" => 0,"vacio" => 0,"otros" => 0),
  //   "vehicular" => array ("adwords" => 0,"si24" => 0,"directo" => 0,"email" => 0,"organico" => 0,"referencia" => 0,"social_media" => 0,"vacio" => 0,"otros" => 0)
  // );

  $soat      = new Producto('soat');
  $vida      = new Producto('vida');
  $vehicular = new Producto('vehicular');

  //$datos = $producto->obtenerDatosCompletos();

  //echo "<pre>".print_r($datos['soat'])."</pre>";
  // var_dump($producto);


  foreach ($workbook->createRowIterator($myWorksheetIndex) as $rowIndex => $values) {
    //var_dump($rowIndex, $values);

    $categoria = $values[17];
    $fuente    = $values[24];
    $medio     = $values[35];

    // LLenamos datos para SOAT
    if ($categoria === 'SOAT') {

      if ($fuente === 'Lead_Ads_Facebook') {
        $medio = 'social-media';
      }

      if ($fuente != 'SOAT_COMMERCE_BD' && $fuente != 'SOAT_COMMERCE_BD_CLIENTES' && $fuente != 'fuente_referido_si24') {
        $soat->procesarMedio($medio);
      }
    }

    // LLenamos datos para VIDA
    if ($categoria === 'Vida') {
      if ($fuente === 'Lead_Ads_Facebook') {
        $medio = 'social-media';
      }
      if ($fuente != 'fuente_referido_si24') {
        $vida->procesarMedio($medio);
      }
    }

    // LLenamos datos para Vehicular
    if ($categoria === 'Vehicular') {
      if ($fuente === 'Lead_Ads_Facebook') {
        $medio = 'social-media';
      }

      $filtro = ($fuente != 'fuente_referido_si24' &&
                 $fuente != 'SV_COMMERCE_BD_DATOSVEHICULO' &&
                 $fuente != 'SV_COMMERCE_BD_FECHANAC' &&
                 $fuente != 'SV_COMMERCE_BD_PLACA' &&
                 $fuente != 'Facebook (FT03-00-001)' ) ? true: false;

      if ($filtro) {
        $vehicular->procesarMedio($medio);
      }
    }

  }

  $tpl = $mustache->loadTemplate('presentacion'); // loads __DIR__.'/views/foo.mustache';
  echo $tpl->render(array(
    "tiempo_lectura_archivo" => $callTime,
    "soat_bruto" => array_sum($soat->obtenerDatosCompletos()),
    "soat" => $soat->obtenerDatosCompletos(),
    "vida_bruto" => array_sum($vida->obtenerDatosCompletos()),
    "vida" => $vida->obtenerDatosCompletos(),
    "vehicular_bruto" => array_sum($vehicular->obtenerDatosCompletos()),
    "vehicular" => $vehicular->obtenerDatosCompletos()
  ));

?>
