<?php
    // $dbusername = "shreyas";
    // $dbpassword = "\$t0reMyData";
    // $dbname = "phpasgmt";
    // $servername = "localhost";

    $dbusername = "first_year";
    $dbpassword = "first_year";
    $dbname = "first_year";
    $servername = "localhost";

    $conn = mysqli_connect($servername,$dbusername,$dbpassword,$dbname);

    if($conn===false){
        die("ERROR. Could not connect.".mysqli_connect_error());
    }

?>