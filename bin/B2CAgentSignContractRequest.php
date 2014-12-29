<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');

class B2CAgentSignContractRequest extends TrxRequest
{
	/** ֪ͨ�̻����ͣ�URL֪ͨ */
	const NOTIFY_TYPE_URL    =   '0';
	
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
	
	/** ������ */
	private $iCardType = '';
	
	/** �������� */
	private $iRequestDate = '';
	
	/** ����ʱ�� */
	private $iRequestTime = '';
	
	/** ������ */
	private $iOrderNo = '';
	
	/** ��������޶� */
	//private $iALimitAmt = '';
	
	/** һ������޶� */
	//private $iADayLimitAmt = '';
	
	/** ����ʱ�� */
	private $iInvaidDate = '2099/01/01';
	
	/** ֪ͨ��ʽ*/
	private $iNotifyType = '';
	
	/**
	 * ����B2CAgentSignContractRequest����
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/**
	 * ��ʼ��B2CAgentSignContractRequest����
	 */
	public function constructB2CAgentSignContractRequest($aXMLDocument) 
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setCertificateType($xml->getValueNoNull('CertificateType'));
		$this->setCertificateNo($xml->getValueNoNull('CertificateNo'));
		$this->setCardType($xml->getValueNoNull('CardType'));
		$this->setResultNotifyURL($xml->getValueNoNull('ResultNotifyURL'));
		$this->setNotifyType($xml->getValueNoNull('NotifyType'));
		//irequestdate orderdate??? irequesttime ordertime
		$this->setRequestDate($xml->getValueNoNull('OrderDate'));
		$this->setRequestTime($xml->getValueNoNull('OrderTime'));
		$this->setOrderNo($xml->getValueNoNull('OrderNo'));
		$this->setInvaidDate($xml->getValueNoNull('InvaidDate'));
		
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
			 '<CardType>'.$this->iCardType.'</CardType>'.
			 '<ResultNotifyURL>'.$this->iResultNotifyURL.'</ResultNotifyURL>'.
			 '<NotifyType>'.$this->iNotifyType.'</NotifyType>'.
			 '<OrderNo>'.$this->iOrderNo.'</OrderNo>'.
			 '<OrderDate>'.$this->iRequestDate.'</OrderDate>'.
			 '<OrderTime>'.$this->iRequestTime.'</OrderTime>'.
			 '<InvaidDate>'.$this->iInvaidDate.'</InvaidDate>'.
			 '<IsSign>'.'Sign'.'</IsSign>'.
			 '</TrxRequest>';
		return $str;
		/*	
	     .append("<ALimitAmt>").append(iALimitAmt).append("</ALimitAmt>")
		 .append("<ADayLimitAmt>").append(iADayLimitAmt).append("</ADayLimitAmt>")
		 */
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
    	if(!DataVerifier::isValidString($this->iInvaidDate))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1100, TrxException::TRX_EXC_MSG_1101,'����ʱ�䲻�Ϸ�');
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
    	if($this->iCardType != '1' && $this->iCardType != '2' && $this->iCardType != 'A')
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'ũ�п����Ͳ��Ϸ�');
    	// 3.����������URL�Ϸ���
    	if(!DataVerifier::isValidURL($this->iResultNotifyURL))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'����ش���ַ���Ϸ�');
    	if(count(DataVerifier::stringToByteArray($this->iResultNotifyURL)) > self::RESULT_NOTIFY_URL_LEN)
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'��֤����ش���ַ���Ϸ�');
    	//4.У�鶨����󳤶� ???????????
    	//5.У�鶨�����ںϷ���
    	if(!DataVerifier::isValidDate($this->iRequestDate))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�������ڸ�ʽ����ȷ');
    	//6.У�鶨�����ںϷ���
    	if(!DataVerifier::isValidTime($this->iRequestTime))
    		throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'����ʱ���ʽ����ȷ');
    	
    	/*
		//1.��֤�Ƿ�Ϊ��	
		//4.У�鶨����󳤶� ?????????????
		//		if (!DataVerifier.isValidString(iOrderNo,ILength.ORDERID_LEN))
			//			throw new TrxException(TrxException.TRX_EXC_CODE_1101,TrxException.TRX_EXC_MSG_1101,"�����ų��ȳ������ƻ�Ϊ��");
		/*		
		*/
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
	 * @return the $iCardType
	 */
	public function getCardType() {
		return $this->iCardType;
	}

	/**
	 * @param string $iCardType
	 */
	public function setCardType($iCardType) {
		$this->iCardType = $iCardType;
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
	 * @return the $iInvaidDate
	 */
	public function getInvaidDate() {
		return $this->iInvaidDate;
	}

	/**
	 * @param string $iInvaidDate
	 */
	public function setInvaidDate($iInvaidDate) {
		$this->iInvaidDate = $iInvaidDate;
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
}
/*
$asc=new B2CAgentSignContractRequest();
*/
?>