<?php
/*===================session========================*/
session_start();
require_once('../log.php');
if(isset($_POST['logout'])){
	 session_unset();
	 header('Location: login.php');
     exit;
}
// if session variable not set, redirect to login page
if(!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit;
}
$username=$_SESSION['username'];
$account_level=$_SESSION['account_level'];
require_once('../log.php');
require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");
if(isset($_POST['filter_company']) && $_POST['filter_company']!='all'){
	$crr_company=$_POST['filter_company'];
	$thefromcompany=$_POST['filter_company'];
	$companyfiltercondition=' AND diamonds.from_company = "'.$thefromcompany.'" ';
}else{
	$companyfiltercondition='';
	$crr_company="all";
}
if(isset($_REQUEST['filter_orderDate']) && $_REQUEST['filter_orderDate']!='all'){
	$crr_orderDate=$_REQUEST['filter_orderDate'];
	if($_REQUEST['filter_orderDate']!='null')
		$orderDateCondition=' AND diamonds.ordered_time in ('.$crr_orderDate.')';
	if(isset($_REQUEST['customer']) && $_REQUEST['customer']!='all'&& $_REQUEST['customer']!='null')
		$orderDateCondition .= ' and diamonds.customer in('.$_REQUEST['customer'].')';
	if(isset($_REQUEST['appointment_time']) && $_REQUEST['appointment_time']!='all'&& $_REQUEST['appointment_time']!='null')
		$orderDateCondition .= ' and diamonds.appointment_time in('.$_REQUEST['appointment_time'].')';
}else{
	$orderDateCondition='';
	$crr_orderDate="all";
}
if(isset($_POST['filter_user']) && $_POST['filter_user']!='all'){
	$crr_searching_user=$_POST['filter_user'];
	//$thefromcompany=$_POST['filter_user'];
	$userfiltercondition=' AND users.user_name = "'.$crr_searching_user.'" ';
}else{
	$userfiltercondition='';
	$crr_searching_user="all";
}
if(isset($_POST['filter_price'])){
	$crr_searching_price=$_POST['filter_price'];
}else{
	$crr_searching_price="retail_price";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>管理界面</title>
<link rel="stylesheet" href="./adminstyle.css">
<link rel="stylesheet" href="../styles/jquery-ui.css">
<!-- <link rel="stylesheet" href="../styles/multi-select.css"> -->
<link rel="stylesheet" href="../styles/jquery.multiselect.css">

<link rel="stylesheet" href="../styles/jquery.dataTables.min.css">

<style>
body{
	font-family:'Microsoft Yahei', 微软雅黑, STHeiti, simsun, Arial, sans-serif;
	font-size:14px;
	font-weight:100;
	}
h1{
	position:relative;
	left:40px;
	font-family:Verdana, Geneva, sans-serif;
	font-weight:bold;
	font-size:20px;
	color:#000;
	margin-top:0px;
}
td{
	vertical-align:top;
	padding:5px;
	border-bottom-style:solid;
	border-left-style:solid;
	border-width:1px;
	border-color:#CCC;
	font-size:12px;
}
span.inditxt{
	color:#DDD;
	font-size:10px;
}
tr.finido{
	background-color:#9FC;
}
.finido td.numberrow{
	background-image:URL(../images/tick.png);
	background-position:center center;
	background-repeat:no-repeat;
	background-size:38px;
}
p.Stock_Num{
	padding:0;
	margin: 0;
}
.cell_stock_ref, .cell_dia_id{
	font-size:10px;
}
td.lastcell{
	border-right-style:solid;
	border-width:1px;
	position:static;
}
td.crrOperationLine{
	background-color:#CFF !important;
}
.d td{
	background-color:#EFEFEF;
}
#tablehead td{
	border-top-style:solid;
	background-color:#BBB;
}
button.operationbutton{
	background-color:#6CF;
	border-width:1px;
	padding:2px 3px;
	font-size:12px;
	margin-left:15px;
	display:inline-block;
	border-style:solid;
}
div.operationbox{
	display:none;
	position:absolute;
	background-color:#CFF;
	width:420px;
	padding:15px;
	right: 0;
	box-shadow: 0 0 5px #666;
	border-radius:6px;
}
span.operationXbtn{
	border-style:solid;
	border-width:1px;
	border-color:#333;
	display:inline-block;
	padding:0 4px;
	float:right;
	background-color:#FFF;
}
button#normalmodebtn{
	background-color:#F90;
	padding:5px 12px;
	font-size:18px;
	border-style:solid;
	border-width:1px;
	display:none;
}
</style>
<script src="../js/jquery-1.11.2.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>

<script src="../js/jquery.dataTables.min.js"></script>
<!-- <script src="../js/jquery.multi-select.js"></script> -->
<script src="../js/jquery.multiselect.js"></script>


<script type="text/javascript">
$(document).ready(function(){
	$("#submit_article").click(function(){
			$("form#uploadArticle").submit();
	});
	$('#filter_company').change(function(){
		$('form#companyfilterform').submit();
	});
	$('#filter_orderDate').change(function(){
		$('form#orderDateForm').submit();
	});
	$('#filter_user').change(function(){
		$('form#userfilterform').submit();
	});
	$('#filter_price').change(function(){
		$('form#pricefilterform').submit();
	});
	$("#checkAll").click(function() {
		if(this.checked){ 
    			$("input[name='subBox']").each(function(){this.checked=true;}); 
    		}else{ 
    			$("input[name='subBox']").each(function(){this.checked=false;}); 
    		} 
	});
	
	getDiaCompany();
	getDiaStock();
	$('#orderTable').DataTable();
});
function filterOrderDate() {
	window.location.href="index.php?filter_orderDate="+$('#orderDateSelect').val()+"&customer="+$('#customerSelect').val()+"&appointment_time="+$('#appointmentSelect').val();
}
function choosethispage(index) {
	window.location.href="index.php?crr_page="+index;
}
function formcomplete(){
	if($.trim($('#title').val())==''){
		alert('没有标题！');
		return false;
	}
	return true;
}
function paidrecord(the_number){
	var refnumber=the_number;
	var theamount=$('input#paid_'+refnumber).val();
	if(theamount==0){
		alert('金额为0,不能保存');
		return false;
	}
	$('#indication').fadeIn('fast');
	$.post(
		"_save_paidamount.php", 
		{stock_ref: refnumber, amount: theamount}, 
		function(data){
			//alert(data);
			if($.trim(data)=='OK'){
				$('#paidbtn_'+refnumber).attr('disabled','disabled');
				$('button#paidbtn_'+refnumber).html('<span class="inditxt">已存</span>');
				$('input#paid_'+refnumber).attr('title',theamount);
				$('input#paid_'+refnumber).css('background-color','#FC9');
			}else{
				alert('Server is busy, please try later!');
			}
			$('#indication').fadeOut('fast');
		}
	);
}
function cancelorder(the_number){
var refnumber="";
	if(the_number!=0&&!the_number){
		var selected = [];
		$('input[name="subBox"]').each(function() {
               	if(this.checked){
			selected.push('"'+$(this).val()+'"');
		}});
		refnumber=selected.join(',');
	}
	else {
		refnumber='"'+the_number+'"';
	}
	$('#indication').fadeIn('fast');
	var r=confirm('确定要取消预定吗？');
	if(r){
		$.post(
			"_cancel_order.php", 
			{stock_ref: refnumber}, 
			function(data){
				console.log(data);
				//alert(data);
				if($.trim(data)=='OK'){
					//$('button#cancelorderbtn_'+refnumber).html('<span class="inditxt">已取消</span>');
					//$('tr#record_'+refnumber+' td button').attr('disabled','disabled');
					//$('tr#record_'+refnumber).css('background-color','#F0F0F0');
					//$('tr#record_'+refnumber).delay(500).fadeOut('slow');
					location.replace(location.href);
				}else{
					alert('Server is busy, please try later!');
				}
				$('#indication').fadeOut('fast');
			}
		);
	}
}
function reserveddiamond(the_number){
	var refnumber=the_number;
	if(refnumber=='no-action'){
		alert('该钻石已经预留，或已经售出');
		return;
	}
	$('#indication').fadeIn('fast');
	$.post(
		"_reserve_diamond.php", 
		{stock_ref: refnumber}, 
		function(data){
			//alert(data);
			if($.trim(data)=='OK'){
				$('button#reservedbtn_'+refnumber).attr('disabled','disabled');
				$('tr#record_'+refnumber+' td.cell_dia_id').append('<br /><span style="color:#F00;">已预留</span>');
				//$('tr#record_'+refnumber).css('background-color','#F0F0F0');
			}else{
				alert('Server is busy, please try later!');
			}
			$('#indication').fadeOut('fast');
		}
	);
}
function sendorder(the_number){
	var refnumber=the_number;
	var r=false;
	var paid_amount_forthis=parseFloat($('#paid_'+refnumber).attr('title'));
	var ori_price_diamond=parseFloat($('#ori_price_'+refnumber).html());
	var just_put_amout=parseFloat($('#paid_'+refnumber).val());
	if(just_put_amout!=paid_amount_forthis){
		alert("已付金额尚未保存，请先保存。");
		return;
	}
	if(paid_amount_forthis<paid_amount_forthis){
		r=confirm('已付金额小于钻石原有价格。确定已发货吗？');
	}else if(paid_amount_forthis==0){
		r=confirm('已付金额为0。确定已发货吗？');
	}else{
		r=true;
	}
	if(r){
		$('#indication').fadeIn('fast');
		$.post(
			"_send_order.php", 
			{stock_ref: refnumber}, 
			function(data){
				//alert(data);
				if($.trim(data)=='OK'){
					$('button#paidbtn_'+refnumber+', button#cancelorderbtn_'+refnumber+', button#reservedbtn_'+refnumber).fadeOut('fast');					
					$('button#sendbtn_'+refnumber).html('<span class="inditxt">已发货</span>');
					$('tr#record_'+refnumber+' td button').attr('disabled','disabled');
					$('tr#record_'+refnumber).css('background-color','#F0F0F0');
				}else{
					alert('Server is busy, please try later!');
				}
				$('#indication').fadeOut('fast');
			}
		);
	}
}
function commentsave(the_number){
	var refnumber=the_number;
	var thetext=$('textarea#comment_'+refnumber).val();
	$('#indication').fadeIn('fast');
	$.post(
		"_save_ordernote.php", 
		{stock_ref: refnumber, content: thetext}, 
		function(data){
			//alert(data);
			if($.trim(data)=='OK'){
				//alert('ordered');
				$('button#commentsavebtn_'+refnumber).html('<span class="inditxt">已存</span>');
			}else{
				alert('Server is busy, please try later!');
			}
			$('#indication').fadeOut('fast');
		}
	);
}
function getDiaCompany(){
	$('.fromcampanytofetch').each(function(){
		var crrObj=$(this);
		var crr_stock_ref=crrObj.attr('title');
		$.post(
			"getdiamondcompany.php", 
			{diamond_id: crr_stock_ref}, 
			function(data){
				$('td.fromcampanytofetch[title="'+crr_stock_ref+'"]').html(data);
			}
		);
	});
}
function getDiaStock(){
	$('.stocknum_to_fetch').each(function(){
		var crrObj=$(this);
		var crr_stock_ref=crrObj.attr('title');
		$.post(
			"getdiamondstock.php", 
			{diamond_id: crr_stock_ref}, 
			function(data){
				$('p.Stock_Num[title="'+crr_stock_ref+'"]').html(data);
			}
		);
	});
}
function openOperationBox(stockref){
	var thestockref=stockref;
	$('#record_'+thestockref+' td').addClass('crrOperationLine');
	$('#record_'+thestockref+' div.operationbox').fadeIn('fast');
}
function closeOperationBox(){
	$('div.operationbox').fadeOut('fast');
	$('td.crrOperationLine').removeClass('crrOperationLine');
}
function printingmode(){
	$('.hideforprint, div.mng_navi').fadeOut('fast',function(){
		$('button#printingmodebtn').hide();
		$('button#normalmodebtn').show();
	});
	$('.paidfield').hide();
	$('#headerbox').hide();$('#logoutForm').hide();
	$('#contentNavi').hide();
	$('tr').find('th:eq(0)').hide(); $('tr').find('td:eq(0)').hide();
	$('tr').find('th:eq(16)').hide(); $('tr').find('td:eq(16)').hide();
	$('div#maincontent').css('margin-left',20);
}
function operationmode(){
	$('.hideforprint, div.mng_navi').fadeIn('fast',function(){
		$('button#normalmodebtn').hide();
		$('button#printingmodebtn').show();
	});
	$('div#maincontent').removeAttr('style');
	$('.paidfield').show();
	$('#headerbox').show();$('#logoutForm').show();
	$('tr').find('th:eq(0)').show(); $('tr').find('td:eq(0)').show();
	$('tr').find('th:eq(16)').show(); $('tr').find('td:eq(16)').show();
}
$('#orderDateSelect').multiselect();
</script>
</head>
<body>
<?php
include('navi.php');
?>
<div id="maincontent">
<?php if($account_level==1){ ?>

    <button onclick="hidefinido()" style="display:inline-block; margin:25px; padding:5px 20px; background-color:#e3dac5; border-width:1px; font-size:16px;">隐藏/显示 已经发货的纪录</button>
    <script type="text/javascript">
    var showfinido=true;
    function hidefinido(){
        if(showfinido){
            $('tr.finido').fadeOut('fast');
            showfinido=false;
        }else{
            $('tr.finido').fadeIn('fast');
            showfinido=true;
        }
    }
    </script>
    <table cellpadding="0" cellspacing="0">
    <tr id="tablehead">
    <td width="68">钻石ID</td>
    <td width="30">形状</td>
    <td width="38">重量</td>
    <td width="38">颜色</td>
    <td width="38">净度</td>
    <td width="88">切工</td>
    <td width="58">荧光</td>
    <td width="78" align="center">证书</td>
    <td width="78">价格(美元)</td>
    <td width="88">预定代理</td>
    <td width="88">预定时间</td>
    <td width="78">操作</td>
    <td width="128" class="lastcell">订单状态</td>
    </tr>
    <?php
    $sql_orders='SELECT diamonds.id, diamonds.stock_ref, shape, carat, color, fancy_color, clarity, grading_lab, certificate_number, cut_grade, polish, symmetry, fluorescence_intensity, price, diamonds.from_company, diamonds.ordered_time, paid_amount, order_sent, comment, status, users.user_name, users.real_name, users.account_level, users.given_by FROM diamonds, users WHERE diamonds.ordered_by IS NOT NULL AND diamonds.ordered_by <> "" AND diamonds.ordered_by = users.user_name AND (diamonds.ordered_by = "'.$username.'" OR (diamonds.ordered_by = users.user_name AND users.given_by = "'.$username.'")) ORDER BY diamonds.ordered_time DESC';
    $counter=0;
        foreach($conn->query($sql_orders) as $row){
            $counter++;
            if($row['order_sent']==NULL){
                $classofrow='';
            }else{
                $classofrow=' class="finido" ';
            }
            if(ceil($counter/2)>($counter/2)){
                $cellclass='o';
            }else{
                $cellclass='d';
            }
    ?>
    <tr<?php echo $classofrow; ?> id="record_<?php echo $row['stock_ref']; ?>" class="<?php echo $cellclass; ?>">
    <td class="cell_dia_id">
    <?php echo $row['stock_ref']; ?>
        <?php
        if($row['status']=='SOLD'){
        ?>
        <br /><span style="color:#F00;">已售出</span>
        <?
        }
        ?>
    </td>
    <td><?php echo $row['shape']; ?></td>
    <td><?php echo $row['carat']; ?></td>
    <td>
        <?php
        if($row['color']!=NULL && $row['color']!=''){
            echo $row['color'];
        }
        if($row['fancy_color']!=NULL && $row['fancy_color']!=''){
            echo $row['fancy_color'];
        }
        ?>
    </td>
    <td><?php echo $row['clarity']; ?></td>
    <td><?php echo $row['cut_grade']; ?> <?php echo $row['polish']; ?> <?php echo $row['symmetry']; ?></td>
    <td><?php echo $row['fluorescence_intensity']; ?></td>
    <td align="center">
    <?php
        $thelab=$row['grading_lab'];
    ?>
    <span class="lab-title"><?php echo $thelab; ?></span><br />
        <?php
        $certi_num=$row['certificate_number'];
        if('GIA'==$thelab){
            $certi_link='http://www.gia.edu/cs/Satellite?pagename=GST%2FDispatcher&childpagename=GIA%2FPage%2FReportCheck&c=Page&cid=1355954554547&reportno='.$certi_num;
        }elseif('IGI'==$thelab){
            //$certi_link='http://www.igiworldwide.com/igi/verify.php?r='.$certi_num;
            $certi_link='http://www.igiworldwide.com/verify.php?r='.$certi_num;
        }elseif('HRD'==$thelab){
            $certi_link='http://www.hrdantwerplink.be/index.php?record_number='.$certi_num;
        }else{
            $certi_link='#not-available';
        }
        ?>
    <a target="_blank" style="color:#000; font-size:9px;" href="<?php echo $certi_link; ?>"><?php echo $certi_num; ?></a>
    </td>
    <td>
    <?php echo $row['price']; ?>
    </td>
    <td><?php echo $row['real_name']; ?></td>
    <td><?php echo $row['ordered_time']; ?></td>
    <td>
        <?php
        if($row['order_sent']==NULL){
        ?>
        <p style="margin:2px 0 5px 0; border-bottom-style:dashed; border-width:1px; border-color:#666; padding:5px;">
        <button class="cancelorderbtn" id="cancelorderbtn_<?php echo $row['stock_ref']; ?>" type="button" onclick="cancelorder('<?php echo $row['stock_ref']; ?>')" >取消预定</button>
        </p>
        <?php
        }
        ?>
    </td>
    <td class="lastcell">
    预定已经收到。<br />
        <?php
        if($row['paid_amount']==0){
            echo "尚未收到付款。<br />";
        }else{
            echo "已收到付款金额为".$row['paid_amount']."欧元。<br />";
        }
        if($row['order_sent']=="YES"){
            echo "已经发货。";
        }else{
            echo "尚未发货。";
        }
        ?>
    </td>
    </tr>
    <?php } ?>
    </table>
<?php } ?>



</div><!-- end maincontent -->
<div id="#indication" style="position:fixed; width:100%; height:100%; background-color:rgba(255,255,255, 0.88); top:0; left:0; z-index:28; display:none;">
<div id="#indiinner" style="position:relative; width:200px; background-color:#0CF; margin:150px auto; padding:20px; text-align:center;">
正在存储。。。
</div>
</div>
</body>
</html>