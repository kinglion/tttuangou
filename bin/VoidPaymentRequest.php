<?php 
class_exists('Order') or require(dirname(__FILE__).'/Order.php');
/**
 * �̻��˽ӿ������ҵ�����࣬�����̻��ύȡ��֧�����׵Ĵ���
 */
class VoidPaymentRequest extends TrxRequest
{
	/** ������ */
	private $iOrderNo = '';
	
	/**
	 * ����VoidPaymentRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * ȡ��֧��������Ϣ�Ƿ�Ϸ�
     * @throws TrxException: ȡ��֧�����󲻺Ϸ�
	 */
	protected function checkRequest() 
	{
		if(strlen(trim($this->iOrderNo))==0)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨�����ţ�');
		if(count(DataVerifier::stringToByteArray($this->iOrderNo))> Order::ORDER_NO_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�����Ų��Ϸ���');
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * �ش����ױ��ġ�
     * @return ���ױ�����Ϣ
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