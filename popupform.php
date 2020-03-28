<?php
    include "config.php";

    if(isset($_POST['reset_p'])){
        session_start();
        $username = $_SESSION['username'];
        $password = sha1(trim($_POST['current_pass']));

        $use = htmlspecialchars($username, ENT_QUOTES);
        $sql = "SELECT * FROM shreyas_users where BINARY username='$use' and BINARY password='$password'";

        $results = mysqli_query($conn, $sql);
        if(mysqli_num_rows($results)==1){
            $password = sha1(trim($_POST['new_pass']));
            $sql = "UPDATE shreyas_users SET password='$password' where username='$use'";

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
        $use = htmlspecialchars($username, ENT_QUOTES);

        $sql = "SELECT * FROM shreyas_users where username='$use'";
        $request = mysqli_query($conn, $sql);

        if(! $request ) {
            echo 'dbconf';
        }else {
            if(mysqli_num_rows($request)==1){
                while($row = mysqli_fetch_assoc($request)) {
                    $eee = htmlspecialchars_decode($row['email'], ENT_QUOTES);
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

        $use = htmlspecialchars($username, ENT_QUOTES);

        if($varname == 'email'){
        
        $val = htmlspecialchars($val, ENT_QUOTES);
        $sql = "UPDATE shreyas_users SET $varname='$val' where username='$use'"; }
        else {
            $sql = "UPDATE shreyas_users SET $varname='$val' where username='$use'";
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
        $use = htmlspecialchars($username, ENT_QUOTES);

        $test = explode(".", $_FILES["file"]["name"]);
        $extension = end($test);
        $name = 'pictures/'.$use.".".$extension;

        $sql = "SELECT profilepic FROM shreyas_users where username='$use'";

        $request = mysqli_query($conn, $sql);
        if(!$request){
            echo "dbunacc";
            exit();
        } else {
            if(mysqli_num_rows($request)==1){
                while($row = mysqli_fetch_assoc($request)) {
                    if($row['profilepic']=='pictures/def.png'){
                       
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
        
        $sql = "UPDATE shreyas_users SET profilepic='$name' where username='$use'";
        if(mysqli_query($conn, $sql)){
            echo  $name;
        } else{
            echo "unabletowrite";
        }
        
        exit();
   }   

?>