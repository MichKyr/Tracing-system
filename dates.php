<?php require('header.php');?>
<?php

if(!empty($_REQUEST['p'])){
echo "<td align=\"center\">";
}
/*
SELECT Crop.Date,Lot.Date,Pallete.DateBottled,Pallete.DateShipped FROM Field INNER JOIN Crop INNER JOIN FromCrop INNER JOIN Lot INNER JOIN FromLot INNER JOIN Pallete WHERE Crop.FieldID = Field.FieldID AND FromCrop.CropID = Crop.CropID AND FromCrop.LotID = Lot.LotID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=Pallete.PalleteID AND Pallete.PalleteID=? ORDER BY Lot.Date;
+------------+------------+-------------+-------------+
| Date       | Date       | DateBottled | DateShipped |
+------------+------------+-------------+-------------+
| 2014-08-18 | 2014-09-10 | 2014-08-23  | 2014-08-25  |
+------------+------------+-------------+-------------+
$stmt_trace_dates
*/
if(!($stmt_trace_dates->bind_param("i",$_REQUEST['p']))){
		echo "fail bind";
		};
if(!($stmt_trace_dates->execute())){
		echo "fail";
		};

    /* bind result variables */
$stmt_trace_dates->bind_result($cropdate, $exdate, $botdate , $shipdate);
$z=0;
while ($stmt_trace_dates->fetch()) {
	$dates["cropdate"][]=$cropdate;
	$dates["exdate"][]=$exdate;
	$botdate0=$botdate;
	$shipdate0=$shipdate;
    $z++;
	}
	$cropdate0=$dates["cropdate"][0];
	$exdate0=$dates["exdate"][0];
	
	
	//insert some testing data
/*
	$dates["cropdate"][0]=100;
	$dates["cropdate"][1]=200;
	$dates["cropdate"][2]=300;
	$dates["cropdate"][3]=500;
	$dates["cropdate"][4]=600;
	$dates["exdate"][0]=400;
	$dates["exdate"][1]=400;
	$dates["exdate"][2]=400;
	$dates["exdate"][3]=700;
	$dates["exdate"][4]=700;
	$cropdate0=$dates["cropdate"][0];
	$exdate0=$dates["exdate"][0];
	$botdate0=800;
	$shipdate0=900;
	$z=5;
*/
	//$z= count($dates);
/*
?>
<table>
	<tr>
	<td>
		<table>


		<tr>
		  <td>
			<table>
			  <tr><td>100</td></tr>
			  <tr><td>200</td></tr>
			  <tr><td>300</td></tr>
			</table></td>
		  <td>400</td>
		</tr>

		<tr>
		  <td>
		    <table>
		     <tr><td>500</td></tr>
		     <tr><td>600</td></tr>
		    </table>
		  </td>
		  <td>700</td>
		</tr>

		</table>
	</td>
	<td>800</td>
	<td>900</td>
	</tr>
</table>
<?php
*/
echo <<<EOF
<table border = "1" width="50%">
	<tr>
		<td width="100%" valign="top" align="center" colspan="3">Information about the Dates:</td>
	<tr>
	 <tr><td width="50%"><table border = "1"><tr><td width="25%"><table border = "1" width="100%"><tr><td align="center">Crop Date(s):</td></tr></table></td><td width="25%" align="center">Extraction Date(s):</td></tr></table></td><td width="25%" align="center">Bottling Date:</td><td width="25%" align="center">Shipping Date:</td></tr>
    </tr>
    <tr>
    <td  width="50%"> 
    <table border = "1" width="100%">
EOF;
	$i=0;
while ($i<$z) {
  echo "<tr><td width=\"25%\"><table border = \"1\" width=\"100%\">";
  while (($i<$z)&&($exdate0==$dates["exdate"][$i])){
  echo "<tr><td align=\"center\" >".$dates["cropdate"][$i]."</td></tr>";
  $i++;
  }
  echo "</table></td><td width=\"25%\" align=\"center\">".$exdate0."</td></tr>";
  if($i<$z){
	  $exdate0=$dates["exdate"][$i];
  }
  //$i++;
} 
echo "</table></td><td width=\"25%\" align=\"center\">".$botdate0."</td><td width=\"25%\" align=\"center\">".$shipdate0."</td></tr></table>";

$stmt_trace_dates->free_result();
?>
<?php require('footer.php');?>
