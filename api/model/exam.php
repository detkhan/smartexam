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
  SELECT *   FROM `exams` a INNER JOIN `register_exam` b ON a.exam_id = b.exam_id WHERE sec_id IN ('$sec_id') AND time_stamp >= '$time_stamp'";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
         'exam_id' => '0',
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


}

}
?>
