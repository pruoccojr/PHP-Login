<?php

    session_start();

    if ($select = $db -> prepare("SELECT user.id, pivot.client_id, user.fname, user.lname, user.phone, user.phone2, user.email, user.image, user.access FROM users AS user INNER JOIN pivot ON user.id = pivot.user_id WHERE user.email = ?"))
    {
        $email_check = $_SESSION['email'];
        $select -> bind_param('s', $email_check);
        $select -> execute();
        $select -> store_result();
        $select -> bind_result($session_id, $session_client_id, $session_fname, $session_lname, $session_phone, $session_phone2, $session_email, $session_image, $session_access);
        $select -> fetch();
        if ($select -> num_rows != '1')
        {
            header ('Location: ../');
            die();
        }
        $select -> close();
    }

?>