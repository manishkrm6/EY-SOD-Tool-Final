<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config = array(
    'create_new_client' => array(
        array(
            'field' => 'client_name',
            'label' => 'Client Name',
            'rules' => 'required|trim|is_unique[iaudit_clients.client_name]'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
    ),
    'api_get_txt_file_content' => array(
        array(
            'field' => 'file_path',
            'label' => 'File Path',
            'rules' => 'required|trim|callback_validateFilePath'
        ),
        array(
            'field' => 'database',
            'label' => 'Database',
            'rules' => 'required|trim|callback_validateDatabase'
        ),
        array(
            'field' => 'database',
            'label' => 'Database',
            'rules' => 'required|trim|callback_validateFile'
        ),
    ),
    'add_new_user' => array(
        array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'trim'
        ),
        array(
            'field' => 'username',
            'label' => 'User Name',
            'rules' => 'required|trim|is_unique[iaudit_users.user_name]'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|trim|is_unique[iaudit_users.email]'
        ),

    ),
    'api_login' => array(
        array(
            'field' => 'user_name',
            'label' => 'User Name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|trim'
        ),
    ),
    'forgot_password' => array(
      
        array(
             'field' => 'email',
              'label' => 'Email ID',
              'rules' => 'required|trim|valid_email|callback_validateValidUser'
        ),
      ),
      'password_reset' => array(
        array(
             'field' => 'new_password',
              'label' => 'New Password',
              'rules' => 'required|trim'
        ),
        array(
             'field' => 'confirm_password',
              'label' => 'Confirm Password',
              'rules' => 'required|trim|callback_validateConfirmPassword'
        ),
      ),
    /* ====== Client Module ===== */
    'api_create_new_client' =>  array(

        array(
            'field' => 'client_name',
            'label' => 'Client Name',
            'rules' => 'required|trim|is_unique[clients.user_name]'
        ),
        array(
            'field' => 'api_key',
            'label' => 'API Key',
            'rules' => 'required|trim|callback_validateAPIKey'
        ),
        array(
            'field' => 'user_id',
            'label' => 'User Id',
            'rules' => 'required|trim|callback_validateUserId'
        )
    ),
    'api_update_client' =>  array(
    ),
    'api_list_client' =>  array(
    ),
    /* ====== Create New Database Module ===== */
    'create_new_analysis' =>  array(
        array(
            'field' => 'analysis_name',
            'label' => 'Analysis',
            'rules' => 'required|trim|is_unique[iaudit_list_analysis.analysis_name]'
        ),
        array(
            'field' => 'fk_client_id',
            'label' => 'Client Id',
            'rules' => 'required|trim|callback_validateClient'
        ),

        /*array(
            'field' => 'api_key',
            'label' => 'API Key',
            'rules' => 'required|trim|callback_validateAPIKey'
        ),
        array(
            'field' => 'create_by',
            'label' => 'Create By',
            'rules' => 'required|trim|callback_validateUserId'
        ),*/
    ),
    'api_upload_new_files' => array(
        /*array(
           'field' => 'uid',
            'label' => 'User ID',
            'rules' => 'required|trim|callback_validate_user_id'
        ),
        array(
           'field' => 'api_key',
            'label' => 'API KEY',
            'rules' => 'required|trim|callback_validate_api_key'
        ),*/
        array(
            'field' => 'userfiles',
            'label' => 'File',
            'rules' => 'callback_validateFile'
        ),
        array(
            'field' => 'upload_path',
            'label' => 'Upload Path',
            'rules' => 'required'
        ),
    ),

);