<?php
require_once("model/database.php");
require_once("model/examination.php");
class exams
{

public function listexam($param)
{
  foreach ($param as $key => $value) {
  $sec_id[]=$value['sec_id'];
  }
  if (sizeof($sec_id)>1) {
  $sec_id=implode(',',$sec_id);
}else {
$sec_id=$value['sec_id'];
}
  $time_stamp=strtotime("now")+(3600*7);
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT *   FROM `exams` a INNER JOIN `register_exam` b ON a.exam_id = b.exam_id WHERE sec_id IN ($sec_id) AND time_end_stamp >= '$time_stamp' AND b.status='1' AND a.status='1'";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     //var_dump($strCondition2);
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
         'status' => "false",
       ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $time_start=strtotime($value['exam_date']." ".$value['time_start'] );
         $time_end=strtotime($value['exam_date']." ".$value['time_end'] );
         $time_total=($time_end-$time_start)/60;
         $exam_id=$value['exam_id'];
         $countset=$this->countSet($exam_id);
         $countexamination=$this->countExamination($exam_id);
         //$ojb_examination=new Examination;
         //$param['set_id']=
         //$set_id=$param['set_id']
        // $number_exam=$ojb_examination.getCountExamination($param);
         $response[] =
         [
           'exam_id' => $value['exam_id'],
           'register_exam_id'=> $value['register_exam_id'],
           'subject' => $value['subject'],
           'short_detail' => $value['short_detail'],
           'detail' => $value['detail'],
           'exam_date' => $value['exam_date'],
           'countset' => $countset,
           'countexamination' => $countexamination,
           'time_start' => $value['time_start'],
           'time_end' => $value['time_end'],
           'time_total' => $time_total,
           'status' => "success",
         ];
       }
     }
       return $response;


}//function listexam

public function countSet($exam_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT  count(*) as countset   FROM `set` WHERE exam_id= '$exam_id' and status='1'";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response=0;
     }
     else{
       foreach ($objSelect2 as $value) {
         $response=$value['countset'];

       }
     }

       return $response;

}

public function getRegisterSet($param)
{
  $student_id=$param['student_id'];
  $exam_id=$param['exam_id'];
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT *   FROM `set` a INNER JOIN `register_set` b ON a.set_id = b.set_id  WHERE exam_id='$exam_id' AND student_id='$student_id' AND a.status='1'";
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
  SELECT
  a.exam_path_id,
  a.exam_path_name,
  b.examination_type_name,
  COUNT(examination_id) as total
  FROM `exam_path` a
  INNER JOIN `examination_type` b
  ON a.examination_type_id=b.examination_type_id
  INNER JOIN `examination` c
  ON a.exam_path_id=c.exam_path_id
  WHERE set_id='$set_id' and a.status='1'
  GROUP BY a.exam_path_id   ORDER BY a.exam_path_id  ASC
";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
         'exam_path_id' => '0',
         'exam_path_name' => '0',
         'examination_type_name' => '0',
         'total' => '0',
         'sum_total' => '0',
       ];
     }
     else{
       $sum_total=0;
       foreach ($objSelect2 as $value) {
         $sum_total+=$value['total'];
         $response[] =
         [
           'exam_path_id' => $value['exam_path_id'],
           'exam_path_name' => $value['exam_path_name'],
           'examination_type_name' => $value['examination_type_name'],
           'total' => $value['total'],
         ];
       }
       //$response['sum_total']=$sum_total;
     }
       return $response;
}

public function getPathNumber($set_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT
  a.exam_path_id,
  a.exam_path_name,
  b.examination_type_name,
  COUNT(examination_id) as total
  FROM `exam_path` a
  INNER JOIN `examination_type` b
  ON a.examination_type_id=b.examination_type_id
  INNER JOIN `examination` c
  ON a.exam_path_id=c.exam_path_id
  WHERE set_id='$set_id' and a.status='1'
  GROUP BY a.exam_path_id   ORDER BY a.exam_path_id  ASC
";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
$response=0;
     }
     else{
       $response=0;
       foreach ($objSelect2 as $value) {
         $response+=$value['total'];
       }
       //$response['sum_total']=$sum_total;
     }
       return $response;
}

public function getExamTime($param)
{
  $register_exam_id=$param['register_exam_id'];
  $clsMyDB = new MyDatabase();
  $time_stamp=strtotime("now")+(3600*7);
  $time_start_stamp=Date("Y-m-d G:i:s",$time_stamp);
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

public function getSent_exam($param)
{
  $exam_id=$param['exam_id'];
  $student_id=$param['student_id'];
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT *   FROM `sent_exam`  WHERE exam_id='$exam_id' and student_id = '$student_id'";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
         'status' => "no",
       ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $response[] =
         [
           'status' => "yes",
         ];
       }
     }
       return $response;
}

public function addSentExam($param)
{
  $exam_id=$param['exam_id'];
  $student_id=$param['student_id'];
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
INSERT INTO  sent_exam (exam_id,student_id)
VALUES ('$exam_id','$student_id')
  ";
     $objSelect2 = $clsMyDB->fncInsertRecord($strCondition2);
}

public function countExamination($exam_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT count(*) as examination_count,b.set_id
  FROM exams a
  INNER JOIN `set` b
  ON a.exam_id=b.exam_id
  INNER JOIN exam_path c
  ON b.set_id=c.set_id
  INNER JOIN examination d
  ON c.exam_path_id=d.exam_path_id
  WHERE a.exam_id='$exam_id' and d.status='1'    GROUP BY b.set_id ORDER BY b.set_id,examination_id ASC LIMIT 0,1
  ";
       $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
       if(!$objSelect2)
       {
  $response=0;
       }
       else{
         foreach ($objSelect2 as $value) {
           $response=$value['examination_count'];
         }
       }
         return $response;
}

//SELECT *   FROM exams a INNER JOIN `set` b ON a.exam_id=b.exam_id INNER JOIN exam_path c ON b.set_id=c.set_id  INNER JOIN examination d ON c.exam_path_id=d.exam_path_id WHERE examination_id<'1'  ORDER BY d.exam_path_id,examination_id ASC LIMIT 0,1

}
?>
