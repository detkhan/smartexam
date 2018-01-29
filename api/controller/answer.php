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

public function countAnswerPath($param)
{
$model=new answers();
$response=$model->countAnswerPath($param);
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

public function getAnswerPair($param)
{
$model=new answers();
$response=$model->getAnswerPair($param);
return $response;
}

public function getAnswerFillSelect($param)
{
$model=new answers();
$response=$model->getAnswerFillSelect($param);
return $response;
}

public function getAnswerFillFill($param)
{
$model=new answers();
$response=$model->getAnswerFillFill($param);
return $response;
}

public function checkAnswerFillSelect($param)
{
$model=new answers();
$response=$model->checkAnswerFillSelect($param);
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


public function addAnswerPath($param)
{
$model=new answers();
$response=$model->addAnswerPath($param);
$data= json_encode($response);
echo $data;
}

public function addAnswerPathFill($param)
{
$model=new answers();
$response=$model->addAnswerPathFill($param);
$data= json_encode($response);
echo $data;
}

public function addAnswerPathFillFill($param)
{
$model=new answers();
$response=$model->addAnswerPathFillFill($param);
$data= json_encode($response);
echo $data;
}



}

 ?>
