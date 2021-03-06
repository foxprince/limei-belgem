
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <title></title>
    <link rel="stylesheet" type="text/css" href="dist/css/style.css" />
    <link rel="stylesheet" type="text/css" href="dist/css/page.init.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/print.css">
	<link rel="stylesheet" type="text/css" href="../css/jquery.fancybox.min.css">
    <script src="dist/js/jquery-2.1.3.min.js"></script>
    <script src="dist/js/pageInit.js"></script>
    <script type="text/javascript" src="../js/jquery.fancybox.min.js"></script>
    
    <script src="dist/js/flexible.js"></script>
    
</head>

<body>
    <div class="order_look">
        <header class="c_header">
            <a href="javascript:;" class="h_logo" title=""></a><span>票据查询</span>
        </header>

        <main>
            <form action="" class="c_form">
                <p class="item">
                    <label for="" class="field">类型</label>
                    <select id="type" name="type" class="i_text">
                    	<option value="">全部</option><option value="invoice">发票</option><option value="receipt">收据</option>
                    </select>
                </p>
                <p class="item">
                    <label for="" class="field">日期选择</label>
                    <input type="date" id="start" class="i_text i_date" placeholder="请输入起始日期"> 至 <input type="date" id="end" class="i_text i_date ml0" placeholder="请输入结束日期">
                </p>
                <p class="item">
                    <label for="" class="field">订单编号</label>
                    <input type="number" id="num" class="i_text" placeholder="请输入订单编号">
                </p>
                <p class="item">
                    <label for="" class="field">客户姓名</label>
                    <input type="text" id="custom" class="i_text" placeholder="请输入客户姓名">
                </p>
                <p class="item pc_btn"><button type="button" class="c_btn look_btn J_lookfor">查询</button></p>
            </form>
            <table class="t_data">
            	<thead>
            		<tr>
            			<th>日期</th>
            			<th>客户姓名</th>
            			<th>类型</th>
            			<th>发票编号</th>
            			<th>货币</th>
            			<th>金额</th>
            			<th>VAT</th>
            			<th>修改</th>
            			<th>删除</th>
            		</tr>
            	</thead>
            	<tbody class='J_databody'>
            	</tbody>
            	<tfoot>
            		<tr>
            			<td colspan="6"></td>
            			<td>合计：</td>
            			<td>&yen;<span id='totalprice'>0.00</span></td>
            			<td></td>
            		</tr>
            	</tfoot>
            </table>
        </main>
    </div>


                <!--print 打印-->
            <div class="row lnvoice-row white_content" id="makeOrder"  style="display: none">
                <div class="l-close"><a class="btn" href="javascript:;" onclick="popToggle()"><img src="../images/close.png"></a></div>
                <!--logo-->
                <div class="col-xs-12 text-center">
                    <img src="images/Logo.png" class="logo" alt="">
                </div>
                <!--抬头-->
                <div class="col-xs-12 rise clearfix">
                    <p>LUMIA JEWELRY</p>
                    <p class="rise-vat print_none">VAT：0599.972.516</p>
                    <p>PELIKAANSTRAAT 62 BUS 314</p>
                    <div class="clearfix">
                        <span class="pull-left" id="corp">2017   ANTWERPEN</span>
                        <span class="pull-right to_time"></span>
                    </div>
                    <div class="clearfix" style="margin-bottom: 5px">
                        <span class="pull-left">Tel:  0032 3 689 73 94 </span>
                        <span class="pull-right  to_invoice"></span>
                    </div>
                </div>
                <!--ITEMS-->
                <header id="items" class="col-xs-12 clearfix header_items">
                    ITEMS
                </header>
                <div id="itemList"></div>
                <!--价格-->
                <div class="prices clearfix">
                    <!--内容-->
                    <div class="col-xs-3 clearfix"></div>
                    <div class="col-xs-6 clearfix"></div>
                    <div class="col-xs-1 clearfix">
                        <p class="print_none print_none">21%VAT:</p>
                        <p class="">Total:</p>
                    </div>
                    <div class="col-xs-2  clearfix">
                        <p id="vat_price" class="vat_price print_none">€0</p>
                        <p id="print_price"class="total_price">€0</p>
                    </div>
                </div>
                <!--客户信息-->
                <div class="client clearfix">
                    <div class="col-xs-2  client-cli">
                        <p>Name</p>
                        <p>Passport No. </p>
                        <p>Address </p>
                    </div>
                    <!--信息-->
                    <div class="col-xs-10 client-cli">
                        <p id="to_name"></p>
                        <p id="to_port"></p>
                        <p id="to_address"></p>
                    </div>
                </div>
            </div>
    
    	<div class="black_overlay" id="fade" style="display:none;"></div>
    	
    <script>
    var pageflag = true;
    	$(function(){

            // 点击展开数据
            function fnDataToggle(){
                $('body').on('click','.J_databody tr .J_toggle', function(){
                    var 
                        self = $(this),
                        obox = self.find('.J_o_box');

                    if(obox.is(':hidden')){
                        self.css({'height': '2rem'});
                        obox.fadeIn(200);
                        //self.find('.J_toggle').addClass('rotate');
                    } else {
                        self.css({'height': 'auto'});
                        obox.hide();
                        self.find('.J_toggle').removeClass('rotate');
                    }
                    return false;
                });
            }
            //fnDataToggle();//点击展开事件
			query(1);
            $(".J_lookfor").click(function(){
               pageflag = true;
               $('.page').empty();
               query(1);
            });
            $(".printTranc").click(function(){
            	$.ajax({
                    async:false,
                    url: '../action.php?action=trancDetail&id='+$(this).attr("trancId"),
                    type: "GET",
                    dataType: 'json',
                    success: function (data) {
           				var json=eval(data),to=json.trancDetail.currency,currencyHint='€';
           				var html = '';
           				if(to=='CNY'){
           					currencyHint = '￥';
           				}else if(to=='EUR'){
           					currencyHint = '€';
           				}else if(to=='USD'){
           					currencyHint = '$';
           				}
           				var address = json.trancDetail.street+'　'+json.trancDetail.postcode+'　'+json.trancDetail.city+'　'+json.trancDetail.country;
           				$('#to_name').html(json.trancDetail.name);
           				$('#to_port').html(json.trancDetail.passport);
           				$('#to_address').html(address)
           				$('#print_price').html(currencyHint+json.trancDetail.total_price);
           				if(json.trancDetail.type=='receipt')
           					$('.print_none').hide();
           				else
           					$('#vat_price').html(currencyHint+json.trancDetail.vat_price);
           				$.each(json.list, function (n, j) {
           					html += '<div class="del_items items clearfix">'+
           				    '<div class="col-xs-3 clearfix">';
           				    if(j.type=='dia'||j.type=='diajew')
           				    	html += '<p id="model">'+j.shape+'</p>'+
           				    	 '<p>Carat Weight <span class="pull-right"><span class="pull-left">'+j.carat+'</span></span></p>'+
           			         '<p>Colour Grade <span class="pull-right"><span  class="pull-left">'+j.color+'</span></span></p>'+
           			         '<p>Clarity Grade <span class="pull-right"><span class="pull-left">'+j.clarity+'</span></span></p>';
           				    if(j.type=='diajew'||j.type=='jew')
           				    	html +='<p style="margin-top: 10px;">'+j.material+' White Gold '+j.jewerly+'</p>';
           				    html+='</div>'+
           				    '<div class="col-xs-3 clearfix">';
           				    if(j.type=='dia'||j.type=='diajew')
           				    	html+='<p>'+j.grading_lab+'&nbsp;'+j.report_no+'</p>'+
           			        '<p>Cut Grade <span class="pull-right">'+j.cut_grade+'</span></p>'+
           			        '<p>Polish <span class="pull-right">'+j.polish+'</span></p>'+
           			        '<p>Symmetry<span class="pull-right">'+j.symmetry+'</span></p>';
           				    html+='</div>'+
           				    '<div class="col-xs-4 clearfix">';
           				 	if(j.type=='dia'||j.type=='diajew')
           				    	html+='<p>'+j.fancy+'</p>';
           				    html+='</div>'+ '<div class="col-xs-2 clearfix">';
           				 	if(j.type=='dia'||j.type=='diajew')
           				    	html+='<p>'+currencyHint+j.price+'</p>';
           				    html+='<p>　</p><p>　</p><p>　</p>';
           				    if(j.type=='jew'||j.type=='diajew')
           				        html+='<p>'+currencyHint+j.jewerly_price+'</p>';
           				    html+='</div></div>';
           				})
           				$('#itemList').html(html);
           				html = "";
           				$('.page').hide();
            			//$('.lnvoice-row').show();
            				$("#fade").fadeToggle();
            				$(".lnvoice-row").fadeToggle("slow").focus();
            			//window.print();
            		}
            	});
            });
            $(".deleteTranc").click(function(){
            	if(confirm('您确认删除吗？')){
            		var id = $(this).attr("trancId");
            		$.ajax({
                        async:false,
                        url: "../action.php?action=deleteTranc&id="+$(this).attr("trancId"),
                        type: "GET",
                        success: function (json) {
                        	$('.trancLine [trancId='+id+']').remove();
                		}
                	});
            	}
            });
    	});
        function listpage(total,total_pages){
            $.pageInit({
                container:'.page',//容器：默认page
                //setPos:'body',//放置位置：默认body
                totalPages:total_pages,//总页数：必填
                totalLists:total,//数据总数：必填
                initPage:1,//初始页码：默认1
                inputVal:1,//设置跳转的input值：默认1
                //要执行的函数：默认null，必须为fn且返回true则可执行分页，false则不执行
                callBack:function(n){
                    var flag = true;
                    query(n);
                    return flag;
                }
            });
            pageflag = false;
        }

        function query(page){
            let query ='../action.php?action=trancList';
            let type = $('#type').val();
            let name = $('#custom').val();
            let start = $('#start').val();
            let end = $('#end').val();
            let invoice_no = $('#num').val();
            let url = query +'&page=' + page;
            if(''!==type){
                url += '&type=' + type;
            }
            if(''!==name){
                url += '&name=' + name;
            }
            if(''!==start){
                url += '&start=' + start.replace(/-/g, '');
            }
            if(''!==end){
                url += '&end=' + end.replace(/-/g, '');
            }
            if(''!==invoice_no){
                url += '&invoice_no=' + invoice_no;
            }
            $.ajax({
                async:false,
                url: url,
                type: "GET",
                dataType: 'json',
                timeout: 5000,
                success: function (json) {
                    var totalprice = 0;
                    $('.J_databody').html('');
                    total = json.total;
                    total_pages = json.total_pages;
                    for(var i=0;i<json.list.length;i++){
                        var temp = '<tr trancId="'+json.list[i].id+'" class="trancLine"><td>'+json.list[i].tranc_date+'</td><td>'+json.list[i].name
                        +'</td><td><a trancId="'+json.list[i].id+'"  class="printTranc t_operate">'  +json.list[i].type+'</a></td><td>'+ (json.list[i].type=='invoice'?json.list[i].invoice_no:"--") +'</td><td>'
                        + json.list[i].currency +'</td><td>'+ json.list[i].total_price +'</td><td>'
                        + json.list[i].vat_price +'</td><td><div class="pl"><a trancId="'+json.list[i].id+'" href="index.html?id='+json.list[i].id+'" target="_blank"class="modify J_modify">修改</a></div></td><td><p class="o_box J_o_box"><button trancId="'+json.list[i].id+'"  class="deleteTranc t_operate">删除</button></p></td></tr>';
                        totalprice += parseInt(json.list[i].total_price);
                        $('.J_databody').append(temp);
                        $('#totalprice').html(totalprice);
                    }
                    <?php if($_SESSION['username']!='gnkf'){?>
                    if(pageflag){
                       listpage(total,total_pages);
                    }
                    <?php }?>

                },
                error: function(xhr){
                    alert("请求出错(请检查相关度网络状况.)");
                }
            });
        }
           
        function popToggle(id) {
        	$("#fade").fadeToggle();
        	$("#makeOrder").fadeToggle("slow").focus();
        }
    </script>
</body>
</html>