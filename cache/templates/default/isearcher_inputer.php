<div class="search-box">
<input type="text" id="search-txt" value="<?=$kw?>"  class="input_h search-box__input"  onkeyup="if (event.keyCode == 13) front_search_request();" />
<input class="search-box__button" type="button" value="搜索" onclick="front_search_request()" />
</div>
<script type="text/javascript">
var front_search_base = "<? echo logic('url')->create('product', array('kw' => 'KW000WK')); ?>";
function front_search_request()
{
window.location = front_search_base.replace('KW000WK', encodeURIComponent($('#search-txt').val()));
}
</script>
<div style="display: none;">志扬互动+搜索框</div>