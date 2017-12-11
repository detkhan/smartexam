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
  SELECT *   FROM `user` WHERE CONCAT(firstname,'.',lastname) = '$name_surname' AND student_code ='$student_code'";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
         'user_id' => '0',
         'fristname' => '0',
         'lastname' => '0',
         'status' => "false",
       ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $response[] =
         [
           'user_id' => $value['user_id'],
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
