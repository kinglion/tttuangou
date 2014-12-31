<?php

/**
 * 支付方式：银联支付
 * @copyright (C)2011 Cenwor Inc.
 * @author Lion <sangerenba@qq.com>
 * @package upacp
 * @name upacp.php
 * @version 1.0
 */

include_once 'upacp.sdk/common.php';
include_once 'upacp.sdk/SDKConfig.php';
include_once 'upacp.sdk/secureUtil.php';
// include_once 'upacp.sdk/encryptParams.php';
include_once 'upacp.sdk/log.class.php';

class upacpPaymentDriver extends PaymentDriver
{
	private $is_notify = null;
	
	public function CreateLink($payment, $parameter)
	{
		$parameter['name'] = preg_replace('/\&[a-z]{2,4}\;/i', '', $parameter['name']);
		$parameter['detail'] = str_replace(array('"',"'",'\\','&'), '', $parameter['detail']);
		$post = array(
			'version' => '5.0.0',						//版本号
			'encoding' => 'UTF-8',						//编码方式
			'certId' => getSignCertId(),				//证书ID
			'txnType' => '01',								//交易类型	
			'txnSubType' => '01',							//交易子类
			'bizType' => '000000',							//业务类型
			'frontUrl' =>  $parameter['product_url'],  				//前台通知地址
			'backUrl' => $parameter['notify_url'],				//后台通知地址	
			'signMethod' => '01',		//签名方法
			'channelType' => '07',					//渠道类型
			'accessType' => '0',							//接入类型
			'merId' => '103440548990006',					//商户代码
			'orderId' => date('YmdHis'),					//商户订单号
			'txnTime' => date('YmdHis'),				//订单发送时间
			'txnAmt' => $parameter['price'],								//交易金额
			'currencyCode' => '156',						//交易币种
			'defaultPayType' => '0001',						//默认支付方式	
		);
		$token = account('ulogin')->token();
		if ($token)
		{
			$post['token'] = $token;
		}
		$post['extend_param'] = 'isv^tt11';
		return $this->__BuildForm($payment, $post);
	}
	
	public function CreateConfirmLink($payment, $order)
	{
		if ($payment['config']['service'] == 'create_direct_pay_by_user' || $this->isDirectPay($payment, $order['orderid']))
		{
			return '?mod=buy&code=tradeconfirm&id='.$order['orderid'];
		}
		else
		{
			$paylog = logic('pay')->GetLog($order['orderid'], 0, '1', true);
			return 'http://lab.alipay.com/consume/record/buyerConfirmTrade.htm?tradeNo='.$paylog['trade_no'];
		}
	}
	
	public function CallbackVerify($payment)
	{
		if ($this->__Is_Nofity())
		{
						sleep(rand(1, 9));
						$trade_status = $this->__Notify_Verify($payment);
		}
		else
		{
			$trade_status = $this->__Return_Verify($payment);
		}
		return $this->__Trade_Status($trade_status);
	}
	
	public function GetTradeData()
	{
		$src = ($this->__Is_Nofity()) ? 'POST' : 'GET';
		$trade = array();
		$trade['sign'] = logic('safe')->Vars($src, 'out_trade_no', 'number');
		$trade['trade_no'] = logic('safe')->Vars($src, 'trade_no', 'number');
		$trade['price'] = logic('safe')->Vars($src, 'total_fee', 'float');
		$trade['money'] = $trade['price'];
		$trade['status'] = $this->__Trade_Status(logic('safe')->Vars($src, 'trade_status', 'txt'));
		return $trade;
	}
	
	public function StatusProcesser($status)
	{
		if (!$this->__Is_Nofity())
		{
			return false;
		}
		if ($status != 'VERIFY_FAILED')
		{
			echo 'success';
		}
		else
		{
			echo 'failed';
		}
		return true;
	}
	
	public function GoodSender($payment, $express, $sign, $type)
	{
		if ($payment['config']['service'] == 'create_direct_pay_by_user' || $this->isDirectPay($payment, $sign))
		{
						if ($type == 'ticket')
			{
				logic('callback')->Bridge($sign)->Processed($sign, 'TRADE_FINISHED');
			}
			else
			{
				logic('callback')->Bridge($sign)->Processed($sign, 'WAIT_BUYER_CONFIRM_GOODS');
			}
			return;
		}
				$post = array(
						'service'           => 'send_goods_confirm_by_platform',
			'partner'           => $payment['config']['partner'],
			'_input_charset'    => ini('settings.charset'),
						'trade_no'			=> $express['trade_no'],
			'logistics_name'    => $express['name'],
			'invoice_no'		=> $express['invoice'],
			'transport_type'    => 'EXPRESS',
		);
		$url = $this->__BuildURL($payment, $post);
		
				$this->__SrvGET($url);
				return;
	}
	
	private function __Trade_Status($trade_status)
	{
		return ($trade_status == 'TRADE_SUCCESS') ? 'TRADE_FINISHED' : $trade_status;
	}
	
	private function isDirectPay($payment, $sign)
	{
		$directPay = false;
		if ($payment['config']['service'] == 'trade_create_by_buyer')
		{
						$order = logic('order')->SrcOne($sign);
			$paylog = logic('pay')->GetLog($order['orderid'], $order['userid']);
			$directPay = (count($paylog) == 3 && $paylog[0]['status'] == 'TRADE_FINISHED');
		}
		return $directPay;
	}
	
	private function __Is_Nofity()
	{
		if (is_null($this->is_notify))
		{
			if (post('trade_status'))
			{
				$this->is_notify = true;
			}
			else
			{
				$this->is_notify = false;
			}
		}
		return $this->is_notify;
	}
	
	private function __BuildForm($payment, $parameter)
	{
		$log = new PhpLog ( SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL );
		$log->LogInfo ( "============处理前台请求开始===============" );
		// 检查字段是否需要加密
		// encrypt_params($params);
		// 签名
		sign($params);
		// 前台请求地址
		$front_uri = SDK_FRONT_TRANS_URL;
		$log->LogInfo ( "前台请求地址为>" . $front_uri );
		// 构造 自动提交的表单
		$html_form = create_html ( $params, $front_uri );

		$log->LogInfo ( "-------前台交易自动提交表单>--begin----" );
		$log->LogInfo ( $html_form );
		$log->LogInfo ( "-------前台交易自动提交表单>--end-------" );
		$log->LogInfo ( "============处理前台请求 结束===========" );
		return $html_form;
	}
	
	private function __BuildURL($payment, $parameter)
	{
		$sign = $this->__CreateSign($payment, $parameter);
		$parameter = $this->__arg_sort($parameter);
		$arg = $this->__create_linkstring_urlencode($parameter);
		$url = $this->Gateway_ssl.$arg.'&sign='.$sign.'&sign_type='.'MD5';
		return $url;
	}
	
	private function __Return_Verify($payment)
	{
		if($payment['config']['ssl'] == 'true')
		{
			$url = $this->Gateway_ssl
				.'service=notify_verify'
				.'&partner='.$payment['config']['partner']
				.'&notify_id='.get('notify_id', 'txt');
		}
		else
		{
			$url = $this->Gateway_com
				.'partner='.$payment['config']['partner']
				.'&notify_id='.get('notify_id', 'txt');
		}

		$result = $this->__Verify($url);

		$parameter = $this->__para_filter($_GET);
		$parameter = $this->__arg_sort($parameter);
		$sign  = $this->__CreateSign($payment, $parameter);

		if (preg_match('/true$/i', $result) && $sign == get('sign', 'txt'))
		{
			return get('trade_status', 'txt');
		}
		else
		{
			return 'VERIFY_FAILED';
		}
	}
	
	private function __Notify_Verify($payment)
	{
		if($payment['config']['ssl'] == 'true')
		{
			$url = $this->Gateway_ssl
				.'service=notify_verify'
				.'&partner='.$payment['config']['partner']
				.'&notify_id='.post('notify_id', 'txt');
		}
		else
		{
			$url = $this->Gateway_com
				.'partner='.$payment['config']['partner']
				.'&notify_id='.post('notify_id', 'txt');
		}

		$result = $this->__Verify($url);

		$parameter = $this->__para_filter($_POST);
		$parameter = $this->__arg_sort($parameter);
		$sign = $this->__CreateSign($payment, $parameter);

		if (preg_match('/true$/i', $result) && $sign == post('sign', 'txt'))
		{
			return post('trade_status', 'txt');
		}
		else
		{
			return 'VERIFY_FAILED';
		}
	}
	
	private function __Verify($url, $time_out = '60')
	{
		$urlArr     = parse_url($url);
		$errNo      = '';
		$errStr     = '';
		$transPorts = '';
		if($urlArr['scheme'] == 'https')
		{
			$transPorts = 'ssl://';
			$urlArr['port'] = '443';
		}
		else
		{
			$transPorts = 'tcp://';
			$urlArr['port'] = '80';
		}
		$fp = msockopen($transPorts . $urlArr['host'], $urlArr['port'], $errNo, $errStr, $time_out);
		if(!$fp)
		{
			zlog('error')->found('error.msockopen');
			die("ERROR: $errNo - $errStr<br />\n");
		}
		else
		{
			fputs($fp, "POST ".$urlArr["path"]." HTTP/1.1\r\n");
			fputs($fp, "Host: ".$urlArr["host"]."\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: ".strlen($urlArr["query"])."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $urlArr["query"] . "\r\n\r\n");
			while(!feof($fp))
			{
				$info[]=@fgets($fp, 1024);
			}
			fclose($fp);
			$info = implode(",",$info);
			return $info;
		}
	}
	
	private function __SrvGET($url, $time_out = '60')
	{
		$urlArr     = parse_url($url);
		$errNo      = '';
		$errStr     = '';
		$transPorts = '';
		if($urlArr['scheme'] == 'https')
		{
			$transPorts = 'ssl://';
			$urlArr['port'] = '443';
		}
		else
		{
			$transPorts = 'tcp://';
			$urlArr['port'] = '80';
		}
		$fp = msockopen($transPorts . $urlArr['host'], $urlArr['port'], $errNo, $errStr, $time_out);
		if(!$fp)
		{
			zlog('error')->found('error.msockopen');
			die("ERROR: $errNo - $errStr<br />\n");
		}
		else
		{
			fputs($fp, "GET ".$urlArr["path"]."?".$urlArr["query"]." HTTP/1.1\r\n");
			fputs($fp, "Host: ".$urlArr["host"]."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			while(!feof($fp))
			{
				$info[]=@fgets($fp, 1024);
			}
			fclose($fp);
			$info = implode(",",$info);
			return $info;
		}
	}
	
	private function __CreateSign($payment, $parameter)
	{
		$parameter = $this->__para_filter($parameter);
		$parameter = $this->__arg_sort($parameter);
		$string = $this->__create_linkstring($parameter);
		$string .= $payment['config']['key'];
		$string = md5($string);
		return $string;
	}
	private function __create_linkstring($array)
	{
		$arg  = '';
		foreach ($array as $key => $val)
		{
			$arg .= $key.'='.$val.'&';
		}
		$arg = substr($arg, 0, count($arg)-2);
		return $arg;
	}
	private function __create_linkstring_urlencode($array)
	{
		$arg  = '';
		foreach ($array as $key => $val)
		{
			if ($key != 'service' && $key != '_input_charset')
			{
				$arg .= $key.'='.urlencode($val).'&';
			}
			else
			{
				$arg .= $key.'='.$val.'&';
			}
		}
		$arg = substr($arg, 0, count($arg)-2);
		return $arg;
	}
	private function __arg_sort($array)
	{
		ksort($array);
		reset($array);
		return $array;
	}
	private function __para_filter($parameter)
	{
		$ignores = array(
			'sign' => 1,
			'sign_type' => 1,
			'mod' => 1,
			'pid' => 1
		);
		$para = array();
		foreach ($parameter as $key => $val)
		{
			if(isset($ignores[$key]) || $val == '')
			{
				continue;
			}
			else
			{
				$para[$key] = $val;
			}
		}
		return $para;
	}
}

?>