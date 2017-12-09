<?php require('header.php');?>
<td>
<?php
session_start();
unset($_SESSION['exsiteid']);
if ($_SESSION['cropid'] == '') {
	 $_SESSION['cropid']= $_POST['cropid'];
 }

?>
<?php
/*
CREATE TABLE ExtractionSite
 (ExtractionSiteID int AUTO_INCREMENT,
 Name varchar(32),
 OwnerName varchar(32),
 City varchar(32),
 Address varchar(64),
 Coordinates varchar(64),
 Phonenumber int,
 Photo varchar(64),
 OwnerPhoto varchar(64),
 PRIMARY KEY (ExtractionSiteID));
*/
echo <<< EOF
    <td>
	<form enctype="multipart/form-data" name = "input" action = "insertexsite.php?cropid={$_SESSION['cropid']}" method = "post"> 
	<input type ="hidden" value = "insert" name = "action">
	
	<table border = "1">
	<tr> <td colspan = "2">Insert Extraction Site Details
	<tr> <td>Name : <td><input type="text" size="30" maxlength="300" name="exsite_name">
	<tr> <td>Owner Name : <td><input type="text" size="30" maxlength="300" name="exsite_owner_name">
	<tr> <td>City : <td><input type="text" size="30" maxlength="300" name="exsite_city">
	<tr> <td>Address : <td><input type="text" size="30" maxlength="300" name="exsite_address">
	<tr> <td>Coordinates : <td><input type="text" size="30" maxlength="300" name="exsite_coordinates">
	<tr> <td>Phone Number : <td><input type="text" size="30" maxlength="300" name="exsite_phone">
	<tr> <td>Extraction Site Photo : <td><input type="file" name="exsite_photo">
	<tr> <td>Owner Photo : <td><input type="file" size="30" name="exsite_owner_photo">
	<TR> <TD colspan = "2"><input type="submit" value="Insert" name="submit" align = "center">
	</TABLE>
	</form>

    
EOF;


if ($_POST['action'] == 'insert'){
$file = $_FILES["exsite_owner_photo"]["tmp_name"];
$exsite_owner_photo_mime = image_type_to_mime_type(exif_imagetype($file));
$file = $_FILES["exsite_photo"]["tmp_name"];
$exsite_photo_mime = image_type_to_mime_type(exif_imagetype($file));
if ((($exsite_owner_photo_mime == "image/gif")
  || ($exsite_owner_photo_mime == "image/jpeg")
  && ($_FILES["exsite_owner_photo"]["size"] < 10240*1024))
  &&(($exsite_photo_mime == "image/gif")
  || ($exsite_photo_mime == "image/jpeg")
  && ($_FILES["exsite_photo"]["size"] < 10240*1024)))
  {
/*
	  $stmt_insert_extractionsite = $mysqli->prepare (" INSERT INTO ExtractionSite(Name,OwnerName,City,Address,Coordinates,Phonenumber)
  VALUES (?, ?, ?, ?, ?, ?)
*/
    $stmt_insert_extractionsite->bind_param("ssssss", $_POST['exsite_name'],
							$_POST['exsite_owner_name'],
							$_POST['exsite_city'],
							$_POST['exsite_address'],
							$_POST['exsite_coordinates'],
							$_POST['exsite_phone']);
	if($stmt_insert_extractionsite->execute())
	{   
		$eid = $stmt_insert_extractionsite->insert_id;
		$stmt_insert_extractionsite->free_result();

echo <<< EOF
		Success!!!!
EOF;

	}
	else
	{
		$stmt_insert_extractionsite->free_result();
echo <<<EOF
		Failed!!!!
EOF;
	}
  $eop="./photos/"."eop-".$eid."-".$_FILES["exsite_owner_photo"]["name"];
  move_uploaded_file($_FILES["exsite_owner_photo"]["tmp_name"],
    $eop);
  $ep="./photos/"."ep-".$eid."-". $_FILES["exsite_photo"]["name"];
  move_uploaded_file($_FILES["exsite_photo"]["tmp_name"],
    $ep);
    //$stmt_insert_extractionsite_photos = $mysqli->prepare (" UPDATE ExtractionSite SET Photo = ? , OwnerPhoto = ?  WHERE ExtractionSite.ExtractionSiteID = ?"
    $stmt_insert_extractionsite_photos->bind_param("ssi", $ep,
							$eop,
							$eid);
	if($stmt_insert_extractionsite_photos->execute())
	{   
		$stmt_insert_extractionsite_photos->free_result();

echo <<< EOF
		Success uploading Photos!!!!
EOF;


	}
	else
	{
		$stmt_insert_extractionsite_photos->free_result();
echo <<<EOF
		Failed uploading Photos!!!!
EOF;
	}
//////create kml
/*
<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://earth.google.com/kml/2.2">
<Document>
  <name>Oliveo - OliTrace </name>
  <description><![CDATA[Olitrace Map]]></description>
  <Style id="style30">
    <IconStyle>
      <Icon>
        <href>http://maps.gstatic.com/mapfiles/ms2/micons/earthquake.png</href>
      </Icon>
    </IconStyle>
  </Style>

 <Placemark>
    <name>Extraction Site - 02-001</name>
    <description><![CDATA[<div><font face="arial" size="2">Average Annual Yield: 120 tn</font></div><div><font face="arial" size="2">Annual Fluctuation:20%</font></div><div><font face="arial" size="2">Plant Class: B</font></div><div><font face="arial" size="2">Product Class: A, B, C</font></div><div><span style="font-family:arial;font-size:small">Owner: K.Nikolaidis</span></div><font face="arial" size="2">Partner Since: 1995</font><div><font face="arial" size="2"><br></font></div>]]></description>
    <styleUrl>#style30</styleUrl>
    <Point>
      <coordinates>22.058825,37.072956,0.000000</coordinates>
    </Point>
  </Placemark>
</Document>
</kml>

*/
$kml[] = '';
// Creates an array of strings to hold the lines of the KML file.
$kml = array('<?xml version="1.0" encoding="UTF-8"?>');
$kml[] = '<kml xmlns="http://earth.google.com/kml/2.2">';
$kml[] = ' <Document>';
$kml[] = '<name>Oliveo - OliTrace </name>';
$kml[] = '<description><![CDATA[Olitrace Map]]></description>';
$kml[] = '<Style id="style30">';
$kml[] = '<IconStyle>';
$kml[] = '<Icon>';
$kml[] = '<href>http://maps.gstatic.com/mapfiles/ms2/micons/earthquake.png</href>';
$kml[] = '</Icon>';
$kml[] = '</IconStyle>';
$kml[] = '</Style>';
/*
if (!($stmt_select_one_extractionsite = $mysqli->prepare (" SELECT ExtractionSite.* FROM ExtractionSite WHERE ExtractionSite.ExtractionSiteID = ?   ")))
   { printf("Error preparing statement stmt_select_one_extractionsite"); }
+------------------+--------------+--------------+----------+----------+------------------------------+-------------+----------------------------+-------------------------------+
| ExtractionSiteID | Name         | OwnerName    | City     | Address  | Coordinates                  | Phonenumber | Photo                      | OwnerPhoto                    |
+------------------+--------------+--------------+----------+----------+------------------------------+-------------+----------------------------+-------------------------------+
|                1 | K.Nikolaidis | K.Nikolaidis | Kalamata | Kapou 23 | 22.058825,37.072956,0.000000 |  2147483647 | ./photos/ep-1-extrsite.jpg | ./photos/eop-1-extrowner.jpeg |
+------------------+--------------+--------------+----------+----------+------------------------------+-------------+----------------------------+-------------------------------+
*/
if(!($stmt_select_one_extractionsite->bind_param("i",$eid))){
		echo "fail bind";
		};
if(!($stmt_select_one_extractionsite->execute())){
		echo "fail trace";
		};
    /* bind result variables */
$stmt_select_one_extractionsite->bind_result($eid, $ename, $eownername, $ecity , $eadress , $ecoordinates, $ephone, $ephoto, $eownerphoto);

while ($stmt_select_one_extractionsite->fetch()) {
$kml[] = '<Placemark>';
$kml[] = "<name>Extraction Site-".$eid."</name>";
$kml[] = "<description><![CDATA[<div dir=\"ltr\">Name:".$ename."<br>Owner:".$eownername."<br>City:".$ecity."<br>Adress:". $eadress."<br>Phone Number:".$ephone."<br></div>]]></description>";
$kml[] = '<styleUrl>#style30</styleUrl>';
$kml[] = '<Point>';
$kml[] = "<coordinates>".$ecoordinates."</coordinates>";
$kml[] = '</Point>';
$kml[] = '</Placemark>';
}

$kml[] = '</Document>';
$kml[] = '</kml>';
$kmlOutput = join("\n", $kml);
//header('Content-type: application/vnd.google-earth.kml+xml');
$file = "./kmls/e-".$eid.".kml";
file_put_contents($file, $kmlOutput);

$stmt_select_one_extractionsite->free_result();

  }
else
  {
  echo "Files must be either JPEG or GIF and less than 10,000 kb";
  }


}
/*
$stmt_select_extractionsite = $mysqli->prepare (" 
* SELECT ExtractionSite.ExtractionSiteID,ExtractionSite.Name,ExtractionSite.OwnerName,ExtractionSite.City,ExtractionSite.Address FROM ExtractionSite  
*/

$stmt_select_extractionsite->execute();

    /* bind result variables */
$stmt_select_extractionsite->bind_result($eid, $ename, $eoname, $ecity, $eaddress);

echo <<<EOF
<td>
<form action="insertlot.php">
<select name="exsiteid">
EOF;

while ($stmt_select_extractionsite->fetch()) {
  $ste="Extr.Site ID:&nbsp;".$eid."&nbsp; Name:&nbsp; ".$ename."&nbsp Owner Name:&nbsp ".$eoname."&nbsp City:&nbsp ".$ecity."&nbsp Address:&nbsp ".$eaddress;
  printf("<option value=\"%s\">%s</option>", $eid , $ste);
  echo "<br>";
}
echo <<<EOF
</select>
<input type="submit" value="Submit">
</form>
EOF;


?>


<?php require('footer.php');?>
