<?php
    include "config.php";

    if(isset($_POST['login'])){
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $sql = ("SELECT * FROM shreyas_users where BINARY username='$username' and BINARY password='$password'");
        $results = mysqli_query($conn, $sql);
        if(mysqli_num_rows($results)==1){
            
                $sql = "UPDATE shreyas_users SET loggedin=1 where username='$username'";

                if(mysqli_query($conn, $sql)){
                    session_start();
                    $_SESSION["username"] = $username;
                    //$_SESSION["password"] = $password;
                    echo "success";
                    exit();
                } else {
                    echo "unabletologin";
                }
                
        } else {
            echo "usernotfound";
            exit();
        }
    }


?>