

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

logout(){
    $$("#content_choice").html('');
    var content='\
    <div class="testpage">\
      <div class="testpage_status">\
        <span class="testpage_status-head">DONE</span>\
        <div class="testpage_status-cover">\
          <div class="testpage_status-tag completed">\
            <i class="statusicons"><img src="img/icons/symbol-correct@3x.png"></i>\
            <div></div>\
            <a id="get_logout" href="" class="back_btn">LOGOUT</a>\
          </div>\
        </div>\
      </div>\
    </div>\
    ';
      $$("#content_choice").append(content);
$$('#name_surname').val("");
$$('#student_code').val("");
mainView.router.load({pageName: 'choice',ignoreCache:true});
}

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
formattype=['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26'];
          break;
      case '3':
formattype=['ก','ข','ค','ง','จ','ฉ','ช','ซ','ฌ','ญ','ฎ','ฏ','ฐ','ฑ','ฒ','ณ','ด','ต','ถ','ท','ธ','น','บ','ป','ผ','ฝ'];
  }
        break;
    case '2':
    switch(examination_type_format_id) {
      case '4':
formattype=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
          break;
      case '5':
formattype=['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26'];

          break;
      case '6':
formattype=['ก','ข','ค','ง','จ','ฉ','ช','ซ','ฌ','ญ','ฎ','ฏ','ฐ','ฑ','ฒ','ณ','ด','ต','ถ','ท','ธ','น','บ','ป','ผ','ฝ'];
  }
        break;
  }
return formattype;
}//examinationTypeFormat
}//class

class Exam {

GetListExam(){
  $$("#content_prpage").html("");
  var content='\
  <div class="prpage">\
  ';
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
content+='\
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
      ข้อสอบ '+field.countset+' ชุด จำนวน '+field.countexamination+' ข้อ\
      </span>\
    </div>\
</div>\
  </a>\
';
}//if else
  });//each
  content+='\
  </div>\
  ';
  $$("#content_prpage").append(content);
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
    <span>'+data[0].set_name+' มี '+data[0].pathnumber+' ข้อ</span>\
    <br>\
  ';
  var num;
  set_id=data[0].set_id;
  $$.each(data[0].path, function(i, field){
  num=i+1;
    content+='\
    <div class="row no-gutter">\
      <div class="col-75"><span>ส่วนที่ '+num+' '+field.exam_path_name+' </span></div>\
      <div class="col-25"><span class="text-right">'+field.total+' ข้อ</span></div>\
    </div>\
    ';
  });//each
  content+='\
  </div>\
  <div class="text-right">\
  <a href="#" class="back_btn small back">BACK</a>\
  <a id="startexam" href="#" class="next_btn small" student_id="'+localStorage.student_id+'" exam_id="'+exam_id+'"  register_exam_id="'+register_exam_id+'" set_id="'+set_id+'">NEXT</a>\
  </div>\
  </div>\
  </div>\
  ';
$$("#content_examboard").append(content);
  });//getJson

}//checkRegisterSet

sent_exam(exam_id){
  var param ={student_id:localStorage.student_id,exam_id:exam_id};
  var url = "http://"+hosturl+"/api/exam/addSentExam/";
  $$.getJSON( url,{parameter:param}
  ,function( data ) {

});//getJson
}//sent_exam
}//class

class Examination {
getExamination(set_id,examination_id,pre_next,row){
$$("#content_choice").html("");
  var param ={set_id:set_id,student_id:localStorage.student_id,examination_id:examination_id,pre_next:pre_next,row:row};
  var url = "http://"+hosturl+"/api/examination/getexamination/";
  var formattype;
  var content;
  $$.getJSON( url,{parameter:param}
  ,function( data ) {
  var progess=(parseInt(data.countanswer)/parseInt(data.examination_count))*100;
  var total=parseInt(data.examination_count)-parseInt(data.countanswer);
  var examination_type_id=data[0].examination_type_id;
  var examination_id=data[0].examination_id;
  switch (examination_type_id) {
    case '0':
  console.log(data[0].exam_id);
  if (progess==100) {
  console.log("progess==100");
  var ojb_examination=new Examination();
  ojb_examination.complete(total,set_id);
  } else {
  console.log("progess!=100");
  var ojb_examination=new Examination();
  ojb_examination.uncomplete(total,set_id);
  }//progess
    break;
    case '1':
    var examination_type_format_id=data[0].examination_type_format_id;
    var ojb_Utility=new Utility();
    formattype=ojb_Utility.examinationTypeFormat(examination_type_id,examination_type_format_id);
    var content='\
    <div class="testpage">\
      <a id="choiceselected" set_id="'+set_id+'" examination_id="'+examination_id+'" save="yes" examination_type_id="'+examination_type_id+'"  href="" class="testpage_overall"><img src="img/btn/overall@2x.png"></a>\
      <div class="testpage_completed">\
        <div class="testpage_completed-step">\
    ';
    content+='\
    <span class="step_point" style="left: '+progess+'%"></span>\
    <div class="step_line">\
      <div style="width: '+progess+'%"></div>\
    </div>\
  </div>\
  <span class="testpage_completed-text">Completed '+data.countanswer+'/'+data.examination_count+'</span>\
  </div>\
  <span class="testpage_part">Part '+data.row_exam_path+' '+data[0].exam_path_name+' '+data.number_examination+' Item ('+data.score+' Point)</span>\
  <span class="testpage_subject">\
'+data[0].row+'. '+data[0].examination_title+'\
';
if (data.story) {


  content+='\
  </span>\
  <div class="testpage_read">\
    <a href="#" class="next_btn open-popup" data-popup=".popup-story">\
      <i class="f7-icons">search_strong</i>\
      READ STORY\
    </a>\
  </div>\
  <!-- story Popup -->\
<div class="popup popup-story">\
  <div class="content-block">\
    <div class="imgpopup story">\
        <div class="imgpopup_inner">\
          <a href="#" class="imgpopup_inner-close close-popup"><img src="img/btn/close@3x.png"></a>\
                  <div class="imgpopup_story">\
                       <span class="imgpopup_story-head">Reading & Answer</span>\
                       <span class="imgpopup_story-text">\
'+data.story+'\
                       </span>\
                  </div>\
        </div>\
      </div>\
  </div>\
</div>\
';
}
if (data.image) {
content+='\
</span>\
<div class="testpage_read">\
  <a href="#" class="next_btn open-popup" data-popup=".popup-img">\
    <i class="f7-icons">search_strong</i>\
    READ MORE.\
  </a>\
</div>\
<!-- Images Popup -->\
<div class="popup popup-img">\
<div class="content-block">\
<div class="imgpopup">\
    <div class="imgpopup_inner">\
      <a href="#" class="imgpopup_inner-close close-popup"><img src="img/btn/close@3x.png"></a>\
    </div>\
    <img id="img_popup" src="'+data.image+'" class="imgpopup_img">\
  </div>\
</div>\
</div>\
';
}
content+='\
<div class="popup popup-choice">\
  <div class="content-block">\
    <div class="imgpopup">\
        <div class="imgpopup_inner">\
          <a href="#" class="imgpopup_inner-close close-popup"><img src="img/btn/close@3x.png"></a>\
        </div>\
        <img id="img_choice_popup" src="" class="imgpopup_img">\
      </div>\
  </div>\
</div>\
';
    content+='\
  <div class="testpage_basiccard">\
    <div class="testpage_nav">\
      <a id="next_btn" href="#" class="testpage_nav-btn next" set_id="'+set_id+'" examination_id="'+data[0].examination_id+'" row="'+data[0].row+'" examination_type_id="'+data[0].examination_type_id+'"><img src="img/btn/arrow-right@3x.png"></a>\
        ';
  if (data[0].row==1) {
    content+='\
        <a href="#" class="testpage_nav-btn prv back"><img src="img/btn/arrow-left@3x.png"></a>\
      </div>\
      <div class="testpage_basiccard-inner">\
        <ul class="testpage_choice">\
      ';
  }else {
    content+='\
        <a id="prv_btn" href="#" class="testpage_nav-btn prv" set_id="'+set_id+'" examination_id="'+data[0].examination_id+'" row="'+data[0].row+'" examination_type_id="'+data[0].examination_type_id+'"><img src="img/btn/arrow-left@3x.png"></a>\
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
              <div class="col-30"><a href="#" data-popup=".popup-choice" class="open-popup"><div class="choice_img"><img id="img_choice" src="'+field.choice_img_name+'"></div></a></div>\
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
        <li  choice_id="'+field.choice_id+'">\
          <div class="row no-gutter">\
            <div class="col-70"><div class="choice">'+formattype[i]+'.<font>'+field.choice_detail+'</font></div></div>\
            <div class="col-30"><a href="#" data-popup=".popup-choice" class="open-popup"><div class="choice_img"><img id="img_choice" src="'+field.choice_img_name+'"></div></a></div>\
         </div>\
        </li>\
        ';
      }

    }

    });//each
    content+='\
    </ul>\
    </div>\
    </div>\
    </div>\
    ';
    $$("#content_choice").append(content);
      break;
    case '2':
    var examination_type_format_id=data[0].examination_type_format_id;
    var ojb_Utility=new Utility();
    formattype=ojb_Utility.examinationTypeFormat(examination_type_id,examination_type_format_id);
    var content='\
    <div class="testpage">\
      <a id="choiceselected" set_id="'+set_id+'" examination_id="" save="yes" examination_type_id="'+examination_type_id+'" href="" class="testpage_overall"><img src="img/btn/overall@2x.png"></a>\
      <div class="testpage_completed">\
        <div class="testpage_completed-step">\
    ';
    content+='\
    <span class="step_point" style="left: '+progess+'%"></span>\
    <div class="step_line">\
      <div style="width: '+progess+'%"></div>\
    </div>\
  </div>\
  <span class="testpage_completed-text">Completed '+data.countanswer+'/'+data.examination_count+'</span>\
  </div>\
  <span class="testpage_part">Part '+data.row_exam_path+' '+data[0].exam_path_name+' '+data.number_examination+' Item ('+data.score+' Point)</span>\
  <div class="testpage_couple">\
    <div class="row">\
      <div class="col-50">\
        <div class="testpage_couple-card">\
          <span class="testpage_couple-head">Question '+data.row_frist+' - '+data.row_last+'</span>\
          <ul class="testpage_couple-list">\
        ';
        $$.each(data, function(i, field){

          if (field.examination_title) {
          content+='\
          <li>\
            <span>\
               '+field.row+'\
               <select class="examination" examination_id="'+field.examination_id+'">\
               <option>-</option>\
               ';
               var num;
               $$.each(data.choice, function(i2, field2){
                 num=0;
                 $$.each(data.getanswer, function(i4, field4){
if (field4.examination_id==field.examination_id &&field4.choice_pair_id==field2.choice_pair_id) {
                content+='\
                <option  value="'+field2.choice_pair_id+'" selected>'+formattype[i2]+'</option>\
';
num++;
}
  });//each
  if (num==0) {
    content+='\
    <option  value="'+field2.choice_pair_id+'">'+formattype[i2]+'</option>\
  ';
  }

                });//each
              content+='\
               </select>\
               '+field.examination_title+'\
            </span>\
          </li>\
          ';
                            }
        });//each
        var count_choice=data.choice.length;
        content+='\
        </ul>\
      </div>\
    </div>\
        <div class="col-50">\
          <div class="testpage_couple-card">\
            <span class="testpage_couple-head">Answer '+formattype[0]+'-'+formattype[count_choice-1]+'</span>\
            <ul class="testpage_couple-list">\
            ';
        $$.each(data.choice, function(i3, field3){
          content+='\
<li><span>'+formattype[i3]+'. '+field3.choice_detail+'</span></li>\
';
              });//each
              content+='\
              </ul>\
            </div>\
            ';
            content+='\
            </ul>\
          </div>\
        </div>\
      </div>\
    </div>\
    <div class="row">\
      <div class="col-50">\
        <div class="text-left">\
          <a id="pre_path"  href="javascript:;" set_id="'+set_id+'" examination_id="'+data.row_frist+'" row="'+data.row_frist+'" class="back_btn back small">BACK PART</a>\
        </div>\
      </div>\
      <div class="col-50">\
        <div class="text-right">\
          <a id="next_path" href="javascript:;" set_id="'+set_id+'" examination_id="'+data.row_last+'" row="'+data.row_last+'"  class="next_btn small">NEXT PART</a>\
        </div>\
      </div>\
    </div>\
  </div>\
            ';
            $$("#content_choice").append(content);
    break;
    case '3':
    var content='\
    <div class="testpage insertword">\
      <a id="choiceselected" set_id="'+set_id+'" examination_type_format_id="'+data[0].examination_type_format_id+'" save="yes" examination_type_id="'+examination_type_id+'" href="" class="testpage_overall"><img src="img/btn/overall@2x.png"></a>\
      <div class="testpage_completed">\
        <div class="testpage_completed-step">\
    ';
    content+='\
    <span class="step_point" style="left: '+progess+'%"></span>\
    <div class="step_line">\
      <div style="width: '+progess+'%"></div>\
    </div>\
  </div>\
  <span class="testpage_completed-text">Completed '+data.countanswer+'/'+data.examination_count+'</span>\
  </div>\
  <span class="testpage_part">Part '+data.row_exam_path+' '+data[0].exam_path_name+' '+data.number_examination+' Item ('+data.score+' Point)</span>\
  <div class="testpage_basiccard">\
    <div class="testpage_basiccard-inner">\
      <div class="testpage_insertword">\
        <span class="testpage_insertword-head">Fill Answers in the blank</span>\
        <ul class="testpage_insertword-list">\
  ';
  $$.each(data, function(i, field){

    if (field.examination_title) {
content+='\
<li><spanrow="'+field.row+'" >'+field.row+'. '+field.examination_title+'</span></li>\
';

    }
      });//each
  content+='\
  </ul>\
</div>\
</div>\
<div class="text-right">\
';
if (data.row_frist==1) {
if (data[0].examination_type_format_id==7) {
  content+='\
  <a href="#" id="back_btn_fill" set_id="'+set_id+'" class="back_btn back small">BACK PART</a>\
  ';
}else {
  content+='\
  <a href="#" id="back_btn_fill_fill" set_id="'+set_id+'" class="back_btn back small">BACK PART</a>\
  ';
}

}else{
  if (data[0].examination_type_format_id==7) {
    content+='\
    <a id="back_btn_fill" href="javascript:;" set_id="'+set_id+'" examination_id="'+data.row_frist+'" row="'+data.row_frist+'"  class="back_btn back small">BACK PART</a>\
    ';
  }else {
    content+='\
    <a id="back_btn_fill_fill" href="javascript:;" set_id="'+set_id+'" examination_id="'+data.row_frist+'" row="'+data.row_frist+'"  class="back_btn back small">BACK PART</a>\
    ';
  }

}
  if (data[0].examination_type_format_id==7) {
    content+='\
    <a id="next_btn_fill" href="javascript:;" set_id="'+set_id+'" examination_id="'+data.row_last+'" row="'+data.row_last+'" class="next_btn small">NEXT PART</a>\
      </div>\
    </div>\
    </div>\
      ';
  }else {
    content+='\
    <a id="next_btn_fill_fill" href="javascript:;" set_id="'+set_id+'" examination_id="'+data.row_last+'" row="'+data.row_last+'" class="next_btn small">NEXT PART</a>\
      </div>\
    </div>\
    </div>\
      ';
  }


$$("#content_choice").append(content);
    break;
    case '4':
    var content='\
    <div class="testpage yesno">\
      <a id="choiceselected" set_id="'+set_id+'" examination_id="'+examination_id+'" save="yes" examination_type_id="'+examination_type_id+'"  href="" class="testpage_overall"><img src="img/btn/overall@2x.png"></a>\
      <div class="testpage_completed">\
        <div class="testpage_completed-step">\
    ';
    content+='\
    <span class="step_point" style="left: '+progess+'%"></span>\
    <div class="step_line">\
      <div style="width: '+progess+'%"></div>\
    </div>\
  </div>\
  <span class="testpage_completed-text">Completed '+data.countanswer+'/'+data.examination_count+'</span>\
  </div>\
  <span class="testpage_part">Part '+data.row_exam_path+' '+data[0].exam_path_name+' '+data.number_examination+' Item ('+data.score+' Point)</span>\
  <span class="testpage_subject">\
  '+data[0].row+'. '+data[0].examination_title+'\
  </span>\
  ';
  if (data.story) {
    content+='\
    <div class="testpage_read">\
      <a href="#" class="next_btn open-popup" data-popup=".popup-story">\
        <i class="f7-icons">search_strong</i>\
        READ STORY\
      </a>\
    </div>\
    <!-- story Popup -->\
  <div class="popup popup-story">\
    <div class="content-block">\
      <div class="imgpopup story">\
          <div class="imgpopup_inner">\
            <a href="#" class="imgpopup_inner-close close-popup"><img src="img/btn/close@3x.png"></a>\
                    <div class="imgpopup_story">\
                         <span class="imgpopup_story-head">Reading & Answer</span>\
                         <span class="imgpopup_story-text">\
  '+data.story+'\
                         </span>\
                    </div>\
          </div>\
        </div>\
    </div>\
  </div>\
  ';
  }
  if (data.image) {
  content+='\
  <div class="testpage_read">\
    <a href="#" class="next_btn open-popup" data-popup=".popup-img">\
      <i class="f7-icons">search_strong</i>\
      READ MORE.\
    </a>\
  </div>\
  <!-- Images Popup -->\
  <div class="popup popup-img">\
  <div class="content-block">\
  <div class="imgpopup">\
      <div class="imgpopup_inner">\
        <a href="#" class="imgpopup_inner-close close-popup"><img src="img/btn/close@3x.png"></a>\
      </div>\
      <img id="img_popup" src="'+data.image+'" class="imgpopup_img">\
    </div>\
  </div>\
  </div>\
  ';
  }
  content+='\
  <div class="popup popup-choice">\
    <div class="content-block">\
      <div class="imgpopup">\
          <div class="imgpopup_inner">\
            <a href="#" class="imgpopup_inner-close close-popup"><img src="img/btn/close@3x.png"></a>\
          </div>\
          <img id="img_choice_popup" src="" class="imgpopup_img">\
        </div>\
    </div>\
  </div>\
  ';
  content+='\
  <div class="testpage_basiccard">\
    <div class="testpage_nav">\
      <a id="next_btn" href="#" class="testpage_nav-btn next" set_id="'+set_id+'" examination_id="'+data[0].examination_id+'" row="'+data[0].row+'" examination_type_id="'+data[0].examination_type_id+'"><img src="img/btn/arrow-right@3x.png"></a>\
        ';
  if (data[0].row==1) {
    content+='\
        <a href="#" class="testpage_nav-btn prv back"><img src="img/btn/arrow-left@3x.png"></a>\
      </div>\
      <div class="testpage_basiccard-inner">\
        <ul class="testpage_choice">\
      ';
  }else {
    content+='\
        <a id="prv_btn" href="#" class="testpage_nav-btn prv" set_id="'+set_id+'" examination_id="'+data[0].examination_id+'" row="'+data[0].row+'" examination_type_id="'+data[0].examination_type_id+'"><img src="img/btn/arrow-left@3x.png"></a>\
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
            <li class="select" choice_id="'+field.choice_id+'"><div class="choice"><font>'+field.choice_detail+'</font></div></li>\
            ';
        }else {
            console.log("no");
          content+='\
          <li class="select" choice_id="'+field.choice_id+'">\
            <div class="row no-gutter">\
              <div class="col-70"><div class="choice"><font>'+field.choice_detail+'</font></div></div>\
              <div class="col-30"><a href="#" data-popup=".popup-choice" class="open-popup"><div class="choice_img"><img id="img_choice" src="'+field.choice_img_name+'"></div></a></div>\
           </div>\
          </li>\
          ';
        }

    }else {
      if (!field.choice_img_name) {
        console.log("yes");
        content+='\
        <li choice_id="'+field.choice_id+'"choice_id="'+field.choice_id+'"><div class="choice" ><font>'+field.choice_detail+'</font></div></li>\
        ';
      }else {
        console.log("no");
        content+='\
        <li class="select" choice_id="'+field.choice_id+'">\
          <div class="row no-gutter">\
            <div class="col-70"><div class="choice"><font>'+field.choice_detail+'</font></div></div>\
            <div class="col-30"><a href="#" data-popup=".popup-choice" class="open-popup"><div class="choice_img"><img id="img_choice" src="'+field.choice_img_name+'"></div></a></div>\
         </div>\
        </li>\
        ';
      }

    }

    });//each
    content+='\
    </ul>\
    </div>\
    </div>\
    </div>\
    ';
    $$("#content_choice").append(content);
    break;
    case '5':
    var content='\
    <div class="testpage">\
      <a id="choiceselected" set_id="'+set_id+'" examination_id="'+examination_id+'" save="yes" examination_type_id="'+examination_type_id+'" href="" class="testpage_overall"><img src="img/btn/overall@2x.png"></a>\
      <div class="testpage_completed">\
        <div class="testpage_completed-step">\
    ';
    content+='\
    <span class="step_point" style="left: '+progess+'%"></span>\
    <div class="step_line">\
      <div style="width: '+progess+'%"></div>\
    </div>\
  </div>\
  <span class="testpage_completed-text">Completed '+data.countanswer+'/'+data.examination_count+'</span>\
  </div>\
  <span class="testpage_part">Part '+data.row_exam_path+' '+data[0].exam_path_name+' '+data.number_examination+' Item ('+data.score+' Point)</span>\
  <span class="testpage_subject">\
  '+data[0].row+'. '+data[0].examination_title+'\
  </span>\
  ';
  if (data.story) {
    content+='\
    <div class="testpage_read">\
      <a href="#" class="next_btn open-popup" data-popup=".popup-story">\
        <i class="f7-icons">search_strong</i>\
        READ STORY\
      </a>\
    </div>\
    <!-- story Popup -->\
  <div class="popup popup-story">\
    <div class="content-block">\
      <div class="imgpopup story">\
          <div class="imgpopup_inner">\
            <a href="#" class="imgpopup_inner-close close-popup"><img src="img/btn/close@3x.png"></a>\
                    <div class="imgpopup_story">\
                         <span class="imgpopup_story-head">Reading & Answer</span>\
                         <span class="imgpopup_story-text">\
  '+data.story+'\
                         </span>\
                    </div>\
          </div>\
        </div>\
    </div>\
  </div>\
  ';
  }
  if (data.image) {
  content+='\
  <div class="testpage_read">\
    <a href="#" class="next_btn open-popup" data-popup=".popup-img">\
      <i class="f7-icons">search_strong</i>\
      READ MORE.\
    </a>\
  </div>\
  <!-- Images Popup -->\
  <div class="popup popup-img">\
  <div class="content-block">\
  <div class="imgpopup">\
      <div class="imgpopup_inner">\
        <a href="#" class="imgpopup_inner-close close-popup"><img src="img/btn/close@3x.png"></a>\
      </div>\
      <img id="img_popup" src="'+data.image+'" class="imgpopup_img">\
    </div>\
  </div>\
  </div>\
  ';
  }
  content+='\
  <div class="testpage_basiccard">\
    <div class="testpage_nav">\
      <a id="next_btn" href="#" class="testpage_nav-btn next" set_id="'+set_id+'" examination_id="'+data[0].examination_id+'" row="'+data[0].row+'" examination_type_id="'+data[0].examination_type_id+'"><img src="img/btn/arrow-right@3x.png"></a>\
        ';
  if (data[0].row==1) {
    content+='\
        <a href="#" class="testpage_nav-btn prv back"><img src="img/btn/arrow-left@3x.png"></a>\
      </div>\
      <div class="testpage_basiccard-inner">\
        <ul class="testpage_choice">\
      ';
  }else {
    content+='\
        <a id="prv_btn" href="#" class="testpage_nav-btn prv" set_id="'+set_id+'" examination_id="'+data[0].examination_id+'" row="'+data[0].row+'" examination_type_id="'+data[0].examination_type_id+'"><img src="img/btn/arrow-left@3x.png"></a>\
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
content+='\
</ul>\
</div>\
</div>\
</div>\
';
$$("#content_choice").append(content);
    break;

  }//switch
});//getJson


mainView.router.load({pageName: 'choice',ignoreCache:true});
}//function getExamination

getLayout(set_id){
$$("#content_choice").html("");
var student_id=localStorage.student_id;
var param ={set_id:set_id,student_id:student_id};
var url = "http://"+hosturl+"/api/examination/getLayout/";
var content="";
content+='\
<div class="selectedpage">\
  <span class="selectedpage_note">"Select numeral and go (Green color is done)"</span>\
  <div class="selectedpage_choice">\
';
var path=0;
var num=0;
$$.getJSON( url,{parameter:param}
,function( data ) {
$$.each(data, function(i, field){
if (path!=field.exam_path_id) {
path=field.exam_path_id;
if (num>0) {
  content+='\
</div>\
  ';
}
num++;
if (field.exam_path_name) {
content+='\
<div class="row">\
  <div class="col-50">\
<span class="selectedpage_choice-head">Part '+num+':'+field.exam_path_name+'</span>\
</div>\
<div class="col-50">\
<div class="text-right">\
';
if (num==1) {
  content+='\
    <a id="submit" exam_id="'+field.exam_id+'" examination_count="'+data.examination_count+'"  countanswer="'+data.countanswer+'" href="" class="next_btn">\
      <i class="f7-icons">arrow_up</i>\
      Submit your exam\
    </a>\
  </div>\
  </div>\
  </div>\
  <div class="selectedpage_choice-list">\
  ';
}else {
  content+='\
  </div>\
  </div>\
  </div>\
  <div class="selectedpage_choice-list">\
  ';
}//else
switch (field.examination_type_id) {
  case '1':
  if (field.getanswer>0) {
    content+='\
    <a id="examination" href="" class="choice select" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
    ';
  }else {
    content+='\
    <a id="examination" href="" class="choice" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
    ';
  }
    break;
    case '2':
    if (field.getanswer[0].status=="success") {
      content+='\
      <a id="examination" href="" class="choice select" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
      ';
    }else {
      content+='\
      <a id="examination" href="" class="choice" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
      ';
    }
      break;
      case '3':
      if (field.getanswer=="success") {
        content+='\
        <a id="examination" href="" class="choice select" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
        ';
      }else {
        content+='\
        <a id="examination" href="" class="choice" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
        ';
      }
        break;
        case '4':
        if (field.getanswer>0) {
          content+='\
          <a id="examination" href="" class="choice select" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
          ';
        }else {
          content+='\
          <a id="examination" href="" class="choice" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
          ';
        }
          break;
          case '5':
          if (field.getanswer!=0) {
            content+='\
            <a id="examination" href="" class="choice select" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
            ';
          }else {

            content+='\
            <a id="examination" href="" class="choice" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
            ';
          }
            break;


}

}//path
}//new path
else {
if (field.exam_path_name) {
  switch (field.examination_type_id) {
    case '1':
    if (field.getanswer>0) {
      content+='\
      <a id="examination" href="" class="choice select" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
      ';
    }else {
      content+='\
      <a id="examination" href="" class="choice" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
      ';
    }
      break;
      case '2':
      if (field.getanswer[0].status=="success") {
        content+='\
        <a id="examination" href="" class="choice select" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
        ';
      }else {
        content+='\
        <a id="examination" href="" class="choice" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
        ';
      }
        break;
        case '3':
        if (field.getanswer=="success") {
          content+='\
          <a id="examination" href="" class="choice select" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
          ';
        }else {
          content+='\
          <a id="examination" href="" class="choice" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
          ';
        }
          break;
          case '4':
          if (field.getanswer>0) {
            content+='\
            <a id="examination" href="" class="choice select" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
            ';
          }else {
            content+='\
            <a id="examination" href="" class="choice" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
            ';
          }
            break;
            case '5':
            if (field.getanswer!=0) {
              content+='\
              <a id="examination" href="" class="choice select" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
              ';
            }else {
              content+='\
              <a id="examination" href="" class="choice" examination_id="'+field.examination_id+'"  set_id="'+field.set_id+'"row="'+field.row+'" >'+field.row+'</a>\
              ';
            }
              break;


  }
}
}
});//each

if (content=="") {
console.log('content='+content);
}else {
  content+='\
</div>\
  ';
  $$("#content_choice").append(content);
}

});//getJson

mainView.router.load({pageName: 'choice',ignoreCache:true});
}//get getLayout

uncomplete(total,set_id){
  $$("#content_choice").html('');
  var content='\
  <div class="testpage">\
    <a id="choiceselected" href="" class="testpage_overall" set_id="'+set_id+'"><img src="img/btn/overall@2x.png"></a>\
    <div class="testpage_status">\
      <span class="testpage_status-head">Incompleted</span>\
      <span class="testpage_status-text">You are not complete</span>\
      <div class="testpage_status-cover">\
        <div class="testpage_status-tag incompleted">\
          <i class="statusicons"><img src="img/icons/group-7@3x.png"></i>\
          <span class="statustext">'+total+' items are incompleted.</span>\
          <a id="choiceselected" href="" class="back_btn" set_id="'+set_id+'">BACK</a>\
        </div>\
      </div>\
    </div>\
  </div>\
  ';
    $$("#content_choice").append(content);
}//uncomplete

complete(total,set_id){
  $$("#content_choice").html('');
  var content='\
  <div class="testpage">\
    <a id="choiceselected"  class="testpage_overall" set_id="'+set_id+'"><img src="img/btn/overall@2x.png"></a>\
    <div class="testpage_status">\
      <span class="testpage_status-head">Completed</span>\
      <span class="testpage_status-text">You are completed.</span>\
      <div class="testpage_status-cover">\
        <div class="testpage_status-tag completed">\
          <i class="statusicons"><img src="img/icons/symbol-correct@3x.png"></i>\
          <span class="statustext">Successful</span>\
          <a id="logout"  set_id="'+set_id+'" href="" class="back_btn">SUBMIT</a>\
        </div>\
      </div>\
    </div>\
  </div>\
  ';
    $$("#content_choice").append(content);
}//complete

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
      if (distance == 900000) {
          myApp.alert("เหลือเวลา 15 นาที", 'SMART EXAM');
      }
      if (distance < 0) {
          clearInterval(x);
          myApp.alert("หมดเวลาสอบ", 'SMART EXAM');
          document.getElementById("counttime").innerHTML = "Time Out";
var ojb_time_exam=new TimeExam();
ojb_time_exam.timeout();
      }
  }, 1000);
}//function starttime

checkTimeExam(register_exam_id,set_id,exam_id,student_id){
  var param ={register_exam_id:register_exam_id,exam_id:exam_id,student_id:student_id};
  var url = "http://"+hosturl+"/api/exam/getExamTime/";
  $$.getJSON( url,{parameter:param}
  ,function( data ) {
$$.each(data, function(i, field){
switch (field.status) {
  case "false":
myApp.alert("ยังไม่ถึงเวลาสอบ", 'SMART EXAM');
    break;
  case "success":
  var ojb_time_exam=new TimeExam();
  ojb_time_exam.starttime(field.time_start_stamp,field.time_end_stamp);
  var row=0;
var ojb_examination=new Examination();
ojb_examination.getExamination(set_id,'0','normal',row);
      break;
  case "sent":
myApp.alert("คุณส่งข้อสอบไปแล้ว", 'SMART EXAM');
  break;

}
/*
if (field.status=="false") {
myApp.alert("ยังไม่ถึงเวลาสอบ", 'SMART EXAM');
}else {
  var ojb_time_exam=new TimeExam();
  ojb_time_exam.starttime(field.time_start_stamp,field.time_end_stamp);
var ojb_examination=new Examination();
ojb_examination.getExamination(set_id,'0','normal');
}
*/
});//each
});//getJson
}//checkTimeExam


timeout(){
    $$("#content_choice").html('');
    var content='\
    <div class="testpage">\
      <div class="testpage_status">\
        <span class="testpage_status-head">Time Out</span>\
        <div class="testpage_status-cover">\
          <div class="testpage_status-tag completed">\
            <i class="statusicons"><img src="img/icons/symbol-correct@3x.png"></i>\
            <div></div>\
            <a id="get_logout" href="" class="back_btn">LOGOUT</a>\
          </div>\
        </div>\
      </div>\
    </div>\
    ';
      $$("#content_choice").append(content);
$$('#name_surname').val("");
$$('#student_code').val("");
}//timeout
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
            var param ={choice_id:choice_id,student_id:localStorage.student_id,set_id:set_id,examination_id:examination_id};
            var url = "http://"+hosturl+"/api/answer/addAnswer/";
            $$.getJSON( url,{parameter:param}
            ,function( data ) {
            $$.each(data, function(i, field){
              console.log(field.status);
            });//each
            });//getJson
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

  add_answer_path(item,set_id){
    console.log(set_id);
    var param ={item:item,student_id:localStorage.student_id,set_id:set_id};
    var url = "http://"+hosturl+"/api/answer/addAnswerPath/";
    $$.getJSON( url,{parameter:param}
    ,function( data ) {
    $$.each(data, function(i, field){
      console.log(field.status);
    });//each
    });//getJson
  }

  add_answer_path_fill(item,set_id){
    console.log(set_id);
    var param ={item:item,student_id:localStorage.student_id,set_id:set_id};
    var url = "http://"+hosturl+"/api/answer/addAnswerPathFill/";
    $$.getJSON( url,{parameter:param}
    ,function( data ) {
    $$.each(data, function(i, field){
      console.log(field.status);
    });//each
    });//getJson
  }

  add_answer_path_fill_fill(item,set_id){
    console.log(set_id);
    var param ={item:item,student_id:localStorage.student_id,set_id:set_id};
    var url = "http://"+hosturl+"/api/answer/addAnswerPathFillFill/";
    $$.getJSON( url,{parameter:param}
    ,function( data ) {
    $$.each(data, function(i, field){
      console.log(field.status);
    });//each
    });//getJson
  }

}//class Answer






startapp();
function startapp() {
//  localStorage.removeItem("student_id");
//  localStorage.removeItem("student_code");
//  localStorage.removeItem("fullname");
if (localStorage.student_id) {
  var ojb_exam=new Exam();
  ojb_exam.GetListExam();
  mainView.router.load({pageName: 'prpage',ignoreCache:true});
}



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
var exam_id=$$(this).attr("exam_id");
var student_id=$$(this).attr("student_id");
var ojb_time_exam=new TimeExam();
ojb_time_exam.checkTimeExam(register_exam_id,set_id,exam_id,student_id);
});//click login

$$(document).on("click", "#next_btn", function() {
var  examination_type_id=$$(this).attr("examination_type_id");
var set_id=$$(this).attr("set_id");
var examination_id=$$(this).attr("examination_id");
var row=$$(this).attr("row");
switch (examination_type_id) {
  case '1':
  var choice_id=parseInt($$(".select").attr("choice_id"));
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
  var choice_id=parseInt($$(".select").attr("choice_id"));
  console.log("choice_id="+choice_id);
  if (!isNaN(choice_id)) {
    var ojb_answer=new Answer();
    ojb_answer.add_answer(choice_id,set_id,examination_id,examination_type_id);
  }
  break;
  case '5':
  var wording=$$(".testpage_wording-textbox").val();
  if (wording) {
    var ojb_answer=new Answer();
    ojb_answer.add_answer(wording,set_id,examination_id,examination_type_id);
  }

  //console.log("choice_id="+choice_id);
  /*
  if (!isNaN(choice_id)) {
    var ojb_answer=new Answer();
    ojb_answer.add_answer(choice_id,set_id,examination_id);
  }
  */
  break;

}
var ojb_examination=new Examination();
ojb_examination.getExamination(set_id,examination_id,'next',row);
//getExamination(set_id,examination_id,pre_next)
});//click next_btn

$$(document).on("click", "#prv_btn", function() {
var  examination_type_id=$$(this).attr("examination_type_id");
  var set_id=$$(this).attr("set_id");
  var examination_id=$$(this).attr("examination_id");
var row=$$(this).attr("row");
  switch (examination_type_id) {
    case '1':
    var choice_id=parseInt($$(".select").attr("choice_id"));
    var ojb_examination=new Examination();
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
    var choice_id=parseInt($$(".select").attr("choice_id"));
    var ojb_examination=new Examination();
    console.log("choice_id="+choice_id);
    if (!isNaN(choice_id)) {
      var ojb_answer=new Answer();
      ojb_answer.add_answer(choice_id,set_id,examination_id,examination_type_id);
    }
    break;
    case '5':
    var wording=$$(".testpage_wording-textbox").val();
    if (wording) {
      var ojb_answer=new Answer();
      ojb_answer.add_answer(wording,set_id,examination_id,examination_type_id);
    }

    /*
    if (!isNaN(choice_id)) {
      var ojb_answer=new Answer();
      ojb_answer.add_answer(choice_id,set_id,examination_id);
    }
    */
    break;

  }
  var ojb_examination=new Examination();
  ojb_examination.getExamination(set_id,examination_id,'pre',row);



});//click next_btn

$$(document).on("click", "#next_btn_fill", function() {
var set_id=$$(this).attr("set_id");
var choice_fill=$$(".choice_fill");
var examination_id_next=$$(this).attr("examination_id");
var row=$$(this).attr("row");
var item=[];
$.each(choice_fill,function(k,v){
  var examination_id=$(this).attr('examination_id');
  var number_fill=$(this).attr('number_fill');
  var val=$(this).val();
  item[k]={examination_id:examination_id,number_fill:number_fill,choice_fill_id:val};
	//item[$(this).attr('examination_id')] = $(v).val();
});
console.log(item);
var ojb_answer=new Answer();
ojb_answer.add_answer_path_fill(item,set_id);
var ojb_examination=new Examination();
ojb_examination.getExamination(set_id,examination_id_next,'next',row);
});//click next_btn_fill

$$(document).on("click", "#back_btn_fill", function() {
var set_id=$$(this).attr("set_id");
var choice_fill=$$(".choice_fill");
var examination_id_next=$$(this).attr("examination_id");
var row=$$(this).attr("row");
var item=[];
$.each(choice_fill,function(k,v){
  var examination_id=$(this).attr('examination_id');
  var number_fill=$(this).attr('number_fill');
  var val=$(this).val();
  item[k]={examination_id:examination_id,number_fill:number_fill,choice_fill_id:val};
	//item[$(this).attr('examination_id')] = $(v).val();
});
console.log(item);
var ojb_answer=new Answer();
ojb_answer.add_answer_path_fill(item,set_id);
var ojb_examination=new Examination();
ojb_examination.getExamination(set_id,examination_id_next,'pre',row);
});//click next_btn_fill

$$(document).on("click", "#next_btn_fill_fill", function() {
var set_id=$$(this).attr("set_id");
var choice_fill=$$(".choice_fill_fill");
var examination_id_next=$$(this).attr("examination_id");
var row=$$(this).attr("row");
var item=[];
$.each(choice_fill,function(k,v){
  var examination_id=$(this).attr('examination_id');
  var number_fill=$(this).attr('number_fill');
  var val=$(this).val();
  item[k]={examination_id:examination_id,number_fill:number_fill,detail:val};
	//item[$(this).attr('examination_id')] = $(v).val();
});
console.log(item);
var ojb_answer=new Answer();
ojb_answer.add_answer_path_fill_fill(item,set_id);
var ojb_examination=new Examination();
ojb_examination.getExamination(set_id,examination_id_next,'next',row);
});//click next_btn_fill_fill

$$(document).on("click", "#back_btn_fill_fill", function() {
var set_id=$$(this).attr("set_id");
var choice_fill=$$(".choice_fill_fill");
var examination_id_next=$$(this).attr("examination_id");
var row=$$(this).attr("row");
var item=[];
$.each(choice_fill,function(k,v){
  var examination_id=$(this).attr('examination_id');
  var number_fill=$(this).attr('number_fill');
  var val=$(this).val();
  item[k]={examination_id:examination_id,number_fill:number_fill,detail:val};
	//item[$(this).attr('examination_id')] = $(v).val();
});
console.log(item);
var ojb_answer=new Answer();
ojb_answer.add_answer_path_fill_fill(item,set_id);
var ojb_examination=new Examination();
ojb_examination.getExamination(set_id,examination_id_next,'pre',row);
});//click back_btn_fill_fill

//back_btn_fill


$$(document).on("click", "#next_path", function() {
var set_id=$$(this).attr("set_id");
var examination=$$(".examination");
var examination_id_next=$$(this).attr("examination_id");
var row=$$(this).attr("row");
var item=[];
$.each(examination,function(k,v){
  var examination_id=$(this).attr('examination_id');
  var val=$(this).val();
  item[k]={examination_id:examination_id,choice_pair_id:val};
	//item[$(this).attr('examination_id')] = $(v).val();
});
  var ojb_answer=new Answer();
  ojb_answer.add_answer_path(item,set_id);
var ojb_examination=new Examination();
ojb_examination.getExamination(set_id,examination_id_next,'next',row);


});//click next_path

$$(document).on("click", "#pre_path", function() {
var set_id=$$(this).attr("set_id");
var examination_id_pre=$$(this).attr("examination_id");
var row=$$(this).attr("row");
var examination=$$(".examination");
var item=[];
$.each(examination,function(k,v){
  var examination_id=$(this).attr('examination_id');
  var val=$(this).val();
  item[k]={examination_id:examination_id,choice_pair_id:val};
	//item[$(this).attr('examination_id')] = $(v).val();
});
  var ojb_answer=new Answer();
  ojb_answer.add_answer_path(item,set_id);
var ojb_examination=new Examination();
ojb_examination.getExamination(set_id,examination_id_pre,'pre',row);


});//click pre_path
$$(document).on("click", "#choiceselected", function() {
var set_id=$$(this).attr("set_id");
var save=$$(this).attr("save");
var  examination_type_id=$$(this).attr("examination_type_id");
var examination_id=$$(this).attr("examination_id");
var  examination_type_format_id=$$(this).attr("examination_type_format_id");
if (save=="yes") {

switch (examination_type_id) {
  case '1':
  var choice_id=parseInt($$(".select").attr("choice_id"));
  console.log("choice_id="+choice_id);
  if (!isNaN(choice_id)) {
    var ojb_answer=new Answer();
    ojb_answer.add_answer(choice_id,set_id,examination_id,examination_type_id);
  }
    break;
  case '2':
  var examination=$$(".examination");
  var item=[];
  $.each(examination,function(k,v){
    var examination_id=$(this).attr('examination_id');
    var val=$(this).val();
    item[k]={examination_id:examination_id,choice_pair_id:val};
  });
    var ojb_answer=new Answer();
    ojb_answer.add_answer_path(item,set_id);
  break;
  case '3':
  if (examination_type_format_id==7) {
    var choice_fill=$$(".choice_fill");
    var item=[];
    $.each(choice_fill,function(k,v){
      var examination_id=$(this).attr('examination_id');
      var number_fill=$(this).attr('number_fill');
      var val=$(this).val();
      item[k]={examination_id:examination_id,number_fill:number_fill,choice_fill_id:val};
    	//item[$(this).attr('examination_id')] = $(v).val();
    });
    console.log(item);
    var ojb_answer=new Answer();
    ojb_answer.add_answer_path_fill(item,set_id);
  }else {
    var choice_fill=$$(".choice_fill_fill");
    var item=[];
    $.each(choice_fill,function(k,v){
      var examination_id=$(this).attr('examination_id');
      var number_fill=$(this).attr('number_fill');
      var val=$(this).val();
      item[k]={examination_id:examination_id,number_fill:number_fill,detail:val};
    	//item[$(this).attr('examination_id')] = $(v).val();
    });
    console.log(item);
    var ojb_answer=new Answer();
    ojb_answer.add_answer_path_fill_fill(item,set_id);
  }

  break;
  case '4':
  var choice_id=parseInt($$(".select").attr("choice_id"));
  console.log("choice_id="+choice_id);
  if (!isNaN(choice_id)) {
    var ojb_answer=new Answer();
    ojb_answer.add_answer(choice_id,set_id,examination_id,examination_type_id);
  }
  break;
  case '5':
  var wording=$$(".testpage_wording-textbox").val();
  if (wording) {
    var ojb_answer=new Answer();
    ojb_answer.add_answer(wording,set_id,examination_id,examination_type_id);
  }

  break;

}

}else {
  var examination_id_pre=$$(this).attr("examination_id");
  var examination=$$(".examination");
  var item=[];
  $.each(examination,function(k,v){
    var examination_id=$(this).attr('examination_id');
    var val=$(this).val();
    item[k]={examination_id:examination_id,choice_pair_id:val};
  });
    var ojb_answer=new Answer();
    ojb_answer.add_answer_path(item,set_id);
}
var ojb_examination=new Examination();
ojb_examination.getLayout(set_id);
});//click choiceselected

$$(document).on("click", "#examination", function() {
  var set_id=$$(this).attr("set_id");
  var examination_id=$$(this).attr("examination_id");
  var row=$$(this).attr("row");
  var ojb_examination=new Examination();
ojb_examination.getExamination(set_id,examination_id,'normal',row);
  });//click examination

  $$(document).on("click", "#logout", function() {
    var set_id=$$(this).attr("set_id");
      var ojb_examination=new Examination();
      ojb_examination.getLayout(set_id);
});//click LOGOUT

$$(document).on("click", "#get_logout", function() {
  localStorage.removeItem("student_id");
  localStorage.removeItem("student_code");
  localStorage.removeItem("fullname");
  mainView.router.load({pageName: 'login',ignoreCache:true});
});//click LOGOUT


$$(document).on("click", "#menu_prpage", function() {
  var ojb_exam=new Exam();
  ojb_exam.GetListExam();
  mainView.router.load({pageName: 'prpage',ignoreCache:true});
});//click menu_prpage


$$(document).on("click", "#menu_logout", function() {
var ojb_user=new User();
ojb_user.logout();
});//click menu_logout
$$(document).on("click", "#submit", function() {
var exam_id=$$(this).attr("exam_id");
var countanswer=$$(this).attr("countanswer");
var examination_count=$$(this).attr("examination_count");
if (examination_count==countanswer) {
  myApp.confirm("คุณแน่ใจว่าจะส่งข้อสอบ เพราะส่งแล้วจะกลับมาแก้ไขไม่ได้",'SMART EXAM',function () {
var ojb_exam=new Exam();
    ojb_exam.sent_exam(exam_id);
    var ojb_user=new User();
      ojb_user.logout();
  },function () {

  });
}else {
myApp.alert("คุณยังทำข้อสอบไม่ครบ !", 'SMART EXAM');
}

});//click menu_logout

$$(document).on("click", "#img_choice", function() {
var img=$$(this).attr("src");
var img_popup=$$("#img_choice_popup").attr("src",img);
});//click img_choice
