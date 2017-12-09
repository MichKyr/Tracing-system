<?php require_once('db.php');?>
<?php

if(!empty($_REQUEST['p'])){
$hlink = "?p=".$_REQUEST['p'];
}
else{
	$hlink = "";
	}
?>
<html>
<head>
	<title>Olitrace</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" type="image/ico" href="favicon.ico">
</head>
<body>
<table width="100%">
	<tr>
		<td colspan="2" height="100" align="center"><a href="index.php<?php echo $hlink?>"><img src="images/header.png"></a> </td>
	</tr>
</table>
    
<table class="frame_table" border="0" width="100%" height="100%" cellspacing="0" cellpadding="0">
<tr>
  <td class="frame_tleft">
  <td class="frame_top">
  <td class="frame_tright">
<tr>
  <td class="frame_left">
  <td>
<table border="0" class="main_table" width="100%" height="100%">
  <tr>

