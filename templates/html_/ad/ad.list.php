<?php

/**
 * 广告位列表
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package ad
 * @name ad.list.php
 * @version 1.0
 */
 
return array(
	'howdo' => array (
		'name' => '首页购买帮助',
		'enabled' => false,
		'config' => array (
			'image' => 'uploads/images/howdo.ad.gif',
			'linker' => 'javascript:;',
			'close_allow' => 'no',
			'auto_hide_time' => '5',
			'auto_hide_allow' => 'on',
			'reshow_delay_time' => '1'
		)
	),
	'howdom' => array(
		'name' => '首页多图广告位（购买帮助下方）',
		'enabled' => false,
		'config' => array(
			'list' => array (
				'ad' => array (
					'image' => 'uploads/images/howdo.ad.gif',
					'text' => '测试广告，请删除',
					'link' => '',
					'target' => '_self',
				),
			),
			'dsp' => array (
				'time' => '3',
				'switchPath' => 'left',
				'showText' => 'false',
				'showButtons' => 'true',
			),
		)
	),
	'howparallel' => array(
		'name' => '首页对联广告位',
		'enabled' => false,
		'config' => array(
			'list' => array (
				'adl' => array (
					'image' => 'uploads/images/howparallel.adl.jpg',
					'text' => '测试广告，请删除',
					'link' => 'javascript:;',
					'target' => '_blank',
				),
				'adr' => array (
					'image' => 'uploads/images/howparallel.adr.jpg',
					'text' => '测试广告，请删除',
					'link' => 'javascript:;',
					'target' => '_blank',
				),
			)
		)
	),
	'howthree' => array(
		'name' => '下方三个广告图',
		'enabled' => false,
		'config' => array(
			'list' => array (
				'0' => array (
					'image' => 'pic/t1.jpg',
					'text' => '测试广告，请删除',
					'link' => 'javascript:;',
					'target' => '_blank',
				),
				'1' => array (
					'image' => 'pic/t1.jpg',
					'text' => '测试广告，请删除',
					'link' => 'javascript:;',
					'target' => '_blank',
				),
				'2' => array (
					'image' => 'pic/t1.jpg',
					'text' => '测试广告，请删除',
					'link' => 'javascript:;',
					'target' => '_blank',
				),
			)
		)
	),
);

?>