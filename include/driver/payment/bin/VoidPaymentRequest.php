<?php 
class_exists('Order') or require(dirname(__FILE__).'/Order.php');
/**
 * 商户端接口软件包业务处理类，负责商户提交取消支付交易的处理。
 */
class VoidPaymentRequest extends TrxRequest
{
	/** 订单号 */
	private $iOrderNo = '';
	
	/**
	 * 构造VoidPaymentRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * 取消支付请求信息是否合法
     * @throws TrxException: 取消支付请求不合法
	 */
	protected function checkRequest() 
	{
		if(strlen(trim($this->iOrderNo))==0)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定订单号！');
		if(count(DataVerifier::stringToByteArray($this->iOrderNo))> Order::ORDER_NO_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'订单号不合法！');
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * 回传交易报文。
     * @return 交易报文信息
	 */
	 protected function getRequestMessage() 
	 {
	 	$tMessage='<TrxRequest>'.
	 	 	      '<TrxType>'.TrxType::TRX_TYPE_VOID_PAY.'</TrxType>'.
	 	 	      '<OrderNo>'.$this->iOrderNo.'</OrderNo>'.
	 	 	      '</TrxRequest>';
	 	return $tMessage;
	 }

	/* (non-PHPdoc)
	 * @see TrxRequest::constructResponse()
	 * 回传交易响应对象。
     * @throws TrxException：组成交易报文的过程中发现内容不合法
     * @return 交易报文信息
	 */
	 protected function constructResponse($aResponseMessage) 
	 {
		$trxRes=new TrxResponse();
		$trxRes->initWithXML($aResponseMessage);
		return $trxRes;
	 }
	/**
	 * @return the $iOrderNo
	 */
	public function getOrderNo() {
		return $this->iOrderNo;
	}

	/**
	 * @param string $iOrderNo
	 */
	public function setOrderNo($iOrderNo) {
		$this->iOrderNo = $iOrderNo;
	}


	
}
?>