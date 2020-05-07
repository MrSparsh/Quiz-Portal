<?php
session_start();
require("../database.php");
include("header.php");
error_reporting(0);
extract($_SESSION);
include('Classes/PHPExcel.php');
$excel=PHPExcel_IOFactory::load('C:\Users\hp\Downloads\1.xlsx');
$excel->setActiveSheetIndex(0);
$i=1;
while($excel->getActiveSheet()->getCell('A'.$i)->getValue()!="")
{
	$id=$excel->getActiveSheet()->getCell('A'.$i)->getValue();
	$option_num=$excel->getActiveSheet()->getCell('B'.$i)->getValue();
	
	mysqli_query($cn,"Update question set true_answer=$option_num where test_id=$_SESSION['test_id'] AND ques_id= $id ");	
}
?>
