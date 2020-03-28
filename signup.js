var us=0, passs=0, es=0, ps=0, gs=0 ;

$('document').ready(function(){
 
    $('#username').on('input', function(){
        
        var username = $('#username').val();
        
        $.ajax({
            url: 'signup.php', type: 'post',

            data: {
                'u_check' : 1,
                'username' : username,
            },

            success: function(response){

                if(response=='taken'){
                    document.getElementById("uname_error").innerHTML = "Username taken.";
                    us=0;
                } else if (response=='not_taken'){
                    document.getElementById("uname_error").innerHTML = "";
                    us=1;
                } else if (response=="length_error"){
                    document.getElementById("uname_error").innerHTML = "Username must be 6-10 characters long.";
                    us=0;
                }
            }

        });

    });

    $('#email').on('input', function(){
        $email = $('#email').val().toLowerCase();

        $.ajax({
            url: 'signup.php', type: 'post',
            data: {
                'e_check': 1,
                'email': $email
            },

            success: function(response){
                if(response=="invalid email"){
                    document.getElementById("email_error").innerHTML = "Invalid email address.";
                    es=0;
                } else if(response == "taken"){
                    document.getElementById("email_error").innerHTML = "Account already exists with this email address.";
                    es=0;
                } else if(response == "not_taken"){
                    document.getElementById("email_error").innerHTML = "";
                    es=1;
                }
            }
        });
    });


    $('#cnfpassword').on('input', function(){
        var cnfpass = $('#cnfpassword').val();
        var pass = $('#password').val(); 

        if(cnfpass!=pass){
            document.getElementById("cnfp_error").innerHTML = "Passwords don't match";
            passs=0;
        } else {
            document.getElementById("cnfp_error").innerHTML = "";
            passs=1;
            // alert(passs);
        }
    });

    
    $('#phone').on('input', function(){
        var phone = $('#phone').val();

        $.ajax({
            url: 'signup.php', type: 'post',

            data: {
                'phone': phone,
                'p_check': 1
            },

            success: function(response){
                if(response=="invalid phone"){
                    document.getElementById("phone_error").innerHTML = "Invalid phone number.";
                    ps = 0;
                } else if(response == "taken"){
                    document.getElementById("phone_error").innerHTML = "Account already exists with this phone number.";
                    ps = 0;
                } else if(response == "not_taken"){
                    document.getElementById("phone_error").innerHTML = "";
                    ps = 1;
                }
            }
        });
    });

    $("#submitBtn").on('click', function(){
        
        if (us==0){
            iziToast.warning({
                position: 'topRight',
                backgroundColor: '#eb4034',
                title: 'Bro pls',
                message: 'Invalid username',
                });
        }

        // alert("es "+ es);
        if (passs==0){
            iziToast.warning({
                position: 'topRight',
                backgroundColor: '#eb4034',
                title: 'Bruh',
                message: 'Passwords don\'t match',
            });
        }

        if (es==0){
            iziToast.warning({
                position: 'topRight',
                backgroundColor: '#eb4034',
                title: 'No, pls',
                message: 'Invalid email',
            });
        }
        // alert(ps);

        if (ps==0){
            iziToast.warning({
                title: 'Srsly?',
                backgroundColor: '#eb4034',
                position: 'topRight',
                message: 'Invalid phone number',
            });
        }
        // alert(passs);
        if ($('input[name=sex]:checked').length == 0) {
            gs=0;
            // do something here
            iziToast.warning({
                title: '-_-',
                backgroundColor: '#eb4034',
                position: 'topRight',
                message: 'Select a gender',
            });
        } else{
            gs=1;
        }

        if(us==1&&passs==1&&es==1&&ps==1&&gs==1){
            let u = $("#username").val();
            let pps = $("#password").val();
            let e = $("#email").val();
            let p = $("#phone").val();
            let g;
            if(document.getElementById('male').checked) {
                //Male radio button is checked
                g = "male";
              }else if(document.getElementById('female').checked) {
                //Female radio button is checked
                g = "female";
              }

              $.ajax({
                  url: 'signup.php', type: 'post',

                  data: {
                      'username': u,
                      'password': pps,
                      'email': e,
                      'phone': p,
                      'sex': g,
                      'total_check': 1
                  },
                   success: function(response){
                        if(response=="reg_success"){
                            iziToast.success({
                                position: 'topCenter',
                                title: 'NOICE',
                                message: 'Registration successful! Redirecting to login page...',
                                timeout: 3000
                            });
                            setTimeout(function(){window.location.replace('login.html')}, 3000);
                        } else {
                            iziToast.error({
                                title: 'Bummer',
                                position: 'topCenter',  
                                message: response,
                            });

                            //window.location.replace('login.html');
                        }
                   }
              });

        } else {
                //alert("fail");
               // window.location.replace('signup.html');
        }
});
    
});