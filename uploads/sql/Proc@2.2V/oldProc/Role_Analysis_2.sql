CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_role_analysis2`(var_proc varchar(1000))
BEGIN

declare done,var_ce,var_cac,var_stat int;
declare rnam varchar(50);
declare var_auth,log_stat varchar(12);
declare var_tcode varchar(40);

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

END 