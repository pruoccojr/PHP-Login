<?php

    $getID    = $_GET['id'];
    $getToken = $_GET['token'];

    // Log into the system.
    if (isset($_POST['login_submit']))
    {
        if (empty($_POST['user_email']) || empty($_POST['user_password']))
        {
            $_SESSION['msg'] = '<spdivan class="alert alert-danger">Both fields are required. <i class="close_alert pe-7s-close"></i></div>';
        } 
        else 
        {
            if ($select = $db -> prepare("SELECT id FROM users WHERE email = ? AND password = ?"))
            {
                $email    = $_POST['user_email'];
                $password = md5($_POST['user_password']);
                $select -> bind_param('ss', $email, $password);
                $select -> execute();
                $select -> store_result();
                $select -> bind_result($current_id);
                $select -> fetch();
                if ($select -> num_rows == '1')
                {
                    session_start();
                    $_SESSION['email'] = $email; 

                    if ($update = $db -> prepare("UPDATE users SET lastlogin = ? WHERE email = ? and password = ?"))
                    {
                        $now = date('Y-m-d H:i:s');
                        $update -> bind_param('sss', $now, $email, $password);
                        $update -> execute();
                        $update -> close();
                    }
                    header ('Location: ./manage/index.php');
                    die();
                }
                else 
                {
                    $_SESSION['msg'] = '<div class="alert alert-danger">Incorrect username or password. <i class="close_alert pe-7s-close"></i></div>';
                    header ('Location: ./');
                    die();
                }

                $select -> close();
            }
        }
    }

    // Forgot password.
    if (isset($_POST['forgot_submit']))
    {              
        require_once ('./assets/phpmailer/class.phpmailer.php');
        
        if ($select = $db -> prepare("SELECT id, fname, email FROM users WHERE email = ?"))
        {
            $email    = $_POST['user_email'];
            $select -> bind_param('s', $email);
            $select -> execute();
            $select -> store_result();
            $select -> bind_result($current_id, $user_fname, $user_email);
            $select -> fetch();
            if ($select -> num_rows == '1')
            {
                $_SESSION['user_fname'] = $user_fname;
                $_SESSION['user_email'] = $user_email;
                
                if ($update = $db -> prepare("UPDATE users SET token = ? WHERE id = ?"))
                {
                    $new_token = md5(time().uniqid());
                    $update -> bind_param('ss', $new_token, $current_id);
                    if ($update -> execute() == true)
                    {
                        $email_to      =  $user_fname;
                        $email_title   =  'Password Recovery';
                        $email_body    =  '
                            It looks like you\'ve forgotten your password and requested to have it reset. Please click or copy/paste the URL below to 
                            choose a new password. Your password change will take effect immediately and you will be brought back to the login page.<br /><br />
                            
                            <a href="YOUR DOMAIN/login.php?page=reset&id='.$current_id.'&token='.$new_token.'">     
                                YOUR DOMAIN/login.php?page=reset&id='.$current_id.'&token='.$new_token.'            
                            </a>
                        ';
                        
                        try
                        {
                            $mail               = new PHPMailer(true);
                            $mail -> IsHTML     (true);
                            $mail -> Subject    = 'Forgotten Password';
                            $mail -> AddAddress ($email);
                            $mail -> From       = 'noreply@yourdomain.com';     // Emails will come from this email address.
                            $mail -> FromName   = 'YOUR NAME';                  // Emails will come from this name.
                            $mail -> Body       = $email_body;
                            $mail -> send();
                            $_SESSION['reset_msg'] = 'Show';
                            header ('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
                            die ();
                        } 
                        catch (phpmailerException $e)
                        {
                            $_SESSION['msg'] = '<div class="alert alert-danger"><i class="close_alert pe-7s-close"></i>'.$e->errorMessage().'</div>';
                        }
                        catch (Exception $e)
                        {
                            $_SESSION['msg'] = '<div class="alert alert-danger"><i class="close_alert pe-7s-close"></i>'.$e->getMessage().'</div>';
                        }
                    }
                    else 
                    {
                        $_SESSION['msg'] = '<div class="alert alert-danger">The token failed to update. <i class="close_alert pe-7s-close"></i></div>';
                    }
                    $update -> close();
                }
            }
            if ($select -> num_rows == '0')
            {
                $_SESSION['msg'] = '<div class="alert alert-danger">The email address was not found. <i class="close_alert pe-7s-close"></i></div>';
            }
        }
    }

    // Reset password.
    if (isset($_POST['reset_submit']))
    {
        if ($select = $db -> prepare("SELECT id, token FROM users WHERE id = ?"))
        {
            $select -> bind_param('s', $getID);
            $select -> execute();
            $select -> bind_result($user_id, $user_token);
            $select -> fetch();
            $select -> close();
        }
        if ($getID == $user_id && $getToken == $user_token)
        {
            if ($update = $db -> prepare("UPDATE users SET password = ?, token = ? WHERE id = ?"))
            {
                $new_password  =  md5($_POST['password']);
                $no_token      =  NULL;
                $update -> bind_param('sss', $new_password, $no_token, $getID);
                if ($update -> execute() == true)
                {
                    $_SESSION['msg'] = '<div class="alert alert-success">Password changed. Please log in. <i class="close_alert pe-7s-close"></i></div>';
                    header ('Location: ./');
                    die ();
                }
                else
                {
                    $message = '<div class="alert alert-danger">'.$update -> error.' <i class="close_alert pe-7s-close"></i></div>';
                }
                $update -> close();
            }
        }
    }

?>