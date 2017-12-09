<?php require('header.php');?>
<?php

if(!empty($_REQUEST['p'])){
//echo "<td>";
//echo $_REQUEST['p'];
}
/*
SELECT DISTINCT Field.* FROM Field INNER JOIN Crop INNER JOIN FromCrop INNER JOIN Lot INNER JOIN FromLot WHERE Crop.FieldID = Field.FieldID AND FromCrop.CropID = Crop.CropID AND FromCrop.LotID = Lot.LotID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=2;
SELECT DISTINCT ExtractionSite.* FROM ExtractionSite INNER JOIN Lot INNER JOIN FromLot WHERE ExtractionSite.ExtractionSiteID=Lot.ExtractionSiteID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=1;
SELECT DISTINCT OliveoPartner.* FROM OliveoPartner INNER JOIN Pallete WHERE OliveoPartner.PartnerID=Pallete.PartnerID AND PalleteID=1;
SELECT DISTINCT BottlingSite.* FROM BottlingSite INNER JOIN Pallete WHERE BottlingSite.BottlingSiteID=Pallete.BottlingSiteID AND PalleteID=1;

*/

if(!empty($_REQUEST['p'])){
echo '<td align="center">';
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
		echo "fail";
		};

    /* bind result variables */
$stmt_trace_field->bind_result($fid, $fownername, $fowneremail , $fownerphoto , $fvariety, $fyest, $fcoordinates, $fphoto);
echo <<<EOF
<table>
	<tr>
	<td width="100%" valign="top" align="center">Information about the Field Owner(s):

	
EOF;

while ($stmt_trace_field->fetch()) {
echo "<tr><td align=\"center\"><table width=40% class=\"simplelist\"><td>Owner Name:<td>".$fownername."<tr><td>Owner Email:<td>".$fowneremail."</table></td></tr>";
echo '<tr><td align=\"center\"><img src="'.$fownerphoto.'"  alt="owner.jpg" /></td></tr>';
}


echo <<<EOF

</table>
<tr>
<td align="center">
EOF;
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
	<td width="100%" valign="top" align="center">Information about the Extraction Site Owner(s):
	<tr>
	
EOF;

while ($stmt_trace_exsite->fetch()) {

echo "<tr><td align=\"center\"><table class=\"simplelist\"><tr><td>Extraction Site Owner Name:<td>".$eownername."<tr><td>City:<td>".$ecity."<tr><td>Phone:<td>".$ephone."</table></tr>";
echo '<tr><td align=\"center\"><img src="'.$eownerphoto.'"  alt="owner.jpg" />';
}


echo <<<EOF

	</tr>
</table>
<tr>
<td align="center">
EOF;
if(!($stmt_trace_botsite->bind_param("i",$_REQUEST['p']))){
		echo "fail bind";
		};
if(!($stmt_trace_botsite->execute())){
		echo "fail bot execute";
		};

    /* bind result variables */
if(!($stmt_trace_botsite->bind_result($bid, $bname, $bownername, $bcity , $badress , $bcoordinates, $bphone, $bphoto, $bownerphoto))){
		echo "fail bot bind";
		};
echo <<<EOF
<table>
	<tr>
	<td width="100%" valign="top" align="center">Information about the Bottling Site Owner:
	<tr>
	
EOF;

while ($stmt_trace_botsite->fetch()) {

echo "<td align=\"center\"><table class=\"simplelist\"><td>Bottling Site Owner Name:<td>".$bownername."<tr><td>City:<td>".$bcity."<tr><td>Phone:<td>".$bphone."</table>";
echo '<tr><td align=\"center\"><img src="'.$bownerphoto.'"  alt="owner.jpg" />';
}


echo <<<EOF

	</tr>
</table>
<tr>
<td align="center">
EOF;
if(!($stmt_trace_dest->bind_param("i",$_REQUEST['p']))){
		echo "fail dest bind";
		};
if(!($stmt_trace_dest->execute())){
		echo "fail dets exec";
		};

    /* bind result variables */
if(!($stmt_trace_dest->bind_result($pid, $pname,$pcoordinates,$pcountry,$pcity,$pphoto))){
		echo "fail dest res";
		};
echo <<<EOF
<table>
	<tr>
	<td width="100%" valign="top" align="center">Information about the Destination(Oliveo Partner):
	<tr>
	
EOF;

while ($stmt_trace_dest->fetch()) {

echo "<td align=\"center\"><table class=\"simplelist\"><td>Partner Name:<td>".$pname."<tr><td>Country :<td>".$pcountry."<tr><td>City:<td>".$pcity."</table>";
echo '<tr><td align=\"center\"><img src="'.$pphoto.'"  alt="extractionsite.jpg" />';
}


echo <<<EOF

	</tr>
</table>
EOF;
?>
<?php require('footer.php');?>
