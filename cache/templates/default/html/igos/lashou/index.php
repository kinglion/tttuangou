<style type="text/css">
.List{ width:1000px; margin:0;}
.List .item{ width: 315px;margin-right: 14px; margin-left:0;}
.List .item .deal-tile__cover,.List .item .deal-tile__cover_img,.List .item .imgs_displayer #imageslider,.List .item .imgs_displayer  #imageslider img{ width: 100%;}
.List .item .mb_0626 b{ font-size:14px;}
</style>
<div class="site-ms">
<div class="site-ms__left List">
<? if(is_array($product)) { foreach($product as $item) { ?>
<? $icc++ ?>
<div class="t_area_out item " >
<div class="t_area_in" >
<div class="deal-tile__cover">
<div class="deal-tile__cover_img">
<? ui('iimager')->single($item['id'], $item['imgs']['0']) ?>
</div>
</div>
<table class="deal-tile__title">
<tbody>
<tr>
<td>
<div class="at_jrat_title"><a href="?view=<?=$item['id']?>" target="_blank"><?=$item['name']?></a></div>
</td>
</tr>
</tbody>
</table>
<div class="deal-tile__detail">
<div class="price">&yen;<?=$item['nowprice']?></div>
<div class="at_shuzi">
<ul>
<li style="line-height:39px;padding:0;"><span>原价:</span><b class="prime_cost ">&yen;<?=$item['price']?></b></li>
</ul>
</div>
<div class="deal_g">
<div class="gsee">
<a href="?view=<?=$item['id']?>" target="_blank"><div class="gotosee">去看看</div></a>
</div>
</div>
</div>
<div class="deal-tile__extra">
<? if($item['presell']) { ?>
<div class="yufu">
<span><?=TUANGOU_STR?>价:</span><b>&yen;<?=$item['presell']['price_full']?></b>
</div>
<? } ?>
<div id="tuanState" class="mb_0626"><b><?=$item['succ_buyers']?></b>人已购买</div>
</div>	
</div>
</div>
<? } } ?>
<div class="product_list_pager"><?=page_moyo()?></div>
</div>
</div>