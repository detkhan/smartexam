<?php
/**
 *
 */
require_once("model/result.php");
require_once("examination.php");
class result
{
public function getStudentSet($param)
{
  $model=new Results();
  $examinations=new examination();
  $response=$model->getStudentSet($param);
  foreach ($response as $key => $value) {
    $set_id=$value['set_id'];
    $student_id=$value['student_id'];
    $get_exam_path=$examinations->getExamPath($set_id);
    foreach ($get_exam_path as $key2 => $value2) {
      $exam_path_id=$value2['exam_path_id'];
      $examination_type_id=$value2['examination_type_id'];
      $examination_type_format_id=$value2['examination_type_format_id'];
      $get_examination=$examinations->getExaminationAnswer($exam_path_id,$examination_type_id,$examination_type_format_id,$student_id);
      var_dump($exam_path_id);
  var_dump($get_examination);
    }


  }



  //$data= json_encode($response);
  //echo $data;
}



}


 ?>
