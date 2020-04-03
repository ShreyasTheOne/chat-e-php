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
        <title>Log In</title>
        <link href="login.css" rel="stylesheet">
        <link rel="stylesheet" href="iziToast.min.css">
        <script src="iziToast.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="login.js"></script>

    </head>

    <body>
        <div class="container">
           
            <div class="content backgroundIn">
                <form name="loginForm" id ="loginForm" autocomplete="off"></form>
                    <div id="apptitle">Chat-e-php</div>
                    <div class="login">
                        Log in
                    </div>
                    <div class="suinput">
                        <input class="suintext backgroundIn" type="text" name="uname" id="uname" placeholder="Username" autocomplete="off">
                        <p id="uname_error" class="error_message"></p> 
                    </div>

                    <div class="suinput">
                        <input class="suintext backgroundIn" type="password" name="psswd" id="psswd" placeholder="Password">
                    </div>
                    <div class="surinput">
                        <input type="checkbox" id="rememberme" name="rememberme" value="rememberme">
                        <label for="rememberme"> Remember me</label>
                    </div>
                    
                    <input type="button" name="submit" id="loginBtn" value="LOGIN">
                    <div id="already">Don't have an account? <a href="signuppage.php">Create an account</a></div>

                    
                </form>    
            </div>
        </div>

    </body>
</html>