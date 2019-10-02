<?php 

    //if you are referring to a session you MUST start the session
    session_start();

    //destroy the session
    session_destroy();

    //redirect to login page
    header('Location: index');
