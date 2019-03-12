<?php
require_once '../lib/db.php';
require_once '../lib/event.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if(event::deleteEvent($_POST['ida']))
{
    echo 'Eliminado';
}else
{
    echo 'error al eliminar';
}
?>
