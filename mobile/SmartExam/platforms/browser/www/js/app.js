class User {
checklogin(){
    var name_surname = $$('#name_surname').val();
    var student_code = $$('#student_code').val();
  if(name_surname==""||student_code==""){
  myApp.alert("No empty !", 'SMART EXAM');
  }else {
  var param ={name_surname:name_surname,student_code:student_code};
  //var param = jQuery.param(str);
  var url = "http://"+hosturl+"/api/user/login/";
  $$.getJSON( url,{parameter:param}
  ,function( data ) {
  $$.each(data, function(i, field){
  var status  =field.status;
  if (status=="false") {
  myApp.alert("Wong Password !", 'SMART EXAM');
  }else{
  //gethome(datereport);
  myApp.alert("Success", 'SMART EXAM');
  //prpage
  }
});//each

});//getJson
}
}//check login
}//class user


$$(document).on("click", "#login", function() {
var object_user = new User();
object_user.checklogin();
});//click login
