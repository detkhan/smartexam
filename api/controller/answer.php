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

public function countAnswerFill($param)
{
$model=new answers();
$response=$model->countAnswerFill($param);
return $response;
}

public function getAnswer($param)
{
$model=new answers();
$response=$model->getAnswer($param);
return $response;
}

public function getAnswerFill($param)
{
$model=new answers();
$response=$model->getAnswerFill($param);
return $response;
}


public function addAnswer($param)
{
$model=new answers();
$response=$model->addAnswer($param);
$data= json_encode($response);
echo $data;
}


public function addAnswerFill($param)
{
$model=new answers();
$response=$model->addAnswerFill($param);
$data= json_encode($response);
echo $data;
}

}

 ?>
