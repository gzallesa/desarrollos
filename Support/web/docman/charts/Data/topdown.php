<?php
require_once "../../lib/db.php";
require_once "../../lib/file.php";
require_once "../../lib/collection.php";
$c=new collection();
$c=file::getTopDownloads();
echo '
<graph numdivlines="4" lineThickness="3" showValues="0" numVDivLines="10" formatNumberScale="1" rotateNames="1" decimalPrecision="1" anchorRadius="2" anchorBgAlpha="0" numberPrefix="" divLineAlpha="30" showAlternateHGridColor="1" yAxisMinValue="800000" shadowAlpha="50" >
<categories >';
for($i=0;$i<$c->length();$i++)
{
    echo '<category Name="'.$c->getElement($i)->getElement(0).'" />';
}
echo'</categories>
<dataset seriesName="" color="#0059B2" anchorBorderColor="#FFFFFF" anchorRadius="5">';
for($i=0;$i<$c->length();$i++)
{
    echo '<set value="'.$c->getElement($i)->getElement(1).'" />';
}
echo '
</dataset>
</graph>
';
header('content-type:application/xml');
?>
