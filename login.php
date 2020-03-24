<?php
    include "config.php";

    if(isset($_POST['login'])){
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $sql = ("SELECT * FROM shreyas_users where username='$username' and password='$password'");
        $results = mysqli_query($conn, $sql);
        if(mysqli_num_rows($results)==1){
                echo "success";
        } else {
            echo "fail";
        }
    }


?>