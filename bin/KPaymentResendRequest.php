<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class_exists('Order') or require(dirname(__FILE__).'/Order.php');
class_exists('Insure') or require(dirname(__FILE__).'/Insure.php');

class KPaymentResendRequest extends TrxRequest
{
	/** �������� */
	private $iOrder=null;
	
	/**
	 * ����KPaymentResendRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/**
	 * Class KPaymentRequest ���캯����ʹ��XML�ļ���ʼ��������ԡ�
	 * @param aXML ��ʼ�����XML�ļ���<br>XML�ļ�������<br>
	 */
	public function constructKPaymentRequest($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setOrder($xml->getValueNoNull('Order'));
	}
	
	/**
	 * �ش����ױ��ġ�
	 * @return ���ױ�����Ϣprotected
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
	 * ֧��������Ϣ�Ƿ�Ϸ�protected
	 * @throws TrxException: ֧�����󲻺Ϸ�
	 */
	 protected  function checkRequest()
	{
		$order=new Order();
		$order->__constructXMlDocument($this->iOrder);
		if($this->iOrder===null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨������Ϣ');
	}
	
	/**
	 * �ش�������Ӧ����
	 * @throws TrxException����ɽ��ױ��ĵĹ����з������ݲ��Ϸ�
	 * @return ���ױ�����Ϣ
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