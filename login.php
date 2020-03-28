<?php
    include "config.php";

    if(isset($_POST['login'])){
        $username = trim($_POST['username']);
        $password = sha1(trim($_POST['password']));
        
        $use = htmlspecialchars($username, ENT_QUOTES);
        $sql = ("SELECT * FROM shreyas_users where BINARY username='$use' and BINARY password='$password'");
        $results = mysqli_query($conn, $sql);
        if(mysqli_num_rows($results)==1){

            
            if($_POST['rememberme'] === "true"){

                $cookiegen = sha1("I am ".$use."-locked".mt_rand(10, 1000).mt_rand(10, 1000));

                $sql = "UPDATE shreyas_users SET cookie='$cookiegen' where username='$use'";
                if(mysqli_query($conn, $sql)){
                    //set cookie
                    setcookie("user_hash", $cookiegen, time() + (86400 * 30), "/");
                } else {
                    echo "unabletologin";
                    exit();
                }
            }

                $sql = "UPDATE shreyas_users SET loggedin=1 where username='$use'";

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