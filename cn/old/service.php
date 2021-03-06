<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="../styles/main.css?v=1395407389" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css">
div.pagemenu{
	display:inline-block;
	position:relative;
	float:left;
	padding:0;
}
.pagemenu ul{
	margin:0;
	padding:0;
}
.pagemenu li{
	border-bottom-style:dotted;
	border-width:1px;
	border-color:#CC6699;
	padding-right:35px;
	list-style:none;
}
.pagemenu li h2{
	font-size:20px;
}
.pagemenu li h2 a{
	color:#555;
	text-decoration:none;
}
li.crr a{
	color:#000 !important;
}

div#content{
	width:680px;
	margin-left:50px;
	float:left;
	font-size:15px;
	padding-top:8px;
}
div#content h1{
	margin-top:0;
	font-size:22px;
}
</style>
<title>LUMIA JEWELRY - HOME</title>
</head>

<body>



<?php
include_once('header.php');



require_once('../includes/connection.php');
$conn=dbConnect('write','pdo');
$conn->query("SET NAMES 'utf8'");

$sql='SELECT * FROM homepage';
$stmt=$conn->query($sql);
foreach($stmt as $row){}
?>



<div id="bodycontent">

<h3 class="blocktitle" style="margin-bottom:50px;">利美钻石 : 售后服务</h3>


<div class="pagemenu" style="margin-top:35px;">
<ul>
<li <?php if((isset($_GET['c']) && $_GET['c']=='glazing') || !isset($_GET)){ echo 'class="crr"';} ?> style="border-top-style:dotted;">
<h2><a href="service.php?c=glazing" class="link-id-0 active">何谓上光服务？</a></h2></li>


<li <?php if(isset($_GET['c']) && $_GET['c']=='polishing'){ echo 'class="crr"';} ?>><h2><a href="service.php?c=polishing" class="link-id-1">何谓抛光服务？</a></h2></li>

<li <?php if(isset($_GET['c']) && $_GET['c']=='resize'){ echo 'class="crr"';} ?>><h2><a href="service.php?c=resize" class="link-id-2">何谓尺寸修改服务？</a></h2></li>
<li <?php if(isset($_GET['c']) && $_GET['c']=='repair'){ echo 'class="crr"';} ?>><h2><a href="service.php?c=repair" class="link-id-3">何谓修复服务？</a></h2></li>
<li <?php if(isset($_GET['c']) && $_GET['c']=='pairing'){ echo 'class="crr"';} ?>><h2><a href="service.php?c=pairing">何谓重制/配对服务？</a></h2></li>
<li <?php if(isset($_GET['c']) && $_GET['c']=='graving'){ echo 'class="crr"';} ?>><h2><a href="service.php?c=graving" class="link-id-5">何谓刻字服务？</a></h2></li>
<li <?php if(isset($_GET['c']) && $_GET['c']=='facelift'){ echo 'class="crr"';} ?>><h2><a href="service.php?c=facelift">何谓改款服务？</a></h2></li>
</ul>
</div>



<div id="content">
<?php
if(isset($_GET['c']) && $_GET['c']=='polishing'){
?>
<h1>何谓抛光服务？</h1>
<div class="field-item even">
<img src="../images/site_elements/dsc_0280.jpg" width="680" alt="何谓抛光服务？" />
</div>



<div class="field-item even"><p>在不影响原有结构形态条件下，通过抛光服务恢复珠宝的原有光泽和外观。但是，抛光处理会消除一层薄薄的金属层，因此一般黄K金珠宝抛光总次数不宜超过两次。另外，抛光处理并不能去除较深的划痕。技术上不可能把白K金表面抛光处理成黑色表面。</p>
<p>抛光处理由利美珠宝工艺师完成，包括以下步骤：</p>
<ul>
<li>对作品进行检查分析；</li>
<li>抛光处理，用刷头分别配合三种不同的抛光膏进行抛光，直至达到光洁平滑的镜面效果；</li>
<li>在加入清洁剂的温水池中采用超声波清洁珠宝，尤其是不易触及到的角落缝隙位置。除祖母绿、珍珠、或其他类似的脆弱宝石以外，所有珠宝都适用于超声波清洁。</li>
<li>镀铑处理，为了增强白K金的莹白质感，有时会在其表面镀一层薄薄的铑金属层，铑是一种稀有的贵重金属，与铂金为同族金属。  </li>
</ul>
<p>镀铑处理包括以下步骤：</p>
<ul>
<li>抛光之前，清除原有的铑金属层，露出原来的金属表面，为重新镀层作准备；</li>
<li>抛光后，将白K金珠宝放入铑金属镀池中均匀镀层。</li>
<li>进行符合利美品质标准的功能和外观检测。</li>
</ul>
</div>







<?php
}else if(isset($_GET['c']) && $_GET['c']=='resize'){
?>
<h1>何谓尺寸修改服务？</h1>

<div class="field-item even">
<img src="../images/site_elements/dsc_0129.jpg" width="680" alt="何谓尺寸修改服务？" />
</div>




<div class="field-item even">
<p>针对手链、项链或戒指的一项服务，在可能的情况下，修改这些珠宝的尺寸大小。此项服务涉及非常细致而复杂的操作。</p>
<p>此项服务由利美珠宝工艺师完成，包括以下步骤：</p>
<ul>
<li>对作品进行检查分析；</li>
<li>调节大小：</li>
<li>对于戒指改圈，珠宝工艺师用极其纤薄的锯片将戒指切开，添加或减少材质，然后再用钳子将切口两端合在一起。</li>
<li>对于链节式珠宝，只需要增加或减少链节即可。</li>
<li>抛光处理，用刷头分别配合三种不同的抛光膏来进行，直至达到光洁平滑的镜面效果；</li>
<li>清洁处理，在加入清洁剂的温水池中采用超声波清洁珠宝，尤其是不易触及到的角落缝隙位置。除祖母绿、珍珠、或其他类似的脆弱宝石以外，所有珠宝都适用于超声波清洁。</li>
<li>镀铑处理，为了增强白K金的莹白质感，有时会在其表面镀一层薄薄的铑金属层，铑是一种稀有的贵重金属，与铂金为同族金属。 </li>
</ul>
<p>镀铑处理包括以下步骤：</p>
<ul>
<li>抛光之前，清除原有的铑金属层，露出原来的金属表面，为重新镀层作准备；</li>
<li>抛光后，将白K金珠宝放入铑金属镀池中均匀镀层。</li>
<li>进行符合利美品质标准的功能和外观检测。</li>
</ul>
<p>注意：在抛光过程中，会去除一层薄薄的金属层。正因如此，我们建议白K金或黄K金珠宝抛光总次数不超过两次。此外，抛光处理也不能完全去除较深划痕。技术上不可能把白K金表面抛光处理成黑色表面。</p>
</div>



<?php
}else if(isset($_GET['c']) && $_GET['c']=='repair'){
?>

<h1>何谓修复服务？</h1>



<div class="field-item even"><p>通过修复处理把一件损坏程度较严重的珠宝饰品恢复成原有的外观形态。</p>
<p>修复处理由利美珠宝工艺师完成，包括以下步骤：</p>
<ul>
<li>对作品进行检查分析；</li>
<li>为修复处理报价。</li>
</ul>
<p>顾客接受报价后：</p>
<ul>
<li>修复分为多个步骤进行：
<ul>
<li>焊接：焊枪接上高温金属焊头，将珠宝两部分组件焊接在一起；然后浸入酸性溶液去除氧化痕迹。</li>
<li>塑形：用黄杨木槌把珠宝塑造成原有的形状。</li>
</ul>
</li>
<li>宝石镶嵌，一道细微而复杂的工序，有时需要重新定做镶座和镶爪，用以固定宝石。
<ul>
<li>抛光处理，用刷头分别配合三种不同的抛光膏来进行，直至达到光洁平滑的镜面效果；</li>
<li>清洁处理，在加入清洁剂的温水池中采用超声波清洁珠宝，尤其是不易触及到的角落缝隙位置。除祖母绿、珍珠、或其他类似的脆弱宝石以外，所有珠宝都适用于超声波清洁。</li>
<li>镀铑处理，为了增强白K金的莹白质感，有时会在其表面镀一层薄薄的铑金属层，铑是一种稀有的贵重金属，与铂金为同族金属。 </li>
</ul>
</li>
</ul>
<p>镀铑处理包括以下步骤：</p>
<ul>
<li>抛光之前，清除原有的铑金属层，露出原来的金属表面，为重新镀层作准备；</li>
<li>抛光后，将白K金珠宝放入铑金属镀池中均匀镀层。</li>
<li>进行符合利美品质标准的功能和外观检测。</li>
</ul>
<p>注意：在抛光过程中，会去除一层薄薄的金属层。此外，抛光处理也不能完全去除较深划痕。技术上不可能把白K金表面抛光处理成黑色表面。</p>
</div>



<?php
}else if(isset($_GET['c']) && $_GET['c']=='pairing'){
?>


<h1>何谓重制/配对服务？</h1>
<div class="field-item even">
<img src="../images/site_elements/n8050600_dia_0.jpg" style="float:right; margin: 0 0 15px 15px;" height="300" alt="何谓重制/配对服务？" /></div>


<div class="field-item even">
<p>重制/配对服务适用于那些无法调整型号大小、无法修复珠宝，或一对珠宝饰品中一只丢失的情况。</p>
<p>重制/配对服务由利美珠宝工艺师完成，包括以下步骤：</p>
<ul>
<li>对作品进行检查分析；</li>
<li>重制：根据原有的珠宝材质和工艺方法，重制方式也有所不同。为了重制最忠于原款的珠宝，利美珠宝工艺师必须遵循复杂而严格的程序，包括以下步骤：</li>
<li>查询利美资料档案，以找出原款的设计图和相应的模具；
<ul>
<li>金属制模成型；</li>
<li>将不同的部件焊接在一起；</li>
<li>镶嵌宝石；</li>
<li>镌刻独立编号和利美标记等。</li>
</ul>
</li>
<li>抛光处理，用刷头分别配合三种不同的抛光膏来进行，直至达到光洁平滑的镜面效果；</li>
<li>清洁处理，在加入清洁剂的温水池中采用超声波清洁珠宝，尤其是不易触及到的角落缝隙位置。除祖母绿、珍珠、或其他类似的脆弱宝石以外，所有珠宝都适用于超声波清洁。</li>
<li>镀铑处理，为了增强白K金的莹白质感，有时会在其表面镀一层薄薄的铑金属层，铑是一种稀有的贵重金属，与铂金为同族金属。镀铑处理包括以下步骤：</li>
<li>抛光之前，清除原有的铑金属层，露出原来的金属表面，为重新镀层作准备；</li>
<li>抛光后，将白K金珠宝放入铑金属镀池中均匀镀层。</li>
<li>进行符合利美品质标准的功能和外观检测。</li>
</ul>
<p>注意：在抛光过程中，会去除一层薄薄的金属层。正因如此，我们建议白K金或黄K金珠宝抛光总次数不超过两次。此外，抛光处理也不能完全去除较深划痕。技术上不可能把白K金表面抛光处理成黑色表面。</p>
</div>



<?php
}else if(isset($_GET['c']) && $_GET['c']=='graving'){
?>

<h1>何谓刻字服务？</h1>
<div class="field-item even"><img src="../images/site_elements/dsc_0051.jpg" width="680" alt="何谓刻字服务？" /></div>


<div class="field-item even">
<p>在技术和空间允许的条件下，为您的利美珠宝镌刻上您个人的独特印记，可以是由字母组合成人名、字句、日期，也可以是简单符号图案。<br />
刻字服务在购买利美珠宝作品三个月内有效，并需出具利美作品证书。</p>
<p>刻字由利美珠宝工艺师完成，包括以下步骤：</p>
<ul>
<li>对作品进行检查分析； </li>
<li>刻字：镌刻内容的可能性取决于可供刻字的有效空间。传统的方式是用刻刀在金属表面凿刻文字或图案。现在大部分镌刻都采用高科技激光雕刻，图案更规则，更均匀。</li>
<li>在加入清洁剂的温水池中采用超声波清洁珠宝，尤其是不易触及到的角落缝隙位置。除祖母绿、珍珠、或其他类似的脆弱宝石以外，所有珠宝都适用于超声波清洁。</li>
<li>进行符合利美品质标准的功能和外观检测。</li>
</ul>
<p>注：刻的字可被清除，也可替换。</p>
</div>





<?php
}else if(isset($_GET['c']) && $_GET['c']=='facelift'){
?>


<h1>何谓改款服务？</h1>

<div class="field-item even"><p>如果您想把利美珠宝改造成您所期望的、或受赠人所期望的形状外观，可以联系我们，与我们的珠宝工艺师具体商讨改款的可能性。</p>
</div>


<?php
}else{
?>
<h1>何谓上光服务？</h1>
<div class="field-item even"><img src="../images/site_elements/dsc_0287.jpg" width="680" alt="何谓上光服务？" /></div>



<div class="field-item even"><p>通过此项服务让原本暗淡或是表面出现划痕的利美珠宝再次绽放璀璨光泽。此项服务不包括对镀铑珠宝作品进行维护。</p>
<p>此项服务由利美珠宝工艺师在品牌精品店内进行，包括以下步骤：</p>
<ul>
<li>对作品进行检查分析；</li>
<li>使用毡轮和抛光膏来提亮金属表面。如果经过操作后，其他划痕显露出来，那么只有抛光处理才能将这些划痕去除。</li>
<li>在加入清洁剂的温水池中采用超声波清洁珠宝，尤其是不易触及到的角落缝隙位置。除祖母绿、珍珠、或其他类似的脆弱宝石以外，所有珠宝都适用于超声波清洁。</li>
<li>进行符合利美品质标准的功能和外观检测。</li>
</ul>
</div>




<?php
}
?>







</div>

<br style="clear:both;" />
</div>




<?php
include_once('footer.php');
?>




</body>
</html>