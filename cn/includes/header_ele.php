<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}
$permit=true;
$username=$_SESSION['username'];
$account_level=$_SESSION['account_level'];
	require_once('../includes/connection.php');
	$conn=dbConnect('write','pdo');
	$conn->query("SET NAMES 'utf8'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="Lumia 比利时钻石,安特卫普钻石,钻石购买,钻交所,钻石交易所，比利时钻交所，比利时钻石交易所" name="keywords" />
<meta name="description" content="Lumia 利美钻石主营产品：比利时钻石，安特卫普钻石，利美钻石婚戒定制专家，为您专业定制独一无二的钻戒，每颗钻石都配有国际钻石证书，清晰的解释，贴心的建议和优惠的价格是利美对您的承诺，作为华人的购钻渠道，利美钻石将竭诚为您的选择提供最专业的服务。"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta content="BELGEM" name="description">
<!-- Google Tag Manager --> <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src= 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-PGHZ4TH');</script>
<!-- End Google Tag Manager -->
<link href="../styles/main.css?v=<?php echo strtotime('now'); ?>" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/styles/jquery-ui.css" />
<link href="/styles/multiple-select.css" rel="stylesheet"/>
<link href="/js/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
<link href="/styles/jquery.datetimepicker.css" rel="stylesheet">
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/moment.js"></script>
<script type="text/javascript" src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="../jscontrol.js?v=<?php echo strtotime('now'); ?>"></script>
<script type="text/javascript">
var r = document.referrer;
r = r.toLowerCase(); //转为小写
var aSites = new Array('google.','baidu.','soso.','so.','360.','yahoo.','youdao.','sogou.','gougou.');
var b = false;
for (i in aSites){
	if (r.indexOf(aSites[i]) > 0){
		b = true;
		break;
	}
}  
if(b){
	self.location = 'https://www.lumiagem.com/index.php';
}
</script>
<link rel="shortcut icon" href="../images/site_elements/icon.ico" />
