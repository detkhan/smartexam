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
  $set_id=$response[0]['set_id'];
  $student_id=$response[0]['student_id'];
  $get_exam_path=$examinations->getExamPath($set_id);
  $exam_path_id=$get_exam_path[0]['exam_path_id'];
  $examination_type_id=$get_exam_path[0]['examination_type_id'];
  $examination_type_format_id=$get_exam_path[0]['examination_type_format_id'];
  $get_examination=$examinations->getExaminationAnswer($exam_path_id,$examination_type_id,$examination_type_format_id,$student_id);
  //$data= json_encode($response);
  //echo $data;
}



}


 ?>
