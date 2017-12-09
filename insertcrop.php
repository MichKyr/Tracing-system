<?php require('header.php');?>
<td>
<?php
session_start();
$_SESSION['fieldid'] = $_REQUEST['fieldid'];
    $fid = $_REQUEST['fieldid'];
?>
<?php



if ($_POST['action'] == 'insert'){

    $stmt_insert_crop->bind_param("isi", $fid,
							$_POST['crop_date'],
							$_POST['crop_weight']);
	if($stmt_insert_crop->execute())
	{   
		$cid = $stmt_insert_crop->insert_id;
		$stmt_insert_crop->free_result();
echo <<< EOF
		Success!!!!
		<form enctype="multipart/form-data" name = "input" action = "selectcrop.php" method = "post"> 	
	<table border = "1">
	<TR> <TD colspan = "2"><input type="submit" value="Continue" name="submit" align = "center">
	</TABLE>
	</form>
EOF;

	}
	else
	{
		$stmt_insert_crop->free_result();
echo <<<EOF
		Failed!!!!
EOF;
	}
 
  }
  
else{

echo <<< EOF
    <td>
	<form enctype="multipart/form-data" name = "input" action = "insertcrop.php?fieldid=$fid" method = "post"> 
	<input type ="hidden" value = "insert" name = "action">
	
	<table border = "1" class="simplelist">
	<tr> <td colspan = "2">Insert Crop Details
	<tr> <td>Date : <td><input type="text" size="30" maxlength="300" name="crop_date">This must be given in format YYYY-MM-DD.
	<tr> <td>Weight : <td><input type="text" size="30" maxlength="300" name="crop_weight">In Kgs
	<TR> <TD colspan = "2"><input type="submit" value="Insert" name="submit" align = "center">
	</TABLE>
	</form>

    
EOF;
}





?>
<tr>



<?php require('footer.php');?>
