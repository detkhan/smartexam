<?php
/**
 *
 */
require_once("model/answer.php");
class answer
{

public function countAnswer($param)
{
$model=new answers();
$response=$model->countAnswer($param);
return $response;
}

public function getAnswer($param)
{
$model=new answers();
$response=$model->getAnswer($param);
return $response;
}

}

 ?>
