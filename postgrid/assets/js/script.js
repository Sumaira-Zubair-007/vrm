$(document).ready(function(){
  $(".sel_ser").select2();
  $(".sel_ser").select2("val", "0");
});

$(".floating_label input").focusin(function(){
  $(this).parent().addClass("active");
});
$(".floating_label input").focusout(function(){
  var this_val = $(this).val();
  if(this_val.length == 0){
    $(this).parent().removeClass("active");
  }else{
    
  }
});