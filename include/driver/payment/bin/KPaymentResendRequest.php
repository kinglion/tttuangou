<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class_exists('Order') or require(dirname(__FILE__).'/Order.php');
class_exists('Insure') or require(dirname(__FILE__).'/Insure.php');

class KPaymentResendRequest extends TrxRequest
{
	/** 订单对象 */
	private $iOrder=null;
	
	/**
	 * 构造KPaymentResendRequest对象
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/**
	 * Class KPaymentRequest 构造函数。使用XML文件初始对象的属性。
	 * @param aXML 初始对象的XML文件。<br>XML文件范例：<br>
	 */
	public function constructKPaymentRequest($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setOrder($xml->getValueNoNull('Order'));
	}
	
	/**
	 * 回传交易报文。
	 * @return 交易报文信息protected
	 */
	protected function getRequestMessage()
	{
		$ord=new Order();
		$ord->__constructXMlDocument($this->getOrder());
		$str='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_KPAYRESEND_REQ.'</TrxType>'.
			 $ord->getXMLDocument(1).
			 '</TrxRequest>';
		return $str;		 
	}
	
	/**
	 * 支付请求信息是否合法protected
	 * @throws TrxException: 支付请求不合法
	 */
	 protected  function checkRequest()
	{
		$order=new Order();
		$order->__constructXMlDocument($this->iOrder);
		if($this->iOrder===null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'未设定订单信息');
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
	
	/**
	 * @return the $iOrder
	 */
	public function getOrder() {
		return $this->iOrder;
	}

	/**
	 * @param NULL $iOrder
	 */
	public function setOrder($aOrder) {
		$this->iOrder = $aOrder;
	}
}
?>