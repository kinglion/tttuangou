<? echo '<'; ?>?xml version="1.0" encoding="<?=ini("settings.charset")?>"?<? echo '>'; ?><!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=<?=ini("settings.charset")?>"/>
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=2.0"/>
<meta name="MobileOptimized" content="236"/>
<meta http-equiv="Cache-Control" content="no-cache"/>
<title><?=ini('settings.site_name')?></title>
</head>
<body>
<a href="?mod=wap">
<img src="templates/wap/images/logo.gif" />
</a>
<hr/>
<? if(MEMBER_ID) { ?>
欢迎你，<?=MEMBER_NAME?>，<a href="?mod=wap&code=account&op=logout">退出</a>
<? } else { ?><a href="?mod=wap&code=account&op=login">登录</a>
<? } ?>
<hr/>