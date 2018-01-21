<?php
/**
 *
 */
require_once("model/section.php");
require_once("model/set.php");
require_once("model/exam.php");
class exam
{

public function listexam($param)
{
$model_section=new sections();
$get_section=$model_section->getsection($param);
$model=new exams();
$response=$model->listexam($get_section);
$data= json_encode($response);
echo $data;
}

public function checkRegisterSet($param)
{
  $exam_id=$param['exam_id'];
  $model=new exams();
  $response1=$this->getRegisterSet($param);
if ($response1[0]['status']=="false") {
$set=$this->getSet($exam_id);
$totalset=count($set)-1;
$random_keys=rand(0,$totalset);
$set_id=$set[$random_keys]['set_id'];
$param['set_id']=$set_id;
$addset=$this->addRegisterSet($param);
$response=$this->getRegisterSet($param);
}else {
$response=$response1;
}
//var_dump($response[0]['set_id']);


$responsePath=$model->getPath($response[0]['set_id']);
$responsePathNumber=$model->getPathNumber($response[0]['set_id']);
$response[0]['path']=$responsePath;
$response[0]['pathnumber']=$responsePathNumber;
  $data= json_encode($response);
  echo $data;
}

public function getRegisterSet($param)
{
  $model=new exams();
  $response=$model->getRegisterSet($param);
  return $response;
}

public function getSet($exam_id)
{
  $model=new sets();
  $response=$model->getSet($exam_id);
  return $response;
}


public function addRegisterSet($param)
{
  $model=new exams();
  $response=$model->addRegisterSet($param);
}


public function getExamTime($param)
{
  $model=new exams();
$check_sent_exam=$model->getSent_exam($param);
if ($check_sent_exam[0]['status']=="no") {
  $response=$model->getExamTime($param);
}else {
$response[0]['status']="sent";
}

  $data= json_encode($response);
  echo $data;
}

public function addSentExam($param)
{
  $model=new exams();
  $response=$model->addSentExam($param);
}//  addSent_exam
}

 ?>
