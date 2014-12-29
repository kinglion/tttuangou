<? if($meituannav) { ?>
<? if(is_array($catalog)) { foreach($catalog as $i => $topclass) { ?>
<li class="root-item"> 
<a href="<?=$topclass['url']?>" class="root-name"><span>
<? if($topclass['icon']) { ?>
<i><img src="<?=$topclass['icon']?>"></i>
<? } ?>
<?=$topclass['name']?></span></a>
<p><a href="<?=$topclass['subclass']['0']['url']?>"><?=$topclass['subclass']['0']['name']?></a><a href="<?=$topclass['subclass']['1']['url']?>"><?=$topclass['subclass']['1']['name']?></a><a href="<?=$topclass['subclass']['2']['url']?>"><?=$topclass['subclass']['2']['name']?></a><a href="<?=$topclass['subclass']['3']['url']?>"><?=$topclass['subclass']['3']['name']?></a></p>
<ul class="pop-panel Fix sub-list">
<? if(is_array($topclass['subclass'])) { foreach($topclass['subclass'] as $n => $subclass) { ?>
<li><a href="<?=$subclass['url']?>"><?=$subclass['name']?></a></li>
<? } } ?>
<div class="pop-panel-img"><?=$topclass['script']?></div>
</ul>
</li>
<? } } ?>
<? } else { ?>          
<div class="site-fs__cell" style="border-bottom:none;">
<div class="site-fs__cell-title"> 分&nbsp;&nbsp;类：</div>
<div class="site-fs__cell-son1">
<? if(is_array($catalog)) { foreach($catalog as $i => $topclass) { ?>
<a href="<?=$topclass['url']?>" class="topclass-name 
<? if($topclass['selected']) { ?>
selected
<? } ?>
"><?=$topclass['name']?></a>
<? if($topclass['selected']) { ?>
<? $subclasses = $topclass['subclass'] ?>
<? } ?>
<? } } ?>
<div style="clear: both;"></div>
</div>
<? if($subclasses) { ?>
<div class="site-fs__cell-son2">
<? if(is_array($subclasses)) { foreach($subclasses as $ii => $subclass) { ?>
<a href="<?=$subclass['url']?>" class="topclass-name 
<? if($subclass['selected']) { ?>
selected
<? } ?>
">
<?=$subclass['name']?><!-- 
<? if(isset($subclass['oslcount'])) { ?>
<font class="subclass-count">(<?=$subclass['oslcount']?>)</font>
<? } ?>
-->
</a>
<? } } ?>
<div style="clear: both;"></div>
</div>
<? } ?>
<div style="clear: both; height:0px; overflow:hidden;"></div>
<div style="display: none;">志扬互动+分类导航</div>
</div>
<? } ?>