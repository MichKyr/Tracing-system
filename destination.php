<?php require('header.php');?>
<?php

if(!empty($_REQUEST['p'])){
echo "<td align=\"center\">";
//echo $_REQUEST['p'];
}
/*
SELECT DISTINCT OliveoPartner.* FROM OliveoPartner INNER JOIN Pallete WHERE OliveoPartner.PartnerID=Pallete.PartnerID AND PalleteID=1;
+-----------+----------------+------------------------------+--------------+--------+--------------------------+
| PartnerID | Name           | Coordinates                  | Country      | City   | Photo                    |
+-----------+----------------+------------------------------+--------------+--------+--------------------------+
|         1 | Naveen Bigdeli | 39.134674,21.663172,0.000000 | Saudi Arabia | Jeddah | ./photos/op-1-person.jpg |
+-----------+----------------+------------------------------+--------------+--------+--------------------------+

*/
if(!($stmt_trace_dest->bind_param("i",$_REQUEST['p']))){
		echo "fail bind";
		};
if(!($stmt_trace_dest->execute())){
		echo "fail";
		};

    /* bind result variables */
if(!($stmt_trace_dest->bind_result($pid, $pname,$pcoordinates,$pcountry,$pcity,$pphoto))){
		echo "fail res";
		};
echo <<<EOF
<table>
	<tr>
	<td width="100%" valign="top" align="center">Information about the Destination(Oliveo Partner):
	<tr>
	
EOF;

while ($stmt_trace_dest->fetch()) {

echo "<td align=\"center\"><table width=40% class=\"simplelist\"><td>Partner Name:<td>".$pname."<tr><td width=29>Coordinates:<td>".$pcoordinates."<tr><td>Country :<td>".$pcountry."<tr><td>City:<td>".$pcity."</table>";
echo '<tr><td><img src="'.$pphoto.'"  alt="extractionsite.jpg" />';
//echo '<tr><td><iframe width="700" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'."https://www.oliveo.com/olitrace/kmls/o-".$pid.'.kml"&amp;t=h&amp;ie=UTF8&amp;output=embed"></iframe><br />';
if ($pid == 1) {
    $link="https://drive.google.com/file/d/0B3r3ylCfyQ-zdm50ZC1qM0RnRVE/edit?usp=sharing";
} elseif ($pid == 2) {
    $link="https://drive.google.com/file/d/0B3r3ylCfyQ-zMjdQWHdKVkVzT1E/edit?usp=sharing";
} elseif ($pid == 3) {
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
