<?php

    include "config.php";

    if(isset($_POST["u_check"])){
        $username = $_POST["username"];
        if(strlen(trim($username))<6||strlen(trim($username))>10){
            //LENGTH ERROR
            echo "length_error";
            exit();
        }

        $sql = "SELECT * FROM shreyas_users WHERE username='$username'";
        $results = mysqli_query($conn, $sql);

        if (mysqli_num_rows($results) > 0) {
            echo "taken";	
          }else{
            echo 'not_taken'; 
          }
          exit();
    }


    if(isset($_POST["e_check"])){
        $email = $_POST['email'];

        if(!preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/',$email)){
            echo "invalid email"; 
            exit();
        }

        $sql = "SELECT * FROM shreyas_users WHERE email='$email'";
        $results = mysqli_query($conn, $sql);

        if (mysqli_num_rows($results) > 0) {
            echo "taken";	
        }else{
            echo 'not_taken';
        }

        exit();
    }

    if(isset($_POST['p_check'])){
        $phone = $_POST['phone'];

        if(!preg_match('/^[123456789][\d]{9}$/', $phone)){
            echo "invalid phone";
            exit();
        }

        $sql = "SELECT * FROM shreyas_users WHERE phone='$phone'";
        $results = mysqli_query($conn, $sql);

        if (mysqli_num_rows($results) > 0) {
            echo "taken";	
        }else{
            echo 'not_taken';
        }
        exit();
    }

    if(isset($_POST["total_check"])){
        
        $username = $_POST["username"];
        $password = sha1(trim($_POST["password"]));
        $sex = $_POST["sex"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];

        $sql = ("INSERT INTO shreyas_users (username, password, email, phone, sex) VALUES ('$username','$password','$email','$phone','$sex')");

        if(mysqli_query($conn, $sql)){
            echo 'reg_success';
            
        } else {
            echo mysqli_error($conn);
        }
    }   
?>