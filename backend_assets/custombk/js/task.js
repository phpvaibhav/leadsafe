/***********************/
//taskAddUpdate Add 
$("#taskAddUpdate").validate({// Rules for form validation
  errorClass    : errorClass,
  errorElement  : errorElement,
  highlight: function(element) {
    $(element).parent().removeClass('state-success').addClass("state-error");
    $(element).removeClass('valid');
  },
  unhighlight: function(element) {
    $(element).parent().removeClass("state-error").addClass('state-success');
    $(element).addClass('valid');
  },
  rules : {
    name : {
      required : true
    },
   description : {
      required : true
    },
  
  },
  // Messages for form validation
  messages : {
    name : {
      required : 'Please enter your task name'
    },

   description : {
      required : 'Please enter your task description'
    },
    
   
  },
  onfocusout: injectTrim($.validator.defaults.onfocusout),
  // Do not change code below
  errorPlacement : function(error, element) {
    error.insertAfter(element.parent());
  }
});

// Validation
jQuery.validator.addClassRules('textClass', {
  required: true /*,
        other rules */
});

$(function() {   
  $(document).on('submit', "#taskAddUpdate", function (event) {
    toastr.clear();
      var total_element_text = $(".elementPro").length;
      var total_element_image = $(".elementProImg").length;
    $('#total_element_text').val(total_element_text);
    $('#total_element_image').val(total_element_image);
    event.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type            : "POST",
        url             : base_url+'adminapi/'+$(this).attr('action'),
        headers         : { 'authToken': authToken },
        data            : formData, //only input
        processData     : false,
        contentType     : false,
        cache           : false,
        beforeSend      : function () {
          preLoadshow(true);
          $('#submit').prop('disabled', true);
        },
        success         : function (res) {
          preLoadshow(false);
          setTimeout(function(){  $('#submit').prop('disabled', false); },4000);
          if(res.status=='success'){
            toastr.success(res.message, 'Success', {timeOut: 3000});
            setTimeout(function(){
               window.location = base_url+'tasks'; 
             // window.location.reload(); 
            },4000);
          }else{
            toastr.error(res.message, 'Alert!', {timeOut: 4000});
          }
        }
    });
  });
  //fromsubmit
});

/***************************************************/
$(document).ready(function(){
 // Add new element
  $(".addPro").click(function(){
    // Finding total number of elements added
    var total_element = Number($(".elementPro").length);
    // last <div> with element class id
    var lastid        = $(".elementPro:last").attr("id");
    var split_id      = lastid.split("_");
    var nextindex     = Number(split_id[1]) + 1;
    var max           = 10;
    // Check total number elements
    if(total_element < max){
      // Adding new div container after last occurance of element class
      $(".elementPro:last").after('<div class="col-md-12 col-sm-12 col-lg-12 elementPro" id="divPro_'+ nextindex +'"></div>');
      $("#divPro_" + nextindex).append('<section class="col col-md-12"><label class="label"><strong>Step Text-'+ nextindex +'</strong><a href="javascript:void(0);" id="remove_' + nextindex + '" class="btn btn-default btn-circle btn-danger pull-right removePro"><i class="fa fa-times" aria-hidden="true"></i></a></label></section><section class="col col-md-12"><label class="label">TEXT<span class="error">*</span></label><label class="textarea"><textarea rows="4" class="textClass" name="textfile_'+nextindex+'" placeholder="Enter Task instuctions step" maxlength="400"></textarea><input type="hidden" name="textfileId_'+nextindex+'" value="0"></label></section>');
    }else{
      toastr.error('text step max limit is 10.', 'Alert!', {timeOut: 4000});
    }
 });
 // Remove element
 $('.textContainer').on('click','.removePro',function(){
    var id          = this.id;
    var split_id    = id.split("_");
    var deleteindex = split_id[1];
    // Remove <div> with id
    $("#divPro_" + deleteindex).remove();
 }); 
  //change  
});
$(document).ready(function(){
 // Add new element
  $(".addProImage").click(function(){
    // Finding total number of elements added
    var total_element_img = Number($(".elementProImg").length);
    // last <div> with element class id
    var lastid_img        = $(".elementProImg:last").attr("id");
    var split_id_img      = lastid_img.split("_");
    var nextindex_img     = Number(split_id_img[1]) + 1;
    var max_img          = 10;
    // Check total number elements
    if(total_element_img < max_img){
      // Adding new div container after last occurance of element class
      $(".elementProImg:last").after('<div class="col-md-12 col-sm-12 col-lg-12 elementProImg" id="divProImg_'+ nextindex_img +'"></div>');
      $("#divProImg_" + nextindex_img).append('<section class="col col-md-12"><label class="label"><strong>Step Image-'+ nextindex_img +'</strong><a href="javascript:void(0);" id="removeimage_' + nextindex_img + '" class="btn btn-default btn-circle btn-danger pull-right removeProImage"><i class="fa fa-times" aria-hidden="true"></i></a></label></section><section class="col col-6 text-center"><img height="120" width="120" src="' + base_url + 'backend_assets/img/avatars/sunny-big.png"  id="blah_' + nextindex_img + '" alt="img"></section><section class="col col-6"><div class="input input-file"><input type="hidden" name="imagefileId_' + nextindex_img + '" value="0"><span class="button"><input type="file" name="fileImage_' + nextindex_img + '" id="file_' + nextindex_img + '" onchange="readURL(this,' + nextindex_img + ');this.parentNode.nextSibling.value = this.value" accept="image/*">Browse</span><input type="text" readonly=""></div></section>');
    }else{
      toastr.error('image step max limit is 10.', 'Alert!', {timeOut: 4000});
    }
 });
 // Remove element
 $('.imageContainer').on('click','.removeProImage',function(){
 
    var id_IMG          = this.id;
   
    var split_id_Img    = id_IMG.split("_");
    var deleteindex_img = split_id_Img[1];
    // Remove <div> with id
    $("#divProImg_" + deleteindex_img).remove();
 }); 
  //change  
});