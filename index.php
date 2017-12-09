<?php require('header.php');?>
<?php

if(!empty($_REQUEST['p'])){  // Edw ftiaxnetai h timi "?p=kati" gia na ginei meta POST sta link twn koumpiwn
$pallete="?p=".$_REQUEST['p'];
}else{
	$pallete="?p=1";         // An den dwthei timi apla vazw thn prwth palleta
}

?>

<td colspan="2" height="100" align="center"><a>Welcome to the most efficient traceability system for olive oil: the Olitrace &copy; System.<br>
We can give you precice information on the quality and production process of the bottle you are enjoying. <br>
Select the information you want to see:<br></a>
  <tr>
    <td width="100%" valign="top" align="center">
    	<br><br>
    	<table width="450px" class="menu" cellspacing="1" cellpadding="1">
    	<tr>
    	  <td><a href="field.php<?php echo $pallete ?>">The Field(s)</a></td>  
    	  <td><a href="extraction.php<?php echo $pallete ?>">The Extraction Site(s)</a></td>
      	  <td><a href="bottling.php<?php echo $pallete ?>">The Bottling Site</a></td>
		<tr>
      	  <td><a href="destination.php<?php echo $pallete ?>">The Destination</a></td>
		  <td><a href="people.php<?php echo $pallete ?>">The People</a></td>
		  <td><a href="dates.php<?php echo $pallete ?>">The Dates</a></td>
		<tr>
		</table>
		<table width="150px" class="menu" cellspacing="1" cellpadding="1">
		  <tr>
		  <td><a href="all.php<?php echo $pallete ?>">All</a></td>
		</table>
		
				<table width="50px" class="menu" cellspacing="1" cellpadding="1">
		  <tr>
		  <td><a href="selectlot.php">+ADD</a></td>
		</table>
	
		<tr>
	<tr>
	<td valign="top" align="center">

<?php require('footer.php');?>
