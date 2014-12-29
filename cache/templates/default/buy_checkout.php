<? include handler('template')->file('header'); ?>
<?=ui('loader')->css('@jquery.tipTip')?>
<?=ui('loader')->js('@jquery.tipTip')?>
<?=ui('loader')->js('@jquery.hook')?>
<?=ui('loader')->js('@jquery.cache')?>
<?=ui('loader')->js('@jquery.form')?>
<?=ui('loader')->css('@jquery.validationEngine')?>
<?=ui('loader')->js('@jquery.validationEngine.cn')?>
<?=ui('loader')->js('@jquery.validationEngine')?>
<script type="text/javascript">
var productid = "<?=$product['id']?>";
var price = <?=$product['nowprice']?>;
var oncemax = <?=$product['oncemax']?>;
var oncemin = <?=$product['oncemin']?>;
var surplus = <?=$product['surplus']?>;
<? if($product['type'] == 'stuff') { ?>
var weight = <?=$product['weightsrc']?>;
<? } ?>
function order_finish(id)
{
window.location = '<?=rewrite("?mod=buy&code=order&id=")?>'+id;
}
</script>
<div class="site-ms">
<?=ui('loader')->js('@buy.checkout', UI_LOADER_ONCE)?>
<div class="site-ms__left">
<div class="t_area_out">
<div class="t_area_in">
<p class="cur_title">提交订单</p>
<div class="sect">
<table id="report">
<tr>
<th><?=TUANGOU_STR?>项目</th>
<th>数量</th>
<th>&nbsp;</th>
<th>价格</th>
<th>&nbsp;</th>
<th>总价</th>
</tr>
<tr>
<td width="35%"><?=$product['flag']?></td>
<td width="10%" style="text-align:center;">
<input type="text" name="num_buys" id="num_buys" value="<?=$product['oncemin']?>" maxlength="4" class="input_text f_input2">
</td>
<td width="4%" style="text-align:center;">x</td>
<td width="12%" style="text-align:center;">&yen; <?=$product['nowprice']?></td>
<td width="4%" style="text-align:center;">=</td>
<td width="15%" style="text-align:center;">
<span class="B">&yen; 
<span id="price_product">
<? echo $product['nowprice']*$product['oncemin'] ?>
</span>
</span>
<p id="product_weight" style="color:#999;"></p>
</td>
</tr>
</table>
<? logic('attrs')->html($product) ?>

<? logic('address')->html($product) ?>

<? logic('express')->html($product) ?>

<? logic('notify' )->html($product) ?>
<table class="price_calc">
<tr id="tr_price_total">
<td class="left">
应付总额
</td>
<td class="right" style="width:100px; margin:0; padding:0; text-align:right;" >
<span style="margin:0px; padding:0px;">	&yen;</span> <font id="price_total" class="price" style="margin:0px; padding:0px;"><? echo $product['nowprice']*$product['oncemin']; ?></font>
</td>
</tr>
</table>
<div class="submit_div">
<form id="checkout_submit" action="?mod=buy&code=checkout&op=save" method="post" >
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/>
<input id="product_id" type="hidden" name="product_id" value="<?=$product['id']?>" />

订单附言：<br/><textarea id="extmsg" class="extmsg" name="extmsg" style="height:88px;"></textarea><br/>
<span style="color:#FF0000">（务必填写正确的联系人和联系电话、否则提交订单无效）</span>
<br/>
<input id="checkout_submit_button" type="submit" value="确认无误，下订单" name="buy" class="btn btn-primary" disabled="false" style="background-color: #555;" />
<font id="submit_status"></font>
<script>
function addListener(element,e,fn){   
	if(element.addEventListener){   
		element.addEventListener(e,fn,false);   
	} else {   
		element.attachEvent("on" + e,fn);   
	}   
}
function textValue(val){
	var Value = val.value;
	var Btn = document.getElementById("checkout_submit_button");
	console.log(Value.length);
	if(Value.length >= 2){
		Btn.disabled = false;
		Btn.style.backgroundColor = "#006dcc";
	}else{
		Btn.disabled = true;
		Btn.style.backgroundColor = "#555";
	}
}
var Textarea = document.getElementById("extmsg");
addListener(Textarea,"keyup",function(){
	textValue(Textarea);
});
</script>
</form>
</div>
</div>
</div>
</div>       
</div>
<script type="text/javascript">fizinit();</script>
<div class="site-ms__right">
<?=ui('widget')->load()?>
</div>
</div>
<? include handler('template')->file('footer'); ?>