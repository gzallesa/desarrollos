<?php
require_once 'collection.php';
/**
 * Description of Anunciante
 *
 * @author Irra_b
 */
class user
{
    private $IDU;
    private $name;
    private $email;
    private $username;
    private $password;
    private $movil;
    private $interno;
    private $ci;
    private $datereg;
    private $lastaccess;
    private $state;
    private $type;
    private $telefono;
    private $direccion;
    private $telefref;
    private $numseguro;
    public function __construct($id,$name,$email,$username,$password,$movil,$interno,$ci,$datereg,$lastaccess,$state,$type,$telefono,$direccion,$telefref,$numseguro)
    {
        $this->IDU=$id;
        $this->name=$name;
        $this->email=$email;
        $this->username=$username;
        $this->password=$password;
        $this->movil=$movil;
        $this->interno=$interno;
        $this->ci=$ci;
        $this->datereg=$datereg;
        $this->lastaccess=$lastaccess;
        $this->state=$state;
        $this->type=$type;
        $this->telefono=$telefono;
        $this->direccion=$direccion;
        $this->telefref=$telefref;
        $this->numseguro=$numseguro;
    }
    public function getUserName()
    {
        return $this->username;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getDireccion()
    {
        return $this->direccion;
    }
    public function getTelRef()
    {
        return $this->telefref;
    }
    public function getNumSegMed()
    {
        return $this->numseguro;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getState()
    {
        return $this->state;
    }
    public function getDateReg()
    {
        return $this->datereg;
    }
    public function getLastAccess()
    {
        return $this->lastaccess;
    }
    public function getIDU()
    {
        return $this->IDU;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getMovil()
    {
        return $this->movil;
    }
    public function getInterno()
    {
        return $this->interno;
    }
    public function getCI()
    {
        return $this->ci;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getName()
    {
        return $this->name;
    }
    public static function existeUser($username)
    {
        $sql="SELECT * FROM docman_user where username='$username'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            echo TRUE;
        }else
        {
            echo FALSE;
        }
    }
    public static function searchUser($criterio)
    {
        $users=new collection();
        $sql="SELECT * FROM docman_user WHERE name LIKE '%$criterio%' or email LIKE '%$criterio%' or interno LIKE '%$criterio%' or ci LIKE '%$criterio%' GROUP BY name";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $u=new user($row['id'], $row['name'], $row['email'],$row['password'], $row['password'], $row['movil'], $row['interno'], $row['ci'], $row['datereg'], $row['lastaccess'], $row['state'], $row['type'], $row['telefono'], $row['direccion'], $row['telefref'], $row['numseguro']);
            $users->add($u);
        }
        return $users;
    }
    public static function getUsersGroups()
    {
        $u=new collection();
        $sql="SELECT type,id,name,state,ingroup,email FROM docman_user LEFT JOIN docman_g_u ON user=id GROUP BY id";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            if($row['type']!=0)
            {
                $usu=new collection();
                $usu->add($row['id']);
                $usu->add($row['name']);
                $usu->add($row['state']);
                $usu->add($row['ingroup']);
                $usu->add($row['email']);
                $usu->add(user::getUserType($row['type']));
                $u->add($usu);
            }
        }
        return $u;
    }
    public static function getUsersByGroup($idg,$id)
    {
        $u=new collection();
        $sql="SELECT * FROM docman_user,docman_g_u 
              WHERE user=id AND ingroup='$idg' AND type<>'0' AND id<>'$id' GROUP BY id";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $usu=new collection();
            $usu->add($row['id']);
            $usu->add($row['name']);
            $usu->add($row['state']);
            $usu->add($row['ingroup']);
            $usu->add($row['email']);
            $usu->add(user::getUserType($row['type']));
            $u->add($usu);
        }
        return $u;
    }
    private static function getUserType($type)
    {
        switch ($type) {
            case 0:
                return 'root';
                break;
            case 1:
                return 'Administrador';
                break;
            case 2:
                return'Estandar';
                break;
        }
    }
    public function getUserType1()
    {
        $sql="SELECT * FROM docman_user WHERE id='$this->IDU'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            return $row['type'];
        }
        return null;
    }
    public static function getGroupsByUser($id)
    {
        $u='';
        $sql="SELECT longname FROM docman_g_u,docman_group WHERE idg=ingroup AND user='$id'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $u=$u.$row['longname'].'<br>';
        }
        return substr($u, 0, strlen($u)-1);
    }
    public function getGroup()
    {
        $sql="SELECT longname FROM docman_g_u,docman_group WHERE idg=ingroup AND user='$this->IDU'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            return $row['longname'];
        }
        return NULL;
    }
    public static function getBirthdaysUsers()
    {
        $c=new collection();
        $f=date("n");   
        $sql="SELECT * 
              FROM(SELECT docman_user.fechanac,MONTH(docman_user.fechanac) AS c1,docman_user.name FROM docman_user)AS t1 WHERE t1.c1='$f'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $u=new collection();
            //$u->add($row['c1']);
            $u->add($row['fechanac']);
            $u->add($row['name']);
            $c->add($u);
            
        }
        return $c;
    }
    public static function getBirthDays()
    {
        $c=new collection();
        $sql="SELECT docman_user.id,docman_user.fechanac,docman_user.name FROM docman_user order by id";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $u=new collection();
            $u->add($row['name']);
            $u->add($row['fechanac']);
            $u->add($row['id']);
            $c->add($u);
        }
        return $c;
    }
    public static function getUsersBirthDaysNow()
    {
        $c=new collection();
        $f=date("m-d");   
        $sql="SELECT * FROM(SELECT docman_user.fechanac,SUBSTRING(docman_user.fechanac,6) AS c1,docman_user.name FROM docman_user)AS t1 
                       WHERE t1.c1='$f'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $u=new collection();
            $u->add($row['fechanac']);
            $u->add($row['name']);
            $c->add($u);
        }
        return $c;
    }

    public function getIdGroup()
    {
        $sql="SELECT idg FROM docman_g_u,docman_group WHERE idg=ingroup AND user='$this->IDU'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            return $row['idg'];
        }
        return NULL;
    }
    public static function getGroupsByUser2($id)
    {
        $gu=new collection();
        $sql="SELECT longname,user,ingroup,folder FROM docman_g_u,docman_group WHERE idg=ingroup AND user='$id'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $u=new collection();
            $u->add($row['user']);
            $u->add($row['ingroup']);
            $u->add($row['longname']);
            $u->add($row['folder']);
            $gu->add($u);
        }
        return $gu;
    }
    public static function getUsersUnGroups()
    {
        $u=new collection();
        $sql="SELECT * FROM docman_user,docman_g_u WHERE id=user AND ingroup=0";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $usu=new collection();
            $usu->add($row['id']);
            $usu->add($row['name']);
            $usu->add($row['state']);
            $u->add($usu);
        }
        return $u;
    }
    public static function getUserByID($id)
    {
        $f=NULL;
        $sql="SELECT * FROM docman_user where id='$id'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new user($row['id'], $row['name'], $row['email'],$row['username'], $row['password'], $row['movil'], $row['interno'], $row['ci'], $row['datereg'], $row['lastaccess'], $row['state'],$row['type'],$row['telefono'],$row['direccion'],$row['telefref'],$row['numseguro']);
        }
        return $f;
    }
    public static function getUserByName($name)
    {
        $f=NULL;
        $sql="SELECT * FROM docman_user where email='$name'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new user($row['id'], $row['name'], $row['email'],$row['username'], $row['password'], $row['movil'], $row['interno'], $row['ci'], $row['datereg'], $row['lastaccess'], $row['state'],$row['type'],$row['telefono'],$row['direccion'],$row['telefref'],$row['numseguro']);
        }
        return $f;
    }
    public static function getUserByCI($ci)
    {
        $f=NULL;
        $sql="SELECT * FROM docman_user where ci='$ci'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new user($row['id'], $row['name'], $row['email'],$row['username'], $row['password'], $row['movil'], $row['interno'], $row['ci'], $row['datereg'], $row['lastaccess'], $row['state'],$row['type'],$row['telefono'],$row['direccion'],$row['telefref'],$row['numseguro']);
        }
        return $f;
    }

    public static function getUserByUserName($name)
    {
        $f=NULL;
        $sql="SELECT * FROM docman_user where username='$name'";
        $r=mysql_query($sql)or die(mysql_error());
        while($row=mysql_fetch_assoc($r))
        {
            $f=new user($row['id'], $row['name'], $row['email'],$row['username'], $row['password'], $row['movil'], $row['interno'], $row['ci'], $row['datereg'], $row['lastaccess'], $row['state'],$row['type'],$row['telefono'],$row['direccion'],$row['telefref'],$row['numseguro']);
        }
        return $f;
    }
    public function saveUser()
    {
        $sql="INSERT INTO docman_user(id,name,email,username,password,movil,interno,ci,datereg,lastaccess,state,type,telefono,direccion,telefref,numseguro)
        VALUES ('','$this->name','$this->email','$this->username','$this->password','$this->movil','$this->interno','$this->ci','$this->datereg','','$this->state','$this->type','$this->telefono','$this->direccion','$this->telefref','$this->numseguro')";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            $this->IDU= mysql_insert_id();
            return 1;
        }else
        {
            return 0;
        }
    }
    public function updateUser()
    {
        $sql="UPDATE docman_user SET name='$this->name', 
                                  email='$this->email', 
                                  username='$this->username',     
                                  password='$this->password', 
                                  movil='$this->movil', 
                                  interno='$this->interno', 
                                       ci='$this->ci', 
                                  telefono='$this->telefono',     
                                  direccion='$this->direccion', 
                                  telefref='$this->telefref', 
                                  numseguro='$this->numseguro' 
                                  WHERE id='$this->IDU'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public function updateUser2()
    {
        $sql="UPDATE docman_user SET name='$this->name', 
                                  password='$this->password', 
                                  movil='$this->movil', 
                                  interno='$this->interno', 
                                       ci='$this->ci', 
                                  telefono='$this->telefono',     
                                  direccion='$this->direccion', 
                                  telefref='$this->telefref', 
                                  numseguro='$this->numseguro' 
                                  WHERE id='$this->IDU'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }

    public function setActive($state)
    {
        $sql="UPDATE docman_user SET state='$state' WHERE id='$this->IDU'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public function setType($type)
    {
        $sql="UPDATE docman_user SET type='$type' WHERE id='$this->IDU'";
        $r=mysql_query($sql)or die(mysql_error());
        if($r==1)
        {
            return 1;
        }else
        {
            return 0;
        }
    }
    public static function deleteUser($id)
    {
        $sql="DELETE FROM docman_user WHERE id='$id'";
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
