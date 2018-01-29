<?php
require_once("model/database.php");
class answers
{

public function countAnswer($param)
{
$set_id=$param['set_id'];
$student_id=$param['student_id'];

  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT count(*) as countanswer
  FROM exams a
  INNER JOIN `set` b
  ON a.exam_id=b.exam_id
  INNER JOIN exam_path c
  ON b.set_id=c.set_id
  INNER JOIN examination d
  ON c.exam_path_id=d.exam_path_id
  INNER JOIN choice e
  ON d.examination_id=e.examination_id
  INNER JOIN answer f
  ON e.choice_id=f.choice_id
  WHERE c.set_id='$set_id' AND student_id='$student_id'
  ORDER BY d.exam_path_id,d.examination_id ASC
";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response=0;
     }
     else{
       foreach ($objSelect2 as $value) {
         $response=$value['countanswer'];
       }
     }
       return $response;


}//function countAnswer


public function countAnswerFill($param)
{
$set_id=$param['set_id'];
$student_id=$param['student_id'];

  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT count(*) as countanswer
  FROM exams a
  INNER JOIN `set` b
  ON a.exam_id=b.exam_id
  INNER JOIN exam_path c
  ON b.set_id=c.set_id
  INNER JOIN examination d
  ON c.exam_path_id=d.exam_path_id
  INNER JOIN answer_fill e
  ON d.examination_id=e.examination_id
  WHERE c.set_id='$set_id' AND student_id='$student_id'
  ORDER BY d.exam_path_id,d.examination_id ASC
";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response=0;
     }
     else{
       foreach ($objSelect2 as $value) {
         $response=$value['countanswer'];
       }
     }
       return $response;


}//function countAnswerFill


public function countAnswerPath($param)
{
$set_id=$param['set_id'];
$student_id=$param['student_id'];

  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT COUNT(*) as countanswer
    FROM exams a
    INNER JOIN `set` b
    ON a.exam_id=b.exam_id
    INNER JOIN exam_path c
    ON b.set_id=c.set_id
    INNER JOIN choice_pair d
    ON c.exam_path_id=d.exam_path_id
    INNER JOIN answer_pair e
    ON e.choice_pair_id=d.choice_pair_id
    WHERE c.set_id='$set_id' AND student_id='$student_id'
    ORDER BY e.examination_id ASC
";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response=0;
     }
     else{
       foreach ($objSelect2 as $value) {
         $response=$value['countanswer'];
       }
     }
       return $response;


}//function countAnswerPath

public function getAnswer($param)
{
$set_id=$param['set_id'];
$student_id=$param['student_id'];
$examination_id=$param['examination_id'];
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT f.choice_id
  FROM exams a
  INNER JOIN `set` b
  ON a.exam_id=b.exam_id
  INNER JOIN exam_path c
  ON b.set_id=c.set_id
  INNER JOIN examination d
  ON c.exam_path_id=d.exam_path_id
  INNER JOIN choice e
  ON d.examination_id=e.examination_id
  INNER JOIN answer f
  ON e.choice_id=f.choice_id
  WHERE c.set_id='$set_id' AND student_id='$student_id'
  AND e.examination_id='$examination_id'
  ORDER BY d.exam_path_id,d.examination_id ASC
";


     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response=0;
     }
     else{
       foreach ($objSelect2 as $value) {
         $response=$value['choice_id'];
       }
     }
       return $response;


}//function getAnswer

public function getAnswerPair($param)
{
$set_id=$param['set_id'];
$student_id=$param['student_id'];
$exam_path_id=$param['exam_path_id'];
if ($param['examination_id']>0) {
  $examination_id=$param['examination_id'];
$sql="AND e.examination_id='$examination_id'";
}else {
  $sql="";
}
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT e.examination_id,e.choice_pair_id
  FROM exams a
  INNER JOIN `set` b
  ON a.exam_id=b.exam_id
  INNER JOIN exam_path c
  ON b.set_id=c.set_id
  INNER JOIN choice_pair d
  ON c.exam_path_id=d.exam_path_id
  INNER JOIN answer_pair e
  ON e.choice_pair_id=d.choice_pair_id
  WHERE c.set_id='$set_id' AND student_id='$student_id'
  AND c.exam_path_id='$exam_path_id'
  $sql
  ORDER BY e.examination_id ASC
";

     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
       '0' => 0,
       'status' => "false",
     ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $response[] =
         [
         'examination_id' => $value['examination_id'],
         'choice_pair_id' => $value['choice_pair_id'],
         'status' => "success",
       ];
       }
     }
       return $response;


}//function getAnswer

public function getAnswerFillSelect($param)
{
$set_id=$param['set_id'];
$student_id=$param['student_id'];
$exam_path_id=$param['exam_path_id'];
if ($param['examination_id']>0) {
  $examination_id=$param['examination_id'];
$sql="AND c.exam_path_id='$exam_path_id' AND e.examination_id='$examination_id'";
}else {
  $sql="";
}
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT e.examination_id,e.choice_fill_id,number_exam
  FROM exams a
  INNER JOIN `set` b
  ON a.exam_id=b.exam_id
  INNER JOIN exam_path c
  ON b.set_id=c.set_id
  INNER JOIN examination d
  ON d.exam_path_id=c.exam_path_id
  INNER JOIN choice_fill e
  ON e.examination_id=d.examination_id
  INNER JOIN answer_fill_select f
  ON f.choice_fill_id=e.choice_fill_id
  WHERE c.set_id='$set_id' AND student_id='$student_id'
  $sql
  ORDER BY e.examination_id ASC
";
//var_dump($strCondition2);
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
       '0' => 0,
       'status' => "false",
     ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $response[] =
         [
         'examination_id' => $value['examination_id'],
         'choice_fill_id' => $value['choice_fill_id'],
         'number_exam' => $value['number_exam'],
         'status' => "success",
       ];
       }
     }
       return $response;


}//function getAnswer


public function getAnswerFillFill($param)
{
$set_id=$param['set_id'];
$student_id=$param['student_id'];
$exam_path_id=$param['exam_path_id'];
if ($param['examination_id']>0) {
  $examination_id=$param['examination_id'];
$sql="AND c.exam_path_id='$exam_path_id' AND e.examination_id='$examination_id'";
}else {
  $sql="";
}
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT e.examination_id,e.detail,number_exam
  FROM exams a
  INNER JOIN `set` b
  ON a.exam_id=b.exam_id
  INNER JOIN exam_path c
  ON b.set_id=c.set_id
  INNER JOIN examination d
  ON d.exam_path_id=c.exam_path_id
  INNER JOIN answer_fill_fill e
  ON e.examination_id=d.examination_id
  WHERE c.set_id='$set_id' AND student_id='$student_id'
  $sql
  ORDER BY e.number_exam ASC
";
//var_dump($strCondition2);
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response[] =
       [
       '0' => 0,
       'status' => "false",
     ];
     }
     else{
       foreach ($objSelect2 as $value) {
         $response[] =
         [
         'examination_id' => $value['examination_id'],
         'detail' => $value['detail'],
         'number_exam' => $value['number_exam'],
         'status' => "success",
       ];
       }
     }
       return $response;


}//function getAnswer

public function checkAnswerFillSelect($param)
{
  $examination_id=$param['examination_id'];
  $set_id=$param['set_id'];
  if ($param['examination_id']>0) {
    $examination_id=$param['examination_id'];
  $sql="AND e.examination_id='$examination_id'";
  }else {
    $sql="";
  }
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT sum(e.number_fill) as number_fill
  FROM exams a
  INNER JOIN `set` b
  ON a.exam_id=b.exam_id
  INNER JOIN exam_path c
  ON b.set_id=c.set_id
  INNER JOIN examination d
  ON d.exam_path_id=c.exam_path_id
  INNER JOIN examination_number_fill e
  ON e.examination_id=d.examination_id
  $sql
  ORDER BY e.examination_id ASC
  ";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response=0;
     }
     else{
       foreach ($objSelect2 as $value) {
         $response=$value['number_fill'];
       }
     }
       return $response;

}


public function getAnswerFill($param)
{
$set_id=$param['set_id'];
$student_id=$param['student_id'];
$examination_id=$param['examination_id'];
  $clsMyDB = new MyDatabase();
  $strCondition2 = "
  SELECT e.detail
  FROM exams a
  INNER JOIN `set` b
  ON a.exam_id=b.exam_id
  INNER JOIN exam_path c
  ON b.set_id=c.set_id
  INNER JOIN examination d
  ON c.exam_path_id=d.exam_path_id
  INNER JOIN answer_fill e
  ON d.examination_id=e.examination_id
  WHERE c.set_id='$set_id' AND student_id='$student_id'
  AND e.examination_id='$examination_id'
  ORDER BY d.exam_path_id,d.examination_id ASC
";
     $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
     if(!$objSelect2)
     {
       $response=0;
     }
     else{
       foreach ($objSelect2 as $value) {
         $response=$value['detail'];
       }
     }
       return $response;


}//function getAnswer


public function addAnswer($param)
{
$choice_id=$param['choice_id'];
$student_id=$param['student_id'];
$created_at=date("Y-m-d G:i:s");
$updated_at=date("Y-m-d G:i:s");
$checkdata=$this->checkAnswer($param);
  $clsMyDB = new MyDatabase();
  if ($checkdata==0) {
    $strinsert ="INSERT INTO  answer (student_id,choice_id,created_at,updated_at) VALUES ('$student_id','$choice_id','$created_at','$updated_at')";
    $objInsert = $clsMyDB->fncInsertRecord($strinsert);
    $response[] =
    [
      'status' => "add",
    ];
  }else {
    $strupdate ="UPDATE  answer SET student_id='$student_id',choice_id='$choice_id',updated_at='$updated_at' where  answer_id='$checkdata'";
    $objupdate = $clsMyDB->fncUpdateRecord($strupdate);
    $response[] =
    [
      'status' => "update",
    ];
  }

return $response;
}//function addAnswer



public function checkAnswer($param)
{
  $set_id=$param['set_id'];
  $student_id=$param['student_id'];
  $examination_id=$param['examination_id'];
    $clsMyDB = new MyDatabase();
    $strCondition2 = "
    SELECT f.answer_id
    FROM exams a
    INNER JOIN `set` b
    ON a.exam_id=b.exam_id
    INNER JOIN exam_path c
    ON b.set_id=c.set_id
    INNER JOIN examination d
    ON c.exam_path_id=d.exam_path_id
    INNER JOIN choice e
    ON d.examination_id=e.examination_id
    INNER JOIN answer f
    ON e.choice_id=f.choice_id
    WHERE c.set_id='$set_id' AND student_id='$student_id'
    AND e.examination_id='$examination_id'
    ORDER BY d.exam_path_id,d.examination_id ASC
  ";
       $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
       if(!$objSelect2)
       {
         $response=0;
       }
       else{
         foreach ($objSelect2 as $value) {
           $response=$value['answer_id'];
         }
       }
         return $response;


}//function getAnswer



public function addAnswerFill($param)
{
$choice_id=$param['choice_id'];
$student_id=$param['student_id'];
$examination_id=$param['examination_id'];
$created_at=date("Y-m-d G:i:s");
$updated_at=date("Y-m-d G:i:s");
$checkdata=$this->checkAnswerFill($param);
  $clsMyDB = new MyDatabase();
  if ($checkdata==0) {
    $strinsert ="INSERT INTO  answer_fill (examination_id,student_id,detail,number_exam,created_at,updated_at) VALUES ('$examination_id','$student_id','$choice_id','1','$created_at','$updated_at')";
    $objInsert = $clsMyDB->fncInsertRecord($strinsert);
    $response[] =
    [
      'status' => "add",
    ];
  }else {
    $strupdate ="UPDATE  answer_fill SET student_id='$student_id',detail='$choice_id',updated_at='$updated_at' where  answer_fill_id='$checkdata'";
    $objupdate = $clsMyDB->fncUpdateRecord($strupdate);
    $response[] =
    [
      'status' => "update",
    ];
  }

return $response;
}//function addAnswer



public function checkAnswerFill($param)
{
  $set_id=$param['set_id'];
  $student_id=$param['student_id'];
  $examination_id=$param['examination_id'];
    $clsMyDB = new MyDatabase();
    $strCondition2 = "
    SELECT e.answer_fill_id
      FROM exams a
      INNER JOIN `set` b
      ON a.exam_id=b.exam_id
      INNER JOIN exam_path c
      ON b.set_id=c.set_id
      INNER JOIN examination d
      ON c.exam_path_id=d.exam_path_id
      INNER JOIN answer_fill e
      ON e.examination_id=d.examination_id
    WHERE c.set_id='$set_id' AND student_id='$student_id'
    AND e.examination_id='$examination_id'
    ORDER BY d.exam_path_id,d.examination_id ASC
  ";
       $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
       if(!$objSelect2)
       {
         $response=0;
       }
       else{
         foreach ($objSelect2 as $value) {
           $response=$value['answer_fill_id'];
         }
       }
         return $response;


}//function getAnswer


public function addAnswerPath($param)
{
$item=$param['item'];
$student_id=$param['student_id'];
$set_id=$param['set_id'];
$created_at=date("Y-m-d G:i:s");
$updated_at=date("Y-m-d G:i:s");
$clsMyDB = new MyDatabase();
foreach ($item as $key => $value) {
//var_dump($key);
$examination_id=$value["examination_id"];
$choice_pair_id=$value["choice_pair_id"];
if ($choice_pair_id !='-') {

$checkdata=$this->checkAnswerPath($student_id,$examination_id,$set_id);
if ($checkdata==0) {
  $strinsert ="INSERT INTO  answer_pair (student_id,choice_pair_id,examination_id,created_at,updated_at) VALUES ('$student_id','$choice_pair_id','$examination_id','$created_at','$updated_at')";
  $objInsert = $clsMyDB->fncInsertRecord($strinsert);
  $response[] =
  [
    'status' => "add",
  ];
}else {
  $strupdate ="UPDATE  answer_pair SET student_id='$student_id',choice_pair_id='$choice_pair_id',updated_at='$updated_at' where  answer_pair_id='$checkdata'";
  $objupdate = $clsMyDB->fncUpdateRecord($strupdate);
  $response[] =
  [
    'status' => "update",
  ];
}

}
}

return $response;
}//function addAnswer


public function checkAnswerPath($student_id,$examination_id,$set_id)
{
    $clsMyDB = new MyDatabase();
    $strCondition2 = "
    SELECT e.answer_pair_id
      FROM exams a
      INNER JOIN `set` b
      ON a.exam_id=b.exam_id
      INNER JOIN exam_path c
      ON b.set_id=c.set_id
      INNER JOIN examination d
      ON c.exam_path_id=d.exam_path_id
      INNER JOIN answer_pair e
      ON e.examination_id=d.examination_id
    WHERE c.set_id='$set_id' AND student_id='$student_id'
    AND e.examination_id='$examination_id'
    ORDER BY d.exam_path_id,d.examination_id ASC
  ";
       $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
       if(!$objSelect2)
       {
         $response=0;
       }
       else{
         foreach ($objSelect2 as $value) {
           $response=$value['answer_pair_id'];
         }
       }
         return $response;


}//function getAnswer



public function addAnswerPathFill($param)
{
$item=$param['item'];
$student_id=$param['student_id'];
$set_id=$param['set_id'];
$created_at=date("Y-m-d G:i:s");
$updated_at=date("Y-m-d G:i:s");
$clsMyDB = new MyDatabase();
foreach ($item as $key => $value) {
//var_dump($key);
$examination_id=$value["examination_id"];
$choice_fill_id=$value["choice_fill_id"];
$number_exam=$value["number_fill"];
if ($choice_fill_id !='-') {

$checkdata=$this->checkAnswerPathFill($student_id,$examination_id,$set_id,$number_exam);
if ($checkdata==0) {
  $strinsert ="INSERT INTO  answer_fill_select (student_id,choice_fill_id,examination_id,created_at,updated_at,number_exam) VALUES ('$student_id','$choice_fill_id','$examination_id','$created_at','$updated_at','$number_exam')";
  $objInsert = $clsMyDB->fncInsertRecord($strinsert);
  $response[] =
  [
    'status' => "add",
  ];
}else {
  $strupdate ="UPDATE  answer_fill_select SET student_id='$student_id',choice_fill_id='$choice_fill_id',updated_at='$updated_at' where  answer_fill_select_id='$checkdata' AND number_exam='$number_exam'";
  $objupdate = $clsMyDB->fncUpdateRecord($strupdate);
  $response[] =
  [
    'status' => "update",
  ];
}

}
}

return $response;
}//function addAnswer


public function checkAnswerPathFill($student_id,$examination_id,$set_id,$number_exam)
{
    $clsMyDB = new MyDatabase();
    $strCondition2 = "
    SELECT e.answer_fill_select_id
      FROM exams a
      INNER JOIN `set` b
      ON a.exam_id=b.exam_id
      INNER JOIN exam_path c
      ON b.set_id=c.set_id
      INNER JOIN examination d
      ON c.exam_path_id=d.exam_path_id
      INNER JOIN answer_fill_select e
      ON e.examination_id=d.examination_id
    WHERE c.set_id='$set_id' AND student_id='$student_id'
    AND e.examination_id='$examination_id' AND number_exam='$number_exam'
    ORDER BY d.exam_path_id,d.examination_id ASC
  ";
       $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
       if(!$objSelect2)
       {
         $response=0;
       }
       else{
         foreach ($objSelect2 as $value) {
           $response=$value['answer_fill_select_id'];
         }
       }
         return $response;


}//function getAnswer


public function addAnswerPathFillFill($param)
{
$item=$param['item'];
$student_id=$param['student_id'];
$set_id=$param['set_id'];
$created_at=date("Y-m-d G:i:s");
$updated_at=date("Y-m-d G:i:s");
$clsMyDB = new MyDatabase();
foreach ($item as $key => $value) {
//var_dump($key);
$examination_id=$value["examination_id"];
$detail=$value["detail"];
$number_exam=$value["number_fill"];
if ($detail !='') {
$checkdata=$this->checkAnswerPathFillFill($student_id,$examination_id,$set_id,$number_exam);
if ($checkdata==0) {
  $strinsert ="INSERT INTO  answer_fill_fill (student_id,detail,examination_id,created_at,updated_at,number_exam) VALUES ('$student_id','$detail','$examination_id','$created_at','$updated_at','$number_exam')";
  $objInsert = $clsMyDB->fncInsertRecord($strinsert);
  $response[] =
  [
    'status' => "add",
  ];
}else {
  $strupdate ="UPDATE  answer_fill_fill SET student_id='$student_id',detail='$detail',updated_at='$updated_at' where  answer_fill_fill_id='$checkdata' AND number_exam='$number_exam'";
  $objupdate = $clsMyDB->fncUpdateRecord($strupdate);
  $response[] =
  [
    'status' => "update",
  ];
}

}
}

return $response;
}//function addAnswer

public function checkAnswerPathFillFill($student_id,$examination_id,$set_id,$number_exam)
{
    $clsMyDB = new MyDatabase();
    $strCondition2 = "
    SELECT e.answer_fill_fill_id
      FROM exams a
      INNER JOIN `set` b
      ON a.exam_id=b.exam_id
      INNER JOIN exam_path c
      ON b.set_id=c.set_id
      INNER JOIN examination d
      ON c.exam_path_id=d.exam_path_id
      INNER JOIN answer_fill_fill e
      ON e.examination_id=d.examination_id
    WHERE c.set_id='$set_id' AND student_id='$student_id'
    AND e.examination_id='$examination_id' AND number_exam='$number_exam'
    ORDER BY d.exam_path_id,d.examination_id ASC
  ";
       $objSelect2 = $clsMyDB->fncSelectRecord($strCondition2);
       if(!$objSelect2)
       {
         $response=0;
       }
       else{
         foreach ($objSelect2 as $value) {
           $response=$value['answer_fill_fill_id'];
         }
       }
         return $response;


}//function getAnswer

}
?>
