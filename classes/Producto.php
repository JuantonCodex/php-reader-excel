<?php
  /**
   *
   */
  class Producto {

    public $datos = array();
    public $nombre_producto;

    function __construct($nombre_producto) {

      // echo "constructor";
      $this->nombre_producto = $nombre_producto;
      $this->datos[$this->nombre_producto] = array(
        "adwords" => 0,
        "si24" => 0,
        "directo" => 0,
        "email" => 0,
        "organico" => 0,
        "referencia" => 0,
        "social_media" => 0,
        "vacio" => 0,
        "otros" => 0
      );

      // array_push($this->datos[$nombre_producto], $array_dinamico);
    }

    public function procesarMedio($medio){

      switch ($medio) {
        case '(not%20set)': //Adwords
          $this->datos[$this->nombre_producto]['adwords']++;
          break;
        case '(none)': //Directo
          $this->datos[$this->nombre_producto]['directo']++;
          break;
        case preg_match("/mail\b/i", $medio) ? $medio : !$medio: //Email
          $this->datos[$this->nombre_producto]['email']++;
          break;
        case 'organic': //Orgánico
          $this->datos[$this->nombre_producto]['organico']++;
          break;
        case 'referral': //Referencia
          $this->datos[$this->nombre_producto]['referencia']++;
          break;
        case preg_match("/\bsocial/i", $medio) ? $medio : !$medio: //Social media
          $this->datos[$this->nombre_producto]['social_media']++;
          break;
        case '': //Vacío
          $this->datos[$this->nombre_producto]['vacio']++;
          break;
        default: //Otros
          $this->datos[$this->nombre_producto]['otros']++;
      }

    }

    public function obtenerDatosCompletos() {
      return $this->datos[$this->nombre_producto];
    }
  }

?>
