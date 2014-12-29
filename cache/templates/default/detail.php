<? include handler('template')->file('header'); ?>
<?=ui('ad')->load('howdo')?>
<?=ui('loader')->js('@time.lesser')?>
<div class="site-ms">
<div class="site-ms__left">
<div class="t_area_out t_area_out1" >
<div class="t_area_in">
<table class="deal-tile__title">
<tbody>
<tr>
<td><span>今日<?=TUANGOU_STR?>：</span><?=$product['name']?></td>
</tr>
</tbody>
</table>
<div class="deal-tile__detail deal-tile__detail2">
<div  class="price">&yen;<?=$product['nowprice']?> </div>
<div class="at_shuzi">
<ul>
<li>原价<br/><h4>&yen;<?=$product['price']?></h4></li>
<? if($product['presell']) { ?>
<li><?=TUANGOU_STR?>价<br/><h3><?=$product['presell']['price_full']?></h3></li>
<li class="R"><?=$product['presell']['text']?><br/><h3>&yen;<?=$product['nowprice']?></h3></li>
<? } else { ?><li>折扣<br/><h3><?=$product['discount']?>折</h3></li>
<li class="R">节省<br/><h3>&yen;<?=$product['price']-$product['nowprice']?></h3></li>
<? } ?>
</ul>
</div>
<? if($product['time_remain'] < 0) { ?>
<div class="deal_o">
<a href="javascript:void(0)">
<div class="jieshu">已结束</div>
</a>
</div>
<? } else { ?>
<? if($product['surplus']>0) { ?>
<div class="deal_b">
<? if($product['type'] == 'prize') { ?>
<a href="?mod=buy&code=checkout&id=<?=$product['id']?>">
<div class="choujiang" >立即抽奖</div>
</a>
<? } else { ?><a href="?mod=buy&code=checkout&id=<?=$product['id']?>">
<div class="buypro" >立即抢购</div>
</a>
<? } ?>
</div>
<? } else { ?><div class="deal_y">
<img src="templates/default/images/new/maiguangle.png">
</div>
<? } ?>
 
<? } ?>
 
<div class="deal-tile__detail" style="display:none;"> 
<img src="templates/default/images/new/time.png" style="position: relative;top: 5px;left: -5px;" />剩余时间：
<? if($product['time_remain'] < 0) { ?>
<span>0</span>
<? } ?>
<div class="deal_djs" id="remainTime_<?=$product['id']?>"></div>
<script language="javascript">
addTimeLesser(<?=$product['id']?>, <?=$product['time_remain']?>);
</script>
</div>	  
<b class="B" >
<? if($product['type'] == 'prize') { ?>
<span><? echo logic('prize')->allCount($product['id']); ?></span>人已参加抽奖
<? if($product['time_remain'] < 0) { ?>
<? if(logic('prize')->PrizeWIN($product['id'])) { ?>
<div>
已开奖
<br/>
<a href="?mod=prize&code=view&pid=<?=$product['id']?>">查看中奖号码</a>
</div>
<? } else { ?><div>未开奖</div>
<? } ?>
<? } ?>
<? } else { ?><span><?=$product['succ_buyers']?></span>人已购买
<? } ?>
</b>
<? if($product['time_remain'] < 0) { ?>
<p class="txt12">下次请赶早！</p>
<? } else { ?>
<? if($product['surplus']<=0) { ?>
<p class="txt12">下次请赶早！</p>
<? } else { ?><p class="txt12">数量有限，行动要快哦！</p><br/>
<? } ?>
<? } ?>
</div>
<div class="deal-tile__cover">
<div class="deal-tile__cover_img">
<? ui('iimager')->multis($product['id'], $product['imgs']) ?>
</div>
<div class="deal-tile__cover_brief">
<p><?=$product['intro']?></p>
</div>	
</div>
<div style="clear: both; height: 0px; overflow:hidden;">&nbsp;</div>
<div class="like_share_this" style="padding-bottom:0;">
<? app('bshare')->load('product_detail', array('product'=>$product)) ?>
</div>
<div style="clear: both; height: 0px; overflow:hidden;"></div>
</div>
</div>
<div class="t_area_out">
<div class="t_area_in">
<a class="detail-centit">
<span>商家的其他<?=TUANGOU_STR?></span>
</a>
<? $data = logic('product')->GetOwnerList($product['sellerid'],5) ?>
<? if(is_array($data)) { foreach($data as $product2) { ?>
<? if($product2['id']!=$product['id']) { ?>
<p>
<b class="oc_price">&yen;<?=$product2['nowprice']?></b>
<a target="_blank" href="?view=<?=$product2['id']?>"><?=$product2['name']?></a>
<span class="mb_0626" id="tuanState"><b><?=$product2['sells_count']?></b>人已购买</span>
</p>
<? } ?>
<? } } ?>
</div>
</div>
<div class="content-navbar" id="content-navbar-id">
<ul>
<? if(!meta('p_hs_'.$product['id'])) { ?>
<li class="name-cur" style="display:none;"><span id="name-address">报名方式</span></li>
<script type="text/javascript">
$("#name-address").click(function() {
$(this).parent("li").nextAll().removeClass("name-cur");
$(this).parent("li").addClass("name-cur");
document.getElementById("name-address-block").scrollIntoView();
})
</script>
<? } ?>
<li class="name-cur"><span id="name-product-detail" >线路详情</span></li>
<li><span id="name-comment">用户评价</span></li>
</ul>
<script type="text/javascript">
if(!($.browser.msie && $.browser.version<7)){
document.write('<script type="text/javascript" src="templates/default/./js/side_follow.js"><'+'/script>');
}
$("#name-product-detail").click(function(){
$(this).parent("li").nextAll().removeClass("name-cur");
$(this).parent("li").prevAll().removeClass("name-cur");
$(this).parent("li").addClass("name-cur");
document.getElementById("name-product-detail-block").scrollIntoView();
})
$("#name-comment").click(function() {
$(this).parent("li").prevAll().removeClass("name-cur");
$(this).parent("li").addClass("name-cur");
document.getElementById("name-comment-block").scrollIntoView();
})
</script>
<div class="content-navbar_buy" style="display:none;">
<? if($product['time_remain'] < 0) { ?>
<a href="javascript:void(0)"><div class="buy-end">已结束</div></a>
<? } else { ?>
<? if($product['surplus']>0) { ?>
<div class="cj_or_bp">
<? if($product['type'] == 'prize') { ?>
<a href="?mod=buy&code=checkout&id=<?=$product['id']?>">
<div class="landb-now" >立即抽奖</div>
</a>
<? } else { ?><a href="?mod=buy&code=checkout&id=<?=$product['id']?>">
<div class="landb-now" >立即抢购</div>
</a>
<? } ?>
</div>
<? } else { ?><img src="templates/default/images/new/maiguangle.png" style="width: 80px;margin: 5px 10px;">
<? } ?>
 
<? } ?>
</div>
<div style="clear:both;"></div>
</div>
<script type="text/javascript">
if(!($.browser.msie && $.browser.version<7)){
$("#content-navbar-id").fixbox({distanceToBottom:200,threshold:8});
}
</script>
<div class="mainbox">
<div class="main">
<?=ui('loader')->js('@product.detail')?>
<? if(!meta('p_hs_'.$product['id'])) { ?>
<a class="detail-centit" id="name-address-block" style="display:none;">
<span>报名方式</span>
</a>
<div class="position-wrapper">
<div class="address-list" style="display:none;">
<? $sellermap = $product['sellermap'] ?>
<? if($sellermap['0']!='') { ?>
<script type="text/javascript" src="http://api.go2map.com/maps/js/api_v2.0.js"></script>
<script type="text/javascript"> 
var map, marker;
function map_initialize()
{
	var location = new sogou.maps.Point('<?=$sellermap['0']?>', '<?=$sellermap['1']?>');
	var mapOptions = {
		zoom: parseInt('<?=$sellermap['2']?>'),
		center: location,
		mapTypeId: sogou.maps.MapTypeId.ROADMAP,
		mapControl: false
	};
	map = new sogou.maps.Map(document.getElementById("map_canvas"), mapOptions);
	marker = new sogou.maps.Marker({
	map: map,
	position: location,
	title: "<?=$product['sellername']?>"
	});
}
</script>
<div class="left-content">
	<div id="map_canvas">
		<div style="padding:1em; color:gray;">正在载入...</div>
	</div>
	<a id="img1" class="img2"><div class="map_big">查看完整地图</div></a>
</div>
<? } ?>
<div class="biz-wrapper" style="float:left;">
	<h1><?=$product['sellername']?></h1>
	<ul style="margin-top:15px;font-size:12px;">
		<li class="com_adr">
			<div><strong>地址：</strong><?=$product['selleraddress']?></div>
			<div><strong>电话：</strong><?=$product['sellerphone']?></div>
			<a href="<?=$product['sellerurl']?>" target="_blank"><?=$product['sellerurl']?></a>
		</li>
	</ul>
</div>
<? if($sellermap['0']!='') { ?>
	<script type="text/javascript">
	$(document).ready(function() {
	$("#img1").click(function() {
	window.open('http://map.sogou.com/#c=<?=$sellermap['0']?>,<?=$sellermap['1']?>,<?=$sellermap['2']?>');
	});
<? if($sellermap['0']!='') { ?>
	map_initialize();
	
<? } ?>
});
	</script>
<? } ?>
</div>
<div style="clear:both;"></div>
</div>
<? } ?>
<a class="detail-centit" id="name-product-detail-block" style="display:none;">
<span>线路详情</span>
</a>
<div id="product_detail_area">
<h4 style="display:none;">【本单详情】</h4>
<Script type="text/javascript">
$("#t_detail_txt img").each(function(){
if($(this).width() > $(this).parent().width()) {
$(this).width("100%");
}});
</Script>
<div id="product_detail_cnt" class="product_detail_cnt"><?=$product['content']?></div>
<? if($product['cue']) { ?>
<h4>【特别提示】</h4>
<div class="product_detail_cnt"><?=$product['cue']?></div>
<? } ?>

<? if($product['theysay']) { ?>
<h4>【他们说】</h4>
<div class="product_detail_cnt"><?=$product['theysay']?></div>
<? } ?>

<? if($product['wesay']) { ?>
<h4>【我们说】</h4>
<div class="product_detail_cnt"><?=$product['wesay']?></div>
<? } ?>
</div>
<a class="detail-centit" id="name-comment-block">
<span>用户评价</span>
</a>
<? logic('comment')->show_summary($product['id']) ?>
</div>
<div class="deal-buy-bottom">
<div class="price">&yen;<?=$product['nowprice']?></div>
<table>
<tbody>
<tr>
<th>市场价</th>
<th>折扣</th>
<th>已<?=TUANGOU_STR?></th>
</tr>
<tr>
<td><span>&yen;</span><del><?=$product['price']?></del></td>
<td><?=$product['discount']?>折</td>
<td>
<? if($product['type'] == 'prize') { ?>
<? echo logic('prize')->allCount($product['id']); ?>
<? } else { ?><?=$product['succ_buyers']?>
<? } ?>
人
</td>
</tr>
</tbody>
</table>
<div class="btn—wrapper">
<? if($product['time_remain'] < 0) { ?>
<div><a href="javascript:void(0)"><div class="js">已结束</div></a></div>
<? } else { ?>
<? if($product['surplus']>0) { ?>
<div class="cj_or_bp">
<? if($product['type'] == 'prize') { ?>
<a href="?mod=buy&code=checkout&id=<?=$product['id']?>">
<div class="cj" >立即抽奖</div>
</a>
<? } else { ?><a href="?mod=buy&code=checkout&id=<?=$product['id']?>">
<div class="bp" >立即抢购</div>
</a>
<? } ?>
</div>
<? } else { ?><div style="float:right;">
<img src="templates/default/images/new/maiguangle.png">
</div>
<? } ?>
 
<? } ?>
</div>
</div>
</div>
</div>
<div class="site-ms__right">
<div class="t_area_out ">
<h1>看了本<?=TUANGOU_STR?>的用户还看了</h1>
<div class="t_area_in">
<ul class="product_list">
<? $cpid = isset($_GET['view']) ? $_GET['view'] : -1; ?>

<? $one_product =  logic('product')->GetOne($cpid); ?>

<? $product_other_list = logic('product')->GetOtherList($one_product['city'], $one_product['category'], $one_product['id'], 10); ?>
<? if(is_array($product_other_list)) { foreach($product_other_list as $i => $product) { ?>
<li>
<p ><a href="?view=<?=$product['id']?>"><img src="<? echo imager($product['imgs']['0'], IMG_Small);; ?>" width="220" height="131"/></a></p>
<p class="name"><a href="?view=<?=$product['id']?>"><?=$product['name']?></a></p>
<div class="shop">
<div class="pr">
<font class="price">&yen;<?=$product['nowprice']?></font>
<font class="markprice">&nbsp;市场价：&yen;<?=$product['price']?></font>
</div>
<div class="gotosee"><a href="?view=<?=$product['id']?>">去看看</a></div>
<div style="clear:both;"></div>
</div>
</li>
<? } } ?>
         
</ul>
</div>
</div>
<?=ui('widget')->load('index_detail')?>
</div>
</div>
<? include handler('template')->file('footer'); ?>