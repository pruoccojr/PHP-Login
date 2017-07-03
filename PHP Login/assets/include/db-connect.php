<?php

    $config = include_once ('config.php');

    $db = mysqli_connect(
        $config -> host,
        $config -> user,
        $config -> pass,
        $config -> data
    );

    if (!$db)
    {
        die('Connection failed: '.mysqli_connect_error());
    }

?>