<?php
require_once("model/database.php");
class choices
{

public function getchoice($examination_id)
{

  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT  a.choice_id as choice_id,examination_id,choice_detail,choice_img_name   FROM choice a  LEFT JOIN choice_img b ON a.choice_id=b.choice_id   WHERE examination_id='$examination_id'  ORDER BY a.choice_id ASC";
  $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);

     if(!$objSelect2)
     {
       $response[] =
       [
         'choice_id' => '0',
         'examination_id' => '0',
         'choice_detail' => '0',
         'choice_img_name' => '0',
         'status' => "false",
       ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $response[] =
         [
           'choice_id' => $value['choice_id'],
           'examination_id'=> $value['examination_id'],
           'choice_detail' => $value['choice_detail'],
           'choice_img_name' => $value['choice_img_name'],
           'status' => "success",
         ];
       }
     }
       return $response;


}//function getchoice

}
?>
