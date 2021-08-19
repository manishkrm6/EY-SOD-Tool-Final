<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_txtuploadrule extends CI_Controller {
    
    private $CI;

 	function __construct()
    {
      $this->CI = get_instance();
    }

    function get_columns_rule( $file ){
        
        $result = [];

        switch ($file) {

            // Required Table
            case 'ADRP':
                $result['target_columns'] = ['PERSNUMBER','NAME_TEXT'];
                $result['date_column_indexes'] = [];
                break;
            case 'AGR_1016':
                $result['target_columns'] = ['AGR_NAME','COUNTER','PROFILE','VARIANT','GENERATED','PSTATE'];
                $result['date_column_indexes'] = [];
                break;
            case 'AGR_AGRS':
                $result['target_columns'] = ['AGR_NAME','CHILD_AGR','ATTRIBUTES'];
                $result['date_column_indexes'] = [];
                break;    
            case 'AGR_USERS':
                $result['target_columns'] = ['AGR_NAME','UNAME','FROM_DAT','TO_DAT','EXCLUDE','ORG_FLAG','COL_FLAG'];
                $result['date_column_indexes'] = [3,4];
                break;
            case 'TSTC':
                $result['target_columns'] = ['TCODE','PGMNA','CINFO'];
                $result['date_column_indexes'] = [];
                break;
            case 'TSTCA':
                $result['target_columns'] = ['TCODE','OBJCT','FIELD','VALUE'];
                $result['date_column_indexes'] = [];
                break;
            case 'TSTCT':
                $result['target_columns'] = ['TCODE','TTEXT'];
                $result['date_column_indexes'] = [];
                break;
            case 'USOBT_C':
                $result['target_columns'] = ['NAME','TYPE','OBJECT','FIELD','LOW','HIGH'];
                $result['date_column_indexes'] = [];
                break;
            case 'USOBX_C':
                $result['target_columns'] = ['NAME','TYPE','OBJECT','OKFLAG'];
                $result['date_column_indexes'] = [];
                break;
            case 'USR02':
                $result['target_columns'] = ['BNAME','GLTGV', 'GLTGB', 'USTYP', 'CLASS', 'UFLAG', 'TRDAT','PASS_CHANGE', 'ERDAT'];
                $result['date_column_indexes'] = [3,4,11,12,34];
                break;
            case 'USR21':
                $result['target_columns'] = ['BNAME','PERSNUMBER'];
                $result['date_column_indexes'] = [];
                break;
            case 'UST04':
                $result['target_columns'] = ['BNAME','PROFILE'];
                $result['date_column_indexes'] = [];
                break;
            case 'UST10C':
                $result['target_columns'] = ['PROFN','AKTPS','SUBPROF'];
                $result['date_column_indexes'] = [];
                break;
            case 'UST10S':
                $result['target_columns'] = ['PROFN','AKTPS','OBJCT','AUTH'];
                $result['date_column_indexes'] = [];
                break;
            case 'UST12':
                $result['target_columns'] = ['OBJCT','AUTH','AKTPS','FIELD','VON','BIS'];
                $result['date_column_indexes'] = [];
                break;

            // Recommend Tables
            case 'AGR_1251':
                $result['target_columns'] = ['AGR_NAME','COUNTER','OBJECT','AUTH','VARIANT','FIELD','LOW','HIGH','MODIFIED','DELETED','COPIED','NEU','NODE'];
                $result['date_column_indexes'] = [];
                break;
            case 'AGR_DEFINE':
                $result['target_columns'] = ['AGR_NAME','PARENT_AGR'];
                $result['date_column_indexes'] = [];
                break;
            case 'AGR_TCODES':
                $result['target_columns'] = ['AGR_NAME'];
                $result['date_column_indexes'] = [];
                break;
            case 'AGR_TEXTS':
                $result['target_columns'] = ['AGR_NAME','TEXT'];
                $result['date_column_indexes'] = [];
                break;
            case 'CEPCT':
                $result['target_columns'] = ['PRCTR','DATBI','KOKRS','LTEXT','MCTXT'];
                $result['date_column_indexes'] = [];
                break;
            case 'FM01T':
                $result['target_columns'] = ['FIKRS','FITXT'];
                $result['date_column_indexes'] = [];
                break;
            case 'LLOCTT':
                $result['target_columns'] = ['LOCAT','TEXT'];
                $result['date_column_indexes'] = [];
                break;
            case 'T000':
                $result['target_columns'] = ['MANDT','MTEXT','ORT01','MWAER','ADRNR','CCCATEGORY','CCCORACTIV','CCNOCLIIND','CCCOPYLOCK','CCNOCASCAD','CCSOFTLOCK','CCORIGCONT','CCIMAILDIS','CCTEMPLOCK','CHANGEUSER','CHANGEDATE','LOGSYS'];
                $result['date_column_indexes'] = [16];
                break;
            case 'T001':
                $result['target_columns'] = ['BUKRS','BUTXT'];
                $result['date_column_indexes'] = [];
                break;
            case 'T001K':
                $result['target_columns'] = ['BWKEY','BUKRS'];
                $result['date_column_indexes'] = [];
                break;
            case 'T001W':
                $result['target_columns'] = ['WERKS','NAME1'];
                $result['date_column_indexes'] = [];
                break;
            case 'T014T':
                $result['target_columns'] = ['KKBER','KKBTX'];
                $result['date_column_indexes'] = [];
                break;
            case 'T024':
                $result['target_columns'] = ['EKGRP','EKNAM'];
                $result['date_column_indexes'] = [];
                break;    
            case 'T024E':
                $result['target_columns'] = ['EKORG','EKOTX','BUKRS'];
                $result['date_column_indexes'] = [];
                break;    
            case 'T300T':
                $result['target_columns'] = ['LGNUM','LNUMT'];
                $result['date_column_indexes'] = [];
                break;    
            case 'T301T':
                $result['target_columns'] = ['LGNUM','LGTYP','LTYPT'];
                $result['date_column_indexes'] = [];
                break;    
            case 'T399I':
                $result['target_columns'] = ['IWERK','NAME1'];
                $result['date_column_indexes'] = [];
                break;    
            case 'T777P':
                $result['target_columns'] = ['PLVAR','PTEXT'];
                $result['date_column_indexes'] = [];
                break;    
            case 'T880':
                $result['target_columns'] = ['RCOMP','NAME1'];
                $result['date_column_indexes'] = [];
                break;    
            case 'TBKK01T':
                $result['target_columns'] = ['BKKRS','T_BKKRS'];
                $result['date_column_indexes'] = [];
                break;    
            case 'TBKK80T':
                $result['target_columns'] = ['CONDAREA','T_CONDAREA'];
                $result['date_column_indexes'] = [];
                break;    
            case 'TF161':
                $result['target_columns'] = ['DIMEN','BUNIT', 'TXTMI'];
                $result['date_column_indexes'] = [];
                break;    
            case 'TGSBT':
                $result['target_columns'] = ['GSBER','GTEXT'];
                $result['date_column_indexes'] = [];
                break;    
            case 'TKA01':
                $result['target_columns'] = ['KOKRS','BEZEI','WAERS','KTOPL'];
                $result['date_column_indexes'] = [];
                break;    
            case 'TKEBT':
                $result['target_columns'] = ['ERKRS','ERKRS_BZ'];
                $result['date_column_indexes'] = [];
                break;    
            case 'TSPAT':
                $result['target_columns'] = ['SPART','VTEXT'];
                $result['date_column_indexes'] = [];
                break;    
            case 'TTDST':
                $result['target_columns'] = ['TPLST','BEZEI'];
                $result['date_column_indexes'] = [];
                break;    
            case 'TVGRT':
                $result['target_columns'] = ['VKGRP','BEZEI'];
                $result['date_column_indexes'] = [];
                break;    
            case 'TVKBT':
                $result['target_columns'] = ['VKBUR','BEZEI'];
                $result['date_column_indexes'] = [];
                break;    
            case 'TVKOT':
                $result['target_columns'] = ['VKORG','VTEXT'];
                $result['date_column_indexes'] = [];
                break;    
            case 'TVSTT':
                $result['target_columns'] = ['VSTEL','VTEXT'];
                $result['date_column_indexes'] = [];
                break;    
            case 'TVTWT':
                $result['target_columns'] = ['VTWEG','VTEXT'];
                $result['date_column_indexes'] = [];
                break;

            default:
                # code...
                break;

        } // End Switch Case

        return $result; 


    } // End Function


} // End Class