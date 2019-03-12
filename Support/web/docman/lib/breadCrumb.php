<?php
require_once 'folder.php';
/**
 * Description of breadCrumb
 *
 * @author Irra_b
 */
class breadCrumb {
    private $rootPath;
    private $Path;
    public function __construct($rootPath)
    {
        $this->rootPath=$rootPath;
        $this->Path=array();
        $this->addCrumb($rootPath);
    }
    public function getFirstCrumb()
    {
        return $this->rootPath;
    }
    public function addCrumb($value)
    {
        array_push($this->Path, $value);
    }
    public function exist($value)
    {
        for($i=0;$i<count($this->Path);$i++)
        {
            if($this->Path[$i]==$value)
            {
                $this->deleteCrumbs($i);
                return true;
            }
        }
        return false;
    }
    public function getLastCrumb()
    {
        return $this->Path[$this->length()-1];
    }
    public function getCrumbs()
    {
        $d='';
        for($i=0;$i<count($this->Path);$i++)
        {
            $f=folder::getFolderById($this->Path[$i]);
            if($f->isGroupFolder() and $f->getIDF()!=$_SESSION['path'])
            {
                $d=$d.'<div><a href="javascript:opensharefolder('.$f->getIDF().');">'.$f->getName().'</a></div><img src="images/bc_separator.png" style="float:left;">';
            }else
            {
                $d=$d.'<div><a href="javascript:openfolder('.$this->Path[$i].');">'.folder::getFolderNameById($this->Path[$i]).'</a></div><img src="images/bc_separator.png" style="float:left;">';
            }
        }
        return $d;
    }
    public function length()
    {
        return count($this->Path);
        
    }
    private function deleteCrumbs($index)
    {
        $aux=array();
        $i=0;
        while($i<=$index)
        {
            array_push($aux, $this->Path[$i]);
            $i++;
        }
        $this->Path=$aux;
    }
}

