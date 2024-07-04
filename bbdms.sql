-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2024 at 09:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbdms`
--

-- --------------------------------------------------------

--
-- Table structure for table `bloodbank`
--

CREATE TABLE `bloodbank` (
  `Bank_ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Street` varchar(100) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bloodbank`
--

INSERT INTO `bloodbank` (`Bank_ID`, `Name`, `Street`, `City`) VALUES
(1, 'Quantum Blood Bank Lab', '31/V Shilpacharya Zainul Abedin Sarak', 'Shantinagar'),
(2, 'Bangladesh Red Crescent Blood Bank', '7/5 Aurangzeb Road', 'Mohammadpur'),
(3, 'Alif Blood Bank & Transfusion Center', '44/11, West Panthapath', 'West Panthapath'),
(4, 'Badhan Blood Bank', 'T.S.C(Ground Floor), University of Dhaka', 'University of Dhaka'),
(5, 'Thalassemia Blood Bank', '30 Chamelibag', 'Chamelibag'),
(6, 'Sandhani (Central)', 'Tinshed Outdoor building BSMMU', 'Shahabag'),
(7, 'Police Blood Bank', 'Central Police Hospital, Rajarbag', 'Rajarbag'),
(8, 'Oriental Blood bank', 'Green Center, 2B/30, Green Road', 'Dhanmondi'),
(9, 'Mukti Blood Bank & Pathology Lab', 'Bir-Uttam A.M. Shafiullah Road', 'Mohammadpur'),
(10, 'New Bangladesh Pathology & Blood Bank', 'Road 9/A', 'Dhanmondi');

-- --------------------------------------------------------

--
-- Table structure for table `bloodbanklocation`
--

CREATE TABLE `bloodbanklocation` (
  `City` varchar(50) NOT NULL,
  `Zip_Code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bloodbanklocation`
--

INSERT INTO `bloodbanklocation` (`City`, `Zip_Code`) VALUES
('Chamelibag', 'Dhaka 1217'),
('Dhanmondi', 'Dhaka 1209'),
('Mohammadpur', 'Dhaka 1207'),
('Rajarbag', 'Dhaka 1362'),
('Shahabag', 'Dhaka 1000'),
('Shantinagar', 'Dhaka 1217'),
('University of Dhaka', 'Dhaka 1000'),
('West Panthapath', 'Dhaka 1215');

-- --------------------------------------------------------

--
-- Table structure for table `bloodbankstock`
--

CREATE TABLE `bloodbankstock` (
  `Bank_ID` int(11) NOT NULL,
  `Blood_Group` varchar(5) NOT NULL,
  `Quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bloodbankstock`
--

INSERT INTO `bloodbankstock` (`Bank_ID`, `Blood_Group`, `Quantity`) VALUES
(1, 'A+', 84),
(1, 'A-', 79),
(1, 'AB+', 89),
(1, 'AB-', 80),
(1, 'B+', 85),
(1, 'B-', 89),
(1, 'O+', 90),
(1, 'O-', 51),
(2, 'A+', 94),
(2, 'A-', 57),
(2, 'AB+', 87),
(2, 'AB-', 87),
(2, 'B+', 54),
(2, 'B-', 50),
(2, 'O+', 53),
(2, 'O-', 70),
(3, 'A+', 82),
(3, 'A-', 73),
(3, 'AB+', 99),
(3, 'AB-', 85),
(3, 'B+', 68),
(3, 'B-', 70),
(3, 'O+', 50),
(3, 'O-', 96),
(4, 'A+', 67),
(4, 'A-', 82),
(4, 'AB+', 97),
(4, 'AB-', 68),
(4, 'B+', 60),
(4, 'B-', 55),
(4, 'O+', 85),
(4, 'O-', 84),
(5, 'A+', 95),
(5, 'A-', 86),
(5, 'AB+', 57),
(5, 'AB-', 79),
(5, 'B+', 95),
(5, 'B-', 68),
(5, 'O+', 62),
(5, 'O-', 96),
(6, 'A+', 97),
(6, 'A-', 76),
(6, 'AB+', 97),
(6, 'AB-', 66),
(6, 'B+', 90),
(6, 'B-', 74),
(6, 'O+', 79),
(6, 'O-', 87),
(7, 'A+', 80),
(7, 'A-', 81),
(7, 'AB+', 62),
(7, 'AB-', 53),
(7, 'B+', 62),
(7, 'B-', 70),
(7, 'O+', 52),
(7, 'O-', 57),
(8, 'A+', 61),
(8, 'A-', 96),
(8, 'AB+', 62),
(8, 'AB-', 59),
(8, 'B+', 98),
(8, 'B-', 51),
(8, 'O+', 75),
(8, 'O-', 87),
(9, 'A+', 64),
(9, 'A-', 99),
(9, 'AB+', 96),
(9, 'AB-', 68),
(9, 'B+', 53),
(9, 'B-', 71),
(9, 'O+', 73),
(9, 'O-', 57),
(10, 'A+', 82),
(10, 'A-', 93),
(10, 'AB+', 80),
(10, 'AB-', 99),
(10, 'B+', 69),
(10, 'B-', 67),
(10, 'O+', 60),
(10, 'O-', 72);

-- --------------------------------------------------------

--
-- Table structure for table `contactname`
--

CREATE TABLE `contactname` (
  `Contact_ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactname`
--

INSERT INTO `contactname` (`Contact_ID`, `Name`) VALUES
(1, 'Ayon');

-- --------------------------------------------------------

--
-- Table structure for table `donation_log_1`
--

CREATE TABLE `donation_log_1` (
  `User_ID` int(11) NOT NULL,
  `Last_Date_Of_Donation` date DEFAULT NULL,
  `Amount_Of_Blood_Donated` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation_log_1`
--

INSERT INTO `donation_log_1` (`User_ID`, `Last_Date_Of_Donation`, `Amount_Of_Blood_Donated`) VALUES
(2, '2024-04-08', 300.00),
(14, '2024-04-09', 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `donation_log_2`
--

CREATE TABLE `donation_log_2` (
  `User_ID` int(11) NOT NULL,
  `Donation_Frequency` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation_log_2`
--

INSERT INTO `donation_log_2` (`User_ID`, `Donation_Frequency`) VALUES
(2, 'Regular'),
(14, 'Regular');

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `User_ID` int(11) NOT NULL,
  `Gender` enum('Male','Female','Other') DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Occupation` varchar(100) DEFAULT NULL,
  `Street` varchar(100) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `Blood_Group` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`User_ID`, `Gender`, `Age`, `Occupation`, `Street`, `City`, `Blood_Group`) VALUES
(2, 'Male', 24, 'Faculty', 'Humayun road', 'Mohammadpur', 'O+'),
(14, 'Male', 38, 'Job', 'Road 13', 'Badda', 'AB-');

-- --------------------------------------------------------

--
-- Table structure for table `donorcity`
--

CREATE TABLE `donorcity` (
  `City` varchar(50) NOT NULL,
  `Zip_Code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donorcity`
--

INSERT INTO `donorcity` (`City`, `Zip_Code`) VALUES
('Badda', 'Dhaka 1212'),
('Dhanmondi', 'Dhaka 1209'),
('Mohammadpur', 'Dhaka 1207');

-- --------------------------------------------------------

--
-- Table structure for table `donorcontact`
--

CREATE TABLE `donorcontact` (
  `User_ID` int(11) NOT NULL,
  `Contact` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donorcontact`
--

INSERT INTO `donorcontact` (`User_ID`, `Contact`) VALUES
(2, '0176874563'),
(14, '01545654565');

-- --------------------------------------------------------

--
-- Table structure for table `emergencycontact`
--

CREATE TABLE `emergencycontact` (
  `User_ID` int(11) DEFAULT NULL,
  `Contact_ID` int(11) NOT NULL,
  `Relationship` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emergencycontact`
--

INSERT INTO `emergencycontact` (`User_ID`, `Contact_ID`, `Relationship`) VALUES
(4, 1, 'Brother');

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `Hospital_Id` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Street` varchar(100) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`Hospital_Id`, `Name`, `Street`, `City`) VALUES
(1, 'IBN Sina Specialized Hospital', '15A', 'Shankar'),
(2, 'Evercare Hospital Dhaka', 'Plot-81, Block-E, Bashundhara R/A', 'Bashundhara R/A'),
(3, 'United Hospital Limited', 'Plot-15, Road-71, Gulshan', 'Gulshan'),
(4, 'Square Hospitals Ltd.', '8/F, Bir Uttam, Qazi Nuruzzaman Sarak, Panthapath', 'Panthapath'),
(5, 'Labaid Specialized Hospital', 'Plot-06, Road-04, Dhanmondi', 'Dhanmondi'),
(6, 'BIRDEM General Hospital', 'Shahbagh Square, 122 Kazi Nazrul Avenue, Shahbagh', 'Shahbagh'),
(7, 'Anwar Khan Model Medical College', 'House-17, Rd No. 8, Dhanmondi', 'Dhanmondi'),
(8, 'Bangladesh Eye Hospital', '78 Satmasjid Road, Dhanmondi', 'Dhanmondi');

-- --------------------------------------------------------

--
-- Table structure for table `hospitalcontact`
--

CREATE TABLE `hospitalcontact` (
  `Hospital_Id` int(11) NOT NULL,
  `Contact_No` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospitalcontact`
--

INSERT INTO `hospitalcontact` (`Hospital_Id`, `Contact_No`) VALUES
(1, '09610009613'),
(1, '09610010615'),
(2, '(02)55037242'),
(2, '09666-710678'),
(2, '10678'),
(3, '+8801914001234'),
(3, '10666'),
(3, '9852466'),
(4, '(8802-)8144400'),
(4, '01713141447'),
(4, '10616'),
(4, '8142431'),
(5, '0173333337'),
(5, '01766661452'),
(5, '10606'),
(6, '01817145928'),
(6, '58610642'),
(6, '9665003'),
(7, '02-58616074'),
(8, '09666-787878');

-- --------------------------------------------------------

--
-- Table structure for table `hospitallocation`
--

CREATE TABLE `hospitallocation` (
  `City` varchar(50) NOT NULL,
  `Zip_Code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospitallocation`
--

INSERT INTO `hospitallocation` (`City`, `Zip_Code`) VALUES
('Bashundhara R/A', 'Dhaka 1229'),
('Dhanmondi', 'Dhaka 1205'),
('Gulshan', 'Dhaka 1212'),
('Mohammadpur', 'Dhaka 1207'),
('Panthapath', 'Dhaka 1205'),
('Shahbagh', 'Dhaka 1000'),
('Shankar', 'Dhaka 1209');

-- --------------------------------------------------------

--
-- Table structure for table `hospitalstaff`
--

CREATE TABLE `hospitalstaff` (
  `User_ID` int(11) NOT NULL,
  `Position` varchar(100) DEFAULT NULL,
  `Hospital_Id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospitalstaff`
--

INSERT INTO `hospitalstaff` (`User_ID`, `Position`, `Hospital_Id`) VALUES
(3, 'Doctor', 1),
(15, 'Doctor', 2);

-- --------------------------------------------------------

--
-- Table structure for table `issue`
--

CREATE TABLE `issue` (
  `User_ID` int(11) NOT NULL,
  `Issues` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issue`
--

INSERT INTO `issue` (`User_ID`, `Issues`) VALUES
(4, 'Heart attack'),
(4, 'High blood pressure');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `LogID` int(11) NOT NULL,
  `Username` varchar(50) DEFAULT NULL,
  `Password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`LogID`, `Username`, `Password`) VALUES
(1, 'admin', '05cd8186692a88ffe129bc8bea8163fe'),
(2, 'Donor', '2353bdbce24c9f7a37779614716908b2'),
(3, 'doctor', '2353bdbce24c9f7a37779614716908b2'),
(4, 'patient', '9e4cc8c91f3a229602587798040d3466'),
(10, 'Munt', '5240a68d0b7f58ee15a408f7773e9a08'),
(15, 'akid', '09bf205eff01cda7688b7e6c4c301c57'),
(16, 'Ad', '09bf205eff01cda7688b7e6c4c301c57'),
(17, 'rash', '02c951b2444b43f3e086582be6a01c87');

-- --------------------------------------------------------

--
-- Table structure for table `orderfrom`
--

CREATE TABLE `orderfrom` (
  `Hospital_Id` int(11) NOT NULL,
  `Bank_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `User_ID` int(11) NOT NULL,
  `Age` int(11) DEFAULT NULL,
  `Hospital_Id` int(11) DEFAULT NULL,
  `Blood_Group` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`User_ID`, `Age`, `Hospital_Id`, `Blood_Group`) VALUES
(4, 25, 1, 'A+');

-- --------------------------------------------------------

--
-- Table structure for table `patientcontact`
--

CREATE TABLE `patientcontact` (
  `User_ID` int(11) NOT NULL,
  `Contact` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patientcontact`
--

INSERT INTO `patientcontact` (`User_ID`, `Contact`) VALUES
(4, '01354584567');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `Transaction_ID` int(11) NOT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `PuserID` int(11) DEFAULT NULL,
  `DuserID` int(11) DEFAULT NULL,
  `Cost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`Transaction_ID`, `Amount`, `Status`, `PuserID`, `DuserID`, `Cost`) VALUES
(8, 100.00, 'Paid', 4, 2, 100);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `Per_Id` int(11) NOT NULL,
  `Per_Name` varchar(50) DEFAULT NULL,
  `Per_Module` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`Per_Id`, `Per_Name`, `Per_Module`) VALUES
(1, 'Admin', 'Admin panel'),
(2, 'Hospital Staff', 'Hospital Panel'),
(3, 'Donor', 'Donor panel'),
(4, 'Patient', 'Patient Panel');

-- --------------------------------------------------------

--
-- Table structure for table `preference`
--

CREATE TABLE `preference` (
  `User_ID` int(11) NOT NULL,
  `Preferred_Donation_Center` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preference`
--

INSERT INTO `preference` (`User_ID`, `Preferred_Donation_Center`) VALUES
(2, 'Dhanmondi'),
(2, 'Mohammadpur'),
(14, 'Badda');

-- --------------------------------------------------------

--
-- Table structure for table `remark`
--

CREATE TABLE `remark` (
  `User_ID` int(11) NOT NULL,
  `Remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `remark`
--

INSERT INTO `remark` (`User_ID`, `Remarks`) VALUES
(2, 'No adverse reactions observed'),
(14, 'Nothing');

-- --------------------------------------------------------

--
-- Table structure for table `secondlookingfor`
--

CREATE TABLE `secondlookingfor` (
  `User_ID` int(11) NOT NULL,
  `Time_Of_Need` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `secondlookingfor`
--

INSERT INTO `secondlookingfor` (`User_ID`, `Time_Of_Need`) VALUES
(4, '2024-04-19 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `hospital_id` int(11) NOT NULL,
  `blood_type` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`hospital_id`, `blood_type`, `quantity`) VALUES
(1, 'A+', 29),
(1, 'A-', 22),
(1, 'AB+', 9),
(1, 'AB-', 5),
(1, 'B+', 25),
(1, 'B-', 20),
(1, 'O+', 15),
(1, 'O-', 12),
(2, 'A+', 17),
(2, 'A-', 16),
(2, 'AB+', 11),
(2, 'AB-', 7),
(2, 'B+', 3),
(2, 'B-', 7),
(2, 'O+', 2),
(2, 'O-', 17),
(3, 'A+', 12),
(3, 'A-', 10),
(3, 'AB+', 9),
(3, 'AB-', 3),
(3, 'B+', 10),
(3, 'B-', 19),
(3, 'O+', 9),
(3, 'O-', 6),
(4, 'A+', 8),
(4, 'A-', 2),
(4, 'AB+', 12),
(4, 'AB-', 3),
(4, 'B+', 5),
(4, 'B-', 6),
(4, 'O+', 9),
(4, 'O-', 6),
(5, 'A+', 12),
(5, 'A-', 6),
(5, 'AB+', 11),
(5, 'AB-', 17),
(5, 'B+', 3),
(5, 'B-', 16),
(5, 'O+', 14),
(5, 'O-', 19),
(6, 'A+', 4),
(6, 'A-', 18),
(6, 'AB+', 13),
(6, 'AB-', 3),
(6, 'B+', 12),
(6, 'B-', 14),
(6, 'O+', 1),
(6, 'O-', 11),
(7, 'A+', 8),
(7, 'A-', 3),
(7, 'AB+', 4),
(7, 'AB-', 2),
(7, 'B+', 7),
(7, 'B-', 18),
(7, 'O+', 20),
(7, 'O-', 5),
(8, 'A+', 3),
(8, 'A-', 16),
(8, 'AB+', 4),
(8, 'AB-', 18),
(8, 'B+', 2),
(8, 'B-', 3),
(8, 'O+', 18),
(8, 'O-', 9);

-- --------------------------------------------------------

--
-- Table structure for table `tblcontactusquery`
--

CREATE TABLE `tblcontactusquery` (
  `Query_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Message` varchar(500) DEFAULT NULL,
  `Status` tinyint(1) DEFAULT 0,
  `PostingDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcontactusquery`
--

INSERT INTO `tblcontactusquery` (`Query_ID`, `User_ID`, `Message`, `Status`, `PostingDate`) VALUES
(4, 2, 'Hello', 1, '2024-04-19 15:22:56');

-- --------------------------------------------------------

--
-- Table structure for table `teammembers`
--

CREATE TABLE `teammembers` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `ShortMessage` varchar(500) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teammembers`
--

INSERT INTO `teammembers` (`ID`, `Name`, `ShortMessage`, `Image`) VALUES
(8, 'Md Sayem Mottakee', 'Mottakee is a valuable member of our team, bringing expertise in Java and frontend technology as a final year Software Engineering student at Mehran University. With a passion for staying current and continuously learning, Saad is always seeking out new opportunities to expand his knowledge and skills.', 'images/Admin1.jpg'),
(9, 'Mohammad Ariful Islam', 'Arif is a valuable team member with expertise in frontend, ReactJS, and WordPress. His dedication to growth and continuous learning make him a valuable asset to any software development project. With a strong foundation in these areas, Noor Ahmed is well-equipped to make valuable contributions to the team', 'images/Admin2.jpg'),
(10, 'Rafid Nahian', 'Rafid is a valuable team member with expertise in Python and frontend technology. His dedication to growth and continuous learning makes him a valuable asset to any software development project. With a strong foundation in these areas and a passion for staying current, Ritik is well-equipped to make valuable contributions to the team.', 'images/Admin4.jpg'),
(11, 'Ayesha Fariha', 'Meet Ayesha, an invaluable asset to our team. Currently in her final year pursuing a degree in Software Engineering at Mehran University, she brings a wealth of expertise in Java and frontend technology. Sarah\'s relentless passion for staying at the forefront of industry trends is evident in her continuous pursuit of knowledge and skill enhancement. Always on the lookout for opportunities to broaden her horizons, Sarah embodies the spirit of perpetual learning and growth that drives our team for', 'images/Admin3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Role` enum('Admin','Donor','Hospital Staff','Receiver') DEFAULT NULL,
  `LogID` int(11) DEFAULT NULL,
  `Per_Id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `Name`, `Role`, `LogID`, `Per_Id`) VALUES
(1, 'Admin', 'Admin', 1, 1),
(2, 'Adnan Parvez', 'Donor', 2, 3),
(3, 'Mahdi Hossain', 'Hospital Staff', 3, 2),
(4, 'Faiaj Fahim', 'Receiver', 4, 4),
(13, 'Akid', 'Donor', 15, 3),
(14, 'Akid', 'Donor', 16, 3),
(15, 'Dr. Rashed', 'Hospital Staff', 17, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bloodbank`
--
ALTER TABLE `bloodbank`
  ADD PRIMARY KEY (`Bank_ID`),
  ADD KEY `fk_bloodbank_location_city` (`City`);

--
-- Indexes for table `bloodbanklocation`
--
ALTER TABLE `bloodbanklocation`
  ADD PRIMARY KEY (`City`,`Zip_Code`);

--
-- Indexes for table `bloodbankstock`
--
ALTER TABLE `bloodbankstock`
  ADD PRIMARY KEY (`Bank_ID`,`Blood_Group`);

--
-- Indexes for table `contactname`
--
ALTER TABLE `contactname`
  ADD PRIMARY KEY (`Contact_ID`);

--
-- Indexes for table `donation_log_1`
--
ALTER TABLE `donation_log_1`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `donation_log_2`
--
ALTER TABLE `donation_log_2`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`User_ID`),
  ADD KEY `City` (`City`);

--
-- Indexes for table `donorcity`
--
ALTER TABLE `donorcity`
  ADD PRIMARY KEY (`City`,`Zip_Code`);

--
-- Indexes for table `donorcontact`
--
ALTER TABLE `donorcontact`
  ADD PRIMARY KEY (`User_ID`,`Contact`);

--
-- Indexes for table `emergencycontact`
--
ALTER TABLE `emergencycontact`
  ADD PRIMARY KEY (`Contact_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`Hospital_Id`),
  ADD KEY `fk_hospital_location_city` (`City`);

--
-- Indexes for table `hospitalcontact`
--
ALTER TABLE `hospitalcontact`
  ADD PRIMARY KEY (`Hospital_Id`,`Contact_No`);

--
-- Indexes for table `hospitallocation`
--
ALTER TABLE `hospitallocation`
  ADD PRIMARY KEY (`City`,`Zip_Code`);

--
-- Indexes for table `hospitalstaff`
--
ALTER TABLE `hospitalstaff`
  ADD PRIMARY KEY (`User_ID`),
  ADD KEY `Hospital_Id` (`Hospital_Id`);

--
-- Indexes for table `issue`
--
ALTER TABLE `issue`
  ADD PRIMARY KEY (`User_ID`,`Issues`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`LogID`);

--
-- Indexes for table `orderfrom`
--
ALTER TABLE `orderfrom`
  ADD PRIMARY KEY (`Hospital_Id`,`Bank_ID`),
  ADD KEY `Bank_ID` (`Bank_ID`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`User_ID`),
  ADD KEY `Hospital_Id` (`Hospital_Id`);

--
-- Indexes for table `patientcontact`
--
ALTER TABLE `patientcontact`
  ADD PRIMARY KEY (`User_ID`,`Contact`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`Transaction_ID`),
  ADD KEY `fk_payment_puser` (`PuserID`),
  ADD KEY `fk_payment_duser` (`DuserID`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`Per_Id`);

--
-- Indexes for table `preference`
--
ALTER TABLE `preference`
  ADD PRIMARY KEY (`User_ID`,`Preferred_Donation_Center`);

--
-- Indexes for table `remark`
--
ALTER TABLE `remark`
  ADD PRIMARY KEY (`User_ID`,`Remarks`);

--
-- Indexes for table `secondlookingfor`
--
ALTER TABLE `secondlookingfor`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`hospital_id`,`blood_type`);

--
-- Indexes for table `tblcontactusquery`
--
ALTER TABLE `tblcontactusquery`
  ADD PRIMARY KEY (`Query_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `teammembers`
--
ALTER TABLE `teammembers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`),
  ADD KEY `LogID` (`LogID`),
  ADD KEY `Per_Id` (`Per_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bloodbank`
--
ALTER TABLE `bloodbank`
  MODIFY `Bank_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `emergencycontact`
--
ALTER TABLE `emergencycontact`
  MODIFY `Contact_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `Hospital_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `Transaction_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `Per_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblcontactusquery`
--
ALTER TABLE `tblcontactusquery`
  MODIFY `Query_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teammembers`
--
ALTER TABLE `teammembers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bloodbank`
--
ALTER TABLE `bloodbank`
  ADD CONSTRAINT `fk_bloodbank_location_city` FOREIGN KEY (`City`) REFERENCES `bloodbanklocation` (`City`);

--
-- Constraints for table `bloodbankstock`
--
ALTER TABLE `bloodbankstock`
  ADD CONSTRAINT `bloodbankstock_ibfk_1` FOREIGN KEY (`Bank_ID`) REFERENCES `bloodbank` (`Bank_ID`);

--
-- Constraints for table `contactname`
--
ALTER TABLE `contactname`
  ADD CONSTRAINT `fk_EmergencyContact_ContactName` FOREIGN KEY (`Contact_ID`) REFERENCES `emergencycontact` (`Contact_ID`);

--
-- Constraints for table `donation_log_1`
--
ALTER TABLE `donation_log_1`
  ADD CONSTRAINT `donation_log_1_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `donor` (`User_ID`);

--
-- Constraints for table `donation_log_2`
--
ALTER TABLE `donation_log_2`
  ADD CONSTRAINT `donation_log_2_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `donor` (`User_ID`);

--
-- Constraints for table `donor`
--
ALTER TABLE `donor`
  ADD CONSTRAINT `donor_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`),
  ADD CONSTRAINT `donor_ibfk_2` FOREIGN KEY (`City`) REFERENCES `donorcity` (`City`);

--
-- Constraints for table `donorcontact`
--
ALTER TABLE `donorcontact`
  ADD CONSTRAINT `donorcontact_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `donor` (`User_ID`);

--
-- Constraints for table `emergencycontact`
--
ALTER TABLE `emergencycontact`
  ADD CONSTRAINT `emergencycontact_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `patient` (`User_ID`);

--
-- Constraints for table `hospital`
--
ALTER TABLE `hospital`
  ADD CONSTRAINT `fk_hospital_location_city` FOREIGN KEY (`City`) REFERENCES `hospitallocation` (`City`);

--
-- Constraints for table `hospitalcontact`
--
ALTER TABLE `hospitalcontact`
  ADD CONSTRAINT `hospitalcontact_ibfk_1` FOREIGN KEY (`Hospital_Id`) REFERENCES `hospital` (`Hospital_Id`);

--
-- Constraints for table `hospitalstaff`
--
ALTER TABLE `hospitalstaff`
  ADD CONSTRAINT `hospitalstaff_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`),
  ADD CONSTRAINT `hospitalstaff_ibfk_2` FOREIGN KEY (`Hospital_Id`) REFERENCES `hospital` (`Hospital_Id`);

--
-- Constraints for table `issue`
--
ALTER TABLE `issue`
  ADD CONSTRAINT `issue_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `patient` (`User_ID`);

--
-- Constraints for table `orderfrom`
--
ALTER TABLE `orderfrom`
  ADD CONSTRAINT `orderfrom_ibfk_1` FOREIGN KEY (`Hospital_Id`) REFERENCES `hospital` (`Hospital_Id`),
  ADD CONSTRAINT `orderfrom_ibfk_2` FOREIGN KEY (`Bank_ID`) REFERENCES `bloodbank` (`Bank_ID`);

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`),
  ADD CONSTRAINT `patient_ibfk_2` FOREIGN KEY (`Hospital_Id`) REFERENCES `hospital` (`Hospital_Id`);

--
-- Constraints for table `patientcontact`
--
ALTER TABLE `patientcontact`
  ADD CONSTRAINT `patientcontact_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `patient` (`User_ID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_duser` FOREIGN KEY (`DuserID`) REFERENCES `donor` (`User_ID`),
  ADD CONSTRAINT `fk_payment_puser` FOREIGN KEY (`PuserID`) REFERENCES `patient` (`User_ID`);

--
-- Constraints for table `preference`
--
ALTER TABLE `preference`
  ADD CONSTRAINT `preference_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `donor` (`User_ID`);

--
-- Constraints for table `remark`
--
ALTER TABLE `remark`
  ADD CONSTRAINT `remark_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `donor` (`User_ID`);

--
-- Constraints for table `secondlookingfor`
--
ALTER TABLE `secondlookingfor`
  ADD CONSTRAINT `secondlookingfor_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `patient` (`User_ID`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`hospital_id`) REFERENCES `hospital` (`Hospital_Id`);

--
-- Constraints for table `tblcontactusquery`
--
ALTER TABLE `tblcontactusquery`
  ADD CONSTRAINT `tblcontactusquery_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`LogID`) REFERENCES `login` (`LogID`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`Per_Id`) REFERENCES `permission` (`Per_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
