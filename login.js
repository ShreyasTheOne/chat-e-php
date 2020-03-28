
$("document").ready(function(){

    $("#loginBtn").on('click',function(){
        var checkedValue = document.getElementById("rememberme").checked;
        var username = $("#uname").val();
        var password = $("#psswd").val();
        // alert(checkedValue)
        if(username===""||username==null){
            iziToast.error({
                title: 'Error',
                position: 'topCenter',
                backgroundColor: '#eb4034',
                message: 'Username field cannot be empty',
            });

        } else if(password===""||password==null){
            iziToast.error({
                title: 'Error',
                position: 'topCenter',
                backgroundColor: '#eb4034',
                message: 'Password field cannot be empty',
            });

            return;
        } else {
            loginUser(username, password, checkedValue);
        }
    });

    $('#uname').keyup(function(event){
        if(event.keyCode==13){
        var checkedValue = document.getElementById("rememberme").checked;
        var username = $("#uname").val();
            var password = $("#psswd").val();

            if(username===""||username==null){
                iziToast.error({
                    title: 'Error',
                    position: 'topCenter',
                backgroundColor: '#eb4034',
                    message: 'Username field cannot be empty',
                });

            } else if(password===""||password==null){
                iziToast.error({
                    title: 'Error',
                    position: 'topRight',
                    backgroundColor: '#eb4034',
                    message: 'Password field cannot be empty',
                });

                return;
            } else {
                loginUser(username, password, checkedValue);
            }
        }
    });

    $('#psswd').keyup(function(event){
        if(event.keyCode==13){
        var checkedValue = document.getElementById("rememberme").checked;
        var username = $("#uname").val();
            var password = $("#psswd").val();

            if(username===""||username==null){
                iziToast.error({
                    title: 'Error',
                    position: 'topCenter',
                    backgroundColor: '#eb4034',
                    message: 'Username field cannot be empty',
                });

            } else if(password===""||password==null){
                iziToast.error({
                    title: 'Error',
                    position: 'topCenter',
                    backgroundColor: '#eb4034',
                    message: 'Password field cannot be empty',
                });

                return;
            } else {
                loginUser(username, password, checkedValue);
            }
        }
    });
    

    
});

function loginUser(username, password, rm){
    $.ajax({
        url: 'login.php', type: 'post',

        data: {
            'login': 1,
            'username': username,
            'password': password,
            'rememberme': rm
        },

        success: function(response){

        //   alert(response)
            if(response=="success"){
                iziToast.success({
                    title: 'Noice',
                    position: 'topCenter',
                    message: 'Login Successful!',
                    timeout: 1000
                });
                setTimeout(function(){
                    location.replace("welcomepage.php");}, 1000);
                
            } else if (response=="usernotfound"){
                iziToast.error({
                    title: 'Error',
                    position: 'topCenter',
                    backgroundColor: '#eb4034',
                    message: 'Bad Credentials',
                });
            } else if(response=="unabletologin"){
                iziToast.error({
                    title: 'Error',
                    position: 'topCenter',
                    backgroundColor: '#eb4034',
                    message: 'Something went wrong',
                });
            }
        }
    });

}