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

         return;
    }

    if(password===""||password==null){
        iziToast.error({
            title: 'Error',
            position: 'topRight',
            message: 'Password field cannot be empty',
        });

        return;
    }

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
                });

                
            } else if (response=="fail"){
                iziToast.error({
                    title: 'Error',
                    position: 'topCenter',
                    message: 'Bad Credentials',
                });
            }
        }
    });

});


});