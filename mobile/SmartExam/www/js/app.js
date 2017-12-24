

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

examinationTypeFormat(examination_type_id,examination_type_format_id){
  var formattype=[];
  switch(examination_type_id) {
    case '1':
    switch(examination_type_format_id) {
      case '1':
formattype=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
          break;
      case '2':
formattype=['ก','ข','ค','ง','จ','ฉ','ช','ซ','ฌ','ญ','ฎ','ฏ','ฐ','ฑ','ฒ','ณ','ด','ต','ถ','ท','ธ','น','บ','ป','ผ','ฝ'];
          break;
      case '3':
formattype=['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26'];
  }
        break;
    case '2':
    switch(examination_type_format_id) {
      case '1':
formattype=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
          break;
      case '2':
formattype=['ก','ข','ค','ง','จ','ฉ','ช','ซ','ฌ','ญ','ฎ','ฏ','ฐ','ฑ','ฒ','ณ','ด','ต','ถ','ท','ธ','น','บ','ป','ผ','ฝ'];
          break;
      case '3':
formattype=['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26'];
  }
        break;
  }
return formattype;
}//examinationTypeFormat
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
  var set_id;

  $$.getJSON( url,{parameter:param}
  ,function( data ) {
  content+='\
  <div class="boardpage_list">\
    <span>'+data[0].set_name+' มี 90 ข้อ</span>\
    <br>\
  ';
  var num;
  set_id=data[0].set_id;
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
  <a id="startexam" href="#" class="next_btn small" register_exam_id="'+register_exam_id+'" set_id="'+set_id+'">NEXT</a>\
  </div>\
  </div>\
  </div>\
  ';
$$("#content_examboard").append(content);
  });//getJson

}//checkRegisterSet
}//class

class Examination {
getExamination(set_id,examination_id,pre_next){
$$("#content_choice").html("");
  var param ={set_id:set_id,student_id:localStorage.student_id,examination_id:examination_id,pre_next:pre_next};
  var url = "http://"+hosturl+"/api/examination/getexamination/";
  var formattype;
  var content='\
  <div class="testpage">\
    <a href="choiceselected.html" class="testpage_overall"><img src="img/btn/overall@2x.png"></a>\
    <div class="testpage_completed">\
      <div class="testpage_completed-step">\
  ';
  $$.getJSON( url,{parameter:param}
  ,function( data ) {
  var progess=(parseInt(data.countanswer)/parseInt(data.examination_count))*100;
  var examination_type_id=data[0].examination_type_id;
  var examination_type_format_id=data[0].examination_type_format_id;
  var ojb_Utility=new Utility();
  formattype=ojb_Utility.examinationTypeFormat(examination_type_id,examination_type_format_id);
  switch (examination_type_id) {
    case '1':
    content+='\
    <span class="step_point" style="left: '+progess+'%"></span>\
    <div class="step_line">\
      <div style="width: '+progess+'%"></div>\
    </div>\
  </div>\
  <span class="testpage_completed-text">Completed '+data.countanswer+'/'+data.examination_count+'</span>\
  </div>\
  <span class="testpage_part">Part '+data.row_exam_path+' '+data[0].exam_path_name+' 50 Item (50 Point)</span>\
  <span class="testpage_subject">\
  </span>\
  '+data.row+'. '+data[0].examination_title+'\
  <div class="testpage_basiccard">\
    <div class="testpage_nav">\
      <a id="next_btn" href="#" class="testpage_nav-btn next" set_id="'+set_id+'" examination_id="'+data[0].examination_id+'" examination_type_id="'+data[0].examination_type_id+'"><img src="img/btn/arrow-right@3x.png"></a>\
        ';
  if (data.row==1) {
    content+='\
        <a href="#" class="testpage_nav-btn prv back"><img src="img/btn/arrow-left@3x.png"></a>\
      </div>\
      <div class="testpage_basiccard-inner">\
        <ul class="testpage_choice">\
      ';
  }else {
    content+='\
        <a id="prv_btn" href="#" class="testpage_nav-btn prv" set_id="'+set_id+'" examination_id="'+data[0].examination_id+'" examination_type_id="'+data[0].examination_type_id+'"><img src="img/btn/arrow-left@3x.png"></a>\
      </div>\
      <div class="testpage_basiccard-inner">\
        <ul class="testpage_choice">\
      ';
  }
    $$.each(data.choice, function(i, field){
      if (field.choice_id==data.getanswer) {
        if (!field.choice_img_name) {
          console.log(field.choice_img_name);
          content+='\
            <li class="select" choice_id="'+field.choice_id+'"><div class="choice">'+formattype[i]+'.<font>'+field.choice_detail+'</font></div></li>\
            ';
        }else {
            console.log("no");
          content+='\
          <li class="select" choice_id="'+field.choice_id+'">\
            <div class="row no-gutter">\
              <div class="col-70"><div class="choice">'+formattype[i]+'.<font>'+field.choice_detail+'</font></div></div>\
              <div class="col-30"><a href="#" data-popup=".popup-img" class="open-popup"><div class="choice_img"><img src="img/'+field.choice_img_name+'"></div></a></div>\
           </div>\
          </li>\
          ';
        }

    }else {
      if (!field.choice_img_name) {
        console.log("yes");
        content+='\
        <li choice_id="'+field.choice_id+'"choice_id="'+field.choice_id+'"><div class="choice" >'+formattype[i]+'.<font>'+field.choice_detail+'</font></div></li>\
        ';
      }else {
        console.log("no");
        content+='\
        <li class="select" choice_id="'+field.choice_id+'">\
          <div class="row no-gutter">\
            <div class="col-70"><div class="choice">'+formattype[i]+'.<font>'+field.choice_detail+'</font></div></div>\
            <div class="col-30"><a href="#" data-popup=".popup-img" class="open-popup"><div class="choice_img"><img src="img/'+field.choice_img_name+'"></div></a></div>\
         </div>\
        </li>\
        ';
      }

    }

    });//each
      break;
    case '2':

    break;
    case '3':

    break;
    case '4':

    break;
    case '5':
    content+='\
    <span class="step_point" style="left: '+progess+'%"></span>\
    <div class="step_line">\
      <div style="width: '+progess+'%"></div>\
    </div>\
  </div>\
  <span class="testpage_completed-text">Completed '+data.countanswer+'/'+data.examination_count+'</span>\
  </div>\
  <span class="testpage_part">Part '+data.row_exam_path+' '+data[0].exam_path_name+' 50 Item (50 Point)</span>\
  <span class="testpage_subject">\
  </span>\
  '+data.row+'. '+data[0].examination_title+'\
  <div class="testpage_basiccard">\
    <div class="testpage_nav">\
      <a id="next_btn" href="#" class="testpage_nav-btn next" set_id="'+set_id+'" examination_id="'+data[0].examination_id+'" examination_type_id="'+data[0].examination_type_id+'"><img src="img/btn/arrow-right@3x.png"></a>\
        ';
  if (data.row==1) {
    content+='\
        <a href="#" class="testpage_nav-btn prv back"><img src="img/btn/arrow-left@3x.png"></a>\
      </div>\
      <div class="testpage_basiccard-inner">\
        <ul class="testpage_choice">\
      ';
  }else {
    content+='\
        <a id="prv_btn" href="#" class="testpage_nav-btn prv" set_id="'+set_id+'" examination_id="'+data[0].examination_id+'" examination_type_id="'+data[0].examination_type_id+'"><img src="img/btn/arrow-left@3x.png"></a>\
      </div>\
      <div class="testpage_basiccard-inner">\
        <ul class="testpage_choice">\
      ';
  }
  var fill;
  if (data.getanswer_fill!='0') {
    fill=data.getanswer_fill;
  }else {
  fill='';
  }
  content+='\
  <div class="testpage_basiccard-inner">\
    <div class="testpage_wording">\
      <span class="testpage_wording-head">Type your answer</span>\
      <textarea class="testpage_wording-textbox">'+fill+'</textarea>\
    </div>\
  </div>\
';
    break;

  }

content+='\
</ul>\
</div>\
</div>\
</div>\
';
$$("#content_choice").append(content);
});//getJson


mainView.router.load({pageName: 'choice',ignoreCache:true});
}//function getExamination
}//class Examination

class TimeExam {
starttime(date_start,date_end){
      var num=0;
      $$("#counttime").html("");
  // Update the count down every 1 second
  var x = setInterval(function() {
var countDownDate = new Date(date_end).getTime();
var now = new Date(date_start).getTime();
    var distance = countDownDate - parseInt(now)-num;
      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours1 = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes1 = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds1 = Math.floor((distance % (1000 * 60)) / 1000);
      var hours = ("0" + hours1).slice(-2);
      var minutes = ("0" + minutes1).slice(-2);
      var seconds = ("0" + seconds1).slice(-2);
      // Output the result in an element with id="demo"
      document.getElementById("counttime").innerHTML =hours + ":"
      + minutes + ":" + seconds;
num=num+1000;
      // If the count down is over, write some text
      if (distance < 0) {
          clearInterval(x);
          myApp.alert("หมดเวลาสอบ", 'SMART EXAM');
          document.getElementById("counttime").innerHTML = "EXPIRED";
          mainView.router.load({pageName: 'end',ignoreCache:true});
      }
  }, 1000);
}//function starttime

checkTimeExam(register_exam_id,set_id){
  var param ={register_exam_id:register_exam_id};
  var url = "http://"+hosturl+"/api/exam/getExamTime/";
  $$.getJSON( url,{parameter:param}
  ,function( data ) {
$$.each(data, function(i, field){
if (field.status=="false") {
myApp.alert("ยังไม่ถึงเวลาสอบ", 'SMART EXAM');
}else {
  var ojb_time_exam=new TimeExam();
  ojb_time_exam.starttime(field.time_start_stamp,field.time_end_stamp);
var ojb_examination=new Examination();
ojb_examination.getExamination(set_id,'0','normal');
}
});//each
});//getJson
}//checkTimeExam
}//class  TimeExam


class Answer {
  add_answer(choice_id,set_id,examination_id,examination_type_id) {
    switch (examination_type_id) {
      case '1':
      var param ={choice_id:choice_id,student_id:localStorage.student_id,set_id:set_id,examination_id:examination_id};
      var url = "http://"+hosturl+"/api/answer/addAnswer/";
      $$.getJSON( url,{parameter:param}
      ,function( data ) {
      $$.each(data, function(i, field){
        console.log(field.status);
      });//each
      });//getJson
        break;
        case '2':

          break;
          case '3':

            break;
            case '4':

              break;
              case '5':
              var param ={choice_id:choice_id,student_id:localStorage.student_id,set_id:set_id,examination_id:examination_id};
              var url = "http://"+hosturl+"/api/answer/addAnswerFill/";
              $$.getJSON( url,{parameter:param}
              ,function( data ) {
              $$.each(data, function(i, field){
                console.log(field.status);
              });//each
              });//getJson
                break;

    }

  }//add_answer
}//class Answer



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
var set_id=$$(this).attr("set_id");
var ojb_time_exam=new TimeExam();
ojb_time_exam.checkTimeExam(register_exam_id,set_id);
});//click login

$$(document).on("click", "#next_btn", function() {
var  examination_type_id=$$(this).attr("examination_type_id");
var set_id=$$(this).attr("set_id");
var examination_id=$$(this).attr("examination_id");

switch (examination_type_id) {
  case '1':
  var choice_id=parseInt($$(".select").attr("choice_id"));
  var ojb_examination=new Examination();
  ojb_examination.getExamination(set_id,examination_id,'next');
  console.log("choice_id="+choice_id);
  if (!isNaN(choice_id)) {
    var ojb_answer=new Answer();
    ojb_answer.add_answer(choice_id,set_id,examination_id,examination_type_id);
  }
    break;
  case '2':

  break;
  case '3':

  break;
  case '4':

  break;
  case '5':
  var wording=$$(".testpage_wording-textbox").val();
  if (wording) {
    var ojb_answer=new Answer();
    ojb_answer.add_answer(wording,set_id,examination_id,examination_type_id);
  }
  var ojb_examination=new Examination();
  ojb_examination.getExamination(set_id,examination_id,'next');
  //console.log("choice_id="+choice_id);
  /*
  if (!isNaN(choice_id)) {
    var ojb_answer=new Answer();
    ojb_answer.add_answer(choice_id,set_id,examination_id);
  }
  */
  break;

}

//getExamination(set_id,examination_id,pre_next)
});//click next_btn

$$(document).on("click", "#prv_btn", function() {
var  examination_type_id=$$(this).attr("examination_type_id");
  var set_id=$$(this).attr("set_id");
  var examination_id=$$(this).attr("examination_id");

  switch (examination_type_id) {
    case '1':
    var choice_id=parseInt($$(".select").attr("choice_id"));
    var ojb_examination=new Examination();
    ojb_examination.getExamination(set_id,examination_id,'pre');
    console.log("choice_id="+choice_id);
    if (!isNaN(choice_id)) {
      var ojb_answer=new Answer();
      ojb_answer.add_answer(choice_id,set_id,examination_id,examination_type_id);
    }
      break;
    case '2':

    break;
    case '3':

    break;
    case '4':

    break;
    case '5':
    var wording=$$(".testpage_wording-textbox").val();
    if (wording) {
      var ojb_answer=new Answer();
      ojb_answer.add_answer(wording,set_id,examination_id,examination_type_id);
    }
    var ojb_examination=new Examination();
    ojb_examination.getExamination(set_id,examination_id,'pre');
    /*
    if (!isNaN(choice_id)) {
      var ojb_answer=new Answer();
      ojb_answer.add_answer(choice_id,set_id,examination_id);
    }
    */
    break;

  }

});//click next_btn
