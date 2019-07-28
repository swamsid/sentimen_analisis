
<?php
    session_start();
    include 'lib/connection.php';

    if(!isset($_SESSION['login']))
        echo '<script> window.location = "login.php" </script>';

    session_destroy();
    echo '<script> window.location = "login.php" </script>';
?>