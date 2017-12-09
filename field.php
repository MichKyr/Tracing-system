<?php require('header.php');?>
<?php

if(!empty($_REQUEST['p'])){
echo "<td align=\"center\">";
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
$stmt_trace_field->bind_result($fid, $fownername, $fowneremail , $fownerphoto , $fvariety, $fyest, $fcoordinates, $fphoto);
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
//echo '<tr><td><iframe width="700" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'."https://www.oliveo.com/olitrace/kmls/f-".$fid.'.kml"&amp;t=h&amp;ie=UTF8&amp;output=embed"></iframe><br />';
//edw xeirokinita vazw ta links prosthetodas to id tou field kai tha epaize automata ean o kwdikas htan anevasmenos se ena site kaontas comment out thn parapanw grammh
if ($fid == 1) {
    $link="https://drive.google.com/file/d/0B_mLUITO4VzQaFRzSVVoVTNIbUE/edit?usp=sharing";
} elseif ($fid == 2) {
    $link="https://drive.google.com/file/d/0B3r3ylCfyQ-zVmtNNTdCT1VMLUk/edit?usp=sharing";
} elseif ($fid == 3) {
   $link="";
}elseif ($fid == 4) {
   $link="";
}

echo '<tr><td><iframe width="700" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$link.'.&amp;t=s&amp;ie=UTF8&amp;output=iframe"></iframe><br />';

}
$stmt_trace_field->free_result();
//echo '<tr><td><iframe width="700" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.dropbox.com/s/q0gw7y28n7tq45g/f-1.kml"></iframe><br />';
echo <<<EOF
</td>
	</tr>
</table>
EOF;

//<iframe width="700" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" zoom="18" maptype="satellite" src="https://drive.google.com/file/d/0B3r3ylCfyQ-zaExYOE9HOVdvMG8/edit?usp=sharing&amp;t=k&amp;ie=UTF8&amp;output=embed"></iframe><br />
?>


<?php require('footer.php');?>
