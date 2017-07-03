<?php 

    /*
    ==================================================================


        TEMPLATE > MAIN

        Constructs the layout for all main pages of the website.


    ==================================================================
    */

    $this_end = 'front_end';

    // Connect to database.
    include_once ('./assets/include/db-connect.php');
    if ($get_user_check != '0')
    {
        include_once ('./assets/include/db-user-check.php');
    }

    // Set the DOCTYPE and begin the document.
    echo '<!DOCTYPE HTML>';
    echo '<html>';

    // Include the <head>.
    include_once ('./assets/template/front-end/head.php'); 

    // Begin the <body>.
    echo '<body class="'.$page_class.'">';

        // Include the header.
        if ($page_class != 'login')
        {
            include_once ('./assets/template/front-end/header.php'); 
        }

        // Begin the page content.
        echo '<div id="content">';

        ?>