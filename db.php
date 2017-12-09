<?php

////To arxeio ayto kaleitai kathe fora apo to header.php pou uparxei se oles tis selides opote
//// kai kathe selida sundeetai me th vash kai einai se thesi na ektelesei ta parakatw statements

 // Create connection
 $mysqli = new mysqli("localhost", "root", "123", "olitrace");

 /* check connection */
 if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
 }
if (!$mysqli->set_charset("utf8")) {   
    printf("Error loading character set utf8: %s\n", $mysqli->error);
} 
 // Prepare statements

//Select statements pou fernoun ta dedomena gia tn kathe selida sta arxika koumpia
if (!($stmt_trace_field = $mysqli->prepare (" SELECT DISTINCT Field.* FROM Field INNER JOIN Crop INNER JOIN FromCrop INNER JOIN Lot INNER JOIN FromLot WHERE Crop.FieldID = Field.FieldID AND FromCrop.CropID = Crop.CropID AND FromCrop.LotID = Lot.LotID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID= ? ;  ")))
   { printf("Error preparing statement stmt_trace_field"); }
if (!($stmt_trace_exsite = $mysqli->prepare ("SELECT DISTINCT ExtractionSite.* FROM ExtractionSite INNER JOIN Lot INNER JOIN FromLot WHERE ExtractionSite.ExtractionSiteID=Lot.ExtractionSiteID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=? ; ")))
   { printf("Error preparing statement stmt_trace_exsite"); }
if (!($stmt_trace_botsite = $mysqli->prepare ("SELECT DISTINCT BottlingSite.* FROM BottlingSite INNER JOIN Pallete WHERE BottlingSite.BottlingSiteID=Pallete.BottlingSiteID AND PalleteID =? ; ")))
   { printf("Error preparing statement stmt_trace_botsite"); }
if (!($stmt_trace_dest = $mysqli->prepare ("   SELECT DISTINCT OliveoPartner.* FROM OliveoPartner INNER JOIN Pallete WHERE OliveoPartner.PartnerID=Pallete.PartnerID AND PalleteID= ? ;")))
   { printf("Error preparing statement stmt_trace_dest"); }
if (!($stmt_trace_dates = $mysqli->prepare ("SELECT Crop.Date,Lot.Date,Pallete.DateBottled,Pallete.DateShipped FROM Field INNER JOIN Crop INNER JOIN FromCrop INNER JOIN Lot INNER JOIN FromLot INNER JOIN Pallete WHERE Crop.FieldID = Field.FieldID AND FromCrop.CropID = Crop.CropID AND FromCrop.LotID = Lot.LotID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=Pallete.PalleteID AND Pallete.PalleteID= ? ORDER BY Lot.Date ; ")))
   { printf("Error preparing statement stmt_trace_dates"); }
if (!($stmt_trace_crops = $mysqli->prepare ("SELECT DISTINCT Crop.* , Field.Variety FROM Field INNER JOIN Crop INNER JOIN FromCrop INNER JOIN Lot INNER JOIN FromLot INNER JOIN Pallete WHERE Crop.FieldID = Field.FieldID AND FromCrop.CropID = Crop.CropID AND FromCrop.LotID = Lot.LotID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=Pallete.PalleteID AND Pallete.PalleteID= ? ;")))
   { printf("Error preparing statement stmt_trace_crops"); }
if (!($stmt_trace_lots = $mysqli->prepare ("SELECT DISTINCT Lot.*  FROM Field INNER JOIN Crop INNER JOIN FromCrop INNER JOIN Lot INNER JOIN FromLot INNER JOIN Pallete WHERE Crop.FieldID = Field.FieldID AND FromCrop.CropID = Crop.CropID AND FromCrop.LotID = Lot.LotID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=Pallete.PalleteID AND Pallete.PalleteID= ? ;")))
   { printf("Error preparing statement stmt_trace_lots"); }

   
//Select kai insert statements gia thn epilogi kai tin kataxwrhsh dedomenwn stis selides opou prosthetoume palletes

if (!($stmt_select_sites_ids = $mysqli->prepare ("SELECT DISTINCT Lot.ExtractionSiteID,Pallete.BottlingSiteID,Pallete.PartnerID FROM Field INNER JOIN Crop INNER JOIN FromCrop INNER JOIN Lot INNER JOIN FromLot INNER JOIN Pallete ON Crop.FieldID = Field.FieldID AND FromCrop.CropID = Crop.CropID AND FromCrop.LotID = Lot.LotID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=Pallete.PalleteID WHERE Pallete.PalleteID=? ;")))
   { printf("Error preparing statement stmt_select_sites_ids"); }
if (!($stmt_field_extr_line = $mysqli->prepare ("SELECT DISTINCT Field.Coordinates, ExtractionSite.Coordinates, Crop.CropID, Crop.Date, Crop.Weight FROM Field INNER JOIN Crop INNER JOIN FromCrop INNER JOIN Lot INNER JOIN ExtractionSite INNER JOIN FromLot INNER JOIN Pallete ON Crop.FieldID = Field.FieldID AND FromCrop.CropID = Crop.CropID AND FromCrop.LotID = Lot.LotID AND Lot.ExtractionSiteID = ExtractionSite.ExtractionSiteID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=Pallete.PalleteID WHERE Pallete.PalleteID= ? ORDER BY Field.Coordinates ASC , ExtractionSite.Coordinates ASC; ")))
   { printf("Error preparing statement stmt_field_extr_line"); }
if (!($stmt_extr_bott_line = $mysqli->prepare (" SELECT DISTINCT ExtractionSite.Coordinates, BottlingSite.Coordinates,Lot.LotID, Lot.Date,Lot.Quality,Lot.Acidity,Lot.Weight FROM Lot INNER JOIN ExtractionSite INNER JOIN FromLot INNER JOIN Pallete INNER JOIN BottlingSite ON Lot.ExtractionSiteID = ExtractionSite.ExtractionSiteID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=Pallete.PalleteID AND Pallete.BottlingSiteID=BottlingSite.BottlingSiteID WHERE Pallete.PalleteID= ?  ORDER BY ExtractionSite.Coordinates ASC, BottlingSite.Coordinates ASC ; ")))
   { printf("Error preparing statement stmt_extr_bott_line"); }  
 
//Field
if (!($stmt_select_field = $mysqli->prepare (" SELECT Field.FieldID,Field.OwnerName,Field.Variety,Field.YearOfEst FROM Field  ")))
   { printf("Error preparing statement stmt_select_field"); }
if (!($stmt_insert_field = $mysqli->prepare (" INSERT INTO Field(OwnerName,OwnerEmail,Variety,YearOfEst,Coordinates)
     VALUES (?, ?, ?, ?, ?)
  ")))
  { printf("Error preparing statement stmt_insert_field"); }
if (!($stmt_insert_field_photos = $mysqli->prepare (" UPDATE Field SET OwnerPhoto = ? , Photo = ? WHERE Field.FieldID = ?")))
  { printf("Error preparing statement stmt_insert_field_photos"); }
  
if (!($stmt_select_one_field = $mysqli->prepare (" SELECT Field.* FROM Field WHERE Field.FieldID = ?   ")))
   { printf("Error preparing statement stmt_select_one_field"); }

if (!($stmt_select_p_fields = $mysqli->prepare ("SELECT DISTINCT Field.* FROM Field INNER JOIN Crop INNER JOIN FromCrop INNER JOIN Lot INNER JOIN FromLot INNER JOIN Pallete ON Crop.FieldID = Field.FieldID AND FromCrop.CropID = Crop.CropID AND FromCrop.LotID = Lot.LotID AND Lot.LotID = FromLot.LotID AND FromLot.PalleteID=Pallete.PalleteID WHERE Pallete.PalleteID=? ;	")))
   { printf("Error preparing statement stmt_select_p_fields"); }
//Crop
if (!($stmt_insert_crop = $mysqli->prepare (" INSERT INTO Crop(FieldID,Date,Weight)
  VALUES (?, ?, ?)
  ")))
    { printf("Error preparing statement stmt_insert_crop"); }
if (!($stmt_select_crop = $mysqli->prepare ("  SELECT Crop.CropID,Crop.Date, Crop.Weight FROM Crop; ")))
  { printf("Error preparing statement stmt_select_crop"); }
  
//FromCrop (relation table)
if (!($stmt_insert_fromcrop = $mysqli->prepare (" INSERT INTO FromCrop(CropID,LotID)
  VALUES (?, ?)
  ")))
  { printf("Error preparing statement stmt_insert_fromcrop"); }

//Extraction Site
if (!($stmt_insert_extractionsite = $mysqli->prepare (" INSERT INTO ExtractionSite(Name,OwnerName,City,Address,Coordinates,Phonenumber)
  VALUES (?, ?, ?, ?, ?, ?)
  ")))
  { printf("Error preparing statement stmt_insert_extractionsite"); }
if (!($stmt_insert_extractionsite_photos = $mysqli->prepare (" UPDATE ExtractionSite SET Photo = ? , OwnerPhoto = ?  WHERE ExtractionSite.ExtractionSiteID = ?")))
  { printf("Error preparing statement stmt_insert_extractionsite_photos"); }
if (!($stmt_select_extractionsite = $mysqli->prepare (" SELECT ExtractionSite.ExtractionSiteID,ExtractionSite.Name,ExtractionSite.OwnerName,ExtractionSite.City,ExtractionSite.Address FROM ExtractionSite  ")))
   { printf("Error preparing statement stmt_select_extractionsite"); }
if (!($stmt_select_one_extractionsite = $mysqli->prepare (" SELECT ExtractionSite.* FROM ExtractionSite WHERE ExtractionSite.ExtractionSiteID = ?   ")))
   { printf("Error preparing statement stmt_select_one_extractionsite"); }
 
//LOT 
if (!($stmt_insert_lot = $mysqli->prepare (" INSERT INTO Lot(ExtractionSiteID,Date,Quality,Acidity,Weight)
  VALUES (?, ?, ?, ?, ?)
  ")))
  { printf("Error preparing statement stmt_insert_lot"); }
if (!($stmt_select_lot = $mysqli->prepare (" SELECT Lot.LotID,Lot.Date,Lot.Quality,Lot.Acidity,Lot.Weight FROM Lot  ")))
   { printf("Error preparing statement stmt_select_lot"); }

//FromLot (relation table)
if (!($stmt_insert_fromlot = $mysqli->prepare (" INSERT INTO FromLot(PalleteID,LotID)
  VALUES (?, ?)
  ")))
  { printf("Error preparing statement stmt_insert_fromlot"); }

//Bottling Site
if (!($stmt_insert_bottlingsite = $mysqli->prepare (" INSERT INTO BottlingSite(Name,OwnerName,City,Address,Coordinates,Phonenumber)
  VALUES (?, ?, ?, ?, ?, ?)
  ")))
  { printf("Error preparing statement stmt_insert_bottlingsite"); }
if (!($stmt_insert_bottlingsite_photos = $mysqli->prepare (" UPDATE BottlingSite SET Photo = ? , OwnerPhoto = ?  WHERE BottlingSite.BottlingSiteID = ?")))
  { printf("Error preparing statement stmt_insert_bottlingsite_photos"); }
if (!($stmt_select_bottlingsite = $mysqli->prepare (" SELECT BottlingSite.BottlingSiteID,BottlingSite.Name,BottlingSite.OwnerName,BottlingSite.City,BottlingSite.Address FROM BottlingSite  ")))
   { printf("Error preparing statement stmt_select_bottlingsite"); }
if (!($stmt_select_one_bottlingsite = $mysqli->prepare (" SELECT BottlingSite.* FROM BottlingSite WHERE BottlingSite.BottlingSiteID = ?   ")))
   { printf("Error preparing statement stmt_select_one_bottlingsite"); }

//Oliveo Partner - Destination   
if (!($stmt_insert_oliveopartner = $mysqli->prepare (" INSERT INTO OliveoPartner(Name,Coordinates,Country,City)
  VALUES (?, ?, ?, ?)
  ")))
  { printf("Error preparing statement stmt_insert_oliveopartner"); }
if (!($stmt_insert_oliveopartner_photo = $mysqli->prepare (" UPDATE OliveoPartner SET Photo = ? WHERE OliveoPartner.PartnerID = ?")))
  { printf("Error preparing statement stmt_insert_oliveopartner_photo"); }
if (!($stmt_select_oliveopartner = $mysqli->prepare (" SELECT OliveoPartner.PartnerID,OliveoPartner.Name,OliveoPartner.Coordinates,OliveoPartner.Country,OliveoPartner.City FROM OliveoPartner  ")))
   { printf("Error preparing statement stmt_select_oliveopartner"); }
if (!($stmt_select_one_oliveopartner = $mysqli->prepare (" SELECT OliveoPartner.* FROM OliveoPartner WHERE OliveoPartner.PartnerID = ?   ")))
   { printf("Error preparing statement stmt_select_one_oliveopartner"); }
   
//Pallete
if (!($stmt_insert_pallete = $mysqli->prepare (" INSERT INTO Pallete(BottlingSiteID,PartnerID,DateShipped,DateBottled)
  VALUES (?, ?, ?, ?)
  ")))
  { printf("Error preparing statement stmt_insert_pallete"); }
/*
  if (!($stmt_insert_shippedto = $mysqli->prepare (" INSERT INTO ShippedTo(PartnerID,PalleteID)
  VALUES (?, ?)
  ")))
  { printf("Error preparing statement stmt_insert_shippedto"); }
*/
?>
