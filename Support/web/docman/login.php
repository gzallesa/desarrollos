<?php
require_once 'lib/db.php';
require_once 'lib/user.php';
require_once 'lib/group.php';
$u=user::getUserByUserName($_POST['usuario']);
if(!is_null($u))
{
        if($u->getUserName()==$_POST['usuario'] and $u->getPassword()== $_POST['password'] and $u->getState()=='1')
        {
            session_start();
            $_SESSION['user']=$u;
            $p=user::getGroupsByUser2($u->getIDU());
            $_SESSION['paths']=$p;
            header( "location:panel.php" );
        }else
        {
            if($u->getState()=='0')
            {
                header( "location:index.php?stat=2" );
                return;
            }
            header( "location:index.php?stat=1" );
        }
}  else {
    header( "location:index.php?stat=0" );
}
 ?>
