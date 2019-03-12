<?php
/**
 * Description of fecha
 *
 * @author Irra_b
 */
class fecha {
   private $fecha;
   private $hora;
   private $fechaArray;
   private $months=array('Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');
   private $longmonths=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
   public function __construct($fecha) {
       $f=explode(' ', $fecha);
       $this->hora=$f[1];
       $this->fechaArray=explode('-', $f[0]);
   }
   public function getDay()
   {
       return $this->fechaArray[2];
   }
   public function getMonth()
   {
       return $this->fechaArray[1];
   }
   public function getLiteralMonth()
   {
       return $this->months[$this->fechaArray[1]-1];
   }
   public function getLiteralLongMonth()
   {
       return $this->longmonths[$this->fechaArray[1]-1];
   }
   public function getYear()
   {
       return $this->fechaArray[0];
   }
   public function getTime()
   {
       return $this->hora;
   }
}
