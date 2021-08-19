-- DROP PROCEDURE IF EXISTS `usp_Role_Build3`;

CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_Role_Build3`(var_mydb varchar(100), var_co varchar(1000), var_dept varchar(1000), var_loc varchar(1000), var_lock int, var_exp_role int, var_exp_user int)

BEGIN
	
declare var_prof, var_masterprofn varchar(12); 
declare usr varchar(12);
declare prof_count int(2);
declare sbprf varchar(12);
declare prof_1016 varchar(12);
declare auth10s, log_stat varchar(12);
declare objct12 varchar(10);
declare auth12 varchar(12);
declare aktps12, var_aktps varchar(1);
declare field12 varchar(10);
declare from12 varchar(40);
declare to12 varchar(40);
declare agrname varchar(50);
DECLARE AGRNAM,var_profn, var_subprof VARCHAR(50);
declare lock_condition,exp_role_status, exp_user_status varchar(100);
declare user_query varchar(1000);
declare var_tstca,var_usobx,var_usobt, var_tblcnt, var_indcnt int(1);

/* === Below 2 Variable Added By Manish Kr === */
DECLARE n INT DEFAULT 0;
DECLARE i INT DEFAULT 0;

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Build', 'Removing Temporary Tables..', current_timestamp());

/* ===== By Manish ====*/

DROP table if exists AGR_1016_ORIG;
DROP table if exists AGR_USERS_ORIG;
DROP table if exists AGR_1016_CLEANUP_INDO;
DROP table if exists AGR_USERS_CLEANUP_INDO;


create table if not exists AGR_1016_ORIG select * from AGR_1016;
create table if not exists AGR_USERS_ORIG select * from AGR_USERS;

DROP table if exists ENABLED_USERS_ROLE_INDO;
CREATE TABLE ENABLED_USERS_ROLE_INDO SELECT DISTINCT au.agr_name FROM USER_DETAILS ud INNER JOIN AGR_USERS au on au.uname = ud.uname and ud.enabled = 1;
Delete a1 from AGR_1016 a1 where a1.agr_name not in ( select a2.agr_name from ENABLED_USERS_ROLE_INDO a2 );

DROP TABLE IF EXISTS role_build;

/* === Added By Manish A NEW Table == */
DROP TABLE IF EXISTS TMP_ROLE_BUILD;

/* ===== By Manish ====*/

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Build', 'Preparing Role Build...', current_timestamp());


CREATE TABLE IF NOT EXISTS role_build (
`AGR_NAME` varchar(50) default NULL,
`OBJCT` varchar(10) default NULL,
`AUTH` varchar(12) default NULL,
`FIELD` varchar(10) default NULL,
`FROM` varchar(45) default NULL,
`TO` varchar(45) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/* === Added By Manish A NEW Table == */
CREATE TABLE IF NOT EXISTS TMP_ROLE_BUILD (
`AGR_NAME` varchar(50) default NULL,
`OBJCT` varchar(10) default NULL,
`AUTH` varchar(12) default NULL,
`FIELD` varchar(10) default NULL,
`FROM` varchar(45) default NULL,
`TO` varchar(45) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


/* THIS HAS BEEN REPLACED BY A MORE EFFICIENT QUERY JUST BELOW THE COMMENTED BLOCK
CREATE TABLE IF NOT EXISTS AGR_TEMP SELECT DISTINCT A.AGR_NAME FROM AGR_USERS A, TAB_USER U WHERE A.AGR_NAME NOT LIKE 'PROFILE:%SAP%ALL%' AND A.AGR_NAME NOT LIKE 'PROFILE:%SAP%NEW%' AND A.UNAME = U.UNAME;
DELETE A FROM AGR_TEMP A INNER JOIN ROLE_BUILD R ON A.AGR_NAME=R.AGR_NAME;
DROP TABLE IF EXISTS BUILD_TEMP;
CREATE TABLE BUILD_TEMP SELECT DISTINCT A.AGR_NAME,S.PROFN,S.AUTH FROM AGR_1016 A, UST10S S WHERE A.COUNTER=1 AND A.PROFILE=S.PROFN LIMIT 0;
CREATE INDEX IDX_BT ON BUILD_TEMP(AGR_NAME,PROFN,AUTH);
WHILE EXISTS (SELECT * FROM AGR_TEMP) DO
SELECT AGR_NAME INTO AGRNAM FROM AGR_TEMP LIMIT 1;
INSERT INTO BUILD_TEMP SELECT DISTINCT A.AGR_NAME,S.PROFN,S.AUTH FROM AGR_1016 A, UST10S S
WHERE A.AGR_NAME=AGRNAM AND A.COUNTER=1 AND S.PROFN=A.PROFILE;
INSERT INTO ROLE_BUILD
SELECT DISTINCT AGRNAM,U.OBJCT,U.AUTH,U.FIELD,U.FROM,U.TO FROM BUILD_TEMP B, UST12 U
WHERE B.AGR_NAME = AGRNAM AND B.AUTH=U.AUTH;
DELETE FROM AGR_TEMP WHERE AGR_NAME=AGRNAM;
TRUNCATE BUILD_TEMP;
END WHILE;
DROP TABLE IF EXISTS BUILD_TEMP;
DROP TABLE IF EXISTS AGR_TEMP;*/

/* Query does not give correct results if UST10S and UST12 are out of sync. Hence replaced with 2 queries below
INSERT INTO ROLE_BUILD SELECT DISTINCT A.AGR_NAME,U.OBJCT,U.AUTH,U.FIELD,U.FROM,U.TO FROM AGR_1016 A inner join UST10S S on S.PROFN=A.PROFILE
INNER JOIN UST12 U ON S.OBJCT=U.OBJCT AND S.AUTH=U.AUTH WHERE A.COUNTER=1 and A.AGR_NAME NOT LIKE 'PROFILE:%SAP%ALL%' AND A.AGR_NAME NOT LIKE 'PROFILE:%SAP%NEW%';*/




CREATE TABLE BUILD_TEMP SELECT DISTINCT A.AGR_NAME,S.AUTH FROM AGR_1016 A inner join UST10S S on S.PROFN=A.PROFILE whERE A.COUNTER=1 and A.AGR_NAME NOT LIKE 'PROFILE:%SAP%ALL%' AND A.AGR_NAME NOT LIKE 'PROFILE:%SAP%NEW%';
CREATE INDEX IDX_BT ON BUILD_TEMP(AUTH);

/* ==== Below Working Code is Commented By Manish Kr === */
/* INSERT INTO ROLE_BUILD SELECT DISTINCT B.AGR_NAME,U.OBJCT,U.AUTH,U.FIELD,U.FROM,U.TO FROM BUILD_TEMP B INNER JOIN UST12 U ON B.AUTH=U.AUTH; */

/* ==== Code Snippet is Added By Manish Kr == */

INSERT INTO TMP_ROLE_BUILD SELECT DISTINCT B.AGR_NAME,U.OBJCT,U.AUTH,U.FIELD,U.FROM,U.TO FROM BUILD_TEMP B INNER JOIN UST12 U ON B.AUTH=U.AUTH;

SELECT COUNT(*) FROM TMP_ROLE_BUILD INTO n;
SET i = 0;
WHILE i < n DO 
  INSERT INTO ROLE_BUILD SELECT * FROM TMP_ROLE_BUILD LIMIT i,1000;
  SET i = i + 1000;
END WHILE;

/* ============= */


/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Build', 'Updating Role Build...', current_timestamp());

DROP TABLE IF EXISTS BUILD_TEMP;

update role_BUILD r set r.to=r.from where r.to='' or r.to is null;
update role_BUILD d set d.from = replace(d.from,'*','%'), d.to = replace(d.to,'*','__%');
create index idx_rB_name_objct_field on role_build(agr_name, auth,objct,field,`from`,`to`);
CREATE INDEX IDX_RB_NAME_FRM_TO ON role_build(agr_name,`from`,`to`);


/* === By Manish === */
DROP TABLE IF EXISTS PROFILES_SAP_ALL;
CREATE TABLE PROFILES_SAP_ALL SELECT DISTINCT A.AGR_NAME,S.AUTH FROM AGR_1016 A inner join UST10S S on S.PROFN=A.PROFILE whERE A.COUNTER=1 and (A.AGR_NAME LIKE 'PROFILE:%SAP%ALL%' OR A.AGR_NAME  LIKE 'PROFILE:%SAP%NEW%');

/* === By Manish === */

/* === By Manish ==== */
	
	DROP TABLE  IF EXISTS AGR_1016;
	CREATE TABLE AGR_1016 SELECT * FROM AGR_1016_ORIG;
	DROP TABLE IF EXISTS AGR_1016_ORIG ;

/* === By Manish ==== */

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Build', 'Analysis Preparation Completed...', current_timestamp());


if log_stat = 'ON' then
set global general_log = 'ON';
end if;


END 