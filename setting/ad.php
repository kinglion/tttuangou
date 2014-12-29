<?php

$config["ad"] =  array (
  'howdo' => 
  array (
    'name' => '首页购买帮助',
    'enabled' => false,
    'config' => 
    array (
      'image' => 'templates/html/ad/images/howdo.ad.gif',
      'linker' => 'http://www.tl0754.com/?view=41',
      'close_allow' => 'no',
      'auto_hide_time' => '5',
      'auto_hide_allow' => 'on',
      'reshow_delay_time' => '1',
    ),
  ),
  'howdom' => 
  array (
    'name' => '首页多图广告位（购买帮助下方）',
    'enabled' => true,
    'config' => 
    array (
      'list' => 
      array (
        '56dlpi' => 
        array (
          'image' => 'templates/html/ad/images/hm.56dlpi.gif',
          'text' => '贵广高铁1180',
          'link' => 'http://www.tl0754.com/?view=128',
          'target' => '_self',
          'order' => '11',
        ),
        '9n070k' => 
        array (
          'image' => 'templates/html/ad/images/hm.9n070k.gif',
          'text' => '河源巴伐利亚',
          'link' => 'http://www.tl0754.com/?view=131',
          'target' => '_self',
          'order' => '11',
        ),
        '5fns63' => 
        array (
          'image' => 'templates/html/ad/images/hm.5fns63.gif',
          'text' => '999',
          'link' => 'http://www.tl0754.com/?mod=article&code=view&id=10',
          'target' => '_self',
          'order' => '11',
        ),
        'wory6l' => 
        array (
          'image' => 'templates/html/ad/images/hm.wory6l.gif',
          'text' => '各国签证顺丰包邮',
          'link' => 'http://www.tl0754.com/?mod=catalog&code=qzbl',
          'target' => '_self',
          'order' => '10',
        ),
      ),
      'dsp' => 
      array (
        'time' => '40',
        'switchPath' => 'left',
        'showText' => 'false',
        'showButtons' => 'true',
      ),
    ),
  ),
  'howparallel' => 
  array (
    'name' => '首页对联广告位',
    'enabled' => false,
    'config' => 
    array (
      'list' => 
      array (
        'adl' => 
        array (
          'image' => 'templates/html/ad/images/howparallel.adl.jpg',
          'text' => '测试广告，请删除',
          'link' => 'javascript:;',
          'target' => '_blank',
        ),
        'adr' => 
        array (
          'image' => 'templates/html/ad/images/howparallel.adr.jpg',
          'text' => '测试广告，请删除',
          'link' => 'javascript:;',
          'target' => '_blank',
        ),
      ),
    ),
  ),
  'howthree' => 
  array (
    'name' => '下方三个广告图',
    'enabled' => true,
    'config' => 
    array (
      'list' => 
      array (
        'o91c2a' => 
        array (
          'image' => 'uploads/images/hm.o91c2a.gif',
          'text' => '3',
          'link' => 'http://www.tl0754.com/?mod=catalog&code=tsly',
          'target' => '_self',
          'order' => '3',
        ),
        '5i45fx' => 
        array (
          'image' => 'uploads/images/hm.5i45fx.gif',
          'text' => '2',
          'link' => 'http://www.tl0754.com/?mod=html&code=contact',
          'target' => '_self',
          'order' => '2',
        ),
        0 => 
        array (
          'image' => 'pic/t1.jpg',
          'text' => '1',
          'link' => 'http://www.tl0754.com/?mod=catalog&code=zbky',
          'target' => '_self',
          'order' => '1',
        ),
      ),
    ),
  ),
);
?>