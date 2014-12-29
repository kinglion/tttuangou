<?php 
class CBPNotifyRequest extends TrxRequest
{
	/** �������˵��� */
	private $iCBPOrderNo = '';
	
	/** ֧��״̬    1:�ɹ���2:ʧ�ܡ�3:����  */
	private $iStatus = '';
	
	/** ֧������ */
	private $iPayDate = '';
	
	/** ֧�����б��  */
	private $iPayBankNo = '';
	
	/** ����֧��ƽ̨������ַ */
	private  $iTrustPayCBPTrxURL = '';
	
	/** �̻�ͨ��������ύ���ϵ�����֧��ƽ̨������ַ */
	private $iTrustPayIECBPTrxURL = '';
	
	/**
	 * ����CBPNotifyRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/**
	 * ��ʼ CBPNotifyRequest ��������ԡ�ʹ��XML�ַ�����
	 */
	public function construstCBPNotifyRequest($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setCBPOrderNo($xml->getValueNoNull('CBPOrderNo'));
		$this->setStatus($xml->getValueNoNull('Status'));
		$this->setPayDate($xml->getValueNoNull('PayDate'));
		$this->setPayBankNo($xml->getValueNoNull('PayBankNo'));
	}
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * ������Ϣ�Ƿ�Ϸ�
     * @throws TrxException: ���󲻺Ϸ�
	 */
	protected function checkRequest() 
	{
		if(!$this->iCBPOrderNo)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'δ�趨�������˵��ţ�');
		if($this->iStatus!='1'&&$this->iStatus!='2'&&$this->iStatus!='3'&&$this->iStatus==null)
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1100,'֧��״̬���Ϸ���');
		if(!DataVerifier::isValidDateTime($this->iPayDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֧�����ڸ�ʽ����ȷ');
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 * �ش����ױ��ġ�
     * @return ���ױ�����Ϣ
	 */
	 protected function getRequestMessage() 
	 {
	 	$tMessage='<CBPOrderNo>'.$this->iCBPOrderNo.'</CBPOrderNo>'.
	 	 		  '<Status>'.$this->iStatus.'</Status>'.
	 	 		  '<PayDate>'.$this->iPayDate.'</PayDate>'.
	 	 		  '<PayBankNo>'.$this->iPayBankNo.'</PayBankNo>';
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
	 	$tTrxResponse=new TrxResponse();
	 	$xmlRes=new XMLDocument($aResponseMessage);
	 	$value=$xmlRes->getValueNoNull('NotifyStatus');
	 	if($value)
	 		$tTrxResponse=$tTrxResponse->initWithCodeMsg(TrxResponse::RC_SUCCESS, 'ũ�н���֪ͨ�ɹ�');
	 	elseif (!$value)
	 		$tTrxResponse=$tTrxResponse->initWithCodeMsg('0011', 'ũ�н���֪ͨʧ��');
		return $tTrxResponse;
	 }
	/**
	 * @return the $iCBPOrderNo
	 */
	public function getCBPOrderNo() {
		return $this->iCBPOrderNo;
	}

	/**
	 * @param string $iCBPOrderNo
	 */
	public function setCBPOrderNo($iCBPOrderNo) {
		$this->iCBPOrderNo = $iCBPOrderNo;
	}

	/**
	 * @return the $iStatus
	 */
	public function getStatus() {
		return $this->iStatus;
	}

	/**
	 * @param string $iStatus
	 */
	public function setStatus($iStatus) {
		$this->iStatus = $iStatus;
	}

	/**
	 * @return the $iPayDate
	 */
	public function getPayDate() {
		return $this->iPayDate;
	}

	/**
	 * @param string $iPayDate
	 */
	public function setPayDate($iPayDate) {
		$this->iPayDate = $iPayDate;
	}

	/**
	 * @return the $iPayBankNo
	 */
	public function getPayBankNo() {
		return $this->iPayBankNo;
	}

	/**
	 * @param string $iPayBankNo
	 */
	public function setPayBankNo($iPayBankNo) {
		$this->iPayBankNo = $iPayBankNo;
	}

	/**
	 * @return the $iTrustPayCBPTrxURL
	 */
	public function getTrustPayCBPTrxURL() {
		return $this->iTrustPayCBPTrxURL;
	}

	/**
	 * @param string $iTrustPayCBPTrxURL
	 */
	public function setTrustPayCBPTrxURL($iTrustPayCBPTrxURL) {
		$this->iTrustPayCBPTrxURL = $iTrustPayCBPTrxURL;
	}

	/**
	 * @return the $iTrustPayIECBPTrxURL
	 */
	public function getTrustPayIECBPTrxURL() {
		return $this->iTrustPayIECBPTrxURL;
	}

	/**
	 * @param string $iTrustPayIECBPTrxURL
	 */
	public function setTrustPayIECBPTrxURL($iTrustPayIECBPTrxURL) {
		$this->iTrustPayIECBPTrxURL = $iTrustPayIECBPTrxURL;
	}


	
}
?>