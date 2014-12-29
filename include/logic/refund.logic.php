<?php

/**
 * 逻辑区：退款相关
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package logic
 * @name refund.logic.php
 * @version 1.0
 */
 
class RefundLogic
{
	public function GetList($process = 0, $uid = 0, $orderid = 0)
	{
										if ($process > 0) {
			$sql_where .= ' process = '.$process;
		}else{
			$sql_where = '1';
		}
						
		$sql = 'SELECT * FROM '.table('refund').' WHERE ' .$sql_where. ' ORDER by `dateline` desc';
		$sql = page_moyo($sql);
		$result = dbc(DBCMax)->query($sql)->done();
		return $result;
	}

	public function GetOne( $orderid = 0)
	{
		return dbc(DBCMax)->select('refund')->where(array('orderid'=>$orderid))->limit(1)->done();
	}
	
	public function save($orderid, $money, $reason)
	{
				if (dbc(DBCMax)->select('refund')->where(array('uid'=>MEMBER_ID,'orderid'=>$orderid))->limit(1)->done()) {
			return 1;
		}
				$order = logic('order')->GetOne($orderid, MEMBER_ID);
		if (empty($order) || $order['pay'] == 0) {
			return 2;
		}

						if ($order['userid'] != MEMBER_ID) {
			return 4;
		}

		if($order['product']['type'] == 'ticket'){
			$coupons = logic('coupon')->SrcList(MEMBER_ID, $order_id);
			if($order['productnum'] != count($coupons)){
				$order['totalprice'] = count($coupons)*$order['productprice'];
			}
		}
		$money = max(0,min($money,$order['totalprice']));
		
		return dbc(DBCMax)->insert('refund')->data(array('uid'=>MEMBER_ID,'orderid'=>$orderid,'demand_money'=>$money,'demand_reason'=>$reason,'dateline'=>time(),'process'=>1))->done();
	}
	
	
	public function agree($orderid, $uid, $money, $reason='')
	{
		return dbc(DBCMax)->update('refund')
		->data(array('process'=>2,'op_uid'=>MEMBER_ID,'op_money'=>$money,'op_reason'=>$reason,'op_dateline'=>time()))
		->where(array('uid'=>$uid,'orderid'=>$orderid))
		->done();
	}

	
	public function refuse($orderid, $uid, $reason)
	{
		return dbc(DBCMax)->update('refund')
		->data(array('process'=>3,'op_uid'=>MEMBER_ID,'op_money'=>0,'op_reason'=>$reason,'op_dateline'=>time()))
		->where(array('uid'=>$uid,'orderid'=>$orderid))
		->done();
	}
}
?>