CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_Role_Build1`(var_mydb varchar(100), var_co varchar(1000), var_dept varchar(1000), var_loc varchar(1000), var_lock int, var_exp_role int, var_exp_user int)

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

END 