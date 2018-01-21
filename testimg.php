<?php
$content="/upload/u1/t10/image_1514969809_6665.jpg";
$urlTeacher="http://teacher.smartexam.revoitmarketing.com";
echo addUrl($content,$urlTeacher);
function addUrl($content,$urlTeacher){
 $pattern = '/\/upload\/u[0-9]+\/t[0-9]+\/image_[0-9_]+.[a-z]{2,4}/';
 preg_match_all($pattern, $content, $matches);
 $img = $matches[0];
 foreach ($img as $key => $value) {
  $content = str_replace($value,$urlTeacher.$value , $content);
 }
 return $content;
}
?>
