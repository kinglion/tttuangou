<?php 
 /*********************************************
 *[tttuangou] (C)2005 - 2010 Cenwor Inc.
 *
 * tttuangou nav配置
 *
 * @author www.tttuangou.net
 *
 * @time 2014-05-28 23:30
 *********************************************/
 
  
$config['nav']=array (
  0 => 
  array (
    'order' => '0',
    'name' => '首页',
    'url' => '/',
    'title' => '查看本期团购',
    'target' => '_self',
  ),
  1 => 
  array (
    'order' => '2',
    'name' => '往期团购',
    'url' => '?mod=list&code=deals',
    'title' => '查看往期团购',
    'target' => '_self',
  ),
  2 => 
  array (
    'order' => '3',
    'name' => '团购指南',
    'url' => '?mod=html&code=help',
    'title' => '不知道如何团购？来看看吧',
    'target' => '_self',
  ),
  3 => 
  array (
    'order' => '4',
    'name' => '常见问题',
    'url' => '?mod=html&code=faq',
    'title' => '有问题了，先来这里看看吧',
    'target' => '_self',
  ),
  4 => 
  array (
    'order' => '5',
    'name' => '在线问答',
    'url' => '?mod=list&code=ask',
    'title' => '您可以在这里提出您的疑问',
    'target' => '_self',
  ),
  5 => 
  array (
    'order' => '6',
    'name' => '邀请有奖',
    'url' => '?mod=list&code=invite',
    'title' => '邀请好友参加团购有返利的哦',
    'target' => '_self',
  ),
  6 => 
  array (
    'order' => '7',
    'name' => '国内旅游 ',
    'url' => '?mod=catalog&code=gnly',
    'title' => '',
    'target' => '_self',
  ),
  7 => 
  array (
    'order' => '8',
    'name' => '周边旅游 ',
    'url' => '?mod=catalog&code=zbky',
    'title' => '',
    'target' => '_self',
  ),
  8 => 
  array (
    'order' => '9',
    'name' => '出境旅游 ',
    'url' => '?mod=catalog&code=cjly',
    'title' => '',
    'target' => '_self',
  ),
);
?>