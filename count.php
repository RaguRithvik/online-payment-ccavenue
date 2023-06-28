<?php

$count_page = ("hitcount.txt");
$hits = file($count_page);
$hits[0] ++;

$fp = fopen($count_page , "w");
fputs($fp , "$hits[0]");
fclose($fp);
// $year = date("Y",strtotime("-1 year"));
// $year1 = substr(date('Y'), 2, 2);
// echo "$year - $year1/ $hits[0]";
echo "$hits[0]";

?>