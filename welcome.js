var firstFormSel = true;
$("document").ready(function(){
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
});


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
    alert('HELLo');

    $.ajax({
        url: 'welcome.php' , type: 'post',

        data: {
            'req_personal_info':1
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
            }else if(repsonse=='smthww'){
                iziToast.error({
                    position: 'topCenter',
                    backgroundColor: '#eb4034',
                    title: 'Error',
                    message: 'Something went wrong.',
                });
                hideForm();
            }else if(response=='works'){
                alert('HELLo');
                var res = response.split('^');
                document.getElementById('emailch').innerHTML="works";
                document.getElementById('phonech').innerHTML=res[1];
            }else {
                alert(response);
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
        url: 'welcome.php', type:'post',

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