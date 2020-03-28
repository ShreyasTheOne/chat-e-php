<?php
    include "config.php";

    if(isset($_COOKIE["user_hash"])){
        $cookie = $_COOKIE["user_hash"];
        $sql = "SELECT username FROM shreyas_users where cookie = '$cookie'";

        $request = mysqli_query($conn, $sql);
        if(mysqli_num_rows($request)==1){
            while($row = mysqli_fetch_assoc($request)){
                    session_start();
                    $_SESSION["username"] = htmlspecialchars_decode($row['username'], ENT_QUOTES);
                    header("Location: welcomepage.php");
            }
        }
    }
?>


<html>
    <head>
        <title>Sign Up</title>
        <link href="signup.css" rel="stylesheet">
        <link rel="stylesheet" href="iziToast.min.css">
        <script src="iziToast.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="signup.js"></script>

    </head>

    <body>
        <div class="container">
           
            <div class="content backgroundIn">
                <form name="signupForm" id ="signupForm" autocomplete="off"></form>
                    <div id="apptitle">Chat-e-php</div>
                    <div class="signup">
                        Sign Up
                    </div>
                    <div class="suinput">
                        <input class="suintext backgroundIn" type="text" name="username" id="username" placeholder="Username" autocomplete="off">
                        <p id="uname_error" class="error_message"></p> 
                    </div>

                    <div class="suinput">
                        <input class="suintext backgroundIn" type="password" name="password" id="password" placeholder="Password">
                    </div>

                    <div class="suinput backgroundIn">
                        <input class="suintext backgroundIn" type="password" name="cnfpassword" id="cnfpassword" placeholder="Confirm Password">
                        <p id="cnfp_error" class="error_message"></p> 
                    </div>

                    <div class="suginput">
                        <div id="sex">Sex -</div>
                        <div id="radio">
                            <label for="sex">Male</label>
                            <input type="radio" id="male" name="sex" value="male">
                            <label for="sex">Female</label>
                            <input type="radio" id="female" name="sex" value="female">
                        </div>
                    </div>

                    <div class="suinput">
                        <input class="suintext backgroundIn" type="text" name="email" id="email" placeholder="Email" autocomplete="off">
                        <p id="email_error" class="error_message"></p>
                    </div>

                    <div class="suinput">
                        <input class="suintext backgroundIn" type="text" name="phone" id="phone" placeholder="Mobile Number" autocomplete="off"><br>
                        <p id="phone_error" class="error_message"></p> 
                    </div>

                    <input type="button" name="submit" id="submitBtn" value="SIGN UP">
                    <div id="already">Already have an account? <a href="loginpage.php">Log in</a></div>
                </form>    
            </div>
        </div>

    </body>
</html>