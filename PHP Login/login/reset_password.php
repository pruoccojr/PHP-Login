<?php

    $page_title = 'Reset Password';
    $page_class = 'login';
    $page_desc  = '';

    if (isset($_GET['id'], $_GET['token']))
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
            $display_form = '1';
        }
        else 
        {
            $display_form = '0';
            $message = '<div style="padding: 20px 0; max-width: 450px; font-size: 16px; text-align: center; color: #ccc;">Either you have already changed your password using this link or you have followed an incorrect link.</div>';
        }
    } 
    else 
    {
        $display_form = '0';
        $_SESSION['msg'] = '<div class="alert alert-danger">That user does not exist. <i class="pe-7s-close"></i></div>';
    }

    include_once ('./assets/template/front-end/main.php');

?>

<form id="reset_form" method="post" action="">
    <?php 
        if ($display_form == '0')
        {
            echo '<h1>Invalid Token</h1>';
            echo $message;
        }
        else
        { ?>
            <h1>Choose a New Password</h1>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="pe-7s-lock"></i></span>
                    <input class="form-control" type="password" id="password" name="password" placeholder="New Password" />
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="pe-7s-lock"></i></span>
                    <input class="form-control" type="password" id="password_verify" name="password_verify" placeholder="Confirm New Password" />
                </div>
            </div>
            <div class="form-group text-center">
                <input class="btn btn-primary" type="submit" name="reset_submit" value="Submit" /> 
            </div>
        <? } 
    ?>
    <div class="text-center" style="margin-top:10px;">
        <a href="./">Back to Login</a>
    </div>
</form>

<?php include_once ('./assets/template/front-end/footer.php'); ?>

<script>    
    $(document).ready(function(){
        $('#reset_form').validate({
            rules: { 
                password         : { required: true },
                password_verify  : { equalTo: '#password'}
            }
        });
    });
</script>