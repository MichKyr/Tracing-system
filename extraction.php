<?php require('header.php');?>
<?php

if(!empty($_REQUEST['p'])){
echo "<td align=\"center\">";
//echo $_REQUEST['p'];
}
/*
SELECT DISTINCT ExtractionSite.* FROM ExtractionSite INNER JOIN Lot INNER JOIN FromLot WHERE ExtractionSite.ExtractionSiteID=Lot.ExtractionSiteID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=1;
+------------------+--------------+--------------+----------+----------+------------------------------+-------------+----------------------------+-------------------------------+
| ExtractionSiteID | Name         | OwnerName    | City     | Address  | Coordinates                  | Phonenumber | Photo                      | OwnerPhoto                    |
+------------------+--------------+--------------+----------+----------+------------------------------+-------------+----------------------------+-------------------------------+
|                1 | K.Nikolaidis | K.Nikolaidis | Kalamata | Kapou 23 | 22.058825,37.072956,0.000000 |  2147483647 | ./photos/ep-1-extrsite.jpg | ./photos/eop-1-extrowner.jpeg |
+------------------+--------------+--------------+----------+----------+------------------------------+-------------+----------------------------+-------------------------------+

*/
if(!($stmt_trace_exsite->bind_param("i",$_REQUEST['p']))){
		echo "fail bind";
		};
if(!($stmt_trace_exsite->execute())){
		echo "fail";
		};

    /* bind result variables */
if(!($stmt_trace_exsite->bind_result($eid, $ename, $eownername, $ecity , $eadress , $ecoordinates, $ephone, $ephoto, $eownerphoto))){
		echo "fail res";
		};
echo <<<EOF
<table>
	<tr>
	<td width="100%" valign="top" align="center">Information about the Extraction Site(s):
	<tr>
	
EOF;

while ($stmt_trace_exsite->fetch()) {

echo "<tr><td align=\"center\"><table width=40% class=\"simplelist\"><td align=\"right\">Extraction Site Name:<td align=\"left\">".$ename."<tr><td align=\"right\">Owner Name:<td align=\"left\">".$eownername."<tr><td align=\"right\">City:<td align=\"left\">".$ecity."<tr><td align=\"right\">Adress:<td align=\"left\">".$eadress."<tr><td width=29 align=\"right\">Coordinates:<td align=\"left\">".$ecoordinates."<tr><td align=\"right\">Phone:<td align=\"left\">".$ephone."</table></td></tr>";
echo '<tr><td align="center"><img src="'.$eownerphoto.'"  alt="owner.jpg" />';
echo '<tr><td align="center"><img src="'.$ephoto.'"  alt="extractionsite.jpg" />';
//echo '<tr><td><iframe width="700" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'."https://www.oliveo.com/olitrace/kmls/e-".$eid.'.kml"&amp;t=h&amp;ie=UTF8&amp;output=embed"></iframe><br />';
if ($eid == 1) {
    $link="https://drive.google.com/file/d/0B3r3ylCfyQ-zRFA2bUxKVjk5MDg/edit?usp=sharing";
} elseif ($eid == 2) {
    $link="";
} elseif ($eid == 3) {
   $link="";
}
echo '<tr><td><iframe width="700" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$link.'.&amp;t=s&amp;ie=UTF8&amp;output=iframe"></iframe><br />';
}


echo <<<EOF

	</tr>
</table>
EOF;
?>
<?php require('footer.php');?>
