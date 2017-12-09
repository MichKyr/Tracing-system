<?php require('header.php');?>
<td>
<?php
session_start();
unset($_SESSION['fieldid']);
//Ayth h forma ektypwnetai kathe fora pou xekinaei h selida gia na kanei insert o xrhsths an den einai to field sth lista
echo <<< EOF
    <td>
	<form enctype="multipart/form-data" name = "input" action = "insertfield.php" method = "post"> 
	<input type ="hidden" value = "insert" name = "action">
	
	<table border = "1" class="simplelist">
	<tr> <th colspan = "2">Insert Field Details
	<tr> <td>Owner Name : <td><input type="text" size="30" maxlength="300" name="field_owner_name">
	<tr> <td>Owner e-mail : <td><input type="text" size="30" maxlength="300" name="field_owner_email">
	<tr> <td>Owner Photo : <td><input type="file" size="30" maxlength="300" name="field_owner_photo">JPEG or GIF(size<10MB)
	<tr> <td>Variety : <td><input type="text" size="30" maxlength="300" name="field_variety">
	<tr> <td>Year of Est. : <td><input type="text" size="30" maxlength="300" name="field_year_of_est">
	<tr> <td>Coordinates : <td><input type="text" size="30" maxlength="600" name="field_coordinates">
	<tr> <td>Field Photo : <td><input type="file" size="30" maxlength="300" name="field_photo">JPEG or GIF(size<10MB)
	<tr> <th colspan = "2"><a width=100%><input type="submit" value="Insert" name="submit" align = "center"></a>
	</TABLE>
	</form>

    
EOF;


if ($_POST['action'] == 'insert'){

//An exei paththei to koumpi insert tote ekteleitai aytos o kwdikas gia na kanei thn kataxwrhsh tou field sth bash
// Arxika elegxetai an to arxeio eikonas pou dothike einai ontws arxeio eikonas kai den einai kati kakoboulo gia logous
//security. Ayto ginetai me thn synarthsh image_type_to_mime_type(exif_imagetype($file)) pou diavazei ta prwta bits tou 
//arxeiou kai epistrefei me sigouria ti eidos arxeiou egine upload.
$file = $_FILES["field_owner_photo"]["tmp_name"];
$field_owner_photo_mime = image_type_to_mime_type(exif_imagetype($file));
$file = $_FILES["field_photo"]["tmp_name"];
$field_photo_mime = image_type_to_mime_type(exif_imagetype($file));

//Sth synexeia elegxetai an o typos kai to megethos tou arxeiou einai apodekta kai an einai proxwraei h kataxwrhsh toy field
//me tis plhrofories pou exoun pleon kataxwrhthei apo thn parapanw form
if ((($field_owner_photo_mime == "image/gif")
  || ($field_owner_photo_mime == "image/jpeg")
  && ($_FILES["field_owner_photo"]["size"] < 10240*1024))
  &&(($field_photo_mime == "image/gif")
  || ($field_photo_mime == "image/jpeg")
  && ($_FILES["field_photo"]["size"] < 10240*1024)))
  {
    $stmt_insert_field->bind_param("sssis", $_POST['field_owner_name'],
							$_POST['field_owner_email'],
							$_POST['field_variety'],
							$_POST['field_year_of_est'],
							$_POST['field_coordinates']);
	if($stmt_insert_field->execute())
	{   
		$fid = $stmt_insert_field->insert_id;//Edw travame to id apo thn kataxwrhsh pou molis egine gia na xrhsimopoihthei parakatw(photos,kml)s
		$stmt_insert_field->free_result();
echo <<< EOF
Success!!!!
EOF;
	}
	else
	{
		$stmt_insert_field->free_result();
echo <<<EOF
Failed!!!!s
EOF;
	}
	
    $fop="./photos/"."fop-".$fid."-".$_FILES["field_owner_photo"]["name"]; //fop: field owner photo , fp:field photo
    move_uploaded_file($_FILES["field_owner_photo"]["tmp_name"],$fop);

    $fp="./photos/"."fp-".$fid."-". $_FILES["field_photo"]["name"];
    move_uploaded_file($_FILES["field_photo"]["tmp_name"],$fp);

    $stmt_insert_field_photos->bind_param("ssi", $fop,
							$fp,
							$fid);
	if($stmt_insert_field_photos->execute())
	{   
		$stmt_insert_field_photos->free_result();

echo <<< EOF
		Success uploading Photos!!!!
EOF;



	}
	else
	{
		$stmt_insert_field_photos->free_result();
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
  <Style id="style34">
    <LineStyle>
      <color>FF33FF33</color>
      <width>5</width>
    </LineStyle>
  </Style>
  <Placemark>
    <name>Plantation - 02.031</name>
    <description><![CDATA[<div dir="ltr">Tree Type: Koroneiki<br>Tree size: Medium<br>Average Yield: 2tn<br>Annual Fluctuation: 20%<br>Class: A<br>Owner: &nbsp;C.Papazisis<br>Partner since: 1990<br>Oliveo Responsible: Iraklis P.</div>]]></description>
    <styleUrl>#style34</styleUrl>
    <LineString>
      <tessellate>1</tessellate>
      <coordinates>
        22.032597,37.227802,0.000000
        22.031122,37.228073,0.000000
        22.031090,37.227207,0.000000
        22.031240,37.227085,0.000000
        22.031963,37.226887,0.000000
        22.032576,37.226742,0.000000
        22.032875,37.226780,0.000000
        22.033375,37.226646,0.000000
        22.033810,37.226799,0.000000
        22.033627,37.227371,0.000000
        22.033594,37.227940,0.000000
        22.033005,37.227879,0.000000
        22.032597,37.227802,0.000000
      </coordinates>
    </LineString>
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
/*
if (!($stmt_select_one_field = $mysqli->prepare (" SELECT Field.* FROM Field WHERE Field.FieldID = ?   ")))
   { printf("Error preparing statement stmt_select_one_field"); }
+---------+-------------+------------+-------------------------------+-----------+-----------+------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------+
| FieldID | OwnerName   | OwnerEmail | OwnerPhoto                    | Variety   | YearOfEst | Coordinates                                                                                                                                                                                                                                                                                                                                                                              | Photo                   |
+---------+-------------+------------+-------------------------------+-----------+-----------+------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------+
|       1 | C.Papazisis |            | ./photos/fop-1-fieldowner.jpg | Koroneiki |      1990 | 22.032597,37.227802,0.000000 22.031122,37.228073,0.000000 22.031090,37.227207,0.000000 22.031240,37.227085,0.000000 22.031963,37.226887,0.000000 22.032576,37.226742,0.000000 22.032875,37.226780,0.000000 22.033375,37.226646,0.000000 22.033810,37.226799,0.000000 22.033627,37.227371,0.000000 22.033594,37.227940,0.000000 22.033005,37.227879,0.000000 22.032597,37.227802,0.000000 | ./photos/fp-1-field.jpg |
+---------+-------------+------------+-------------------------------+-----------+-----------+------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------+
*/
if(!($stmt_select_one_field->bind_param("i",$fid))){
		echo "fail bind";
		};
if(!($stmt_select_one_field->execute())){
		echo "fail trace";
		};
    /* bind result variables */
$stmt_select_one_field->bind_result($fid, $fownername, $fowneremail , $fownerphoto , $fvariety, $fyest, $fcoordinates, $fphoto);

while ($stmt_select_one_field->fetch()) {
$kml[] = '<Placemark>';
$kml[] = "<name>Plantation-".$fid."</name>";
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

$kml[] = '</Document>';
$kml[] = '</kml>';
$kmlOutput = join("\n", $kml);
//header('Content-type: application/vnd.google-earth.kml+xml');
$file = "./kmls/f-".$fid.".kml";
file_put_contents($file, $kmlOutput);
$stmt_select_one_field->free_result();	
  }
else
  {
  echo "Files must be either JPEG or GIF and less than 10,000 kb";
  }


}

/////Edw Ftiaxnetai i Select Form ap opou dialegoume to Field ap opou prohlthan ta crops
/////To ID ths epiloghs metaferetai sth selida insertcrop.php gia na ginei i sysxetish

$stmt_select_field->execute();

    /* bind result variables */
$stmt_select_field->bind_result($fid, $fownername, $fvariety, $fyest);

echo <<<EOF
<td>
<form action="insertcrop.php">
<select name="fieldid">
EOF;

while ($stmt_select_field->fetch()) {
  $stf="FieldID:&nbsp;".$fid."&nbsp; Owner:&nbsp; ".$fownername."&nbsp Variety:&nbsp ".$fvariety."&nbsp EST:&nbsp ".$fyest;
  printf("<option value=\"%s\">%s</option>", $fid , $stf);
  echo "<br>";
}
$stmt_select_field->free_result();
echo <<<EOF
</select>
<input type="submit" value="Submit">
</form>
EOF;


?>
<tr>


<?php require('footer.php');?>
