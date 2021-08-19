-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2020 at 06:22 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dynamic_dbs_anal_03_nov_11_apple`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_elements`
--

CREATE TABLE `access_elements` (
  `elm_id` int(11) NOT NULL,
  `elm_name` varchar(150) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `agr_tcodes`
--

CREATE TABLE `agr_tcodes` (
  `AGR_NAME` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conflicts_c_o`
--

CREATE TABLE `conflicts_c_o` (
  `CONFLICTID` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `OBJCT` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `FIELD` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `VALUE` varchar(45) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conflicts_c_orig`
--

CREATE TABLE `conflicts_c_orig` (
  `CONFLICTID` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `OBJCT` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `FIELD` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `VALUE` varchar(45) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `graphinfo`
--

CREATE TABLE `graphinfo` (
  `repid` int(10) NOT NULL DEFAULT 0,
  `id` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
  `proc` varchar(50) CHARACTER SET utf8 NOT NULL,
  `users` int(10) DEFAULT NULL,
  `risks` int(10) DEFAULT NULL,
  `conflicts` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inigraph`
--

CREATE TABLE `inigraph` (
  `repid` int(1) NOT NULL DEFAULT 0,
  `id` varchar(3) DEFAULT NULL,
  `proc` varchar(50) NOT NULL,
  `High` int(10) DEFAULT NULL,
  `Medium` int(10) DEFAULT NULL,
  `Low` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mit_uconflicts_c`
--

CREATE TABLE `mit_uconflicts_c` (
  `UNAME` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `CONFLICTID` varchar(12) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mit_uconflicts_r`
--

CREATE TABLE `mit_uconflicts_r` (
  `UNAME` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `CONFLICTID` varchar(12) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `msg_qmanage`
--

CREATE TABLE `msg_qmanage` (
  `rating` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `message` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `color` varchar(10) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pclients`
--

CREATE TABLE `pclients` (
  `partner_user_id` int(5) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `report_license`
--

CREATE TABLE `report_license` (
  `license_id` int(4) NOT NULL,
  `license_date` datetime DEFAULT NULL,
  `partner_id` int(4) DEFAULT NULL,
  `client_id` int(10) DEFAULT NULL,
  `db_id` int(2) DEFAULT NULL,
  `report_type_id` int(10) DEFAULT NULL,
  `assign_date` datetime DEFAULT NULL,
  `upload_file` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `upload_status` int(1) DEFAULT NULL,
  `upload_message` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `upload_date` datetime DEFAULT NULL,
  `my_db_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `database_server` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `database_user` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `database_password` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `flag` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `recreate_rules` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `is_archive` char(1) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rep_org_access`
--

CREATE TABLE `rep_org_access` (
  `User_ID` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `User_Name` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `TCode` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `Company_Code` text CHARACTER SET utf8 DEFAULT NULL,
  `Business_Area` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Controlling_Area` text CHARACTER SET utf8 DEFAULT NULL,
  `Plant` text CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rep_tcode_level_sod_with_role`
--

CREATE TABLE `rep_tcode_level_sod_with_role` (
  `USERID` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `USER_NAME` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `department` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `COMPANY` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `CONFLICT_ID` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `RISK_DESCRIPTION` text CHARACTER SET utf8 DEFAULT NULL,
  `RISK_RATING` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
  `TCODE1` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `ROLE1` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `TCODE2` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `ROLE2` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `TCODE3` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `ROLE3` varchar(50) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `role_build`
--

CREATE TABLE `role_build` (
  `AGR_NAME` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `OBJCT` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `AUTH` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `FIELD` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `FROM` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `TO` varchar(45) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `role_build_org`
--

CREATE TABLE `role_build_org` (
  `agr_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `objct` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `field` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `from` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `to` varchar(45) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `root_cause_analysis`
--

CREATE TABLE `root_cause_analysis` (
  `UNAME` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `TCODE` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `AGR_NAME` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `OBJCT` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `AUTH` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `FIELD` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `FROM` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `TO` varchar(45) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `root_cause_org_role`
--

CREATE TABLE `root_cause_org_role` (
  `AGR_NAME` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `TCODE` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `OBJCT` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `FIELD` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `FROM` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `TO` varchar(45) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `root_cause_tcdsrc`
--

CREATE TABLE `root_cause_tcdsrc` (
  `uname` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `TCode` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `agr_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sapcon`
--

CREATE TABLE `sapcon` (
  `con_id` int(11) NOT NULL,
  `con_name` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `server_id` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `system_no` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `system_id` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `sap_client` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `sap_userid` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `sap_password` varchar(500) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sap_report`
--

CREATE TABLE `sap_report` (
  `Id` int(11) DEFAULT NULL,
  `dashboard` int(11) DEFAULT NULL,
  `report_type_id` int(11) DEFAULT NULL,
  `column_name` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `column_value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scheduler_settings`
--

CREATE TABLE `scheduler_settings` (
  `scheduler_id` int(11) NOT NULL,
  `scheduler_name` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `schedule_type` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `repeat_type` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `scheduled_date` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `scheduled_time` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `sap_con_id` int(5) DEFAULT NULL,
  `app_id` int(4) DEFAULT NULL,
  `ana_id` int(4) DEFAULT NULL,
  `client_id` int(5) DEFAULT NULL,
  `custom_tcode` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `expired_role` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `locked_user` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `expired_user` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `org_elm` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `non_dialog_user` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `skip_root_cause` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `status` char(1) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `security_permission`
--

CREATE TABLE `security_permission` (
  `group_id` int(10) DEFAULT NULL,
  `elm_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sys_log`
--

CREATE TABLE `sys_log` (
  `logid` int(10) NOT NULL,
  `logtime` datetime DEFAULT NULL,
  `username` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `dbname` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `logmsg` varchar(2000) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tab_user`
--

CREATE TABLE `tab_user` (
  `uname` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tab_user`
--

CREATE TABLE `tab_user_bkp` (
  `uname` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------


--
-- Table structure for table `tmp_field`
--

CREATE TABLE `tmp_field` (
  `TCODE` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `OBJCT` varchar(10) CHARACTER SET utf8 NOT NULL,
  `FIELD` varchar(10) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `top_risks`
--

CREATE TABLE `top_risks` (
  `repid` int(1) NOT NULL,
  `RiskID` varchar(6) DEFAULT NULL,
  `Description` varchar(1000) DEFAULT NULL,
  `Risk_Rating` varchar(6) DEFAULT NULL,
  `No_of_Conflicts` bigint(21) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `top_tcodes`
--

CREATE TABLE `top_tcodes` (
  `repid` int(1) NOT NULL,
  `TCode` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `Description` varchar(75) CHARACTER SET utf8 DEFAULT NULL,
  `No_of_Conflicts` bigint(21) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `top_user_roles`
--

CREATE TABLE `top_user_roles` (
  `repid` int(1) NOT NULL,
  `id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `cnt` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `uconflicts_col`
--

CREATE TABLE `uconflicts_col` (
  `UNAME` varchar(12) CHARACTER SET utf8 NOT NULL,
  `CONFLICTID` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `TCODE1` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `TCODE2` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `TCODE3` varchar(45) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `uerror`
--

CREATE TABLE `uerror` (
  `license_id` int(11) DEFAULT NULL,
  `error_msg` longtext CHARACTER SET utf8 DEFAULT NULL,
  `flag` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `sts` char(2) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2020 at 08:32 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db2_master_2nov`
--

-- --------------------------------------------------------

--
-- Table structure for table `qm_requests`
--

CREATE TABLE `qm_requests` (
  `request_id` int(10) UNSIGNED NOT NULL,
  `request_type` varchar(4) NOT NULL,
  `uname` varchar(1500) DEFAULT NULL,
  `agr_name` varchar(1500) DEFAULT NULL,
  `tcodes` varchar(1500) DEFAULT NULL,
  `objvals` varchar(1500) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `request_date` datetime DEFAULT NULL,
  `ac_type` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `qm_requests`
--
ALTER TABLE `qm_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `qm_requests`
--
ALTER TABLE `qm_requests`
  MODIFY `request_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;


--
-- Table structure for table `import_data_verification`
--

CREATE TABLE `import_data_verification` (
  `id` int(11) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `total_imported_lines` int(11) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_line_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `import_data_verification`
--

ALTER TABLE `import_data_verification`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `import_data_verification`
--
ALTER TABLE `import_data_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;


--
-- Table structure for table `procedure_message`
--

CREATE TABLE `procedure_message` (
  `id` int(11) NOT NULL,
  `procedure_name` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `create_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `procedure_message`
--
ALTER TABLE `procedure_message`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `procedure_message`
--
ALTER TABLE `procedure_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;









/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
