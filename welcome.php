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

    if(isset($_POST['get_dp'])){
        session_start();
        $username = $_SESSION['username'];
        
        $sql = "SELECT profilepic FROM shreyas_users where username='$username'";

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