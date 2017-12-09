<?php require('header.php');?>
<?php
session_start();



if (empty($_SESSION['opartid'])) {
$_SESSION['opartid'] = $_REQUEST['opartid'];
}

?>

<?php



if ($_POST['action'] == 'insert'){

/*
CREATE TABLE Pallete
 (PalleteID int AUTO_INCREMENT,
 BottlingSiteID int,
 PartnerID int,
 DateShipped date,
 DateBottled date,
 QRcode varchar(64),
 PRIMARY KEY (PalleteID),
 FOREIGN KEY (`BottlingSiteID`) REFERENCES `BottlingSite`(`BottlingSiteID`)
 ON DELETE CASCADE,
 FOREIGN KEY (`PartnerID`) REFERENCES `OliveoPartner`(`PartnerID`)
 ON DELETE CASCADE);
*/
/*
$stmt_insert_pallete = $mysqli->prepare (" INSERT INTO Pallete(BottlingSiteID,PartnerID,DateShipped,DateBottled)
  VALUES (?, ?, ?)
*/
    $stmt_insert_pallete->bind_param("iiss", $_SESSION['botsiteid'],
							$_SESSION['opartid'],
							$_POST['pallete_date'],
							$_POST['pallete_date_b']);
	if($stmt_insert_pallete->execute())
	{   
		$pid = $stmt_insert_pallete->insert_id;
        if(!empty($_SESSION['lotid'])) {
             foreach($_SESSION['lotid'] as $lid) {
/*
  $stmt_insert_fromlot = $mysqli->prepare (" INSERT INTO FromLot(PalleteID,LotID)
  VALUES (?, ?)                
*/
             $stmt_insert_fromlot->bind_param("ii", $pid, $lid);
             $stmt_insert_fromlot->execute();
             $stmt_insert_fromlot->free_result();
            }
        }
		$stmt_insert_pallete->free_result();
		
//////////////////////////////////////////////////create KML  //////////////////////////
/*,,Pallete.BottlingSiteID,Pallete.PartnerID
SELECT DISTINCT Field.* FROM Field INNER JOIN Crop INNER JOIN FromCrop INNER JOIN Lot INNER JOIN FromLot INNER JOIN Pallete ON Crop.FieldID = Field.FieldID AND FromCrop.CropID = Crop.CropID AND FromCrop.LotID = Lot.LotID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=Pallete.PalleteID WHERE Pallete.PalleteID=? ;	
+---------+
| FieldID |
+---------+
|       1 |
|       2 |
+---------+

*/
$kml[] = '';
// Creates an array of strings to hold the lines of the KML file.
$kml = array('<?xml version="1.0" encoding="UTF-8"?>');
$kml[] = '<kml xmlns="http://earth.google.com/kml/2.2">';
$kml[] = ' <Document>';
$kml[] = '<name>Oliveo - OliTrace </name>';
$kml[] = '<description><![CDATA[Olitrace Map]]></description>';
$kml[] = '<Style id="style34">';
$kml[] = '<LineStyle>';
$kml[] = '<color>FF33FF33</color>';
$kml[] = '<width>5</width>';
$kml[] = '</LineStyle>';
$kml[] = '</Style>';
$kml[] = '<Style id="style15">';
$kml[] = '<IconStyle>';
$kml[] = '<Icon>';
$kml[] = '<href>http://maps.gstatic.com/mapfiles/ms2/micons/tree.png</href>';
$kml[] = '</Icon>';
$kml[] = '</IconStyle>';
$kml[] = '</Style>';
$kml[] = '<Style id="style30">';
$kml[] = '<IconStyle>';
$kml[] = '<Icon>';
$kml[] = '<href>http://maps.gstatic.com/mapfiles/ms2/micons/earthquake.png</href>';
$kml[] = '</Icon>';
$kml[] = '</IconStyle>';
$kml[] = '</Style>';
$kml[] = '<Style id="style2">';
$kml[] = '<IconStyle>';
$kml[] = '<Icon>';
$kml[] = '<href>http://maps.gstatic.com/mapfiles/ms2/micons/earthquake.png</href>';
$kml[] = '</Icon>';
$kml[] = '</IconStyle>';
$kml[] = '</Style>';
$kml[] = '<Style id="style14">';
$kml[] = '<IconStyle>';
$kml[] = '<Icon>';
$kml[] = '<href>http://maps.gstatic.com/mapfiles/ms2/micons/man.png</href>';
$kml[] = '</Icon>';
$kml[] = '</IconStyle>';
$kml[] = '</Style>';
$kml[] = '<Style id="style32">';
$kml[] = '<LineStyle>';
$kml[] = '<color>B333FF33</color>';
$kml[] = '<width>15</width>';
$kml[] = '</LineStyle>';
$kml[] = '</Style>';
$kml[] = '<Style id="style1">';
$kml[] = '<LineStyle>';
$kml[] = '<color>B300CCFF</color>';
$kml[] = '<width>15</width>';
$kml[] = '</LineStyle>';
$kml[] = '</Style>';
$kml[] = '<Style id="style11">';
$kml[] = '<LineStyle>';
$kml[] = '<color>990000FF</color>';
$kml[] = '<width>15</width>';
$kml[] = '</LineStyle>';
$kml[] = '</Style>';

//Add  the fields///////////////////////////////////////////////
if(!($stmt_select_p_fields->bind_param("i",$pid))){
		echo "fail bind";
		};
if(!($stmt_select_p_fields->execute())){
		echo "fail trace";
		};
    /* bind result variables */
$stmt_select_p_fields->bind_result($fid, $fownername, $fowneremail , $fownerphoto , $fvariety, $fyest, $fcoordinates, $fphoto);

while ($stmt_select_p_fields->fetch()) {
$kml[] = '<Placemark>';
$kml[] = "<name>Plantation".$fid."</name>";
$kml[] = "<description><![CDATA[<div dir=\"ltr\">Variety:".$fvariety."<br>Owner:".$fownername."<br>Owner E-mail:".$fowneremail."<br>Year of Est:".$fyest."<br></div>]]></description>";
if (strlen($fcoordinates) > 35){
$kml[] = '<styleUrl>#style34</styleUrl>';
$kml[] = '<LineString>';
$kml[] = '<tessellate>1</tessellate>';
$kml[] = '<coordinates>';
$kml[] = $fcoordinates;
$kml[] = '</coordinates>';
$kml[] = '</LineString>';

}else{
$kml[] = '<styleUrl>#style15</styleUrl>';
$kml[] = '<Point>';
$kml[] = "<coordinates>".$fcoordinates."</coordinates>";
$kml[] = '</Point>';
}
$kml[] = '</Placemark>';
}
$stmt_select_p_fields->free_result();
////Add the rest/////////////////////////////////////////////
/*
SELECT DISTINCT Lot.ExtractionSiteID,Pallete.BottlingSiteID,Pallete.PartnerID FROM Field INNER JOIN Crop INNER JOIN FromCrop INNER JOIN Lot INNER JOIN FromLot INNER JOIN Pallete ON Crop.FieldID = Field.FieldID AND FromCrop.CropID = Crop.CropID AND FromCrop.LotID = Lot.LotID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=Pallete.PalleteID WHERE Pallete.PalleteID=? ORDER BY Lot.ExtractionSiteID;	
+------------------+----------------+-----------+
| ExtractionSiteID | BottlingSiteID | PartnerID |
+------------------+----------------+-----------+
|                1 |              1 |         1 |
+------------------+----------------+-----------+
*/
if(!($stmt_select_sites_ids->bind_param("i",$pid))){
		echo "fail bind";
		};
if(!($stmt_select_sites_ids->execute())){
		echo "fail trace";
		};
$stmt_select_sites_ids->bind_result($eid,$bid,$oid);
$z=0;
while($stmt_select_sites_ids->fetch()){
$extid[]=$eid;
$botid=$bid;
$oliid=$oid;
$z++;
}
$stmt_select_sites_ids->free_result();
for($i=0 ; $i<$z ; $i++){
if(!($stmt_select_one_extractionsite->bind_param("i",$extid[$i]))){
		echo "fail bind";
		};
if(!($stmt_select_one_extractionsite->execute())){
		echo "fail trace";
		};
    /* bind result variables */
$stmt_select_one_extractionsite->bind_result($eoid, $ename, $eownername, $ecity , $eadress , $ecoordinates, $ephone, $ephoto, $eownerphoto);

while ($stmt_select_one_extractionsite->fetch()) {
$kml[] = '<Placemark>';
$kml[] = "<name>Extraction Site-".$eoid."</name>";
$kml[] = "<description><![CDATA[<div dir=\"ltr\">Name:".$ename."<br>Owner:".$eownername."<br>City:".$ecity."<br>Adress:". $eadress."<br>Phone Number:".$ephone."<br></div>]]></description>";
$kml[] = '<styleUrl>#style30</styleUrl>';
$kml[] = '<Point>';
$kml[] = "<coordinates>".$ecoordinates."</coordinates>";
$kml[] = '</Point>';
$kml[] = '</Placemark>';

}

$stmt_select_one_extractionsite->free_result();

}


if(!($stmt_select_one_bottlingsite->bind_param("i",$botid))){
		echo "fail bind";
		};
if(!($stmt_select_one_bottlingsite->execute())){
		echo "fail trace";
		};
    /* bind result variables */
$stmt_select_one_bottlingsite->bind_result($bid, $bname, $bownername, $bcity , $badress , $bcoordinates, $bphone, $bphoto, $bownerphoto);

while ($stmt_select_one_bottlingsite->fetch()) {
$kml[] = '<Placemark>';
$kml[] = "<name>Bottling Site-".$bid."</name>";
$kml[] = "<description><![CDATA[<div dir=\"ltr\">Name:".$bname."<br>Owner:".$bownername."<br>City:".$bcity."<br>Adress:". $badress."<br>Phone Number:".$bphone."<br></div>]]></description>";
$kml[] = '<styleUrl>#style2</styleUrl>';
$kml[] = '<Point>';
$kml[] = "<coordinates>".$bcoordinates."</coordinates>";
$kml[] = '</Point>';
$kml[] = '</Placemark>';
$botcoordinates=$bcoordinates;
}
$stmt_select_one_bottlingsite->free_result();


if(!($stmt_select_one_oliveopartner->bind_param("i",$oliid))){
		echo "fail bind";
		};
if(!($stmt_select_one_oliveopartner->execute())){
		echo "fail trace";
		};
    /* bind result variables */
$stmt_select_one_oliveopartner->bind_result($oid, $oname,$ocoordinates,$ocountry,$ocity,$ophoto);

while ($stmt_select_one_oliveopartner->fetch()) {
$kml[] = '<Placemark>';
$kml[] = "<name>Oliveo Partner".$oid."</name>";
$kml[] = "<description><![CDATA[<div dir=\"ltr\">Name:".$oname."<br>Country:".$ocountry."<br>City:".$ocity."<br></div>]]></description>";
$kml[] = '<styleUrl>#style14</styleUrl>';
$kml[] = '<Point>';
$kml[] = "<coordinates>".$ocoordinates."</coordinates>";
$kml[] = '</Point>';
$kml[] = '</Placemark>';
$olicoordinates=$ocoordinates;
}
$stmt_select_one_oliveopartner->free_result();
///////Make the lines//////////
//Ftisxnoume th grammh pou paei apo to bottling site sto destination
$kml[] = '<Placemark>';
$kml[] = '<name>Pallete-'.$pid.'</name>';
$kml[] = '<description><![CDATA[]]></description>';
$kml[] = '<styleUrl>#style11</styleUrl>';
$kml[] = '<LineString>';
$kml[] = '<tessellate>1</tessellate>';
$kml[] = '<coordinates>';
$kml[] = $botcoordinates;
$kml[] = $olicoordinates;
$kml[] = '</coordinates>';
$kml[] = '</LineString>';
$kml[] = '</Placemark>';

/*
Oi grammes pou enwnoun ta fields me ta extraction sites
$stmt_field_extr_line
SELECT DISTINCT Field.Coordinates, ExtractionSite.Coordinates, Crop.CropID,  Crop.Date, Crop.Weight FROM Field INNER JOIN Crop INNER JOIN FromCrop INNER JOIN Lot INNER JOIN ExtractionSite INNER JOIN FromLot INNER JOIN Pallete ON Crop.FieldID = Field.FieldID AND FromCrop.CropID = Crop.CropID AND FromCrop.LotID = Lot.LotID AND Lot.ExtractionSiteID = ExtractionSite.ExtractionSiteID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=Pallete.PalleteID WHERE Pallete.PalleteID= ?  ORDER BY Field.Coordinates ASC , ExtractionSite.Coordinates ASC;	

*/


if(!($stmt_field_extr_line->bind_param("i",$pid))){
		echo "fail bind";
		};
if(!($stmt_field_extr_line->execute())){
		echo "fail trace";
		};
$stmt_field_extr_line->bind_result($fcoordinates, $ecoordinates, $cid, $cdate, $cweight);
/*<Placemark>
    <name>Crop 02.131-2012-01</name>
    <description><![CDATA[<div dir="ltr">Type: A Olives<br>Units: Kg<br>Size: 600<br>Date: 2012.12.01<br>Into Lot: B 02.001-2012-002</div>]]></description>
    <styleUrl>#style32</styleUrl>
    <LineString>
      <tessellate>1</tessellate>
      <coordinates>
        22.060740,37.075211,0.000000
        22.058990,37.073143,0.000000
      </coordinates>
    </LineString>
  </Placemark>
  */


while ($stmt_field_extr_line->fetch()) {
  $fcoordprev=$fcoordinates;
$ecoordprev=$ecoordinates;
$cidprev= $cid;
$cdateprev= $cdate;
$cweightprev= $cweight;
$kml[] = '<Placemark>';
$kml[] = "<name>Crops</name>";
$kml[] = "<description><![CDATA[<div dir=\"ltr\">CropID:".$cid."<br>Date:".$cdate."<br>Weight:".$cweight."<br>";
while ($stmt_field_extr_line->fetch()) {
if ($fcoordprev==$fcoordinates && $ecoordprev=$ecoordinates){
$kml[] = "CropID:".$cid."<br>Date:".$cdate."<br>Weight:".$cweight."<br>";
}else{
$kml[] = "</div>]]></description>";
if (strlen($fcoordprev) > 35){
$fcoordpreve = explode(" ", $fcoordprev);
//echo $fcoordinate[0]; // piece1
$fcoor=$fcoordpreve[0];
}else{
$fcoor=$fcoordprev;
}
$kml[] = '<styleUrl>#style34</styleUrl>';
$kml[] = '<LineString>';
$kml[] = '<tessellate>1</tessellate>';
$kml[] = '<coordinates>';
$kml[] = $fcoor;
$kml[] = $ecoordprev;
$kml[] = '</coordinates>';
$kml[] = '</LineString>';
$kml[] = '</Placemark>';
$fcoordprev=$fcoordinates;
$ecoordprev=$ecoordinates;
$cidprev= $cid;
$cdateprev= $cdate;
$cweightprev= $cweight;
$kml[] = '<Placemark>';
$kml[] = "<name>Crops</name>";
$kml[] = "<description><![CDATA[<div dir=\"ltr\">CropID:".$cid."<br>Date:".$cdate."<br>Weight:".$cweight."<br>";

}

}
$kml[] = "</div>]]></description>";
if (strlen($fcoordprev) > 35){
$fcoordpreve = explode(" ", $fcoordprev);
//echo $fcoordinate[0]; // piece1
$fcoor=$fcoordpreve[0];
}else{
$fcoor=$fcoordprev;
}
$kml[] = '<styleUrl>#style34</styleUrl>';
$kml[] = '<LineString>';
$kml[] = '<tessellate>1</tessellate>';
$kml[] = '<coordinates>';
$kml[] = $fcoor;
$kml[] = $ecoordprev;
$kml[] = '</coordinates>';
$kml[] = '</LineString>';
$kml[] = '</Placemark>';
// $fcoordprev=$fcoordinates;
// $ecoordprev=$ecoordinates;
// $cidprev= $cid;
// $cdateprev= $cdate;
// $cweightprev= $cweight;
// $kml[] = '<Placemark>';
// $kml[] = "<name>Crops</name>";
// $kml[] = "<description><![CDATA[<div dir=\"ltr\">CropID:".$cid."<br>Date:".$cdate."<br>Weight:".$cweight."<br>";
// $kml[] = "<description><![CDATA[<div dir=\"ltr\">Date:".$cdate."<br>Weight:".$cweight."<br></div>]]></description>";

}
$stmt_field_extr_line->free_result();
/*
SELECT DISTINCT ExtractionSite.Coordinates, BottlingSite.Coordinates,Lot.LotID, Lot.Date,Lot.Quality,Lot.Acidity,Lot.Weight FROM Lot INNER JOIN ExtractionSite INNER JOIN FromLot INNER JOIN Pallete INNER JOIN BottlingSite ON Lot.ExtractionSiteID = ExtractionSite.ExtractionSiteID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=Pallete.PalleteID AND Pallete.BottlingSiteID=BottlingSite.BottlingSiteID WHERE Pallete.PalleteID= ?  ORDER BY ExtractionSite.Coordinates ASC, BottlingSite.Coordinates ASC;	

  <Placemark>
    <name>Lot 02.001-2012-002</name>
    <description><![CDATA[Type: B Extracted Olive Oil<div>Units: Kg</div><div>Size: 6500</div><div>Date: 2012.12.03</div><div>Connected Lots: A-02.00X-2012-0XX</div>]]></description>
    <styleUrl>#style1</styleUrl>
    <LineString>
      <tessellate>1</tessellate>
      <coordinates>
        22.058472,37.072845,0.000000
        22.052200,37.075600,0.000000
        22.053379,37.074951,0.000000
        22.052179,37.075562,0.000000
      </coordinates>
    </LineString>
  </Placemark>
*/

if(!($stmt_extr_bott_line->bind_param("i",$pid))){
		echo "fail bind";
		};
if(!($stmt_extr_bott_line->execute())){
		echo "fail trace";
		};
$stmt_extr_bott_line->bind_result($ecoordinates, $bcoordinates, $lid, $ldate, $lquality,$lacidity,$lweight);
while ($stmt_extr_bott_line->fetch()) {

$ecoordprev=$ecoordinates;
$bcoordprev=$bcoordinates;
$lidprev= $lid;
$ldateprev= $ldate;
$lqualityprev= $lquality;
$lacidityprev=$lacidity;
$lweightprev=$lweight;

$kml[] = '<Placemark>';
$kml[] = "<name>Lots</name>";
$kml[] = "<description><![CDATA[<div dir=\"ltr\">LotID:".$lid."<br>Date:".$ldate."<br>Quality:".$lquality."<br>Acidity:".$lacidity."<br>Weight:".$lweight."<br>";
while ($stmt_extr_bott_line->fetch()) {
if ($bcoordprev==$bcoordinates && $ecoordprev=$ecoordinates){
$kml[] = "LotID:".$lid."<br>Date:".$ldate."<br>Quality:".$lquality."<br>Acidity:".$lacidity."<br>Weight:".$lweight."<br>";
}else{
$kml[] = "</div>]]></description>";
$kml[] = '<styleUrl>#style1</styleUrl>';
$kml[] = '<LineString>';
$kml[] = '<tessellate>1</tessellate>';
$kml[] = '<coordinates>';
$kml[] = $ecoordprev;
$kml[] = $bcoordprev;
$kml[] = '</coordinates>';
$kml[] = '</LineString>';
$kml[] = '</Placemark>';
$ecoordprev=$ecoordinates;
$bcoordprev=$bcoordinates;
$lidprev= $lid;
$ldateprev= $ldate;
$lqualityprev= $lquality;
$lacidityprev=$lacidity;
$lweightprev=$lweight;
$kml[] = '<Placemark>';
$kml[] = "<name>Lots</name>";
$kml[] = "<description><![CDATA[<div dir=\"ltr\">LotID:".$lid."<br>Date:".$ldate."<br>Quality:".$lquality."<br>Acidity:".$lacidity."<br>Weight:".$lweight."<br>";
}
}
$kml[] = "</div>]]></description>";
$kml[] = '<styleUrl>#style1</styleUrl>';
$kml[] = '<LineString>';
$kml[] = '<tessellate>1</tessellate>';
$kml[] = '<coordinates>';
$kml[] = $ecoordinates;
$kml[] = $bcoordinates;
$kml[] = '</coordinates>';
$kml[] = '</LineString>';
$kml[] = '</Placemark>';
}



$stmt_extr_bott_line->free_result();


$kml[] = '</Document>';
$kml[] = '</kml>';
$kmlOutput = join("\n", $kml);
//header('Content-type: application/vnd.google-earth.kml+xml');
$file = "./kmls/p-".$pid.".kml";
file_put_contents($file, $kmlOutput);

echo <<< EOF
		<td>Success!!!!
    <tr><td align="center">
	 <table  class="simplelist">
	   <tr><td colspan = "2">
	    <form enctype="multipart/form-data" name = "input" action = "index.php?p=$pid" method = "post">	
	    <input type="submit" value="Continue" name="submit" align = "center">
	    </form>
	    </td>
	   </tr>
	 </table>
	</td></tr>

EOF;

	}
	else
	{
		$stmt_insert_pallete->free_result();
echo <<<EOF
		<td>Failed!!!!
EOF;
	}
  }
 else{
	 /*
 * CREATE TABLE Pallete
 (PalleteID int AUTO_INCREMENT,
 BottlingSiteID int,
 DateShipped date,
 QRcode varchar(64),
 PRIMARY KEY (PalleteID),
 FOREIGN KEY (`BottlingSiteID`) REFERENCES `BottlingSite`(`BottlingSiteID`)
 );
*/
echo <<< EOF
    <td>
	<form enctype="multipart/form-data" name = "input" action = "insertpallete.php" method = "post"> 
	<input type ="hidden" value = "insert" name = "action">
	
	<table border = "1">
	<tr> <td colspan = "2">Insert Pallete Details
	<tr> <td>Date Bottled : <td><input type="text" size="30" maxlength="300" name="pallete_date_b">
    <tr> <td>Date Shipped : <td><input type="text" size="30" maxlength="300" name="pallete_date">
	<TR> <TD colspan = "2"><input type="submit" value="Insert" name="submit" align = "center">
	</TABLE>
	</form>

    
EOF;
}


?>




<?php require('footer.php');?>
