class User {
  constructor() {

  }
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
  if (status=="no") {
  myApp.alert("Wong Password !", 'SMART EXAM');
  }else{
  //gethome(datereport);
  }
});//each

});//getJson
}
}//check login
}//class
//export default User;
