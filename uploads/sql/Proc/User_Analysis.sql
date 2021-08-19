

-- DROP PROCEDURE IF EXISTS `USP_USER_ANALYSIS`;

CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_User_Analysis`(var_proc varchar(1000), var_custom int, var_rca int, var_mydb varchar(100))
BEGIN

/*This proc is updated on 04-Nov-2012 to add table ACT_VAL so that activity exclusion is flexible. The proc now also
removes the entries from root_cause table where the conflicts_exceptions are specified and due to such exceptions user is 
deemed not to have access to a tcode.

Further updated on 01-Jul-2013 to add 'Other Tcodes' in User-Tcode where the tcodes are not part of conflict definition or
critical access. For such tcodes user is considered to have access without any checks and may result in false positives.*/

/*User Analysis Declarations*/

declare done, cnt_var_tcode,var_ce,var_cac int; /*Status of Flow*/
declare unam, log_stat varchar(20);
declare var_auth varchar(12);
declare var_tcode,lock_condition,exp_role_status, exp_user_status varchar(100);
declare proc_query, DispUser_Query, DelConf_query varchar(1000);
declare var_tblcnt, var_indcnt, var_exprole int;

select variable_value into log_stat from information_schema.global_variables where variable_name = 'General_Log';
if log_stat = 'ON' then
    set global general_log = 'OFF';
end if;

/* To be able to restart the analysis from the point where it was stopped / killed, these statements have to be
removed.*/

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'User Analyis', 'Removing Temporary Tables..', current_timestamp());

drop table if exists tcode_list;
drop table if exists user_eval_tcd;
drop table if exists cva;
drop table if exists cva_view;
drop table if exists cva_view_filter;
drop table if exists cva_tcode;
drop table if exists cvb;
drop table if exists cvb_tcode;
drop table if exists cvb_view;
drop table if exists cvb_view_filter;
drop table if exists cvf;
drop table if exists cvf_tcode;
drop table if exists cvf_view;
drop table if exists cvf_view_filter;
drop table if exists conf_tcode;
drop table if exists user_eval_tcd_src;

IF VAR_RCA=0 THEN
    CREATE TABLE  IF NOT EXISTS ROOT_CAUSE (
      `UNAME` varchar(50) default NULL,
      `TCODE` varchar(45) default NULL,
      `AGR_NAME` varchar(50) default NULL,
      `OBJCT` varchar(10)default NULL,
      `AUTH` varchar(12)default NULL,
      `FIELD` varchar(10) default NULL,
      `FROM` varchar(45) default NULL,
      `TO` varchar(45) default NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


    select count(*) into var_indcnt FROM INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'ROOT_CAUSE' and index_name = 'idx_RC' and table_schema = var_mydb;
    if var_indcnt=0 then
      CREATE INDEX IDX_RC ON ROOT_CAUSE(UNAME,TCODE,AGR_NAME,OBJCT,FIELD,`FROM`,`TO`);
    ELSE
      DROP INDEX IDX_RC ON ROOT_CAUSE;
      CREATE INDEX IDX_RC ON ROOT_CAUSE(UNAME,TCODE,AGR_NAME,OBJCT,FIELD,`FROM`,`TO`);
    end if;

    DROP TABLE IF EXISTS ROOT_CAUSE_ORG;
    CREATE TABLE IF NOT EXISTS ROOT_CAUSE_ORG (
      `UNAME` varchar(50) default NULL,
      `TCODE` varchar(45) default NULL,
      `AGR_NAME` varchar(50) default NULL,
      `OBJCT` varchar(10)default NULL,
      `AUTH` varchar(12) default NULL,
      `FIELD` varchar(10) default NULL,
      `FROM` varchar(45) default NULL,
      `TO` varchar(45) default NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
   DROP TABLE IF EXISTS ROOT_CAUSE_ANALYSIS;
   CREATE TABLE ROOT_CAUSE_ANALYSIS SELECT * FROM ROOT_CAUSE;
   CREATE INDEX IDX_RCA ON ROOT_CAUSE_ANALYSIS(UNAME,TCODE,AGR_NAME,AUTH,OBJCT,FIELD,`FROM`,`TO`);
END IF;

/*Creating table for only enabled conflicts definition*/
/*if var_proc <> '\'%\'' then
    set @proc_query = concat('delete from conflicts_c where left(conflictid,3) not in (',var_proc,');');
    prepare q1 from @proc_query;
    execute q1;

    set @proc_query = concat('delete from rconflicts where left(conflictid,3) not in (',var_proc,');');
    prepare q2 from @proc_query;
    execute q2;
end if;*/
/* creating table conf_tcode from actcode, conflicts_c critical auth tstct*/

if var_custom=1 then
    create table conf_tcode select distinct tcode from actcode union select distinct value `tcode` from conflicts_c  union select distinct tcode from critical_auth where status=1 union select distinct tcode from tstct where tcode like 'Y%' or tcode like 'Z%';
else
    create table conf_tcode select distinct tcode from actcode union select distinct value `tcode` from conflicts_c where value not like 'Y%' and value not like 'Z%'  union select distinct tcode from critical_auth where tcode not like 'Y%' and tcode not like 'Z%' and status=1;
end if;

/* take only distinct tcode from conf_tcode*/
drop table if exists conf_tcode_dist;
create table conf_tcode_dist select distinct * from conf_tcode;
truncate conf_tcode;
insert into conf_tcode select * from conf_tcode_dist;
create index idx_ct on conf_tcode(tcode);
drop table if exists conf_tcode_dist;

/*Create a list of tcode and specific org element related fields for the tcode*/
drop table if exists tmp_tcode_field;
drop table if exists tmp_tmp_tcode_field;

/*Create a list of tcode in tmp_tcode_field and specific org element related fields for the tcode as field of usobt_c is = element of org_element and then take only disctinct values of table*/

IF VAR_RCA = 0 THEN
   create table tmp_tcode_field select distinct c.value tcode, x.object objct, t.field
      from usobx_c x, usobt_c t, org_elements o, (select distinct value from conflicts_c) c where x.okflag = 'Y' and X.name = c.value and x.name=t.name and x.object=t.object and t.field = o.element;
   insert into tmp_tcode_field select distinct t.tcode, t.objct, t.field from tstca t,usobt_c c, org_elements o
      where c.low like '$%' and c.name=t.tcode and c.object=t.objct and c.field=t.field and t.field=o.element;

    create table tmp_tmp_tcode_field select distinct * from tmp_tcode_field;
    delete from tmp_tcode_field;
    insert into tmp_tcode_field select * from tmp_tmp_tcode_field;
    drop table tmp_tmp_tcode_field;
    create index idx_ttf on tmp_tcode_field(tcode,objct,field);
end if;


/* Creating a table agr_count_temp to count roles attached to per users using agr_users
	Creating another table tab_user_temp taking user names from tab_users( users selected for analysis) and joning this temp table with above table. Logic is now we have list of user name and count of roles attached to users for all those users who are selected for analysis. Put this detail in tab_user by truncating old values*/


drop table if exists agr_counts_temp;
create table agr_counts_temp select uname, count(distinct agr_name) cnt from agr_users group by uname;
create index idx_act on agr_counts_temp(uname);
drop table if exists tab_user_temp;
create table tab_user_temp select t.uname, cnt from tab_user t left join agr_counts_temp a on a.uname=t.uname order by cnt;
truncate tab_user;
insert into tab_user select uname from tab_user_temp;
drop table if exists tab_user_temp;
drop table if exists agr_counts_temp;

/*Creating tables for analysis*/
create table cva (`tcode` varchar(45),`Count` int(5)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_cva on cva(tcode);
create table cva_tcode (`tcode` varchar(45)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_ct on cva_tcode(tcode);

create table cvb (`tcode` varchar(45),`Count` int(5)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_cvb on cvb(tcode);
create table cvb_tcode (`tcode` varchar(45)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_ct on cvb_tcode(tcode);

create table cvf (`tcode` varchar(45),`Count` int(5)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_cvf on cvf(tcode);

/* starting loop unless there are values in tab_user table. Take the first user from tab_user and put that in variable uname, 
then get all the data of that user from role_build into table user_data condition user is not expired 
then deleting values from user_data those roles which are maintained in table conflicts_exceptions_role and where from and to are empty*/

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'User Analyis', 'Extracting User Conflicts..', current_timestamp());

while exists (select uname from tab_user) do
    select * into unam from tab_user limit 1;
    /*Getting authorization data pertaining to user under analysis in table user_data*/
    
    /* Below Line Commented by Manish */
    
    /* select expired_role into var_exprole from quick_audit.analysis_criteria a inner join quick_audit.report_license r on a.license_id=r.license_id and r.my_db_name=var_mydb; */

    /*Inserting data in user_data table*/
    drop index idx_ua on user_data;
    if var_exprole=1 then
        insert into user_data select distinct r.* from role_build r, (select * from agr_users where uname = unam and date(to_dat)>=curdate()) a where r.agr_name=a.agr_name;
    else
        insert into user_data select distinct r.* from role_build r, (select * from agr_users where uname = unam) a where r.agr_name=a.agr_name;
    end if;
    create index idx_ua on user_data(agr_name,objct,auth,field,`from`,`to`);
    delete u from user_data u inner join conflicts_exceptions_role c on u.agr_name=c.agr_name where c.uname=unam;
    delete from user_data where `from`='' and `to`='';

	
	
	/*  Taking distinct tcode from conf_tcode, joining with user_data table created above and taking values where object is s_tcode and field is TCD and tcode from conf_tcode is present between from and to of user_data
	
	Put these details in user eval tcd src and copy the same to user eval tcd. These two table now contain all tcode for the user under consideration for which object is S-TCODE and field is TCD*/

       /*Getting a count into an internediate table on intersection of the tcd-tcd rules and user_data*/
    create table user_eval_tcd_src select distinct c.tcode from conf_tcode c, user_data u where u.objct='S_TCODE' and u.field='TCD' and c.tcode between u.`from` and u.`to`;
    create table user_eval_tcd select * from user_eval_tcd_src limit 0;
    create index idx_uets on user_eval_tcd_src(tcode);
    create index idx_uet on user_eval_tcd(tcode);

    /*Analysis step 1: Identify the tcodes that are not in TSTCA and USOBX_C*/
	/* because in role build we segregated those tcode which are neither is TSTCA and USOBX into conflcts values notcd 
	Now, trasfrring tcode to user_tcode for the user under consideration from joining conflcits value notcd table with user eval tcd src*/
    insert into user_tcode select distinct unam, n.tcode from conflicts_values_notcd n, user_eval_tcd_src c where c.tcode=n.tcode;
    delete c from user_eval_tcd_src c, conflicts_values_notcd n where c.tcode=n.tcode;

    /*Root Cause for NOTCD condition inserted in table ROOT_CAUSE
	
	
	*/
    IF VAR_RCA=0 THEN
        INSERT INTO ROOT_CAUSE SELECT DISTINCT U.UNAME, U.TCODE, D.AGR_NAME, D.OBJCT, D.AUTH, D.FIELD, REPLACE(D.FROM,'%','*'), REPLACE(D.TO,'__%','*')
        FROM USER_TCODE U, USER_DATA D, CONFLICTS_VALUES_NOTCD N
        WHERE U.UNAME = UNAM AND U.TCODE=N.TCODE AND D.OBJCT = 'S_TCODE' AND D.FIELD = 'TCD' AND N.TCODE BETWEEN D.FROM AND D.TO;
    end if;

    insert into user_eval_tcd select * from user_eval_tcd_src;


    /*Checking TSTCA requirements where value is not blank*/
    insert into cva select distinct t.tcode,count(distinct a.value) 'Count' from user_data u, conflicts_values_a a, user_eval_tcd t where a.tcode=t.tcode and u.objct=a.objct and u.field = a.field and u.from <> '' and u.from is not null and a.value between u.from and u.to group by tcode;
        /*No longer required as view access is eliminated from role definition itself
        insert into cva_view select distinct c.tcode, u.objct from user_data u, conflicts_values_a c, user_eval_tcd t where c.tcode=t.tcode and u.objct=c.objct and u.field = 'ACTVT';
        insert into cva_view_filter select distinct c.tcode from user_data u, cva_view c where u.objct=c.objct and u.field = 'ACTVT' and (('03' not between u.from and u.to and '08' not between u.from and u.to and u.from <> '' and u.from is not null) or u.from= '%');
        delete c from cva_view c, cva_view_filter f where c.tcode=f.tcode;
        delete c from cva c, cva_view v where c.tcode=v.tcode;*/
        insert into cva_tcode select distinct c.tcode from cva c, cva_cnt t where c.tcode=t.tcode and c.count=t.count;
        /* The following three queries are replaced to do away with not in
        insert into user_tcode select distinct unam, tcode from cva_tcode where tcode not in (select distinct tcode from conflicts_values_bl);*/
        insert into user_tcode select distinct unam, c.tcode from cva_tcode c left outer join conflicts_values_bl b on c.tcode=b.tcode where b.tcode is null;
        delete u from user_eval_tcd u, cva_tcode c where c.tcode = u.tcode and c.tcode not in (select distinct tcode from conflicts_values_bl);
        delete u from user_eval_tcd u, conflicts_values_a c where c.tcode = u.tcode and c.tcode not in (select distinct tcode from cva_tcode);
        /*delete u from user_eval_tcd u, cva_tcode c left outer join conflicts_values_bl b on c.tcode=b.tcode where c.tcode = u.tcode and b.tcode is null;
        delete u from user_eval_tcd u, conflicts_values_a c left outer join cva_tcode t on c.tcode=t.tcode where c.tcode = u.tcode and t.tcode is null;*/

        IF VAR_RCA=0 THEN
            INSERT INTO ROOT_CAUSE SELECT DISTINCT U.UNAME, U.TCODE, D.AGR_NAME, D.OBJCT, D.AUTH, D.FIELD, REPLACE(D.FROM,'%','*'), REPLACE(D.TO,'__%','*')
            FROM USER_TCODE U, USER_DATA D, CONFLICTS_VALUES_A C
            WHERE U.UNAME = UNAM AND U.TCODE=C.TCODE AND D.FROM <>'' AND D.FROM IS NOT NULL AND D.OBJCT = C.OBJCT AND D.FIELD = C.FIELD AND C.VALUE BETWEEN D.FROM AND D.TO;

            INSERT INTO ROOT_CAUSE SELECT DISTINCT U.UNAME, U.TCODE, D.AGR_NAME, D.OBJCT, D.AUTH, D.FIELD, REPLACE(D.FROM,'%','*'), REPLACE(D.TO,'__%','*')
            FROM USER_TCODE U, USER_DATA D, CONFLICTS_VALUES_A C
            WHERE U.UNAME = UNAM AND U.TCODE=C.TCODE AND D.OBJCT = 'S_TCODE' AND D.FIELD = 'TCD' AND U.TCODE BETWEEN D.FROM AND D.TO;
        end if;

    /*The queries below remove from role_data table the objects (by auth) that have only view access as determined
    after comparison with the table ACT_VAL where field EXCL is set as 1.*/
    drop table if exists ud_act;
    drop table if exists ud_act_cnt;
    drop table if exists ud_act_verify;
    create table ud_act_cnt select distinct auth,agr_name, objct from user_data where field='actvt';
    create table ud_act select * from user_data where field='actvt';
    create index idx_uac on ud_act_cnt(auth,agr_name,objct);
    create index idx_uac on ud_act(auth,agr_name,objct,field,`from`,`to`);
    delete r from ud_act r, act_val a where a.val = r.from and a.excl=1;
    create table ud_act_verify select r.auth,r.agr_name,r.objct,a.objct null_obj from ud_act_cnt r left join ud_act a on r.auth=a.auth and r.agr_name=a.agr_name and r.objct=a.objct where a.objct is null;
    create index idx_uav on ud_act_verify(auth,agr_name,objct,null_obj);
    delete r from user_data r inner join ud_act_verify v on r.agr_name=v.agr_name and r.auth=v.auth and r.objct=v.objct;
    delete u from user_data u, act_val a where u.field='actvt' and u.from=a.val and a.excl=1;

        /*Additional Checking where value is blank*/
        insert into cvb select c.tcode,count(distinct u.objct,u.field) 'Count' from user_data u, conflicts_values_bl c, user_eval_tcd t where c.tcode=t.tcode and u.objct=c.objct and u.field=c.field group by tcode;
        /*No longer required as view access is eliminated from role definition itself
        insert into cvb_view select distinct c.tcode, u.objct from user_data u, conflicts_values_bl c, user_eval_tcd t where c.tcode=t.tcode and u.objct=c.objct and u.field = 'ACTVT';
        insert into cvb_view_filter select distinct c.tcode from user_data u , cvb_view c where u.objct=c.objct and u.field = 'ACTVT' and (('03' not between u.from and u.to and '08' not between u.from and u.to and u.from <> '' and u.from is not null) or u.from= '%');
        delete c from cvb_view c, cvb_view_filter f where c.tcode=f.tcode;
        delete c from cvb c, cvb_view v where c.tcode=v.tcode;*/
        insert into cvb_tcode select distinct b.tcode from cvb_cnt b, cvb c where c.tcode=b.tcode and c.count=b.count;
        insert into user_tcode select distinct unam, c.tcode from user_eval_tcd u, cvb_tcode c where u.tcode=c.tcode;
	      delete u from user_eval_tcd u, cvb_tcode c where u.tcode=c.tcode;

        IF VAR_RCA=0 THEN
            INSERT INTO ROOT_CAUSE SELECT DISTINCT U.UNAME, U.TCODE, D.AGR_NAME, D.OBJCT, D.AUTH, D.FIELD, REPLACE(D.FROM,'%','*'), REPLACE(D.TO,'__%','*')
            FROM USER_TCODE U, USER_DATA D, CONFLICTS_VALUES_BL C
            WHERE U.UNAME = UNAM AND U.TCODE=C.TCODE AND D.OBJCT = C.OBJCT AND D.FIELD = C.FIELD AND d.from <> '' and d.from is not null;

            INSERT INTO ROOT_CAUSE SELECT DISTINCT U.UNAME, U.TCODE, D.AGR_NAME, D.OBJCT, D.AUTH, D.FIELD, REPLACE(D.FROM,'%','*'), REPLACE(D.TO,'__%','*')
            FROM USER_TCODE U, USER_DATA D, CONFLICTS_VALUES_BL C
            WHERE U.UNAME = UNAM AND U.TCODE=C.TCODE AND D.OBJCT = 'S_TCODE' AND D.FIELD = 'TCD' AND U.TCODE BETWEEN D.FROM AND D.TO;
        end if;

        /*This additional insert statement is to take care of the tcodes where part entry is in table CONFLICTS_VALUES_A and
        part entry in table CONFLICTS_VALUES_BL. The query below inserts the lines in CONFLICTS_VALUES_A in table ROOT_VAUSE
        which would otherwise be missed out.*/
        IF VAR_RCA=0 THEN
            INSERT INTO ROOT_CAUSE SELECT DISTINCT U.UNAME, U.TCODE, D.AGR_NAME, D.OBJCT, D.AUTH, D.FIELD, REPLACE(D.FROM,'%','*'), REPLACE(D.TO,'__%','*')
            FROM USER_TCODE U, USER_DATA D, CONFLICTS_VALUES_BL C, CONFLICTS_VALUES_A A
            WHERE U.UNAME = UNAM AND U.TCODE=C.TCODE AND C.TCODE = A.TCODE AND D.OBJCT = A.OBJCT AND D.FIELD = A.FIELD AND A.VALUE BETWEEN D.FROM AND D.TO AND d.from <> '' and d.from is not null;

            INSERT INTO ROOT_CAUSE SELECT DISTINCT U.UNAME, U.TCODE, D.AGR_NAME, D.OBJCT, D.AUTH, D.FIELD, REPLACE(D.FROM,'%','*'), REPLACE(D.TO,'__%','*')
            FROM USER_TCODE U, USER_DATA D, CONFLICTS_VALUES_BL C, CONFLICTS_VALUES_A A
            WHERE U.UNAME = UNAM AND U.TCODE=C.TCODE AND C.TCODE = A.TCODE AND D.OBJCT = 'S_TCODE' AND D.FIELD = 'TCD' AND A.TCODE BETWEEN D.FROM AND D.TO;
        end if;

        /*Tcodes not found in TSTCA checked through USOBX_C*/
        insert into cvf select distinct lb.tcode,count(distinct u.objct) 'count' from user_data u, conflicts_values_flbl lb, user_eval_tcd t where lb.tcode=t.tcode and u.objct=lb.objct group by tcode;
        /*No longer required as view access is eliminated from role definition itself
        insert into cvf_view select distinct c.tcode, u.objct from user_data u, conflicts_values_flbl c, user_eval_tcd t where c.tcode=t.tcode and u.objct=c.objct and u.field = 'ACTVT';
        insert into cvf_view_filter select distinct c.tcode, c.objct from user_data u, cvf_view c where u.objct=c.objct and u.field = 'ACTVT' and (('03' not between u.from and u.to and '08' not between u.from and u.to and u.from <>'' and u.from is not null) or u.from= '%');
        delete c from cvf_view c, cvf_view_filter f where c.tcode=f.tcode;
        delete c from cvf c, cvf_view v where c.tcode=v.tcode;*/
        /* The query below checks if ALL the check / maintain objects are present in user access. However, as per original understanding, ANY condition was to be incorporated. Hence this statement is not to be executed.
	      create table cvf_tcode select distinct c.tcode from cvf_cnt f, cvf c where f.tcode=c.tcode and f.count=c.count;*/
        /* The query below has been suitably modified to consider above situation by removing reference to cvf_tcode and giving reference to table cvf instead.
      	insert into user_tcode select distinct unam, u.tcode from user_eval_tcd u, cvf_tcode c where u.tcode=c.tcode;*/
      	insert into user_tcode select distinct unam, u.tcode from user_eval_tcd u, cvf c where u.tcode=c.tcode;
        delete u from user_eval_tcd u, cvf c where u.tcode=c.tcode;

        IF VAR_RCA=0 THEN
            INSERT INTO ROOT_CAUSE SELECT DISTINCT U.UNAME, U.TCODE, D.AGR_NAME, D.OBJCT, D.AUTH, D.FIELD, REPLACE(D.FROM,'%','*'), REPLACE(D.TO,'__%','*')
            FROM USER_TCODE U, USER_DATA D, CONFLICTS_VALUES_FLBL C
            WHERE U.UNAME = UNAM AND U.TCODE=C.TCODE AND C.OBJCT = D.OBJCT AND d.from <> '' and d.from is not null;

            INSERT INTO ROOT_CAUSE SELECT DISTINCT U.UNAME, U.TCODE, D.AGR_NAME, D.OBJCT, D.AUTH, D.FIELD, REPLACE(D.FROM,'%','*'), REPLACE(D.TO,'__%','*')
            FROM USER_TCODE U, USER_DATA D, CONFLICTS_VALUES_FLBL C
            WHERE U.UNAME = UNAM AND U.TCODE=C.TCODE AND D.OBJCT='S_TCODE' AND D.FIELD='TCD' AND U.TCODE BETWEEN D.FROM AND D.TO;
        end if;

        TRUNCATE cva;
        TRUNCATE cva_tcode;
        TRUNCATE cvb;
        TRUNCATE cvb_tcode;
        TRUNCATE cvf;
        TRUNCATE user_eval_tcd;

    /*Updating user access to tcodes*/
    drop table if exists user_tcode_temp;
    create table user_tcode_temp select distinct * from user_tcode where uname=unam;
    delete from user_tcode where uname=unam;
    insert into user_tcode select * from user_tcode_temp;
    drop table if exists user_tcode_temp;

    /*Temp Fix - To be removed*/
    CREATE TABLE IF NOT EXISTS  `conflicts_exceptions` (
      `TCODE` varchar(45) DEFAULT NULL,
      `OBJCT` varchar(10) DEFAULT NULL,
      `FIELD` varchar(10) DEFAULT NULL,
      `VALUE` varchar(45) DEFAULT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    CREATE TABLE IF NOT EXISTS `conflicts_Add_checks` (
      `TCODE` varchar(45) DEFAULT NULL,
      `OBJCT` varchar(10) DEFAULT NULL,
      `FIELD` varchar(10) DEFAULT NULL,
      `VALUE` varchar(45) DEFAULT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


    select count(distinct u.tcode) into var_ce from user_tcode u inner join conflicts_exceptions c on u.tcode=c.tcode where u.uname=unam;
    select count(distinct u.tcode) into var_cac from user_tcode u inner join conflicts_Add_checks c on u.tcode=c.tcode where u.uname=unam;

    if var_ce>0 then

      /*Removing Exceptions to Access*/
      drop table if exists user_confexp;
      drop table if exists user_confexp_compare;
      drop table if exists uconfexp_auth;
      create table user_confexp select distinct t.tcode,u.auth,u.objct,u.field,`from`,`to` from user_data u inner join conflicts_exceptions c on u.objct=c.objct and u.field=c.field inner join user_tcode t on t.tcode=c.tcode where t.uname=unam;
      create table user_confexp_compare select * from user_confexp;
      create index idx_uc on user_confexp(tcode,auth,objct,field,`from`,`to`);
      create index idx_ucc on user_confexp_compare(tcode,auth,objct,field,`from`,`to`);
      delete u from user_confexp u inner join conflicts_exceptions c on u.tcode=c.tcode and u.objct=c.objct and u.field=c.field where c.value=u.from and c.value=u.to;
      drop table if exists utcode_exp;
      create table utcode_exp select u.tcode from user_tcode u inner join conflicts_exceptions c on u.tcode=c.tcode where u.uname=unam and u.tcode not in (select distinct tcode from user_confexp);
      create index idx_ue on utcode_exp(tcode);
      delete u from user_tcode u inner join utcode_exp e on u.tcode=e.tcode where u.uname=unam;
      create table uconfexp_auth select u.tcode,u.auth,u.objct,u.field,c.field null_field from user_confexp_compare u left outer join user_confexp c on u.tcode=c.tcode and u.auth=c.auth and u.objct=c.objct and u.field=c.field where c.field is null;
      create index idx_ua on uconfexp_auth(tcode,auth,objct,field,null_field);
      delete r from root_cause r inner join uconfexp_auth u on r.uname=unam and r.tcode=u.tcode and r.auth=u.auth;
      drop table if exists user_confexp;
      drop table if exists utcode_exp;
      drop table if exists uconfexp_auth;
      drop table if exists user_confexp_compare;

    end if;

    if var_cac>0 then
      /*Perforning additional checks*/
      /*drop table if exists uc_cnt;
      drop table if exists user_confexp;
      drop table if exists utcode_exp;
      create table uc_cnt select tcode, count(*) cnt from conflicts_add_checks group by tcode;
      create table user_confexp select t.tcode, count(distinct q.objct,q.field) cnt from user_tcode t left join (select c.tcode,u.objct,u.field from conflicts_Add_checks c inner join user_data u on u.objct=c.objct and u.field=c.field and c.value between u.from and u.to) q on t.tcode=q.tcode inner join (select distinct tcode from conflicts_add_checks) c on t.tcode=c.tcode where t.uname=unam group by tcode;
      create index idx_uc on user_confexp(tcode);
      create table utcode_exp select distinct u.tcode from user_confexp u inner join uc_cnt c on u.tcode=c.tcode where u.cnt=c.cnt;
      create index idx_ue on utcode_exp(tcode);
      delete u from user_confexp u inner join utcode_exp c on u.tcode=c.tcode;
      delete u from user_tcode u inner join user_confexp e on u.tcode=e.tcode where uname=unam;
      drop table if exists user_confexp;
      drop table if exists utcode_exp;*/

      drop table if exists uc_cnt;
      drop table if exists user_confexp;
      drop table if exists utcode_exp;
      create table uc_cnt select tcode, count(*) cnt from conflicts_add_checks group by tcode;
      create index idx_uc on uc_cnt(tcode,cnt);
      create table user_confexp select t.tcode, count(distinct q.objct,q.field,q.value) cnt from user_tcode t left join (select distinct c.tcode,u.objct,u.field,c.value from conflicts_Add_checks c inner join user_data u on u.objct=c.objct and u.field=c.field and c.value between u.from and u.to) q on t.tcode=q.tcode inner join (select distinct tcode from conflicts_add_checks) c on t.tcode=c.tcode where t.uname=unam group by tcode;
      create index idx_uc on user_confexp(tcode,cnt);
      delete u from UC_CNT u inner join user_confexp c on u.tcode=c.tcode AND U.CNT=C.CNT;
      delete u from user_tcode u inner join uc_cnt e on u.tcode=e.tcode where uname=unam;
      drop table if exists user_confexp;
      drop table if exists utcode_exp;

      /*Removing objects from root_cause where they do not provide access to specified checks*/
      drop table if exists uconf_compare;
      drop table if exists utcode_exp;
      drop table if exists user_confexp;
      create table user_confexp select r.auth,r.agr_name,r.objct from (select * from root_cause where uname=unam) r inner join conflicts_add_checks c on r.tcode=c.tcode and r.objct=c.objct and r.field=c.field;
      create index idx_uc on user_confexp(auth,agr_name,objct);
      create table utcode_exp select r.auth,r.agr_name,r.objct from (select * from root_cause where uname=unam) r inner join conflicts_add_checks c on r.tcode=c.tcode and r.objct=c.objct and r.field=c.field where c.value between r.from and r.to;
      create index idx_ue on utcode_exp(auth,agr_name,objct);
      create table uconf_compare select u.auth,u.agr_name,u.objct,e.objct null_obj from user_confexp u left outer join utcode_exp e on u.auth=e.auth and u.agr_name=e.agr_name and u.objct=e.objct where e.objct is null;
      create index idx_uc on uconf_compare(auth,agr_name,objct);
      delete r from root_cause r inner join uconf_compare u on r.auth=u.auth and r.agr_name=u.agr_name and r.objct=u.objct where r.uname=unam;
      drop table if exists uconf_compare;
      drop table if exists utcode_exp;
      drop table if exists user_confexp;
    end if;


    /*After access to tcodes is assessed, conflicts are put in table uconflicts_all*/
    drop table if exists conflicts_temp;
    create table conflicts_temp select distinct c.conflictid, count(distinct u.tcode) `Count` from user_tcode u, conflicts_c c where u.uname=unam and c.value=u.tcode group by c.conflictid;
    create index idx_ct on conflicts_temp(conflictid);
    insert into uconflicts_all select distinct unam, f.conflictid from conflicts_temp c,conflicts_first_cnt f where c.conflictid=f.conflictid and c.count=f.count;
    drop table if exists conflicts_temp;

    IF VAR_RCA=0 THEN
        DROP TABLE IF EXISTS TMP_FIELD;
        CREATE TABLE TMP_FIELD SELECT DISTINCT T.TCODE,T.OBJCT,T.FIELD FROM USER_TCODE U, TMP_TCODE_FIELD T WHERE U.UNAME=UNAM AND U.TCODE=T.TCODE;
        CREATE INDEX IDX_TF ON TMP_FIELD(TCODE,OBJCT,`FIELD`);

        INSERT INTO ROOT_CAUSE_ORG SELECT DISTINCT unam, T.TCODE, D.AGR_NAME, D.OBJCT,D.AUTH, D.FIELD, D.FROM, D.TO
        FROM TMP_FIELD T, USER_DATA D
        WHERE D.FROM <> '' AND D.FROM IS NOT NULL AND T.OBJCT=D.OBJCT AND T.FIELD=D.FIELD;

    end if;

    drop table if exists user_eval_tcd;
    drop table if exists user_eval_tcd_src;
    
	/* added user_data_2 on 13/01 by hammad */	
	insert into user_data_2 select * from user_data ;
	
	delete from user_data;
    insert into ucompleted values(unam,current_timestamp(), 0);

    drop table if exists user_other_tcodes;
    create table user_other_tcodes select unam uname,t.tcode from user_data u, tstc t where u.objct='s_tcode' and field='tcd' and t.tcode between u.from and u.to;
    create index idx_uot on user_other_tcodes(uname,tcode);
    delete u from user_other_tcodes u inner join conf_tcode c where u.tcode=c.tcode;
    insert into user_tcode select distinct * from user_other_tcodes;
    create table if not exists root_cause_tcdsrc select uname,tcode,agr_name from root_cause limit 0;
    insert into root_cause select u.uname, u.tcode, d.agr_name,d.objct,d.auth,d.field,d.from,d.to from user_other_tcodes u, user_data d where d.objct='s_tcode' and d.field='tcd' and u.tcode between d.from and d.to;
    drop table if exists user_other_tcodes;

    delete from tab_user where uname = unam;
End While;

  /* === Removing False Positive in Root Cause Org Where Objects are common @author Rajiv == */
    
    drop table if exists tmp_agrname_from;
  /* === adding a index as query was taking hell lot of time */
   /* create table tmp_agrname_from select  concat(trim(agr_name),'_',trim(u.from),'_',trim(u.auth)) from user_data_2 u where objct = 'S_TCODE'; */
	create table tmp_agrname_from select  concat(trim(agr_name),'_',trim(u.from),'_',trim(u.auth)) as test from user_data_2 u where objct = 'S_TCODE';   
    CREATE INDEX IDX_TAF ON tmp_agrname_from (test);
	drop table if exists root_cause_org_bkp;
    create table root_cause_org_bkp select * from root_cause_org;
    delete from root_cause_org where concat(trim(agr_name),'_',trim(tcode),'_',trim(auth)) NOT IN (select * from tmp_agrname_from);

  /* === End Block Removing False Positive in Root Cause Org Where Objects are common @author Rajiv == */  
  

drop table if exists cva;
drop table if exists cva_view;
drop table if exists cva_tcode;
drop table if exists cvb;
drop table if exists cvb_tcode;
drop table if exists cvb_view;
drop table if exists cvb_view_filter;
drop table if exists cvf;
drop table if exists cvf_view;
drop table if exists cvf_view_filter;
drop table if exists ud_act;
drop table if exists ud_act_cnt;
drop table if exists ud_act_verify;

/*Only unique values are kept in table uconflicts_all*/
drop table conf_tcode;
drop table if exists uconflicts_temp;
create table uconflicts_temp select distinct * from uconflicts_all;
truncate table uconflicts_all;
insert into uconflicts_all select * from uconflicts_temp;
drop table if exists uconflicts_temp;

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'User Analyis', 'Preparing User Conflicts..', current_timestamp());

IF VAR_RCA=0 THEN
    DROP TABLE IF EXISTS ROOT_CAUSE_TEMP;
    CREATE TABLE ROOT_CAUSE_TEMP SELECT DISTINCT * FROM ROOT_CAUSE;
    DELETE FROM ROOT_CAUSE;
    INSERT INTO ROOT_CAUSE SELECT * FROM ROOT_CAUSE_TEMP;
    DROP TABLE IF EXISTS ROOT_CAUSE_TEMP;
    
    select count(*) into var_tblcnt from information_schema.tables where table_schema = var_mydb and table_name = 'ROOT_CAUSE';
    select count(*) into var_indcnt FROM	INFORMATION_SCHEMA.STATISTICS WHERE	table_name = 'ROOT_CAUSE' and	index_name = 'idx_RC' and table_schema=var_mydb;
    if var_tblcnt=1 and var_indcnt=0 then
        CREATE INDEX IDX_RC ON ROOT_CAUSE(UNAME,TCODE,AGR_NAME,OBJCT,FIELD,`FROM`,`TO`);
    end if;    

    DROP TABLE IF EXISTS ROOT_CAUSE_ORG_TEMP;
    CREATE TABLE ROOT_CAUSE_ORG_TEMP SELECT DISTINCT * FROM ROOT_CAUSE_ORG;
    DELETE FROM ROOT_CAUSE_ORG;
    INSERT INTO ROOT_CAUSE_ORG SELECT * FROM ROOT_CAUSE_ORG_TEMP ORDER BY UNAME, TCODE;
    DROP TABLE IF EXISTS ROOT_CAUSE_ORG_TEMP;

    select count(*) into var_indcnt FROM INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'ROOT_CAUSE_ORG' and	index_name = 'idx_RCO' and table_schema=var_mydb;
    if var_tblcnt=1 and var_indcnt=0 then
        CREATE INDEX IDX_RCO ON ROOT_CAUSE_ORG(UNAME,TCODE,AGR_NAME,OBJCT,FIELD,`FROM`,`TO`);
    end if;
END IF;

drop table if exists tmp_tcode_field;
delete from uconflicts;
insert into uconflicts select * from uconflicts_all;
insert into uconflicts_org select * from uconflicts;


if log_stat = 'ON' then
    set global general_log = 'ON';
end if;



END

