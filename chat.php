<?php
include "config.php";

//create table convid_1_2 (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, message varchar(250), sender int, receiver int);
// insert into shreyas_conversations values ("convid_1_2");


if(isset($_POST['get_chat'])){
    session_start();

    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];

    $ser = htmlspecialchars($sender, ENT_QUOTES);
    $rer = htmlspecialchars($receiver, ENT_QUOTES);

    $sql = "SELECT * FROM shreyas_conversations where (sender = '$ser' AND receiver='$rer') OR (sender = '$rer' AND receiver='$ser')";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)==0){
        echo "yettobegin";
        exit();
    }else{
        while($row=mysqli_fetch_assoc($result)){
            
            $output = $row['message']."±".$row['sender'];

            echo $output."¬";
        }
        exit();
    }
}

function startconvo($sid, $rid){
    if($sid<$rid){
        $l = $sid;
        $g = $rid;
    } else{
        $l = $rid;
        $g = $sid;
    }

    $name = "shreyas_convid_".$l."_".$g;

    global $conn;
    $sqli = "create table $name (mid int NOT NULL AUTO_INCREMENT PRIMARY KEY, message varchar(12000), sender int, receiver int)";
    
    if(mysqli_query($conn, $sqli)){
        $sqli = "insert into shreyas_conversations values ('$name')";
        if(mysqli_query($conn, $sqli)){
            return $name;
        }
    } else {
        return "fail";
    }
    
}

function check($sid, $rid){
    if($sid<$rid){
        $l = $sid;
        $g = $rid;
    } else{
        $l = $rid;
        $g = $sid;
    }
    
    $name = "shreyas_convid_".$l."_".$g;
    // $name = "convid_1_2";
    
    $sqli = "SELECT * FROM shreyas_conversations where convid='$name'";
    global $conn;
    $res = mysqli_query($conn, $sqli);

    if(mysqli_num_rows($res)==0){
        return "notset";
    } else {
       while($row=mysqli_fetch_assoc($res)){
           $x = $row['convid'];
       }
       return $x;
    }

}

if(isset($_POST["check_online"])){
    $receiver = $_POST['receiver'];
    $rer = htmlspecialchars($receiver, ENT_QUOTES);
    $sql = "SELECT loggedin FROM shreyas_users where username = '$rer'";

    $request = mysqli_query($conn, $sql);

    if(mysqli_num_rows($request)==1){
        
        while($row = mysqli_fetch_assoc($request)){
            echo $row['loggedin'];
            exit();
        }
    } else{
        echo "usernotfound";
        exit();
    }
}

if(isset($_POST['sendmsg'])){
    $msg = $_POST['message'];
    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];

    $ser = htmlspecialchars($sender, ENT_QUOTES);
    $rer = htmlspecialchars($receiver, ENT_QUOTES);
    $m = htmlspecialchars($msg, ENT_QUOTES);

    $sql = "INSERT INTO shreyas_conversations (message, sender, receiver) VALUES ('$m', '$ser', '$rer')";

    if(mysqli_query($conn, $sql)){
        echo "s";
        exit();
    }else{
        echo"f";
        exit();
    }
}

?>