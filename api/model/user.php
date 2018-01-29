<?php
require_once("model/database.php");
class users
{

public function login($param)
{
  $name_surname=$param['name_surname'];
  $student_code=$param['student_code'];
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT *   FROM `student` WHERE CONCAT(firstname,'.',SUBSTRING(lastname,1,3)) = '$name_surname' AND student_code ='$student_code'";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
         'student_id' => '0',
         'student_code' => '0',
         'fristname' => '0',
         'lastname' => '0',
         'status' => "false",
       ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $response[] =
         [
           'student_id' => $value['student_id'],
           'student_code' => $value['student_code'],
           'firstname' => $value['firstname'],
           'lastname' => $value['lastname'],
           'status' => "success",
         ];
       }
     }
       return $response;


}

}
?>
