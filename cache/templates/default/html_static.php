<? include handler('template')->file('header'); ?>
<div class="site-ms">
<div class="site-ms__left"> 
<div class="t_area_out">
<div class="t_area_in">
<p class="cur_title" style="width:650px;"><?=$html['title']?></p>
<div class="sect">
<?=$html['content']?>
</div>
</div>
</div>
</div>
<div class="site-ms__right"><? echo $html['name'] == '404' ? ui('widget')->load('html_404') : ui('widget')->load(); ?></div>
</div>
<? include handler('template')->file('footer'); ?>