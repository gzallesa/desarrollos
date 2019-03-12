<?php
require_once 'collection.php';
require_once 'folder.php';
/**
 * Description of group
 *
 * @author Irra_b
 */
class group extends folder{
    private $idg;
    private $longname;
    private $folder;
    public function __construct($idg,$longname,$folder)
    {
        $this->idg=$idg;
        $this->longname=$longname;
        $this->folder=$folder;
        //parent::__construct($idf, $name, $path, $parentfolder, $datecreated);
    }
    public function getIDG()
    {
        return $this->idg;
    }
    public function getLongName()
    {
        return $this->longname;
    }
    public function setLongName($newname)
    {
        return $this->longname=$newname;
    }
    public function getFolderID()
    {
        return $this->folder;
    }
    public static function getGroups()
    {
        $g=NULL;
        $a=new collection();
        $sql="SELECT * FROM docman_group WHERE longname<>'root'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $g=new group($row['idg'], $row['longname'],$row['folder']);
            $a->add($g);
        }
        return $a;
    }
    public static function getGroupsUser($idu)
    {
        $g=NULL;
        $a=new collection();
        $sql="SELECT * FROM docman_group,docman_user,docman_g_u WHERE longname<>'root' AND id=user AND ingroup=idg AND id='$idu'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $g=new group($row['idg'], $row['longname'],$row['folder']);
            $a->add($g);
        }
        return $a;
    }
    public static function getUnGroups($idu)
    {
        $g=NULL;
        $a=new collection();
        $sql="SELECT * FROM docman_group WHERE idg<>(SELECT ingroup FROM docman_g_u, docman_user WHERE user=idu AND idu='$idu' group by user) AND longname<>'root'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $g=new group($row['idg'], $row['longname'],$row['folder']);
            $a->add($g);
        }
        return $a;
    }
    public static function getGroupByName($name)
    {
        $g=NULL;
        $sql="SELECT * FROM docman_group where longname='$name'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $g=new group($row['idg'], $row['longname'],$row['folder']);
        }
        return $g;
    }
    public static function getGroupByIdFolder($idf)
    {
        $g=NULL;
        $sql="SELECT * FROM docman_group where folder='$idf'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $g=new group($row['idg'], $row['longname'],$row['folder']);
        }
        return $g;
    }
    public static function updateUserGroup($idg,$idu)
    {
        if(group::getGroupsUser($idu)->length())
        {
            $sql="UPDATE docman_g_u SET ingroup='$idg'
                                WHERe user='$idu'";
        }else
        {
            $sql="INSERT INTO docman_g_u(ingroup,user)
                  VALUES ('$idg','$idu')";
        }
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public static function setUserGroup($idg,$idu)
    {
        $sql="INSERT INTO docman_g_u(ingroup,user)
        VALUES ('$idg','$idu')";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public static function setUserGroupCeros($idu)
    {
        $sql="DELETE FROM docman_g_u WHERE user='$idu'";
        try{
            mysql_query($sql);
        }catch(Exception $e){
            echo 'ERROR:'.$e;
        }
        //or die(mysql_error());
    }
    public function updateGroup()
    {
        $sql="UPDATE docman_group SET longname='$this->longname'
                                WHERE idg='$this->idg'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public static function getGroupByID($idg)
    {
        $g=NULL;
        $sql="SELECT * FROM docman_group where idg='$idg'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $g=new group($row['idg'], $row['longname'],$row['folder']);
        }
        return $g;
    }
    public function addFolder(folder $folder)
    {
        return $folder->saveFolder();
    }
    public function renameFolder($idf,$newname)
    {
        $f=folder::getFolderById($idf);
        $f->setName($newname);
        return $f->renameFolder();
    }
    public function delete()
    {
        $f=folder::getFolderById($this->folder);
        $sql="DELETE FROM docman_group WHERE idg='$this->idg'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            $f->deleteFolder();
            return 1;
        }else
        {
            return 0;
        }
    }
    public function deleteFolder($idf)
    {
        $f=folder::getFolderById($idf);
        rmdir('../rootfolder/'.$f->getPath().$f->getIDF());
        $sql="DELETE FROM docman_folder WHERE idf='$idf' OR parentfolder='$idf'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public function getFolders()
    {
        $f=folder::getFolderById($this->folder);
        return $f->getFolders();
    }
    public function saveGroup()
    {
        $sql="INSERT INTO docman_group(idg,longname,folder)
        VALUES ('','$this->longname','$this->folder')";
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




