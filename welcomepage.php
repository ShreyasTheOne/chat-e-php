<?php
    include "config.php";
    session_start();
    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    } else{
        $username = "NOPE";
    }
?>

<html>  
    <head>
        <title>Welcome</title>
        <link rel="stylesheet" href="iziToast.min.css">
        <link rel="stylesheet" href="welcome.css">
        <script src="iziToast.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="welcome.js"></script>
    </head>

    <body>
        <div class="container">
            <div id="welcome-user">
                    <div id="dpDivWelcome">
                        <img alt="Profile Picture" id="dpWelcome">
                        <p id="welcome-text"></p>
                    </div>
            </div>
            
            <div id="popupform">
                    <div id="pfcontent">
                        <div id="options">
                            <div id="firstOp" class="switch">
                               <p class="optiontext">Personal Information</p>
                            </div>
                            <div id="secondOp" class="switch">
                               <p class="optiontext">Change Password</p>
                            </div>
                        </div>

                         

                        <div id="firstForm" class="form">
                            <div id="firstFormContent">
                                <form name="personalinfo" id="personalinfo">
                                    <div id="fcFirstForm">
                                        <div class="oneinput">
                                            <p id="emailch">Current email:</p>
                                            <label for="emailin">New Email:</label>
                                            <input type="text" name="emailin" id="emailin">
                                        </div>
                                        <div class="oneinput">
                                            <p id="phonech">Current phone number: </p>
                                            <label for="phonein">New phone number:</label>
                                            <input type="text" name="phonein" id="phonein">
                                        </div>
                                    </div>
                                </form>
         <!-- FORM STARTS HERE-->   <form name="picUpload" id="picUpload">
                                    <div id="scFirstForm">
                                        <div id="dpDiv">
                                            <img src="pictures/def.png" alt="Profile Picture" id="dp"><!-- Change src to blank after editing onload function in js -->
                                        </div>
                                        
                                        <input type="file" id="file" name="file">
                                        <input type="button" id="uploadBtn" name="uploadBtn" value="Upload">
                                    </div> 
        <!-- FORM ENDS HERE-->  </form>
                            </div>
                        </div>
                        <div id="secondForm" class="form">
                            <div id="secondFormContent">
                                <form name="changepassword" id="changepassword">
                                    <div class="twoinput">
                                        <label for="currentpass">Current Password:</label>
                                        <input type="password" name="currentpass" id="currentpass"> 
                                    </div>
                                    <div class="twoinput">
                                        <label for="newpass">New Password:</label>
                                        <input  type="password" name="newpass" id="newpass"> 
                                    </div>  
                                    <div class="twoinput">
                                        <label for="cnfnewpass">Confirm New Password:</label>
                                        <input type="password" name="cnfnewpass" id="cnfnewpass"> 
                                    </div>  
                                </form>
                            </div>
                        </div>
    
                        <div id="cancelsubmit">
                            <div id="cancelbtn" class="switch">
                                <p class="optiontext">Cancel</p>
                             </div>
                             <div id="submitbtn" class="switch">
                                <p class="optiontext">Change</p>
                             </div>
                        </div>
                    </div>
            </div>
            <div class="content">
                
                <div class="side-pane">
                    <div class="side-pane-title">
                        <div id="profile">
                            Settings
                        </div>
                        <div id="logOff">
                            Log out
                        </div>
                    </div>
                    <div class="users-list">
                    <?php                         
                            $sql = "SELECT profilepic, username  FROM shreyas_users";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result)>0){
                                while($row = mysqli_fetch_assoc($result)) {
                                $pp = $row['profilepic'];
                                $uname = $row['username'];
                                if($uname==htmlspecialchars($username, ENT_QUOTES)){
                                    continue;
                                }
                                $output = "<div class='user_div' onclick='chatwith(`".$uname."` , `".$pp."` )' id='".$uname."'>
                                <div class='user_img_container'> <img src='".$pp."' alt='PIC' class = 'user_img'> </div>
                                <div class='user_name'> <p class='user_name_text'>".$uname." </p> </div>
                                            
                                    </div>";

                            
                                echo $output;
                                }
                               
                            } else{
                                echo "OMG";
                            }
                        ?>
                    
                    </div>
                </div>


                <div class="chat-area">
                        <div id="messages-header" class="yellowFront">
                                <div class='user_img_container'><img alt='PIC' class = 'user_img' id="chatimg"></div>
                                <div class='user_name'> <p class='user_name_text' id="chatuser"></p> </div>
                                <div id='onlinestate'></div>
                        </div>
                        <div id="messages-area" class="yellowFront">
                            
                        </div>
                        <div class="message-send-div yellowFront">
                            <div id="message-input-container"><input type="text" name="message-input" id="message-input"></div>
                            <input type ="button" value="SEND" name="msg-send-btn" id="msg-send-btn">
                        </div>
                </div>
            </div>
        </div>
    </body>
        
</html>