<?php
/**
 *
 */
require_once("model/choice.php");
class choice
{

public function getchoice($examination_id)
{
$model=new choices();
$response=$model->getchoice($examination_id);
return $response;
}

public function getchoicePair($exam_path_id)
{
  $model=new choices();
  $response=$model->getchoicePair($exam_path_id);
  return $response;
}

}

 ?>
