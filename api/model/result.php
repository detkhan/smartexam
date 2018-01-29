<?php
require_once("model/database.php");
class results
{

public function getStudentSet($param)
{
  $exam_id=$param['exam_id'];
  $sec_id=$param['sec_id'];
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT
a.exam_id,
a.sec_id,
b.student_id,
c.set_id
FROM
`register_exam` a
INNER JOIN
`register_sec` b
ON a.sec_id=b.sec_id
INNER JOIN
(
SELECT
aa.student_id,
aa.set_id
FROM
`register_set` aa
INNER JOIN
`set` bb
ON aa.set_id=bb.set_id
WHERE  bb.exam_id='$exam_id'
) as c
ON c.student_id=b.student_id
WHERE a.sec_id='$sec_id' AND a.exam_id='$exam_id'
  ";

     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
         'exam_id' => '0',
         'sec_id' => '0',
         'student_id' => '0',
         'set_id' => '0',
         'status' => "false",
       ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $response[] =
         [
           'exam_id' => $value['exam_id'],
           'sec_id' => $value['sec_id'],
           'student_id' => $value['student_id'],
           'set_id' => $value['set_id'],
           'status' => "success",
         ];
       }
     }
       return $response;


}

}
?>
