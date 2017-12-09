<?php require('header.php');?>
<?php
session_start();
unset($_SESSION['cropid']);
////An den exoun akoma kataxwrhthei ta Crops edw ftiaxnetai ena koumpi gia pame sth selida insertfield.php
////Apo ekei afou ginei epilogi tou field ap opou prohlthan ta crops tha metaferthoume sth selida insertcrop.php
////opou tha ginei kataxwrhsh twn idiothtwn tou crop
echo <<<EOF
<tr>
<td align="center">
 	<table class="simplelist">
 	<tr>
	 <th align="center">If not all the Crops that were used for the LOT are listed start over by selecting:<br>Field->Crops <br> until all the nessesary Crops are available to check:</td></tr>
    <tr> 
	 <th align="center">
      <form enctype="multipart/form-data" name = "input" action = "insertfield.php?" method = "post"> 	
	  <input type="submit" value="Add more Crops before moving on" name="submit" align = "center">
	  </form>
	 </td>
    </tr>
	</table>
</td>
</tr>
EOF;


////Edw ftiaxnetai mia checklist me ola ta crops pou einai kataxwrhmena sth bash gia na epilegoun osa xreiazontai
////Ta IDs twn crop pou epilegontai mpainoun se enan pinaka cropid[] sto $_SESSION gia na xrhsimopoihthoun 
////argotera sth selida insertlot.php pou ginetai insert h LOT

/*
if (!($stmt_select_crop = $mysqli->prepare ("  SELECT Crop.CropID,Crop.Date, Crop.Weight FROM Crop; ")))
  { printf("Error preparing statement stmt_select_crop"); }
+--------+------------+--------+
| CropID | Date       | Weight |
+--------+------------+--------+
|      1 | 2014-08-18 |    300 |
|      2 | 2014-08-18 |    300 |
|      3 | 2014-01-01 |    300 |
+--------+------------+--------+
*/

$stmt_select_crop->execute();
/* bind result variables */
$stmt_select_crop->bind_result($cid, $cdate, $cweight);
echo <<<EOF
<tr>
<td align="center">
<table class="simplelist">
<tr>
<td>
<form action="insertexsite.php" method="post">
EOF;
while ($stmt_select_crop->fetch()) {
  $ste="Crop ID:&nbsp;".$cid."&nbsp; Date :&nbsp; ".$cdate."&nbsp Weight :&nbsp ".$cweight;
  printf("<input type=\"checkbox\" name=\"cropid[]\" value=\"%s\">%s</input>", $cid , $ste);
  echo "<br>";
}
echo <<<EOF
</td>
</tr>
<tr>
<th><input type="submit" value="Submit">
</form>
</td>
</tr>
</table>
</td>
</tr>
EOF;


?>
<?php require('footer.php');?>