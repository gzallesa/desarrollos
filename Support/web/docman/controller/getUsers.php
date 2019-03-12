<?php
require_once '../lib/db.php';
require_once '../lib/user.php';
require_once '../lib/collection.php';
session_start();
//echo $_SESSION['user']->getType();
if($_SESSION['user']->getType()=='0')
{
    $u=user::getUsersGroups();
}
if($_SESSION['user']->getType()=='1')
{
    $g=user::getGroupsByUser2($_SESSION['user']->getIDU());
    $u=user::getUsersByGroup($g->getElement(0)->getElement(1),$_SESSION['user']->getIDU());
}
if($_SESSION['user']->getType()=='2')
{
    $g=user::getGroupsByUser2($_SESSION['user']->getIDU());
    $u=user::getUsersByGroup($g->getElement(0)->getElement(1),$_SESSION['user']->getIDU());
}
echo '<?xml version="1.0" encoding="UTF-8"?><rows>';
for($i=0;$i<$u->length();$i++)
{
    $user=$u->getElement($i);
    echo '<row id="u'.$i.'">
            <cell><![CDATA[<div style="font-weight: bold;text-transform:uppercase;">'.$user->getElement(1).'</div><div style="text-transform:lowercase;">'.$user->getElement(4).'</div>]]></cell>';
    if($user->getElement(2)=='1')
    {
        echo'<cell><![CDATA[<button onclick="desactivarU('.$user->getElement(0).')" class="activar"  title="Deshabilitar"></button>]]></cell>';
    }else
    {
        echo'<cell><![CDATA[<button onclick="activarU('.$user->getElement(0).')" class="desactivar" title="Habilitar"></button>]]></cell>';
    }
    if($_SESSION['user']->getType()=='0')
    {
        if($user->getElement(3)!=NULL)
        {
            echo'<cell><![CDATA[<a href="javascript:asignar('.$user->getElement(0).')">'.user::getGroupsByUser($user->getElement(0)).'</a>]]></cell>';
        }else
        {
            echo'<cell><![CDATA[<a href="javascript:asignar('.$user->getElement(0).')">Asignar Grupo</a>]]></cell>';
        }
    }
    else
    {
        echo'<cell><![CDATA['.user::getGroupsByUser($user->getElement(0)).']]></cell>';
    }
    echo'<cell><![CDATA[<a href="javascript:modiftipo('.$user->getElement(0).')">'.$user->getElement(5).'</a>]]></cell>';
    echo'<cell><![CDATA[<button onclick="edituser('.$user->getElement(0).')" class="lapiz"></button>]]></cell>
         <cell><![CDATA[<button onclick="deleteuser('.$user->getElement(0).')" class="eliminar"></button>]]></cell>
        </row>';
}
echo '</rows>';
header('Content-type:text/xml;');
?>
