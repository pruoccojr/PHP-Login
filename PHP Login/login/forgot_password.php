<?php

    $page_title = 'Forgot Password';
    $page_class = 'login';
    $page_desc  = '';

    include_once ('./assets/template/front-end/main.php');

?>

<form id="forgot_form" method="post" action="">
    <h1>Forgot Password</h1>
    <?php 
        echo  $_SESSION['msg']; 
        unset($_SESSION['msg']); 
        if (isset($_SESSION['reset_msg']))
        { 
            echo '<div style="padding: 20px 0; max-width: 450px; font-size: 16px; text-align: center; color: #ccc;">An email with a password reset link was sent to <strong>'.$_SESSION['user_email'].'</strong>. Please check your email and follow the instructions within.</div>';
            unset($_SESSION['reset_msg']); 
            unset($_SESSION['user_email']); 
        } 
        else
        { ?>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="pe-7s-mail"></i></span>
                    <input class="form-control" type="email" name="user_email" placeholder="Email Address" />
                </div>  
            </div>
            <div class="form-group text-center">
                <input class="btn btn-primary" type="submit" name="forgot_submit" value="Submit" /> 
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
        $('#forgot_form').validate({
            rules: { 
                user_email : { required:true, email: true },
            }
        });
    });
</script>