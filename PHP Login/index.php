<?php

    session_start();
    $get_user_check = 0;
    
    include_once ('./assets/include/db-connect.php');
    include_once ('./login/functions.php');

    switch($_GET['page'])
    {
        case 'logout':
            session_start();
            session_destroy();
            header ('Location: ./login.php');
        break;
        case 'forgot':  include_once ('./login/forgot_password.php'); break;
        case 'reset':   include_once ('./login/reset_password.php'); break;
        default:        include_once ('./login/index.php'); break;
    }

?>