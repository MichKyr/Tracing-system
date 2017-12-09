<?php require('header.php');?>
<?php

if(!empty($_REQUEST['p'])){
echo "<td align=\"center\">";
}
/*
SELECT DISTINCT BottlingSite.* FROM BottlingSite INNER JOIN Pallete WHERE BottlingSite.BottlingSiteID=Pallete.BottlingSiteID AND PalleteID=1;
+----------------+---------------------------------------------+---------------------------------------------+----------+---------+------------------------------+-------------+---------------------------+-----------------------------+
| BottlingSiteID | Name                                        | OwnerName                                   | City     | Address | Coordinates                  | Phonenumber | Photo                     | OwnerPhoto                  |
+----------------+---------------------------------------------+---------------------------------------------+----------+---------+------------------------------+-------------+---------------------------+-----------------------------+
|              1 | Messinia Union of Agricultural Cooperatives | Messinia Union of Agricultural Cooperatives | Messinia | kapou   | 22.051117,37.076691,0.000000 |  1231312123 | ./photos/bp-1-botsite.jpg | ./photos/bop-1-botowner.jpg |
+----------------+---------------------------------------------+---------------------------------------------+----------+---------+------------------------------+-------------+---------------------------+-----------------------------+

*/
if(!($stmt_trace_botsite->bind_param("i",$_REQUEST['p']))){
		echo "fail bind";
		};
if(!($stmt_trace_botsite->execute())){
		echo "fail ex";
		};

    /* bind result variables */
if(!($stmt_trace_botsite->bind_result($bid, $bname, $bownername, $bcity , $badress , $bcoordinates, $bphone, $bphoto, $bownerphoto))){
		echo "fail res";
		};
echo <<<EOF
<table>
	<tr>
	<td width="100%" valign="top" align="center">Information about the Bottling Site:
	<tr>
	
EOF;

while ($stmt_trace_botsite->fetch()) {

echo "<td align=\"center\"><table width=40% class=\"simplelist\"><td align=\"right\">Bottling Site Name:<td align=\"left\">".$bname."<tr><td align=\"right\">Owner Name:<td align=\"left\">".$bownername."<tr><td align=\"right\">City:<td align=\"left\">".$bcity."<tr><td align=\"right\">Adress:<td align=\"left\">".$badress."<tr><td width=29 align=\"right\">Coordinates:<td align=\"left\">".$bcoordinates."<tr><td align=\"right\">Phone:<td align=\"left\">".$bphone."</table>";
echo '<tr><td align="center"><img src="'.$bownerphoto.'"  alt="owner.jpg" />';
echo '<tr><td align="center"><img src="'.$bphoto.'"  alt="extractionsite.jpg" />';
//echo '<tr><td><iframe width="700" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'."https://www.oliveo.com/olitrace/kmls/b-".$bid.'.kml"&amp;t=h&amp;ie=UTF8&amp;output=embed"></iframe><br />';

if ($bid == 1) {
    $link="https://drive.google.com/file/d/0B3r3ylCfyQ-zVkhWcjdjSXcwNTQ/edit?usp=sharing";
} elseif ($bid == 2) {
    $link="";
} elseif ($bid == 3) {
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
