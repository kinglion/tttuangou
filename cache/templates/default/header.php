<!doctype html>
<html>
<head>
<?='<base h'.'ref="'.ini('settings.site_url').'/" />'?>
<meta http-equiv="Content-Type" content="text/html; charset=<?=ini("settings.charset")?>" />
<title><? echo ($this->Title != '') ? $this->Title.' - ' : (ini('cplace.cnpre.enabled') ? (logic('misc')->City('name').ini('settings.tuangou_str').' - ') : ''); ?><?=ini("settings.site_name")?><?=$this->Config['page_title']?></title>
<meta name="Keywords" content="<?=ini('settings.'.(mocod()=='index.main'?'index_':'').'meta_keywords')?>" />
<meta name="Description" content="<?=ini('settings.'.(mocod()=='index.main'?'index_':'').'meta_description')?>
<? if($__p = productCurrentView()) { ?>
,<? echo strip_tags($__p['intro']); ?>
<? } ?>
" />
<script type="text/javascript">
var thisSiteURL = '<?=ini("settings.site_url")?>/';
</script>
<link rel="shortcut icon" href="favicon.ico" />
<?=ui('loader')->css('main')?>
<?=ui('style')->loadCSS()?>
<?=ui('loader')->js('@jquery')?>
<?=ui('loader')->js('@common')?><? echo '<!-'.'-[if IE 6]>'; ?><?=ui('loader')->js('DD_belatedPNG')?>
<script type="text/javascript">
DD_belatedPNG.fix('*');
</script><? echo '<![endif]-'.'->'; ?>
<? if(false==DEBUG) { ?>
<?=ui('loader')->js('@error.clear')?>
<? } ?>
</head>
<body>
<div class="m_bg">
<div class="header">
<div class="site-mast">
<? $unms = ui('style')->allowMulti() ? false : true ?>
<div class="site-mast__user-nav">
<ul id="mobile-info"
<? if($unms) { ?>
 style="background:none;"
<? } ?>
>

</ul>
<div id="skin-chose">
<?=ui('style')->loadSwUI()?>
</div>
<div class="site-mast__user-w" >
<? if(MEMBER_ID > 0) { ?>
<script type="text/javascript">
$(document).ready(function(){
if ($(".sp_member").width()>75){
$(".sp_member").width(75) ;}});
</script>
<div class="user-info 
<? if(MEMBER_ROLE_ID==3) { ?>
welcom
<? } ?>
">
<div class="user-info__name">
<span style="float:left;">欢迎您，</span>
<span class="sp_member"><?=MEMBER_NAME?></span>
</div>
<div class="user-info__logout">
<a href="?mod=account&code=logout">退出</a>            
</div>
</div>
<? if($this->MemberHandler->HasPermission('index',"",1) === true) { ?>
<div class="user-info" >
<a href="admin.php" target="_blank">管理后台</a>
</div>
<? } ?>
 
<? if(MEMBER_ROLE_ID==6) { ?>
<div class="user-info" >
<a href="?mod=seller">商家管理</a>
</div>
<? } ?>
 
<div class="user-info">
<div class="dropdown">
我的<?=TUANGOU_STR?><i class="tri"></i>
<div class="dropdown-menu">
<div><a href="?mod=me&code=coupon" class="sh_t">我的<?=TUANGOU_STR?>券</a></div>
<div><a href="?mod=me&code=order">我的订单</a></div>
<div><a href="?mod=me&code=bill">收支明细</a></div>
<div><a href="?mod=me&code=favorite">我的收藏</a></div>
<div><a href="?mod=me&code=setting">账户设置</a></div>
<div><a href="?mod=me&code=address">收货地址</a></div>
<div><a href="?mod=recharge">账户充值</a></div>
<div><a href="?mod=me&code=rebate" style="display:none">我的返利</a></div>
<div><a href="?mod=me&code=credit" style="display:none">我的积分</a></div>
</div>
</div>
</div>
<? } else { ?><div class="user-info">
<div class="user-info__name">您好！欢迎您的到来。</div>
<div class="user-info__login">
<a href="?mod=account&code=login">登录</a>
</div>
<div class="user-info__signup">
<a href="?mod=account&code=register">注册</a>
</div>
</div>
<? } ?>
<div class="user-info" style="display:none;"><a href="?mod=list&code=ckticket" class="vcoupon">&raquo; <?=TUANGOU_STR?>券验证及消费登记</a></div>
</div>    
</div>
</div>
<div class="site-mast__branding">
<div class="site-logo"><a href="./"><img src="templates/default/images/zhanweifu.gif" /></a></div>
<div class="city-info">
<a class="at_city" href="javascript:void(0)"><?=logic('misc')->City('name')?></a>
<a id="top_title">[切换城市]</a>
<div id="change_city" > 
<div id="show_provinces" >
<div class="city_close" id="close">[关闭]</div>
<div style=" font-weight:bolder;" class="city_chose"><span>请选择您所在的城市:</span></div>
<ul class="scity">
<? if(is_array(logic('misc')->CityList())) { foreach(logic('misc')->CityList() as $i => $value) { ?>
<li><span><a href="?city=<?=$value['shorthand']?>"><?=$value['cityname']?></a></span></li>
<? } } ?>
</ul>
</div>
</div>
</div>
<? $kw = logic('isearcher')->inputer() ?>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
$(".dropdown").mouseover(function(){$(".dropdown-menu").show();$(".dropdown").addClass("dropdown-open");});
$(".dropdown").mouseout(function(){$(".dropdown-menu").hide();$(".dropdown").removeClass("dropdown-open");});
});
</script>
<div class="site-mast__site-nav-w">
<div class="site-mast__site-nav">
<? if(is_array($this->Config['__navs'])) { foreach($this->Config['__navs'] as $i => $nav) { ?>
<a href="<?=$nav['url']?>" title="<?=$nav['title']?>" target="<?=$nav['target']?>" class="<?=$nav['class']?>"><span><?=$nav['name']?></span></a>
<? } } ?>
</div>
</div>
<div class="site-mast__search-result" 
<? if($kw) { ?>
 style="display:block;"
<? } else { ?>style="display:none;"
<? } ?>
>找到“<?=$kw?>”相关的<?=TUANGOU_STR?>如下</div>
<? echo ui('loader')->css($this->Module.'.'.$this->Code) ?>