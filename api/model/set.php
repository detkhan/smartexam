<?php
require_once("model/database.php");
class sets
{

public function getSet($exam_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT *   FROM `set` WHERE exam_id = '$exam_id'";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
         'set_id' => '0',
         'status' => "false",
       ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $response[] =
         [
           'set_id' => $value['set_id'],
           'status' => "success",
         ];
       }
     }
       return $response;


}

}
?>
