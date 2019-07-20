 $(document).ready(function(){

    if($("#submitUpdate").length !== 0) {

        document.getElementById("submitUpdate").addEventListener("click", function () {
        
            var submitForm = true;
            
            
            if (isMail($('#email').val())) {
                setValid('#email');
            } else {
                setInvalid('#email');
                submitForm = false;
                alert('Your Email is invalid');
            }
            
           if ($('#password-new').val().length >= 8 && $('#password-new').val() !== "Default text"){

           if (isPassword($('#password-new').val())){
                setValid('#password-new');
           }else{
                setInvalid('#password-new');
                submitForm = false;
                alert('Your new password is invalid');
           }

       }
       
        if ($('#password-new').val() == $('#password-old').val()) { 
            setInvalid('#password-new');
            submitForm = false;
            alert('New Password equal old Password');
         }
        
       
         if ($('#password-new').val() != $('#password-new-confirmed').val()) { 
            setInvalid('#password-new-confirmed');
            submitForm = false;
            alert('Confirm Password not equal Password');
         }else{
            setValid('#password-new-confirmed');
         }
        
        
               //alert(this.files[0].size);
            var file = $('input[type="file"]').files[0].type.toString();
            var ext = file.substring(file.length-3)
            if (ext != "peg" && ext != "gif" && ext != "png" && ext != "jpg"){
                 alert("file type not allowed choose another or press choose then cancel to cancel the selected file");
                 var input = $('input[type="file"]').css({
                     background: "red",
                 });
            }else{
                 var input = $('input[type="file"]').css({
                     background: "green",
                 });
            }
            
            var form = document.getElementById('updateForm');
            if (submitForm === true){
                form.submit();
            }
        });
    }

    /*
    if($("#submitRegister").length !== 0) {

        document.getElementById("submitRegister").addEventListener("click", function () {
        
        var submitForm = true;
        
        if (isMail($('#inputEmail').val())) {
            setValid('#inputEmail');
        } else {
            setInvalid('#inputEmail');
            submitForm = false;
            alert('Your Email is invalid');
        }
        
        if ($('#inputPassword').val().length >= 8 && $('#inputPassword').val() !== "Default text"){

           if (isPassword($('#inputPassword').val())){
                setValid('#inputPassword');
           }else{
                setInvalid('#inputPassword');
                submitForm = false;
                alert('Your password is invalid');
           }

       }
       
        if ($('#inputPassword').val() != $('#confirmPassword').val()) { 
            setInvalid('#confirmPassword');
            submitForm = false;
            alert('Confirm Password not equal Password');
         }else{
            setValid('#confirmPassword');
         }
        
        
        //alert(this.files[0].size);
        var file = $('input[type="file"]').files[0].type.toString();
        var ext = file.substring(file.length-3)
        if (ext != "peg" && ext != "gif" && ext != "png" && ext != "jpg"){
             alert("file type not allowed choose another or press choose then cancel to cancel the selected file");
             var input = $('input[type="file"]').css({
                 background: "red",
             });
        }else{
             var input = $('input[type="file"]').css({
                 background: "green",
             });
        }

        var form = document.getElementById('registerForm');
        if (submitForm === true){
            form.submit();
        }
    });
    }*/

    $('input[type="file"]'). change(function(){
       //alert(this.files[0].size);
       var file = this.files[0].type.toString();
       var ext = file.substring(file.length-3)
       if (ext != "peg" && ext != "gif" && ext != "png" && ext != "jpg"){
            alert("file type not allowed choose another or press choose then cancel to cancel the selected file");
            var input = $('input[type="file"]').css({
                background: "red",
            });
            document.getElementById('hiddenFile').value="false";
       }else{
            var input = $('input[type="file"]').css({
                background: "green",
            });
            document.getElementById('hiddenFile').value="true";
            
       }
   
   });
   
   
   
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });

     $('#inputPassword').on('keyup', function () {

        if ($('#inputPassword').attr('name')!="inputPasswordLogin"){


            if ($('#inputPassword').val().length == 0 ){
                $('#inputPassword').removeClass('is-invalid');
                $('#inputPassword').removeClass('is-valid');
                $('#confirmPassword').removeClass('is-invalid');
                $('#confirmPassword').removeClass('is-valid');
            }
             
             if ($('#inputPassword').val().length >= 1 && $('#inputPassword').val().length < 8 && $('#inputPassword').val() !== "Default text"){
                    setInvalid('#inputPassword');
             }
             
             if ($('#inputPassword').val().length >= 8 && $('#inputPassword').val() !== "Default text"){
                 
                if (isPassword($('#inputPassword').val())){
                        setValid('#inputPassword');
                }else{
                        setInvalid('#inputPassword');
                }
                 
            }
        }
    });
   
   
    $('confirmPassword', '#password-new-confirmed').bind("cut copy paste",function(e) {
         e.preventDefault();
    });
   
   
 $('#confirmPassword').on('keyup', function () {
     if ($('#confirmPassword').val().length > 0 && $('#confirmPassword').val() != "Default text"){
        if ($('#inputPassword').val() != $('#confirmPassword').val()) { 
            setInvalid('#confirmPassword');
         }else{
            setValid('#confirmPassword');
         }
    }
});
 
 
  $('#inputPassword').on('keyup', function () {
        document.getElementById('confirmPassword').value = "";
  });
 
  $('#password-old').on('keyup', function () {
      document.getElementById('password-new').value = "";
        document.getElementById('password-new-confirmed').value = "";
  });
 
 $('#password-new').on('keyup', function () {
     
    if ($('#password-new').val().length == 0 ){
        $('#password-new').removeClass('is-invalid');
        $('#password-new').removeClass('is-valid');
    }
     
     if ($('#password-new').val().length >= 1 && $('#password-new').val().length < 8 && $('#password-new').val() !== "Default text"){
            setInvalid('#password-new');
     }
     
     if ($('#password-new').val().length >= 8 && $('#password-new').val() !== "Default text"){
         
        
         
        if (isPassword($('#password-new').val())){
                setValid('#password-new');
        }else{
                setInvalid('#password-new');
        }
        
          if ($('#password-new').val() == $('#password-old').val()) { 
            setInvalid('#password-new');
            alert('New Password equal old Password');
         }
         
    }
});
 
 $('#password-new-confirmed').on('keyup', function () {
     if ($('#password-new-confirmed').val().length > 0 && $('#password-new-confirmed').val() != "Default text"){
        if ($('#password-new').val() != $('#password-new-confirmed').val()) { 
            setInvalid('#password-new-confirmed');
         }else{
            setValid('#password-new-confirmed');
         }
    }
});
 

 $('#inputEmail').on('keyup', function () {
    
    if ($('#inputEmail').val().length == 0 ){
        $('#inputEmail').removeClass('is-invalid');
        $('#inputEmail').removeClass('is-valid');
    }
    
    if ($('#inputEmail').val().length > 0 && $('#inputEmail').val() !== "Default text"){
        if (isMail($('#inputEmail').val())) {
            setValid('#inputEmail');
        } else {
            setInvalid('#inputEmail');
        }
    }
});


 });
 
 
function setInvalid(id){
    $(id).removeClass('is-valid');
    $(id).addClass('is-invalid');
}

function setValid(id){
    $(id).removeClass('is-invalid');
    $(id).addClass('is-valid');    
}

function isMail(mail){
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(re.test(mail)){
        return true;
    }
    return false;
}

function isPassword(password){
    var re = /(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])_*/;
    if (re.test(password)){
        return true;
    }
    return false;
}

