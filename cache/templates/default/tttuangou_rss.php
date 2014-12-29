<? include handler('template')->file('header'); ?>
<div class="site-ms">
<div class="site-ms__left">
<div class="t_area_out">
<div class="t_area_in">
<p class="cur_title">开放API</p>
<div class="sect">
<ul class="rsslist">
<? if(is_array($supportList)) { foreach($supportList as $key => $one) { ?>
<li>
<? if($key!='index') { ?>
<?=$one['title']?>的格式
<? } else { ?><a href="<?=$this->Config['site_url']?><?=$url_pre?><?=$key?>"><?=$one['title']?></a> 标准格式
<? } ?>
</li>
<li class="content">
<input type="text" value="<?=$this->Config['site_url']?><?=$url_pre?><?=$key?>" />
<? if($one['submit']!='') { ?>
<a href="<?=$one['submit']?>" target="_blank">[ 点此提交 ]</a>
<? } ?>
</li>
<? } } ?>
</ul>
</div>
</div>
</div>
</div>
<div class="site-ms__right">
<?=ui('widget')->load()?>
</div>
</div>
<? include handler('template')->file('footer'); ?>