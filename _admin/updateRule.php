<?php
/*===================session========================*/
session_start();

require_once ('../cn/includes/header_ele.php');

if(!isset($_POST['source']) || !isset($_POST['target']) || !isset($_POST['recordid']) || !isset($_POST['carat_from']) || !isset($_POST['carat_to'])){
	exit('error');
}

require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");



$source=$_POST['source'];
$target=$_POST['target'];
$recordid=$_POST['recordid'];
$carat_from=$_POST['carat_from'];
$carat_to=$_POST['carat_to'];
$color=$_POST['color'];
$clarity=$_POST['clarity'];
$cut=$_POST['cut'];
$polish = $_POST['polish'];
$symmetry = $_POST['symmetry'];
$shape = $_POST['shape'];
$certificate = $_POST['certificate'];
$fluo = $_POST['fluo'];
$the_para_value=$_POST['the_para_value'];


$sql='UPDATE price_settings  SET carat_from = '.$carat_from.', carat_to = '.$carat_to.', color = "'.$color.'", clarity = "'.$clarity.'", cut = "'.$cut.'", symmetry = "'.$symmetry.'", polish = "'.$polish.'", certificate = "'.$certificate.'", fluo = "'.$fluo.'", shape = "'.$shape.'", the_para_value = '.$the_para_value.' WHERE id = '.$recordid;
require_once('../log.php');
logger($sql);
$stmt=$conn->query($sql);		
$OK=$stmt->rowCount();

if($OK){
	echo 'ok';
}else{
	echo 'error';
}