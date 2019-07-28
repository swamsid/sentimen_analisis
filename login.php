
<?php
    session_start();
    include 'lib/connection.php';

    if(isset($_SESSION['login'])){
        echo '<script> window.location = "index.php" </script>';
    }

     $falsed = false;

    if(isset($_POST['login'])){

        $sql = "SELECT * FROM user where us_username = '".$_POST['email']."' and us_password = '".$_POST['password']."'";
        $result = $con->query($sql) or die (mysqli_error($con));
        $counter = mysqli_num_rows($result);
        $row = $result->fetch_assoc();

        if($counter){
            $_SESSION['login'] = $row['us_id'];
            echo '<script> window.location = "index.php" </script>';
        }else{
            $falsed = true;
        }

    }
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown" style="margin-top: 30px;">
        <div>
            <h3>Selamat Datang</h3>
            <p>Login Untuk Masuk ke Halaman Utama</p>
            <?php 
                if($falsed)
                    echo '<p class="text-danger">User Tidak Bisa Ditemukan, Silahkan Coba Lagi.</p>';

             ?>
            <form class="m-t" role="form" action="login.php" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="email" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b" name="login">Login</button>

                <!-- <a href="#"><small>Forgot password?</small></a> -->
                <!-- <p class="text-muted text-center"><small>Do not have an account?</small></p> -->
                <!-- <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a> -->
            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
