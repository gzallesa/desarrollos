<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
if(!(isset($_SESSION['user'])))
{
    header("location:index.php");
    exit();
}
?>
