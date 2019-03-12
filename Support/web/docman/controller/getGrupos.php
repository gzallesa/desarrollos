<?php
require_once '../lib/db.php';
require_once '../lib/group.php';
require_once '../lib/user.php';
session_start();
if($_SESSION['user']->getUserType1()=='0')
{
    $g=group::getGroups();
    echo '<?xml version="1.0" encoding="UTF-8"?><rows>';
    for($i=0;$i<$g->length();$i++)
    {
        $grupo=$g->getElement($i);
        if($grupo->getIDG()!=$p)
        {
            echo '<row id="'.$i.'">
                <cell><![CDATA[<div style="font-weight: bold;">'.$grupo->getLongName().'</div>]]></cell>
                <cell><![CDATA[<a href="javascript:test('.$grupo->getIDG().')">Administrar</a>]]></cell>
                <cell><![CDATA[<button onclick="editGroup('.$grupo->getIDG().')" class="lapiz"></button>]]></cell>
                <cell><![CDATA[<button onclick="deleteGroup('.$grupo->getIDG().')" class="eliminar"></button>]]></cell>
            </row>';
        }else
        {

        }
    }
    echo '</rows>';
}
if($_SESSION['user']->getUserType1()=='1')
{
    $g=group::getGroups();
    echo '<?xml version="1.0" encoding="UTF-8"?><rows>';
    for($i=0;$i<$g->length();$i++)
    {
        $grupo=$g->getElement($i);
        if($grupo->getIDG()!=$p)
        {
            echo '<row id="'.$i.'">
                <cell><![CDATA[<div style="font-weight: bold;">'.$grupo->getLongName().'</div>]]></cell>
                <cell>-</cell>
                <cell>-</cell>
                <cell>-></cell>
            </row>';
        }else
        {

        }

    }
    echo '</rows>';
}
header('Content-type:text/xml;')
?>
