<?php
/**
 *
 */
require_once("choice.php");
require_once("answer.php");
require_once("model/examination.php");
class examination
{

public function getexamination($param)
{
$model=new examinations();
$response=$model->getexamination($param);
$examination_id=$response[0]['examination_id'];
$exam_path_id=$response[0]['exam_path_id'];
$param['examination_id']=$examination_id;
$set_id=$param['set_id'];
$response['row']=$model->getNumberExamination($set_id,$examination_id);
$response['row_exam_path']=$model->getNumberExamPath($exam_path_id);
$response['examination_count']=$model->getCountExamination($param);
$ojb_choice=new choice();
$response['choice']=$ojb_choice->getchoice($examination_id);
$ojb_answer=new answer();
$response['countanswer']=$ojb_answer->countAnswer($param);
$response['getanswer']=$ojb_answer->getAnswer($param);
$data= json_encode($response);
echo $data;
}

}

 ?>