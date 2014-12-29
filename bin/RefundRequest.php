<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class_exists('Order') or require(dirname(__FILE__).'/Order.php');

class RefundRequest extends TrxRequest
{

	/** 订单号 */
	private $iOrderNo = '';
	
	/** 退款订单号 */
	private $iNewOrderNo = '';
	
	/** 交易金额 */
	private $iTrxAmount = 0;
	
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
		$this->iOrderNo = trim($iOrderNo);
	}

	/**
	 * @return the $iNewOrderNo
	 */
	public function getNewOrderNo() {
		return $this->iNewOrderNo;
	}

	/**
	 * @param string $iNewOrderNo
	 */
	public function setNewOrderNo($iNewOrderNo) {
		$this->iNewOrderNo = trim($iNewOrderNo);
	}

	/**
	 * @return the $iTrxAmount
	 */
	public function getTrxAmount() {
		return $this->iTrxAmount;
	}

	/**
	 * @param number $iTrxAmount
	 */
	public function setTrxAmount($iTrxAmount) {
		$this->iTrxAmount = $iTrxAmount;
	}

	/**
	 * 构造RefundRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/**
	 * 回传交易报文。
	 * @return 交易报文信息 
	 */
	protected function getRequestMessage()
	{
		$str='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_REFUND.'</TrxType>'.
			 '<OrderNo>'.$this->iOrderNo.'</OrderNo>'.
			 '<NewOrderNo>'.$this->iNewOrderNo.'</NewOrderNo>'.
			 '<TrxAmount>'.$this->iTrxAmount.'</TrxAmount>'.
			 '</TrxRequest>';
		return $str;
	}
	/**
	 * 退货请求信息是否合法
	 * @throws TrxException: 退货请求不合法 
	 */
	protected function checkRequest()
	{
		if(strlen(trim($this->iOrderNo))==0)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定订单号！');
		//getBytes
		if(strlen(trim($this->iOrderNo))>Order::ORDER_NO_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'订单号不合法！');
		if($this->iTrxAmount<=0)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'交易金额不合法！');
		if(!DataVerifier::isValidAmount($this->iTrxAmount, 2))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'交易金额不合法！');		
	}
	/**
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
}
/*
$rr=new RefundRequest();
$rr->setOrderNo('ON200306300001');
$rr->setNewOrderNo('ON200306300002');
$rr->setTrxAmount(23.56);
echo $rr->getRequestMessage()."**<br/>";
if(!$rr->checkRequest())
echo 'ok';
echo $rr->getNewOrderNo();
echo $rr->getOrderNo();
echo $rr->getTrxAmount();
*/
?>