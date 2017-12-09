<?php



if (!($stmt_db_create = $mysqli->prepare("
DROP DATABASE IF EXISTS olitrace;
CREATE DATABASE IF NOT EXISTS olitrace;
USE olitrace;
SET storage_engine=INNODB;
SET NAMES 'utf8';

CREATE TABLE BottlingSite
 (BottlingSiteID int AUTO_INCREMENT,
 Name varchar(64),
 OwnerName varchar(64),
 City varchar(32),
 Address varchar(64),
 Coordinates varchar(128),
 Phonenumber int(15),
 Photo varchar(64),
 OwnerPhoto varchar(64),
 PRIMARY KEY (BottlingSiteID));

CREATE TABLE OliveoPartner
(PartnerID int AUTO_INCREMENT,
Name varchar(64),
Coordinates varchar(128),
Country varchar(32),
City varchar(32),
Photo varchar(64),
PRIMARY KEY (PartnerID));

CREATE TABLE ExtractionSite
 (ExtractionSiteID int AUTO_INCREMENT,
 Name varchar(64),
 OwnerName varchar(64),
 City varchar(32),
 Address varchar(64),
 Coordinates varchar(128),
 Phonenumber int(15),
 Photo varchar(64),
 OwnerPhoto varchar(64),
 PRIMARY KEY (ExtractionSiteID));

CREATE TABLE Pallete
 (PalleteID int AUTO_INCREMENT,
 BottlingSiteID int,
 PartnerID int,
 DateShipped date,
 DateBottled date,
 QRcode varchar(64),
 PRIMARY KEY (PalleteID),
 FOREIGN KEY (`BottlingSiteID`) REFERENCES `BottlingSite`(`BottlingSiteID`)
 ON DELETE CASCADE,
 FOREIGN KEY (`PartnerID`) REFERENCES `OliveoPartner`(`PartnerID`)
 ON DELETE CASCADE);
 
CREATE TABLE Lot
 (LotID int AUTO_INCREMENT,
  ExtractionSiteID int,
 Date date,
 Quality varchar(32),
 Acidity varchar(32),
 Weight int,
 PRIMARY KEY (LotID),
 FOREIGN KEY (`ExtractionSiteID`) REFERENCES `ExtractionSite`(`ExtractionSiteID`)
 ON DELETE CASCADE);
 
CREATE TABLE FromLot
 (PalleteID int,
 LotID int,
 PRIMARY KEY (PalleteID,LotID),
 FOREIGN KEY (`PalleteID`) REFERENCES `Pallete`(`PalleteID`)
   ON DELETE CASCADE,
 FOREIGN KEY (`LotID`) REFERENCES `Lot`(`LotID`)
   ON DELETE CASCADE);
 
CREATE TABLE Field
 (FieldID int AUTO_INCREMENT,
 OwnerName varchar(64),
 OwnerEmail varchar (64),
 OwnerPhoto varchar(64),
 Variety varchar(64),
 YearOfEst int,
 Coordinates varchar(600),
 Photo varchar(64),
 PRIMARY KEY (FieldID));

CREATE TABLE Crop
(CropID int AUTO_INCREMENT,
 FieldID int,
 Date date,
 Weight int,
 PRIMARY KEY (CropID),
 FOREIGN KEY (`FieldID`) REFERENCES `Field`(`FieldID`)
 ON DELETE CASCADE);
 
 
 CREATE TABLE FromCrop
 (CropID int,
 LotID int,
 PRIMARY KEY (CropID ,LotID),
 FOREIGN KEY (`CropID`) REFERENCES `Crop`(`CropID`)
  ON DELETE CASCADE,
 FOREIGN KEY (`LotID`) REFERENCES `Lot`(`LotID`)
   ON DELETE CASCADE);
 

 

 
CREATE TABLE ShippedTo
(PartnerID int,
PalleteID int,
Date date,
QRcode varchar(128),
  PRIMARY KEY (PalleteID),
 FOREIGN KEY (`PalleteID`) REFERENCES `Pallete`(`PalleteID`)
  ON DELETE CASCADE,
 FOREIGN KEY (`PartnerID`) REFERENCES `OliveoPartner`(`PartnerID`)
   ON DELETE CASCADE);"
)))
 { printf("Error preparing statement stmt_db_create"); }
?>
