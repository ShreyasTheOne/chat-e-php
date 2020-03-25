<?php
    include "config.php";

    if(isset($_GET["logout"])){
        session_start();
        $username = $_SESSION["username"];
        
        $sql = "UPDATE shreyas_users SET loggedin=0 where username='$username'";

        if(mysqli_query($conn, $sql)){
            session_destroy();
            header("Location: login.html");
        } else {
            echo mysqli_error($conn);
            exit();
        }

    }

    if(isset($_POST['reset_p'])){
        session_start();
        $username = $_SESSION['username'];
        $password = $_POST['current_pass'];
        $sql = "SELECT * FROM shreyas_users where BINARY username='$username' and BINARY password='$password'";

        $results = mysqli_query($conn, $sql);
        if(mysqli_num_rows($results)==1){
            $password = $_POST['new_pass'];
            $sql = "UPDATE shreyas_users SET password='$password' where username='$username'";

            if(mysqli_query($conn, $sql)){
                echo 'success';
                exit();
            }else{
                echo 'failed';
                exit();
            }
        } else{
            echo 'wcp';
            exit();
        }

    }

    if(isset($_POST['req_personal_info'])){
        session_start();
        $username = $_SESSION['username'];

        $sql = "SELECT * FROM shreyas_users where username='$username'";
        $request = mysqli_query($conn, $sql);

        if(! $request ) {
            echo 'dbconf';
        }else {
            if(mysqli_num_rows($request)==1){
                while($row = mysql_fetch_array($request, MYSQL_ASSOC)) {
                    // echo "$row[email]"."^"."$row[phone]";
                    echo "works";
                 }
            }else{
                echo 'smthww';
            }
        }
        exit();
    }


?>