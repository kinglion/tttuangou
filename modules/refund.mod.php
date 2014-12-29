<?php

/**
 * 模块：退款相关操作
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package module
 * @name refund.mod.php
 * @version 1.0
 */

class ModuleObject extends MasterObject
{
    function ModuleObject( $config )
    {
        $this->MasterObject($config);
        if (MEMBER_ID < 1)
        {
            $this->Messager(__('请先登录！'), '?mod=account&code=login');
        }
        $runCode = Load::moduleCode($this);
        $this->$runCode();
    }
    
    function Main()
    {
        $order_id= get('oid','number');
        $info    = logic('order')->GetOne($order_id, MEMBER_ID);
		$info['paymoney'] = $info['totalprice'];
        if ($order_id < 1 || empty($info)) {
            $this->Messager('订单信息错误!');
        }
		if($info['product']['type'] == 'ticket'){
			$coupons = logic('coupon')->SrcList(MEMBER_ID, $order_id);
			if (count($coupons) === 0) {
				$this->Messager('该订单所有' . TUANGOU_STR . '券都已消费，不能申请退款。如有疑问，请联系客服电话：'.ini('data.cservice.phone'), 'index.php?mod=me&code=order', 10);
			}
			if($info['productnum'] != count($coupons)){
				$info['tmsg'] = array(
					'money' => $info['paymoney'],
					'tnum' => $info['productnum'],
					'num' => $info['productnum']-count($coupons)
				);
				$info['paymoney'] = number_format(count($coupons)*$info['productprice'],2);
			}
		}
        include handler('template')->file('@refund_apply');
    }
    
    
    function refundsave()
    {
        $order_id= post('orderid', 'number');
        $money   = post('money', 'float');
        $reason  = post('reason', 'string');
        
        if ($money == 0) {
            $this->Messager('请填写退款金额!');
        }
		if (trim($reason) == '') {
            $this->Messager('请填写退款理由!');
        }
        if ($order_id == 0) {
            $this->Messager('错误的参数!');
        }
        $rs = logic('refund')->save($order_id, $money, $reason);
        if ($rs == 1) {
            $this->Messager('请勿重复提交退款申请!', '?mod=me&code=order');
        }
        if ($rs == 2 || $rs == 4) {
            $this->Messager('订单信息错误!', '?mod=me&code=order');
        }
        $this->Messager('退款申请提交成功!', '?mod=me&code=order');
    }
}

?>