<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class B2CAgentUnsignContractRequest extends TrxRequest
{
	/** ֪ͨ�̻����ͣ�URL֪ͨ */
	const NOTIFY_TYPE_URL    =  '0';
	
	/** ֪ͨ�̻����ͣ�������֪ͨ */
	const NOTIFY_TYPE_SERVER =   '1';
	
	/** ֧������ش���ַ��󳤶� */
	const RESULT_NOTIFY_URL_LEN = 200;
	
	/** �̻�֪ͨURL */
	private $iResultNotifyURL = '';
	
	/** ֤������ */
	private $iCertificateNo = '';
	
	/** ֤������ */
	private $iCertificateType = '';
	
	/** �������� */
	private $iRequestDate = '';
	
	/** ����ʱ�� */
	private $iRequestTime = '';
	
	/** ������ */
	private $iOrderNo = '';
	
	/** ֪ͨ��ʽ*/
	private $iNotifyType = '';
	
	/** ǩԼЭ���*/
	private $iAgentSignNo = '';
	
	/**
	 * ����B2CAgentUnsignContractRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/**
	 * ��ʼ��B2CAgentUnsignContractRequest����
	 */
	public function constructB2CAgentUnsignContractRequest($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setCertificateType($xml->getValueNoNull('CertificateType'));
		$this->setCertificateNo($xml->getValueNoNull('CertificateNo'));
		$this->setResultNotifyURL($xml->getValueNoNull('ResultNotifyURL'));
		$this->setNotifyType($xml->getValueNoNull('NotifyType'));
		$this->setRequestDate($xml->getValueNoNull('OrderDate'));
		$this->setRequestTime($xml->getValueNoNull('OrderTime'));
		$this->setOrderNo($xml->getValueNoNull('OrderNo'));
		$this->setAgentSignNo($xml->getValueNoNull('AgentSignNo'));
	
	}
	
	/* (non-PHPdoc)
	 * @see TrxRequest::getRequestMessage()
	 */
	protected function getRequestMessage() 
	{
		// TODO Auto-generated method stub
		   $str='<TrxRequest>'.
				'<TrxType>'.TrxType::TRX_TYPE_B2C_AgentSignContract_REQ.'</TrxType>'.
				'<CertificateType>'.$this->iCertificateType.'</CertificateType>'.
				'<CertificateNo>'.$this->iCertificateNo.'</CertificateNo>'.
				'<ResultNotifyURL>'.$this->iResultNotifyURL.'</ResultNotifyURL>'.
				'<NotifyType>'.$this->iNotifyType.'</NotifyType>'.
				'<OrderNo>'.$this->iOrderNo.'</OrderNo>'.
				'<AgentSignNo>'.$this->iAgentSignNo.'</AgentSignNo>'.
				'<OrderDate>'.$this->iRequestDate.'</OrderDate>'.
				'<OrderTime>'.$this->iRequestTime.'</OrderTime>'.
				'<IsSign>'.'Unsign'.'</IsSign>'.
				'</TrxRequest>';
		   return $str;
	}
	protected function checkRequest()
	{
		//1.��֤�Ƿ�Ϊ��
		if(!DataVerifier::isValidString($this->iResultNotifyURL))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'��֤����ش���ַ���Ϸ�');
		if(!DataVerifier::isValidString($this->iOrderNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�����Ų��Ϸ�');
		if(!DataVerifier::isValidString($this->iRequestDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�������ڲ��Ϸ�');
		if(!DataVerifier::isValidString($this->iRequestTime))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'����ʱ�䲻�Ϸ�');
		if(!DataVerifier::isValidString($this->iAgentSignNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'ǩԼЭ��Ų��Ϸ�');
		if(!DataVerifier::isValidString($this->iCertificateType))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�ͻ�֤�����Ͳ��Ϸ�');
		if(!DataVerifier::isValidString($this->iCertificateNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'�ͻ�֤�����벻�Ϸ�');
		if(!DataVerifier::isValidString($this->iNotifyType))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'֪ͨ���Ͳ��Ϸ�');
		if($this->iNotifyType != self::NOTIFY_TYPE_URL && $this->iNotifyType != self::NOTIFY_TYPE_SERVER)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֪ͨ����δ���壡');
		//2.����֤�����͡�֤������Ϸ���
		if(!DataVerifier::isValidCertificate($this->iCertificateType, $this->iCertificateNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֤�����͡�֤�����벻�Ϸ�');
		if($this->iCertificateType != 'I')
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'֤�����ͱ���Ϊ�������֤');
		// 3.����������URL�Ϸ���
		if(!DataVerifier::isValidURL($this->iResultNotifyURL))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'����ش���ַ���Ϸ�');
		if(count(DataVerifier::stringToByteArray($this->iResultNotifyURL)) > self::RESULT_NOTIFY_URL_LEN)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'��֤����ش���ַ���Ϸ�');
		//4.У�鶨����󳤶�
		//5.У�鶨�����ںϷ���
		if(!DataVerifier::isValidDate($this->iRequestDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�������ڸ�ʽ����ȷ');
		//6.У�鶨�����ںϷ���
		if(!DataVerifier::isValidTime($this->iRequestTime))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'����ʱ���ʽ����ȷ');		 
	}
	
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
	 * @param string $iResultNotifyURL
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

	/**
	 * @return the $iRequestDate
	 */
	public function getRequestDate() {
		return $this->iRequestDate;
	}

	/**
	 * @param string $iRequestDate
	 */
	public function setRequestDate($iRequestDate) {
		$this->iRequestDate = $iRequestDate;
	}

	/**
	 * @return the $iRequestTime
	 */
	public function getRequestTime() {
		return $this->iRequestTime;
	}

	/**
	 * @param string $iRequestTime
	 */
	public function setRequestTime($iRequestTime) {
		$this->iRequestTime = $iRequestTime;
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

	/**
	 * @return the $iNotifyType
	 */
	public function getNotifyType() {
		return $this->iNotifyType;
	}

	/**
	 * @param string $iNotifyType
	 */
	public function setNotifyType($iNotifyType) {
		$this->iNotifyType = $iNotifyType;
	}

	/**
	 * @return the $iAgentSignNo
	 */
	public function getAgentSignNo() {
		return $this->iAgentSignNo;
	}

	/**
	 * @param string $iAgentSignNo
	 */
	public function setAgentSignNo($iAgentSignNo) {
		$this->iAgentSignNo = $iAgentSignNo;
	}


	
}
?>