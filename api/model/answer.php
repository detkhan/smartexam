<?php
require_once("model/database.php");
class answers
{

public function countAnswer($param)
{
$set_id=$param['set_id'];
$student_id=$param['student_id'];

  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT count(*) as countanswer
  FROM exams a
  INNER JOIN `set` b
  ON a.exam_id=b.exam_id
  INNER JOIN exam_path c
  ON b.set_id=c.set_id
  INNER JOIN examination d
  ON c.exam_path_id=d.exam_path_id
  INNER JOIN choice e
  ON d.examination_id=e.examination_id
  INNER JOIN answer f
  ON e.choice_id=f.choice_id
  WHERE c.set_id='$set_id' AND student_id='$student_id'
  ORDER BY d.exam_path_id,d.examination_id ASC
";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response=0;
     }
     else{
       foreach ($objSelect2 as $value) {
         $response=$value['countanswer'];
       }
     }
       return $response;


}//function countAnswer

public function getAnswer($param)
{
$set_id=$param['set_id'];
$student_id=$param['student_id'];
$examination_id=$param['examination_id'];
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT f.choice_id
  FROM exams a
  INNER JOIN `set` b
  ON a.exam_id=b.exam_id
  INNER JOIN exam_path c
  ON b.set_id=c.set_id
  INNER JOIN examination d
  ON c.exam_path_id=d.exam_path_id
  INNER JOIN choice e
  ON d.examination_id=e.examination_id
  INNER JOIN answer f
  ON e.choice_id=f.choice_id
  WHERE c.set_id='$set_id' AND student_id='$student_id'
  AND e.examination_id='$examination_id'
  ORDER BY d.exam_path_id,d.examination_id ASC
";

     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response=0;
     }
     else{
       foreach ($objSelect2 as $value) {
         $response=$value['choice_id'];
       }
     }
       return $response;


}//function getAnswer


}
?>
