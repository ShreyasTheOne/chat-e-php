<?php
    include "config.php";

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

    if(isset($_POST['rpi'])){
        session_start();
        $username = $_SESSION['username'];

        $sql = "SELECT * FROM shreyas_users where username='$username'";
        $request = mysqli_query($conn, $sql);

        if(! $request ) {
            echo 'dbconf';
        }else {
            if(mysqli_num_rows($request)==1){
                while($row = mysqli_fetch_assoc($request)) {
                    $sout = $row['email'].'^'.$row['phone'];
                    echo $sout;
                 }

            
            }else{
                echo 'smthww';
            }
        }
        exit();
    }

    if(isset($_POST['pi_update'])){
        session_start();
        $username = $_SESSION['username'];
        $val = $_POST['value'];
        $varname = $_POST['varname'];
        if($varname == 'email'){
        $sql = "UPDATE shreyas_users SET $varname='$val' where username='$username'"; }
        else {
            $sql = "UPDATE shreyas_users SET $varname=$val where username='$username'";
        }

        if(mysqli_query($conn, $sql)){
            echo "success";
            exit();
        }else {
            echo mysqli_error($conn);
            exit();
        }
    }


   
    if($_FILES["file"]["name"] != ''){
        session_start();
        $username = $_SESSION["username"];
        $test = explode(".", $_FILES["file"]["name"]);
        $extension = end($test);
        $name = 'pictures/'.$username.".".$extension;

        $sql = "SELECT profilepic FROM shreyas_users where username='$username'";

        $request = mysqli_query($conn, $sql);
        if(!$request){
            echo "dbunacc";
            exit();
        } else {
            if(mysqli_num_rows($request)==1){
                while($row = mysqli_fetch_assoc($request)) {
                    if($row['profilepic']=='pictures/defaultdp.png'){
                       
                    } else {
                        unlink($row['profilepic']);
                        move_uploaded_file($_FILES["file"]["tmp_name"], $name);
                    }
                    
                }

            }else{
                echo 'smthww';
                exit();
            }
        }
        
        $sql = "UPDATE shreyas_users SET profilepic='$name' where username='$username'";
        if(mysqli_query($conn, $sql)){
            echo  $name;
        } else{
            echo "unabletowrite";
        }
        
        exit();
   }   



?>