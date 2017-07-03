<?php

    $page_title = 'Login';
    $page_class = 'login';
    $page_desc  = '';

    include_once ('./assets/template/front-end/main.php');

?>

<form id="login_form" method="post" action="">
    <h1>Log In</h1>
    <?php 
        echo  $_SESSION['msg']; 
        unset($_SESSION['msg']); 
    ?>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="pe-7s-mail"></i></span>
            <input class="form-control" type="email" name="user_email" value="<?php echo $_POST['user_email']; ?>" placeholder="Email Address" />
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="pe-7s-lock"></i></span>
            <input class="form-control" type="password" name="user_password" placeholder="Password" />
        </div>
    </div>
    <div class="form-group text-center">
        <input class="btn btn-primary" type="submit" name="login_submit" value="Login" /> 
    </div>
    <div class="text-center" style="margin-top:10px;">
        <a href="./?page=forgot">I forgot my password!</a>
    </div>
</form>

<?php include_once ('./assets/template/front-end/footer.php'); ?>

<script>
    $(document).ready(function(){
        $('#login_form').validate({
            rules: { 
                user_email    : { required:true, email: true },
                user_password : { required:true }
            }
        });
    });
</script>