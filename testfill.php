<?php

$contentraw='test1<span class="fill ans1">&nbsp;</span>test2<span class="fill ans2">&nbsp;</span>';
echo addUrl($contentraw);
function addUrl($subject){
  $pattern = '/<span class="fill ans(?:[1-9]|10)">\&nbsp\;<\/span>/';
  preg_match_all($pattern, $subject, $matches);

  foreach ($matches[0] as $key => $value) {
  $number = str_replace('<span class="fill ans', '', $value);
  $number = str_replace('">&nbsp;</span>', '', $number);
  $subject = str_replace($value, '<input type="text" id="number'.$number.'">', $subject);
  }
 return $subject;

}
?>
