<?php
$days=8587;
$years=0;
$months=0;
 if($days>=365){
   $years=(int)($days / 365);
   $days=$days%365;
 }
 if($days>30){
    $months=(int)($days/30);
    $days=$days%30;
 }
  
?>