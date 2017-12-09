<?php require('header.php');?>
<?php
session_start();

if ($_SESSION['exsiteid'] == '') {
$_SESSION['exsiteid'] = $_REQUEST['exsiteid'];
}

?>

<?php


if ($_POST['action'] == 'insert'){

/*
	 $stmt_insert_lot = $mysqli->prepare (" INSERT INTO Lot(ExtractionSiteID,Date,Quality,Acidity)
  VALUES (?, ?, ?, ?)
*/
    $stmt_insert_lot->bind_param("isssi", $_SESSION['exsiteid'],
							$_POST['lot_date'],
							$_POST['lot_quality'],
							$_POST['lot_acidity'],
							$_POST['lot_weight']);
	if($stmt_insert_lot->execute())
	{   
		$lid = $stmt_insert_lot->insert_id;
		$stmt_insert_lot->free_result();
/*
if (!($stmt_insert_fromcrop = $mysqli->prepare (" INSERT INTO FromCrop(CropID,LotID)
  VALUES (?, ?)
  ")))
*/
if(!empty($_SESSION['cropid'])) {
             foreach($_SESSION['cropid'] as $cid) {

             $stmt_insert_fromcrop->bind_param("ii", $cid, $lid);
             $stmt_insert_fromcrop->execute();
             $stmt_insert_fromcrop->free_result();
            }
        }

echo <<< EOF
    <td align="center">Success!!!!



EOF;

	}
	else
	{
		$stmt_insert_lot->free_result();
echo <<<EOF
		<td>Failed!!!!
EOF;


	}
echo <<<EOF
    <tr><td align="center">
	 <table  class="simplelist">
	   <tr><td colspan = "2">
	    <form enctype="multipart/form-data" name = "input" action = "selectlot.php?" method = "post"> 	
	    <input type="submit" value="Continue to select the LOTs" name="submit" align = "center">
	    </form>
	    </td>
	   </tr>
	 </table>
	</td></tr>
 <tr>
 <td align="center">
 	<table class="simplelist">
 	<tr><th align="center">If you want to add more LOTs before moving on, start over by selecting :<br> Crops->Extraction Site-> Lot <br> </th></tr>
    <tr><th align="center">
    <form enctype="multipart/form-data" name = "input" action = "selectcrop.php?" method = "post"> 	
	
    <input type="submit" value="Add more LOTs before moving on" name="submit" align = "center">

	</form>
	</th></tr>
	</table>
 </td>
 </tr>
EOF;
  }
  else{
	  /*
CREATE TABLE Lot
 (LotID int AUTO_INCREMENT,
  ExtractionSiteID int,
 Date date,
 Quality varchar(32),
 Acidity varchar(32),
 PRIMARY KEY (LotID),
 FOREIGN KEY (`ExtractionSiteID`) REFERENCES `ExtractionSite`(`ExtractionSiteID`)
 ON DELETE CASCADE);
*/
echo <<< EOF
    <td>
	<form enctype="multipart/form-data" name = "input" action = "insertlot.php?exsiteid={$_SESSION['exsiteid']}" method = "post"> 
	<input type ="hidden" value = "insert" name = "action">
	
	<table border = "1">
	<tr> <td colspan = "2">Insert LOT Details
	<tr> <td>Date : <td><input type="text" size="30" maxlength="300" name="lot_date">This must be given in format YYYY-MM-DD.
	<tr> <td>Quality : <td><input type="text" size="30" maxlength="300" name="lot_quality">
	<tr> <td>Acidity : <td><input type="text" size="30" maxlength="300" name="lot_acidity">
	<tr> <td>Weight : <td><input type="text" size="30" maxlength="300" name="lot_weight">In Kgs
	<TR> <TD colspan = "2"><input type="submit" value="Insert" name="submit" align = "center">
	</TABLE>
	</form>

    
EOF;

  }



?>

<?php require('footer.php');?>
