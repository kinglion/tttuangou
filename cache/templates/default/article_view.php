<? include handler('template')->file('header'); ?>
<div class="site-ms">
<div class="site-ms__left">
<div class="t_area_out">
<div class="t_area_in">
<div class="cur_top">
<div class="wenzhang">文章</div>
<div class="article_listl"><a href="?mod=article">返回文章列表</a></div>
</div>
<div class="cur">
<div class="cur_titles"><?=$article['title']?></div>
<div class="clear" style="clear:both;"></div>
<div class="article_info">
<div class="article_au">来自：<?=$article['writer']?></div>
<div class="article_ti"><? echo date('Y-m-d H:i:s', $article['timestamp_create']); ?></div>
<div class="clear" style="clear:both;"></div>
</div>
<div class="sect">
<ul class="article_content">
<li>
<?=$article['content']?>
</li>
</ul>
</div>
</div>
</div>
</div>
</div>  
<div class="site-ms__right">
<?=ui('widget')->load()?>
</div>
</div>
<? include handler('template')->file('footer'); ?>