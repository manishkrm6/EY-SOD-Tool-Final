-- DROP PROCEDURE IF EXISTS `usp_Role_Build2`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_Role_Build2`(var_mydb varchar(100), var_co varchar(1000), var_dept varchar(1000), var_loc varchar(1000), var_lock int, var_exp_role int, var_exp_user int)


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

END 
