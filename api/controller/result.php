<?php
/**
 *
 */
require_once("model/result.php");
class result
{
public function getStudentSet($param)
{
  $model=new Results();
  $response=$model->getStudentSet($param);
  $data= json_encode($response);
  echo $data;
}



}


 ?>
