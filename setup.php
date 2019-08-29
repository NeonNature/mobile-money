<?php
require ('connect.php');

//-------------CustomerType Table----------

$drct="DROP TABLE CustomerType";
$retct=mysql_query($drct, $connection);

$ct="CREATE TABLE CustomerType
(
	CustomerTypeID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
	CustomerTypeName varchar(30)
)";

$retct =mysql_query ($ct, $connection);



$q1="INSERT INTO CustomerType
		(CustomerTypeID, CustomerTypeName)
		VALUES
		(1,'Normal')";
$retct1=mysql_query($q1, $connection);

$q2="INSERT INTO CustomerType
		(CustomerTypeID, CustomerTypeName)
		VALUES
		(2,'Silver')";
$retct2=mysql_query($q2, $connection);

$q3="INSERT INTO CustomerType
		(CustomerTypeID, CustomerTypeName)
		VALUES
		(3,'Golden')";
$retct3=mysql_query($q3, $connection);

if ($retct && $retct2 && $retct3 )
{
	echo "<p> CustomerType Table Created!</p>";
}
else
{
	echo "<p> Something went wrong while creating CustomerType Table. Please retry later: ".mysql_error()." </p>";
}

//-------------PartnerType Table----------

$drpt="DROP TABLE PartnerType";
$retpt=mysql_query($drpt, $connection);

$pt="CREATE TABLE PartnerType
(
	PartnerTypeID int NOT NULL PRIMARY KEY,
	PartnerTypeName varchar(30)
)";

$retpt =mysql_query ($pt, $connection);



$q1="INSERT INTO PartnerType
		(PartnerTypeID, PartnerTypeName)
		VALUES
		(1,'Restaurant')";
$retpt1=mysql_query($q1, $connection);

$q2="INSERT INTO PartnerType
		(PartnerTypeID, PartnerTypeName)
		VALUES
		(2,'Hotel')";
$retpt2=mysql_query($q2, $connection);

$q3="INSERT INTO PartnerType
		(PartnerTypeID, PartnerTypeName)
		VALUES
		(3,'Supermarket')";
$retpt3=mysql_query($q3, $connection);

if ($retpt && $retpt2 && $retpt3 )
{
	echo "<p> CustomerType Table Created!</p>";
}
else
{
	echo "<p> Something went wrong while creating PartnerType Table. Please retry later: ".mysql_error()." </p>";
}



//-------------Admin Table----------

$dra="DROP TABLE Admin";
$reta=mysql_query($dra, $connection);

$a="CREATE TABLE Admin
(
	AdminID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
	Username varchar(30),
	Password varchar(30)
)";

$reta =mysql_query ($a, $connection);


$query="INSERT INTO Admin
		(AdminID, Username, Password)
		VALUES
		(1, 'NeonNature', 'neonnature2016' )";
$reta=mysql_query($query, $connection);

if ($reta)
{
	echo "<p> Admin Table Created!</p>";
}
else
{
	echo "<p> Something went wrong while creating Admin Table. Please retry later: ".mysql_error()." </p>";
}

//-------------Customer Table----------

$drc="DROP TABLE Customer";
$retc=mysql_query($drc, $connection);

$c="CREATE TABLE Customer
(
	CustomerID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
	CustomerName varchar(50),
	CustomerBalance int,
	PhoneNo varchar(10),
	Location varchar(255),
	Password varchar(30),
	Informed int,
	CustomerTypeID int NOT NULL,
	FOREIGN KEY (CustomerTypeID) references CustomerType(CustomerTypeID)
)";

$retc =mysql_query ($c, $connection);


$query="INSERT INTO Customer
		(CustomerID, CustomerName, CustomerBalance, PhoneNo, Location, Password, Informed, CustomerTypeID)
		VALUES
		(1,'Min Maung Maung', 0, '9440259616', 'Yangon, Myanmar', 'tomatoftw', 1, 2)";
$retc1=mysql_query($query, $connection);


$query="INSERT INTO Customer
		(CustomerID, CustomerName, CustomerBalance, PhoneNo, Location, Password, Informed, CustomerTypeID)
		VALUES
		(2,'Yamong Nadi Aung', 0, '9440259644', 'Yangon, Myanmar', 'piggyyamong', 1, 3)";
$retc2=mysql_query($query, $connection);

$query="INSERT INTO Customer
		(CustomerID, CustomerName, CustomerBalance, PhoneNo, Location, Password, Informed, CustomerTypeID)
		VALUES
		(3,'Mr. Potato', 0, '936250008', 'Yangon, Myanmar', 'potatoftw', 1, 1)";
$retc3=mysql_query($query, $connection);


if ($retc1 && $retc2 && $retc3)
{
	echo "<p> Customer Table Created!</p>";
}
else
{
	echo "<p> Something went wrong while creating Customer Table. Please retry later: ".mysql_error()." </p>";
}

//-------------Partner Table----------

$drp="DROP TABLE Partner";
$retp=mysql_query($drp, $connection);

$p="CREATE TABLE Partner
(
	PartnerID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
	PartnerName varchar(50),
	PartnerBalance int,
	PhoneNo varchar(10),
	Location varchar(255),
	Password varchar(30),
	PartnerTypeID int NOT NULL,
	FOREIGN KEY (PartnerTypeID) references PartnerType(PartnerTypeID)
)";

$retp =mysql_query ($p, $connection);


$q="INSERT INTO Partner
		(PartnerID, PartnerName, PartnerBalance, PhoneNo, Location, Password, PartnerTypeID)
		VALUES
		(1,'Lotteria', 100000, '9441111111', 'Yangon, Myanmar', 'eatourchickenpls', 1)";
$retp1=mysql_query($q, $connection);


$q2="INSERT INTO Partner
		(PartnerID, PartnerName, PartnerBalance, PhoneNo, Location, Password, PartnerTypeID)
		VALUES
		(2,'Sedona', 100000, '9442222222', 'Yangon, Myanmar', 'stayherepls', 2)";
$retp2=mysql_query($q2, $connection);

$q3="INSERT INTO Partner
		(PartnerID, PartnerName, PartnerBalance, PhoneNo, Location, Password, PartnerTypeID)
		VALUES
		(3,'City Mart', 100000, '9443333333', 'Yangon, Myanmar', 'buyatuspls', 3)";
$retp3=mysql_query($q3, $connection);


if ($retp1 && $retp2 && $retp3)
{
	echo "<p> Partner Table Created!</p>";
}
else
{
	echo "<p> Something went wrong while creating Partner Table. Please retry later: ".mysql_error()." </p>";
}


//-------------Agent Table----------

$dra="DROP TABLE Agent";
$reta=mysql_query($dra, $connection);

$a="CREATE TABLE Agent
(
	AgentID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
	AgentName varchar(50),
	AgentBalance int,
	PhoneNo varchar(10),
	Location varchar(255),
	Password varchar(30)
)";

$reta =mysql_query ($a, $connection);


$q1="INSERT INTO Agent
		(AgentID, AgentName, AgentBalance, PhoneNo, Location, Password)
		VALUES
		(1,'Naing Aung Win', 1000000, '9444444444', 'Yangon, Myanmar', 'dtshadow')";
$reta1=mysql_query($q1, $connection);


$q2="INSERT INTO Agent
		(AgentID, AgentName, AgentBalance, PhoneNo, Location, Password)
		VALUES
		(2,'Waing La Min Lwin', 1000000, '9445555555', 'Yangon, Myanmar', 'drarchon')";
$reta2=mysql_query($q2, $connection);

$q3="INSERT INTO Agent
		(AgentID, AgentName, AgentBalance, PhoneNo, Location, Password)
		VALUES
		(3,'Rubick', 1000000, '9446666666', 'Yangon, Myanmar', 'grandmagus')";
$reta3=mysql_query($q3, $connection);

if ($reta1 && $reta2 && $reta3)
{
	echo "<p> Agent Table Created!</p>";
}
else
{
	echo "<p> Something went wrong while creating Agent Table. Please retry later: ".mysql_error()." </p>";
}

//-------------SuperAgent Table----------

$drsa="DROP TABLE SuperAgent";
$retsa=mysql_query($drsa, $connection);

$sa="CREATE TABLE SuperAgent
(
	SuperAgentID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
	SuperAgentName varchar(50),
	SuperAgentBalance int,
	PhoneNo varchar(10),
	Location varchar(255),
	Password varchar(30)
)";

$retsa =mysql_query ($sa, $connection);


$q1="INSERT INTO SuperAgent
		(SuperAgentID, SuperAgentName, SuperAgentBalance, PhoneNo, Location, Password)
		VALUES
		(1,'Tony Stark', 100000000, '9447777777', 'Yangon, Myanmar', 'iamironman')";
$retsa1=mysql_query($q1, $connection);


$q2="INSERT INTO SuperAgent
		(SuperAgentID, SuperAgentName, SuperAgentBalance, PhoneNo, Location, Password)
		VALUES
		(2,'Bruce Wayne', 100000000, '94488888888', 'Yangon, Myanmar', 'iambatman')";
$retsa2=mysql_query($q2, $connection);

$q3="INSERT INTO SuperAgent
		(SuperAgentID, SuperAgentName, SuperAgentBalance, PhoneNo, Location, Password)
		VALUES
		(3,'Markus Persson', 100000000, '9449999999', 'Yangon, Myanmar', 'iamnotch')";
$retsa3=mysql_query($q3, $connection);

if ($retsa1 && $retsa2 && $retsa3)
{
	echo "<p> SuperAgent Table Created!</p>";
}
else
{
	echo "<p> Something went wrong while creating SuperAgent Table. Please retry later: ".mysql_error()." </p>";
}

//-------------CustomerTransaction Table----------

$drctr="DROP TABLE CustomerTransaction";
$retctr=mysql_query($drctr, $connection);

$ctr="CREATE TABLE CustomerTransaction
(
	CID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
	ReceiverID int NOT NULL,
	SenderID int NOT NULL ,
	Amount int,
	TransDate date,
	FOREIGN KEY (ReceiverID) references Customer(CustomerID),
	FOREIGN KEY (SenderID) references Customer(CustomerID)
)";

$retctr =mysql_query ($ctr, $connection);

if ($retctr)
{
	echo "<p> CustomerTransaction Table Created!</p>";
}
else
{
	echo "<p> Something went wrong while creating CustomerTransaction Table. Please retry later: ".mysql_error()." </p>";
}

//-------------AgentTransaction Table----------

$dratr="DROP TABLE AgentTransaction";
$retatr=mysql_query($dratr, $connection);

$atr="CREATE TABLE AgentTransaction
(
	AID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
	CustomerID int NOT NULL,
	AgentID int NOT NULL,
	Amount int,
	Upgrade boolean,
	TransDate date,
	FOREIGN KEY (CustomerID) references Customer(CustomerID),
	FOREIGN KEY (AgentID) references Agent(AgentID)
)";

$retatr =mysql_query ($atr, $connection);

if ($retctr)
{
	echo "<p> AgentTransaction Table Created!</p>";
}
else
{
	echo "<p> Something went wrong while creating AgentTransaction Table. Please retry later: ".mysql_error()." </p>";
}

//-------------SuperAgentTransaction Table----------

$drsatr="DROP TABLE SuperAgentTransaction";
$retsatr=mysql_query($drsatr, $connection);

$satr="CREATE TABLE SuperAgentTransaction
(
	SAID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
	AgentID int NOT NULL,
	SuperAgentID int NOT NULL,
	Amount int,
	TransDate date,
	FOREIGN KEY (AgentID) references Agent(AgentID),
	FOREIGN KEY (SuperAgentID) references SuperAgent(SuperAgentID)
)";

$retsatr =mysql_query ($satr, $connection);

if ($retctr)
{
	echo "<p> SuperAgentTransaction Table Created!</p>";
}
else
{
	echo "<p> Something went wrong while creating SuperAgentTransaction Table. Please retry later: ".mysql_error()." </p>";
}

//-------------PartnerTransaction Table----------

$drptr="DROP TABLE PartnerTransaction";
$retptr=mysql_query($drptr, $connection);

$ptr="CREATE TABLE PartnerTransaction
(
	PID int AUTO_INCREMENT NOT NULL PRIMARY KEY,
	CustomerID int NOT NULL,
	PartnerID int NOT NULL,
	Amount int,
	TransDate date,
	FOREIGN KEY (CustomerID) references Customer(CustomerID),
	FOREIGN KEY (PartnerID) references Partner(PartnerID)
)";

$retptr =mysql_query ($ptr, $connection);

if ($retptr)
{
	echo "<p> PartnerTransaction Table Created!</p>";
}
else
{
	echo "<p> Something went wrong while creating PartnerTransaction Table. Please retry later: ".mysql_error()." </p>";
}

//---------------MPT PhoneNo table-------------

$drmpt="DROP TABLE MPT";
$retmpt=mysql_query($drmpt, $connection);

$mpt="CREATE TABLE MPT
(
	PhoneNo varchar(10) NOT NULL PRIMARY KEY
)";

$retmpt =mysql_query ($mpt, $connection);

$m1="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('9440259616')";
$retm1=mysql_query($m1, $connection);

$m2="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('9440259644')";
$retm2=mysql_query($m2, $connection);

$m3="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('936250008')";
$retm3=mysql_query($m3, $connection);

$m4="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('9440259644')";
$retm4=mysql_query($m4, $connection);

$m5="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('9441111111')";
$retm5=mysql_query($m5, $connection);

$m6="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('9442222222')";
$retm6=mysql_query($m6, $connection);

$m7="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('9443333333')";
$retm7=mysql_query($m7, $connection);

$m8="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('9444444444')";
$retm8=mysql_query($m8, $connection);

$m9="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('9445555555')";
$retm9=mysql_query($m9, $connection);

$m10="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('9446666666')";
$retm10=mysql_query($m10, $connection);

$m11="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('9447777777')";
$retm11=mysql_query($m11, $connection);

$m12="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('94488888888')";
$retm12=mysql_query($m12, $connection);

$m13="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('9449999999')";
$retm13=mysql_query($m13, $connection);

$m0="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('9440000001')";
$retm0=mysql_query($m0, $connection);

$m00="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('9440000002')";
$retm00=mysql_query($m00, $connection);

$m000="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('9440000003')";
$retm000=mysql_query($m000, $connection);

$m0000="INSERT INTO MPT
		(PhoneNo)
		VALUES
		('9440000004')";
$retm0000=mysql_query($m0000, $connection);



if ($retmpt)
{
	echo "<p> MPT Table Created!</p>";
}
else
{
	echo "<p> Something went wrong while creating MPT Table. Please retry later: ".mysql_error()." </p>";
}