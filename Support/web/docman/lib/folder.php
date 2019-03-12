<?php
require_once 'collection.php';
require_once 'file.php';
require_once 'permissions.php';
/**
 * Description of folder
 *
 * @author Irra_b
 */
class folder {
    private $idf;
    private $name;
    private $path;
    private $parentfolder;
    private $datecreated;
    private $user;
    private $permissions;
    public function __construct($idf,$name,$path,$parentfolder,$datecreated,$user)
    {
        $this->idf=$idf;
        $this->name=$name;
        $this->path=$path;
        $this->parentfolder=$parentfolder;
        $this->datecreated=$datecreated;
        $this->user=$user;
        $this->permissions=new permissions($this->idf=$idf, 'r--', '---');
    }
    public function setPermissions(permissions $p)
    {
        $this->permissions=$p;
    }
    public function getPermissions()
    {
        return $this->permissions;
    }
    public function getIDF()
    {
        return $this->idf;
    }
    public function setName($newname)
    {
        $this->name=$newname;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getUser()
    {
        return $this->user;
    }
    public function getPath()
    {
        return $this->path;
    }
    public function getParentFolder()
    {
        return $this->parentfolder;
    }
    public function getDateCreation()
    {
        return $this->datecreated;
    }
    public function getShareFolders()
    {
        $f=NULL;
        $folders=new collection();
        $sql="SELECT * FROM docman_folder
              WHERE parentfolder='0' AND status='1' AND idf<>'$this->idf'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new folder($row['idf'], $row['name'], $row['path'], $row['parentfolder'], $row['createdate'],$row['user']);
            //$f->setPermissions(new permissions($row['file'], $row['users'], $row['groups']));
            $folders->add($f);
        }
        return $folders;
    }
    public function getFolders()
    {
        $f=NULL;
        $folders=new collection();
        $sql="SELECT * FROM docman_folder,docman_folder_permission
              WHERE parentfolder='$this->idf' AND status='1' AND file=idf";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new folder($row['idf'], $row['name'], $row['path'], $row['parentfolder'], $row['createdate'],$row['user']);
            $f->setPermissions(new permissions($row['file'], $row['users'], $row['groups']));
            $folders->add($f);
        }
        return $folders;
    }
    public function isGroupFolder()
    {
        $sql="SELECT * FROM docman_folder
              WHERE parentfolder='0' AND idf='$this->idf'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            return 1;
        }
        return 0;
    }
    public static function getCirculars()
    {
        $f=NULL;
        $files=new collection();
        $sql="SELECT docman_file.idf,docman_file.filename,docman_file.created,docman_file.ext,docman_file.filesize,docman_file.parentfolder,docman_file.user,docman_file.status,docman_file.path,docman_permission.file,docman_permission.groups,docman_permission.users
              FROM docman_folder,docman_file,docman_permission,
			(SELECT docman_folder.parentfolder as pf,docman_folder.name, docman_folder.idf as idfolder from docman_folder
			 WHERE docman_folder.name='circulares')as tbl1
              WHERE docman_folder.idf=tbl1.pf AND docman_file.parentfolder=tbl1.idfolder AND docman_file.status='1' AND docman_file.idf=docman_permission.file order by docman_file.created desc limit 6";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new file($row['idf'], $row['filename'], $row['filesize'], $row['created'], $row['ext'], $row['parentfolder'],$row['user'],$row['status'],$row['path']);
            $f->setPermissions(new permissions($row['file'], $row['users'], $row['groups']));
            $files->add($f);
        }
        return $files;
    }

    public function getFiles()
    {
        $f=NULL;
        $files=new collection();
        $sql="SELECT * FROM docman_file,docman_permission WHERE parentfolder='$this->idf' AND status='1' AND file=idf ORDER BY created DESC";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new file($row['idf'], $row['filename'], $row['filesize'], $row['created'], $row['ext'], $row['parentfolder'],$row['user'],$row['status'],$row['path']);
            $f->setPermissions(new permissions($row['file'], $row['users'], $row['groups']));
            $files->add($f);
        }
        return $files;
    }
    public function getFilesByDate($fecha)
    {
        $f=NULL;
        $files=new collection();
        $sql="SELECT * FROM(SELECT idf,filename,created,ext,filesize,parentfolder,docman_file.user,docman_file.status,path,file,users,groups,SUBSTR(created,1,10)AS f1 FROM docman_file,docman_permission 
        WHERE parentfolder='$this->idf' AND status='1' AND file=idf ORDER BY created DESC)as tbl1 WHERE tbl1.f1='$fecha'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new file($row['idf'], $row['filename'], $row['filesize'], $row['created'], $row['ext'], $row['parentfolder'],$row['user'],$row['status'],$row['path']);
            $f->setPermissions(new permissions($row['file'], $row['users'], $row['groups']));
            $files->add($f);
        }
        return $files;
    }
    public function getShareFiles()
    {
        $f=NULL;
        $files=new collection();
        $sql="SELECT docman_permission.groups,docman_permission.users,docman_permission.file,docman_file.idf,docman_file.path,docman_file.filename,docman_file.filesize,docman_file.created,docman_file.ext,docman_file.parentfolder,docman_file.user,docman_file.status 
              FROM docman_folder,docman_file,docman_permission
              WHERE docman_folder.path like '$this->idf%'
              AND groups like 'r%' 
              AND docman_folder.idf=docman_file.parentfolder
              AND docman_file.idf=file";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new file($row['idf'], $row['filename'], $row['filesize'], $row['created'], $row['ext'], $row['parentfolder'],$row['user'],$row['status'],$row['path']);
            $f->setPermissions(new permissions($row['file'], $row['users'], $row['groups']));
            $files->add($f);
        }
        return $this->getRootShareFiles($files);
    }    
    private function getRootShareFiles($files)
    {
        $f=NULL;
        $sql="SELECT docman_permission.groups,docman_permission.users,docman_permission.file,docman_file.idf,docman_file.path,docman_file.filename,docman_file.filesize,docman_file.created,docman_file.ext,docman_file.parentfolder,docman_file.user,docman_file.status 
              FROM docman_folder,docman_file,docman_permission
              WHERE docman_file.parentfolder='$this->idf'
              AND groups like 'r%' 
              AND docman_folder.idf=docman_file.parentfolder
              AND docman_file.idf=file";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new file($row['idf'], $row['filename'], $row['filesize'], $row['created'], $row['ext'], $row['parentfolder'],$row['user'],$row['status'],$row['path']);
            $f->setPermissions(new permissions($row['file'], $row['users'], $row['groups']));
            $files->add($f);
        }
        return $files;
    }    
    public static function getPathByIDFolder($idf)
    {
        $sql="SELECT * FROM docman_folder where idf='$idf'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            return $row['path'].$row['idf'].'/';
        }
        return NULL;
    }
    public function getParentFolderObject()
    {
        return $this->getFolderById($this->parentfolder);
    }
    public static function getFolderById($idf)
    {
        $f=NULL;
        $sql="SELECT * FROM docman_folder, docman_folder_permission where idf='$idf' AND idf=file";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new folder($row['idf'], $row['name'], $row['path'], $row['parentfolder'], $row['createdate'],$row['user']);
            $f->setPermissions(new permissions($row['file'], $row['users'], $row['groups']));
        }
        return $f;
    }
    public function getFolderByName($name)
    {
        $f=NULL;
        $folders=new collection();
        $sql="SELECT * FROM docman_folder,docman_folder_permission
              WHERE parentfolder='$this->idf' AND status='1' AND file=idf AND name='$name'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new folder($row['idf'], $row['name'], $row['path'], $row['parentfolder'], $row['createdate'],$row['user']);
            $f->setPermissions(new permissions($row['file'], $row['users'], $row['groups']));
            $folders->add($f);
        }
        return $folders;
    }
    public static function getFolderNameById($idf)
    {
        $f=NULL;
        $sql="SELECT * FROM docman_folder where idf='$idf'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            return $row['name'];
        }
        return null;
    }
    public function addFile(file $file)
    {
        $f[0]=$file->getFileName();
        $f[1]=$file->getDateCreation();
        $f[2]=$file->getFileExt();
        $f[3]=$file->getFileSize();
        $f[4]=$file->getParentFolder();
        $f[5]=$file->getUser();
        $f[6]=$file->getPathFile();
        $sql="INSERT INTO docman_file(idf,filename,created,ext,filesize,parentfolder,user,status,path)
        VALUES ('','$f[0]','$f[1]','$f[2]','$f[3]','$f[4]','$f[5]','1','$f[6]')";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            $p=new permissions(mysql_insert_id(), $file->getPermissions()->getUsers(), $file->getPermissions()->getGroups());
            return $this->savePermissions($p);
        }else
        {
            return 0;
        }
    }    
    public function updateFilePermissions()
    {
        $u=$this->permissions->getUsers();
        $g=$this->permissions->getGroups();
        $sql="UPDATE docman_folder_permission SET users='$u', groups='$g' WHERE file='$this->idf'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    
    private function savePermissions(permissions $p)
    {
        $f[0]=$p->getFile();
        $f[1]=$p->getUsers();
        $f[2]=$p->getGroups();
        $sql="INSERT INTO docman_permission(file,users,groups)
        VALUES ('$f[0]','$f[1]','$f[2]')";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public function addFolder(folder $folder)
    {
        return $folder->saveFolder();
    }
    public function renameFolder()
    {
        $sql="UPDATE docman_folder SET name='$this->name' WHERE idf='$this->idf'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    private function getNextID()
    {
        $sql="SELECT * FROM docman_folder order by idf DESC LIMIT 1";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            return $row['idf']+1;
        }
        return FALSE;
    }
    public function saveFolder()
    {
        $this->idf=$this->getNextID();
        //echo $this->getPath().$this->idf;
        if(!mkdir('../rootfolder/'.$this->getPath().$this->idf))
        {
            echo('Error al crear el directorio...');
            exit();
        }
        chmod('../rootfolder/'.$this->getPath().$this->idf, 0777); 
        $sql="INSERT INTO docman_folder(idf,name,path,parentfolder,createdate,status,user)
        VALUES ('','$this->name','$this->path','$this->parentfolder','$this->datecreated','1','$this->user')";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            $this->idf=mysql_insert_id();
            $p=new permissions($this->idf, 'r--', '---');
            return $this->savePermissionsFolder($p);
        }else
        {
            return 0;
        }
    }
    private function savePermissionsFolder(permissions $p)
    {
        $f[0]=$p->getFile();
        $f[1]=$p->getUsers();
        $f[2]=$p->getGroups();
        $sql="INSERT INTO docman_folder_permission(file,users,groups)
        VALUES ('$f[0]','$f[1]','$f[2]')";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public function getSubFolders()
    {
        $f=NULL;
        $files=new collection();
        $sql="SELECT * FROM docman_folder where parentfolder='$this->idf' AND status='1'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new folder($row['idf'], $row['name'], $row['path'], $row['parentfolder'], $row['createdate'],$row['user']);
            $files->add($f);
        }
        return $files;
    
    }
    public function deleteFolder()
    {
        $sql="UPDATE docman_folder SET status='0' WHERE idf='$this->idf'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return $this->deleteFiles();
        }else
        {
            return 0;
        }
    }
    public function deleteFolder2()
    {
        $sql="DELETE FROM docman_folder
              WHERE ìdf='$this->idf'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public function deleteFiles()
    {
        $sql="UPDATE docman_file SET status='0' WHERE parentfolder='$this->idf'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public function trueDeleteFolder()
    {
        $sql="DELETE FROM docman_folder WHERE idf='$this->idf' OR parentfolder='$this->idf'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return $this->trueDeleteFiles();
        }else
        {
            return 0;
        }
    }
    public function trueDeleteFiles()
    {
        $sql="DELETE FROM docman_file WHERE parentfolder='$this->idf'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    private function existeFolder($folder)
    {
        if(file_exists('../rootfolder/'.$this->name.'/'.$folder))
        {
           return TRUE; 
        }
        return FALSE;
    }
    public function existeFile($filename)
    {
        $sql="SELECT * FROM docman_file where parentfolder='$this->idf' AND status='1' AND filename='$filename'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            return true;
        }
        return FALSE;
    }
    public function getRecycledFolders()
    {
        $f=NULL;
        $files=new collection();
        $sql="SELECT * FROM docman_folder where parentfolder='$this->idf' AND status='0'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new folder($row['idf'], $row['name'], $row['path'], $row['parentfolder'], $row['createdate']);
            $files->add($f);
        }
        return $files;
    }
    public function getRecycledFiles()
    {
        $f=NULL;
        $files=new collection();
        $sql="SELECT * FROM docman_file where parentfolder='$this->idf' AND status='0' ORDER BY created";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new file($row['idf'], $row['filename'], $row['filesize'], $row['created'], $row['ext'], $row['parentfolder'],$row['user'],$row['status']);
            $files->add($f);
        }
        return $files;
    }
    public function getRecycledFiles2($idu)
    {
        $f=NULL;
        $files=new collection();
        $sql="SELECT * FROM docman_file where status='0' AND user='$idu' ORDER BY created";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new file($row['idf'], $row['filename'], $row['filesize'], $row['created'], $row['ext'], $row['parentfolder'],$row['user'],$row['status']);
            $files->add($f);
        }
        return $files;
    }
    
}

