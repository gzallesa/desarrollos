<?php
require_once 'collection.php';
require_once 'permissions.php';
/**
 * Description of file
 *
 * @author Irra_b
 */
class file {
    private $idf;
    private $filename;
    private $filesize;
    private $created;
    private $ext;
    private $parentfolder;
    private $user;
    private $status;
    private $permissions;
    private $path;
    public function __construct($idf,$filename,$filesize,$created,$ext,$parentfolder,$user,$status,$path)
    {
        $this->idf=$idf;
        $this->filename=$filename;
        $this->parentfolder=$parentfolder;
        $this->ext=$ext;
        $this->created=$created;
        $this->filesize=$filesize;
        $this->user=$user;
        $this->status=$status;
        $this->permissions=new permissions($this->idf, 'r--', '---');
        $this->path=$path;
    }
    public function setPermissions(permissions $p)
    {
        $this->permissions=$p;
    }
    public function getPermissions()
    {
        return $this->permissions;
    }
    public function getPathFile()
    {
        return $this->path;
    }
    public function getIDF()
    {
        return $this->idf;
    }
    public function setIDF($idf)
    {
        $this->idf=$idf;
    }
    public function getUser()
    {
        return $this->user;
    }
    public function getFileName()
    {
        return $this->filename;
    }
    public function getFileSize()
    {
        return $this->filesize;
    }
    public function getDateCreation()
    {
        return $this->created;
    }
    public function getFileExt()
    {
        return $this->ext;
    }
    public function getParentFolder()
    {
        return $this->parentfolder;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public static function getTopDownloads()
    {
        $c=new collection();
        $sql="SELECT filename,count(*)as top FROM docman_u_f,docman_file
              WHERE file=idf
              GROUP BY file
              HAVING 1=1 ORDER BY top DESC LIMIT 10";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $b=new collection();
            $b->add($row['filename']);
            $b->add($row['top']);
            $c->add($b);
        }
        return $c;
    }
    public function getSharedFiles()
    {
        $c=new collection();
        $f=NULL;
        $sql="SELECT * FROM docman_file,docman_permission WHERE idf=file AND groups LIKE 'r%'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new file($row['idf'], $row['filename'], $row['filesize'], $row['created'], $row['ext'], $row['parentfolder'], $row['user'],$row['status'],$row['path']);
            $c->add($f);
        }
        return $c;
    }
    public static function searchFiles($param)
    {
        $p=$_SESSION['path'];
        $c=new collection();
        $f=NULL;
        $sql="SELECT *
              FROM docman_file,docman_permission WHERE docman_file.idf=docman_permission.file
              AND filename LIKE '%$param%' AND status='1' AND (groups LIKE 'r%' OR path LIKE '$p%')";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new file($row['idf'], $row['filename'], $row['filesize'], $row['created'], $row['ext'], $row['parentfolder'], $row['user'],$row['status'],$row['path']);
            $c->add($f);
        }
        return $c;
    }
    public static function getFilesRecicled($idu)
    {
        $c=new collection();
        $f=NULL;
        $sql="SELECT * 
              FROM docman_file
              WHERE status ='0'
              AND user='$idu'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new file($row['idf'], $row['filename'], $row['filesize'], $row['created'], $row['ext'], $row['parentfolder'], $row['user'],$row['status']);
            $c->add($f);
        }
        return $c;
    }
    public static function getFilePath(file $file)
    {
        $p=$file->getParentFolder();
        $sql="SELECT path
              FROM docman_file,docman_folder
              WHERE docman_file.parentfolder=docman_folder.idf AND
              docman_folder.idf='$p'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            return $row['path'];
        }
        return null;
    }
    public function getPath()
    {
        $sql="SELECT path,docman_folder.idf
              FROM docman_file,docman_folder
              WHERE docman_file.parentfolder=docman_folder.idf AND
              docman_folder.idf='$this->parentfolder'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            return $row['path'].$row['idf'];
        }
        return null;
    }
    public static function getFileById($idf)
    {
        $f=NULL;
        $sql="SELECT * FROM docman_file,docman_permission where idf='$idf' AND idf=file";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new file($row['idf'], $row['filename'], $row['filesize'], $row['created'], $row['ext'], $row['parentfolder'], $row['user'],$row['status'],$row['path']);
            $f->setPermissions(new permissions($row['file'], $row['users'], $row['groups']));
        }
        return $f;
    }
    public function deleteFile()
    {
        $sql="UPDATE docman_file SET status='0' WHERE idf='$this->idf'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public function rename($newname)
    {
        $sql="UPDATE docman_file SET filename='$newname' WHERE idf='$this->idf'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public function updateFilePermissions()
    {
        $u=$this->permissions->getUsers();
        $g=$this->permissions->getGroups();
        $sql="UPDATE docman_permission SET users='$u', groups='$g' WHERE file='$this->idf'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public function trueDeleteFile()
    {
        $sql="DELETE FROM docman_file WHERE idf='$this->idf'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public function saveGroup()
    {
        $sql="INSERT INTO docman_group(idg,name)
        VALUES ('','$this->name')";
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
