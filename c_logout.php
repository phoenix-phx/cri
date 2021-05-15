<?php
    session_start();
    session_destroy();
    header('Location: splash.php');
    return;
?>
