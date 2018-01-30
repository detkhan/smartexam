<?php
require_once("model/database.php");
class examinations
{

public function getexamination($param)
{
$set_id=$param['set_id'];
$examination_id=$param['examination_id'];
$row=$param['row'];
$field="row";
  switch ($param['pre_next']) {
    case 'normal':
    $calculate="=";
    $asc="ASC  LIMIT 0,1";
    $path="";
    //$field="examination_id";
      break;
      case 'next':
    $calculate=">";
    $asc="ASC  LIMIT 0,1";
    $path="";
        break;
        case 'pre':
  $calculate="<";
  $asc="DESC  LIMIT 0,1";
  $path="";
          break;
          case 'path':
    $exam_path_id=$param['exam_path_id'];
    $calculate=">=";
    $asc="ASC";
    $path="exam_path_id='$exam_path_id'";
            break;
  }
  if ($examination_id==0) {
$calculate=">";
$field="examination_id";
  }
if ($param['pre_next']==path) {
  $examination_id_sql="$path";
}else {
  $examination_id_sql=" $field $calculate '$row' $path";
}



  $time_stamp=strtotime("now");
  $clsMyDB = new MyDatabase();
  /*
  $strCondition2 = "
  SELECT *   FROM exams a INNER JOIN `set` b ON a.exam_id=b.exam_id INNER JOIN exam_path c ON b.set_id=c.set_id  INNER JOIN examination d ON c.exam_path_id=d.exam_path_id WHERE c.set_id='$set_id'  $examination_id_sql     ORDER BY d.exam_path_id,examination_id $asc LIMIT 0,1";
*/
  $strCondition2 = "SELECT *  FROM (
    SELECT @r:=@r+1 'row' ,
  	dataraw.* FROM
    (SELECT a.exam_id,c.set_id,c.exam_path_id,exam_path_name,examination_type_id,examination_type_sub_id,examination_type_format_id,examination_id,examination_title FROM
     exams a INNER JOIN `set` b
     ON a.exam_id=b.exam_id
      INNER JOIN exam_path c
      ON b.set_id=c.set_id
      INNER JOIN examination d
      ON c.exam_path_id=d.exam_path_id
       WHERE c.set_id='$set_id' AND a.status='1'  AND b.status='1' AND c.status='1' AND d.status='1'   ORDER BY d.exam_path_id,examination_id ASC) as dataraw
  	  ,(SELECT@r:=0)as a
    )
    as dataexamination
    WHERE    $examination_id_sql ORDER BY row $asc";

     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
         'exam_id' => '0',
         'row' => '0',
         'examination_id' => '0',
         'exam_path_id'=>'0',
         'examination_title' => '0',
         'examination_type_id' => '0',
         'examination_type_format' => '0',
         'examination_type_sub_id' => '0',
         'set_id' => '0',
         'exam_path_name' => '0',
         'status' => "false",
       ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $response[] =
         [
           'exam_id' => $value['exam_id'],
           'row' => $value['row'],
           'examination_id'=> $value['examination_id'],
           'exam_path_id'=> $value['exam_path_id'],
           'examination_title' => $value['examination_title'],
           'examination_type_id' => $value['examination_type_id'],
           'examination_type_format_id' => $value['examination_type_format_id'],
           'examination_type_sub_id' => $value['examination_type_sub_id'],
           'set_id' => $value['set_id'],
           'exam_path_name' => $value['exam_path_name'],
           'status' => "success",
         ];
       }
     }
       return $response;


}//function getexamination

public function getNumberExamination($set_id,$examination_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT *  FROM (
  SELECT @r:=@r+1 'row' ,dataraw.* FROM
  (SELECT a.exam_id,b.set_id,examination_id,d.exam_path_id FROM exams a INNER JOIN `set` b ON a.exam_id=b.exam_id INNER JOIN exam_path c ON b.set_id=c.set_id INNER JOIN examination d ON c.exam_path_id=d.exam_path_id WHERE c.set_id='$set_id' AND a.status='1'  AND b.status='1' AND c.status='1' AND d.status='1' ORDER BY d.exam_path_id,examination_id ASC) as dataraw
  ,(SELECT@r:=0)as a
  )
  as dataexamination
  WHERE    examination_id ='$examination_id'
  ";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2){
      $response= "false";
     }else {
foreach ($objSelect2 as $value) {
$response=$value['row'];
}
     }
     return $response;
}


public function getNumberExamPath($exam_path_id,$set_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT *  FROM (
  SELECT @r:=@r+1 'row' ,dataraw.* FROM
  (SELECT exam_path_id FROM
  exam_path a INNER JOIN `set` b
  ON a.set_id=b.set_id
  WHERE b.set_id='$set_id' AND a.status='1'
  ORDER BY exam_path_id ASC) as dataraw
  ,(SELECT@r:=0)as a
  )
  as dataexam_path
  WHERE exam_path_id='$exam_path_id'
  ";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2){
      $response= "false";
     }else {
foreach ($objSelect2 as $value) {
$response=$value['row'];
}
     }
     return $response;
}



public function getCountExamination($param)
{
  $set_id=$param['set_id'];
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT count(*) as examination_count   FROM exams a INNER JOIN `set` b ON a.exam_id=b.exam_id INNER JOIN exam_path c ON b.set_id=c.set_id  INNER JOIN examination d ON c.exam_path_id=d.exam_path_id WHERE c.set_id='$set_id' AND d.status='1'      ORDER BY d.exam_path_id,examination_id ASC";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
         $response="false";
     }
     else{
       foreach ($objSelect2 as $value) {
         $response=$value['examination_count'];
       }
}
return $response;
}//getCountExamination

public function getLayout($param){
$set_id=$param['set_id'];
$student_id=$param['student_id'];
$clsMyDB = new MyDatabase();
$strCondition2 = "SELECT *  FROM (
  SELECT @r:=@r+1 'row' ,
  dataraw.* FROM
  (SELECT a.exam_id,c.set_id,c.exam_path_id,exam_path_name,examination_type_id,examination_type_sub_id,examination_type_format_id,examination_id,examination_title FROM
   exams a INNER JOIN `set` b
   ON a.exam_id=b.exam_id
    INNER JOIN exam_path c
    ON b.set_id=c.set_id
    INNER JOIN examination d
    ON c.exam_path_id=d.exam_path_id
     WHERE c.set_id='$set_id' AND d.status='1'    ORDER BY d.exam_path_id,examination_id ASC) as dataraw
    ,(SELECT@r:=0)as a
  )
  as dataexamination
 ORDER BY row ASC";

   $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
   if(!$objSelect2)
   {
     $response[] =
     [
       'exam_id' => '0',
       'row' => '0',
       'examination_id' => '0',
       'exam_path_id'=>'0',
       'examination_title' => '0',
       'examination_type_id' => '0',
       'examination_type_format' => '0',
       'examination_type_sub_id' => '0',
       'set_id' => '0',
       'exam_path_name' => '0',
       'status' => "false",
     ];
   }
   else{
     foreach ($objSelect2 as $value) {
       $examination_type_id=$value['examination_type_id'];
       $examination_id=$value['examination_id'];
       $exam_path_id=$value['exam_path_id'];
       $examination_type_format_id=$value['examination_type_format_id'];
       $ojb_answer=new answer();
       switch ($examination_type_id) {
         case '1':
         $param['examination_id']=$examination_id;
         $getanswer=$ojb_answer->getAnswer($param);
           break;
           case '2':
           $param['examination_id']=$examination_id;
           $param['exam_path_id']=$exam_path_id;
           $getanswer=$ojb_answer->getAnswerPair($param);
             break;
             case '3':
             $param['examination_id']=$examination_id;
             $param['exam_path_id']=$exam_path_id;
             if ($examination_type_format_id==7) {
            $getanswer1=$ojb_answer->getAnswerFillSelect($param);
            $number_fillall=$ojb_answer->checkAnswerFillSelect($param);
            $totalfill=count($getanswer1);
            if ($totalfill==$number_fillall) {
            $getanswer="success";
            }else {
            $getanswer="false";
            }
          }else {
            $getanswer1=$ojb_answer->getAnswerFillFill($param);
            $number_fillall=$ojb_answer->checkAnswerFillSelect($param);
            $totalfill=count($getanswer1);
            if ($totalfill==$number_fillall) {
            $getanswer="success";
            }else {
            $getanswer="false";
            }
          }

               break;
               case '4':
               $param['examination_id']=$examination_id;
               $getanswer=$ojb_answer->getAnswer($param);
                 break;
                 case '5':
                 $param['examination_id']=$examination_id;
                 $getanswer=$ojb_answer->getAnswerFill($param);
                   break;

        }

       $response[] =
       [
         'exam_id' => $value['exam_id'],
         'row' => $value['row'],
         'examination_id'=> $value['examination_id'],
         'exam_path_id'=> $value['exam_path_id'],
         'examination_title' => $value['examination_title'],
         'examination_type_id' => $value['examination_type_id'],
         'examination_type_format_id' => $value['examination_type_format_id'],
         'examination_type_sub_id' => $value['examination_type_sub_id'],
         'set_id' => $value['set_id'],
         'exam_path_name' => $value['exam_path_name'],
         'getanswer' => $getanswer,
         'status' => "success",
       ];
     }
   }

     return $response;
}

public function getCountExaminationPath($exam_path_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT
  COUNT(*) as number_examination
  FROM
  examination a
  LEFT JOIN exam_path b
  ON a.exam_path_id=b.exam_path_id
  WHERE
  b.exam_path_id='$exam_path_id' AND a.status='1'
";
  $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response =0;
     }
     else{
       foreach ($objSelect2 as $value) {
         $response=$value['number_examination'];
       }
     }
       return $response;


}//function getNumberExamination

public function getStory($examination_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT
  story_detail
  FROM
  examination a
  LEFT JOIN examination_story b
  ON a.examination_id=b.examination_id
  WHERE
  b.examination_id='$examination_id'
";
  $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response =0;
     }
     else{
       foreach ($objSelect2 as $value) {
$urlTeacher="http://teacher.smartexam.revoitmarketing.com";
    $content=$value['story_detail'];
    $content_result=$this->addUrl($content,$urlTeacher);
         $response=$content_result;
       }
     }
       return $response;


}//function getStory

public function getImage($examination_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT
  examination_img_name
  FROM
  examination a
  LEFT JOIN examination_img b
  ON a.examination_id=b.examination_id
  WHERE
  b.examination_id='$examination_id'
";
  $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response =0;
     }
     else{
       foreach ($objSelect2 as $value) {
        $urlTeacher="http://teacher.smartexam.revoitmarketing.com";
        $content=$value['examination_img_name'];
        $content_result=$this->addUrl($content,$urlTeacher);
        $response=$content_result;
       }
     }
       return $response;


}//function getImage


function addUrl($content,$urlTeacher){
 $pattern = '/\/upload\/u[0-9]+\/t[0-9]+\/image_[0-9_]+.[a-z]{2,4}/';
 preg_match_all($pattern, $content, $matches);
 $img = $matches[0];
 foreach ($img as $key => $value) {
  $content = str_replace($value,$urlTeacher.$value , $content);
 }
 return $content;
}


public function getScoreFill($exam_path_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT
  SUM(score) as score_total
  FROM
  examination a
  LEFT JOIN exam_path b
  ON a.exam_path_id=b.exam_path_id
  LEFT JOIN examination_fill c
  ON a.examination_id=c.examination_id
  WHERE
  b.exam_path_id='$exam_path_id' AND a.status='1'
  ";
  $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response =0;
     }
     else{
       foreach ($objSelect2 as $value) {
         $response=$value['score_total'];
       }
     }
       return $response;
}


public function getScorePath($exam_path_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT
  SUM(score) as score_total
  FROM
  examination a
LEFT JOIN exam_path b
ON a.exam_path_id=b.exam_path_id
LEFT JOIN exam_path_score c
ON a.examination_id=c.examination_id
  WHERE
  b.exam_path_id='$exam_path_id' AND a.status='1'
  ";
  $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response =0;
     }
     else{
       foreach ($objSelect2 as $value) {
         $response=$value['score_total'];
       }
     }
       return $response;
}

public function countFillSelect($param)
{
  $set_id=$param['set_id'];
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT d.examination_id,c.exam_path_id,c.examination_type_format_id,e.number_fill
  FROM exams a
  INNER JOIN `set` b
  ON a.exam_id=b.exam_id
  INNER JOIN exam_path c
  ON b.set_id=c.set_id
  INNER JOIN examination d
  ON d.exam_path_id=c.exam_path_id
  INNER JOIN examination_number_fill e
  ON e.examination_id=d.examination_id
  WHERE b.set_id='$set_id' AND b.status='1'
  ORDER BY d.examination_id ASC
  ";

     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
         'examination_id'=> 0,
         'exam_path_id'=> 0,
         'number_fill'=> 0,
         'examination_type_format_id'=> 0,
         'status' => "false",
       ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $response[] =
         [
           'examination_id'=> $value['examination_id'],
           'examination_type_format_id'=> $value['examination_type_format_id'],
           'exam_path_id'=> $value['exam_path_id'],
           'number_fill'=> $value['number_fill'],
           'status' => "success",
         ];
       }
     }
       return $response;

}


public function getscoreFillFill($exam_path_id)
{
  $set_id=$param['set_id'];
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT sum(score) as score_total
  FROM exams a
  INNER JOIN `set` b
  ON a.exam_id=b.exam_id
  INNER JOIN exam_path c
  ON b.set_id=c.set_id
  INNER JOIN examination d
  ON d.exam_path_id=c.exam_path_id
  INNER JOIN examination_fill e
  ON e.examination_id=d.examination_id
  WHERE c.exam_path_id='$exam_path_id'
  ORDER BY d.examination_id ASC
  ";

     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
$response=0;
     }
     else{
       foreach ($objSelect2 as $value) {
$response=$value['score_total'];
       }
     }
       return $response;

}


public function getExamPath($set_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT *  FROM (
  SELECT @r:=@r+1 'row' ,dataraw.* FROM
  (SELECT exam_path_id,examination_type_id,examination_type_format_id FROM
  exam_path a INNER JOIN `set` b
  ON a.set_id=b.set_id
  WHERE b.set_id='$set_id' AND a.status='1'
  ORDER BY exam_path_id ASC) as dataraw
  ,(SELECT@r:=0)as a
  )
  as dataexam_path
  ";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2){
       $response[] =
       [
         'row' => '0',
         'exam_path_id'=>'0',
         'examination_type_id' => '0',
         'examination_type_format_id' => '0',
         'status' => "false",
       ];
     }else {
foreach ($objSelect2 as $value) {
  $response[] =
  [
    'row' =>$value['row'],
    'exam_path_id'=>$value['exam_path_id'],
    'examination_type_id' => $value['examination_type_id'],
    'examination_type_format_id' =>$value['examination_type_format_id'],
    'status' => "success",
  ];
}
     }
     return $response;
}


public function getExaminationAnswerChoice($exam_path_id,$student_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT SUM(score) as score  FROM
exam_path a
INNER JOIN
examination b
ON a.exam_path_id=b.exam_path_id
INNER JOIN
choice c
ON b.examination_id=c.examination_id
INNER JOIN
answer d
ON c.choice_id=d.choice_id
WHERE  a.exam_path_id='$exam_path_id' AND student_id='$student_id'   ORDER BY b.examination_id ASC
  ";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2){
       $response ='0';
     }else {
foreach ($objSelect2 as $value) {
  $response=$value['score'];
}
     }
     return $response;
}



public function getExaminationAnswerPair($exam_path_id,$student_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT
SUM((
SELECT
SUM(score)
FROM
exam_path_score
WHERE
exam_path_score.examination_id=dataraw.examination_id
AND
exam_path_score.choice_pair_id=dataraw.choice_pair_id
)) as score
FROM
(
SELECT
c.examination_id,
c.choice_pair_id
FROM
exam_path a
INNER JOIN
examination b
ON a.exam_path_id=b.exam_path_id
INNER JOIN
answer_pair c
ON b.examination_id=c.examination_id
WHERE  a.exam_path_id='$exam_path_id' AND student_id='$student_id'
ORDER BY b.examination_id ASC
) dataraw
  ";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2){
       $response ='0';
     }else {
foreach ($objSelect2 as $value) {
  $response=$value['score'];
}
     }
     return $response;
}


public function getExaminationAnswerFill($exam_path_id,$student_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT
  b.examination_id,
  keyword,
  score
  FROM
  exam_path a
  INNER JOIN
  examination b
  ON a.exam_path_id=b.exam_path_id
  INNER JOIN
  examination_fill c
  ON b.examination_id=c.examination_id
  WHERE  a.exam_path_id='$exam_path_id'
  ORDER BY b.examination_id ASC
  ";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2){
       $response ='0';
     }else {
foreach ($objSelect2 as $value) {
  $answer_number_keyword=0;
  $examination_id=$value['examination_id'];
  $keyword=$value['keyword'];
  $scoreraw=$value['score'];
  $keyword_string=explode(',',$keyword);
  $total_keyword=count($keyword_string);
  for ($i=0; $i < $total_keyword; $i++) {
    $keyword_answer=$keyword_string[$i];
  $answer_number_keyword+=$this->checkKeyword($examination_id,$keyword_answer,$student_id);

  }
  $score+=$this->calculateScore($total_keyword,$scoreraw,$answer_number_keyword);
}
     }
     return $score;
}

public function checkKeyword($examination_id,$keyword_answer,$student_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT
  count(*) as number_fill
  FROM
  answer_fill
  WHERE
  examination_id='$examination_id'
  AND
  student_id='$student_id'
  AND
  detail LIKE '%$keyword_answer%'
  ";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2){
       $response ='0';
     }else {
foreach ($objSelect2 as $value) {
  $response =$value['number_fill'];

}
     }
     return $response;
}

public function calculateScore($total_keyword,$scoreraw,$answer_number_keyword)
{
$score=round(($answer_number_keyword/$total_keyword)*$scoreraw);
return $score;
}


public function getExaminationAnswerFillSelect($exam_path_id,$student_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT
  SUM( score ) AS score
  FROM
  exam_path a
  INNER JOIN
  examination b
  ON a.exam_path_id = b.exam_path_id
  INNER JOIN
  answer_fill_select c
  ON b.examination_id = c.examination_id
  INNER JOIN
  choice_fill d
  ON d.choice_fill_id = c.choice_fill_id
  WHERE  a.exam_path_id='$exam_path_id' AND student_id='$student_id'   ORDER BY b.examination_id ASC
  ";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2){
       $response ='0';
     }else {
foreach ($objSelect2 as $value) {
  $response=$value['score'];
}
     }
     return $response;
}



public function getExaminationAnswerFillFill($exam_path_id,$student_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT
  b.examination_id,
  number_exam,
  keyword,
  score
  FROM
  exam_path a
  INNER JOIN
  examination b
  ON a.exam_path_id=b.exam_path_id
  INNER JOIN
  examination_fill c
  ON b.examination_id=c.examination_id
  WHERE  a.exam_path_id='$exam_path_id'
  ORDER BY b.examination_id ASC
  ";

     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2){
       $response ='0';
     }else {
foreach ($objSelect2 as $value) {
  $answer_number_keyword=0;
  $examination_id=$value['examination_id'];
  $keyword=$value['keyword'];
  $scoreraw=$value['score'];
  $number_exam=$value['number_exam'];
  $keyword_string=explode(',',$keyword);
  $total_keyword=count($keyword_string);
  for ($i=0; $i < $total_keyword; $i++) {
    $keyword_answer=$keyword_string[$i];
  $answer_number_keyword+=$this->checkKeywordFill($examination_id,$number_exam,$keyword_answer,$student_id);

  }
  $score+=$this->calculateScore($total_keyword,$scoreraw,$answer_number_keyword);
}
     }
     return $score;
}

public function checkKeywordFill($examination_id,$number_exam,$keyword_answer,$student_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT
  count(*) as number_fill
  FROM
  answer_fill_fill
  WHERE
  examination_id='$examination_id'
  AND
  number_exam='$number_exam'
  AND
  student_id='$student_id'
  AND
  detail LIKE '%$keyword_answer%'
  ";

     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2){
       $response ='0';
     }else {
foreach ($objSelect2 as $value) {
  $response =$value['number_fill'];

}
     }
     return $response;
}

//SELECT *,MAX(score)  FROM choice GROUP BY examination_id
}
?>
