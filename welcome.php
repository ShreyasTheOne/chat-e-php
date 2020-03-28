<?php
    include "config.php";

    if(isset($_POST['check_login'])){
        session_start();
        if(isset($_SESSION['username'])){
            echo $_SESSION['username'];
            exit();
        } else{
            echo "fail";
            session_destroy();
            exit();
        }
    }


    if(isset($_GET["logout"])){
        session_start();
        $username = $_SESSION["username"];
        $use = htmlspecialchars($username, ENT_QUOTES);
        $sql = "UPDATE shreyas_users SET loggedin=0 where username='$use'";

        if(mysqli_query($conn, $sql)){
            setcookie("user_hash", "", 1, "/");
            session_destroy();
            header("Location: loginpage.php");
        } else {
            echo mysqli_error($conn);
            exit();
        }

    }

    if(isset($_POST['get_dp'])){
        session_start();
        $username = $_SESSION['username'];
        $use = htmlspecialchars($username, ENT_QUOTES);
        
        $sql = "SELECT profilepic FROM shreyas_users where username='$use'";

        $request = mysqli_query($conn, $sql);
        if(!$request){
            echo "dbunacc";
            exit();
        } else {
            if(mysqli_num_rows($request)==1){
                while($row = mysqli_fetch_assoc($request)) {
                    echo $row['profilepic'];
                    exit();
                }

            }else{
                echo 'smthww';
                exit();
            }
        }
    }

?>