<?php
/*===================session========================*/
session_start();
include_once('../log.php');

// if session variable not set, redirect to login page
if(!isset($_SESSION['authenticated'])) {
  header('Location: login.php');
  exit('error');
}

if($_SESSION['authenticated']!='SiHui'){
	$_SESSION=array();
	if (isset($_COOKIE[session_name()])){
		setcookie(session_name(), '', time()-86400, '/');
	}
	session_destroy();
	header('Location: login.php');
    exit('error');
}


$username=$_SESSION['username'];
$account_level=$_SESSION['account_level'];


if($account_level>2 && $account_level!=8){
	exit('no permit');
}


require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");



if(isset($_POST['stock_ref'])){
	$stock_ref=$_POST['stock_ref'];
	$sql_UPDATE='UPDATE diamonds SET ordered_by = NULL WHERE stock_ref in ('.$stock_ref.') ';
logger($sql_UPDATE);	
	
	
	$stmt=$conn->query($sql_UPDATE);	  
	
	$insertOK=$stmt->rowCount();
logger($insertOK);
	if($insertOK){
		echo 'OK';
		
		foreach($conn->query('SELECT real_name FROM users WHERE user_name = "'.$username.'"') as $row_user){
			$operator=$row_user['real_name'];
		}
		
		$the_action='操作：取消预定；操作人：'.$operator.'； 操作对象：钻石编号'.$stock_ref;
		
		$sql_record_login='INSERT INTO login_history (theuser, the_action, action_time) VALUES(:theuser, :the_action, NOW())';
		
		
		$stmt=$conn->prepare($sql_record_login);	  
		$stmt->bindParam(':theuser', $username, PDO::PARAM_STR);
		$stmt->bindParam(':the_action', $the_action, PDO::PARAM_STR);
		$stmt->execute();
		$insertOK=$stmt->rowCount();
		
		
	}
}else{
	echo 'error';
}
