<?php require('header.php');?>
<?php
session_start();
unset($_SESSION['opartid']);
if (empty($_SESSION['botsiteid'])) {
$_SESSION['botsiteid'] = $_REQUEST['botsiteid'];
}
?>

<?php
/*
 * CREATE TABLE OliveoPartner
(PartnerID int AUTO_INCREMENT,
Name varchar(32),
Coordinates varchar(128),
Country varchar(32),
City varchar(32),
Photo varchar(32),
PRIMARY KEY (PartnerID));
*/
echo <<< EOF
    <td>
	<form enctype="multipart/form-data" name = "input" action = "insertpartner.php" method = "post"> 
	<input type ="hidden" value = "insert" name = "action">
	<table border = "1">
	<tr> <td colspan = "2">Insert Oliveo Partner Details
	<tr> <td>Name : <td><input type="text" size="30" maxlength="300" name="opart_name">
	<tr> <td>Coordinates : <td><input type="text" size="30" maxlength="300" name="opart_coordinates">
	<tr> <td>Country : <td><input type="text" size="30" maxlength="300" name="opart_country">
	<tr> <td>City : <td><input type="text" size="30" maxlength="300" name="opart_city">
	<tr> <td>Photo : <td><input type="file" size="30" name="opart_photo">
	<TR> <TD colspan = "2"><input type="submit" value="Insert" name="submit" align = "center">
	</TABLE>
	</form>

    
EOF;


if ($_POST['action'] == 'insert'){
$file = $_FILES["opart_photo"]["tmp_name"];
$opart_photo_mime = image_type_to_mime_type(exif_imagetype($file));
if (($opart_photo_mime == "image/gif")
  || ($opart_photo_mime == "image/jpeg")
  && ($_FILES["opart_photo"]["size"] < 10240*1024))
  {
/*
if (!($stmt_insert_oliveopartner = $mysqli->prepare (" INSERT INTO OliveoPartner(Name,Coordinates,Country,City)
  VALUES (?, ?, ?, ?)
  ")))
  { printf("Error preparing statement stmt_insert_oliveopartner"); }
  if (!($stmt_insert_oliveopartner_photo = $mysqli->prepare (" UPDATE OliveoPartner SET Photo = ? WHERE OliveoPartner.PartnerID = ?")))
  { printf("Error preparing statement stmt_insert_oliveopartner_photo"); }
*/
    $stmt_insert_oliveopartner->bind_param("ssss", $_POST['opart_name'],
							$_POST['opart_coordinates'],
							$_POST['opart_country'],
							$_POST['opart_city']);
	if($stmt_insert_oliveopartner->execute())
	{   
		$oid = $stmt_insert_oliveopartner->insert_id;
		$stmt_insert_oliveopartner->free_result();

echo <<< EOF
		Success!!!!
EOF;

	}
	else
	{
		$stmt_insert_oliveopartner->free_result();
echo <<<EOF
		Failed!!!!
EOF;
	}
	$op="./photos/"."op-".$oid."-".$_FILES["opart_photo"]["name"];
  move_uploaded_file($_FILES["opart_photo"]["tmp_name"],
    $op);

    $stmt_insert_oliveopartner_photo->bind_param("si", $op,
							$oid);
	if($stmt_insert_oliveopartner_photo->execute())
	{   
		$stmt_insert_oliveopartner_photo->free_result();

echo <<< EOF
		Success uploading Photos!!!!
EOF;

	}
	else
	{
		$stmt_insert_oliveopartner_photo->free_result();
echo <<<EOF
		Failed uploading Photos!!!!
EOF;
	}
	
//////create kml

/*<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://earth.google.com/kml/2.2">
<Document>
  <name>Oliveo - OliTrace </name>
  <description><![CDATA[Olitrace Map]]></description>
   <Style id="style14">
    <IconStyle>
      <Icon>
        <href>http://maps.gstatic.com/mapfiles/ms2/micons/man.png</href>
      </Icon>
    </IconStyle>
  </Style>
   <Placemark>
    <name>Naveen Bigdeli</name>
    <description><![CDATA[<div dir="ltr">email: naveen.bigdeli@oliveo.gr<br>skype: bidgeli.oliveo</div>]]></description>
    <styleUrl>#style14</styleUrl>
    <Point>
      <coordinates>39.134674,21.663172,0.000000</coordinates>
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
$kml[] = '<Style id="style14">';
$kml[] = '<IconStyle>';
$kml[] = '<Icon>';
$kml[] = '<href>http://maps.gstatic.com/mapfiles/ms2/micons/man.png</href>';
$kml[] = '</Icon>';
$kml[] = '</IconStyle>';
$kml[] = '</Style>';
/*
if (!($stmt_select_one_oliveopartner = $mysqli->prepare (" SELECT OliveoPartner.* FROM OliveoPartner WHERE OliveoPartner.PartnerID = ?   ")))
   { printf("Error preparing statement stmt_select_one_oliveopartner"); }
+-----------+----------------+------------------------------+--------------+--------+--------------------------+
| PartnerID | Name           | Coordinates                  | Country      | City   | Photo                    |
+-----------+----------------+------------------------------+--------------+--------+--------------------------+
|         1 | Naveen Bigdeli | 39.134674,21.663172,0.000000 | Saudi Arabia | Jeddah | ./photos/op-1-person.jpg |
+-----------+----------------+------------------------------+--------------+--------+--------------------------+
*/
if(!($stmt_select_one_oliveopartner->bind_param("i",$oid))){
		echo "fail bind";
		};
if(!($stmt_select_one_oliveopartner->execute())){
		echo "fail trace";
		};
    /* bind result variables */
$stmt_select_one_oliveopartner->bind_result($pid, $pname,$pcoordinates,$pcountry,$pcity,$pphoto);

while ($stmt_select_one_oliveopartner->fetch()) {
$kml[] = '<Placemark>';
$kml[] = "<name>Oliveo Partner".$pid."</name>";
$kml[] = "<description><![CDATA[<div dir=\"ltr\">Name:".$pname."<br>Country:".$pcountry."<br>City:".$pcity."<br></div>]]></description>";
$kml[] = '<styleUrl>#style14</styleUrl>';
$kml[] = '<Point>';
$kml[] = "<coordinates>".$pcoordinates."</coordinates>";
$kml[] = '</Point>';
$kml[] = '</Placemark>';
}



$kml[] = '</Document>';
$kml[] = '</kml>';
$kmlOutput = join("\n", $kml);
//header('Content-type: application/vnd.google-earth.kml+xml');
$file = "./kmls/o-".$oid.".kml";
file_put_contents($file, $kmlOutput);

$stmt_select_one_oliveopartner->free_result();
  }
else
  {
  echo "Files must be either JPEG or GIF and less than 10,000 kb";
  }


}
/*
$stmt_select_oliveopartner = $mysqli->prepare (" 
* SELECT OliveoPartner.PartnerID,OliveoPartner.Name,OliveoPartner.Coordinates,OliveoPartner.Country,OliveoPartner.City FROM OliveoPartner 
*/

$stmt_select_oliveopartner->execute();

    /* bind result variables */
$stmt_select_oliveopartner->bind_result($oid, $oname, $ocoordinates, $ocountry, $ocity);

echo <<<EOF
<td>
<form action="insertpallete.php">
<select name="opartid">
EOF;

while ($stmt_select_oliveopartner->fetch()) {
  $ste="Oliveo Partner ID:&nbsp;".$oid."&nbsp; Name:&nbsp; ".$oname."&nbsp Coordinates:&nbsp ".$ocoordinates."&nbsp Country:&nbsp ".$ocountry."&nbsp City:&nbsp ".$ocity;
  printf("<option value=\"%s\">%s</option>", $oid , $ste);
  echo "<br>";
}
echo <<<EOF
</select>
<input type="submit" value="Submit">
</form>
<tr>
EOF;


?>




<?php require('footer.php');?>
