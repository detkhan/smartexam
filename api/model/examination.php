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
    $asc="ASC";
      break;
      case 'next':
    $calculate=">";
    $asc="ASC";
        break;
        case 'pre':
  $calculate="<";
  $asc="DESC";
          break;
  }
  if ($examination_id==0) {
  $examination_id_sql="";
  }else
  {
  $examination_id_sql=" AND examination_id $calculate '$examination_id'";
  }

  $time_stamp=strtotime("now");
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT *   FROM exams a INNER JOIN `set` b ON a.exam_id=b.exam_id INNER JOIN exam_path c ON b.set_id=c.set_id  INNER JOIN examination d ON c.exam_path_id=d.exam_path_id WHERE c.set_id='$set_id'  $examination_id_sql     ORDER BY d.exam_path_id,examination_id $asc LIMIT 0,1";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
         'exam_id' => '0',
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
  (SELECT a.exam_id,b.set_id,examination_id,d.exam_path_id FROM exams a INNER JOIN `set` b ON a.exam_id=b.exam_id INNER JOIN exam_path c ON b.set_id=c.set_id INNER JOIN examination d ON c.exam_path_id=d.exam_path_id WHERE c.set_id='$set_id' ORDER BY d.exam_path_id,examination_id ASC) as dataraw
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


public function getNumberExamPath($exam_path_id)
{
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT *  FROM (
  SELECT @r:=@r+1 'row' ,dataraw.* FROM
  (SELECT * FROM  exam_path   ORDER BY exam_path_id ASC) as dataraw
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
  SELECT count(*) as examination_count   FROM exams a INNER JOIN `set` b ON a.exam_id=b.exam_id INNER JOIN exam_path c ON b.set_id=c.set_id  INNER JOIN examination d ON c.exam_path_id=d.exam_path_id WHERE c.set_id='$set_id'      ORDER BY d.exam_path_id,examination_id ASC";
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

}
?>
