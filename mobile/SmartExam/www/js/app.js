

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
  localStorage.user_id=field.user_id;
  localStorage.fullname=field.firstname+" "+field.lastname;
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
  var param ={user_id:localStorage.user_id};
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
  <a id="prdetail" href="#prdetail" subject="'+field.subject+'" datethainame="'+datethainame+'" detail="'+field.detail+'" exam_id="'+field.exam_id+'" time_total="'+field.time_total+'"  short_detail="'+field.short_detail+'">\
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
}//class


startapp();
function startapp() {
  localStorage.removeItem("user_id");
  localStorage.removeItem("fullname");


}
$$(document).on("click", "#login", function() {
var object_user = new User();
object_user.checklogin();
});//click login

$$(document).on("click", "#prdetail", function() {
var exam_id=$$(this).attr("exam_id");
var subject=$$(this).attr("subject");
var detail=$$(this).attr("detail");
var short_detail=$$(this).attr("short_detail");
var time_total=$$(this).attr("time_total");
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
    <a id="examboard" href="#examboard" exam_id="'+exam_id+'" short_detail="'+short_detail+'" time_total="'+time_total+'" subject="'+subject+'" class="next_btn small">NEXT</a>\
  </div>\
</div>\
</div>\
';
$$("#content_prdetail").append(content);
});//click prpage_detail

$$(document).on("click", "#examboard", function() {
  var exam_id=$$(this).attr("exam_id");
  var subject=$$(this).attr("subject");
  var short_detail=$$(this).attr("short_detail");
  var time_total=$$(this).attr("time_total");
  $$("#content_examboard").html('');
var content='\
<div class="boardpage">\
  <span class="boardpage_name">Annop Sawatdipol</span>\
  <span class="boardpage_code">Student Code 494245152</span>\
  <div class="boardpage_card">\
    <div class="boardpage_date">\
      <span>วันที่ 24 ตุลาคม 2560</span>\
      <span>เริ่มสอบ 15.00 -  16.30 น.</span>\
    </div>\
    <div class="boardpage_head">\
      <i class="boardpage_head-mask">ค1</i>\
      <span class="boardpage_head-name">คณิตศาสตร์ พื้นฐาน 1</span>\
      <span class="boardpage_head-deatil">\
        ข้อสอบวิชาคณิตศาสตร์พื้นฐาน 1 เทอม 1\
        <br><br>\
    ระยะเวลาทำข้อสอบ 90 นาที<br>\
    ข้อสอบ 1 ชุด จำนวน 90 ข้อ\
      </span>\
    </div>\
    <div class="boardpage_list">\
      <span>ชุดที่1 มี 90 ข้อ</span>\
      <br>\
      <div class="row no-gutter">\
        <div class="col-75"><span>ส่วนที่ 1 ปรนัย </span></div>\
        <div class="col-25"><span class="text-right">50 ข้อ</span></div>\
      </div>\
      <div class="row no-gutter">\
        <div class="col-75"><span>ส่วนที่ 2 แบบเลือกคำตอบถูกผิด</span></div>\
        <div class="col-25"><span class="text-right">10 ข้อ</span></div>\
      </div>\
    </div>\
    <div class="text-right">\
    <a href="#" class="back_btn small back">BACK</a>\
    <a href="#multiplechoice" class="next_btn small">NEXT</a>\
  </div>\
  </div>\
</div>\
';
});//click prpage_detail
