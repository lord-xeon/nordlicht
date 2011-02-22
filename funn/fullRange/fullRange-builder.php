<?php 
/*Outputs a JSON object of the Full Range of data in the stats file for a given section*/
require_once('fullRange-class.php');

$fr = new FullRange();

$fr->dayR=$_GET['day'];
$fr->what=$_GET['what'];
$fr->surl=$_GET['surl'];
$fr->build();

echo json_encode($fr->jsonObj);
?>