<?php
/**
 *
 */
require_once("model/section.php");
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

}


 ?>
