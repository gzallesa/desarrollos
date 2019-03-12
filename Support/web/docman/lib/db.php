<?php
define('DB_HOST', 'bds.oopp.gob.bo');
define('DB_USER', 'docman');
define('DB_PASSWORD', 'uDMJzX2u9SEvPnQWUyjr');
define('DB_NAME', 'docman');
if(!$GLOBALS['DB']=  mysql_connect(DB_HOST,DB_USER,DB_PASSWORD))
{
    die ('Error');
}
if(!mysql_select_db(DB_NAME,$GLOBALS['DB']))
{
    mysql_close($GLOBALS['DB']);
    die ('Error abriendo bd');
}

//echo $GLOBALS['DB'];
