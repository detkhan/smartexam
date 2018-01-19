<?php
require_once("model/database.php");
class examinations
{

public function getexamination($param)
{
$set_id=$param['set_id'];
$examination_id=$param['examination_id'];

  switch ($param['pre_next']) {
    case 'normal':
    $calculate="=";
    $asc="ASC  LIMIT 0,1";
    $path="";
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
  }
if ($param['pre_next']==path) {
  $examination_id_sql="$path";
}else {
  $examination_id_sql=" examination_id $calculate '$examination_id' $path";
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
         $response=$value['story_detail'];
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
         $response=$value['examination_img_name'];
       }
     }
       return $response;


}//function getImage

//SELECT *,MAX(score)  FROM choice GROUP BY examination_id
}
?>
