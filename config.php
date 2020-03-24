<?php
    $dbusername = "shreyas";
    $dbpassword = "\$t0reMyData";
    $dbname = "phpasgmt";
    $servername = "localhost";

    $conn = mysqli_connect($servername,$dbusername,$dbpassword,$dbname);

    if($conn===false){
        die("ERROR. Could not connect.".mysqli_connect_error());
    }

?>