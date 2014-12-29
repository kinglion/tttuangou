<?php 
class CardVerifyRequest extends TrxRequest
{
	/** �̻�֪ͨURL*/
	private $iResultNotifyURL = null;
	
	/** ֤������*/
	private $iCertificateNo = '';
	
	/** ֤������*/
	private $iCertificateType = '';
	
	
	/**
	 * ����CardVerifyRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	
	/**
	 * ��ʼ��CardVerifyRequest��������
	 */
	public function constructCardVerifyRequest($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setResultNotifyURL($xml->getValueNoNull('ResultNotifyURL'));
		$this->setCertificateNo($xml->getValueNoNull('CertificateNo'));
		$this->setCertificateType($xml->getValueNoNull('CertificateType'));
	}
	/* (non-PHPdoc)
	 * @see TrxRequest::checkRequest()
	 * ��Ϣ�Ƿ�Ϸ�
     * @throws TrxException: ���󲻺Ϸ�
	 */
	protected function checkRequest() 
	{
		if(strlen(trim($this->iCertificateNo)) ==0 || strlen((trim($this->iCertificateType))) == 0)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101);
		if(strlen(trim($this->iResultNotifyURL)) == 0)
			throw  new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101);
	}

	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 */
	 protected function getRequestMessage() 
	 {
	 	$tMessage='<TrxRequest>'.
	 	 		  '<TrxType>'.TrxType::TRX_TYPE_CARD_VERIFY_REQ.'</TrxType>'.
	 	 		  '<ResultNotifyURL>'.$this->iResultNotifyURL.'</ResultNotifyURL>'.
	 	 		  '<CertificateType>'.$this->iCertificateType.'</CertificateType>'.
	 	 		  '<CertificateNo>'.$this->iCertificateNo.'</CertificateNo>'.
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
	 * @return the $iResultNotifyURL
	 */
	public function getResultNotifyURL() {
		return $this->iResultNotifyURL;
	}

	/**
	 * @param NULL $iResultNotifyURL
	 */
	public function setResultNotifyURL($iResultNotifyURL) {
		$this->iResultNotifyURL = $iResultNotifyURL;
	}

	/**
	 * @return the $iCertificateNo
	 */
	public function getCertificateNo() {
		return $this->iCertificateNo;
	}

	/**
	 * @param string $iCertificateNo
	 */
	public function setCertificateNo($iCertificateNo) {
		$this->iCertificateNo = $iCertificateNo;
	}

	/**
	 * @return the $iCertificateType
	 */
	public function getCertificateType() {
		return $this->iCertificateType;
	}

	/**
	 * @param string $iCertificateType
	 */
	public function setCertificateType($iCertificateType) {
		$this->iCertificateType = $iCertificateType;
	}


	
}
?>