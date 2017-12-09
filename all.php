<?php require('header.php');?>
<?php

if(!empty($_REQUEST['p'])){
echo "<tr><td align=\"center\">";
}
/*
SELECT DISTINCT Field.* FROM Field INNER JOIN Crop INNER JOIN FromCrop INNER JOIN Lot INNER JOIN FromLot WHERE Crop.FieldID = Field.FieldID AND FromCrop.CropID = Crop.CropID AND FromCrop.LotID = Lot.LotID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=2;
| FieldID | OwnerName| OwnerEmail | OwnerPhoto | Variety   | YearOfEst | Coordinates  | Photo |
22.057713,37.077118,0.000000
*/
if(!($stmt_trace_field->bind_param("i",$_REQUEST['p']))){
		echo "fail bind";
		};
if(!($stmt_trace_field->execute())){
		echo "fail trace";
		};

    /* bind result variables */
if(!($stmt_trace_field->bind_result($fid, $fownername, $fowneremail , $fownerphoto , $fvariety, $fyest, $fcoordinates, $fphoto))){
	echo "fail bind res";
	};
echo <<<EOF
<table>
	<tr>
	<td width="100%" valign="top" align="center">Information about the Field(s):
	<tr>
EOF;

while ($stmt_trace_field->fetch()) {
echo "<tr><td align=\"center\"><table class=\"simplelist\"><tr><td align=\"center\">Owner Name:".$fownername."<tr><td align=\"center\">Owner Email:".$fowneremail."<tr><td align=\"center\">Variety:".$fvariety."<tr><td align=\"center\">Year of Est:".$fyest."<tr><td width=29 align=\"center\">Coordinates:".$fcoordinates."</td></table></tr>";
echo '<tr><td align="center"><img src="'.$fownerphoto.'"  alt="owner.jpg" />';
echo '<tr><td align="center"><img src="'.$fphoto.'"  alt="field.jpg" />';

}
$stmt_trace_field->free_result();
echo <<<EOF
</td>
	</tr>
</table>
EOF;
/*
///////////////////CROPS

if (!($stmt_trace_crops = $mysqli->prepare ("SELECT DISTINCT Crop.* , Field.Variety FROM Field INNER JOIN Crop INNER JOIN FromCrop INNER JOIN Lot INNER JOIN FromLot INNER JOIN Pallete WHERE Crop.FieldID = Field.FieldID AND FromCrop.CropID = Crop.CropID AND FromCrop.LotID = Lot.LotID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=Pallete.PalleteID AND Pallete.PalleteID= ? ;")))
+--------+---------+------------+--------+-----------+
| CropID | FieldID | Date       | Weight | Variety   |
+--------+---------+------------+--------+-----------+
|      1 |       2 | 2014-08-18 |    300 | Koroneiki |
+--------+---------+------------+--------+-----------+
*/
if(!($stmt_trace_crops->bind_param("i",$_REQUEST['p']))){
		echo "fail bind";
		};
if(!($stmt_trace_crops->execute())){
		echo "fail trace";
		};

    /* bind result variables */
if(!($stmt_trace_crops->bind_result($cid, $cfield, $cdate, $cweight,$cfvariety))){
	echo "fail bind res";
	};
echo <<<EOF
<table>
	<tr>
	<td width="100%" valign="top" align="center">Information about the Crops:
	<tr>
EOF;

while ($stmt_trace_crops->fetch()) {
echo "<tr><td align=\"center\"><table class=\"simplelist\"><tr><td align=\"center\">CropID:".$cid."<tr><td align=\"center\">Date Collected:".$cdate."<tr><td align=\"center\">Weight(Kg):".$cweight."<tr><td align=\"center\">Variety:".$cfvariety."</td></tr></table></tr>";
}
$stmt_trace_crops->free_result();
echo <<<EOF
</td>
	</tr>
</table>
EOF;




/*
//////////////////EXSITE
*/

if(!empty($_REQUEST['p'])){
echo "<tr><td align=\"center\">";
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
}


echo <<<EOF

	</tr>
</table>
EOF;

/*
/////////////////////////////LOTS

if (!($stmt_trace_lots = $mysqli->prepare ("
SELECT DISTINCT Lot.* FROM 
Field INNER JOIN Crop INNER JOIN FromCrop INNER JOIN Lot INNER JOIN FromLot INNER JOIN Pallete 
WHERE Crop.FieldID = Field.FieldID AND 
      FromCrop.CropID = Crop.CropID AND 
	  FromCrop.LotID = Lot.LotID AND
	  Lot.LotID = FromLot.LotID AND
	  FromLot.PalleteID=Pallete.PalleteID AND
	  Pallete.PalleteID= ? ;")))
   { printf("Error preparing statement stmt_trace_lots"); }
+-------+------------------+------------+---------+---------+--------+
| LotID | ExtractionSiteID | Date       | Quality | Acidity | Weight |
+-------+------------------+------------+---------+---------+--------+
|     1 |                1 | 2014-09-10 | A       | low     |    300 |
+-------+------------------+------------+---------+---------+--------+
*/
if(!($stmt_trace_lots->bind_param("i",$_REQUEST['p']))){
		echo "fail bind";
		};
if(!($stmt_trace_lots->execute())){
		echo "fail trace";
		};

    /* bind result variables */
if(!($stmt_trace_lots->bind_result($lid, $lexid, $ldate, $lquality,$lacidity,$lweight))){
	echo "fail bind res";
	};
echo <<<EOF
<table>
	<tr>
	<td width="100%" valign="top" align="center">Information about the LOTs:
	<tr>
EOF;

while ($stmt_trace_lots->fetch()) {
echo "<tr><td align=\"center\"><table class=\"simplelist\"><tr><td align=\"center\">LotID:".$lid."<tr><td align=\"center\">Date Extracted:".$ldate."<tr><td align=\"center\">Weight(Kg):".$lweight."<tr><td align=\"center\">Quality:".$lquality."</td></tr><tr><td align=\"center\">Acidity:".$lacidity."</td></tr></table></tr>";
}
$stmt_trace_lots->free_result();
echo <<<EOF
</td>
	</tr>
</table>
EOF;



/*
////////////////////////////BOTTLINGSITE
*/


if(!empty($_REQUEST['p'])){
echo "<tr><td align=\"center\">";
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
}


echo <<<EOF

	</tr>
</table>
EOF;

/*
//////////////////////SHIPPEDTO
*/


if(!empty($_REQUEST['p'])){
echo "<tr><td align=\"center\">";
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
echo '<tr><tdalign=\"center\"><img src="'.$pphoto.'"  alt="extractionsite.jpg" />';
}

//echo '<tr><td><iframe width="700" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'."https://www.oliveo.com/olitrace/kmls/p-".$_REQUEST['p'].'.kml"&amp;t=h&amp;ie=UTF8&amp;output=embed"></iframe><br />';
if ($_REQUEST['p'] == 1) {
    $link="https://drive.google.com/file/d/0B3r3ylCfyQ-zRHRwWGhxVng2Mzg/edit?usp=sharing";
} elseif ($_REQUEST['p'] == 2) {
    $link="https://drive.google.com/file/d/0B3r3ylCfyQ-zRExiSWlkNkh4N1E/edit?usp=sharing";
} elseif ($_REQUEST['p'] == 3) {
   $link="https://drive.google.com/file/d/0B_mLUITO4VzQbVVtZEJiZUFYSW8/edit?usp=sharing";
} elseif ($_REQUEST['p'] == 4) {
   $link="";
} elseif ($_REQUEST['p'] == 5) {
   $link="";
}
echo '<tr><td><iframe width="700" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$link.'.&amp;t=s&amp;ie=UTF8&amp;output=iframe"></iframe><br />';
echo <<<EOF

	</tr>
</table>
EOF;

///////////////////////////////////PALLETE

?>


<?php require('footer.php');?>
