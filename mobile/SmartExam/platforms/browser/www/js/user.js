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
  localStorage.student_id=field.student_id;
  localStorage.fullname=field.firstname+" "+field.lastname;
  localStorage.student_code=field.student_code;
  myApp.alert("Success", 'SMART EXAM');
  var ojb_exam=new Exam();
  ojb_exam.GetListExam();
  mainView.router.load({pageName: 'prpage',ignoreCache:true});

  //prpage
  }
});//each

});//getJson
}
}//check login
}//class user
export default User;
