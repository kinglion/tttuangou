<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class_exists('Order') or require(dirname(__FILE__).'/Order.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');

class VoidRefundRequest extends TrxRequest
{
	
	/**
	 * 订单号
	 */
	private $iOrderNo = '';
	
	/**
	 * 交易金额（单位为 RMB￥0.01）
	 */
	private $iTrxAmount = 0;
	
	/**
	 * 构造VoidRefundRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * 取消退货请求信息是否合法
     * @throws TrxException: 取消退货请求不合法
	 */
	 protected function checkRequest() 
	 {
	 	if(strlen($this->iOrderNo)==0)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定订单号！');
	 	if(count(DataVerifier::stringToByteArray($this->iOrderNo))>Order::ORDER_NO_LEN)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'订单号不合法！');
	 	if($this->iTrxAmount <= 0)
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'交易金额不合法！');
	 	if(!DataVerifier::isValidAmount($this->iTrxAmount, 2))
	 		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'交易金额不合法！');
	 }

	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * 回传交易报文。
     * @return 交易报文信息
	 */
	 protected function getRequestMessage() 
	 {
	 	$tMessage='<TrxRequest>'.
	 	 	      '<TrxType>'.TrxType::TRX_TYPE_VOID_REFUND.'</TrxType>'.
	 	 	      '<OrderNo>'.$this->iOrderNo.'</OrderNo>'.
	 	 	      '<TrxAmount>'.$this->iTrxAmount.'</TrxAmount>'.
	 	 	      '</TrxRequest>';
	 	return $tMessage;
	 }

	/* (non-PHPdoc)
	 * @see TrxRequest::constructResponse()
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
	 * @return the $iTrxAmount
	 */
	public function getTrxAmount() {
		return $this->iTrxAmount;
	}

	/**
	 * @param string $iOrderNo
	 */
	public function setOrderNo($iOrderNo) {
		$this->iOrderNo = $iOrderNo;
	}

	/**
	 * @param number $iTrxAmount
	 */
	public function setTrxAmount($iTrxAmount) {
		$this->iTrxAmount = $iTrxAmount;
	}


}
?>