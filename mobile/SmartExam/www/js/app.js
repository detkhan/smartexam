

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

class Utility{
  getdate(dateraw){
    var dateraw_split=dateraw.split("-");
    var year=dateraw_split[0];
    var month=dateraw_split[1];
    var array_month=[
      'มกราคม',
      'กุมภาพันธ์',
      'มีนาคม',
      'เมษายน',
      'พฤษภาคม',
      'มิถุนายน',
      'กรกฎาคม',
      'สิงหาคม',
      'กันยายน',
      'ตุลาคม',
      'พฤศจิกายน',
      'ธันวาคม',
    ];
  var  thai=[];
  thai['day']=dateraw_split[2];
  thai['month_name']=array_month[(parseInt(month)-1)];
  thai['year_name']=parseInt(year)+543;
  return thai;
  }//getDate
}//class

class Exam {

GetListExam(){
  $$("#content_prpage").html("");
  var param ={student_id:localStorage.student_id};
  var url = "http://"+hosturl+"/api/exam/listexam/";
  $$.getJSON( url,{parameter:param}
  ,function( data ) {
  $$.each(data, function(i, field){
var status  =field.status;
if (status=="false") {
myApp.alert("คุณยังไม่มีวิชาที่สอบ !", 'SMART EXAM');
}else{
var exam_dateraw=field.exam_date;
var ojb_Utility=new Utility();
var datethai=ojb_Utility.getdate(exam_dateraw);
var datethainame=datethai['day']+' '+datethai['month_name']+'  '+datethai['year_name'];
var content='\
<div class="prpage">\
  <a id="prdetail" href="#prdetail" subject="'+field.subject+'" datethainame="'+datethainame+'" detail="'+field.detail+'" exam_id="'+field.exam_id+'" time_total="'+field.time_total+'"  time_start="'+field.time_start+'" time_end="'+field.time_end+'" short_detail="'+field.short_detail+'" register_exam_id="'+field.register_exam_id+'">\
    <div class="card prpage_card">\
      <div class="prpage_date">\
        <span>วันที่ '+datethai['day']+' '+datethai['month_name']+'  '+datethai['year_name']+'</span>\
        <span>เริ่มสอบ '+field.time_start+' -  '+field.time_end+' น.</span>\
      </div>\
    <span class="prpage_testname">'+field.subject+'</span>\
    <div class="prpage_detail">\
      <span>\
        '+field.short_detail+'\
        <br><br>\
      ระยะเวลาทำข้อสอบ '+field.time_total+' นาที<br>\
      ข้อสอบ 3 ชุด จำนวน 120 ข้อ\
      </span>\
    </div>\
</div>\
  </a>\
</div>\
';
$$("#content_prpage").append(content);
}//if else
  });//each

  });//getJson
}//GetListExam
checkRegisterSet(array_data){
  var exam_id =array_data['exam_id'];
  var register_exam_id=array_data['register_exam_id'];
  var subject =array_data['subject'];
  var time_start =array_data['time_start'];
  var time_end =array_data['time_end'];
  var datethainame =array_data['datethainame'];
  var short_detail =array_data['short_detail'];
  var time_total =array_data['time_total'];
  var register_exam_id=array_data['register_exam_id'];
  $$("#content_examboard").html('');
  var content='\
  <div class="boardpage">\
    <span class="boardpage_name">'+localStorage.fullname+'</span>\
    <span class="boardpage_code">Student Code '+localStorage.student_code+'</span>\
    <div class="boardpage_card">\
      <div class="boardpage_date">\
        <span>วันที่ '+datethainame+'</span>\
        <span>เริ่มสอบ '+time_start+' -  '+time_end+' น.</span>\
      </div>\
      <div class="boardpage_head">\
        <i class="boardpage_head-mask">ค1</i>\
        <span class="boardpage_head-name">'+subject+'</span>\
        <span class="boardpage_head-deatil">\
          '+short_detail+'\
          <br><br>\
      ระยะเวลาทำข้อสอบ '+time_total+' นาที<br>\
      ข้อสอบ 1 ชุด จำนวน 90 ข้อ\
        </span>\
      </div>\
  ';

  var param ={student_id:localStorage.student_id,exam_id:exam_id};
  var url = "http://"+hosturl+"/api/exam/checkRegisterSet/";

  $$.getJSON( url,{parameter:param}
  ,function( data ) {
  content+='\
  <div class="boardpage_list">\
    <span>'+data[0].set_name+' มี 90 ข้อ</span>\
    <br>\
  ';
  var num;
  $$.each(data[0].path, function(i, field){
  num=i+1;
    content+='\
    <div class="row no-gutter">\
      <div class="col-75"><span>ส่วนที่ '+num+' '+field.exam_path_name+' </span></div>\
      <div class="col-25"><span class="text-right">50 ข้อ</span></div>\
    </div>\
    ';
  });//each
  content+='\
  </div>\
  <div class="text-right">\
  <a href="#" class="back_btn small back">BACK</a>\
  <a id="startexam" href="#" class="next_btn small" register_exam_id="'+register_exam_id+'">NEXT</a>\
  </div>\
  </div>\
  </div>\
  ';
$$("#content_examboard").append(content);
  });//getJson

}//checkRegisterSet
}//class


class TimeExam {
starttime(distance){
  // Update the count down every 1 second
  var x = setInterval(function() {
      // Time calculations for days, hours, minutes and seconds
      //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Output the result in an element with id="demo"
      document.getElementById("demo").innerHTML = days + "d " + hours + "h "
      + minutes + "m " + seconds + "s ";

      // If the count down is over, write some text
      if (distance < 0) {
          clearInterval(x);
          document.getElementById("demo").innerHTML = "EXPIRED";
      }
  }, 1000);
}//function starttime

checkTimeExam(register_exam_id){
  var param ={register_exam_id:register_exam_id};
  var url = "http://"+hosturl+"/api/exam/getExamTime/";
  $$.getJSON( url,{parameter:param}
  ,function( data ) {
$$.each(data, function(i, field){
if (field.status=="false") {
myApp.alert("ยังไม่ถึงเวลาสอบ", 'SMART EXAM');
}else {
  mainView.router.load({pageName: 'choice',ignoreCache:true});
}
});//each
});//getJson
}//checkTimeExam
}//class  TimeExam



startapp();
function startapp() {
  //localStorage.removeItem("user_id");
  //localStorage.removeItem("fullname");
var ojb_exam=new Exam();
ojb_exam.GetListExam();
mainView.router.load({pageName: 'prpage',ignoreCache:true});


}
$$(document).on("click", "#login", function() {
var object_user = new User();
object_user.checklogin();
});//click login

$$(document).on("click", "#prdetail", function() {
var exam_id=$$(this).attr("exam_id");
var subject=$$(this).attr("subject");
var detail=$$(this).attr("detail");
var time_start=$$(this).attr("time_start");
var time_end=$$(this).attr("time_end");
var datethainame=$$(this).attr("datethainame");
var short_detail=$$(this).attr("short_detail");
var time_total=$$(this).attr("time_total");
var register_exam_id=$$(this).attr("register_exam_id");
$$("#content_prdetail").html('');
var content='\
<div class="prpage deatil">\
  <div class="card prpage_card">\
  <span class="prpage_testname">'+subject+'</span>\
  <div class="prpage_detail">\
    <span>\
    '+detail+'\
    </span>\
  </div>\
  <div class="text-right">\
    <a href="#" class="back_btn small back">BACK</a>\
    <a id="examboard" href="#examboard" exam_id="'+exam_id+'" short_detail="'+short_detail+'" time_total="'+time_total+'" time_start="'+time_start+'"  time_end="'+time_end+'" subject="'+subject+'" datethainame="'+datethainame+'" register_exam_id="'+register_exam_id+'" class="next_btn small">NEXT</a>\
  </div>\
</div>\
</div>\
';
$$("#content_prdetail").append(content);
});//click prpage_detail

$$(document).on("click", "#examboard", function() {
  var array_data=[];
  array_data['exam_id']=$$(this).attr("exam_id");
  array_data['subject']=$$(this).attr("subject");
  array_data['time_start']=$$(this).attr("time_start");
  array_data['time_end']=$$(this).attr("time_end");
  array_data['datethainame']=$$(this).attr("datethainame");
  array_data['short_detail']=$$(this).attr("short_detail");
  array_data['time_total']=$$(this).attr("time_total");
  array_data['register_exam_id']=$$(this).attr("register_exam_id");
  $$("#content_examboard").html('');
  var ojb_exam=new Exam();
  ojb_exam.checkRegisterSet(array_data);

});//click prpage_detail

$$(document).on("click", "#startexam", function() {
var register_exam_id=$$(this).attr("register_exam_id");
var ojb_time_exam=new TimeExam();
ojb_time_exam.checkTimeExam(register_exam_id);
});//click login
