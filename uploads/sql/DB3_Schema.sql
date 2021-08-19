-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2020 at 07:06 AM
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
-- Database: `test_sap4`
--

-- --------------------------------------------------------

--
-- Table structure for table `actcode`
--

CREATE TABLE `actcode` (
  `activity` varchar(5) DEFAULT NULL,
  `tcode` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `act_class`
--

CREATE TABLE `act_class` (
  `activity` varchar(5) NOT NULL,
  `act_desc` varchar(50) DEFAULT NULL,
  `act_class` varchar(45) DEFAULT NULL,
  `proc` varchar(25) DEFAULT NULL,
  `subproc` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `act_class_desc`
--

CREATE TABLE `act_class_desc` (
  `act_num` int(11) DEFAULT NULL,
  `act_desc` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `act_val`
--

CREATE TABLE `act_val` (
  `val` varchar(2) DEFAULT NULL,
  `dsc` varchar(30) DEFAULT NULL,
  `excl` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `adrp`
--

CREATE TABLE `adrp` (
  `PERSNUMBER` varchar(10) NOT NULL,
  `NAME_TEXT` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `agr_1016`
--

CREATE TABLE `agr_1016` (
  `AGR_NAME` varchar(50) DEFAULT NULL,
  -- `COUNTER` varchar(6) DEFAULT NULL,
  `COUNTER` bigint(21) DEFAULT NULL,
  `PROFILE` varchar(12) DEFAULT NULL,
  `VARIANT` varchar(4) DEFAULT NULL,
  `GENERATED` varchar(1) DEFAULT NULL,
  `PSTATE` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `agr_1251`
--

CREATE TABLE `agr_1251` (
  `AGR_NAME` varchar(30) DEFAULT NULL,
  `COUNTER` varchar(6) DEFAULT NULL,
  `OBJECT` varchar(10) DEFAULT NULL,
  `AUTH` varchar(12) DEFAULT NULL,
  `VARIANT` varchar(4) DEFAULT NULL,
  `FIELD` varchar(10) DEFAULT NULL,
  `LOW` varchar(40) DEFAULT NULL,
  `HIGH` varchar(40) DEFAULT NULL,
  `MODIFIED` varchar(1) DEFAULT NULL,
  `DELETED` varchar(1) DEFAULT NULL,
  `COPIED` varchar(1) DEFAULT NULL,
  `NEU` varchar(1) DEFAULT NULL,
  `NODE` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `agr_1252`
--

CREATE TABLE `agr_1252` (
  `AGR_NAME` varchar(30) DEFAULT NULL,
  `COUNTER` varchar(6) DEFAULT NULL,
  `VARBL` varchar(40) DEFAULT NULL,
  `LOW` varchar(40) DEFAULT NULL,
  `HIGH` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `agr_agrs`
--

CREATE TABLE `agr_agrs` (
  `AGR_NAME` varchar(30) DEFAULT NULL,
  `CHILD_AGR` varchar(30) DEFAULT NULL,
  `ATTRIBUTES` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `agr_define`
--

CREATE TABLE `agr_define` (
  `AGR_NAME` varchar(30) DEFAULT NULL,
  `PARENT_AGR` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `agr_texts`
--

CREATE TABLE `agr_texts` (
  `AGR_NAME` varchar(30) DEFAULT NULL,
  `TEXTS` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `agr_users`
--

CREATE TABLE `agr_users` (
  `AGR_NAME` varchar(30) NOT NULL,
  `UNAME` varchar(12) NOT NULL,
  `FROM_DAT` varchar(12) NOT NULL,
  `TO_DAT` varchar(12) NOT NULL,
  `EXCLUDE` varchar(1) NOT NULL,
  `ORG_FLAG` varchar(1) NOT NULL,
  `COL_FLAG` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bus_proc`
--

CREATE TABLE `bus_proc` (
  `proc` varchar(3) NOT NULL DEFAULT '',
  `dsc` varchar(45) DEFAULT NULL,
  `Status` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bus_subproc`
--

CREATE TABLE `bus_subproc` (
  `proc` varchar(3) NOT NULL,
  `subproc` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cepct`
--

CREATE TABLE `cepct` (
  `PRCTR` varchar(10) DEFAULT NULL,
  `DATBI` varchar(12) DEFAULT NULL,
  `KOKRS` varchar(4) DEFAULT NULL,
  `LTEXT` varchar(40) DEFAULT NULL,
  `MCTXT` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conflicts`
--

CREATE TABLE `conflicts` (
  `CONFLICTID` varchar(12) DEFAULT NULL,
  `OBJCT` varchar(45) DEFAULT NULL,
  `FIELD` varchar(45) DEFAULT NULL,
  `VALUE` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conflicts_add_checks`
--

CREATE TABLE `conflicts_add_checks` (
  `TCODE` varchar(45) DEFAULT NULL,
  `OBJCT` varchar(10) DEFAULT NULL,
  `FIELD` varchar(10) DEFAULT NULL,
  `VALUE` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conflicts_c`
--

CREATE TABLE `conflicts_c` (
  `CONFLICTID` varchar(12) DEFAULT NULL,
  `OBJCT` varchar(45) DEFAULT NULL,
  `FIELD` varchar(45) DEFAULT NULL,
  `VALUE` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conflicts_exceptions`
--

CREATE TABLE `conflicts_exceptions` (
  `TCODE` varchar(45) DEFAULT NULL,
  `OBJCT` varchar(10) DEFAULT NULL,
  `FIELD` varchar(10) DEFAULT NULL,
  `VALUE` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conflicts_exceptions_role`
--

CREATE TABLE `conflicts_exceptions_role` (
  `uname` varchar(12) DEFAULT NULL,
  `agr_name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conflicts_first_cnt`
--

CREATE TABLE `conflicts_first_cnt` (
  `conflictid` varchar(12) DEFAULT NULL,
  `count` bigint(21) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conflicts_org_cnt`
--

CREATE TABLE `conflicts_org_cnt` (
  `tcode` varchar(30) NOT NULL DEFAULT '',
  `count(distinct field)` bigint(21) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conflicts_values_a`
--

CREATE TABLE `conflicts_values_a` (
  `tcode` varchar(20) NOT NULL,
  `objct` varchar(10) NOT NULL,
  `field` varchar(10) NOT NULL,
  `value` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conflicts_values_bl`
--

CREATE TABLE `conflicts_values_bl` (
  `tcode` varchar(20) NOT NULL,
  `objct` varchar(10) NOT NULL,
  `field` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conflicts_values_flbl`
--

CREATE TABLE `conflicts_values_flbl` (
  `tcode` varchar(20) NOT NULL,
  `objct` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conflicts_values_notcd`
--

CREATE TABLE `conflicts_values_notcd` (
  `tcode` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `conflicts_values_org`
--

CREATE TABLE `conflicts_values_org` (
  `tcode` varchar(30) NOT NULL DEFAULT '',
  `objct` varchar(10) NOT NULL DEFAULT '',
  `field` varchar(10) NOT NULL DEFAULT '',
  `org` varchar(40) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `critical_auth`
--

CREATE TABLE `critical_auth` (
  `proc` varchar(3) NOT NULL DEFAULT '',
  `tcode` varchar(50) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `crtx`
--

CREATE TABLE `crtx` (
  `OBJTY` varchar(2) DEFAULT NULL,
  `OBJID` varchar(8) DEFAULT NULL,
  `KTEXT` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cva_cnt`
--

CREATE TABLE `cva_cnt` (
  `tcode` varchar(20) NOT NULL,
  `count` bigint(21) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cvb_cnt`
--

CREATE TABLE `cvb_cnt` (
  `tcode` varchar(20) NOT NULL,
  `count` bigint(21) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cvf_cnt`
--

CREATE TABLE `cvf_cnt` (
  `tcode` varchar(20) NOT NULL,
  `count` bigint(21) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `disabled_conflicts`
--

CREATE TABLE `disabled_conflicts` (
  `conflictid` varchar(12) NOT NULL DEFAULT '',
  `reason_disabled` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `extract_details`
--

CREATE TABLE `extract_details` (
  `Extract_Date` datetime DEFAULT NULL,
  `USER` varchar(25) DEFAULT NULL,
  `SERVER` varchar(50) DEFAULT NULL,
  `SYSTEM_NO` varchar(2) DEFAULT NULL,
  `SYSTEM_ID` char(3) DEFAULT NULL,
  `CLIENT` char(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fm01t`
--

CREATE TABLE `fm01t` (
  `FIKRS` varchar(4) DEFAULT NULL,
  `FITXT` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inirep`
--

CREATE TABLE `inirep` (
  `repid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `tabl` int(10) UNSIGNED DEFAULT NULL,
  `lin` int(10) UNSIGNED DEFAULT NULL,
  `repout` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lloctt`
--

CREATE TABLE `lloctt` (
  `LOCAT` varchar(4) DEFAULT NULL,
  `TEXT` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mit_conflict`
--

CREATE TABLE `mit_conflict` (
  `conflictid` varchar(12) DEFAULT NULL,
  `uname` varchar(12) DEFAULT NULL,
  `control_id` varchar(20) DEFAULT NULL,
  `solman_req` varchar(100) DEFAULT NULL,
  `created_by` varchar(150) DEFAULT NULL,
  `created_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mit_control`
--

CREATE TABLE `mit_control` (
  `control_id` varchar(20) NOT NULL,
  `proc` varchar(3) DEFAULT NULL,
  `company_id` int(4) DEFAULT NULL,
  `dsc` varchar(2500) DEFAULT NULL,
  `type_id` int(4) DEFAULT NULL,
  `control_owner` varchar(50) DEFAULT NULL,
  `frequency_id` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mit_control_freq`
--

CREATE TABLE `mit_control_freq` (
  `frequency_id` int(4) NOT NULL,
  `frequency_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mit_control_type`
--

CREATE TABLE `mit_control_type` (
  `type_id` int(4) NOT NULL,
  `type_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mit_risk`
--

CREATE TABLE `mit_risk` (
  `riskid` varchar(6) DEFAULT NULL,
  `uname` varchar(12) DEFAULT NULL,
  `control_id` varchar(20) DEFAULT NULL,
  `solman_req` varchar(100) DEFAULT NULL,
  `created_by` varchar(150) DEFAULT NULL,
  `created_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `org_elements`
--

CREATE TABLE `org_elements` (
  `element` varchar(10) NOT NULL,
  `dsc` varchar(50) DEFAULT NULL,
  `tbl` varchar(45) DEFAULT NULL,
  `fld` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `org_filter`
--

CREATE TABLE `org_filter` (
  `element` varchar(10) DEFAULT NULL,
  `val` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `org_filter_option`
--

CREATE TABLE `org_filter_option` (
  `option_id` int(11) NOT NULL,
  `filter_option` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pahi`
--

CREATE TABLE `pahi` (
  `PARTYPE` varchar(1) DEFAULT NULL,
  `HOSTNAME` varchar(32) DEFAULT NULL,
  `SYSTEMID` varchar(2) DEFAULT NULL,
  `PARDATE` varchar(12) DEFAULT NULL,
  `PARNAME` varchar(64) DEFAULT NULL,
  `PARSTATE` varchar(1) DEFAULT NULL,
  `PARVALUE` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rcompleted`
--

CREATE TABLE `rcompleted` (
  `AGR_NAME` varchar(50) DEFAULT NULL,
  `DtStamp` datetime DEFAULT NULL,
  `EOCStat` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rconflicts`
--

CREATE TABLE `rconflicts` (
  `AGR_NAME` varchar(50) DEFAULT NULL,
  `CONFLICTID` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rconflicts_all`
--

CREATE TABLE `rconflicts_all` (
  `AGR_NAME` varchar(50) DEFAULT NULL,
  `CONFLICTID` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rconflicts_all_filter`
--

CREATE TABLE `rconflicts_all_filter` (
  `AGR_NAME` varchar(50) DEFAULT NULL,
  `CONFLICTID` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rconflicts_org`
--

CREATE TABLE `rconflicts_org` (
  `AGR_NAME` varchar(50) DEFAULT NULL,
  `CONFLICTID` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `role_data`
--

CREATE TABLE `role_data` (
  `AGR_NAME` varchar(50) DEFAULT NULL,
  `OBJCT` varchar(45) DEFAULT NULL,
  `AUTH` varchar(12) DEFAULT NULL,
  `FIELD` varchar(45) DEFAULT NULL,
  `FROM` varchar(45) DEFAULT NULL,
  `TO` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `role_tcode`
--

CREATE TABLE `role_tcode` (
  `AGR_NAME` varchar(40) DEFAULT NULL,
  `TCODE` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `root_cause`
--

CREATE TABLE `root_cause` (
  `UNAME` varchar(50) DEFAULT NULL,
  `TCODE` varchar(45) DEFAULT NULL,
  `AGR_NAME` varchar(50) DEFAULT NULL,
  `OBJCT` varchar(10) DEFAULT NULL,
  `AUTH` varchar(12) DEFAULT NULL,
  `FIELD` varchar(10) DEFAULT NULL,
  `FROM` varchar(45) DEFAULT NULL,
  `TO` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `root_cause_org`
--

CREATE TABLE `root_cause_org` (
  `uname` varchar(12) NOT NULL,
  `tcode` varchar(50) NOT NULL,
  `AGR_NAME` varchar(50) DEFAULT NULL,
  `OBJCT` varchar(10) DEFAULT NULL,
  `AUTH` varchar(12) DEFAULT NULL,
  `FIELD` varchar(10) DEFAULT NULL,
  `FROM` varchar(45) DEFAULT NULL,
  `TO` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sap_security`
--

CREATE TABLE `sap_security` (
  `proc` varchar(3) NOT NULL DEFAULT '',
  `tcode` varchar(50) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `saved_filters`
--

CREATE TABLE `saved_filters` (
  `filter_name` varchar(45) NOT NULL,
  `filter_option` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sod_color`
--

CREATE TABLE `sod_color` (
  `RW` int(1) DEFAULT NULL,
  `CL` int(1) DEFAULT NULL,
  `Matrix_color` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sod_risk`
--

CREATE TABLE `sod_risk` (
  `riskid` varchar(6) DEFAULT '',
  `act1` varchar(45) DEFAULT NULL,
  `act2` varchar(45) DEFAULT NULL,
  `act3` varchar(45) DEFAULT NULL,
  `riskname` varchar(1000) DEFAULT NULL,
  `dsc` varchar(1000) DEFAULT NULL,
  `rating` varchar(6) DEFAULT NULL,
  `bproc` varchar(50) DEFAULT NULL,
  `enabled` char(1) DEFAULT NULL,
  `ctype` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t000`
--

CREATE TABLE `t000` (
  `MANDT` varchar(3) DEFAULT NULL,
  `MTEXT` varchar(25) DEFAULT NULL,
  `ORT01` varchar(25) DEFAULT NULL,
  `MWAER` varchar(5) DEFAULT NULL,
  `ADRNR` varchar(10) DEFAULT NULL,
  `CCCATEGORY` varchar(1) DEFAULT NULL,
  `CCCORACTIV` varchar(1) DEFAULT NULL,
  `CCNOCLIIND` varchar(1) DEFAULT NULL,
  `CCCOPYLOCK` varchar(1) DEFAULT NULL,
  `CCNOCASCAD` varchar(1) DEFAULT NULL,
  `CCSOFTLOCK` varchar(1) DEFAULT NULL,
  `CCORIGCONT` varchar(1) DEFAULT NULL,
  `CCIMAILDIS` varchar(1) DEFAULT NULL,
  `CCTEMPLOCK` varchar(1) DEFAULT NULL,
  `CHANGEUSER` varchar(12) DEFAULT NULL,
  `CHANGEDATE` datetime DEFAULT NULL,
  `LOGSYS` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t001`
--

CREATE TABLE `t001` (
  `BUKRS` varchar(4) DEFAULT NULL,
  `BUTXT` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t001k`
--

CREATE TABLE `t001k` (
  `BWKEY` varchar(4) DEFAULT NULL,
  `BUKRS` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t001w`
--

CREATE TABLE `t001w` (
  `WERKS` varchar(4) DEFAULT NULL,
  `NAME1` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t014t`
--

CREATE TABLE `t014t` (
  `KKBER` varchar(4) DEFAULT NULL,
  `KKBTX` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t024`
--

CREATE TABLE `t024` (
  `EKGRP` varchar(3) DEFAULT NULL,
  `EKNAM` varchar(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t024e`
--

CREATE TABLE `t024e` (
  `EKORG` varchar(4) DEFAULT NULL,
  `EKOTX` varchar(20) DEFAULT NULL,
  `BUKRS` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t300t`
--

CREATE TABLE `t300t` (
  `LGNUM` varchar(3) DEFAULT NULL,
  `LNUMT` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t301t`
--

CREATE TABLE `t301t` (
  `LGNUM` varchar(3) DEFAULT NULL,
  `LGTYP` varchar(3) DEFAULT NULL,
  `LTYPT` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t399i`
--

CREATE TABLE `t399i` (
  `IWERK` varchar(4) DEFAULT NULL,
  `NAME1` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t777p`
--

CREATE TABLE `t777p` (
  `PLVAR` varchar(2) DEFAULT NULL,
  `PTEXT` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `t880`
--

CREATE TABLE `t880` (
  `RCOMP` varchar(6) DEFAULT NULL,
  `NAME1` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbkk01t`
--

CREATE TABLE `tbkk01t` (
  `BKKRS` varchar(4) DEFAULT NULL,
  `T_BKKRS` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbkk80t`
--

CREATE TABLE `tbkk80t` (
  `CONDAREA` varchar(4) DEFAULT NULL,
  `T_CONDAREA` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tcode_disabled`
--

CREATE TABLE `tcode_disabled` (
  `activity` varchar(5) DEFAULT NULL,
  `tcode` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tf161`
--

CREATE TABLE `tf161` (
  `DIMEN` varchar(2) DEFAULT NULL,
  `BUNIT` varchar(18) DEFAULT NULL,
  `TXTMI` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tf181`
--

CREATE TABLE `tf181` (
  `DIMEN` varchar(2) DEFAULT NULL,
  `CONGR` varchar(18) DEFAULT NULL,
  `TXTMI` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tgsbt`
--

CREATE TABLE `tgsbt` (
  `GSBER` varchar(4) DEFAULT NULL,
  `GTEXT` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tka01`
--

CREATE TABLE `tka01` (
  `KOKRS` varchar(4) DEFAULT NULL,
  `BEXEI` varchar(25) DEFAULT NULL,
  `WAERS` varchar(5) DEFAULT NULL,
  `KTOPL` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tkebt`
--

CREATE TABLE `tkebt` (
  `ERKRS` varchar(4) DEFAULT NULL,
  `ERKRS_BZ` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tspat`
--

CREATE TABLE `tspat` (
  `SPART` varchar(2) DEFAULT NULL,
  `VTEXT` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tstc`
--

CREATE TABLE `tstc` (
  `tcode` varchar(45) DEFAULT NULL,
  `PGMNA` varchar(40) DEFAULT NULL,
  `CINFO` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tstca`
--

CREATE TABLE `tstca` (
  `TCODE` varchar(20) NOT NULL,
  `OBJCT` varchar(10) NOT NULL,
  `FIELD` varchar(10) NOT NULL,
  `VALUE` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tstct`
--

CREATE TABLE `tstct` (
  `tcode` varchar(45) DEFAULT NULL,
  `desc` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ttdst`
--

CREATE TABLE `ttdst` (
  `TPLST` varchar(4) DEFAULT NULL,
  `BEZEI` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tutyp`
--

CREATE TABLE `tutyp` (
  `USERTYP` char(2) DEFAULT NULL,
  `UTYPTEXT` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tvgrt`
--

CREATE TABLE `tvgrt` (
  `VKGRP` varchar(3) DEFAULT NULL,
  `BEZEI` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tvkbt`
--

CREATE TABLE `tvkbt` (
  `VKBUR` varchar(4) DEFAULT NULL,
  `BEZEI` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tvkot`
--

CREATE TABLE `tvkot` (
  `VKORG` varchar(4) DEFAULT NULL,
  `VTEXT` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tvstt`
--

CREATE TABLE `tvstt` (
  `VSTEL` varchar(4) DEFAULT NULL,
  `VTEXT` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tvtwt`
--

CREATE TABLE `tvtwt` (
  `VTWEG` varchar(2) DEFAULT NULL,
  `VTEXT` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ucompleted`
--

CREATE TABLE `ucompleted` (
  `uname` varchar(12) DEFAULT NULL,
  `DtStamp` datetime DEFAULT NULL,
  `EOCStat` INTEGER DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `uconflicts`
--

CREATE TABLE `uconflicts` (
  `UNAME` varchar(12) DEFAULT NULL,
  `CONFLICTID` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `uconflicts_all`
--

CREATE TABLE `uconflicts_all` (
  `UNAME` varchar(12) DEFAULT NULL,
  `CONFLICTID` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `uconflicts_all_filter`
--

CREATE TABLE `uconflicts_all_filter` (
  `UNAME` varchar(12) DEFAULT NULL,
  `CONFLICTID` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `uconflicts_org`
--

CREATE TABLE `uconflicts_org` (
  `UNAME` varchar(12) DEFAULT NULL,
  `CONFLICTID` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `AGR_NAME` varchar(50) DEFAULT NULL,
  `OBJCT` varchar(45) DEFAULT NULL,
  `AUTH` varchar(12) DEFAULT NULL,
  `FIELD` varchar(45) DEFAULT NULL,
  `FROM` varchar(45) DEFAULT NULL,
  `TO` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
--
-- Table structure for table `user_data_2`
--

CREATE TABLE `user_data_2` (
  `AGR_NAME` varchar(50) DEFAULT NULL,
  `OBJCT` varchar(45) DEFAULT NULL,
  `AUTH` varchar(12) DEFAULT NULL,
  `FIELD` varchar(45) DEFAULT NULL,
  `FROM` varchar(45) DEFAULT NULL,
  `TO` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `uname` varchar(12) NOT NULL DEFAULT '',
  `user_name` varchar(100) DEFAULT NULL,
  `valid_from` varchar(12) DEFAULT NULL,
  `valid_to` varchar(12) DEFAULT NULL,
  `lockstatus` int(11) DEFAULT NULL,
  `user_type` varchar(1) DEFAULT NULL,
  `user_group` varchar(12) DEFAULT NULL,
  `department` varchar(45) DEFAULT 'Not Specified',
  `manager` varchar(45) DEFAULT NULL,
  `suser` varchar(1) DEFAULT '0',
  `shared_id` varchar(1) DEFAULT '0',
  `generic_id` varchar(1) DEFAULT '0',
  `company` varchar(40) DEFAULT NULL,
  `location` varchar(45) DEFAULT NULL,
  `enabled` varchar(1) DEFAULT '1',
  `PASSWORD` varchar(250) DEFAULT NULL,
  `level2` varchar(100) DEFAULT NULL,
  `level3` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_tcode`
--

CREATE TABLE `user_tcode` (
  `uname` varchar(12) DEFAULT NULL,
  `tcode` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usobt_c`
--

CREATE TABLE `usobt_c` (
  `NAME` varchar(30) NOT NULL,
  `TYPE` varchar(2) NOT NULL,
  `OBJECT` varchar(10) NOT NULL,
  `FIELD` varchar(10) NOT NULL,
  `LOW` varchar(40) NOT NULL,
  `HIGH` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usobx_c`
--

CREATE TABLE `usobx_c` (
  `NAME` varchar(30) NOT NULL,
  `TYPE` varchar(2) NOT NULL,
  `OBJECT` varchar(10) NOT NULL,
  `OKFLAG` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usr02`
--

CREATE TABLE `usr02` (
  `UNAME` varchar(12) NOT NULL,
  `VALID_FROM` varchar(12) DEFAULT NULL,
  `VALID_TO` varchar(12) DEFAULT NULL,
  `USER_TYPE` varchar(1) NOT NULL,
  `USER_GROUP` varchar(12) DEFAULT NULL,
  `LOCKSTATUS` varchar(3) NOT NULL,
  `LAST_LOGON` varchar(12) DEFAULT NULL,
  `PASS_CHANGE` varchar(12) DEFAULT NULL,
  `CREATED_ON` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usr06`
--

CREATE TABLE `usr06` (
  `BNAME` varchar(12) DEFAULT NULL,
  `LIC_TYPE` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usr21`
--

CREATE TABLE `usr21` (
  `UNAME` varchar(12) NOT NULL,
  `PERSNUMBER` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ust04`
--

CREATE TABLE `ust04` (
  `username` varchar(12) DEFAULT NULL,
  `profile` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ust10c`
--

CREATE TABLE `ust10c` (
  `PROFN` varchar(12) DEFAULT NULL,
  `AKTPS` varchar(1) DEFAULT NULL,
  `SUBPROF` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ust10s`
--

CREATE TABLE `ust10s` (
  `PROFN` varchar(12) DEFAULT NULL,
  `AKTPS` varchar(1) DEFAULT NULL,
  `OBJCT` varchar(10) DEFAULT NULL,
  `AUTH` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ust12`
--

CREATE TABLE `ust12` (
  `OBJCT` varchar(10) NOT NULL,
  `AUTH` varchar(12) NOT NULL,
  `AKTPS` varchar(1) NOT NULL,
  `FIELD` varchar(10) NOT NULL,
  `FROM` varchar(40) NOT NULL,
  `TO` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `zcodes`
--

CREATE TABLE `zcodes` (
  `zcode` varchar(50) DEFAULT NULL,
  `dsc` varchar(100) DEFAULT NULL,
  `proc` varchar(3) DEFAULT NULL,
  `subproc` varchar(45) DEFAULT NULL,
  `type` varchar(11) DEFAULT NULL,
  `activity` varchar(5) DEFAULT NULL,
  `add_info` varchar(1000) DEFAULT NULL,
  `tcode` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actcode`
--
ALTER TABLE `actcode`
  ADD KEY `idx_actcode` (`activity`,`tcode`);

--
-- Indexes for table `act_class`
--
ALTER TABLE `act_class`
ADD PRIMARY KEY (`activity`) USING BTREE;

--
-- Indexes for table `act_class_desc`
--
ALTER TABLE `act_class_desc`
  ADD KEY `idx_act_class_desc` (`act_num`);

--
-- Indexes for table `adrp`
--
ALTER TABLE `adrp`
  ADD KEY `idx_adrp` (`PERSNUMBER`);

--
-- Indexes for table `agr_1251`
--
ALTER TABLE `agr_1251`
  ADD KEY `IDX_AD` (`AGR_NAME`,`COUNTER`,`OBJECT`,`AUTH`,`FIELD`,`LOW`,`HIGH`),
  ADD KEY `IDX_A11_I` (`AGR_NAME`,`COUNTER`,`MODIFIED`,`COPIED`,`DELETED`,`NEU`);

--
-- Indexes for table `agr_1252`
--
ALTER TABLE `agr_1252`
  ADD KEY `IDX_AD` (`AGR_NAME`,`COUNTER`);

--
-- Indexes for table `agr_define`
--
ALTER TABLE `agr_define`
  ADD KEY `IDX_AD` (`AGR_NAME`,`PARENT_AGR`);

--
-- Indexes for table `agr_users`
--
ALTER TABLE `agr_users`
  ADD KEY `idx_agr_users` (`AGR_NAME`,`UNAME`);

--
-- Indexes for table `bus_proc`
--
ALTER TABLE `bus_proc`
  ADD PRIMARY KEY (`proc`);

--
-- Indexes for table `bus_subproc`
--
ALTER TABLE `bus_subproc`
  ADD KEY `idx_bussupproc` (`proc`,`subproc`);

--
-- Indexes for table `conflicts`
--
ALTER TABLE `conflicts`
  ADD KEY `idx_conflicts` (`CONFLICTID`,`OBJCT`,`FIELD`,`VALUE`);

--
-- Indexes for table `conflicts_c`
--
ALTER TABLE `conflicts_c`
  ADD KEY `idx_conflicts_c` (`CONFLICTID`,`OBJCT`,`FIELD`,`VALUE`);

--
-- Indexes for table `conflicts_first_cnt`
--
ALTER TABLE `conflicts_first_cnt`
  ADD KEY `idx_cfc` (`conflictid`);

--
-- Indexes for table `conflicts_values_a`
--
ALTER TABLE `conflicts_values_a`
  ADD KEY `idx_cva` (`tcode`,`objct`,`field`,`value`);

--
-- Indexes for table `conflicts_values_bl`
--
ALTER TABLE `conflicts_values_bl`
  ADD KEY `idx cvb` (`tcode`,`objct`,`field`);

--
-- Indexes for table `conflicts_values_flbl`
--
ALTER TABLE `conflicts_values_flbl`
  ADD KEY `idx cvf` (`tcode`,`objct`);

--
-- Indexes for table `conflicts_values_notcd`
--
ALTER TABLE `conflicts_values_notcd`
  ADD KEY `idx_cv_notcd` (`tcode`);

--
-- Indexes for table `critical_auth`
--
ALTER TABLE `critical_auth`
  ADD KEY `idx_ca1` (`tcode`);

--
-- Indexes for table `cva_cnt`
--
ALTER TABLE `cva_cnt`
  ADD KEY `idx cva_cnt` (`tcode`,`count`);

--
-- Indexes for table `cvb_cnt`
--
ALTER TABLE `cvb_cnt`
  ADD KEY `idx_cvb_cnt` (`tcode`,`count`);

--
-- Indexes for table `cvf_cnt`
--
ALTER TABLE `cvf_cnt`
  ADD KEY `idx_cvf_cnt` (`tcode`,`count`);

--
-- Indexes for table `disabled_conflicts`
--
ALTER TABLE `disabled_conflicts`
  ADD PRIMARY KEY (`conflictid`);

--
-- Indexes for table `inirep`
--
ALTER TABLE `inirep`
  ADD PRIMARY KEY (`repid`);

--
-- Indexes for table `mit_conflict`
--
ALTER TABLE `mit_conflict`
  ADD KEY `idx_mc` (`conflictid`,`uname`,`control_id`);

--
-- Indexes for table `mit_control`
--
ALTER TABLE `mit_control`
  ADD PRIMARY KEY (`control_id`);

--
-- Indexes for table `mit_control_freq`
--
ALTER TABLE `mit_control_freq`
  ADD PRIMARY KEY (`frequency_id`);

--
-- Indexes for table `mit_control_type`
--
ALTER TABLE `mit_control_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `mit_risk`
--
ALTER TABLE `mit_risk`
  ADD KEY `idx_mr` (`riskid`,`uname`,`control_id`);

--
-- Indexes for table `org_elements`
--
ALTER TABLE `org_elements`
  ADD KEY `idx_oe` (`element`);

--
-- Indexes for table `org_filter`
--
ALTER TABLE `org_filter`
  ADD KEY `idx_of` (`element`,`val`);

--
-- Indexes for table `org_filter_option`
--
ALTER TABLE `org_filter_option`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `rcompleted`
--
ALTER TABLE `rcompleted`
  ADD KEY `idx_rcompleted` (`AGR_NAME`);

--
-- Indexes for table `rconflicts`
--
ALTER TABLE `rconflicts`
  ADD KEY `idx_rconf` (`AGR_NAME`,`CONFLICTID`);

--
-- Indexes for table `rconflicts_all_filter`
--
ALTER TABLE `rconflicts_all_filter`
  ADD KEY `idx_raf` (`AGR_NAME`,`CONFLICTID`);

--
-- Indexes for table `role_data`
--
ALTER TABLE `role_data`
  ADD KEY `idx_roledata` (`AGR_NAME`,`OBJCT`,`AUTH`,`FIELD`,`FROM`,`TO`);

--
-- Indexes for table `saved_filters`
--
ALTER TABLE `saved_filters`
  ADD PRIMARY KEY (`filter_name`);

--
-- Indexes for table `sod_risk`
--
ALTER TABLE `sod_risk`
  ADD KEY `idx_sodrisk` (`riskid`,`act1`,`act2`,`act3`,`bproc`,`enabled`);

--
-- Indexes for table `tcode_disabled`
--
ALTER TABLE `tcode_disabled`
  ADD KEY `idx_tcode_disabled` (`activity`,`tcode`);

--
-- Indexes for table `tstc`
--
ALTER TABLE `tstc`
  ADD KEY `idx_tstc` (`tcode`);

--
-- Indexes for table `tstct`
--
ALTER TABLE `tstct`
  ADD KEY `idx_tstct_tcode` (`tcode`),
  ADD KEY `idx_tstct` (`tcode`);

--
-- Indexes for table `tutyp`
--
ALTER TABLE `tutyp`
  ADD UNIQUE KEY `USERTYP` (`USERTYP`);

--
-- Indexes for table `uconflicts`
--
ALTER TABLE `uconflicts`
  ADD KEY `idx_uconflicts` (`UNAME`,`CONFLICTID`);

--
-- Indexes for table `uconflicts_all_filter`
--
ALTER TABLE `uconflicts_all_filter`
  ADD KEY `idx_ua` (`UNAME`,`CONFLICTID`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD KEY `idx_ua` (`AGR_NAME`,`OBJCT`,`AUTH`,`FIELD`,`FROM`,`TO`);
  
-- Indexes for table `user_data`
--
ALTER TABLE `user_data_2`
  ADD KEY `idx_ua` (`AGR_NAME`,`OBJCT`,`AUTH`,`FIELD`,`FROM`,`TO`);
--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD KEY `idx_ud` (`uname`,`valid_from`,`valid_to`,`lockstatus`,`user_type`);

--
-- Indexes for table `user_tcode`
--
ALTER TABLE `user_tcode`
  ADD KEY `idx_usertcd` (`uname`,`tcode`);

--
-- Indexes for table `usr02`
--
ALTER TABLE `usr02`
  ADD KEY `idx_usr02` (`UNAME`,`VALID_FROM`,`VALID_TO`,`USER_TYPE`,`LOCKSTATUS`);

--
-- Indexes for table `usr06`
--
ALTER TABLE `usr06`
  ADD UNIQUE KEY `BNAME` (`BNAME`);

--
-- Indexes for table `usr21`
--
ALTER TABLE `usr21`
  ADD KEY `idx_usr21` (`UNAME`,`PERSNUMBER`);

--
-- Indexes for table `ust04`
--
ALTER TABLE `ust04`
  ADD KEY `idx_ut4` (`profile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mit_control_freq`
--
ALTER TABLE `mit_control_freq`
  MODIFY `frequency_id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mit_control_type`
--
ALTER TABLE `mit_control_type`
  MODIFY `type_id` int(4) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
