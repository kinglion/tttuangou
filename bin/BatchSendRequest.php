<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
/**
 * 商户端接口软件包业务处理类，负责商户提交订单状态查询的处理。
 */
class BatchSendRequest extends TrxRequest
{
	/** 批量流水号 */
	private $iSerialNumber = '';
	
	/**
	 * 构造BatchSendRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * 订单查询请求信息是否合法
	 * @throws TrxException: 订单查询请求不合法
	 */protected function checkRequest() 
	 {
		// TODO Auto-generated method stub
		if(!$this->iSerialNumber)
		{
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定批量流水号！');
		}
		if(count(DataVerifier::stringToByteArray($this->iSerialNumber))>30)
		{
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'支付结果回传网址不合法！');
		}
	}
	
	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * 回传交易报文。
	 * @return 交易报文信息
	 */protected function getRequestMessage() 
	 {
		// TODO Auto-generated method stub
		$tMessage='<TrxRequest>'.
				  '<TrxType>'.RefundBatchSendReq.'</TrxType>'.
				  '<SerialNumber>'.$this->iSerialNumber.'</SerialNumber>'.
				  '</TrxRequest>';
		return $tMessage;
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::constructResponse()
	 */protected function constructResponse($aResponseMessage) 
	 {
		$trxRes=new TrxResponse();
		$trxRes->initWithXML($aResponseMessage);
		return $trxRes;
	 }
	/**
	 * @return the $iSerialNumber
	 */
	public function getSerialNumber() {
		return $this->iSerialNumber;
	}

	/**
	 * @param string $iSerialNumber
	 */
	public function setSerialNumber($iSerialNumber) {
		$this->iSerialNumber = $iSerialNumber;
	}


	
}
?>