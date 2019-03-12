<?php
require_once 'collection.php';
/**
 * Description of event
 *
 * @author Irra_b
 */
class event {
    private $fecha;
    private $hora;
    private $evento;
    private $ide;
    private $descrip;
    private $public;
    private $group;
    public function __construct($ide,$fecha,$evento,$desc,$hora,$public,$group)
    {
        $this->ide=$ide;
        $this->fecha=$fecha;
        $this->evento=$evento;
        $this->descrip=$desc;
        $this->hora=$hora;
        $this->public=$public;
        $this->group=$group;
    }
    public function getHora()
    {
        return $this->hora;
    }
    public function getDescription()
    {
        return $this->descrip;
    }
    public function getIde()
    {
        return $this->ide;
    }
    public function getFecha()
    {
        return $this->fecha;
    }        
    public function getPublic()
    {
        return $this->public;
    }        
    public function getEvent()
    {
        return $this->evento;
    }
    public static function getEvents()
    {
        $events=new collection();
        $sql="SELECT * FROM evento";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $e=new event($row['ide'], $row['fecha'], $row['evento'],$row['descrip'],$row['hora'],$row['public'],$row['group']);
            $events->add($e);
        }
        return $events;
    }
    public static function getEventsGroupAll($idg)
    {
        $events=new collection();
        $sql="SELECT * FROM evento WHERE evento.group='$idg' OR public='1'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $e=new event($row['ide'], $row['fecha'], $row['evento'],$row['descrip'],$row['hora'],$row['public'],$row['group']);
            $events->add($e);
        }
        return $events;
    }
    public static function getMopsvEvents()
    {
        $events=new collection();
        $sql="SELECT * FROM evento WHERE public='1'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $e=new event($row['ide'], $row['fecha'], $row['evento'],$row['descrip'],$row['hora'],$row['public'],$row['group']);
            $events->add($e);
        }
        return $events;
    }
    public function saveEvent()
    {
        $sql="INSERT INTO evento(ide,fecha,evento,descrip,hora,public,evento.group)
        VALUES ('','$this->fecha','$this->evento','$this->descrip','$this->hora','$this->public','$this->group')";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public function updateEvent()
    {
        $sql="UPDATE event SET  fecha='$this->fecha', 
                                evento='$this->evento', 
                                descrip='$this->descrip', 
                                hora='$this->hora' 
                                public='$this->public' 
                                WHERE ide='$this->ide'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public static function deleteEvent($ide)
    {
        $sql="DELETE FROM evento WHERE ide='$ide'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
}
