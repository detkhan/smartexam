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
$result=$this->checkPath($param);
$examination_type_id=$result[0]['examination_type_id'];
$exam_path_id=$result[0]['exam_path_id'];
if ($examination_type_id !=2) {
  $response=$model->getexamination($param);
  $examination_id=$response[0]['examination_id'];
  $exam_path_id=$response[0]['exam_path_id'];
  $examination_type_id=$response[0]['examination_type_id'];
  $param['examination_id']=$examination_id;
  $set_id=$param['set_id'];
  //$response['row']=$model->getNumberExamination($set_id,$examination_id);
  $response['row_exam_path']=$model->getNumberExamPath($exam_path_id);
  $response['examination_count']=$model->getCountExamination($param);
  $ojb_answer=new answer();
  $countanswer=$ojb_answer->countAnswer($param);
  $countanswer_fill=$ojb_answer->countAnswerFill($param);
  $countanswer_path=$ojb_answer->countAnswerPath($param);
  $response['countanswer']=$countanswer+$countanswer_fill+$countanswer_path;
}
switch ($examination_type_id) {
  case '1':
  $ojb_choice=new choice();
  $response['choice']=$ojb_choice->getchoice($examination_id);
  $response['score']=$ojb_choice->getscore($exam_path_id);
  $response['number_examination']=$model->getCountExaminationPath($exam_path_id);
  $response['getanswer']=$ojb_answer->getAnswer($param);
  $response['story']=$model->getStory($examination_id);
  $response['image']=$model->getImage($examination_id);
    break;
    case '2':
$param['pre_next']="path";
$param['exam_path_id']=$exam_path_id;
$param['examination_id']=0;
$response=$model->getexamination($param);
$number_row=count($response);
$response['row_frist']=$response[0]['row'];
$response['row_last']=$response[($number_row-1)]['row'];
$ojb_choice=new choice();
$response['choice']=$ojb_choice->getchoicePair($exam_path_id);
$ojb_answer=new answer();
$response['getanswer']=$ojb_answer->getAnswerPair($param);
$response['row_exam_path']=$model->getNumberExamPath($exam_path_id);
$response['examination_count']=$model->getCountExamination($param);
$countanswer=$ojb_answer->countAnswer($param);
$countanswer_fill=$ojb_answer->countAnswerFill($param);
$countanswer_path=$ojb_answer->countAnswerPath($param);
$response['countanswer']=$countanswer+$countanswer_fill+$countanswer_path;

      break;
      case '3':
        # code...
        break;
        case '4':
        $ojb_choice=new choice();
        $response['choice']=$ojb_choice->getchoice($examination_id);
        $response['score']=$ojb_choice->getscore($exam_path_id);
        $response['number_examination']=$model->getCountExaminationPath($exam_path_id);
        $response['getanswer']=$ojb_answer->getAnswer($param);
          break;
          case '5':
  $response['getanswer_fill']=$ojb_answer->getAnswerFill($param);
            break;
}

$data= json_encode($response);
echo $data;
}

public function checkPath($param)
{
  $model=new examinations();
  $response=$model->getexamination($param);
  return $response;
}

public function getLayout($param)
{
  $model=new examinations();
  $response=$model->getLayout($param);
  $data= json_encode($response);
  echo $data;
}

}


 ?>
