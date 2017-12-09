<?php require('header.php');?>

<?php
session_start();
unset($_SESSION['botsiteid']);
if ($_SESSION['lotid'] == '') {
$_SESSION['lotid'] = $_POST['lotid'];
}
?>
<?php
/*
CREATE TABLE BottlingSite
 (BottlingSiteID int AUTO_INCREMENT,
 Name varchar(32),
 OwnerName varchar(32),
 City varchar(32),
 Address varchar(32),
 Coordinates varchar(64),
 Phonenumber int,
 Photo varchar(32),
 OwnerPhoto varchar(32),
 PRIMARY KEY (BottlingSiteID));
*/
echo <<< EOF
    <td>
	<form enctype="multipart/form-data" name = "input" action = "insertbottlingsite.php" method = "post"> 
	<input type ="hidden" value = "insert" name = "action">
	
	<table border = "1">
	<tr> <td colspan = "2">Insert Bottling Site Details
	<tr> <td>Name : <td><input type="text" size="30" maxlength="300" name="botsite_name">
	<tr> <td>Owner Name : <td><input type="text" size="30" maxlength="300" name="botsite_owner_name">
	<tr> <td>City : <td><input type="text" size="30" maxlength="300" name="botsite_city">
	<tr> <td>Address : <td><input type="text" size="30" maxlength="300" name="botsite_address">
	<tr> <td>Coordinates : <td><input type="text" size="30" maxlength="300" name="botsite_coordinates">
	<tr> <td>Phone Number : <td><input type="text" size="30" maxlength="300" name="botsite_phone">
	<tr> <td>Bottling Site Photo : <td><input type="file" name="botsite_photo">
	<tr> <td>Owner Photo : <td><input type="file" size="30" name="botsite_owner_photo">
	<TR> <TD colspan = "2"><input type="submit" value="Insert" name="submit" align = "center">
	</TABLE>
	</form>

    
EOF;


if ($_POST['action'] == 'insert'){
$file = $_FILES["botsite_owner_photo"]["tmp_name"];
$botsite_owner_photo_mime = image_type_to_mime_type(exif_imagetype($file));
$file = $_FILES["botsite_photo"]["tmp_name"];
$botsite_photo_mime = image_type_to_mime_type(exif_imagetype($file));
if ((($botsite_owner_photo_mime == "image/gif")
  || ($botsite_owner_photo_mime == "image/jpeg")
  && ($_FILES["botsite_owner_photo"]["size"] < 10240*1024))
  &&(($botsite_photo_mime == "image/gif")
  || ($botsite_photo_mime == "image/jpeg")
  && ($_FILES["botsite_photo"]["size"] < 10240*1024)))
  {
/*
	$stmt_insert_bottlingsite = $mysqli->prepare (" INSERT INTO BottlingSite(Name,OwnerName,City,Address,Coordinates,Phonenumber)
  VALUES (?, ?, ?, ?, ?, ?)
*/
    $stmt_insert_bottlingsite->bind_param("ssssss", $_POST['botsite_name'],
							$_POST['botsite_owner_name'],
							$_POST['botsite_city'],
							$_POST['botsite_address'],
							$_POST['botsite_coordinates'],
							$_POST['botsite_phone']);
	if($stmt_insert_bottlingsite->execute())
	{   
		$bid = $stmt_insert_bottlingsite->insert_id;
		$stmt_insert_bottlingsite->free_result();

echo <<< EOF
		Success!!!!
EOF;

	}
	else
	{
		$stmt_insert_bottlingsite->free_result();
echo <<<EOF
		Failed!!!!
EOF;
	}
	$bop="./photos/"."bop-".$bid."-".$_FILES["botsite_owner_photo"]["name"];
  move_uploaded_file($_FILES["botsite_owner_photo"]["tmp_name"],
    $bop);
    $bp="./photos/"."bp-".$bid."-". $_FILES["botsite_photo"]["name"];
  move_uploaded_file($_FILES["botsite_photo"]["tmp_name"],
    $bp);
    $stmt_insert_bottlingsite_photos->bind_param("ssi", $bp,
							$bop,
							$bid);
	if($stmt_insert_bottlingsite_photos->execute())
	{   
		$stmt_insert_bottlingsite_photos->free_result();

echo <<< EOF
		Success uploading Photos!!!!
EOF;
	}
	else
	{
		$stmt_insert_bottlingsite_photos->free_result();
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
  <Style id="style2">
    <IconStyle>
      <Icon>
        <href>http://maps.gstatic.com/mapfiles/ms2/micons/earthquake.png</href>
      </Icon>
    </IconStyle>
  </Style>

  <Placemark>
    <name>Bottling Site</name>
    <description><![CDATA[<div><span style="font-size:10pt">Owner: Messinia Union of Agricultural Cooperatives</span></div><div><span style="font-size:10pt">Average Annual Yield: 2mn bottles</span></div><div>Bottle types: Dorica, Maresca</div><div>Class: A+</div><div>Established: 1985</div>]]></description>
    <styleUrl>#style2</styleUrl>
    <Point>
      <coordinates>22.051117,37.076691,0.000000</coordinates>
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
$kml[] = '<Style id="style2">';
$kml[] = '<IconStyle>';
$kml[] = '<Icon>';
$kml[] = '<href>http://maps.gstatic.com/mapfiles/ms2/micons/earthquake.png</href>';
$kml[] = '</Icon>';
$kml[] = '</IconStyle>';
$kml[] = '</Style>';
/*
if (!($stmt_select_one_bottlingsite = $mysqli->prepare (" SELECT BottlingSite.* FROM BottlingSite WHERE BottlingSite.BottlingSiteID = ?   ")))
   { printf("Error preparing statement stmt_select_one_bottlingsite"); }
+----------------+---------------------------------------------+---------------------------------------------+----------+---------+------------------------------+-------------+---------------------------+-----------------------------+
| BottlingSiteID | Name                                        | OwnerName                                   | City     | Address | Coordinates                  | Phonenumber | Photo                     | OwnerPhoto                  |
+----------------+---------------------------------------------+---------------------------------------------+----------+---------+------------------------------+-------------+---------------------------+-----------------------------+
|              1 | Messinia Union of Agricultural Cooperatives | Messinia Union of Agricultural Cooperatives | Messinia | kapou   | 22.051117,37.076691,0.000000 |  1231312123 | ./photos/bp-1-botsite.jpg | ./photos/bop-1-botowner.jpg |
+----------------+---------------------------------------------+---------------------------------------------+----------+---------+------------------------------+-------------+---------------------------+-----------------------------+
*/
if(!($stmt_select_one_bottlingsite->bind_param("i",$bid))){
		echo "fail bind";
		};
if(!($stmt_select_one_bottlingsite->execute())){
		echo "fail trace";
		};
    /* bind result variables */
$stmt_select_one_bottlingsite->bind_result($bid, $bname, $bownername, $bcity , $badress , $bcoordinates, $bphone, $bphoto, $bownerphoto);

while ($stmt_select_one_bottlingsite->fetch()) {
$kml[] = '<Placemark>';
$kml[] = "<name>Extraction Site-".$bid."</name>";
$kml[] = "<description><![CDATA[<div dir=\"ltr\">Name:".$bname."<br>Owner:".$bownername."<br>City:".$bcity."<br>Adress:". $badress."<br>Phone Number:".$bphone."<br></div>]]></description>";
$kml[] = '<styleUrl>#style2</styleUrl>';
$kml[] = '<Point>';
$kml[] = "<coordinates>".$bcoordinates."</coordinates>";
$kml[] = '</Point>';
$kml[] = '</Placemark>';
}

$kml[] = '</Document>';
$kml[] = '</kml>';
$kmlOutput = join("\n", $kml);
//header('Content-type: application/vnd.google-earth.kml+xml');
$file = "./kmls/b-".$bid.".kml";
file_put_contents($file, $kmlOutput);

$stmt_select_one_bottlingsite->free_result();

  }
else
  {
  echo "Files must be either JPEG or GIF and less than 10,000 kb";
  }


}
/*
$stmt_select_bottlingsite = $mysqli->prepare (" SELECT BottlingSite.BottlingSiteID,BottlingSite.Name,BottlingSite.OwnerName,BottlingSite.City,BottlingSite.Address FROM BottlingSite  
*/

$stmt_select_bottlingsite->execute();

    /* bind result variables */
$stmt_select_bottlingsite->bind_result($bid, $bname, $boname, $bcity, $baddress);

echo <<<EOF
<td>
<form action="insertpartner.php">
<select name="botsiteid">
EOF;

while ($stmt_select_bottlingsite->fetch()) {
  $ste="Bot.Site ID:&nbsp;".$bid."&nbsp; Name:&nbsp; ".$bname."&nbsp Owner Name:&nbsp ".$boname."&nbsp City:&nbsp ".$bcity."&nbsp Address:&nbsp ".$baddress;
  printf("<option value=\"%s\">%s</option>", $bid , $ste);
  echo "<br>";
}
echo <<<EOF
</select>
<input type="submit" value="Submit">
</form>
EOF;


?>

<?php require('footer.php');?>
