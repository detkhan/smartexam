<?php
/**
 *
 */
require_once("choice.php");
require_once("answer.php");
require_once("model/examination.php");
class examination
{

public function getexamination($param)
{
$model=new examinations();
$result=$this->checkPath($param);
$examination_type_id=$result[0]['examination_type_id'];
$exam_path_id=$result[0]['exam_path_id'];
if ($examination_type_id !=2 || $examination_type_id !=3) {
  $response=$model->getexamination($param);
  $examination_id=$response[0]['examination_id'];
  $exam_path_id=$response[0]['exam_path_id'];
  $examination_type_id=$response[0]['examination_type_id'];
  $param['examination_id']=$examination_id;
  $set_id=$param['set_id'];
  //$response['row']=$model->getNumberExamination($set_id,$examination_id);
  $response['row_exam_path']=$model->getNumberExamPath($exam_path_id,$set_id);
  $response['examination_count']=$model->getCountExamination($param);
  $ojb_answer=new answer();
  $countanswer=$ojb_answer->countAnswer($param);
  $countanswer_fill=$ojb_answer->countAnswerFill($param);
  $countanswer_path=$ojb_answer->countAnswerPath($param);
  $countanswer_fill_select_all=$this->checkNumberFillSelect($param);
  $response['countanswer']=$countanswer+$countanswer_fill+$countanswer_path+$countanswer_fill_select_all;
}
switch ($examination_type_id) {
  case '1':
  $ojb_choice=new choice();
  $response['choice']=$ojb_choice->getchoice($examination_id);
  $response['score']=$ojb_choice->getscore($exam_path_id);
  $response['number_examination']=$model->getCountExaminationPath($exam_path_id);
  $response['getanswer']=$ojb_answer->getAnswer($param);
  $response['story']=$model->getStory($examination_id);
  $response['image']=$model->getImage($examination_id);
    break;
    case '2':
$param['pre_next']="path";
$param['exam_path_id']=$exam_path_id;
$param['examination_id']=0;
$set_id=$param['set_id'];
$response=$model->getexamination($param);
$number_row=count($response);
$response['row_frist']=$response[0]['row'];
$response['row_last']=$response[($number_row-1)]['row'];
$ojb_choice=new choice();
$response['choice']=$ojb_choice->getchoicePair($exam_path_id);
$ojb_answer=new answer();
$response['getanswer']=$ojb_answer->getAnswerPair($param);
$response['row_exam_path']=$model->getNumberExamPath($exam_path_id,$set_id);
$response['examination_count']=$model->getCountExamination($param);
$countanswer=$ojb_answer->countAnswer($param);
$countanswer_fill=$ojb_answer->countAnswerFill($param);
$countanswer_path=$ojb_answer->countAnswerPath($param);
$response['number_examination']=$model->getCountExaminationPath($exam_path_id);
$response['score']=$model->getScorePath($exam_path_id);
$response['countanswer']=$countanswer+$countanswer_fill+$countanswer_path;

      break;
      case '3':
      $param['pre_next']="path";
      $param['exam_path_id']=$exam_path_id;
      $param['examination_id']=0;
      $set_id=$param['set_id'];
      $ojb_choice=new choice();
      $ojb_answer=new answer();
      $countanswer_fill_select=0;
      $response=$model->getexamination($param);
      foreach ($response as $key => $value) {
      $ex=$value['examination_title'];
      $examination_id=$value['examination_id'];
      $examination_type_format_id=$value['examination_type_format_id'];
      $param1['set_id']=$set_id;
      $param1['examination_id']=$examination_id;
      $param1['exam_path_id']=$exam_path_id;
      $param1['student_id']=$param['student_id'];
      if ($examination_type_format_id==7) {
      $getanswer=$ojb_answer->getAnswerFillSelect($param1);
      $choice=$ojb_choice->getchoiceFill($examination_id);
      $result=$this->addFillSelect($ex,$choice,$getanswer);

    }else {
      $getanswer=$ojb_answer->getAnswerFillFill($param1);
      $result=$this->addFillInput($ex,$getanswer,$examination_id);

    }
      $response[$key]["examination_title"]=$result;
      }

      $param2['set_id']=$set_id;
      $param2['examination_id']=0;
      $param2['exam_path_id']=$exam_path_id;
      $param2['student_id']=$param['student_id'];
      $getanswerall=count($ojb_answer->getAnswerFillSelect($param2));
      $number_fillall=$ojb_answer->checkAnswerFillSelect($param2);
      $countanswer_fill_select_all=$this->checkNumberFillSelect($param2);
      $number_row=count($response);
      $lastnumber=$number_row-1;
      $response['row_frist']=$response[0]['row'];
      $response['row_last']=$response[$lastnumber]['row'];
      $response['number_examination']=$model->getCountExaminationPath($exam_path_id);
      if ($examination_type_format_id==7) {
      $response['score']=$ojb_choice->getscoreFill($exam_path_id);
      }else {
      $response['score']=$model->getscoreFillFill($exam_path_id);
      }

      $response['row_exam_path']=$model->getNumberExamPath($exam_path_id,$set_id);
      $response['examination_count']=$model->getCountExamination($param);
      $countanswer=$ojb_answer->countAnswer($param);
      $countanswer_fill=$ojb_answer->countAnswerFill($param);
      $countanswer_path=$ojb_answer->countAnswerPath($param);
      $response['number_examination']=$model->getCountExaminationPath($exam_path_id);
      $response['countanswer']=$countanswer+$countanswer_fill+$countanswer_path+$countanswer_fill_select_all;
        break;
        case '4':
        $ojb_choice=new choice();
        $response['choice']=$ojb_choice->getchoice($examination_id);
        $response['score']=$ojb_choice->getscore($exam_path_id);
        $response['number_examination']=$model->getCountExaminationPath($exam_path_id);
        $response['getanswer']=$ojb_answer->getAnswer($param);
        $response['story']=$model->getStory($examination_id);
        $response['image']=$model->getImage($examination_id);
          break;
          case '5':
  $response['story']=$model->getStory($examination_id);
  $response['image']=$model->getImage($examination_id);
  $response['getanswer_fill']=$ojb_answer->getAnswerFill($param);
  $response['score']=$model->getScoreFill($exam_path_id);
  $response['number_examination']=$model->getCountExaminationPath($exam_path_id);
            break;
}

$data= json_encode($response);
echo $data;
}

public function checkPath($param)
{
  $model=new examinations();
  $response=$model->getexamination($param);
  return $response;
}

public function getLayout($param)
{
  $model=new examinations();
  $response=$model->getLayout($param);
  $response['examination_count']=$model->getCountExamination($param);
  $ojb_answer=new answer();
  $countanswer=$ojb_answer->countAnswer($param);
  $countanswer_fill=$ojb_answer->countAnswerFill($param);
  $countanswer_path=$ojb_answer->countAnswerPath($param);
  $countanswer_fill_select_all=$this->checkNumberFillSelect($param);
  $response['countanswer']=$countanswer+$countanswer_fill+$countanswer_path+$countanswer_fill_select_all;
  $data= json_encode($response);
  echo $data;
}

public function addFillInput($subject,$getanswer,$examination_id)
{

  $pattern = '/<span class="fill ans(?:[1-9]|10)">\&nbsp\;<\/span>/';
  preg_match_all($pattern, $subject, $matches);

  foreach ($matches[0] as $key => $value) {
    $subject1="";
    $number1="";
    $number2="";
    $key_number=($key+1);
    $detail ="";
    foreach ($getanswer as $key2 => $value2) {
    $fill=$value2['number_exam'];

    if ($key_number==$fill) {
    $detail ='value="'.$value2['detail'].'"' ;
    }
  }
  $result = '<input type="text" class="choice_fill_fill" examination_id="'.$examination_id.'" number_fill="'.$key_number.'" '.$detail.'>';
    $subject = str_replace($value, $result, $subject);
  /*
  $number = str_replace('<span class="fill ans', '', $value);
  $number = str_replace('">&nbsp;</span>', '', $number);
  $subject = str_replace($value, '<input type="text" id="number'.$number.'">', $subject);
  */
  }


 return $subject;
}

public function addFillSelect($subject,$choice,$getanswer)
{

  $pattern = '/<span class="fill ans(?:[1-9]|10)">\&nbsp\;<\/span>/';
  preg_match_all($pattern, $subject, $matches);
  foreach ($matches[0] as $key => $value) {
      $subject1="";
      $number1="";
      $number2="";
      $key_number=($key+1);

      $number1 = '<select class="choice_fill" examination_id="'.$choice[0]['examination_id'].'" number_fill="'.$key_number.'"><option>-</option>';
  foreach ($choice as $key1 => $value1) {
    $selected="";
    $fill=$value1['number_fill'];
    $choice_fill_id=$value1['choice_fill_id'];
  if ($key_number==$fill) {
  foreach ($getanswer as $key2 => $value2) {
    $choice_fill_id_answer=$value2['choice_fill_id'];
  if ($choice_fill_id==$choice_fill_id_answer) {
    $selected="selected";
  //$subject1 .='<option value='.$value1['choice_fill_id'].' selected>'.$value1['choice_detail'].'</option>';
}
}//foreach ($getanswer
$subject1 .='<option value="'.$value1['choice_fill_id'].'" '.$selected.'>'.$value1['choice_detail'].'</option>';
}//$key_number==$fill
}//foreach ($choice
  $number2 ='<select>';
  $result=$number1.$subject1.$number2;
  $subject = str_replace($value, $result, $subject);
  }
 return $subject;
}

public function checkNumberFillSelect($param)
{
$model=new examinations();
$ojb_answer=new answer();
$countanswer_fill_select=0;
$getFillSelect=$model->countFillSelect($param);

//$number_fillall=$ojb_answer->checkAnswerFillSelect($param);
foreach ($getFillSelect as $key => $value) {

  $param1['set_id']=$param['set_id'];
  $param1['examination_id']=$value['examination_id'];
  $param1['exam_path_id']=$value['exam_path_id'];
  $param1['student_id']=$param['student_id'];
  $examination_type_format_id=$value['examination_type_format_id'];
  $number_fill=$ojb_answer->checkAnswerFillSelect($param1);

  if ($examination_type_format_id==7) {
    $getanswer=$ojb_answer->getAnswerFillSelect($param1);
    $number_answer=count($getanswer);
    if ($number_fill==$number_answer) {
    $countanswer_fill_select++;
  }
  }else {

  $getanswer1=$ojb_answer->getAnswerFillFill($param1);
  $number_answer1=count($getanswer1);

  if ($number_fill==$number_answer1) {
  $countanswer_fill_select++;
  }
}
  }
return $countanswer_fill_select;
}


public function getExamPath($set_id)
{
  $model=new examinations();
  $result=$model->getExamPath($set_id);
return $result;
}


public function getExaminationAnswer($exam_path_id,$examination_type_id,$examination_type_format_id,$student_id)
{
  $model=new examinations();
  switch ($examination_type_id) {
    case '1':
$result=$model->getExaminationAnswerChoice($exam_path_id,$student_id);
      break;
    case '2':
$result=$model->getExaminationAnswerPair($exam_path_id,$student_id);
      break;
    case '3':
if ($examination_type_format_id==7) {
$result=$model->getExaminationAnswerFillSelect($exam_path_id,$student_id);
}else {
$result=$model->getExaminationAnswerFillFill($exam_path_id,$student_id);
}
      break;
    case '4':
$result=$model->getExaminationAnswerChoice($exam_path_id,$student_id);
      break;
    case '5':
$result=$model->getExaminationAnswerFill($exam_path_id,$student_id);
      break;
  }
return $result;
}
}







 ?>
