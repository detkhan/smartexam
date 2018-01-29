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
public function getchoiceFill($examination_id)
{
$model=new choices();
$response=$model->getchoiceFill($examination_id);
return $response;
}

public function getscore($exam_path_id)
{
  $model=new choices();
  $response=$model->getscore($exam_path_id);
  return $response;
}

public function getscoreFill($exam_path_id)
{
  $model=new choices();
  $response=$model->getscoreFill($exam_path_id);
  return $response;
}

}

 ?>
