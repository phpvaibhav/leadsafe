var base_url  = $('body').data('base-url'); // Base url
var authToken = $('body').data('auth-url'); // Base url
//rember me
$(function() {
  if (localStorage.chkbx && localStorage.chkbx != '') {
    $('#remember_me').attr('checked', 'checked');
    $('#username').val(localStorage.usrname);
    $('#password').val(localStorage.pass);
  } else {
    $('#remember_me').removeAttr('checked');
    $('#username').val('');
    $('#password').val('');
  }
  $('#remember_me').click(function() {
    if ($('#remember_me').is(':checked')) {

      localStorage.usrname  = $('#username').val();
      localStorage.pass     = $('#password').val();
      localStorage.chkbx    = $('#remember_me').val();

    } else {

      localStorage.usrname  = '';
      localStorage.pass     = '';
      localStorage.chkbx    = '';
    }
  });
});
//rember me
//login method
// Validation
$("#login-form").validate({
  // Rules for form validation
  rules : {
    email   : {
              required  : true,
              email     : true
            },
    password : {
              required  : true,
              minlength : 3,
              maxlength : 20
            }
  },
  // Messages for form validation
  messages : {
    email : {
              required  : 'Please enter your email address',
              email     : 'Please enter a valid email address'
            },
    password : {
              required  : 'Please enter your password'
            }
  },
  // Do not change code below
  errorPlacement : function(error, element) {
            error.insertAfter(element.parent());
          },
  // ajax 
  submitHandler: function (form) {
    toastr.clear();
    $('#submit').prop('disabled', true);
      $.ajax({
        type        : "POST",
        url         : base_url+'adminapi/'+$(form).attr('action'),
        data        : $(form).serialize(),
        cache       : false,
        beforeSend  : function() {
          preLoadshow(true);
          $('#submit').prop('disabled', true);  
        },     
        success: function (res) {
          preLoadshow(false);
          setTimeout(function(){  $('#submit').prop('disabled', false); },4000);
          if(res.status=='success'){
            toastr.success(res.message, 'Success', {timeOut: 3000});
            setTimeout(function(){ window.location = base_url+'dashboard'; },4000);
          }else{
            toastr.error(res.message, 'Alert!', {timeOut: 3000});
          }
        }
      });
      return false; // required to block normal submit since you used ajax
  }
});    // Validation
//Forgot
$("#forgot-form").validate({
  // Rules for form validation
  rules : {
            email : {
              required  : true,
              email     : true
            }
          },
  // Messages for form validation
  messages : {
            email : {
              required  : 'Please enter your email address',
              email     : 'Please enter a valid email address'
            },
  },// Do not change code below
  errorPlacement : function(error, element) {
    error.insertAfter(element.parent());
  },
  // ajax 
  submitHandler: function (form) {
    toastr.clear();
    $('#submit').prop('disabled', true);
      $.ajax({
        type        : "POST",
        url         : base_url+'adminapi/'+$(form).attr('action'),
        data        : $(form).serialize(),
        cache       : false,
        beforeSend  : function() {
          preLoadshow(true);
          $('#submit').prop('disabled', true);  
        },     
        success     : function (res) {
          preLoadshow(false);
          setTimeout(function(){  $('#submit').prop('disabled', false); },4000);
          if(res.status=='success'){
            toastr.success(res.message, 'Success', {timeOut: 3000});
            setTimeout(function(){ window.location = base_url; },4000);
          // window.location = base_url;
          }else{
            toastr.error(res.message, 'Alert!', {timeOut: 4000});
          }
        }
    });
    return false; // required to block normal submit since you used ajax
  }
});
//sign up
$("#smart-form-register").validate({// Rules for form validation
  rules : {
    fullName    : {
      required  : true
    },
    email : {
      required  : true,
      email     : true
    },
    contact : {
      required  : true,
    
    },
    password : {
      required  : true,
      minlength : 3,
      maxlength : 20
    },
    passwordConfirm : {
      required  : true,
      minlength : 3,
      maxlength : 20,
      equalTo   : '#password'
    },

  },
  // Messages for form validation
  messages : {
    fullName : {
      required  : 'Please enter your full name'
    },
    email : {
      required  : 'Please enter your email address',
      email     : 'Please enter a valid email address'
    },
    contact : {
      required  : 'Please enter your contact number'
    },
    password : {
      required  : 'Please enter your password'
    },
    passwordConfirm : {
      required  : 'Please re-enter your password',
      equalTo   : 'Please enter the same password as above'
    }
  },
  // Ajax form submition
  submitHandler : function(form) {
    toastr.clear();
    $('#submit').prop('disabled', true);
    $.ajax({
      type            : "POST",
      url             : base_url+'adminapi/'+$(form).attr('action'),
      data            : $(form).serialize(),
      cache           : false,
      beforeSend      : function() {
        preLoadshow(true);
        $('#submit').prop('disabled', true);  
      },     
      success: function (res) {
        preLoadshow(false);
        setTimeout(function(){  $('#submit').prop('disabled', false); },4000);
        if(res.status=='success'){
          toastr.success(res.message, 'Success', {timeOut: 3000});
          setTimeout(function(){ window.location = base_url+'dashboard'; },4000);
        }else{
          toastr.error(res.message, 'Alert!', {timeOut: 4000});
        }
      }
    });
    return false; // required to block normal submit since you used ajax
  },
  // Do not change code below
  errorPlacement : function(error, element) {
    error.insertAfter(element.parent());
  }
});
//date 
  $("#resetpassForm").validate({
    rules: {
      password: {
        required  : true,
        minlength : 6,
        maxlength : 15,
      },
      cpassword: {
        required  : true,  
        minlength : 6,
        maxlength : 15,
        equalTo   : "#password",
      }
    },
    messages: {
      password:{
        required  : "Please enter password.",
        minlength : "Password should have minimum 6 characters.",
        maxlength : "Password should have Maxlength 15 characters.",
      }, 
      cpassword:{ 
        required  : "Please enter confirm password.",
        minlength : "Confirm password should have minimum 6 characters.",
        maxlength : "Confirm password should have Maxlength 15 characters.",
        equalTo   : "Confirm password does not match.",
      }
    },
    // Do not change code below
    errorPlacement : function(error, element) {
      error.insertAfter(element.parent());
    },
    // ajax 
    submitHandler: function (form) {
      toastr.clear();
      $('#submit').prop('disabled', true);
      $.ajax({
        type       : "POST",
        url        : $(form).attr('action'),
        data       : $(form).serialize(),
        dataType   :'json',
        cache      : false,
        beforeSend : function() {
          preLoadshow(true);
          $('#submit').prop('disabled', true);  
        },     
        success     : function (res) {
          preLoadshow(false);
          setTimeout(function(){  $('#submit').prop('disabled', false); },4000);
          if(res.status=='success'){
            toastr.success(res.message, 'Success', {timeOut: 3000});
            setTimeout(function(){ window.location = base_url; },4000);
          }else{
            toastr.error(res.message, 'Alert!', {timeOut: 4000});
          } 
          //  $('#submit').prop('disabled', false);  
        }
      });
      return false; // required to block normal submit since you used ajax
    }
  });