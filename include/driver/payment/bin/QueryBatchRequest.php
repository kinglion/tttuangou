<?php 

/**
 * 商户端接口软件包业务处理类，负责商户提交订单状态查询的处理。
 */
class QueryBatchRequest extends TrxRequest
{
	/** 批量流水号 */
	private $iSerialNumber = '';
	
	/**
	 * 构造QueryOrderRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * 订单查询请求信息是否合法
	 * @throws TrxException: 订单查询请求不合法
	 */
	protected function checkRequest() 
	{
		if($this->iSerialNumber == null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定批量流水号！');
		if(strlen(DataVerifier::stringToByteArray($this->iSerialNumber)) > 30)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'支付结果回传网址不合法！');
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * 回传交易报文。
	 * @return 交易报文信息
	 */
	 protected function getRequestMessage() 
	 {
	 	$tMessage='<TrxRequest>'.
	 			  '<TrxType>'.QueryBatchReq.'</TrxType>'.
	 			  '<SerialNumber>'.$this->iSerialNumber.'</SerialNumber>'.
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
	 	return new TrxResponse($aResponseMessage);
	 }

	
}
?>