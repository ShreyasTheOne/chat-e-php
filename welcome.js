var firstFormSel = true;
var dpsrc="";
var es=0, ps=0, ec=0, pc=0;
$("document").ready(function(){
   listUsers();

    $("#logOff").on('click', function(){
        iziToast.show({
            theme: 'light',
            icon: 'icon-person',
            title: '',
            message: 'Confirm log out?',
            position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
            progressBarColor: 'rgb(0, 255, 184)',
            buttons: [
                ['<button>Yes</button>', function (instance, toast) {
                    window.location='welcome.php?logout=true';
                }, true], // true to focus
                ['<button>No</button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOutUp',
                        onClosing: function(instance, toast, closedBy){
                            showHomeScreen(); // The return will be: 'closedBy: buttonName'
                        }
                    }, toast, 'buttonName');
                }]
            ],
            onOpening: function(instance, toast){
                console.info('callback abriu!');
            },
            onClosing: function(instance, toast, closedBy){
                console.info('closedBy: ' + closedBy); // tells if it was closed by 'drag' or 'button'
            }
        }); 

    });

    $('#profile').on('click', function(){
       openForm();
       
    });
   
    $('#firstOp').on('click', function(){
        firstFormSel = true;
        selectForm("firstForm", "secondForm");
    });

    $('#secondOp').on('click', function(){
        firstFormSel = false;
        selectForm("secondForm", "firstForm");
    });

    $('#submitbtn').on('click', function(){
        if(firstFormSel){
            submitFormOne();
        }else{
            var cp = $('#currentpass').val();
            var np = $('#newpass').val();
            var cnp = $('#cnfnewpass').val();

            if(cp==''||np==''||cnp==''){
                iziToast.error({
                    position: 'topCenter',
                    backgroundColor: '#eb4034',
                    title: 'Error',
                    message: 'Please fill all fields.',
                });
            } else if (np!==cnp){
                iziToast.error({
                    position: 'topCenter',
                    backgroundColor: '#eb4034',
                    title: 'Error',
                    message: 'Passwords don\'t match.',
                });
            } 
            else{
                resetPassword(cp, np);
            }
        }
    });

    $('#cancelbtn').on('click', function(){
        hideForm();
    });

    $('#uploadBtn').on('click', function(){
        var image = document.getElementById('file').files[0];
        var img_name = image.name;
        var img_ext = img_name.split('.').pop().toLowerCase();
        
        if(jQuery.inArray(img_ext, ['jpg', 'jpeg', 'png']) == -1){
            iziToast.error({
                position: 'topCenter',
                backgroundColor: '#eb4034',
                title: 'Error',
                message: 'Image must be of type jpg, jpeg, or png.',
            });
            return;
        } else {
            var img_size = image.size;
            if(img_size>500000){
                iziToast.error({
                    position: 'topCenter',
                    backgroundColor: '#eb4034',
                    title: 'Error',
                    message: 'Image is too large (Max size 500kb).',
                });
                return;
            } else {
                var formData = new FormData();
                formData.append("file", image);

                $.ajax({
                    url: 'popupform.php', type: 'post',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response){
                        if(response=="dbunacc"){
                            iziToast.error({
                                position: 'topCenter',
                                title: 'Error',
                                message: 'Database not accessible.',
                            });
                        } else if(response == "smthww"){
                            iziToast.error({
                                position: 'topCenter',
                                title: 'Error',
                                message: 'Something went wrong.',
                            });
                        } else if(response=="unabletowrite"){
                            iziToast.error({
                                position: 'topCenter',
                                title: 'Error',
                                message: 'Unable to write to database.',
                            });
                        } else {
                            iziToast.success({
                                position: 'topCenter',
                                title: 'NOICE',
                                message: 'Profile picture changed.',
                            });
                            updateDP(response);
                        }
                    }
                });
            }
        }
    });
});


function listUsers(){
    $.ajax({
        url: 'welcome.php', type: 'post',

        data: {
            'get_dp': 1
        },

        success(response){
            if(response=='dbunacc'){
                iziToast.error({
                    position: 'topCenter',
                    title: 'Error',
                    message: 'Unable to access to database.',
                });
            }else if(response == "smthww"){
                iziToast.error({
                    position: 'topCenter',
                    title: 'Error',
                    message: 'Something went wrong.',
                });
            } else{
                var dpsrc=response;
                updateDP(dpsrc);
            }
        }
    });
}

function openForm(){
    document.getElementById("popupform").style.display="block";
    if(firstFormSel){
        selectForm("firstForm", "secondForm");
        setupFormOne();
    } else{
        selectForm("secondForm", "firstForm");
    }
}

function hideForm(){
    document.getElementById("popupform").style.display="none";
}

function setupFormOne(){
   

    $.ajax({
        url: 'popupform.php' , type: 'post',

        data: {
            'rpi':1,
        },

        success: function(response){
            if(response=='dbconf'){
                iziToast.error({
                    position: 'topCenter',
                    backgroundColor: '#eb4034',
                    title: 'Error',
                    message: 'Failed to connect to database.',
                });
                hideForm();
            }else if(response=='smthww'){
                iziToast.error({
                    position: 'topCenter',
                    backgroundColor: '#eb4034',
                    title: 'Error',
                    message: 'Something went wrong.',
                });
                hideForm();
            } else {
                //alert(response);
                var res = response.split('^');
                document.getElementById('emailch').innerHTML="Current email: " + res[0];
                document.getElementById('phonech').innerHTML="Current phone number: "+res[1];
            }
        }   
    });

    $('#emailin').on('blur', function(){
        $email = $('#emailin').val().toLowerCase();
        if($email==''){
            es=1;
            ec = 0;
        } else{
            $.ajax({
                url: 'signup.php', type: 'post',
                data: {
                    'e_check': 1,
                    'email': $email
                },
    
                success: function(response){    
                    if(response=="invalid email"){
                        // document.getElementById("email_error").innerHTML = "Invalid email address.";
                        iziToast.error({
                            position: 'topCenter',
                            backgroundColor: '#eb4034',
                            title: 'Error',
                            message: 'Invalid email format.',
                        });
                        es=0;
                        ec=1;
                    } else if(response == "taken"){
                        iziToast.error({
                            position: 'topCenter',
                            backgroundColor: '#eb4034',
                            title: 'Error',
                            message: 'Account already exists with this email address.',
                        });
                        es=0;
                        ec=1;
                    } else if(response == "not_taken"){
                       
                        es=1;
                        ec=1;
                    }
                }
            });
        }
        
    });

    $('#phonein').on('blur', function(){
        var phone = $('#phonein').val();

        if(phone==''){
            ps = 1;
            pc = 0;
        } else{
            $.ajax({
                url: 'signup.php', type: 'post',
    
                data: {
                    'phone': phone,
                    'p_check': 1
                },
    
                success: function(response){
                    if(response=="invalid phone"){
                        iziToast.error({
                            position: 'topCenter',
                            backgroundColor: '#eb4034',
                            title: 'Error',
                            message: 'Phone number invalid.',
                        });
                        ps = 0;
                        pc=1;
                    } else if(response == "taken"){
                        iziToast.error({
                            position: 'topCenter',
                            backgroundColor: '#eb4034',
                            title: 'Error',
                            message: 'Account already exists with this phone number.',
                        });
                        ps = 0;
                        pc=1;
                    } else if(response == "not_taken"){
                        
                        ps = 1;
                        pc=1;
                    }
                }
            });
        }
        
    });


}

function submitFormOne(){
    if(pc==0 && ec==0){
        iziToast.error({
            position: 'topCenter',
            backgroundColor: '#eb4034',
            title: 'Error',
            message: 'Cannot leave both fields empty.',
        });
    } else if(pc==0 && ec==1){
        if(es==0){
            iziToast.error({
                position: 'topCenter',
                backgroundColor: '#eb4034',
                title: 'Error',
                message: 'Email invalid/unavailable.',
            });  
        }else{
            updateEmail();
        }
       
    } else if (pc==1 && ec==0){
        if(ps==0){
            iziToast.error({
                position: 'topCenter',
                backgroundColor: '#eb4034',
                title: 'Error',
                message: 'Phone number invalid/unavailable.',
            });  
        }else{
            updatePhone();
        }
    } else {
        if(es==0){
            iziToast.error({
                position: 'topCenter',
                backgroundColor: '#eb4034',
                title: 'Error',
                message: 'Email invalid/unavailable.',
            });  
        }else{
            updateEmail();
        }
        if(ps==0){
            iziToast.error({
                position: 'topCenter',
                backgroundColor: '#eb4034',
                title: 'Error',
                message: 'Phone number invalid/unavailable.',
            });  
        }else{
            updatePhone();
        }
    }
}

function updateEmail(){
    let e = $("#emailin").val();

    $.ajax({
        url: 'popupform.php', type: 'post',

        data: {
            'value': e,
            'varname': 'email',
            'pi_update': 1
        },
         success: function(response){
              if(response=="success"){
                  iziToast.success({
                      position: 'topCenter',
                      title: 'NOICE',
                      message: 'Email updated successfully.',
                      timeout: 3000
                  });
                  document.getElementById("emailin").value="";
                 hideForm();
              } else {
                  iziToast.error({
                      title: 'Bummer',
                      position: 'topCenter',  
                      message: 'Email update failed',
                  });
                  //window.location.replace('login.html');
              }
         }
    });
}

function updatePhone(){
    let p = $("#phonein").val();

    $.ajax({
        url: 'popupform.php', type: 'post',

        data: {
            'value': p,
            'varname': 'phone',
            'pi_update': 1
        },
         success: function(response){
              if(response=="success"){
                  iziToast.success({
                      position: 'topCenter',
                      title: 'NOICE',
                      message: 'Phone number updated successfully.',
                      timeout: 3000
                  });
                  hideForm();
                  document.getElementById("phonein").value="";
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
}

function selectForm(form, nform){
    document.getElementById(form).style.display = "block";
    document.getElementById(nform).style.display = "none";

    if(firstFormSel == true){
        op = "firstOp";
        nop = "secondOp";
    } else {
        nop = "firstOp";
        op = "secondOp";
    }
    let a = document.getElementById(op);
    let b = document.getElementById(nop);

    a.style.borderRight = "1px solid #000000";
    a.style.borderTop = "1px solid #000000";
    a.style.borderLeft = "1px solid #000000";
    a.style.borderBottom = "0px solid #000000";
    b.style.borderBottom = "1px solid #000000";
    b.style.borderTop = "0px solid #000000";
    b.style.borderRight = "0px solid #000000";
    b.style.borderLeft = "0px solid #000000";
}

function resetPassword(cp, np){


    $.ajax({
        url: 'popupform.php', type:'post',

        data: {
            'reset_p': 1,
            'current_pass': cp,
            'new_pass': np
        },

        success: function(response){
            if(response=="success"){
                iziToast.success({
                    position: 'topCenter',
                    title: 'NOICE',
                    message: 'Password changed!',
                    timeout: 3000
                });

                hideForm();
            } else if(response=="wcp"){
                iziToast.error({
                    position: 'topCenter',
                    backgroundColor: '#eb4034',
                    title: 'Error',
                    message: 'Current password is incorrect.',
                });
            } else if(response=="failed"){
                iziToast.error({
                    position: 'topCenter',
                    backgroundColor: '#eb4034',
                    title: 'Error',
                    message: 'Something went wrong.',
                });
            }
        }
    });
}

function updateDP(newurl){
    $("#dp").attr('src', newurl);
}

