<?php
/**
 * Description of download
 *
 * @author Irra_b
 */
class download {
    private $fecha;
    private $user;
    private $file;
    public function __construct($user,$file,$fecha)
    {
        $this->user=$user;
        $this->file=$file;
        $this->fecha=$fecha;
    }
    public function getUser()
    {
        return $this->user;
    }
    public function getFile()
    {
        return $this->file;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function save()
    {
        $sql="INSERT INTO docman_u_f(user,file,fecha)
        VALUES ('$this->user','$this->file','$this->fecha')";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public function getTotalDownloads($idu)
    {
        $sql="SELECT count(*) as total 
              FROM docman_u_f
              WHERE AND user='$idu'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            return $row['total'];
        }
        return NULL;
    }
}
