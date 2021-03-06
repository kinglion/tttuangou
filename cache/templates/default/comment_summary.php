<?=ui('loader')->css('comment')?>
<?=ui('loader')->js('@comment.ops')?>
<div class="user-reviews">
<div class="overview">
<div class="overview-head">
<div class="overview-title">消费评价</div>
<div class="overview-feedback">
<? if($i_buyed) { ?>
<? if($comment_my) { ?>
您已评价
<? } else { ?>您已购买过本单，请评价
<? } ?>
<? } else { ?>请您购买后评价
<? } ?>
</div>
</div>
<div class="rating-area total-detail">
<div class="total-score">本单用户评价：<span><?=$summary['average']?></span>分</div>
</div>
<div class="rating-area">
<ul class="comment-rating">
<li style="z-index:0; display: list-item; width:<? echo $summary['average'] * 20; ?>%;"></li>
</ul>
</div>
<div class="rating-area">
<div>已有<strong><?=$summary['count']?></strong>人评价</div>
</div>
<div style="clear:both"></div>
</div>
<div class="comment-list" id="deal_comment">
<div id="sp_other">
<? if($i_buyed) { ?>
<div class="comment-sort"><h4>【我的评价内容】</h4></div>
<dl class="comment-txt">
<dd>
<? if($comment_my) { ?>
<p><?=$comment_my['content']?></p>
<? if($comment_my['reply']) { ?>
<div class="replybg"><p class="reply"><?=$comment_my['reply']?></p></div>
<? } ?>
<div class="comment-info">
<ul class="comment-info__rating">
<li style="z-index:0; display: list-item; width:<? echo $comment_my['score'] * 20; ?>%"></li>
</ul>
<span class="comment-info__user-time">
<span class="name"><?=$comment_my['user_name']?></span>
<span class="date"><? echo date('Y-m-d H:i:s', $comment_my['timestamp_update']); ?></span>
</span>
</div>
<? } else { ?><div id="comment-form-box" class="comment-form">
<form id="comment-form" action="index.php?mod=comment&code=submit&pid=<?=$product_id?>" method="post" >
<input type="hidden" name="FORMHASH" value='<?=FORMHASH?>'/>
<p class="p-title">评分</p>
<p class="p-sbox">
<ul class="comment-rating comment-rating-current">
<li id="comment-score-displayer" style="z-index:0; display: list-item; width:0%;"></li>
<li id="comment-score-selector" class="comment-score-selector"></li>
</ul>
<input id="i-comment-score" type="hidden" />
</p>
<p class="p-title">内容</p>
<p class="p-sbox">
<textarea id="i-comment-content"></textarea>
</p>
<p class="p-sbox">
<input id="comment-button" type="button" class="btn btn-primary" value="发布" style="_margin-left:0;" />
</p>
</form>
<div id="comment-form-loading" class="comment-form-loading"></div>
</div>
<? } ?>
</dd>
</dl>
<? } ?>
<div class="comment-sort"><h4>【最新评价内容】</h4></div>
<dl class="comment-txt">
<? if(is_array($comments)) { foreach($comments as $comment) { ?>
<dd>
<p><?=$comment['content']?></p>
<? if($comment['reply']) { ?>
<div class="replybg"><p class="reply"><?=$comment['reply']?></p></div>
<? } ?>
<div class="comment-info">
<ul class="comment-info__rating">
<li style="z-index:0; display: list-item; width:<? echo $comment['score'] * 20; ?>%"></li>
</ul>
<span class="comment-info__user-time">
<span class="name"><?=$comment['user_name']?></span>
<span class="date"><? echo date('Y-m-d H:i:s', $comment['timestamp_update']); ?></span>
<? if($comment['status'] != 'approved') { ?>
<span class="status">
<? if($comment['status']=='auditing') { ?>
审核中
<? } ?>

<? if($comment['status']=='denied') { ?>
未通过
<? } ?>
</span>
<? } ?>
</span>
</div>
</dd>
<? } } ?>
</dl>
<div style=" padding:15px 15px 0 15px;" class="page product_list_pager">
<?=page_moyo()?>
</div>
<input type="hidden" id="nowpage" value="1" />
<div class="c"></div>
</div>
</div>
</div>
<script type="text/javascript">
var commentGoodsId = '7454706';
// if document.ready
//getGoodsComment(commentGoodsId, 1);
// end if
$('#_comment_page a').live("click", function(){
var classn  = $(this).attr('class');
var nowpage = parseInt($("#nowpage").val());
var nowtext = parseInt($(this).text());
if((classn.indexOf('pageup-dis') != '-1') || (classn.indexOf('pagedown-dis') != '-1')) return false;
if(classn.indexOf('pageup') != '-1' && isNaN(nowtext))
{
var page = nowpage - 1;
}
else if(classn.indexOf('pagedown') != '-1' && isNaN(nowtext))
{
var page = nowpage + 1;
}
else
{
var page = nowtext;
}
$("#nowpage").val(page);
$("html,body").animate({scrollTop: $("#deal_comment").offset().top}, 500);
getGoodsComment(commentGoodsId, page);
});
//get comment
function getGoodsComment(goodsId, page) {        
var _url = '/ajax/getComment.php?act=comment';        
$(function(){
$.ajax({
type: "POST",
dataType:'json',
data: "goodsId="+goodsId + "&page=" + page,
url:_url,
beforeSend:function(){$('#_comment_info').html('加载中...');},
success: function(data){
if(data.code == 1) {
$('#_comment_info').html(data.html);
$('#_comment_page').html(data.page);
}
}
});
})
}
</script>