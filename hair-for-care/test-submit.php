<?php

$date = $_POST['date'];

$day = date("d",strtotime($date));
$month = date("m",strtotime($date));
$year = date("Y",strtotime($date));

echo $day;
echo $month;
echo $year;

?>