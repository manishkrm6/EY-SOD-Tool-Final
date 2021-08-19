CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_role_analysis`(var_proc varchar(1000))
BEGIN

/*This proc is updated on 01-Jul-2013 to add conflicts additional checks and exceptions for roles.*/

declare done,var_ce,var_cac,var_stat int;
declare rnam varchar(50);
declare var_auth,log_stat varchar(12);
declare var_tcode varchar(40);

declare cur_role cursor for select distinct u.agr_name from agr_users u left outer join rcompleted r on u.agr_name=r.agr_name inner join tab_user t on u.uname = t.uname where r.agr_name is null and date(u.to_dat)>=curdate() and u.agr_name not like 'PROFILE:%SAP%ALL%' and u.agr_name not like 'PROFILE:%SAP%NEW%';
declare continue handler for not found set done=1;

Select variable_value into log_stat from information_schema.global_variables where variable_name = 'General_Log';

if log_stat = 'ON' then
    set global general_log = 'OFF';
end if;

/* To restart analysis from the point where it stopped, these lines have to be removed.
    delete from role_data;
    delete from rconflicts;
    delete from rconflicts_all;
    delete from rconflicts_org;
    delete from role_tcode;
    delete from rcompleted;
*/

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Analyis', 'Removing Temporary Tables..', current_timestamp());

drop table if exists role_eval;
drop table if exists role_eval_src;
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

/*drop table if exists role_tcode;*/
/*Creating table for only enabled conflicts definition*/

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Analyis', 'Preparing Conflicts Master..', current_timestamp());

drop table if exists conflicts_c_o;
create table conflicts_c_o select * from conflicts_c;
delete c from conflicts_c c left outer join bus_proc b on left(conflictid,3)=b.proc and b.status=1 where b.proc is null ;

delete c from conflicts_c c left outer join sod_risk s on left(conflictid,6)=s.riskid and enabled=1 where riskid is null;
delete c from conflicts_c c, disabled_conflicts d where c.conflictid=d.conflictid;

/*if var_proc <> '\'%\'' then
    set @proc_query = concat('delete from conflicts_c where left(conflictid,3) not in (',var_proc,');');
    prepare q1 from @proc_query;
    execute q1;
end if;*/

/* To be enabled when var_custom is passed to role_analysis
if var_custom=1 then
    create table conf_tcode select distinct value `tcode` from conflicts_c  union select distinct tcode from critical_auth where status =1 union select distinct tcode from tstct where tcode like 'Y%' or tcode like 'Z%';
else
    create table conf_tcode select distinct value `tcode` from conflicts_c where value not like 'Y%' and value not like 'Z%'  union select distinct tcode from critical_auth where tcode like 'Y%' or tcode like 'Z%' and status=1;
end if;*/

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Analyis', 'Preparing Role TCodes..', current_timestamp());

create table conf_tcode select distinct tcode from (select distinct tcode from actcode union select distinct value `tcode` from conflicts_c union select distinct tcode from critical_auth where status = 1 union select distinct tcode from tstct where tcode like 'Y%' or tcode like 'Z%')q;
drop table if exists conf_tcode_dist;
create table conf_tcode_dist select distinct * from conf_tcode;
truncate conf_tcode;

insert into conf_tcode select * from conf_tcode_dist;
create index idx_ct on conf_tcode(tcode);
drop table if exists conf_tcode_dist;

create table if not exists role_tcode(`AGR_NAME` varchar(40),`TCODE` varchar(45)) Engine = MyISAM;
SELECT COUNT(*) INTO var_stat FROM INFORMATION_SCHEMA.STATISTICS WHERE table_name = 'role_tcode' AND index_name = 'idx_rt' AND table_schema = (select database());
IF var_stat=0 THEN
  CREATE INDEX idx_rt ON role_tcode(agr_name,tcode);
END IF;

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Analyis', 'Updating Conflicts Masters..', current_timestamp());

/*Create temporary table to store original rules so that disabled rules can be deleted from conflicts_c table*/
drop table if exists conflicts_c_orig;
create table conflicts_c_orig select * from conflicts_c;
delete c from conflicts_c c, disabled_conflicts d where c.conflictid=d.conflictid;
delete c from conflicts_c c, sod_risk s, tcode_disabled t where t.activity=s.act1 and s.riskid=left(c.conflictid,6) and  c.value=t.tcode;
delete c from conflicts_c c, sod_risk s, tcode_disabled t where t.activity=s.act2 and s.riskid=left(c.conflictid,6) and  c.value=t.tcode;
delete c from conflicts_c c, sod_risk s, tcode_disabled t where t.activity=s.act3 and s.riskid=left(c.conflictid,6) and  c.value=t.tcode;
delete c from conflicts_c c inner join (select conflictid,count(distinct value) cnt from conflicts_c group by 1 having cnt=1) q on c.conflictid=q.conflictid;

/*Following lines of code adds separate lines for field ACTVT where the orginal values of from and to are different.
This is done in order to compare the ACTVT values to the ones to be excluded as per table ACT_VAL*/
drop table if exists role_build_act;
create table role_build_act select * from role_build u where field='actvt' and u.from <>'%' and u.from<>u.to;
CREATE INDEX IDX_rba ON role_build_act(AGR_NAME,AUTH,OBJCT,FIELD,`FROM`,`TO`);
INSERT INTO role_build(agr_name,auth,objct,field,`from`,`to`) SELECT distinct AGR_NAME,AUTH,OBJCT,FIELD,VAL,VAL FROM role_build_act R, ACT_VAL A WHERE A.VAL BETWEEN R.FROM AND R.TO;
DELETE R FROM role_build R INNER JOIN role_build_act A ON R.AUTH=A.AUTH AND R.AGR_NAME=A.AGR_NAME AND R.OBJCT=A.OBJCT AND R.FIELD=A.FIELD where r.from<>r.to and r.from<> '%';
DROP TABLE role_build_act;

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Analyis', 'Creating Temporary Tables & Indexing Process..', current_timestamp());

/*Creating analysis tables*/
create table cva (`tcode` varchar(45),`Count` int(5)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_cva on cva(tcode);
create table cva_view (`tcode` varchar(45),`objct` varchar(10)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_ca on cva_view(tcode,objct);
create table cva_view_filter (`tcode` varchar(45)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_cvf on cva_view_filter(tcode);
create table cva_tcode (`tcode` varchar(45)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_ct on cva_tcode(tcode);

create table cvb (`tcode` varchar(45),`Count` int(5)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_cvb on cvb(tcode);
create table cvb_view (`tcode` varchar(45),`objct` varchar(10)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_cv on cvb_view(tcode,objct);
create table cvb_view_filter (`tcode` varchar(45)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_cvf on cvb_view_filter(tcode);
create table cvb_tcode (`tcode` varchar(45)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_ct on cvb_tcode(tcode);

create table cvf (`tcode` varchar(45),`Count` int(5)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_cvf on cvf(tcode);
create table cvf_view (`tcode` varchar(45),`objct` varchar(10)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_cv on cvf_view(tcode,objct);
create table cvf_view_filter (`tcode` varchar(45)) Engine=MyISAM DEFAULT CHARSET=utf8;
create index idx_cvf on cvf_view_filter(tcode);

open cur_role;
role_analysis:LOOP
    fetch cur_role into rnam;
    
    if done = 1 then
        leave role_analysis;
    end if;

    /* === Line ADDED By Manish Kr === */
    INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Analyis', 'Preparing Role Data..', current_timestamp());

    /*Getting authorization data pertaining to user under analysis in table role_data*/
    insert into role_data select distinct r.* from role_build r where r.agr_name=rnam;

    /*Getting a count into an internediate table on intersection of the tcd-tcd rules and role_data*/
    create table role_eval_src select distinct c.tcode from conf_tcode c, role_data u where u.objct='S_TCODE' and u.field='TCD' and c.tcode between u.`from` and u.`to`;
    create table role_eval select * from role_eval_src limit 0;
    create index idx_res on role_eval_src(tcode);
    create index idx_re on role_eval(tcode);

    /*Analyis Step 2 & later: Identify the tcodes to which user has access and delete them from control table*/
    /*open cur_auth;
    Auth_Loop:Loop
        fetch cur_auth into var_auth;
        if done = 1 then
            leave Auth_Loop;
        end if;*/

        insert into role_eval select * from role_eval_src;
        /*Analysis step 1: Identify the tcodes that are not in TSTCA and USOBX_C*/
        insert into role_tcode select distinct rnam, n.tcode from conflicts_values_notcd n, role_eval_src c where c.tcode=n.tcode;
        delete c from role_eval_src c, conflicts_values_notcd n where n.tcode=c.tcode;

        insert into cva select distinct t.tcode,count(distinct a.value) 'Count' from role_data r, conflicts_values_a a, role_eval t where a.tcode=t.tcode and r.objct=a.objct and r.field = a.field and r.from <> '' and r.from is not null and a.value between r.from and r.to group by tcode;
        /*No longer required as view access is eliminated from role definition itself
        insert into cva_view select distinct c.tcode, u.objct from role_data u, conflicts_values_a c, role_eval t where c.tcode=t.tcode and u.objct=c.objct and u.field = 'ACTVT';
        insert into cva_view_filter select distinct c.tcode from role_data u, cva_view c where u.objct=c.objct and u.field = 'ACTVT' and (('03' not between u.from and u.to and '08' not between u.from and u.to and u.from <> '' and u.from is not null) or u.from= '%');
        delete c from cva_view c, cva_view_filter f where c.tcode=f.tcode;
        delete c from cva c, cva_view v where c.tcode=v.tcode;*/
        insert into cva_tcode select distinct c.tcode from cva c, cva_cnt t where c.tcode=t.tcode and c.count=t.count;
        insert into role_tcode select distinct rnam, c.tcode from cva_tcode c left outer join conflicts_values_bl b on c.tcode=b.tcode where b.tcode is null;
        /* The queries below are replace by left join null syntax
        delete r from role_eval r, cva_tcode c where c.tcode = r.tcode and c.tcode not in (select distinct tcode from conflicts_values_bl);
        delete r from role_eval r, conflicts_values_a c where c.tcode = r.tcode and c.tcode not in (select distinct tcode from cva_tcode);*/
        delete r from role_eval r, cva_tcode c left outer join conflicts_values_bl b on c.tcode=b.tcode where r.tcode = c.tcode and b.tcode is null;
        delete r from role_eval r, conflicts_values_a c left outer join cva_tcode t on c.tcode=t.tcode where c.tcode = r.tcode and t.tcode is null;

    /*The queries below remove from role_data table the objects (by auth) that have only view access as determined
    after comparison with the table ACT_VAL where field EXCL is set as 1.*/
    drop table if exists rd_act;
    drop table if exists rd_act_cnt;
    drop table if exists rd_act_verify;
    create table rd_act_cnt select distinct auth,agr_name, objct from role_data where field='actvt';
    create table rd_act select * from role_data where field='actvt';
    create index idx_rac on rd_act_cnt(auth,agr_name,objct);
    create index idx_rac on rd_act(auth,agr_name,objct,field,`from`,`to`);
    delete r from rd_act r, act_val a where a.val = r.from and a.excl=1;
    create table rd_act_verify select r.auth,r.agr_name,r.objct,a.objct null_obj from rd_act_cnt r left join rd_act a on r.auth=a.auth and r.agr_name=a.agr_name and r.objct=a.objct where a.objct is null;
    create index idx_rav on rd_act_verify(auth,agr_name,objct,null_obj);
    delete r from role_data r inner join rd_act_verify v on r.agr_name=v.agr_name and r.auth=v.auth and r.objct=v.objct;
    delete from role_data where `from`='' and `to`='';
    delete u from role_data u, act_val a where u.field='actvt' and u.from=a.val and a.excl=1;
    drop table if exists rd_act;
    drop table if exists rd_act_cnt;
    drop table if exists rd_act_verify;

        insert into cvb select c.tcode,count(distinct r.objct,r.field) 'Count' from role_data r, conflicts_values_bl c, role_eval t where c.tcode=t.tcode and r.objct=c.objct and r.field=c.field group by tcode;
        /*No longer required as view access is eliminated from role definition itself
        insert into cvb_view select distinct c.tcode, u.objct from role_data u, conflicts_values_bl c, role_eval t where c.tcode=t.tcode and u.objct=c.objct and u.field = 'ACTVT';
        insert into cvb_view_filter select distinct c.tcode from role_data u, cvb_view c where u.objct=c.objct and u.field = 'ACTVT' and (('03' not between u.from and u.to and '08' not between u.from and u.to and U.FROM <>'' AND U.FROM IS NOT NULL) or u.from= '%');
        delete c from cvb_view c, cvb_view_filter f where c.tcode=f.tcode;
        delete c from cvb c, cvb_view v where c.tcode=v.tcode;*/
        insert into cvb_tcode select distinct b.tcode from cvb_cnt b, cvb c where c.tcode=b.tcode and c.count=b.count;
        insert into role_tcode select distinct rnam, c.tcode from role_eval r, cvb_tcode c where r.tcode=c.tcode;
        delete r from role_eval r, cvb_tcode c where r.tcode=c.tcode;

        insert into cvf select distinct lb.tcode,count(distinct r.objct) 'count' from role_data r, conflicts_values_flbl lb, role_eval t where lb.tcode=t.tcode and r.objct=lb.objct group by tcode having count(distinct r.objct)>0;
        /*No longer required as view access is eliminated from role definition itself
        insert into cvf_view select distinct c.tcode, u.objct from role_data u, conflicts_values_flbl c, role_eval t where c.tcode=t.tcode and u.objct=c.objct and u.field = 'ACTVT';
        insert into cvf_view_filter select distinct c.tcode from role_data u, cvf_view c, role_eval t where c.tcode=t.tcode and u.objct=c.objct and u.field = 'ACTVT' and (('03' not between u.from and u.to and '08' not between u.from and u.to and U.FROM <> '' AND U.FROM IS NOT NULL) or u.from= '%');
        delete c from cvf_view c, cvf_view_filter f where c.tcode=f.tcode;
        delete c from cvf c, cvf_view v where c.tcode=v.tcode;*/
        /* The query below checks if ALL the check / maintain objects are present in user access. However, as per original understanding, ANY condition was to be incorporated. Hence this statement is not to be executed.
        create table cvf_tcode select distinct c.tcode from cvf c, cvf_cnt t where c.tcode=t.tcode and c.count=t.count;*/
        /* The query below has been suitably modified to consider above situation by removing reference to cvf_tcode and giving reference to table cvf instead.
        insert into role_tcode select distinct rnam, r.tcode from role_eval r, cvf_tcode c where r.tcode=c.tcode;*/
        insert into role_tcode select distinct rnam, r.tcode from role_eval r, cvf c where r.tcode=c.tcode;
        delete r from role_eval r, cvf c where r.tcode=c.tcode;

        truncate cva;
        truncate cva_view;
        truncate cva_tcode;
        truncate cvb;
        truncate cvb_tcode;
        truncate cvb_view;
        truncate cvb_view_filter;
        truncate cvf;
        truncate cvf_view;
        truncate cvf_view_filter;
        truncate role_eval;

    /*end Loop;
    close cur_auth;

    set done = 0;*/

    /* === Line ADDED By Manish Kr === */
    INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Analyis', 'Preparing Conflicts Exception..', current_timestamp());

    /*Updating role access to tcodes*/
    drop table if exists role_tcode_temp;
    create table role_tcode_temp select distinct * from role_tcode where agr_name=rnam;
    delete from role_tcode where agr_name=rnam;
    insert into role_tcode select * from role_tcode_temp;
    drop table if exists role_tcode_temp;

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


    /* === Line ADDED By Manish Kr === */
    INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Analyis', 'Preparing RCompleted..', current_timestamp());

    select count(distinct u.tcode) into var_ce from role_tcode u inner join conflicts_exceptions c on u.tcode=c.tcode where u.agr_name=rnam;
    select count(distinct u.tcode) into var_cac from role_tcode u inner join conflicts_Add_checks c on u.tcode=c.tcode where u.agr_name=rnam;

    if var_ce>0 then
      /*Removing Exceptions to Access*/
      drop table if exists role_confexp;
      drop table if exists role_confexp_compare;
      drop table if exists rconfexp_auth;
      create table role_confexp select distinct t.tcode,u.auth,u.objct,u.field,`from`,`to` from role_data u inner join conflicts_exceptions c on u.objct=c.objct and u.field=c.field inner join role_tcode t on t.tcode=c.tcode where t.agr_name=rnam;
      create table role_confexp_compare select * from role_confexp;
      create index idx_rc on role_confexp(tcode,auth,objct,field,`from`,`to`);
      create index idx_rcc on role_confexp_compare(tcode,auth,objct,field,`from`,`to`);
      delete u from role_confexp u inner join conflicts_exceptions c on u.tcode=c.tcode and u.objct=c.objct and u.field=c.field where c.value=u.from and c.value=u.to;
      drop table if exists rtcode_exp;
      create table rtcode_exp select u.tcode from role_tcode u inner join conflicts_exceptions c on u.tcode=c.tcode where u.agr_name=rnam and u.tcode not in (select distinct tcode from role_confexp);
      create index idx_re on rtcode_exp(tcode);
      delete u from role_tcode u inner join rtcode_exp e on u.tcode=e.tcode where u.agr_name=rnam;
      drop table if exists role_confexp;
      drop table if exists rtcode_exp;
      drop table if exists role_confexp_compare;
    end if;

    if var_cac>0 then
      drop table if exists rc_cnt;
      drop table if exists role_confexp;
      drop table if exists rtcode_exp;
      create table rc_cnt select tcode, count(*) cnt from conflicts_add_checks group by tcode;
      create index idx_rc on rc_cnt(tcode,cnt);
      create table role_confexp select t.tcode, count(distinct q.objct,q.field,q.value) cnt from role_tcode t left join (select distinct c.tcode,u.objct,u.field,c.value from conflicts_Add_checks c inner join role_data u on u.objct=c.objct and u.field=c.field and c.value between u.from and u.to) q on t.tcode=q.tcode inner join (select distinct tcode from conflicts_add_checks) c on t.tcode=c.tcode where t.agr_name=rnam group by tcode;
      create index idx_rc on role_confexp(tcode,cnt);
      delete u from rC_CNT u inner join role_confexp c on u.tcode=c.tcode AND U.CNT=C.CNT;
      delete u from role_tcode u inner join rc_cnt e on u.tcode=e.tcode where agr_name=rnam;
      drop table if exists role_confexp;
      drop table if exists rtcode_exp;
    end if;

    drop table if exists conflicts_temp;
    create table conflicts_temp select distinct c.conflictid, count(distinct r.tcode) `Count` from role_tcode r, conflicts_c c where r.agr_name = rnam and c.value=r.tcode group by c.conflictid;
    create index idx_ct on conflicts_temp(conflictid);
    insert into rconflicts_all select distinct rnam, f.conflictid from conflicts_temp c,conflicts_first_cnt f where c.conflictid=f.conflictid and c.count=f.count;
    drop table if exists conflicts_temp;

    drop table if exists role_eval;
    drop table if exists role_eval_src;
    delete from role_data;
    insert into rcompleted values(rnam,current_timestamp(),0);

End Loop;
close cur_role;
set done=0;

drop table conf_tcode;

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Analyis', 'Extracting Role Conflicts..', current_timestamp());

drop table if exists rconflicts_temp;
create table rconflicts_temp select distinct * from rconflicts_all;
truncate rconflicts_all;
insert into rconflicts_all select * from rconflicts_temp;
drop table rconflicts_temp;

delete from rconflicts;
insert into rconflicts select * from rconflicts_all;
insert into rconflicts_org select * from rconflicts;

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Analyis', 'Removing Temporary Tables after Analyzing Roles..', current_timestamp());

/*Disposing off analysis tables*/
drop table if exists cva;
drop table if exists cva_view;
drop table if exists cva_view_filter;
drop table if exists cva_tcode;
drop table if exists cvb;
drop table if exists cvb_tcode;
drop table if exists cvb_view;
drop table if exists cvb_view_filter;
drop table if exists cvf;
drop table if exists cvf_view;
drop table if exists cvf_view_filter;

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Role Analyis', 'Role Analyis Done..', current_timestamp());


if log_stat = 'ON' then
    set global general_log = 'ON';
end if;


END 
