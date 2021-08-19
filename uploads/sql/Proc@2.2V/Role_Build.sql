CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_Role_Build`(var_mydb varchar(100), var_co varchar(1000), var_dept varchar(1000), var_loc varchar(1000), var_lock int, var_exp_role int, var_exp_user int)

BEGIN
  
/*This proc was modified on 02-Oct-2011 to rectify the queries that create indexes only if extracted tables exist by adding the condition table_schema=var_mydb.
Also, the queries creating tables conflicts_values_a_o, conflicts_values_bl_o etc. are commented as not required.*/

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

DECLARE n INT DEFAULT 0;
DECLARE i INT DEFAULT 0;

select variable_value into log_stat  from information_schema.global_variables where variable_name = 'General_Log';
if log_stat = 'ON' then
    set global general_log = 'OFF';
end if;

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Build', 'Removing Temporary Tables..', current_timestamp());

drop table if exists UST04_TEMP;
drop table if exists UST10C_TEMP;
drop table if exists agr_1016_temp;
drop table if exists UST10S_TEMP;
drop table if exists UST12_TEMP;

/* tab_users is a table important in context of analysis */
/* BNAME is UNAME */



/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Build', 'Creating Table Indexes..', current_timestamp());

/*Checking if tables exist and then creating indexes*/
select count(*) into var_tblcnt from information_schema.tables where table_schema = var_mydb and table_name = 'tab_user';
select count(*) into var_indcnt FROM  INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'tab_user' and index_name = 'idx_tu' and table_schema = var_mydb;
if var_tblcnt=1 and var_indcnt=0 then
    create index idx_tu on tab_user(uname);
end if;

select count(*) into var_tblcnt from information_schema.tables where table_schema = var_mydb and table_name = 'adrp';
select count(*) into var_indcnt FROM  INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'adrp' and index_name = 'idx_adrp' and table_schema = var_mydb;
if var_tblcnt=1 and var_indcnt=0 then
    create index idx_adrp on adrp(persnumber);
end if;

select count(*) into var_tblcnt from information_schema.tables where table_schema = var_mydb and table_name = 'ust04';
select  count(*) into var_indcnt FROM INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'ust04' and  index_name = 'idx_ust04' and table_schema = var_mydb;
if var_tblcnt=1 and var_indcnt=0 then
    create index idx_ust04 on ust04(username,profile);
end if;

select count(*) into var_tblcnt from information_schema.tables where table_schema = var_mydb and table_name = 'ust10c';
select  count(*) into var_indcnt FROM INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'ust10c' and index_name = 'idx_ust10c' and table_schema = var_mydb;
if var_tblcnt=1 and var_indcnt=0 then
    create index idx_ust10c on ust10c(profn,subprof);
end if;

select count(*) into var_tblcnt from information_schema.tables where table_schema = var_mydb and table_name = 'agr_1016';
select  count(*) into var_indcnt FROM INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'agr_1016' and index_name = 'idx_agr_1016' and table_schema = var_mydb;
if var_tblcnt=1 and var_indcnt=0 then
    create index idx_agr_1016 on agr_1016(agr_name, profile,counter);
end if;

select count(*) into var_tblcnt from information_schema.tables where table_schema = var_mydb and table_name = 'agr_users';
select  count(*) into var_indcnt FROM INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'agr_users' and  index_name = 'idx_agr_users' and table_schema = var_mydb;
if var_tblcnt=1 and var_indcnt=0 then
    create index idx_agr_users on agr_users(agr_name,uname);
end if;

select count(*) into var_tblcnt from information_schema.tables where table_schema = var_mydb and table_name = 'usr02';
select  count(*) into var_indcnt FROM INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'usr02' and  index_name = 'idx_usr02' and table_schema = var_mydb;
if var_tblcnt=1 and var_indcnt=0 then
    create index idx_usr02 on usr02(uname,valid_from,valid_to,user_type,lockstatus);
end if;

select count(*) into var_tblcnt from information_schema.tables where table_schema = var_mydb and table_name = 'usr21';
select  count(*) into var_indcnt FROM INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'usr21' and  index_name = 'idx_usr21' and table_schema = var_mydb;
if var_tblcnt=1 and var_indcnt=0 then
    create index idx_usr21 on usr21(uname,persnumber);
end if;

select count(*) into var_tblcnt from information_schema.tables where table_schema = var_mydb and table_name = 'ust10s';
select  count(*) into var_indcnt FROM INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'ust10s' and index_name = 'idx_ust10s' and table_schema = var_mydb;
if var_tblcnt=1 and var_indcnt=0 then
    create index idx_ust10s on ust10s(profn,objct,auth);
end if;

select count(*) into var_tblcnt from information_schema.tables where table_schema = var_mydb and table_name = 'ust12';
select  count(*) into var_indcnt FROM INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'ust12' and  index_name = 'idx_ust12' and table_schema = var_mydb;
if var_tblcnt=1 and var_indcnt=0 then
    create index idx_ust12 on ust12(objct,auth,field);
end if;

select count(*) into var_tblcnt from information_schema.tables where table_schema = var_mydb and table_name = 'tstct';
select  count(*) into var_indcnt FROM INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'tstct' and  index_name = 'idx_tstct' and table_schema = var_mydb;
if var_tblcnt=1 and var_indcnt=0 then
    create index idx_tstct on tstct(tcode);
end if;

select count(*) into var_tblcnt from information_schema.tables where table_schema = var_mydb and table_name = 'usobx_c';
select  count(*) into var_indcnt FROM INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'usobx_c' and  index_name = 'idx_usobx_c' and table_schema = var_mydb;
if var_tblcnt=1 and var_indcnt=0 then
    create index idx_usobx_c on usobx_c(name,object,okflag);
end if;

select count(*) into var_tblcnt from information_schema.tables where table_schema = var_mydb and table_name = 'usobt_c';
select  count(*) into var_indcnt FROM INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'usobt_c' and  index_name = 'idx_usobt_c' and table_schema = var_mydb;
if var_tblcnt=1 and var_indcnt=0 then
    create index idx_usobt_c on usobt_c(name,object,field,low);
end if;

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Build', 'Triming SAP Data...', current_timestamp());

/*Cleaning up data*/
update agr_users set uname=trim(uname), agr_name=trim(agr_name);
update tstct set tcode=trim(tcode);
update agr_1016 set agr_name=trim(agr_name);
update user_details set uname=trim(uname);
update usr02 set uname=trim(uname);
update usr21 set uname=trim(uname), persnumber=trim(persnumber);
update ust04 set username=trim(username), profile=trim(profile);
update ust10c set profn=trim(profn), subprof=trim(subprof);
update ust10s set profn=trim(profn), objct=trim(objct), auth=trim(auth);
update ust12 set objct=trim(objct), auth=trim(auth), field=trim(field);


/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Build', 'Update Master Role...', current_timestamp());

/*Create backup of UST04 and UST10C*/
create table if not exists UST04_ORIG select * from UST04;
create table if not exists UST10C_ORIG select * from UST10C;

/*delete from UST04 where profile in (select distinct PROFILE from AGR_1016);*/
drop table if exists ust04_del;

create table ust04_del select distinct u.profile from (select distinct profile from ust04) u inner join agr_1016 a on u.profile=a.profile;
create index idx_ud on ust04_del(profile);

delete u from UST04 u, ust04_del a where u.profile=a.profile;
drop table if exists ust04_del;
delete from UST04 where profile = '............';
/*delete from UST10C where profn in (select distinct PROFILE from AGR_1016);*/
delete u from UST10C u, AGR_1016 a where u.profn=a.profile;

insert into AGR_1016 select distinct concat('PROFILE:',profn),'000001',profn,'','X','' from ust04 u, ust10s s where u.profile = s.profn;
insert into AGR_USERS select distinct concat('PROFILE:',profn),username,'20000101','99991231','','','' from ust04 u, ust10s s where s.profn=u.profile;
delete u from ust04 u, ust10s s where u.profile=s.profn;


drop table if exists ust10c_recur;
create table ust10c_recur select distinct c.profn master_profn, c.profn, c.subprof from ust10c c, ust04 u where c.profn = u.profile;

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Build', 'Attaching Profiles with Subprofiles', current_timestamp());

while exists (select * from ust10c_recur) 
do
    select master_profn,profn,subprof into var_masterprofn, var_profn, var_subprof from ust10c_recur limit 1;
    
    insert into AGR_1016 select distinct concat('PROFILE:', var_subprof),'000001',var_subprof,'','X','' from ust10s where profn=var_subprof;
    insert into AGR_USERS select distinct concat('PROFILE:',var_subprof),u.username,'20000101','99991231','','','' from ust04 u, ust10s s where u.profile = var_masterprofn and s.profn=var_subprof;
    
    insert into ust10c_recur select distinct var_masterprofn, profn, subprof from ust10c where profn=var_subprof;
    delete from ust10c_recur where master_profn = var_masterprofn and profn = var_profn and subprof=var_subprof;

end while;

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Build', 'Cleaning Users..', current_timestamp());

drop table if exists ust10c_recur;

DROP TABLE IF EXISTS AGR_1016_CLEANUP;
CREATE TABLE AGR_1016_CLEANUP SELECT DISTINCT * FROM AGR_1016;
TRUNCATE AGR_1016;
INSERT INTO AGR_1016 SELECT * FROM AGR_1016_CLEANUP;
DROP TABLE IF EXISTS AGR_1016_CLEANUP;

DROP TABLE IF EXISTS AGR_USERS_CLEANUP;
CREATE TABLE AGR_USERS_CLEANUP SELECT DISTINCT * FROM AGR_USERS;
TRUNCATE AGR_USERS;
INSERT INTO AGR_USERS SELECT * FROM AGR_USERS_CLEANUP;
DROP TABLE IF EXISTS AGR_USERS_CLEANUP;



/* ==== Modified By Manish (Commented Code Uncommented) ==== */

/* The part below has been commented since it is taken care of by C# code in application. */

/*if var_lock = 1 then
    set lock_condition = ' and r.lockstatus in (0,128)';
else
    set lock_condition = '';
end if;
if var_exp_role = 1 then
    set exp_role_status= 'u.to_dat >= curdate() and ';
else
    set exp_role_status = '';
end if;
if var_exp_user = 1 then
    set exp_user_status= ' (r.valid_to = \'00000000\' or r.valid_to >= curdate()) and ';
else
    set exp_user_status = '';
end if;
if var_co = '\'%\'' then
    set var_co = '';
else
    set var_co = concat('d.company in (',var_co,')');
end if;
if var_dept = '\'%\'' then
    set var_dept = '';
else
    set var_dept = concat(' and d.company in (',var_dept,') ');
end if;
if var_loc = '\'%\'' then
    set var_loc = '';
else
    set var_loc = concat(' and d.location in (',var_loc,') ');
end if;
   
   set @user_query = concat('select distinct u.UNAME from AGR_USERS u, usr02 r, user_details d where ',exp_role_status, 'u.uname=d.uname and ',exp_user_status,' d.enabled = 1 ', var_co, var_dept, var_loc,' and u.uname=r.uname', lock_condition,';');
-- set @user_query = concat('create table tab_user select distinct u.UNAME from AGR_USERS u, usr02 r, user_details d where ',exp_role_status, 'u.uname=d.uname and ',exp_user_status,' d.enabled = 1 ', var_co, var_dept, var_loc,' and u.uname=r.uname', lock_condition,';');
prepare s from @user_query;
execute s;*/

/* ==== End Block - Modified By Manish (Commented Code Uncommented) ==== */


/*Re-creating the rules tables*/
drop table if exists tcode_list;
drop table if exists conflicts_values_a_o;
drop table if exists conflicts_values_bl_o;
drop table if exists cva_cnt_o;
drop table if exists cvb_cnt_o;
drop table if exists conflicts_values_flbl_o;
drop table if exists cvf_cnt_o;
drop table if exists conflicts_values_notcd_o;

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Build', 'Preparing T-Code List..', current_timestamp());

create table tcode_list select distinct q.tcode from (select distinct tcode from actcode union select distinct value tcode from conflicts_c union select distinct tcode from critical_auth where status=1 union select distinct tcode from tstct where tcode like 'Y%' or tcode like 'Z%')q;
select count(*) into var_tstca from information_schema.tables where table_schema = var_mydb and table_name = 'tstca';
select count(*) into var_usobx from information_schema.tables where table_schema = var_mydb and table_name = 'usobx_c';
select count(*) into var_usobt from information_schema.tables where table_schema = var_mydb and table_name = 'usobt_c';

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Build', 'Preparing Conflicts.. ', current_timestamp());

if var_tstca > 0 then
  /*create table conflicts_values_a_o select * from conflicts_values_a;
  create table conflicts_values_bl_o select * from conflicts_values_bl;
  create table cva_cnt_o select * from cva_cnt;
  create table cvb_cnt_o select * from cvb_cnt;*/
  delete from conflicts_values_a;
  delete from conflicts_values_bl;
  delete from cva_cnt;
  delete from cvb_cnt;
  
  insert into conflicts_values_a select distinct t.tcode,t.objct,t.field,t.value from tstca t, tcode_list c where t.tcode=c.tcode and t.value is not null and t.value <> '';
  insert into conflicts_values_bl select distinct t.tcode,t.objct,t.field from tstca t, tcode_list c where t.tcode=c.tcode and (t.value is null or t.value = '');
  insert into cva_cnt select tcode, count(*) from conflicts_values_a group by tcode;
  insert into cvb_cnt select tcode, count(*) from conflicts_values_bl group by tcode;

end if;

if var_usobx > 0 and var_usobt > 0 then
  
  /*create table conflicts_values_flbl_o select * from conflicts_values_flbl;
  create table cvf_cnt_o select * from cvf_cnt;*/

  delete from conflicts_values_flbl;
  delete from cvf_cnt;
  insert into conflicts_values_flbl select distinct x.name tcode, x.object objct from usobx_c x, tcode_list c where x.okflag='y' and x.name=c.tcode;
  delete f from conflicts_values_flbl f, (select distinct tcode from conflicts_values_a union select distinct tcode from conflicts_values_bl)q where q.tcode=f.tcode;
  insert into cvf_cnt select tcode, count(*) from conflicts_values_flbl group by tcode;

end if;

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Build', 'Preparing Conflict Values', current_timestamp());

if var_tstca > 0 or var_usobx > 0 or var_usobt > 0 then
  /*create table conflicts_values_notcd_o select * from conflicts_values_notcd;*/
  delete from conflicts_values_notcd;
  insert into conflicts_values_notcd select distinct tcode from tcode_list;
  delete t from conflicts_values_notcd t, (select distinct tcode from conflicts_values_a union select distinct tcode from conflicts_values_bl union select distinct tcode from conflicts_values_flbl)q where q.tcode=t.tcode;
end if;
drop table if exists tcode_list;

/*Restoring UST04 and UST10C to original state*/
truncate ust04;
insert into ust04 select * from ust04_orig;
drop table if exists ust04_orig;

truncate ust10c;
insert into ust10c select * from ust10c_orig;
drop table if exists ust10c_orig;

drop table if exists build_temp;
drop table if exists role_build;

/* === Below 2 Variable Added By Manish Kr === */

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