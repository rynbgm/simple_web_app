CREATE DATABASE LIBRARY;

USE LIBRARY;

CREATE TABLE USER(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    FIRSTNAME VARCHAR(50),
    LASTNAME  VARCHAR(50),
    PASSWORD VARCHAR(20),
    DATEOFBIRTH DATE,
    USERNAME VARCHAR(30),
    TYPE VARCHAR(10)
);

INSERT INTO USER values (1, "Elie", "Bou Zeid", "Elie123","2004-03-22","eliebouzeidd@gmail.com","Admin");

CREATE TABLE record(
USERID INT,
    BOOKID INT,
    BORROWDATE DATE,
    RETURNDATE DATE,
);

CREATE TABLE `book` (
  `BookId` int(10) AUTO_INCREMENT,
  `Title` varchar(50) ,
  `Publisher` varchar(50) ,
  `Year` varchar(50) ,
  `Availability` int(5),
  PRIMARY KEY (`BookId`)
);

INSERT INTO `book` VALUES (1,'OS','PEARSON','2006',0),(2,'DBMS','TARGET67','2010',0),(3,'TOC','NITC','2018',4),(4,'TOC','NITC','2018',1),(5,'DAA','y','2014',0),(6,'DSA','X','2010',10),(7,'Discrete Structures','Pearson','2010',10),(8,'Database Processing','Prentice Hall','2013',12),(9,'Computer System Architecture','Prentice Hall','2015',4),(10,'C: How to program','Prentice Hall','2009',3),(11,'Atomic and Nuclear Systems','Pearson India ','2017',13),(12,'The PlayBook','Stinson','2010',12),(13,'General Theory of Relativity','Pearson India ','2012',5),(14,'Heat and Thermodynamics','Pearson','2013',9),(15,'Machine Design','Pearson India ','2012',5),(16,'Nuclear Physics','Pearson India ','1998',7),(17,'Operating System','Pearson India ','1990',7),(18,'Theory of Machines','Pearson','1992',12);
