<?php require('header.php');?>
<?php
session_start();
unset($_SESSION['lotid']); //H entoli diagrafei oti plhrofories einai apothikeymenes ston pinaka lotid[] apo prohgoumenes energeies apo ta add

////An den exoun akoma kataxwrhthei ola ta LOTs edw ftiaxnetai ena koumpi gia pame sth selida selectcrop.php
////Apo ekei afou ginei epilogi twn crops ap opou prohlthan ta LOTs tha metaferthoume sth selida insertexsite.php
////kai sth synexeia sth selida insertlot.php opou tha ginei kataxwrhsh twn idiothtwn tou LOT kai tha ginei kai 
////i sysxetish me ta dedomena apo ta crops pou xrhsimopoihthikan kai to meros opou egine to extraction

echo <<<EOF
 <tr>
 <td align="center">
 	<table class="simplelist">
 	<tr><th align="center">If not all the LOTs that were used for the pallete are listed start over by selecting :<br> Crops->Extraction Site-> Lot <br> until all the nessesary LOTs are available to check:</th></tr>
    <tr><th align="center">
    <form enctype="multipart/form-data" name = "input" action = "selectcrop.php?" method = "post"> 	
	
    <input type="submit" value="Add more LOTs before moving on" name="submit" align = "center">

	</form>
	</th></tr>
	</table>
 </td>
 </tr>
EOF;

////Edw ftiaxnetai mia checklist me ola ta LOTs pou einai kataxwrhmena sth bash gia na epilegoun osa xreiazontai
////Ta IDs twn LOTs pou epilegontai mpainoun se enan pinaka lotid[] sto $_SESSION gia na xrhsimopoihthoun 
////argotera sth selida insertpallete.php pou ginetai insert h palleta kai kataxwrountai kai oi sxeseis apo poia
////LOTs apoteleitai

$stmt_select_lot->execute();
/* bind result variables */
$stmt_select_lot->bind_result($lid, $ldate, $lquality, $lacidity, $lweight);

echo <<<EOF
<tr>
<td align="center">
<table class="simplelist">
<tr>
<td>
<form action="insertbottlingsite.php" method="post">
EOF;

while ($stmt_select_lot->fetch()) {
  $ste="Lot ID:&nbsp;".$lid."&nbsp; Date :&nbsp; ".$ldate."&nbsp Quality :&nbsp ".$lquality."&nbsp Acidity :&nbsp ".$lacidity."&nbsp Weight :&nbsp ".$lweight;
  printf("<input type=\"checkbox\" name=\"lotid[]\" value=\"%s\">%s</input>", $lid , $ste);
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