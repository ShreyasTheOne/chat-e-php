
$("document").ready(function(){

    $("#loginBtn").on('click',function(){
        var username = $("#uname").val();
        var password = $("#psswd").val();

        if(username===""||username==null){
            iziToast.error({
                title: 'Error',
                position: 'topRight',
                message: 'Username field cannot be empty',
            });

        } else if(password===""||password==null){
            iziToast.error({
                title: 'Error',
                position: 'topRight',
                message: 'Password field cannot be empty',
            });

            return;
        } else {
            loginUser(username, password);
        }
    });

    
});

function loginUser(username, password){
    $.ajax({
        url: 'login.php', type: 'post',

        data: {
            'login': 1,
            'username': username,
            'password': password,
        },

        success: function(response){
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
                    message: 'Bad Credentials',
                });
            } else if(response=="unabletologin"){
                iziToast.error({
                    title: 'Error',
                    position: 'topCenter',
                    message: 'Something went wrong',
                });
            }
        }
    });

}