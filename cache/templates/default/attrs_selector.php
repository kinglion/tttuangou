<?=ui('loader')->js('@attrs.selector')?>
<div class="pro-attrs">
<? if(is_array($pro_attrs)) { foreach($pro_attrs as $cat) { ?>
<dl>
<dt id="pro-attrs-cat-<?=$cat['id']?>" class="xcat" xcat="<?=$cat['id']?>" xrequired="<?=$cat['required']?>"><?=$cat['name']?></dt>
<dd>
<ul>
<? if(is_array($cat['attrs'])) { foreach($cat['attrs'] as $attr) { ?>
<li id="pro-attrs-item-<?=$attr['id']?>" class="pro-attrs-link" catfrom="<?=$attr['cat_id']?>" attrid="<?=$attr['id']?>" pricemoves="<?=$attr['price_moves']?>" xbinding="<?=$attr['binding']?>"><?=$attr['name']?></li>
<? } } ?>
</ul>
</dd>
</dl>
<? } } ?>
</div>