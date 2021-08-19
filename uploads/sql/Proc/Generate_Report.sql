
-- DROP PROCEDURE IF EXISTS `Generate_report`;

CREATE DEFINER=`root`@`localhost` PROCEDURE `Generate_report`(var_mydb varchar(100))
BEGIN

/*Proc Modified on 18-May-2013 to extend report for Org element access to additional objects*/

DECLARE  column_name VARCHAR(200);
DECLARE  column_val, var_rco_update, var_roa_update INT;
DECLARE  total, mit_ex, mit_idx_ex INT;
declare  temp_val varchar(50);
declare var_client varchar(200);
declare done int default 0;
declare i int default 0;
declare j int default 0;
declare var_analysis_date date;
declare var_org, var_tbl,var_fld,var_org_fld varchar(50);
declare cnt,var_idx int;

declare cur_org cursor for select distinct r.field org, replace(replace(o.dsc,' ','_'),'/','') dsc from (select distinct field from root_cause) r inner join org_elements o on r.field=o.element inner join (select distinct table_name from information_schema.tables where table_schema=(select database())) t on o.tbl=t.table_name order by 1;
declare cur_dashboard3 CURSOR for select b.dsc 'Business Process', count(u.conflictid) 'No. of Conflicts' from uconflicts u, bus_proc b where left(conflictid,3)=b.proc group by b.proc;
declare cur_dashboard4 CURSOR for select Department, count(distinct left(conflictid,6)) 'No. of Users' from uconflicts c, user_details u where c.uname=u.uname and u.department like '%' group by u.department;
declare CONTINUE handler for not found set done=1;

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Dashboard Report', 'Preparing Dashboard Report..', current_timestamp());

/* ==== BEGIN: sap_report IS BEING USED To Prepare Dashboard Report of NEW SOD Tool @author Manish Kr ===== */ 

truncate table `sap_report`;
  
insert into sap_report set Id = 1, dashboard = 1, report_type_id = 1, column_name = 'total_user_anlaysed', column_value = (select count(distinct uname) as total_user_anlaysed FROM ucompleted);
insert into sap_report set Id = 2, dashboard = 2, report_type_id = 2, column_name = 'total_user_conflicts', column_value = (select count(distinct uname) as total_user_conflicts from uconflicts);
insert into sap_report set Id = 3, dashboard = 3, report_type_id = 3, column_name = 'total_role_analysed', column_value = (select count(distinct agr_name) as total_role_analysed FROM rcompleted);
insert into sap_report set Id = 4, dashboard = 4, report_type_id = 4, column_name = 'total_role_conflicts', column_value = (select count(distinct agr_name) as total_role_conflicts from rconflicts);
insert into sap_report set Id = 5, dashboard = 5, report_type_id = 5, column_name = 'total_risk_analysed', column_value = (select count(distinct riskid) as total_risk_analysed from sod_risk where enabled='1');
insert into sap_report set Id = 6, dashboard = 6, report_type_id = 6, column_name = 'total_risk_violated', column_value = (select count(distinct left(conflictid,6)) as total_risk_violated from uconflicts);
insert into sap_report set Id = 7, dashboard = 7, report_type_id = 7, column_name = 'total_conflicts', column_value = (select count(conflictid) as total_conflicts from uconflicts);

/* ==== PIE Chart ===*/
insert into sap_report set Id = 8, dashboard = 8, report_type_id = 8, column_name = 'high_risk', column_value = (select count(left(conflictid,6)) 'high_risk' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high');
insert into sap_report set Id = 9, dashboard = 9, report_type_id = 9, column_name = 'medium_risk', column_value = (select count(left(conflictid,6)) 'medium_risk' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium');
insert into sap_report set Id = 10, dashboard = 10, report_type_id = 10, column_name = 'low_risk', column_value = (select count(left(conflictid,6)) 'low_risk' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low');

/* ==== Intra High, Medium, Low ==== */

insert into sap_report set Id = 11, dashboard = 11, report_type_id = 11, column_name = 'intra_high_risk', column_value = (select count(left(conflictid,6)) 'intra_high_risk' from rconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='High');
insert into sap_report set Id = 12, dashboard = 12, report_type_id = 12, column_name = 'intra_medium_risk', column_value = (select count(left(conflictid,6)) 'intra_medium_risk' from rconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='Medium');
insert into sap_report set Id = 13, dashboard = 13, report_type_id = 13, column_name = 'intra_low_risk', column_value = (select count(left(conflictid,6)) 'intra_low_risk' from rconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='Low');

/* ==== User With SAP ALL ==== */

insert into sap_report set Id = 14, dashboard = 14, report_type_id = 14, column_name = 'user_with_sap_all', column_value = ( select count(distinct a.uname) 'user_with_sap_all' from agr_users a inner join user_details u on a.uname=u.uname where (u.valid_to >= curdate() or u.valid_to ='00000000') and lockstatus='0' and user_type='1' and a.agr_name like 'Profile%sap%all%' or a.agr_name like 'profie%sap%new%' );

/* ==== Custom T Code ==== */
insert into sap_report set Id = 15, dashboard = 15, report_type_id = 15, column_name = 'custom_t_code', column_value = ( select count(distinct tcode) 'custom_t_code' from tstc where tcode like 'z%' or tcode like 'y%');
		

/* ==== [Bar Graph] - Risk Violated ====== */

/* High [A] */
insert into sap_report set Id = 16, dashboard = 16, report_type_id = 16, column_name = 'risk_violated_high', column_value = ( select count(distinct left(conflictid,6)) 'risk_violated_high' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' );

/* Medium [B] */
insert into sap_report set Id = 17, dashboard = 17, report_type_id = 17, column_name = 'risk_violated_medium', column_value = ( select count(distinct left(conflictid,6)) 'risk_violated_medium' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' );

/* Low [C] */
insert into sap_report set Id = 18, dashboard = 18, report_type_id = 18, column_name = 'risk_violated_low', column_value = ( select count(distinct left(conflictid,6)) 'risk_violated_low' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' );

/* Total SOD Risk  [D] */
insert into sap_report set Id = 19, dashboard = 19, report_type_id = 19, column_name = 'total_sod_risk', column_value = ( select count(distinct riskid) 'total_sod_risk' from sod_risk where enabled='1' );

/* Total U Conflicts [E] */
insert into sap_report set Id = 20, dashboard = 20, report_type_id = 20, column_name = 'total_e_risk', column_value = ( select count( distinct left(conflictid,6)) 'total_e_risk' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID );

/* MAT[High, Medium, Low] */

/* MAT[High] */
insert into sap_report set Id = 21, dashboard = 21, report_type_id = 21, column_name = 'mat_high', column_value = ( select count(left(conflictid,3)) 'mat_high' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'MAT%' );

/* MAT[Medium] */
insert into sap_report set Id = 22, dashboard = 22, report_type_id = 22, column_name = 'mat_medium', column_value = ( select count(left(conflictid,3)) 'mat_medium' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'MAT%' );

/* MAT[Low] */
insert into sap_report set Id = 23, dashboard = 23, report_type_id = 23, column_name = 'mat_low', column_value = ( select count(left(conflictid,3)) 'mat_low' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'MAT%' );

/* PRD[High, Medium, Low] */

/* PRD[High] */
insert into sap_report set Id = 24, dashboard = 24, report_type_id = 24, column_name = 'prd_high', column_value = ( select count(left(conflictid,3)) 'prd_high' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'PRD%' );

/* PRD[Medium] */
insert into sap_report set Id = 25, dashboard = 25, report_type_id = 25, column_name = 'prd_medium', column_value = ( select count(left(conflictid,3)) 'prd_medium' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'PRD%' );

/* PRD[Low] */
insert into sap_report set Id = 26, dashboard = 26, report_type_id = 26, column_name = 'prd_low', column_value = ( select count(left(conflictid,3)) 'prd_low' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'PRD%' );


/* CRM [High, Medium, Low] */

/* CRM[High] */
insert into sap_report set Id = 27, dashboard = 27, report_type_id = 27, column_name = 'crm_high', column_value = ( select count(left(conflictid,3)) 'crm_high' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'CRM%' );

/* CRM[Medium] */
insert into sap_report set Id = 28, dashboard = 28, report_type_id = 28, column_name = 'crm_medium', column_value = ( select count(left(conflictid,3)) 'crm_medium' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'CRM%' );

/* CRM[Low] */
insert into sap_report set Id = 29, dashboard = 29, report_type_id = 29, column_name = 'crm_low', column_value = ( select count(left(conflictid,3)) 'crm_low' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'CRM%' );


/* OTC [High, Medium, Low] */

/* OTC [High] */
insert into sap_report set Id = 30, dashboard = 30, report_type_id = 30, column_name = 'otc_high', column_value = ( select count(left(conflictid,3)) 'otc_high' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'OTC%' );

/* OTC[Medium] */
insert into sap_report set Id = 31, dashboard = 31, report_type_id = 31, column_name = 'otc_medium', column_value = ( select count(left(conflictid,3)) 'otc_medium' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'OTC%' );

/* OTC[Low] */
insert into sap_report set Id = 32, dashboard = 32, report_type_id = 32, column_name = 'otc_low', column_value = ( select count(left(conflictid,3)) 'otc_low' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'OTC%' );


/* PTP[High, Medium, Low] */

/* PTP[High] */
insert into sap_report set Id = 33, dashboard = 33, report_type_id = 33, column_name = 'ptp_high', column_value = ( select count(left(conflictid,3)) 'ptp_high' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'PTP%' );
/* PTP[Medium] */
insert into sap_report set Id = 34, dashboard = 34, report_type_id = 34, column_name = 'ptp_medium', column_value = ( select count(left(conflictid,3)) 'ptp_medium' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'PTP%' );
/* PTP[Low] */
insert into sap_report set Id = 35, dashboard = 35, report_type_id = 35, column_name = 'ptp_low', column_value = ( select count(left(conflictid,3)) 'ptp_low' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'PTP%' );


/* HRP [High, Medium, Low] */

/* HRP [High] */
insert into sap_report set Id = 36, dashboard = 36, report_type_id = 36, column_name = 'hrp_high', column_value = ( select count(left(conflictid,3)) 'hrp_high' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'HRP%' );

/* HRP[Medium] */
insert into sap_report set Id = 37, dashboard = 37, report_type_id = 37, column_name = 'hrp_medium', column_value = ( select count(left(conflictid,3)) 'hrp_medium' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'HRP%' );

/* HRP[Low] */
insert into sap_report set Id = 38, dashboard = 38, report_type_id = 38, column_name = 'hrp_low', column_value = ( select count(left(conflictid,3)) 'hrp_low' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'HRP%' );


/* FIN [High, Medium, Low] */

/* FIN [High] */
insert into sap_report set Id = 39, dashboard = 39, report_type_id = 39, column_name = 'fin_high', column_value = ( select count(left(conflictid,3)) 'fin_high' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'FIN%' );

/* FIN[Medium] */
insert into sap_report set Id = 40, dashboard = 40, report_type_id = 40, column_name = 'fin_medium', column_value = ( select count(left(conflictid,3)) 'fin_medium' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'FIN%' );

/* FIN[Low] */
insert into sap_report set Id = 41, dashboard = 41, report_type_id = 41, column_name = 'fin_low', column_value = ( select count(left(conflictid,3)) 'fin_low' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'FIN%' );


/* SRM [High, Medium, Low] */

/* SRM [High] */
insert into sap_report set Id = 42, dashboard = 42, report_type_id = 42, column_name = 'srm_high', column_value = ( select count(left(conflictid,3)) 'srm_high' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'SRM%' );

/* SRM[Medium] */
insert into sap_report set Id = 43, dashboard = 43, report_type_id = 43, column_name = 'srm_medium', column_value = ( select count(left(conflictid,3)) 'srm_medium' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'SRM%' );

/* SRM[Low] */
insert into sap_report set Id = 44, dashboard = 44, report_type_id = 44, column_name = 'srm_low', column_value = ( select count(left(conflictid,3)) 'srm_low' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'SRM%' );


/* BAS [High, Medium, Low] */

/* BAS [High] */
insert into sap_report set Id = 45, dashboard = 45, report_type_id = 45, column_name = 'bas_high', column_value = ( select count(left(conflictid,3)) 'bas_high' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'BAS%' );

/* BAS[Medium] */
insert into sap_report set Id = 46, dashboard = 46, report_type_id = 46, column_name = 'bas_medium', column_value = ( select count(left(conflictid,3)) 'bas_medium' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'BAS%' );

/* BAS[Low] */
insert into sap_report set Id = 47, dashboard = 47, report_type_id = 47, column_name = 'bas_low', column_value = ( select count(left(conflictid,3)) 'bas_low' from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'BAS%' );
	
	/* TRANSACTION LeveL Sod Conflicts */
	DROP TABLE IF EXISTS transaction_level_sod_conflicts;
	
	Create table transaction_level_sod_conflicts Select DISTINCT r.agr_name ROLE, r.CONFLICTID, k.riskid as RISKID, k.riskname as Risk_Description , k.rating as RISK_RATING, k.act1 as Activity1, AC.act_desc as Activity1_Description, ut.tcode1 as TCODE1, t1.desc as TCODE1_DESCRIPTION,  k.act2 as Activity2, AC2.act_desc as Activity2_description, ut.tcode2 as TCODE2, t2.desc as TCODE2_DESCRIPTION, k.act3 as Activity3, AC3.act_desc as Activity3_Description, ut.tcode3 as TCODE3, t3.desc as TCODE3_DESCRIPTION FROM rconflicts r INNER JOIN rcompleted a on r.agr_name=a.agr_name INNER JOIN SOD_RISK K ON K.RISKID=LEFT(r.CONFLICTID,6) INNER JOIN ACT_CLASS AC ON K.ACT1=AC.ACTIVITY INNER JOIN ACT_CLASS AC2 ON K.ACT2=AC2.ACTIVITY LEFT JOIN ACT_CLASS AC3 ON K.ACT3=AC3.ACTIVITY
	LEFT JOIN rconflicts_col as ut ON r.AGR_NAME=ut.AGR_NAME AND r.CONFLICTID = ut.CONFLICTID
	LEFT JOIN (SELECT t.tcode , t.desc FROM `tstct` as t group by t.tcode) as t1 ON ut.tcode1=t1.tcode
	LEFT JOIN (SELECT tx.tcode, tx.desc  FROM `tstct` as tx group by tx.tcode) as t2 ON ut.tcode2=t2.tcode
	LEFT JOIN (SELECT tx2.tcode, tx2.desc  FROM `tstct` as tx2 group by tx2.tcode) as t3 ON ut.tcode3=t3.tcode;
	
	/* Transaction Level SoD Conflicts by Users */
	DROP TABLE IF EXISTS transaction_level_sod_conflicts_by_users;
	Create table transaction_level_sod_conflicts_by_users SELECT DISTINCT a.`UNAME`, ud.user_name,BP.DSC BUSINESS_PROCESS, a.`CONFLICTID`, k.riskid, k.rating,AC.activity AS ACTIVITY1, AC.act_desc AS ACTIVITY1_DESCCRIPTION, b.TCODE1, t1.desc AS TOCODE1_DESCRIPTION, AC2.activity AS ACTIVITY2, AC2.act_desc AS ACTIVITY2_DESCCRIPTION, b.TCODE2,  t2.desc as TOCODE2_DESCRIPTION, AC3.activity AS ACTIVITY3, AC3.act_desc AS ACTIVITY3_DESCCRIPTION, b.TCODE3,  t3.desc as TOCODE3_DESCRIPTION FROM `uconflicts` as a LEFT JOIN uconflicts_col as b ON a.`UNAME`=b.UNAME and a.`CONFLICTID`=b.CONFLICTID INNER JOIN user_details as ud ON a.`UNAME`=ud.uname INNER JOIN SOD_RISK K ON K.RISKID=LEFT(a.CONFLICTID,6) INNER JOIN BUS_PROC BP ON K.BPROC=BP.PROC INNER JOIN ACT_CLASS AC ON K.ACT1=AC.ACTIVITY INNER JOIN ACT_CLASS AC2 ON K.ACT2=AC2.ACTIVITY LEFT JOIN ACT_CLASS AC3 ON K.ACT3=AC3.ACTIVITY 
	LEFT JOIN (SELECT t.tcode , t.desc FROM `tstct` as t group by t.tcode) as t1 ON b.tcode1=t1.tcode
	LEFT JOIN (SELECT tx.tcode, tx.desc  FROM `tstct` as tx group by tx.tcode) as t2 ON b.tcode2=t2.tcode
	LEFT JOIN (SELECT tx2.tcode, tx2.desc  FROM `tstct` as tx2 group by tx2.tcode) as t3 ON b.tcode3=t3.tcode;

	
	
		
		
/* ==== END: sap_report IS BEING USED To Prepare Dashboard Report of NEW SOD Tool @author Manish Kr ===== */

/*
select count(*) into mit_ex from information_schema.tables where table_schema=var_mydb and table_name in ('mit_risk','mit_conflict');
if mit_ex>0 then
    create table if not exists mit_uconflicts_r select * from uconflicts limit 0;
    create table if not exists mit_uconflicts_c select * from uconflicts limit 0;
    select count(distinct index_name) into mit_idx_ex from information_schema.statistics where table_schema=var_mydb and table_name='mit_uconflicts_r' and index_name='idx_mur';
    if mit_idx_ex = 0 then
        create index idx_mur on mit_uconflicts_r(uname,conflictid);
    end if;
    set mit_idx_ex=0;
    select count(distinct index_name) into mit_idx_ex from information_schema.statistics where table_schema=var_mydb and table_name='mit_uconflicts_c' and index_name='idx_muc';
    if mit_idx_ex = 0 then
        create index idx_muc on mit_uconflicts_c(uname,conflictid);
    end if;    
    insert into mit_uconflicts_r select distinct u.* from uconflicts u inner join mit_risk m on u.uname=m.uname and left(u.conflictid,6)=m.riskid;
    insert into mit_uconflicts_c select distinct u.* from uconflicts u inner join mit_conflict m on u.uname=m.uname and u.conflictid=m.conflictid;
    delete u from uconflicts u inner join mit_risk m on u.uname=m.uname and left(u.conflictid,6)=m.riskid;
    delete u from uconflicts u inner join mit_conflict m on u.uname=m.uname and u.conflictid=m.conflictid;
    delete u from uconflicts_all u inner join mit_uconflicts_r m on u.uname=m.uname and u.conflictid=m.conflictid;
    delete u from uconflicts_all u inner join mit_uconflicts_c m on u.uname=m.uname and u.conflictid=m.conflictid;
    delete u from uconflicts_col u inner join mit_risk m on u.uname=m.uname and left(u.conflictid,6)=m.riskid;
    delete u from uconflicts_col u inner join mit_conflict m on u.uname=m.uname and u.conflictid=m.conflictid;
    insert into uconflicts select distinct m.* from mit_uconflicts_r m where concat(m.uname,left(m.conflictid,6)) not in (select concat(mr.uname,mr.riskid) from mit_risk mr);
    insert into uconflicts select distinct m.* from mit_uconflicts_c m where concat(m.uname,m.conflictid) not in (select concat(mc.uname,mc.conflictid) from mit_conflict mc);
    insert into uconflicts_all select distinct m.* from mit_uconflicts_r m where concat(m.uname,left(m.conflictid,6)) not in (select concat(mr.uname,mr.riskid) from mit_risk mr);
    insert into uconflicts_all select distinct m.* from mit_uconflicts_c m where concat(m.uname,m.conflictid) not in (select concat(mc.uname,mc.conflictid) from mit_conflict mc);
    INSERT INTO UCONFLICTS_COL SELECT U.UNAME,U.CONFLICTID, C.VALUE TCODE1, D.VALUE TCODE2, E.VALUE TCODE3 FROM (SELECT DISTINCT M.* FROM MIT_UCONFLICTS_R M WHERE CONCAT(M.UNAME,LEFT(M.CONFLICTID,6)) NOT IN (SELECT CONCAT(MR.UNAME,MR.RISKID) FROM MIT_RISK MR)) U, CONFLICTS_C C, CONFLICTS_C D, CONFLICTS_C E, CONFLICTS_FIRST_CNT F WHERE C.CONFLICTID=U.CONFLICTID and C.CONFLICTID=D.CONFLICTID AND D.CONFLICTID=E.CONFLICTID AND D.CONFLICTID=F.CONFLICTID AND C.VALUE<>D.VALUE AND D.VALUE<>E.VALUE AND C.VALUE<>E.VALUE AND F.COUNT=3 GROUP BY 1,2;
    INSERT INTO UCONFLICTS_COL (UNAME,CONFLICTID,TCODE1,TCODE2) SELECT DISTINCT U.UNAME,U.CONFLICTID,C.VALUE,D.VALUE FROM (SELECT DISTINCT M.* FROM MIT_UCONFLICTS_R M WHERE CONCAT(M.UNAME,LEFT(M.CONFLICTID,6)) NOT IN (SELECT CONCAT(MR.UNAME,MR.RISKID) FROM MIT_RISK MR)) U,CONFLICTS_C C, CONFLICTS_C D, CONFLICTS_FIRST_CNT F WHERE U.CONFLICTID=C.CONFLICTID AND C.CONFLICTID=D.CONFLICTID AND C.VALUE<>D.VALUE AND D.CONFLICTID=F.CONFLICTID AND F.COUNT=2 GROUP BY 1,2;
    INSERT INTO UCONFLICTS_COL SELECT U.UNAME,U.CONFLICTID, C.VALUE TCODE1, D.VALUE TCODE2, E.VALUE TCODE3 FROM (select distinct m.* from mit_uconflicts_c m where concat(m.uname,m.conflictid) not in (select concat(mc.uname,mc.conflictid) from mit_conflict mc)) U, CONFLICTS_C C, CONFLICTS_C D, CONFLICTS_C E, CONFLICTS_FIRST_CNT F WHERE C.CONFLICTID=U.CONFLICTID and C.CONFLICTID=D.CONFLICTID AND D.CONFLICTID=E.CONFLICTID AND D.CONFLICTID=F.CONFLICTID AND C.VALUE<>D.VALUE AND D.VALUE<>E.VALUE AND C.VALUE<>E.VALUE AND F.COUNT=3 GROUP BY 1,2;
    INSERT INTO UCONFLICTS_COL (UNAME,CONFLICTID,TCODE1,TCODE2) SELECT DISTINCT U.UNAME,U.CONFLICTID,C.VALUE,D.VALUE FROM (select distinct m.* from mit_uconflicts_c m where concat(m.uname,m.conflictid) not in (select concat(mc.uname,mc.conflictid) from mit_conflict mc)) U,CONFLICTS_C C, CONFLICTS_C D, CONFLICTS_FIRST_CNT F WHERE U.CONFLICTID=C.CONFLICTID AND C.CONFLICTID=D.CONFLICTID AND C.VALUE<>D.VALUE AND D.CONFLICTID=F.CONFLICTID AND F.COUNT=2 GROUP BY 1,2;
    delete m from mit_uconflicts_r m where concat(m.uname,left(m.conflictid,6)) not in (select concat(mr.uname,mr.riskid) from mit_risk mr);
    delete m from mit_uconflicts_c m where concat(m.uname,m.conflictid) not in (select concat(mc.uname,mc.conflictid) from mit_conflict mc);
        
    drop table if exists tmp_mit_uconflicts;
    create temporary table tmp_mit_uconflicts select distinct * from mit_uconflicts_r;
    truncate mit_uconflicts_r;
    insert into mit_uconflicts_r select * from tmp_mit_uconflicts;
    drop table if exists tmp_mit_uconflicts;

    drop table if exists tmp_mit_uconflicts;
    create temporary table tmp_mit_uconflicts select distinct * from mit_uconflicts_c;
    truncate mit_uconflicts_c;
    insert into mit_uconflicts_c select * from tmp_mit_uconflicts;
    drop table if exists tmp_mit_uconflicts;
    
    drop table if exists tmp_uconflicts;
    create temporary table tmp_uconflicts select distinct * from uconflicts;
    truncate uconflicts;
    insert into uconflicts select * from tmp_uconflicts;
    drop table if exists tmp_uconflicts;

    drop table if exists tmp_uconflicts_all;
    create temporary table tmp_uconflicts_all select distinct * from uconflicts_all;
    truncate uconflicts_all;
    insert into uconflicts_all select * from tmp_uconflicts_all;
    drop table if exists tmp_uconflicts_all;
    
    drop table if exists mit_uconflicts_COL;
    CREATE TABLE MIT_UCONFLICTS_COL SELECT U.UNAME,U.CONFLICTID, C.VALUE TCODE1, D.VALUE TCODE2, E.VALUE TCODE3 FROM MIT_UCONFLICTS_C U, CONFLICTS_C C, CONFLICTS_C D, CONFLICTS_C E, CONFLICTS_FIRST_CNT F WHERE C.CONFLICTID=U.CONFLICTID and C.CONFLICTID=D.CONFLICTID AND D.CONFLICTID=E.CONFLICTID AND D.CONFLICTID=F.CONFLICTID AND C.VALUE<>D.VALUE AND D.VALUE<>E.VALUE AND C.VALUE<>E.VALUE AND F.COUNT=3 GROUP BY 1,2;
    INSERT INTO MIT_UCONFLICTS_COL (UNAME,CONFLICTID,TCODE1,TCODE2) SELECT DISTINCT U.UNAME,U.CONFLICTID,C.VALUE,D.VALUE FROM MIT_UCONFLICTS_C U,CONFLICTS_C C, CONFLICTS_C D, CONFLICTS_FIRST_CNT F WHERE U.CONFLICTID=C.CONFLICTID AND C.CONFLICTID=D.CONFLICTID AND C.VALUE<>D.VALUE AND D.CONFLICTID=F.CONFLICTID AND F.COUNT=2 GROUP BY 1,2;
    INSERT INTO MIT_UCONFLICTS_COL SELECT U.UNAME,U.CONFLICTID, C.VALUE TCODE1, D.VALUE TCODE2, E.VALUE TCODE3 FROM MIT_UCONFLICTS_R U, CONFLICTS_C C, CONFLICTS_C D, CONFLICTS_C E, CONFLICTS_FIRST_CNT F WHERE C.CONFLICTID=U.CONFLICTID and C.CONFLICTID=D.CONFLICTID AND D.CONFLICTID=E.CONFLICTID AND D.CONFLICTID=F.CONFLICTID AND C.VALUE<>D.VALUE AND D.VALUE<>E.VALUE AND C.VALUE<>E.VALUE AND F.COUNT=3 GROUP BY 1,2;
    INSERT INTO MIT_UCONFLICTS_COL (UNAME,CONFLICTID,TCODE1,TCODE2) SELECT DISTINCT U.UNAME,U.CONFLICTID,C.VALUE,D.VALUE FROM MIT_UCONFLICTS_R U,CONFLICTS_C C, CONFLICTS_C D, CONFLICTS_FIRST_CNT F WHERE U.CONFLICTID=C.CONFLICTID AND C.CONFLICTID=D.CONFLICTID AND C.VALUE<>D.VALUE AND D.CONFLICTID=F.CONFLICTID AND F.COUNT=2 GROUP BY 1,2;
    CREATE INDEX IDX_UCOL ON MIT_UCONFLICTS_COL(UNAME,CONFLICTID,TCODE1,TCODE2,TCODE3);
    drop table if exists tmp_muc;
    create table tmp_muc select distinct * from MIT_UCONFLICTS_COL;
    truncate MIT_UCONFLICTS_COL;
    insert into MIT_UCONFLICTS_COL select * from tmp_muc;
    drop table if exists tmp_muc;
end if;

DROP table if exists sap_report;
CREATE TABLE `sap_report` (
 `Id` int(11) DEFAULT NULL,
 `dashboard` int(11) DEFAULT NULL,
 `report_type_id` int(11) DEFAULT NULL,
 `column_name` varchar(200)
 DEFAULT NULL,`column_value` int(11) DEFAULT NULL, KEY `DashboardIndex` (`Id`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

set column_name='AssinedRoles';
select count(distinct a.agr_name) INTO column_val from agr_users a, agr_1016 r where a.agr_name=r.agr_name and date(to_dat) >= curdate();
insert into sap_report(Id,dashboard,report_type_id,column_name,column_value) values(1,1,1,column_name,column_val);

set column_name='SAPUnassignedRoles';
select count(distinct a.agr_name) INTO column_val from agr_1016 a left join (agr_users au inner join usr02 us on au.uname=us.uname and lockstatus in (0,128) and (valid_to>=var_analysis_date or valid_to='00000000') and user_type='A' and (to_dat>=current_date() or to_dat is null or to_dat='00000000')) on a.agr_name=au.agr_name where au.agr_name is null and a.agr_name like 'SAP%';
insert into sap_report(Id,dashboard,report_type_id,column_name,column_value) values(2,1,1,column_name,column_val);

set column_name='UnAssinedRoles';
select count(distinct a.agr_name) INTO column_val from agr_1016 a left join (agr_users au inner join usr02 us on au.uname=us.uname and lockstatus in (0,128) and (valid_to>=var_analysis_date or valid_to='00000000') and user_type='A' and (to_dat>=current_date() or to_dat is null or to_dat='00000000')) on a.agr_name=au.agr_name where au.agr_name is null and a.agr_name not like 'SAP%';
insert into sap_report(Id,dashboard,report_type_id,column_name,column_value) values(3,1,1,column_name,column_val);

set column_name='User with conflict';
select count(distinct uname) INTO column_val from uconflicts;
insert into sap_report(Id,dashboard,report_type_id,column_name,column_value) values(1,2,1,column_name,column_val);  

set column_name='Users with no conflict';
select q1.cnt - q2.cnt into column_val from (select count(*) cnt from ucompleted)q1, (select count(distinct uname) cnt from uconflicts)q2;
insert into sap_report(Id,dashboard,report_type_id,column_name,column_value) values(2,2,1,column_name,column_val); 

open cur_dashboard3;
dashboard3Loop:Loop
    fetch cur_dashboard3 into column_name,column_val;
    if done=1 then
        leave dashboard3Loop;
    end if;

    set i=i+1;
    insert into sap_report(Id,dashboard,report_type_id,column_name,column_value) values(i,3,1,column_name,column_val);
end loop dashboard3Loop;
close cur_dashboard3;
set done=0;

open cur_dashboard4;
dashboard4Loop:Loop
    fetch cur_dashboard4 into column_name,column_val;

    if done=1 then
        leave dashboard4Loop;
    end if;
    set j=j+1;
    insert into sap_report(Id,dashboard,report_type_id,column_name,column_value) values(j,4,1,column_name,column_val);
end loop dashboard4Loop;
close cur_dashboard4;   

set column_name='Risk With Violation';
select count(distinct left(conflictid,6)) into column_val from uconflicts;
insert into sap_report(Id,dashboard,report_type_id,column_name,column_value) values(1,5,1,column_name,column_val);

set column_name='Risk With No Violation';    
select q1.cnt-q2.cnt into column_val from (select count(distinct riskid) cnt from sod_risk)q1, (select count(distinct left(conflictid,6)) cnt from uconflicts)q2;
insert into sap_report(Id,dashboard,report_type_id,column_name,column_value) values(2,5,1,column_name,column_val);

set column_name='Users with SU Access';
select count(distinct k.uname) into column_val from
(select distinct a.uname from agr_users a, role_build r, user_details ud where a.uname=ud.uname and ud.valid_to >=curdate() and a.agr_name=r.agr_name and objct='s_tcode' and field='tcd' and r.from='%'
union
select distinct a.uname from agr_users a, user_details u where a.uname=u.uname and u.valid_to>=curdate() and (agr_name like 'PROFILE:%SAP%NEW%' or agr_name like 'PROFILE:%SAP%ALL%'))k;
insert into sap_report(Id,dashboard,report_type_id,column_name,column_value) values(1,6,1,column_name,column_val);

set column_name='Users with no SU Access';
select q1.cnt-q2.cnt into column_val from (select count(distinct uname) cnt from user_details)q1, (select column_value cnt from sap_report where id=1 and dashboard=6)q2;
insert into sap_report(Id,dashboard,report_type_id,column_name,column_value) values(2,6,1,column_name,column_val);

set column_name='Roles with SU Access';
select count(distinct agr_name) into column_val from role_build r where r.objct = 's_tcode' and r.field = 'tcd' and r.from = '%';
insert into sap_report(Id,dashboard,report_type_id,column_name,column_value) values(1,7,1,column_name,column_val);

set column_name='Roles with no SU Access';
select q1.cnt-q2.cnt into column_val from (select count(distinct agr_name) cnt from role_build)q1, (select column_value cnt from sap_report where id=1 and dashboard=7)q2;
insert into sap_report(Id,dashboard,report_type_id,column_name,column_value) values(2,7,1,column_name,column_val);

/*Code for Extraction & Statistical Details Dashboard queries*/

/* Removed Primary key repid by Manish */

/*
drop table if exists inirep;
CREATE TABLE  inirep (
  `repid` int(10) NOT NULL DEFAULT '0',
  `tabl` int(10) DEFAULT NULL,
  `lin` int(10) DEFAULT NULL,
  `repdsc` varchar(100) DEFAULT NULL,
  `repout` varchar(100) DEFAULT NULL
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Info on the left side*/

/*
select if(isnull(date_format(now(),'%Y%m%d')),date(now()),date_format(now(),'%Y%m%d')) into var_analysis_date; -- from quick_audit.report_license where my_db_name = var_mydb;
if var_analysis_date = '' then
  set var_analysis_date = date(now());
end if;

Insert into inirep select 1,1,1,'Data Extracted On ',EXTRACT_DATE from extract_details;
insert into inirep select 2,1,2,'Total Users ',count(distinct uname) from user_details;
insert into inirep select 3,1,3,'Locked Users: ',count(distinct u.uname) from user_details u where u.lockstatus=1;

-- insert into inirep select 4,1,4,'Expired Users: ',count(distinct u.uname) from user_details u, quick_audit.report_license r where my_db_name = var_mydb and u.valid_to <> '00000000' and u.valid_to < var_analysis_date;

/* This Code is added after modification of above line by Manish Kumar */ 

/*
insert into inirep select 4,1,4,'Expired Users: ',count(distinct u.uname) from user_details u where  u.valid_to <> '00000000' and u.valid_to < var_analysis_date;


insert into inirep select 5,1,5,'Active Dialog Users ', count(distinct u.uname) from user_details u where u.lockstatus =0 and (u.valid_to >= var_analysis_date or u.valid_to = '00000000' or u.valid_to = '' or u.valid_to is null) and user_type=1;
insert into inirep select 6,1,6,'Total Roles ', count(distinct agr_name) from agr_1016;
insert into inirep select 8,1,8,'Active Roles ',count(distinct agr_name) from agr_users where (to_dat>=current_date() or to_dat is null or to_dat='00000000') and uname in (select distinct uname from usr02 where lockstatus in (0,128) and (valid_to>=current_date() or valid_to='00000000') and user_type='A') order by agr_name;
insert into inirep select 7,1,7,'Unassigned Roles ',q1.cnt1-q2.cnt2 from (select repout cnt1 from inirep where repid=6)q1,(select repout cnt2 from inirep where repid=8)q2;
insert into inirep select 9,1,9,'Custom TCodes ',count(distinct tcode) from tstct where tcode like 'y%' or tcode like 'z%';
insert into inirep select 10,1,10,'Rules for Custom TCodes',count(conflictid) from tstct t inner join conflicts_c c on t.tcode=c.value where tcode like 'y%' or tcode like 'z%';
insert into inirep select 11,1,11,'Non-dialog Users',count(distinct u.uname) from user_details u where u.lockstatus =0 and (u.valid_to >= var_analysis_date or u.valid_to = '00000000' or u.valid_to = '' or u.valid_to is null) and user_type=0;
insert into inirep select 12,1,12,'User Conflicts',count(conflictid) from uconflicts;
insert into inirep select 13,1,13,'No. of Users in Conflict',count(distinct uname) from uconflicts;

/*Info on right side*/

/*
insert into inirep select 11,2,1,'Date of Analysis: ',var_analysis_date;
insert into inirep select 12,2,2,'Users Analyzed: ', count(distinct uname) from ucompleted;
insert into inirep select 13,2,3,'Roles Analyzed: ',count(distinct agr_name) from rcompleted;
insert into inirep select 14,2,4,'Users Not Logged on to SAP System: ', count(u.uname) Users FROM usr02 u inner join user_details ud on u.uname=ud.uname where ud.user_type=1 and (last_logon = '00000000' or last_logon='' or last_logon is null) and (ud.valid_to = '00000000' or ud.valid_to > current_date());
insert into inirep select 15,2,5,'Users Not Logged on in last 6 months: ',count(u.uname) Users FROM usr02 u inner join user_details ud on u.uname=ud.uname where ud.user_type=1 and (last_logon = '00000000' or datediff(current_date(),last_logon) > 180) and (ud.valid_to = '00000000' or ud.valid_to > current_date());
insert into inirep select 16,2,6,'Users who have not changed password: ',count(distinct u.uname) FROM usr02 u inner join user_details ud on u.uname=ud.uname where ud.user_type=1 and (pass_change='' or pass_change ='00000000' or pass_change is null)  and (ud.valid_to = '00000000' or ud.valid_to > current_date());
insert into inirep select 17,2,7,'Users who have not changed password in last 6 months: ',count(distinct u.uname) FROM usr02 u inner join user_details ud on u.uname=ud.uname where ud.user_type=1 and (pass_change='' or pass_change = '00000000' or pass_change is null or datediff(current_date(),pass_change) > 180)  and (ud.valid_to = '00000000' or ud.valid_to > current_date());
insert into inirep select 18,2,8,'Users with SAP_ALL & SAP_NEW Access <span style="color:red;">*</span>: ', count(distinct a.uname) from agr_users a inner join user_details u on a.uname=u.uname where (u.valid_to >= curdate() or u.valid_to ='00000000') and agr_name like 'profile:%sap%all%' or agr_name like 'profile:%sap%new%';
insert into inirep select 19,2,9,'Users with Wild Card * in S_TCODE: ', count(distinct uname) from (select au.uname,au.agr_name from agr_users au inner join user_details ud on au.uname=ud.uname) a, role_build r where a.agr_name = r.agr_name and r.objct = 's_tcode' and r.field = 'tcd' and r.from = '%';

*/

/*Queries for Graphical Dashboard*/

/*
drop table if exists graphinfo;
CREATE TABLE  graphinfo (
  `repid` int(10) NOT NULL DEFAULT '0',
  `id` varchar(3)DEFAULT NULL,
  `proc` varchar(50) DEFAULT NULL,
  `users` int(10) DEFAULT NULL,
  `risks` int(10) DEFAULT NULL,
  `conflicts` int(10) DEFAULT NULL,
  PRIMARY KEY (`repid`,`proc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into graphinfo select 1,b.proc,b.dsc,count(distinct uname),count(distinct left(conflictid,6)),count(conflictid) from uconflicts u, bus_proc b where left(conflictid,3) = proc group by b.dsc;
insert into graphinfo select 2,b.proc,b.dsc,count(distinct agr_name) 'No. of Users',count(distinct left(conflictid,6)) 'No. of Risks Violated',count(conflictid) 'No. of Conflicts' from rconflicts u, bus_proc b where left(conflictid,3) = proc group by b.dsc;

drop table if exists inigraph;
CREATE TABLE  inigraph (
  `repid` int(1) NOT NULL DEFAULT '0',
  `id` varchar(3)DEFAULT NULL,
  `proc` varchar(50) DEFAULT NULL,
  `High` int(10) DEFAULT NULL,
  `Medium` int(10) DEFAULT NULL,
  `Low` int(10) DEFAULT NULL,
  PRIMARY KEY (`repid`,`proc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into inigraph select distinct 1,q.proc,q.process,sum(high),sum(medium),sum(low) from (
select distinct 1,b.proc,b.dsc 'Process', count(conflictid) High,0 Medium,0 Low
from uconflicts u, bus_proc b, sod_risk s where left(conflictid,3) = proc and left(conflictid,6)=riskid and rating = 'High'
group by b.dsc
union
select distinct 1,b.proc,b.dsc 'Process', 0 High,count(conflictid) 'Medium',0 Low
from uconflicts u, bus_proc b, sod_risk s where left(conflictid,3) = proc and left(conflictid,6)=riskid and rating = 'Medium'
group by b.proc
union
select distinct 1,b.proc,b.dsc 'Process', 0 High, 0 Medium, count(conflictid) Low
from uconflicts u, bus_proc b, sod_risk s where left(conflictid,3) = proc and left(conflictid,6)=riskid and rating = 'Low'
group by b.dsc)q
group by q.proc;

insert into inigraph select distinct 2,q.proc,q.process,sum(high),sum(medium),sum(low) from (
select distinct 1,b.proc,b.dsc 'Process', count(conflictid) High,0 Medium,0 Low
from rconflicts u, bus_proc b, sod_risk s where left(conflictid,3) = proc and left(conflictid,6)=riskid and rating = 'High'
group by b.dsc
union
select distinct 1,b.proc,b.dsc 'Process', 0 High,count(conflictid) 'Medium',0 Low
from rconflicts u, bus_proc b, sod_risk s where left(conflictid,3) = proc and left(conflictid,6)=riskid and rating = 'Medium'
group by b.proc
union
select distinct 1,b.proc,b.dsc 'Process', 0 High, 0 Medium, count(conflictid) Low
from rconflicts u, bus_proc b, sod_risk s where left(conflictid,3) = proc and left(conflictid,6)=riskid and rating = 'Low'
group by b.dsc)q
group by q.proc;

drop table if exists top_user_roles;
CREATE TABLE  top_user_roles (
  `repid` int(1) NOT NULL DEFAULT '0',
  `id` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `cnt` int(10) DEFAULT NULL,
  PRIMARY KEY (`repid`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into top_user_roles select 1, u.uname, user_name, count(conflictid) from uconflicts  u, user_details ud where u.uname=ud.uname group by u.uname order by count(conflictid) desc limit 5;
insert into top_user_roles(repid,id,cnt) select 2, agr_name, count(conflictid) from rconflicts group by agr_name order by count(conflictid) desc limit 5;
insert into top_user_roles select 3, u.uname, user_name, count(conflictid) from uconflicts  u, user_details ud where u.uname=ud.uname and ud.suser=0 group by u.uname order by count(conflictid) desc limit 5;
insert into top_user_roles(repid,id,cnt) select 4, agr_name, count(conflictid) from rconflicts group by agr_name order by count(conflictid) desc limit 5;

drop table if exists top_risks;
create table top_risks select 1 'repid', RiskID, riskname 'Description', rating 'Risk_Rating', count(conflictid) 'No_of_Conflicts' from uconflicts u, sod_risk s where left(u.conflictid,6) = s.riskid group by riskid, riskname, rating order by count(conflictid) desc limit 5;
insert into top_risks select 2, RiskID, riskname 'Description', rating 'Risk_Rating', count(conflictid) 'No_of_Conflicts' from uconflicts u, sod_risk s, user_details d where left(u.conflictid,6) = s.riskid and u.uname=d.uname and d.suser=0 group by riskid, riskname, rating order by count(conflictid) desc limit 5;
drop table if exists top_tcodes;
create table top_tcodes select 1 'repid', value TCode, t.desc 'Description', count(value) 'No_of_Conflicts' from uconflicts u, conflicts_c c, tstct t where u.conflictid=c.conflictid and c.value = t.tcode group by value order by count(value) desc limit 5;
insert into top_tcodes select 2, value TCode, t.desc 'Description', count(value) 'No_of_Conflicts' from (select uc.* from uconflicts uc inner join user_details ud on uc.uname=ud.uname where ud.suser=0) u, conflicts_c c, tstct t where u.conflictid=c.conflictid and c.value = t.tcode group by value order by count(value) desc limit 5;

/*Updating Trend Data*/

/* Below lines are Commented By Manish kr */
/*select client_db into var_client from quick_audit.report_license r inner join quick_audit.client_master c on r.client_id=c.client_id where r.my_db_name=(select database());

set @q3=concat('CREATE TABLE IF NOT EXISTS ',var_client,'.CONF_TREND (`LICENSE_ID` INT,`PROC` VARCHAR(3),`DEPARTMENT` VARCHAR(45),`USERS` BIGINT,`HIGH` BIGINT,`MEDIUM` BIGINT,`LOW` BIGINT,`TOTAL` BIGINT, KEY `IDX_CT` (LICENSE_ID,PROC,`USERS`)) ENGINE=MyISAM DEFAULT CHARSET=UTF8;');
prepare q3 from @q3;
execute q3;

set @q4=concat('CREATE TABLE IF NOT EXISTS ',var_client,'.MIT_TREND (`LICENSE_ID` INT,`PROC` VARCHAR(3),`DEPARTMENT` VARCHAR(45),`USERS` BIGINT,`HIGH` BIGINT,`MEDIUM` BIGINT,`LOW` BIGINT,`TOTAL` BIGINT, KEY `IDX_CT` (LICENSE_ID,PROC,`USERS`)) ENGINE=MyISAM DEFAULT CHARSET=UTF8;');
prepare q4 from @q4;
execute q4;

set @q31=concat('DELETE C FROM ',var_client,'.CONF_TREND C, QUICK_AUDIT.REPORT_LICENSE R WHERE R.MY_DB_NAME=(SELECT DATABASE()) AND C.LICENSE_ID=R.LICENSE_ID;');
prepare q31 from @q31;
execute q31;

set @q41=concat('DELETE C FROM ',var_client,'.MIT_TREND C, QUICK_AUDIT.REPORT_LICENSE R WHERE R.MY_DB_NAME=(SELECT DATABASE()) AND C.LICENSE_ID=R.LICENSE_ID;');
prepare q41 from @q41;
execute q41;

set @q5=concat('INSERT INTO ',var_client,'.CONF_TREND SELECT LICENSE_ID,PROC,DEPARTMENT,COUNT(USERS) USERS, SUM(HIGH) HIGH,SUM(MEDIUM) MEDIUM,SUM(LOW) LOW, SUM(HIGH)+SUM(MEDIUM)+SUM(LOW) TOTAL FROM (SELECT DISTINCT LICENSE_ID,LEFT(U.CONFLICTID,3)PROC,DEPARTMENT,RATING, U.UNAME USERS, IF(RATING=''HIGH'',count(u.conflictid),0) HIGH,IF(RATING=''MEDIUM'',count(u.conflictid),0) MEDIUM,IF(RATING=''LOW'',count(u.conflictid),0) LOW FROM UCONFLICTS U INNER JOIN USER_DETAILS UD ON U.UNAME=UD.UNAME INNER JOIN SOD_RISK S ON LEFT(U.CONFLICTID,6)=S.RISKID, QUICK_AUDIT.REPORT_LICENSE R WHERE R.MY_DB_NAME=(SELECT DATABASE()) group by 1,2,3,4,5)Q GROUP BY 1,2,3;');
prepare q5 from @q5;
execute q5;

set @q6=concat('INSERT INTO ',var_client,'.MIT_TREND SELECT LICENSE_ID,PROC,DEPARTMENT,COUNT(USERS) USERS, SUM(HIGH) HIGH,SUM(MEDIUM) MEDIUM,SUM(LOW) LOW, SUM(HIGH)+SUM(MEDIUM)+SUM(LOW) TOTAL FROM (SELECT DISTINCT LICENSE_ID,LEFT(U.CONFLICTID,3)PROC,DEPARTMENT,RATING, U.UNAME USERS, IF(RATING=''HIGH'',count(u.conflictid),0) HIGH,IF(RATING=''MEDIUM'',count(u.conflictid),0) MEDIUM,IF(RATING=''LOW'',count(u.conflictid),0) LOW FROM MIT_UCONFLICTS_COL U INNER JOIN USER_DETAILS UD ON U.UNAME=UD.UNAME INNER JOIN SOD_RISK S ON LEFT(U.CONFLICTID,6)=S.RISKID, QUICK_AUDIT.REPORT_LICENSE R WHERE R.MY_DB_NAME=(SELECT DATABASE()) group by 1,2,3,4,5)Q GROUP BY 1,2,3;');
prepare q6 from @q6;
execute q6; */

/*---END---Updating Trend Data*/

/*Generating report rep_org_access i.e. access to org elements by user

set done=0;

select  count(*) into var_idx FROM INFORMATION_SCHEMA.STATISTICS WHERE  table_name = 'root_cause' and   index_name = 'idx_rc_fld' and table_schema = (select database());
if var_idx=0 then
  create index idx_rc_fld on root_cause(`uname`,`tcode`,`field`);
end if;

drop table if exists rep_org_access;
set @q1='create table rep_org_access (User_ID varchar(12), User_Name varchar(80),TCode varchar(100),';
open cur_org;
org_create:Loop
  fetch cur_org into var_org, var_org_fld;
  if done=1 then
    leave org_create;
  end if;
  set @q1=concat(@q1,var_org_fld,' TEXT,');
end loop;
close cur_org;
set done=0;

set @q1=concat(@q1,' KEY `idx_roa` (`User_ID`)) Engine=MyISAM default charset=utf8;');
prepare q1 from @q1;
execute q1;

insert into rep_org_access(user_id,user_name,tcode) select distinct r.uname,user_name,tcode from (select distinct uname,tcode,field from root_cause) r inner join user_details ud on r.uname=ud.uname inner join org_elements o on r.field=o.element order by 1;

open cur_org;
org_input:Loop
  fetch cur_org into var_org, var_org_fld;
  if done=1 then
    leave org_input;
  end if;
  select tbl,fld into var_tbl,var_fld from org_elements where element=var_org;
  set @q2=concat('update rep_org_access roa, (select r.uname,r.tcode, replace(group_concat(distinct t.',var_fld,' order by ',var_fld,'),'','','', '') fld from root_cause r, ',var_tbl,' t where r.field=''',var_org,''' and t.',var_fld,' between replace(r.from,''*'',''%'') and replace(r.to,''*'',''__%'') group by r.uname,r.tcode)t set roa.',var_org_fld,'=t.fld where roa.user_id=t.uname and roa.tcode=t.tcode;');
  prepare q2 from @q2;
  execute q2;
end loop;
close cur_org;
set done=0;


/*Adding additional objects other than Org elements*/
/* commenting by hm 12/01 * temporary as incrroect entry to root cause/
/*
select count(*) into var_rco_update from root_cause_org where field='BSART';
if var_rco_update=0 then
  insert into root_cause_org
    select distinct a.uname,u.tcode,r.agr_name,r.objct,r.auth,r.field,r.from,r.to
    from agr_users a inner join role_build r on a.agr_name=r.agr_name and a.to_dat>now() inner join user_tcode u on a.uname=u.uname
    inner join usobx_c x on u.tcode=x.name and x.okflag='y' and x.object=r.objct
    where r.field in ('BSART','AUART','AUFART','LGORT','BWART','DISPO','FKART','STSMA','QMART','QMASTAUTH');
end if;

select count(*) into var_roa_update from information_schema.columns where table_schema=var_mydb and table_name='rep_org_access' and column_name ='Purchasing_Doc_Type';
if var_roa_update=0 then
alter table rep_org_access add column `Purchasing_Doc_Type` text, add column sales_order_type text, add column Production_order_Type text,
  add column Storage_Location text, add column Movement_Type text, add column MRP_Controller text, add column Billing_Type text, add column Sales_Order_Status text, add column QM_Inspection_Type text,
  add column QM_Mat_Auth_Group text;
end if;

update rep_org_access roa, (select r.uname,r.tcode, group_concat(distinct if(replace(r.from,'%','*')=replace(r.to,'__%','*'),replace(r.from,'%','*'),concat(replace(r.from,'%','*'),' - ',replace(r.to,'%','*')))) fld from root_cause_org r where field='BSART' and r.from <>'' group by r.uname,r.tcode) rco set roa.Purchasing_Doc_Type=rco.fld where roa.user_id=rco.uname and roa.tcode=rco.tcode;
update rep_org_access roa, (select r.uname,r.tcode, group_concat(distinct if(replace(r.from,'%','*')=replace(r.to,'__%','*'),replace(r.from,'%','*'),concat(replace(r.from,'%','*'),' - ',replace(r.to,'%','*')))) fld from root_cause_org r where field='AUART' and r.from <>'' group by r.uname,r.tcode) rco set roa.sales_order_type=rco.fld where roa.user_id=rco.uname and roa.tcode=rco.tcode;
update rep_org_access roa, (select r.uname,r.tcode, group_concat(distinct if(replace(r.from,'%','*')=replace(r.to,'__%','*'),replace(r.from,'%','*'),concat(replace(r.from,'%','*'),' - ',replace(r.to,'%','*')))) fld from root_cause_org r where field='AUFRT' and r.from <>'' group by r.uname,r.tcode) rco set roa.Production_order_Type=rco.fld where roa.user_id=rco.uname and roa.tcode=rco.tcode;
update rep_org_access roa, (select r.uname,r.tcode, group_concat(distinct if(replace(r.from,'%','*')=replace(r.to,'__%','*'),replace(r.from,'%','*'),concat(replace(r.from,'%','*'),' - ',replace(r.to,'%','*')))) fld from root_cause_org r where field='LGORT' and r.from <>'' group by r.uname,r.tcode) rco set roa.Storage_Location=rco.fld where roa.user_id=rco.uname and roa.tcode=rco.tcode;
update rep_org_access roa, (select r.uname,r.tcode, group_concat(distinct if(replace(r.from,'%','*')=replace(r.to,'__%','*'),replace(r.from,'%','*'),concat(replace(r.from,'%','*'),' - ',replace(r.to,'%','*')))) fld from root_cause_org r where field='BWART' and r.from <>'' group by r.uname,r.tcode) rco set roa.Movement_Type=rco.fld where roa.user_id=rco.uname and roa.tcode=rco.tcode;
update rep_org_access roa, (select r.uname,r.tcode, group_concat(distinct if(replace(r.from,'%','*')=replace(r.to,'__%','*'),replace(r.from,'%','*'),concat(replace(r.from,'%','*'),' - ',replace(r.to,'%','*')))) fld from root_cause_org r where field='DISPO' and r.from <>'' group by r.uname,r.tcode) rco set roa.MRP_Controller=rco.fld where roa.user_id=rco.uname and roa.tcode=rco.tcode;
update rep_org_access roa, (select r.uname,r.tcode, group_concat(distinct if(replace(r.from,'%','*')=replace(r.to,'__%','*'),replace(r.from,'%','*'),concat(replace(r.from,'%','*'),' - ',replace(r.to,'%','*')))) fld from root_cause_org r where field='FKART' and r.from <>'' group by r.uname,r.tcode) rco set roa.Billing_Type=rco.fld where roa.user_id=rco.uname and roa.tcode=rco.tcode;
update rep_org_access roa, (select r.uname,r.tcode, group_concat(distinct if(replace(r.from,'%','*')=replace(r.to,'__%','*'),replace(r.from,'%','*'),concat(replace(r.from,'%','*'),' - ',replace(r.to,'%','*')))) fld from root_cause_org r where field='STSMA' and r.from <>'' group by r.uname,r.tcode) rco set roa.Sales_Order_Status=rco.fld where roa.user_id=rco.uname and roa.tcode=rco.tcode;
update rep_org_access roa, (select r.uname,r.tcode, group_concat(distinct if(replace(r.from,'%','*')=replace(r.to,'__%','*'),replace(r.from,'%','*'),concat(replace(r.from,'%','*'),' - ',replace(r.to,'%','*')))) fld from root_cause_org r where field='QMART' and r.from <>'' group by r.uname,r.tcode) rco set roa.QM_Inspection_Type=rco.fld where roa.user_id=rco.uname and roa.tcode=rco.tcode;
update rep_org_access roa, (select r.uname,r.tcode, group_concat(distinct if(replace(r.from,'%','*')=replace(r.to,'__%','*'),replace(r.from,'%','*'),concat(replace(r.from,'%','*'),' - ',replace(r.to,'%','*')))) fld from root_cause_org r where field='QMASTAUTH' and r.from <>'' group by r.uname,r.tcode) rco set roa.QM_Mat_Auth_Group=rco.fld where roa.user_id=rco.uname and roa.tcode=rco.tcode;

/* === Line ADDED By Manish Kr === */
INSERT INTO `procedure_message` (`id`, `procedure_name`, `message`, `create_datetime`) VALUES (NULL, 'Dashboard Report', 'Dashboard Report Completed..', current_timestamp());

END
