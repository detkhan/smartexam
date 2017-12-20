<?php
require_once("model/database.php");
class exams
{

public function listexam($param)
{
  $sec_id=$param[0]['sec_id'];
  if (sizeof($sec_id)>1) {
  $sec_id=implode(',',$sec_id);
  }

  $time_stamp=strtotime("now");
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT *   FROM `exams` a INNER JOIN `register_exam` b ON a.exam_id = b.exam_id WHERE sec_id IN ('$sec_id') AND time_end_stamp >= '$time_stamp'";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
         'exam_id' => '0',
         'register_exam_id' => '0',
         'subject' => '0',
         'short_detail' => '0',
         'detail' => '0',
         'exam_date' => '0',
         'time_start' => '0',
         'time_end' => '0',
         'time_stamp' => '0',
         'status' => "false",
       ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $time_start=strtotime($value['exam_date']." ".$value['time_start'] );
         $time_end=strtotime($value['exam_date']." ".$value['time_end'] );
         $time_total=($time_end-$time_start)/60;
         $response[] =
         [
           'exam_id' => $value['exam_id'],
           'register_exam_id'=> $value['register_exam_id'],
           'subject' => $value['subject'],
           'short_detail' => $value['short_detail'],
           'detail' => $value['detail'],
           'exam_date' => $value['exam_date'],
           'time_start' => $value['time_start'],
           'time_end' => $value['time_end'],
           'time_total' => $time_total,
           'time_stamp' => $value['time_stamp'],
           'status' => "success",
         ];
       }
     }
       return $response;


}//function listexam

public function getRegisterSet($param)
{
  $student_id=$param['student_id'];
  $exam_id=$param['exam_id'];
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT *   FROM `set` a INNER JOIN `register_set` b ON a.set_id = b.set_id  WHERE exam_id='$exam_id' AND student_id='$student_id'";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
         'exam_id' => '0',
         'register_set_id' => '0',
         'set_id' => '0',
         'set_name' => '0',
         'status' => "false",
       ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $response[] =
         [
           'exam_id' => $exam_id,
           'register_set_id' => $value['register_set_id'],
           'set_id' => $value['set_id'],
           'set_name' => $value['set_name'],
           'status' => "success",
         ];
       }
     }
       return $response;
}

public function addRegisterSet($param)
{
  $student_id=$param['student_id'];
  $set_id=$param['set_id'];
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
INSERT INTO  register_set (set_id,student_id)
VALUES ('$set_id','$student_id')
  ";
     $objSelect2 = $clsMyDB->fncInsertRecord($strCondition2);
}


public function getPath($set_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT *   FROM `exam_path` a INNER JOIN `examination_type` b ON a.examination_type_id=b.examination_type_id WHERE set_id='$set_id' ORDER BY exam_path_id ASC ";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
         'exam_path_id' => '0',
         'exam_path_name' => '0',
         'examination_type_name' => '0',
       ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $response[] =
         [
           'exam_path_id' => $value['exam_path_id'],
           'exam_path_name' => $value['exam_path_name'],
           'examination_type_name' => $value['examination_type_name'],
         ];
       }
     }
       return $response;
}

public function getExamTime($param)
{
  $register_exam_id=$param['register_exam_id'];
  $clsMyDB = new MyDatabase();
  $time_stamp=strtotime("now");
  $time_start_stamp=Date("Y-m-d G:i:s");
  $strCondition2 = "
  SELECT *   FROM `register_exam`  WHERE register_exam_id='$register_exam_id' and time_start_stamp <= '$time_stamp'";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
         'time_start_stamp' => '0',
         'time_end_stamp' => '0',
         'status' => "false",
       ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $time_end_stamp=$value['exam_date']." ".$value['time_end'];
         $response[] =
         [
           'time_start_stamp' => $time_start_stamp,
           'time_end_stamp' => $time_end_stamp,
           'status' => "success",
         ];
       }
     }
       return $response;
}
//SELECT *   FROM exams a INNER JOIN `set` b ON a.exam_id=b.exam_id INNER JOIN exam_path c ON b.set_id=c.set_id  INNER JOIN examination d ON c.exam_path_id=d.exam_path_id  ORDER BY d.exam_path_id ASC 
}
?>
