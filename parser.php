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

  // Productos que se mostrarán en la tabla de reporte
  $soat        = new Producto('soat');
  $vida        = new Producto('vida');
  $vehicular   = new Producto('vehicular');
  $salud       = new Producto('salud');
  $sctr        = new Producto('sctr');
  $hogar       = new Producto('hogar');
  $eps         = new Producto('eps');
  $rrgg        = new Producto('rrgg');
  $empresarial = new Producto('empresarial');
  $vidaley     = new Producto('vidaley');

  // Lista de contador de cantidad bruta por cada producto
  $bruto = array();
  // Lista de contador de cantidad neta por cada producto
  $neto = array();

  foreach ($workbook->createRowIterator($myWorksheetIndex) as $rowIndex => $values) {

    // var_dump($values);
    // if ($values[$columnIndex] === 'MOTIVO_NO_CIERRE_VENTA') {
    //   echo "cha pasa";
    // }

      $categoria = $values[17];
      $fuente    = $values[24];
      $medio     = $values[35];

      // LLenamos datos para SOAT
      if ($categoria === 'SOAT') {

        $medio = ($fuente === 'Lead_Ads_Facebook') ? 'social-media' : $medio;

        if ($fuente != 'SOAT_COMMERCE_BD' && $fuente != 'SOAT_COMMERCE_BD_CLIENTES' && $fuente != 'fuente_referido_si24') {
          $soat->procesarMedio($medio);
        }
      }

      // LLenamos datos para VIDA
      if ($categoria === 'Vida') {

        $medio = ($fuente === 'Lead_Ads_Facebook') ? 'social-media' : $medio;

        if ($fuente != 'fuente_referido_si24') {
          $vida->procesarMedio($medio);
        }
      }

      // LLenamos datos para Vehicular
      if ($categoria === 'Vehicular') {

        $medio = ($fuente === 'Lead_Ads_Facebook') ? 'social-media' : $medio;

        $filtro = ($fuente != 'fuente_referido_si24' &&
                   $fuente != 'SV_COMMERCE_BD_DATOSVEHICULO' &&
                   $fuente != 'SV_COMMERCE_BD_FECHANAC' &&
                   $fuente != 'SV_COMMERCE_BD_PLACA' &&
                   $fuente != 'Facebook (FT03-00-001)' ) ? true: false;

        if ($filtro) {
          $vehicular->procesarMedio($medio);
        }
      }

      // LLenamos datos para Salud
      if ($categoria === 'Salud') {

        $medio = ($fuente === 'Lead_Ads_Facebook') ? 'social-media' : $medio;

        $filtro = ($fuente != 'fuente_referido_si24') ? true: false;

        if ($filtro) {
          $salud->procesarMedio($medio);
        }
      }

      // LLenamos datos para SCTR
      if ($categoria === 'SCTR') {

        $medio = ($fuente === 'Lead_Ads_Facebook') ? 'social-media' : $medio;

        $filtro = ($fuente != 'fuente_referido_si24') ? true : false;

        if ($filtro) {
          $sctr->procesarMedio($medio);
        }
      }

      // LLenamos datos para Hogar
      if ($categoria === 'Hogar') {

        $medio = ($fuente === 'Lead_Ads_Facebook') ? 'social-media' : $medio;

        $filtro = ($fuente != 'fuente_referido_si24' &&
                   $fuente != 'Facebook (FT03-00-001)' ) ? true: false;

        if ($filtro) {
          $hogar->procesarMedio($medio);
        }
      }

      // LLenamos datos para EPS
      if ($categoria === 'EPS') {

        $medio = ($fuente === 'Lead_Ads_Facebook') ? 'social-media' : $medio;

        $filtro = ($fuente != 'fuente_referido_si24') ? true: false;

        if ($filtro) {
          $eps->procesarMedio($medio);
        }
      }

      // LLenamos datos para Rrgg
      if ($categoria === 'Rrgg') {

        $medio = ($fuente === 'Lead_Ads_Facebook') ? 'social-media' : $medio;

        $filtro = ($fuente != 'fuente_referido_si24') ? true: false;

        if ($filtro) {
          $rrgg->procesarMedio($medio);
        }
      }

      // LLenamos datos para Empresarial
      if ($categoria === 'Empresarial') {

        $medio = ($fuente === 'Lead_Ads_Facebook') ? 'social-media' : $medio;

        $filtro = ($fuente != 'fuente_referido_si24') ? true: false;

        if ($filtro) {
          $empresarial->procesarMedio($medio);
        }
      }

      // LLenamos datos para Vida Ley
      if ($categoria === 'Vida Ley') {

        $medio = ($fuente === 'Lead_Ads_Facebook') ? 'social-media' : $medio;

        $filtro = ($fuente != 'fuente_referido_si24') ? true: false;

        if ($filtro) {
          $vidaley->procesarMedio($medio);
        }
      }


  }

  // Guardar las cantidades brutas
  $bruto['soat']        = array_sum($soat->obtenerDatosCompletos());
  $bruto['vida']        = array_sum($vida->obtenerDatosCompletos());
  $bruto['vehicular']   = array_sum($vehicular->obtenerDatosCompletos());
  $bruto['salud']       = array_sum($salud->obtenerDatosCompletos());
  $bruto['sctr']        = array_sum($sctr->obtenerDatosCompletos());
  $bruto['hogar']       = array_sum($hogar->obtenerDatosCompletos());
  $bruto['eps']         = array_sum($eps->obtenerDatosCompletos());
  $bruto['rrgg']        = array_sum($rrgg->obtenerDatosCompletos());
  $bruto['empresarial'] = array_sum($empresarial->obtenerDatosCompletos());
  $bruto['vidaley']     = array_sum($vidaley->obtenerDatosCompletos());

  $tpl = $mustache->loadTemplate('presentacion'); // loads __DIR__.'/views/foo.mustache';
  echo $tpl->render(array(
    "tiempo_lectura_archivo" => $callTime,
    "cantidad_bruta" => $bruto,

    "soat" => $soat->obtenerDatosCompletos(),
    "soat_detalle_otros" => $soat->detalleOtros(),

    "vida" => $vida->obtenerDatosCompletos(),
    "vida_detalle_otros" => $vida->detalleOtros(),

    "vehicular" => $vehicular->obtenerDatosCompletos(),
    "vehicular_detalle_otros" => $vehicular->detalleOtros(),

    "salud" => $salud->obtenerDatosCompletos(),
    "salud_detalle_otros" => $salud->detalleOtros(),

    "sctr" => $sctr->obtenerDatosCompletos(),
    "sctr_detalle_otros" => $sctr->detalleOtros(),

    "hogar" => $hogar->obtenerDatosCompletos(),
    "hogar_detalle_otros" => $hogar->detalleOtros(),

    "eps" => $eps->obtenerDatosCompletos(),
    "eps_detalle_otros" => $eps->detalleOtros(),

    "rrgg" => $rrgg->obtenerDatosCompletos(),
    "rrgg_detalle_otros" => $rrgg->detalleOtros(),

    "empresarial" => $empresarial->obtenerDatosCompletos(),
    "empresarial_detalle_otros" => $empresarial->detalleOtros(),

    "vidaley" => $vidaley->obtenerDatosCompletos(),
    "vidaley_detalle_otros" => $vidaley->detalleOtros()
  ));

?>
