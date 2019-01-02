/**
* Customer Table
*/
CREATE TABLE `Customer` (
    `ID` int NOT NULL AUTO_INCREMENT,
    `FirstName` varchar(16) NOT NULL,
    `LastName` varchar(16) NOT NULL,
    `Email` varchar(128) NOT NULL UNIQUE,
    `Password` varchar(255) NOT NULL,
    
    PRIMARY KEY (`ID`)
);

/**
* Admin Table
*/
CREATE TABLE `Admin` (
	`ID` int NOT NULL AUTO_INCREMENT,
    `Username` varchar(32) NOT NULL UNIQUE,
    `Password` varchar(255) NOT NULL,

    PRIMARY KEY (`ID`)
);

/**
* Vehicle Table
*/
CREATE TABLE `Vehicle` (
	`Reg` varchar(10) NOT NULL,
    `CustomerID` int NOT NULL,
    `HasPermit` bit(1) NOT NULL DEFAULT 0,

    PRIMARY KEY (`Reg`),
    FOREIGN KEY (`CustomerID`) REFERENCES `Customer`(`ID`)
);

/**
* Carpark Table
*/
CREATE TABLE `Carpark` (
	`ID` int NOT NULL AUTO_INCREMENT,
    `Name` varchar(32) NOT NULL,
    `Price` decimal(13,2) NOT NULL,

    PRIMARY KEY (`ID`)
);

/**
* Parking Table
*/ 
CREATE TABLE `Parking` (
	`Reg` varchar(10) NOT NULL,
    `EntryDateTime` datetime NOT NULL,
    `ExitDateTime` datetime NOT NULL DEFAULT NOW(),
    `CarparkID` int NOT NULL,

    PRIMARY KEY (`Reg`, `EntryDateTime`),
    FOREIGN KEY (`Reg`) REFERENCES `Vehicle`(`Reg`),
    FOREIGN KEY (`CarparkID`) REFERENCES `Carpark`(`ID`)
);